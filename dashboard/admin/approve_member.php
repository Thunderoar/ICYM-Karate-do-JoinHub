<?php
require '../../include/db_conn.php';
page_protect();

if (isset($_POST['userid'])) {
    $userid = $_POST['userid'];
    $isReapproved = isset($_POST['isReapproved']) ? 1 : 0;

    // Update query to approve or reapprove the user
    $query = "UPDATE users SET hasApproved='Yes', hasReapproved='$isReapproved' WHERE userid='$userid'";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Member approved successfully');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";
    } else {
        echo "<script>alert('Error approving member');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";
    }
}
?>
