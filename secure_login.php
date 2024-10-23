<?php
include './include/db_conn.php';

// Assuming the session is already started during login
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id_auth = ltrim($_POST['user_id_auth']);
$user_id_auth = rtrim($_POST['user_id_auth']);
$pass_key = ltrim($_POST['pass_key']);
$pass_key = rtrim($_POST['pass_key']);
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

    // Check if this is an admin or coach login page (using a flag or different form input)
    $is_admin_login = isset($_POST['is_admin_login']) && $_POST['is_admin_login'] == 1;
    $is_coach_login = isset($_POST['is_coach_login']) && $_POST['is_coach_login'] == 1;

    if ($is_admin_login) {
        // Admin login query
        $sql = "SELECT a.adminid, a.username, 'admin' as authority, i.image_path
                FROM admin a
                LEFT JOIN images i ON i.adminid = a.adminid
                WHERE a.username = '$user_id_auth' AND a.pass_key = '$pass_key'";
    } elseif ($is_coach_login) {
        // Coach login query with join to login table
        $sql = "SELECT l.loginid, l.authority, l.username, l.userid, l.adminid, l.staffid, i.image_path
                FROM login l
                LEFT JOIN images i ON l.staffid = i.staffid
                WHERE l.username = '$user_id_auth' AND l.pass_key = '$pass_key' AND l.authority = 'coach'";
    } else {
        // Member (user) login query with join to enrolls_to and plan tables
$sql = "
    SELECT u.userid, u.username, 'member' AS authority, i.image_path, 
           e.planid, p.planName, p.description, p.planType, p.validity, p.amount
    FROM users u
    LEFT JOIN images i ON i.userid = u.userid
    LEFT JOIN enrolls_to e ON e.userid = u.userid
    LEFT JOIN plan p ON p.planid = e.planid
    WHERE u.username = '$user_id_auth' AND u.pass_key = '$pass_key' 
    AND e.et_id = (
        SELECT MAX(et.et_id) 
        FROM enrolls_to et 
        WHERE et.userid = u.userid
    )";

    }

    $result = mysqli_query($con, $sql);
    $count  = mysqli_num_rows($result);

    if ($count == 1) {
        // Fetch the user's or admin's data
        $row = mysqli_fetch_assoc($result);

        // Store session data based on whether it's an admin, member, or coach login
        session_start();
        if ($is_admin_login) {
            $_SESSION['adminid'] = $row['adminid'];
            $_SESSION['is_admin_logged_in'] = true; // Set the session variable for admin
        } elseif ($is_coach_login) {
            $_SESSION['staffid'] = $row['staffid']; // Store coach's staff ID
        } else {
            $_SESSION['userid']   = $row['userid'];   // Store logged-in user's ID
            $_SESSION['planid']   = $row['planid'];   // Store the user's planid from enrolls_to
            $_SESSION['planName'] = $row['planName']; // Store the plan's name
            $_SESSION['amount']   = $row['amount'];   // Store the plan's amount
            $_SESSION['planType'] = $row['planType']; // Store the plan's type
            $_SESSION['validity'] = $row['validity']; // Store the plan's validity
        }

        $_SESSION['user_data']      = $row['username'];  // Store username in session
        $_SESSION['logged']         = "start";
        $_SESSION['authority']      = $row['authority']; // 'admin', 'member', or 'coach'
        $_SESSION['username']       = $row['username'];  // Username from the session
        $_SESSION['profile_pic']    = $row['image_path'];  // Store image URL from the images table

        // Redirect based on the user's or admin's authority level
        if ($_SESSION['authority'] == "admin") {
            header("location: index.php");
        } elseif ($_SESSION['authority'] == "member") {
            header("location: index.php");
        } elseif ($_SESSION['authority'] == "coach") {
            header("location: index.php");
        } else {
            echo "<html><head><script>alert('Invalid Authority');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        }
    } else {
        echo "<html><head><script>alert('Username OR Password is Invalid');</script></head></html>";
        // Redirect based on whether it was an admin, coach, or user login
        if ($is_admin_login) {
            echo "<meta http-equiv='refresh' content='0; url=login-admin.php'>";  // Redirect to admin login page
        } elseif ($is_coach_login) {
            echo "<meta http-equiv='refresh' content='0; url=login-coach.php'>";  // Redirect to coach login page
        } else {
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";  // Redirect to the user login page (homepage)
        }
    }
}
?>
