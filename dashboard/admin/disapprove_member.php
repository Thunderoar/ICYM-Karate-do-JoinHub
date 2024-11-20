<?php
require '../../include/db_conn.php';
page_protect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userid'], $_POST['reason'])) {
    $userid = mysqli_real_escape_string($con, $_POST['userid']);
    $reason = mysqli_real_escape_string($con, trim($_POST['reason']));

    if (empty($reason)) {
        echo "<script>alert('Disapproval reason is required.'); window.history.back();</script>";
        exit;
    }

    // Start transaction
    mysqli_begin_transaction($con);

    try {
        // Update user status to disapproved
        $updateQuery = "UPDATE users SET hasApproved='No' WHERE userid='$userid'";
        if (!mysqli_query($con, $updateQuery)) {
            throw new Exception('Error updating user status.');
        }

        // Insert the disapproval reason
        $adminId = $_SESSION['adminid']; // Assuming `$_SESSION['admin_id']` holds the admin's ID
        $insertQuery = "INSERT INTO disapproval_reasons (userid, adminid, reason) VALUES ('$userid', '$adminId', '$reason')";
        if (!mysqli_query($con, $insertQuery)) {
            throw new Exception('Error inserting disapproval reason.');
        }

        // Commit transaction
        mysqli_commit($con);

        echo "<script>alert('Member disapproved successfully with reason saved.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";

    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($con);
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
