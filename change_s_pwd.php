<?php
// include database connection
include './include/db_conn.php';

// Get and sanitize POST data
$key = rtrim($_POST['login_key']);
$pass = rtrim($_POST['pwfield']);
$user_id_auth = rtrim($_POST['login_id']);
$passconfirm = rtrim($_POST['confirmfield']);

if ($pass == $passconfirm) {
    if (isset($user_id_auth) && isset($pass) && isset($key)) {
        // Check if user/admin exists in the 'login' table
        $login_query = "SELECT * FROM login WHERE username='$user_id_auth' AND securekey='$key'";
        $login_result = mysqli_query($con, $login_query);
        $login_count = mysqli_num_rows($login_result);

        if ($login_count == 1) {
            // Fetch the user's authority level (admin, user, or staff)
            $login_data = mysqli_fetch_assoc($login_result);
            $authority = $login_data['authority'];

            // Update the password in the login table
            mysqli_query($con, "UPDATE login SET pass_key='$pass' WHERE username='$user_id_auth'");

            // Update the password in the corresponding tables based on authority level
            if ($authority == 'user') {
                mysqli_query($con, "UPDATE users SET pass_key='$pass' WHERE username='$user_id_auth'");
            } elseif ($authority == 'staff') {
                mysqli_query($con, "UPDATE staff SET pass_key='$pass' WHERE username='$user_id_auth'");
            } elseif ($authority == 'admin') {
                mysqli_query($con, "UPDATE admin SET pass_key='$pass' WHERE username='$user_id_auth'");
            }

            // Redirect and alert based on authority
            if ($authority == 'admin') {
                echo "<html><head><script>alert('Admin Password Updated. Please Login Again');</script></head></html>";
            } else {
                echo "<html><head><script>alert('User Password Updated. Please Login Again');</script></head></html>";
            }
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        } else {
            // If no user/admin found with the given credentials
            echo "<html><head><script>alert('Change Unsuccessful. Invalid Credentials');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=forgot_password.php'>";
        }
    } else {
        // If required data is missing
        echo "<html><head><script>alert('Change Unsuccessful. Please fill all fields');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=forgot_password.php'>";
    }
} else {
    // If the confirmation password does not match
    echo "<html><head><script>alert('Confirm Password Mismatch');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=forgot_password.php'>";
}
?>
<center>
<img src="loading.gif">
</center>
