<?php
require '../../include/db_conn.php';
page_protect();


if (isset($_SESSION['error_message'])) {
    echo "<script type='text/javascript'>
            alert('{$_SESSION['error_message']}');
          </script>";
    // Unset the error message after displaying it
    unset($_SESSION['error_message']);
}

$id = $_GET['id'];

// First, get the plan dates and plan ID from sports_timetable and plan tables
$datesSql = "SELECT p.planid, p.startDate, p.endDate 
             FROM sports_timetable st 
             JOIN plan p ON st.planid = p.planid 
             WHERE st.tid = '$id'";
$datesResult = mysqli_query($con, $datesSql);
$dates = mysqli_fetch_assoc($datesResult);

if ($dates) {
    $startDate = new DateTime($dates['startDate']);
    $endDate = new DateTime($dates['endDate']);
    $planId = $dates['planid'];
    
    // Calculate the date difference
    $interval = $startDate->diff($endDate);
    $totalDays = $interval->days + 1;
    
    // Store scroll position before processing form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['scroll_position'] = $_POST['scroll_position'] ?? 0;

        if (isset($_POST['update_dates'])) {
            $newStartDate = $_POST['startDate'] ?? $dates['startDate'];
            $newEndDate = $_POST['endDate'] ?? $dates['endDate'];
            $tid = mysqli_real_escape_string($con, $_GET['id']); // Get and sanitize tid instead of id

            // Calculate the total number of days between startDate and new endDate
            $numDays = (int)((strtotime($newEndDate) - strtotime($newStartDate)) / (60 * 60 * 24)) + 1;

            // Get the current number of days in timetable_days
            $currentDaysSql = "SELECT day_id, day_number, activities FROM timetable_days WHERE tid = '$id' ORDER BY day_number";
            $currentDaysResult = mysqli_query($con, $currentDaysSql);
            $currentDays = mysqli_num_rows($currentDaysResult);

            // Check if we are trying to shorten the timetable
            if ($currentDays > $numDays) {
                // Find days that would be removed
                $daysToRemove = [];
                mysqli_data_seek($currentDaysResult, 0); // Reset result pointer
                while ($day = mysqli_fetch_assoc($currentDaysResult)) {
                    if ($day['day_number'] > $numDays) {
                        // Check if there's data in the activities for this day
                        if (!empty($day['activities'])) {
                            $daysToRemove[] = $day['day_number'];
                        }
                    }
                }
			}

// If there are days with data in activities that would be removed, disallow the update
if (!empty($daysToRemove)) {
    $planid = $dates['planid'];
    $url = 'timetable_detail.php?id=' . $tid . '&planid=' . $planid . '&scroll=' . $_SESSION['scroll_position'] . '#timetable-details';
    
    // Set up an error message and redirect URL
    $errorMessage = 'Error: Cannot update. There are activities in days that would be removed. Please clear activities on days after the new end date.';
    
    // Store the error message in the session or a flash data mechanism
    $_SESSION['error_message'] = $errorMessage;
    
    // Redirect to the appropriate URL
    header('Location: ' . $url);
    exit;
}


            // Proceed with the update if no data exists in the days to be removed
            $updatePlanSql = "UPDATE plan 
                             SET startDate = '$newStartDate', 
                                 endDate = '$newEndDate' 
                             WHERE planid = '$planId'";
            mysqli_query($con, $updatePlanSql);

            // Adjust timetable_days table based on the new date range
            if ($currentDays < $numDays) {
                // Add new days if needed
                for ($i = $currentDays + 1; $i <= $numDays; $i++) {
                    $insertDaySql = "INSERT INTO timetable_days (day_id, tid, day_number) VALUES (UUID(), '$id', $i)";
                    mysqli_query($con, $insertDaySql);
                }
            } elseif ($currentDays > $numDays) {
                // Delete excess days if shortening
                $deleteDaysSql = "DELETE FROM timetable_days 
                                  WHERE tid = '$id' 
                                  AND day_number > $numDays";
                mysqli_query($con, $deleteDaysSql);
            }

            // Redirect to timetable details page
            header("Location: timetable_detail.php?id=" . $id . "&scroll=" . $_SESSION['scroll_position'] . "#timetable-details");
            exit;
        }



    }

    
