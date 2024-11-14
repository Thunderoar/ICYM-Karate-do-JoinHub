<?php
require '../../include/db_conn.php';

$key = trim($_POST['login_key']);
$password = trim($_POST['pwfield']);
$user_id_auth = trim($_POST['login_id']);
$password_confirm = trim($_POST['confirmfield']);

if ($password === $password_confirm) {
    if (!empty($user_id_auth) && !empty($password) && !empty($key)) {
        $sql = "SELECT * FROM staff WHERE username='$user_id_auth'";
        $result = mysqli_query($con, $sql);
        
        if ($result && mysqli_num_rows($result) === 1) {
            // Update staff table
            $update_staff_sql = "UPDATE staff SET pass_key='$password' WHERE username='$user_id_auth'";
            if (mysqli_query($con, $update_staff_sql)) {
                // Update securekey in login table
                $update_login_sql = "UPDATE login SET securekey='$key' WHERE username='$user_id_auth'";
                if (mysqli_query($con, $update_login_sql)) {
                    echo "<html><head><script>alert('Profile Updated');</script></head></html>";
                    echo "<meta http-equiv='refresh' content='0; url=more-userprofile.php'>";
                } else {
                    echo "<html><head><script>alert('Failed to update secure key');</script></head></html>";
                    echo "Error: " . mysqli_error($con);
                }
            } else {
                echo "<html><head><script>alert('Failed to update profile');</script></head></html>";
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "<html><head><script>alert('User not found');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=change_pwd.php'>";
        }
    } else {
        echo "<html><head><script>alert('Missing required fields');</script></head></html>";
    }
} else {
    echo "<html><head><script>alert('Confirm Password Mismatch');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=change_pwd.php'>";
}
?>

<center>
    <img src="loading.gif">
</center>
