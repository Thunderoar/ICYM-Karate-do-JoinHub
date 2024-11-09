<?php
// unjoin_plan.php

session_start();
require '../../include/db_conn.php';
page_protect();

$userid = $_POST['userid'];
$planid = $_POST['planid'];

// SQL query to delete the enrollment
$delete_query = "DELETE FROM enrolls_to WHERE userid = '$userid' AND planid = '$planid'";
$result = mysqli_query($con, $delete_query);

if ($result) {
    // Redirect back with success message
    header("Location: view_plan.php?message=Successfully unjoined from the plan");
} else {
    // Redirect back with error message
    header("Location: view_plan.php?message=Error: Unable to unjoin the plan");
}

mysqli_close($con);
?>