// Handle adding new day
if (isset($_POST['add_day'])) {
    mysqli_begin_transaction($con);

    try {
        // Get the current maximum day number
        $maxDaySql = "SELECT COALESCE(MAX(day_number), 0) as max_day FROM timetable_days WHERE tid = '$id'";
        $maxDayResult = mysqli_query($con, $maxDaySql);
        $maxDay = mysqli_fetch_assoc($maxDayResult);
        $nextDayNumber = $maxDay['max_day'] + 1;

        // Insert new day with NULL activities by default
        $insertSql = "INSERT INTO timetable_days (day_id, tid, day_number, activities) VALUES (UUID(), '$id', '$nextDayNumber', NULL)";
        mysqli_query($con, $insertSql);

        // Calculate new end date after adding the day
        $newEndDate = clone $startDate;
        $newEndDate->modify('+' . ($nextDayNumber - 1) . ' days');

        // Update plan end date
        $newEndDateStr = $newEndDate->format('Y-m-d');
        $updatePlanSql = "UPDATE plan 
                         SET endDate = '$newEndDateStr', 
                             duration = DATEDIFF('$newEndDateStr', startDate) + 1
                         WHERE planid = '$planId'";
        mysqli_query($con, $updatePlanSql);

        mysqli_commit($con);
        header("Location: timetable_detail.php?id=" . $id . "&scroll=" . $_SESSION['scroll_position'] . "#timetable-details");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
        exit;
    }
}

// Handle removing day
if (isset($_POST['remove_day'])) {
    $dayId = $_POST['day_id'];
    $dayNumber = $_POST['day_number'];

    mysqli_begin_transaction($con);

    try {
        // Delete the day
        $deleteSql = "DELETE FROM timetable_days WHERE day_id = '$dayId' AND tid = '$id'";
        mysqli_query($con, $deleteSql);

        // Get all remaining days ordered by day_number
        $getDaysSql = "SELECT day_id FROM timetable_days WHERE tid = '$id' ORDER BY day_number";
        $daysResult = mysqli_query($con, $getDaysSql);

        // Update day numbers one by one
        $newDayNumber = 1;
        while ($day = mysqli_fetch_assoc($daysResult)) {
            $updateDayNumberSql = "UPDATE timetable_days SET day_number = $newDayNumber 
                                   WHERE day_id = '{$day['day_id']}'";
            mysqli_query($con, $updateDayNumberSql);
            $newDayNumber++;
        }

        // Count remaining days
        $remainingDaysSql = "SELECT COUNT(*) as days FROM timetable_days WHERE tid = '$id'";
        $remainingDaysResult = mysqli_query($con, $remainingDaysSql);
        $remainingDays = mysqli_fetch_assoc($remainingDaysResult);

        // Calculate new end date after removing a day
        $newEndDate = clone $startDate;
        $newEndDate->modify('+' . ($remainingDays['days'] - 1) . ' days');

        // Update plan end date
        $newEndDateStr = $newEndDate->format('Y-m-d');
        $updatePlanSql = "UPDATE plan 
                         SET endDate = '$newEndDateStr', 
                             duration = DATEDIFF('$newEndDateStr', startDate) + 1
                         WHERE planid = '$planId'";
        mysqli_query($con, $updatePlanSql);

        mysqli_commit($con);
        header("Location: timetable_detail.php?id=" . $id . "&scroll=" . $_SESSION['scroll_position'] . "#timetable-details");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
        exit;
    }
}


// Update Activities functionality with existing logic
if (isset($_POST['update_activities'])) {
    foreach ($_POST['activities'] as $day_id => $activities) {
        // Check if activities is empty and set to NULL if so
        if (trim($activities) === '') {
            $activities = "NULL";
        } else {
            $activities = "'" . mysqli_real_escape_string($con, $activities) . "'";
        }
        
        // Update query with activities value
        $updateSql = "UPDATE timetable_days SET activities = $activities WHERE day_id = '$day_id' AND tid = '$id'";
        mysqli_query($con, $updateSql);
    }
    header("Location: timetable_detail.php?id=" . $id . "&scroll=" . $_SESSION['scroll_position'] . "#timetable-details");
    exit;
}

		
    // Fetch timetable details with dates
    $sql = "SELECT t.tname, td.day_id, td.day_number, td.activities 
            FROM sports_timetable t 
            LEFT JOIN timetable_days td ON t.tid = td.tid 
            WHERE t.tid = '$id'
            ORDER BY td.day_number";
    $result = mysqli_query($con, $sql);
    $timetableData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $timetableData[] = $row;
    }

    // Create an array of all dates within the range
    $dateArray = [];
    $currentDate = clone $startDate;
    while ($currentDate <= $endDate) {
        $dateArray[] = [
            'date' => $currentDate->format('Y-m-d'),
            'day' => $currentDate->format('l')
        ];
        $currentDate->modify('+1 day');
    }
}

