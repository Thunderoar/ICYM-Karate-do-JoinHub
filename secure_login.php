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

    // Join the login, admin, and images tables to get relevant information
    $sql = "
        SELECT l.*, a.adminid, a.username, i.image_path 
        FROM login l
        JOIN admin a ON l.adminid = a.adminid
        LEFT JOIN images i ON i.adminid = a.adminid
        WHERE l.username = '$user_id_auth' AND l.pass_key = '$pass_key'
    ";

    $result = mysqli_query($con, $sql);
    $count  = mysqli_num_rows($result);

    if ($count == 1) {
        // Fetch the user's data along with their admin and image information
        $row = mysqli_fetch_assoc($result);

        session_start();
        // Store session data
        $_SESSION['adminid']        = $row['adminid'];
        $_SESSION['user_data']      = $user_id_auth;
        $_SESSION['logged']         = "start";
        $_SESSION['authority']      = $row['authority'];
        $_SESSION['full_name']      = $row['admin_name'];
        $_SESSION['username']       = $row['username'];
        $_SESSION['profile_pic']    = $row['image_path'];  // Store image URL from the images table
        $auth_l_x                   = $_SESSION['authority'];

        // Redirect based on the user's authority level
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
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    }
}
?>
