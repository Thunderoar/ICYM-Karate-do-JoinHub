<?php
require '../../include/db_conn.php';
page_protect();
$id = $_GET['id'];

// Handle adding new day
if (isset($_POST['add_day'])) {
    // Get the current maximum day number
    $maxDaySql = "SELECT COALESCE(MAX(day_number), 0) as max_day FROM timetable_days WHERE tid = '$id'";
    $maxDayResult = mysqli_query($con, $maxDaySql);
    $maxDay = mysqli_fetch_assoc($maxDayResult);
    $nextDayNumber = $maxDay['max_day'] + 1;
    
    // Insert new day
    $insertSql = "INSERT INTO timetable_days (tid, day_number, activities) VALUES ('$id', '$nextDayNumber', '')";
    mysqli_query($con, $insertSql);
    
    header("Location: timetable_detail.php?id=" . $id);
    exit;
}

// Handle removing day
if (isset($_POST['remove_day'])) {
    $dayId = $_POST['day_id'];
    
    // Delete the day
    $deleteSql = "DELETE FROM timetable_days WHERE day_id = '$dayId' AND tid = '$id'";
    mysqli_query($con, $deleteSql);
    
    // Reorder remaining days
    $reorderSql = "SET @num := 0; 
                   UPDATE timetable_days 
                   SET day_number = (@num := @num + 1) 
                   WHERE tid = '$id' 
                   ORDER BY day_number;";
    mysqli_multi_query($con, $reorderSql);
    
    header("Location: timetable_detail.php?id=" . $id);
    exit;
}

// Handle updating activities
if (isset($_POST['update_activities'])) {
    foreach ($_POST['activities'] as $day_id => $activities) {
        $activities = mysqli_real_escape_string($con, $activities);
        $updateSql = "UPDATE timetable_days SET activities = '$activities' WHERE day_id = '$day_id' AND tid = '$id'";
        mysqli_query($con, $updateSql);
    }
    header("Location: timetable_detail.php?id=" . $id);
    exit;
}

// Fetch timetable details
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
                <p><strong>Timetable Name:</strong> <?= htmlspecialchars($timetableData[0]['tname'] ?? 'N/A') ?></p>
                
                <!-- Add New Day Button -->
                <form method="POST" class="mb-3">
                    <button type="submit" name="add_day" class="btn btn-success">Add New Day</button>
                </form>
                
                <form method="POST" action="">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Activities</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($timetableData)) : ?>
                                <?php foreach ($timetableData as $day) : ?>
                                    <?php if (!empty($day['day_id'])) : ?>
                                        <tr>
                                            <td>Day <?= htmlspecialchars($day['day_number']) ?></td>
                                            <td>
                                                <textarea name="activities[<?= $day['day_id'] ?>]" class="form-control" rows="3"><?= htmlspecialchars($day['activities']) ?></textarea>
                                            </td>
                                            <td>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="day_id" value="<?= $day['day_id'] ?>">
                                                    <button type="submit" name="remove_day" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this day?')">
                                                        Remove Day
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">No days found. Add a new day to get started.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php if (!empty($timetableData)) : ?>
                        <button type="submit" name="update_activities" class="btn btn-primary">Update Timetable</button>
                    <?php endif; ?>
                    <a href="view_plan.php" class="btn btn-secondary">Back to Plans</a>
                </form>
            </div>
        </div>
    </div>
    <a class="btn-sm px-4 py-3 d-flex home-button return" style="background-color:#2a2e32" href="viewroutine.php">Return to Timetable</a>
    <?php include('footer.php'); ?>
</body>
</html>