$planId = isset($_GET['planid']) ? $_GET['planid'] : $dates['planid'];

// Only proceed with plan validation if we don't have a valid ID from the timetable query
if (!$dates) {
    // Sanitize the plan ID
    $planId = mysqli_real_escape_string($con, $planId);
    
    // Fetch plan details from database
    $planQuery = "SELECT p.*, st.tid, st.tname, i.image_path 
                  FROM plan p 
                  LEFT JOIN sports_timetable st ON p.planid = st.planid 
                  LEFT JOIN images i ON p.planid = i.planid 
                  WHERE p.planid = '$planId'";
                  
    $result = mysqli_query($con, $planQuery);
    $planData = mysqli_fetch_assoc($result);
    
    // If no plan found, redirect to view plans page
    if (!$planData) {
        header("Location: view_plan.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do | Detail Timetable</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css" id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashboard/sidebar.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .day-actions {
            display: flex;
            gap: 10px;
        }
        .home-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 20px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }
        .date-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .date-info span {
            font-weight: bold;
            color: #007bff;
        }
		.go-to-timetable-button {
    display: block;
    margin: 10px auto 20px;
    padding: 10px 20px;
    font-size: 16px;
}
		.go-to-timetable-button {
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.go-to-timetable-button:hover {
    background-color: #0c7b93; /* Optional hover effect */
}
    </style>
</head>
<body class="page-body page-fade" onload="collapseSidebar()">
    <div class="page-container sidebar-collapsed" id="navbarcollapse">
        <div class="sidebar-menu">
            <header class="logo-env">
                <!-- logo -->
                <?php require('../../element/loggedin-logo.html'); ?>
                
                <!-- logo collapse icon -->
                <div class="sidebar-collapse" onclick="collapseSidebar()">
                    <a href="#" class="sidebar-collapse-icon with-animation">
                        <i class="entypo-menu"></i>
                    </a>
                </div>
            </header>
            <?php include('nav.php'); ?>
        </div>

        <div class="main-content">
            <div class="row">
                <!-- Profile Info and Notifications -->
                <div class="col-md-6 col-sm-8 clearfix">
                </div>
                
                <!-- Raw Links -->
                <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                    <ul class="list-inline links-list pull-right">
                        <?php require('../../element/loggedin-welcome.html'); ?>
                        <li>
                            <a href="logout.php">
                                Log Out <i class="entypo-logout right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
			
			            <h2>Edit Plan</h2>
<?php
$tid = mysqli_real_escape_string($con, $_GET['id']); // Get and sanitize tid instead of id

// Modified query to join sports_timetable and plan tables
$sql = "SELECT p.* 
        FROM plan p 
        INNER JOIN sports_timetable st ON p.planid = st.planid 
        WHERE st.tid = '$tid'";

$res = mysqli_query($con, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
} else {
    echo "<p>Plan not found or invalid timetable ID.</p>";
    exit; // Stop script execution if no results are found
}
?>
            <hr/>
<button class="btn btn-info go-to-timetable-button" onclick="scrollToTimetable()">Go to Timetable Section</button>
<div class="container">
	<form id="form1" name="form1" method="post" class="a1-container" action="updateplan.php">	
        <div class="row" style="margin-bottom:200px">
            <div class="col-md-6">
<div class="form-group">
    <label><b>Type of Plan:</b></label>
    <select name="plantype" id="plantype" class="form-control" required onchange="updateFeeLabel()">
        <option value="">--Please Select--</option>
        <option value="Core" <?php echo ($row['planType'] == 'Core') ? 'selected' : ''; ?>>Core</option>
        <option value="Event" <?php echo ($row['planType'] == 'Event') ? 'selected' : ''; ?>>Event</option>
        <option value="Tournament" <?php echo ($row['planType'] == 'Tournament') ? 'selected' : ''; ?>>Tournament</option>
        <option value="Collaboration" <?php echo ($row['planType'] == 'Collaboration') ? 'selected' : ''; ?>>Collaboration</option>
    </select>
</div>


                <!-- Plan Image -->
<div class="form-group">
    <label><b>Event Image:</b></label>
    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
    <img id="image-preview" src="" alt="Image Preview" style="display: none; margin-top: 10px;" width="400">
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('image-preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
	            <td height="0">
                <input type="hidden" name="tid" id="tid" readonly value='<?php echo $id; ?>'>
            </td>
                <div class="form-group">
                    <label><b>Plan ID:</b></label>
                    <input type="text" name="planid" id="planID" class="form-control" readonly 
                        value="<?php echo $row['planid']; ?>">
                </div>

                <input type="hidden" id="boxx" name="timetable_id" 
                    value="<?php echo mt_rand(1, 1000000000); ?>" required/>

                <div class="form-group">
                    <label><b>Plan Name:</b></label>
                    <input type="text" name="planname" id="planName" class="form-control" 
                        placeholder="Enter plan name" value='<?php echo $row['planName']; ?>'>
                </div>
				
				        <h3><u>Involved Staff</u></h3>				
    <!-- Staff Selection with Add Button -->
    <div class="form-group">
        <label><b>Choose Staff:</b></label>
        <div class="input-group">
            <select name="staff_select" id="boxx1" class="form-control" onchange="mystaffdetail(this.value)">
                <option value="">--Please Select--</option>
                <?php
                // Query to select all staff
                $query = "SELECT * FROM staff";
                $result = mysqli_query($con, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row1 = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row1['staffid']}' 
                              data-username='{$row1['username']}' 
                              data-role='{$row1['role']}'>"
                              . htmlspecialchars($row1['name']) . "</option>";
                    }
                }
                ?>
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-success" onclick="addStaffMember()">Add Staff</button>
            </div>
        </div>
	</div>

	
	    <!-- Selected Staff Members Display -->
    <div class="form-group">
        <label><b>Selected Staff Members:</b></label>
    <div id="selectedStaffContainer" style="border: 1px solid #ccc; border-radius: 0.25rem; padding: 1rem !important; margin: 1rem !important; min-height: 100px;">
            <!-- Selected staff will be displayed here -->
        </div>
        <!-- Hidden inputs to store staff data -->
        <input type="hidden" name="selected_staff_data" id="selectedStaffData" value="">
    </div>


            </div>

            <div class="col-md-6">
<div class="form-group">
    <label><b>Description:</b></label>
    <textarea name="desc" id="planDesc" class="form-control" placeholder="Enter plan description" rows="3"><?php echo $row['description']; ?></textarea>
</div>


                <div class="form-group">
                    <label><b>Start Date:</b></label>
                    <input type="date" name="startDate" id="startDate" class="form-control" 
                        onchange="calculateDuration()" value='<?php echo $row['startDate']; ?>'>
                </div>

                <div class="form-group">
                    <label><b>End Date:</b></label>
                    <input type="date" name="endDate" id="endDate" class="form-control" 
                        onchange="calculateDuration()" value='<?php echo $row['endDate']; ?>'>
                </div>

                <div class="form-group">
                    <label><b>Duration (Days):</b></label>
                    <input type="number" name="duration" id="duration" class="form-control" value='<?php echo $row['duration']; ?>' readonly>
                </div>

                <div class="form-group">
                    <label id="feeLabel"><b>Plan Fee:</b></label>
                    <input type="text" name="amount" id="planAmnt" class="form-control" 
                        placeholder="Enter plan amount" value='<?php echo $row['amount']; ?>'>
                </div>
            </div>
			                <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="UPDATE PLAN">
                <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
        </div>
        <h3 id="timetable-details" class="mt-4">Timetable Details</h3>
        <hr/>
    </form>
</div>


        
        <div class="container" style="margin-bottom: 200px;">
            <?php if ($dates): ?>
                <p><strong>Timetable Name:</strong> <?= htmlspecialchars($timetableData[0]['tname'] ?? 'N/A') ?></p>
<!-- HTML Section for Date Update Form -->
<form method="POST" style="margin-bottom: 20px;">
    <label>Start Date:</label>
    <input type="date" name="startDate" value="<?= $startDate->format('Y-m-d') ?>" required>
    
    <label>End Date:</label>
    <input type="date" name="endDate" value="<?= $endDate->format('Y-m-d') ?>" required>
    
    <button type="submit" name="update_dates" class="btn btn-primary">Update Dates</button>
</form>
                
                <!-- Add New Day Button at the top -->
                <form method="POST" style="margin-bottom: 20px;">
                    <button type="submit" name="add_day" class="btn btn-success">
                        Add New Day
                    </button>
                </form>
                
                <form method="POST" action="">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Date</th>
                                <th>Activities</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dateArray as $index => $date): ?>
                                <tr>
                                    <td>Day <?= $index + 1 ?></td>
                                    <td><?= $date['date'] ?> (<?= $date['day'] ?>)</td>
                                    <td>
                                        <?php
                                        $dayData = array_filter($timetableData, function($item) use ($index) {
                                            return ($item['day_number'] ?? 0) == ($index + 1);
                                        });
                                        $dayData = reset($dayData);
                                        ?>
                                        <textarea name="activities[<?= $dayData['day_id'] ?? '' ?>]" 
                                                  class="form-control" 
                                                  rows="3"><?= htmlspecialchars($dayData['activities'] ?? '') ?></textarea>
                                    </td>
                                    <td>
                                        <?php if (!empty($dayData['day_id'])): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="day_id" value="<?= $dayData['day_id'] ?>">
                                                <input type="hidden" name="day_number" value="<?= $index + 1 ?>">
                                                <button type="submit" name="remove_day" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to remove this day? This will update the plan end date.')">
                                                    Remove Day
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
					<button type="submit" name="add_day" class="btn btn-success">Add New Day</button>
                    <button type="submit" name="update_activities" class="btn btn-primary">Update Timetable</button>
					 
                    <a href="view_plan.php" class="btn btn-secondary">Back to Plans</a>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    No date range found for this timetable. Please ensure the timetable is associated with a plan that has start and end dates.
                </div>
                <a href="view_plan.php" class="btn btn-secondary">Back to Plans</a>
            <?php endif; ?>
        </div>
    </div>
    
    <a class="btn-sm px-4 py-3 d-flex home-button return" style="background-color:#2a2e32" href="view_plan.php">
        Return Back
    </a>
	
<script>
    document.getElementById('timetableForm').addEventListener('submit', function() {
        document.getElementById('scrollPosition').value = window.scrollY;
    });

    function restoreScrollPosition() {
        const urlParams = new URLSearchParams(window.location.search);
        const scrollPosition = urlParams.get('scroll');
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition));
        }
    }

    window.onload = restoreScrollPosition;

    function scrollToTimetable() {
        document.getElementById('timetable-details').scrollIntoView({ behavior: 'smooth' });
    }
	let selectedStaff = new Map(); // Using Map to store staff data

