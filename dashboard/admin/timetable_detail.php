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

// Store scroll position before processing form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['scroll_position'] = $_POST['scroll_position'] ?? 0;
    
    if (isset($_POST['update_dates'])) {
        $newStartDate = $_POST['startDate'] ?? $dates['startDate'];
        $newEndDate = $_POST['endDate'] ?? $dates['endDate'];
        $tid = mysqli_real_escape_string($con, $_GET['id']);

        // First, check if the new date range would exclude any days with activities
        $checkDatesSql = "SELECT MIN(DATE_ADD(p.startDate, INTERVAL (td.day_number - 1) DAY)) as earliest_activity,
                                MAX(DATE_ADD(p.startDate, INTERVAL (td.day_number - 1) DAY)) as latest_activity
                         FROM timetable_days td
                         JOIN plan p ON p.planid = ?
                         WHERE td.tid = ? 
                         AND td.activities != ''";
        
        $stmt = mysqli_prepare($con, $checkDatesSql);
        mysqli_stmt_bind_param($stmt, 'ss', $planId, $tid);
        mysqli_stmt_execute($stmt);
        $dateRange = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        // If there are activities, validate the new date range
        if ($dateRange['earliest_activity'] !== NULL) {
            $earliestActivity = new DateTime($dateRange['earliest_activity']);
            $latestActivity = new DateTime($dateRange['latest_activity']);
            $newStart = new DateTime($newStartDate);
            $newEnd = new DateTime($newEndDate);

            // Check if new date range would exclude any activities
            if ($newStart > $earliestActivity || $newEnd < $latestActivity) {
        $_SESSION['error_message'] = 'Cannot update dates: Days with activities would be excluded. The date range must include all days from ' . 
                                   $earliestActivity->format('Y-m-d') . ' to ' . 
                                   $latestActivity->format('Y-m-d');
        header("Location: timetable_detail.php");
        header("Location: timetable_detail.php?id=" . $tid . "&scroll=" . $_SESSION['scroll_position'] . "#timetable-details");					 
                exit;
            }
        }
		

        // If validation passes, proceed with update
        $numDays = (int)((strtotime($newEndDate) - strtotime($newStartDate)) / (60 * 60 * 24)) + 1;

        // Get all existing days with activities and store them by actual date
        $existingDaysSql = "SELECT td.day_number, td.activities, 
                           DATE_ADD(p.startDate, INTERVAL (td.day_number - 1) DAY) as actual_date
                           FROM timetable_days td
                           JOIN plan p ON p.planid = ?
                           WHERE td.tid = ? 
                           AND td.activities != ''
                           ORDER BY td.day_number";
        
        $stmt = mysqli_prepare($con, $existingDaysSql);
        mysqli_stmt_bind_param($stmt, 'ss', $planId, $tid);
        mysqli_stmt_execute($stmt);
        $existingDaysResult = mysqli_stmt_get_result($stmt);

        // Store activities indexed by their actual dates
        $activitiesByDate = [];
        while ($day = mysqli_fetch_assoc($existingDaysResult)) {
            if (!empty($day['activities'])) {
                $activitiesByDate[$day['actual_date']] = $day['activities'];
            }
        }

        // Clear all existing timetable days for this tid
        $clearDaysSql = "DELETE FROM timetable_days WHERE tid = ?";
        $stmt = mysqli_prepare($con, $clearDaysSql);
        mysqli_stmt_bind_param($stmt, 's', $tid);
        mysqli_stmt_execute($stmt);

        // Insert days based on the new date range
        $currentDate = new DateTime($newStartDate);
        for ($i = 1; $i <= $numDays; $i++) {
            $currentDateStr = $currentDate->format('Y-m-d');
            $activities = '';

            // If we have activities for this date, preserve them
            if (isset($activitiesByDate[$currentDateStr])) {
                $activities = $activitiesByDate[$currentDateStr];
            }

            // Insert the day with any preserved activities
            $insertDaySql = "INSERT INTO timetable_days (day_id, tid, day_number, activities) 
                            VALUES (UUID(), ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insertDaySql);
            mysqli_stmt_bind_param($stmt, 'sis', $tid, $i, $activities);
            mysqli_stmt_execute($stmt);

            $currentDate->modify('+1 day');
        }

        // Update plan dates
        $updatePlanSql = "UPDATE plan 
                         SET startDate = ?, 
                             endDate = ? 
                         WHERE planid = ?";
        $stmt = mysqli_prepare($con, $updatePlanSql);
        mysqli_stmt_bind_param($stmt, 'sss', $newStartDate, $newEndDate, $planId);
        mysqli_stmt_execute($stmt);

        $_SESSION['success_message'] = "Dates updated successfully!";
        header("Location: timetable_detail.php?id=" . $tid . "&scroll=" . $_SESSION['scroll_position'] . "#timetable-details");
        exit;
}
    }

    
