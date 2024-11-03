<?php
require '../../include/db_conn.php';
page_protect();
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

    // Retrieve tid from the sports_timetable table based on the planid
    $getTidSql = "SELECT tid FROM sports_timetable WHERE planid = '$planId'";
    $result = mysqli_query($con, $getTidSql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tid = $row['tid']; // Retrieved tid to be used in further queries

        if (isset($_POST['update_dates'])) {
            $newStartDate = $_POST['startDate'] ?? $dates['startDate'];
            $newEndDate = $_POST['endDate'] ?? $dates['endDate'];

            // Check if the new end date is earlier and there are activities in timetable_days beyond this date
            $endDateTimestamp = strtotime($newEndDate);
            $checkActivitiesSql = "SELECT * FROM timetable_days WHERE tid = '$tid' AND day_number > (DATEDIFF('$newEndDate', '$newStartDate') + 1) AND activities IS NOT NULL";
            $result = mysqli_query($con, $checkActivitiesSql);

            if (mysqli_num_rows($result) > 0) {
                // If activities exist beyond the new end date, disallow the update and show an error as an alert
                echo "<script>alert('Error: Cannot shorten the end date because there are activities scheduled beyond this date.');</script>";
            } else {
                // Update the plan dates
                $updatePlanSql = "UPDATE plan 
                                  SET startDate = '$newStartDate', 
                                      endDate = '$newEndDate' 
                                  WHERE planid = '$planId'";
                mysqli_query($con, $updatePlanSql);

                // Calculate the total number of days between startDate and endDate
                $numDays = (int) ((strtotime($newEndDate) - strtotime($newStartDate)) / (60 * 60 * 24)) + 1;

                // Loop through each day and insert missing days into timetable_days if they don't exist
                for ($i = 1; $i <= $numDays; $i++) {
                    $checkDaySql = "SELECT * FROM timetable_days WHERE tid = '$tid' AND day_number = $i";
                    $dayResult = mysqli_query($con, $checkDaySql);

                    if (mysqli_num_rows($dayResult) === 0) {
                        // Insert missing day if it doesn't exist
                        $insertDaySql = "INSERT INTO timetable_days (day_id, tid, day_number) VALUES (UUID(), '$tid', $i)";
                        mysqli_query($con, $insertDaySql);
                    }
                }

                // Calculate the difference in days between the old and new start dates
                $oldStartDateTimestamp = strtotime($dates['startDate']); // Assuming $dates holds the original dates
                $newStartDateTimestamp = strtotime($newStartDate);
                $dateDifference = (int)(($newStartDateTimestamp - $oldStartDateTimestamp) / (60 * 60 * 24));

                // Now update the timetable_days based on the form data
                foreach ($_POST['days'] as $dayId => $dayData) {
                    $dayNumber = $dayData['day_number'] ?? null;
                    $activities = $dayData['activities'] ?? null;

                    if ($dayNumber !== null && $activities !== null) {
                        // Adjust the day number based on the date difference
                        $newDayNumber = $dayNumber + $dateDifference;

                        $updateDaySql = "UPDATE timetable_days 
                                         SET day_number = '$newDayNumber', 
                                             activities = '$activities' 
                                         WHERE day_id = '$dayId' AND tid = '$tid'";
                        mysqli_query($con, $updateDaySql);
                    }
                }

                // Redirect back to the timetable detail page
                header("Location: timetable_detail.php?id=" . $id);
                exit;
            }
        }
    } else {
        echo "No timetable found for the specified plan.";
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
            
            // Insert new day
            $insertSql = "INSERT INTO timetable_days (day_id, tid, day_number, activities) VALUES (UUID(), '$id', '$nextDayNumber', '')";
            mysqli_query($con, $insertSql);
            
            // Calculate new end date
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
            header("Location: timetable_detail.php?id=" . $id . "&scroll=" . $_SESSION['scroll_position']);
            exit;
            
        } catch (Exception $e) {
            mysqli_rollback($con);
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    // Handle removing day (previous code remains the same)
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
            
            // Calculate new end date
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
            header("Location: timetable_detail.php?id=" . $id);
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
                $activities = mysqli_real_escape_string($con, $activities);
                $updateSql = "UPDATE timetable_days SET activities = '$activities' WHERE day_id = '$day_id' AND tid = '$id'";
                mysqli_query($con, $updateSql);
            }
            header("Location: timetable_detail.php?id=" . $id);
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
            
        <h2>Timetable Detail</h2>
        <hr/>
        
        <div class="container">
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
        // Store scroll position before form submission
        document.getElementById('timetableForm').addEventListener('submit', function() {
            document.getElementById('scrollPosition').value = window.scrollY;
        });

        // Restore scroll position after page load
        function restoreScrollPosition() {
            const urlParams = new URLSearchParams(window.location.search);
            const scrollPosition = urlParams.get('scroll');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition));
            }
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>