function addStaffMember() {
    const select = document.getElementById('boxx1');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!select.value) {
        alert('Please select a staff member');
        return;
    }

    // Check if staff is already added
    if (selectedStaff.has(select.value)) {
        alert('This staff member is already added');
        return;
    }

    // Generate timetable name (you can modify this format)
    const tname = `${selectedOption.text}'s Schedule`;

    // Add to Map with staff data
    selectedStaff.set(select.value, {
        staffid: select.value,
        name: selectedOption.text,
        tname: tname,
        hasApproved: 0 // Default to not approved
    });

    // Create staff member display element
    const container = document.getElementById('selectedStaffContainer');
    const staffElement = document.createElement('div');
    staffElement.className = 'badge badge-primary m-1 p-2 d-inline-flex align-items-center';
    staffElement.innerHTML = `
        ${selectedOption.text}
        <button type="button" class="btn btn-link p-0 ml-2" 
                style="color: white !important; font-size: 16px !important; background: none; border: none;"
                onclick="removeStaffMember('${select.value}', this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(staffElement);

    // Update hidden input with staff data
    updateSelectedStaffData();

    // Reset select
    select.value = '';
}



function removeStaffMember(staffId, buttonElement) {
    selectedStaff.delete(staffId);
    buttonElement.closest('.badge').remove();
    updateSelectedStaffData();
}

function updateSelectedStaffData() {
    const staffData = Array.from(selectedStaff.values());
    document.getElementById('selectedStaffData').value = JSON.stringify(staffData);
}

// Optional: Add validation before form submission
document.getElementById('planForm').onsubmit = function(e) {
    if (selectedStaff.size === 0) {
        alert('Please select at least one staff member');
        e.preventDefault();
        return false;
    }
    return true;
};
</script>

    <?php include('footer.php'); ?>
</body>
</html>