// At the top of your PHP file, add this function to handle date calculations
function recalculateDates($con, $planId, $startDate, $dayCount) {
    $endDate = clone $startDate;
    $endDate->modify('+' . ($dayCount - 1) . ' days');
    $endDateStr = $endDate->format('Y-m-d');
    
    $updatePlanSql = "UPDATE plan 
                      SET endDate = '$endDateStr', 
                          duration = DATEDIFF('$endDateStr', startDate) + 1
                      WHERE planid = '$planId'";
    mysqli_query($con, $updatePlanSql);
}

if (isset($_POST['add_day'])) {
    $_SESSION['scroll_position'] = $_POST['scroll_position']; // Store scroll position in session
    mysqli_begin_transaction($con);
    try {
        // Get the current maximum and minimum day numbers
        $daysSql = "SELECT COALESCE(MAX(day_number), 0) as max_day, 
                           COALESCE(MIN(day_number), 1) as min_day 
                    FROM timetable_days 
                    WHERE tid = '$id'";
        $daysResult = mysqli_query($con, $daysSql);
        $days = mysqli_fetch_assoc($daysResult);
        
        // Determine if we're adding a previous or next day
        $isPrevious = isset($_POST['direction']) && $_POST['direction'] === 'previous';
        $newDayNumber = $isPrevious ? $days['min_day'] - 1 : $days['max_day'] + 1;
        
        if ($isPrevious) {
            // Update all existing day numbers to make room for the new day
            $updateSql = "UPDATE timetable_days 
                         SET day_number = day_number + 1 
                         WHERE tid = '$id'";
            mysqli_query($con, $updateSql);
            $newDayNumber = 1;
        }
        
        // Insert new day
        $insertSql = "INSERT INTO timetable_days (day_id, tid, day_number, activities) 
                      VALUES (UUID(), '$id', '$newDayNumber', NULL)";
        mysqli_query($con, $insertSql);
        
        // Get total number of days after insertion
        $countSql = "SELECT COUNT(*) as total FROM timetable_days WHERE tid = '$id'";
        $countResult = mysqli_query($con, $countSql);
        $totalDays = mysqli_fetch_assoc($countResult)['total'];
        
        // Update plan dates
        if ($isPrevious) {
            $startDate->modify('-1 day');
            $updateStartSql = "UPDATE plan SET startDate = '" . $startDate->format('Y-m-d') . "' WHERE planid = '$planId'";
            mysqli_query($con, $updateStartSql);
        }
        recalculateDates($con, $planId, $startDate, $totalDays);
        
        mysqli_commit($con);
        
        // Redirect to the appropriate form based on direction
        $formId = $isPrevious ? 'prevDayForm' : 'nextDayForm';
        header("Location: timetable_detail.php?id=" . $id . "&scroll=" . $_SESSION['scroll_position'] . "#$formId");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($con);
        // Handle error in a way other than echo
        logError($e->getMessage());
        exit;
    }
}

