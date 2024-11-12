<?php
session_start();
require '../../include/db_conn.php';

$admin_username = $_SESSION['adminid'];
$entered_password = $_POST['password'];

// Fetch the hashed password for the admin
$sql = "SELECT pass_key FROM admin WHERE username = '$admin_username'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $stored_password = $row['pass_key'];

    // Verify password (assuming the password is hashed)
    if (password_verify($entered_password, $stored_password)) {
        echo "success";
    } else {
        echo "fail";
    }
} else {
    echo "fail";
}
?>
