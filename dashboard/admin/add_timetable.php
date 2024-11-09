<?php
require '../../include/db_conn.php';
page_protect();

$planid = $_GET['planid']; // Get the planid from the URL
$staffid = 1; // Set a default staffid or retrieve it from your session or database
$tname = 'Default Timetable Name'; // Set a default timetable name
$hasApproved = 'no'; // Set default approval status

$tid = mt_rand(1, 1000000000);
$query = "INSERT INTO sports_timetable (tid, planid, staffid, tname, hasApproved) VALUES ('$tid', '$planid', '$staffid', '$tname', '$hasApproved')";

$result = mysqli_query($con, $query);

if ($result) {
    // Redirect to timetable_detail.php with the manually assigned tid and planid
    header("Location: timetable_detail.php?id=$tid&planid=$planid");
    exit();
} else {
    echo "Error: " . mysqli_error($con);
}
?>