// Handle removing day
if (isset($_POST['remove_day'])) {
    $dayId = $_POST['day_id'];
    $dayNumber = (int)$_POST['day_number'];
    
    mysqli_begin_transaction($con);
    try {
        // Get total number of days before deletion
        $totalDaysSql = "SELECT COUNT(*) as total FROM timetable_days WHERE tid = ?";
        $stmt = mysqli_prepare($con, $totalDaysSql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $totalResult = mysqli_stmt_get_result($stmt);
        $totalDays = mysqli_fetch_assoc($totalResult)['total'];

        // Delete the specific day
        $deleteSql = "DELETE FROM timetable_days WHERE day_id = ? AND tid = ?";
        $stmt = mysqli_prepare($con, $deleteSql);
        mysqli_stmt_bind_param($stmt, "ss", $dayId, $id);
        mysqli_stmt_execute($stmt);

        // Update day numbers for subsequent days
        $updateDaysSql = "UPDATE timetable_days 
                         SET day_number = day_number - 1 
                         WHERE tid = ? AND day_number > ?";
        $stmt = mysqli_prepare($con, $updateDaysSql);
        mysqli_stmt_bind_param($stmt, "si", $id, $dayNumber);
        mysqli_stmt_execute($stmt);

        // If first day was removed, adjust start date
        if ($dayNumber === 1) {
            $newStartDate = clone $startDate;
            $newStartDate->modify('+1 day');
            $newStartDateStr = $newStartDate->format('Y-m-d');
            
            $updateStartSql = "UPDATE plan SET startDate = ? WHERE planid = ?";
            $stmt = mysqli_prepare($con, $updateStartSql);
            mysqli_stmt_bind_param($stmt, "ss", $newStartDateStr, $planId);
            mysqli_stmt_execute($stmt);
        }
        // If last day was removed, adjust end date
        else if ($dayNumber === $totalDays) {
            $newEndDate = clone $endDate;
            $newEndDate->modify('-1 day');
            $newEndDateStr = $newEndDate->format('Y-m-d');
            
            $updateEndSql = "UPDATE plan SET endDate = ? WHERE planid = ?";
            $stmt = mysqli_prepare($con, $updateEndSql);
            mysqli_stmt_bind_param($stmt, "ss", $newEndDateStr, $planId);
            mysqli_stmt_execute($stmt);
        }

        // Update plan duration
        $updateDurationSql = "UPDATE plan 
                            SET duration = DATEDIFF(endDate, startDate) + 1 
                            WHERE planid = ?";
        $stmt = mysqli_prepare($con, $updateDurationSql);
        mysqli_stmt_bind_param($stmt, "s", $planId);
        mysqli_stmt_execute($stmt);

        mysqli_commit($con);
        header("Location: timetable_detail.php?id=" . $id . "&scroll=" . $_SESSION['scroll_position'] . "#timetable-details");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($con);
        error_log("Error removing day: " . $e->getMessage());
        $_SESSION['error_message'] = "Error removing day. Please try again.";
        header("Location: timetable_detail.php?id=" . $id);
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

#selectedMembersContainer {
    border: 1px solid #ddd;
    padding: 10px;
    margin-top: 10px;
    min-height: 50px;
    border-radius: 4px;
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
			
<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] === true;
$isCoach = isset($_SESSION['is_coach_logged_in']) && $_SESSION['is_coach_logged_in'] === true;
$returnPath = $isAdmin ? '../../dashboard/admin/view_plan.php' : ($isCoach ? '../../dashboard/coach/view_plan.php' : '../../dashboard/member/view_plan.php');


$tid = mysqli_real_escape_string($con, $_GET['id']); 

$sql = "SELECT p.* 
        FROM plan p 
        INNER JOIN sports_timetable st ON p.planid = st.planid 
        WHERE st.tid = '$tid'";

$res = mysqli_query($con, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
} else {
    echo "<p>Plan not found or invalid timetable ID.</p>";
    exit;
}
?>
<h2><?php echo $isAdmin ? 'Edit' : 'View' ?> Plan</h2>
            <hr/>
<div class="d-flex justify-content-center">
    <button class="btn btn-info btn-sm mx-2 go-to-timetable-button" onclick="scrollToTimetable()">Go to Timetable Section</button>
    <button class="btn btn-info btn-sm mx-2 go-to-involvement-button" onclick="scrollToInvolvement()">Go to Involvement Section</button>
</div>




<div class="container">
    <form id="form1" name="form1" method="post" class="a1-container" action="updateplan.php">    
			<h2 id="detailss"><b>Event Detail:</b></h2>	
        <div class="row" style="margin-bottom:200px">

            <div class="col-md-6">
                <div class="form-group">
                    <label><b>Type of Plan:</b></label>
                    <select name="plantype" id="plantype" class="form-control" required onchange="updateFeeLabel()" <?php echo !$isAdmin ? 'disabled' : ''; ?>>
                        <option value="">--Please Select--</option>
                        <option value="Core" <?php echo ($row['planType'] == 'Core') ? 'selected' : ''; ?>>Core</option>
                        <option value="Event" <?php echo ($row['planType'] == 'Event') ? 'selected' : ''; ?>>Event</option>
                        <option value="Tournament" <?php echo ($row['planType'] == 'Tournament') ? 'selected' : ''; ?>>Tournament</option>
                        <option value="Collaboration" <?php echo ($row['planType'] == 'Collaboration') ? 'selected' : ''; ?>>Collaboration</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><b>Event Image:</b></label>
                    <?php if ($isAdmin): ?>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <?php endif; ?>
                    <img id="image-preview" src="" alt="Image Preview" style="display: none; margin-top: 10px;" width="400">
                </div>

                <div class="form-group">
                    <label><b>Plan ID:</b></label>
                    <input type="text" name="planid" id="planID" class="form-control" readonly 
                        value="<?php echo $row['planid']; ?>">
                </div>
				
				<div class="form-group">
                    <label><b></b></label>
                    <input type="hidden" name="tid" id="tid" class="form-control" readonly 
                        value="<?php echo $tid ?>">
                </div>

                <div class="form-group">
                    <label><b>Plan Name:</b></label>
                    <input type="text" name="planname" id="planName" class="form-control" 
                        placeholder="Enter plan name" value='<?php echo $row['planName']; ?>' <?php echo !$isAdmin ? 'readonly' : ''; ?>>
                </div>
                </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label><b>Description:</b></label>
                    <textarea name="desc" id="planDesc" class="form-control" placeholder="Enter plan description" 
                        rows="3" <?php echo !$isAdmin ? 'readonly' : ''; ?>><?php echo $row['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label><b>Start Date:</b></label>
                    <input type="date" name="startDate" id="startDate" class="form-control" 
                        onchange="calculateDuration()" value='<?php echo $row['startDate']; ?>' <?php echo !$isAdmin ? 'readonly' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><b>End Date:</b></label>
                    <input type="date" name="endDate" id="endDate" class="form-control" 
                        onchange="calculateDuration()" value='<?php echo $row['endDate']; ?>' <?php echo !$isAdmin ? 'readonly' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><b>Duration (Days):</b></label>
                    <input type="number" name="duration" id="duration" class="form-control" value='<?php echo $row['duration']; ?>' readonly>
                </div>

                <div class="form-group">
                    <label id="feeLabel"><b>Plan Fee:</b></label>
                    <input type="text" name="amount" id="planAmnt" class="form-control" 
                        placeholder="Enter plan amount" value='<?php echo $row['amount']; ?>' <?php echo !$isAdmin ? 'readonly' : ''; ?>>
                </div>
				
				
            </div>
			
<div>
            <?php if ($isAdmin): ?>
                <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="UPDATE PLAN">
                <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
            <?php endif; ?>
        </div>

<div class="col-md-12" style="margin-top:250px;">
<hr>
<h2 id="involvementid"><b>Member and Staff Involvement</b></h2>	<br><br>
<!-- Your HTML content -->
<h3><b>Involved Staff</b></h3>
<?php if ($isAdmin): ?>
    <div class="form-group">
        <label><b>Choose Staff:</b></label>
        <div class="input-group">
            <select name="staff_select" id="boxx1" class="form-control" onchange="mystaffdetail(this.value)">
                <option value="">--Please Select--</option>
                <?php
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
<?php endif; ?>

<div class="form-group">
    <label><b>Selected Staff Members:</b></label>
    <div id="selectedStaffContainer" style="border: 1px solid #ccc; border-radius: 0.25rem; padding: 1rem !important; margin: 1rem !important; min-height: 100px;">
        <!-- Selected staff will be displayed here -->
    </div>
    <input type="hidden" name="selected_staff_data" id="selectedStaffData" value="">
</div>
</div>

<?php
$selectedStaffQuery = "SELECT staff.staffid, staff.name 
                       FROM event_staff 
                       JOIN staff ON event_staff.staffid = staff.staffid 
                       WHERE event_staff.planid = '$planId'";
$selectedStaffResult = mysqli_query($con, $selectedStaffQuery);
$selectedStaff = [];

if (mysqli_num_rows($selectedStaffResult) > 0) {
    while ($staff = mysqli_fetch_assoc($selectedStaffResult)) {
        $selectedStaff[] = $staff;
    }
}
?>

<?php $isAdmin = isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] === true; ?>


<script>
const selectedStaff = new Map();

const isAdmin = <?php echo isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'true' : 'false'; ?>;
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

    // Add to Map with staff data
    selectedStaff.set(select.value, {
        staffid: select.value,
        name: selectedOption.text
    });

    // Create staff member display element
    const container = document.getElementById('selectedStaffContainer');
    const staffElement = document.createElement('div');
    staffElement.className = 'badge badge-primary m-1 p-2 d-inline-flex align-items-center';
    staffElement.innerHTML = `
        ${selectedOption.text}
        ${isAdmin ? `
        <button type="button" class="btn btn-link p-0 ml-2" 
                style="color: white !important; font-size: 16px !important; background: none; border: none;"
                onclick="removeStaffMember('${select.value}', this)">
            <i class="fas fa-times"></i>
        </button>` : ''}
    `;
    container.appendChild(staffElement);

    // Update hidden input with staff data
    updateSelectedStaffData();

    // Reset select
    select.value = '';
}

function removeStaffMember(staffId, button) {
    selectedStaff.delete(staffId);
    button.parentElement.remove();
    updateSelectedStaffData();
}

function updateSelectedStaffData() {
    const selectedStaffData = document.getElementById('selectedStaffData');
    selectedStaffData.value = JSON.stringify(Array.from(selectedStaff.values()));
}

// Render pre-selected staff on page load
document.addEventListener('DOMContentLoaded', function() {
    const preSelectedStaff = <?php echo json_encode($selectedStaff); ?>;
    if (preSelectedStaff.length > 0) {
        preSelectedStaff.forEach(staff => {
            selectedStaff.set(staff.staffid, {
                staffid: staff.staffid,
                name: staff.name
            });

// Create staff member display element
const container = document.getElementById('selectedStaffContainer');
const staffElement = document.createElement('div');
staffElement.className = 'badge badge-primary m-1 p-2 d-inline-flex align-items-center';

// Check if user is admin based on the session variable
const isAdmin = <?php echo isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'true' : 'false'; ?>;

// Generate button HTML only if the user is admin
const buttonHtml = isAdmin ? `
    <button type="button" class="btn btn-link p-0 ml-2" 
            style="color: white !important; font-size: 16px !important; background: none; border: none;"
            onclick="removeStaffMember('${staff.staffid}', this)">
        <i class="fas fa-times"></i>
    </button>
` : '';

staffElement.innerHTML = `
    ${staff.name}
    ${buttonHtml}
`;
container.appendChild(staffElement);

        });
        updateSelectedStaffData();
    }
});


</script>

<div class="col-md-12" style="margin-top:50px;">

    <h3><b>Involved Members</b></h3>
	<?php if ($isAdmin): ?>
    <div class="form-group">
        <label><b>Choose Eligible Member:</b></label>
<div class="input-group">
    <select name="member_select" id="memberBox" class="form-control">
        <option value="">--Please Select--</option>
        <?php
        $query = "SELECT DISTINCT u.userid, u.fullName
                  FROM users u
                  INNER JOIN enrolls_to et ON u.userid = et.userid
                  WHERE et.hasPaid = 'yes' AND et.hasApproved = 'yes'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . htmlspecialchars($row['userid']) . "'>" 
                     . htmlspecialchars($row['fullName']) 
                     . "</option>";
            }
        }
        ?>
    </select>
    <div class="input-group-append">
        <button type="button" class="btn btn-success" onclick="addEventMember()">Add Member</button>
    </div>
