<?php
require '../../include/db_conn.php';
page_protect();

$memID = $_POST['userID'];
$plan = $_POST['planID'];
$et_id = $_POST['et_id'];

// Default expire date for all plans
$expire_date = '9999-12-31';

// Proceed with the update query to approve the payment
$updateQuery = "UPDATE enrolls_to 
                SET hasPaid='yes', hasApproved='yes', paid_date=NOW(), expire='$expire_date'
                WHERE userid='$memID' AND planid='$plan' AND et_id='$et_id'";

// Insert into event_members table
$insertQuery = "INSERT INTO event_members (planid, userid, joined_at)
                VALUES ('$plan', '$memID', NOW())";

if (mysqli_query($con, $updateQuery) && mysqli_query($con, $insertQuery)) {
    echo "<head><script>alert('Payment successfully approved.');</script></head></html>";

    // Redirect to the appropriate directory based on session
    if (isset($_SESSION['is_admin_logged_in'])) {
        echo "<meta http-equiv='refresh' content='0; url=../../dashboard/admin/payments.php'>";
    } elseif (isset($_SESSION['is_coach_logged_in'])) {
        echo "<meta http-equiv='refresh' content='0; url=../../dashboard/coach/payments.php'>";
    }
} else {
    echo "<head><script>alert('Payment approval failed: " . mysqli_error($con) . "');</script></head></html>";

    // Redirect to the appropriate directory with an error message
    if (isset($_SESSION['is_admin_logged_in'])) {
        echo "<meta http-equiv='refresh' content='0; url=../../dashboard/admin/payments.php'>";
    } elseif (isset($_SESSION['is_coach_logged_in'])) {
        echo "<meta http-equiv='refresh' content='0; url=../../dashboard/coach/payments.php'>";
    }
}
?>
