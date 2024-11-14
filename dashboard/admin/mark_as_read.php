<?php
include '../../include/db_conn.php';

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    // Update the read_status to 1 (mark as read)
    $sql = "UPDATE contact_messages SET read_status = 1 WHERE message_id = '$message_id'";
    if ($con->query($sql) === TRUE) {
        echo "Message marked as read.";
    } else {
        echo "Error updating record: " . $con->error;
    }

    // Redirect back to the message center after updating
    header("Location: messageCenter.php");  // Replace with the actual page name
    exit;
}
?>