</div>

    </div>
	<?php endif; ?>

    <div class="form-group">
        <label><b>Selected Karate Members:</b></label>
        <div id="selectedMembersContainer">
            <!-- Selected members will appear here -->
        </div>
        <input type="hidden" name="selected_members_data" id="selectedMembersData" value="">
    </div>
</div>

<?php
$selectedMembersQuery = "SELECT users.userid, users.fullName 
                         FROM event_members 
                         JOIN users ON event_members.userid = users.userid 
                         WHERE event_members.planid = '$planId'";
$selectedMembersResult = mysqli_query($con, $selectedMembersQuery);
$selectedMembers = [];

if (mysqli_num_rows($selectedMembersResult) > 0) {
    while ($member = mysqli_fetch_assoc($selectedMembersResult)) {
        $selectedMembers[] = $member;
    }
}
?>



<script>
const eventMembers = new Map();

function addEventMember() {
    const select = document.getElementById('memberBox');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!select.value) {
        alert('Please select a member');
        return;
    }

    // Check if member is already added
    if (eventMembers.has(select.value)) {
        alert('This member is already added');
        return;
    }

    // Add to Map with member data
    eventMembers.set(select.value, {
        userId: select.value,
        fullName: selectedOption.text
    });

    // Create member display element
    const container = document.getElementById('selectedMembersContainer');
    const memberElement = document.createElement('div');
    memberElement.className = 'badge badge-primary m-1 p-2 d-inline-flex align-items-center';
    memberElement.innerHTML = `
        ${selectedOption.text}
        <button type="button" class="btn btn-link p-0 ml-2" 
                style="color: white !important; font-size: 16px !important; background: none; border: none;"
                onclick="removeEventMember('${select.value}', this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(memberElement);

    // Update hidden input with member data
    updateEventMemberData();

    // Reset select
    select.value = '';
}

function removeEventMember(userId, button) {
    eventMembers.delete(userId);
    button.parentElement.remove();
    updateEventMemberData();
}

function updateEventMemberData() {
    const selectedMembersData = document.getElementById('selectedMembersData');
    selectedMembersData.value = JSON.stringify(Array.from(eventMembers.values()));
}

// Render pre-selected members on page load
document.addEventListener('DOMContentLoaded', function() {
    const preSelectedMembers = <?php echo json_encode($selectedMembers); ?>;
    if (preSelectedMembers.length > 0) {
        preSelectedMembers.forEach(member => {
            eventMembers.set(member.userid, {
                userId: member.userid,
                fullName: member.fullName
            });

// Create member display element
const container = document.getElementById('selectedMembersContainer');
const memberElement = document.createElement('div');
memberElement.className = 'badge badge-primary m-1 p-2 d-inline-flex align-items-center';

// Check if user is admin based on the session variable
const isAdmin = <?php echo isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'true' : 'false'; ?>;

// Generate button HTML only if the user is admin
const buttonHtml = isAdmin ? `
    <button type="button" class="btn btn-link p-0 ml-2" 
            style="color: white !important; font-size: 16px !important; background: none; border: none;"
            onclick="removeEventMember('${member.userid}', this)">
        <i class="fas fa-times"></i>
    </button>
