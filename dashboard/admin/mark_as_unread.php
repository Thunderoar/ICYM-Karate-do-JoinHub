<?php
include '../../include/db_conn.php';

// Get the message ID from the URL
$message_id = $_GET['id'];

// Update read_status to 0 (or NULL) to mark as unread
$updateQuery = "UPDATE contact_messages SET read_status = 0 WHERE message_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("i", $message_id);
$stmt->execute();

// Redirect back to the message center page
header("Location: messageCenter.php");
exit();
?>
