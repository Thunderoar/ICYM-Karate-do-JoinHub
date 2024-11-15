<?php
include './include/db_conn.php';

// Assuming the session is already started during login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = json_decode(file_get_contents('php://input'), true);
$userInputPassword = $data['password'];

// Fetch the actual password from the database based on userid
$query = "SELECT pass_key FROM login WHERE userid = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($actualPassword);
$stmt->fetch();
$stmt->close();

// Verify the user input password with the actual password
$response = array('verified' => password_verify($userInputPassword, $actualPassword));

echo json_encode($response);
?>