` : '';

memberElement.innerHTML = `
    ${member.fullName}
    ${buttonHtml}
`;
container.appendChild(memberElement);

        });
        updateEventMemberData();
    }
});

</script>


<div>
            <?php if ($isAdmin): ?>
                <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="UPDATE PLAN">
                <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
            <?php endif; ?>
        </div>
        <hr/>
    </form>
</div>

<hr>
         <h3 id="timetable-details" class="mt-4"><b>Timetable Details</b></h3>       
<div class="container" style="margin-bottom: 200px;">
    <?php if ($dates): ?>
        <p><strong>Timetable Name:</strong> <?= htmlspecialchars($timetableData[0]['tname'] ?? 'N/A') ?></p>
        
        <?php if ($isAdmin): ?>
            <!-- HTML Section for Date Update Form - Only visible to admins -->
            <form method="POST" style="margin-bottom: 20px;">
                <label>Start Date:</label>
                <input type="date" name="startDate" value="<?= $startDate->format('Y-m-d') ?>" required>
                
                <label>End Date:</label>
                <input type="date" name="endDate" value="<?= $endDate->format('Y-m-d') ?>" required>
                
                <button type="submit" name="update_dates" class="btn btn-primary">Update Dates</button>
            </form>

            <!-- Add Previous Day Button - Only visible to admins -->
            <div style="display: flex; justify-content: center; gap: 10px; align-items: center;">
                <form method="POST" style="display: inline;" id="prevDayForm">
                    <input type="hidden" name="direction" value="previous">
                    <input type="hidden" name="scroll_position" id="scroll_position">
                    <button type="submit" name="add_day" class="btn btn-success" onclick="saveScrollPosition()">
                        Add Previous Day
                    </button>
                </form>
            </div>
        <?php else: ?>
            <!-- Read-only date display for non-admins -->
            <div class="mb-3">
                <p><strong>Start Date:</strong> <?= $startDate->format('Y-m-d') ?></p>
                <p><strong>End Date:</strong> <?= $endDate->format('Y-m-d') ?></p>
            </div>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
            <form method="POST" action="">
        <?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Day</th>
            <th>Date</th>
            <th>Activities</th>
            <?php if ($isAdmin): ?>
                <th>Actions</th>
            <?php endif; ?>
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
                    if ($isAdmin):
                    ?>
                        <textarea name="activities[<?= $dayData['day_id'] ?? '' ?>]" 
                                  class="form-control" 
                                  rows="3"><?= htmlspecialchars($dayData['activities'] ?? '') ?></textarea>
                    <?php else: ?>
                        <div class="form-control" style="height: auto; min-height: 74px; background-color: #f8f9fa;">
                            <?= nl2br(htmlspecialchars($dayData['activities'] ?? '')) ?>
                        </div>
                    <?php endif; ?>
                </td>
                <?php if ($isAdmin): ?>
                    <td>
                        <?php if (!empty($dayData['day_id'])): ?>
<form method="POST" style="display: inline;">
    <input type="hidden" name="day_id" value="<?= $dayData['day_id'] ?>">
    <input type="hidden" name="day_number" value="<?= $index + 1 ?>">
    <button type="submit" name="remove_day" class="btn btn-danger btn-sm" 
            onclick="return confirm('Are you sure you want to remove this day?')">
        Remove Day
    </button>
</form>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
   
            <?php if ($isAdmin): ?>
                <br>
                <button type="submit" name="update_activities" class="btn btn-primary">Update Timetable</button>
            <?php endif; ?>
            
<a href="<?php echo $returnPath; ?>" class="btn btn-secondary">Back to Plans</a>

        <?php if ($isAdmin): ?>
            </form>

            <!-- Add Next Day Button - Only visible to admins -->
            <div style="display: flex; justify-content: center; gap: 10px; align-items: center;">
                <form method="POST" style="display: inline;" id="nextDayForm">
                    <input type="hidden" name="direction" value="next">
                    <input type="hidden" name="scroll_position" id="scroll_position">
                    <button type="submit" name="add_day" class="btn btn-success" onclick="saveScrollPosition()">
                        Add Next Day
                    </button>
                </form>
            </div>
        <?php endif; ?>
            
    <?php else: ?>
        <div class="alert alert-warning">
            No date range found for this timetable. Please ensure the timetable is associated with a plan that has start and end dates.
        </div>
    <?php endif; ?>
</div>
    
<a class="btn-sm px-4 py-3 d-flex home-button return" style="background-color:#2a2e32" href="<?php echo $returnPath; ?>">
    Return Back
</a>
	
<script>
// Save scroll position before form submission
document.getElementById('timetableForm').addEventListener('submit', function() {
    document.getElementById('scrollPosition').value = window.scrollY;
});

// Scroll to timetable section
function scrollToTimetable() {
    document.getElementById('timetable-details').scrollIntoView({ behavior: 'smooth' });
}

// Scroll to timetable section
function scrollToInvolvement() {
    document.getElementById('involvementid').scrollIntoView({ behavior: 'smooth' });
}

// Scroll to bottom when required
function scrollToBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
}




// Validation before form submission
document.getElementById('planForm').onsubmit = function(e) {
    if (selectedStaff.size === 0) {
        alert('Please select at least one staff member');
        e.preventDefault();
        return false;
    }
    return true;
};
    function saveScrollPosition() {
        // Save the current scroll position of the button in the hidden input
        const buttonPosition = document.querySelector('#nextDayForm button').getBoundingClientRect().top + window.scrollY;
        document.getElementById('scroll_position').value = buttonPosition;
    }

    function restoreScrollPosition() {
        const urlParams = new URLSearchParams(window.location.search);
        const scrollPosition = urlParams.get('scroll');
        
        // Scroll to saved position if available; otherwise, scroll to timetable section
        if (scrollPosition) {
            window.scrollTo({
                top: parseInt(scrollPosition),
                behavior: 'smooth'
            });
        } else {
            document.getElementById('timetable-details').scrollIntoView({ behavior: 'smooth' });
        }
    }


    window.onload = restoreScrollPosition;
</script>

    <?php include('footer.php'); ?>
</body>
</html>