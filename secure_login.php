<?php
include './include/db_conn.php';

$user_id_auth = ltrim($_POST['user_id_auth']);
$user_id_auth = rtrim($user_id_auth);

$pass_key = ltrim($_POST['pass_key']);
$pass_key = rtrim($pass_key);

$user_id_auth = stripslashes($user_id_auth);
$pass_key     = stripslashes($pass_key);

if ($pass_key == "" &&  $user_id_auth == "") {
    echo "<head><script>alert('Username and Password cannot be empty');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
} elseif ($pass_key == "") {
    echo "<head><script>alert('Password cannot be empty');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
} elseif ($user_id_auth == "") {
    echo "<head><script>alert('Username cannot be empty');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
} else {
    // Escape the input to prevent SQL injection
    $user_id_auth = mysqli_real_escape_string($con, $user_id_auth);
    $pass_key     = mysqli_real_escape_string($con, $pass_key);

    // Check if this is an admin login page (using a flag or different form input)
    $is_admin_login = isset($_POST['is_admin_login']) && $_POST['is_admin_login'] == 1;

    if ($is_admin_login) {
        // Admin login query
        $sql = "
            SELECT a.adminid, a.username, 'admin' as authority, i.image_path
            FROM admin a
            LEFT JOIN images i ON i.adminid = a.adminid
            WHERE a.username = '$user_id_auth' AND a.pass_key = '$pass_key'
        ";
    } else {
        // User login query
        $sql = "
            SELECT u.userid, u.username, 'member' as authority, i.image_path
            FROM users u
            LEFT JOIN images i ON i.userid = u.userid
            WHERE u.username = '$user_id_auth' AND u.pass_key = '$pass_key'
        ";
    }

    $result = mysqli_query($con, $sql);
    $count  = mysqli_num_rows($result);

    if ($count == 1) {
        // Fetch the user's or admin's data
        $row = mysqli_fetch_assoc($result);

        session_start();
        // Store session data
        if ($is_admin_login) {
            $_SESSION['adminid'] = $row['adminid'];
        } else {
            $_SESSION['userid'] = $row['userid'];
        }
        $_SESSION['user_data']      = $user_id_auth;
        $_SESSION['logged']         = "start";
        $_SESSION['authority']      = $row['authority'];
        $_SESSION['username']       = $row['username'];
        $_SESSION['profile_pic']    = $row['image_path'];  // Store image URL from the images table
        $auth_l_x                   = $_SESSION['authority'];

        // Redirect based on the user's or admin's authority level
        if ($auth_l_x == "admin") {
            header("location: ./dashboard/admin/");
        } elseif ($auth_l_x == "member") {
            header("location: ./dashboard/member/");
        } else {
            echo "<html><head><script>alert('Invalid Authority');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        }
    } else {
        echo "<html><head><script>alert('Username OR Password is Invalid');</script></head></html>";
        
        // Redirect based on whether it was an admin or user login
        if ($is_admin_login) {
            echo "<meta http-equiv='refresh' content='0; url=login-admin.php'>";  // Redirect to admin login page
        } else {
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";  // Redirect to the user login page (homepage)
        }
    }
}
?>
