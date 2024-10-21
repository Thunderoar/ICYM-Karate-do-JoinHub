<?php
require '../../include/db_conn.php';
page_protect();

if (isset($_POST['userid'])) {
    $userid = $_POST['userid'];
    
    // Update query to disapprove the user
    $query = "UPDATE users SET hasApproved='No' WHERE userid='$userid'";
    
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Member disapproved successfully');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";
    } else {
        echo "<script>alert('Error disapproving member');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";
    }
}
?>
