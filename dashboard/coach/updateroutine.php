<?php
require '../../include/db_conn.php';
page_protect();

$id = $_POST['tid'];  // This can be a string
$day1 = $_POST['day1'];
$day2 = $_POST['day2'];
$day3 = $_POST['day3'];
$day4 = $_POST['day4'];
$day5 = $_POST['day5'];
$day6 = $_POST['day6'];

// Escape string to make it safe
$id = mysqli_real_escape_string($con, $id);

// Use prepared statement to prevent SQL injection
$query1 = "UPDATE sports_timetable SET day1=?, day2=?, day3=?, day4=?, day5=?, day6=? WHERE tid=?";
$stmt = mysqli_prepare($con, $query1);

mysqli_stmt_bind_param($stmt, 'sssssss', $day1, $day2, $day3, $day4, $day5, $day6, $id);

if (mysqli_stmt_execute($stmt)) {
    echo "<html><head><script>alert('Routine Updated Successfully');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=viewroutine.php'>";
} else {
    echo "<html><head><script>alert('ERROR! Update Operation Unsuccessful');</script></head></html>";
    echo "Error: " . mysqli_error($con);
}
?>
