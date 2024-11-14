<?php
require '../../include/db_conn.php';
page_protect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required keys are set
    if (isset($_POST['et_id']) && isset($_POST['userID'])) {
        $et_id = mysqli_real_escape_string($con, $_POST['et_id']);
        $userID = mysqli_real_escape_string($con, $_POST['userID']);

        // Update the `enrolls_to` table to set hasPaid to 'no'
        $updateQuery = "UPDATE enrolls_to SET hasPaid='no' WHERE et_id='$et_id' AND userid='$userID'";
        
        if (mysqli_query($con, $updateQuery)) {
            // Redirect to the appropriate directory with a success message
            if (isset($_SESSION['is_admin_logged_in'])) {
                header("Location: ../../dashboard/admin/payments.php?message=Payment canceled successfully.");
            } elseif (isset($_SESSION['is_coach_logged_in'])) {
                header("Location: ../../dashboard/coach/payments.php?message=Payment canceled successfully.");
            }
            exit();
        } else {
            // Redirect to the appropriate directory with an error message
            if (isset($_SESSION['is_admin_logged_in'])) {
                header("Location: ../../dashboard/admin/payments.php?message=Error canceling payment.");
            } elseif (isset($_SESSION['is_coach_logged_in'])) {
                header("Location: ../../dashboard/coach/payments.php?message=Error canceling payment.");
            }
            exit();
        }
    } else {
        // Redirect to the appropriate directory with a missing data message
        if (isset($_SESSION['is_admin_logged_in'])) {
            header("Location: ../../dashboard/admin/payments.php?message=Required data is missing.");
        } elseif (isset($_SESSION['is_coach_logged_in'])) {
            header("Location: ../../dashboard/coach/payments.php?message=Required data is missing.");
        }
        exit();
    }
} else {
    // Redirect to the appropriate directory with an invalid request message
    if (isset($_SESSION['is_admin_logged_in'])) {
        header("Location: ../../dashboard/admin/payments.php?message=Invalid request method.");
    } elseif (isset($_SESSION['is_coach_logged_in'])) {
        header("Location: ../../dashboard/coach/payments.php?message=Invalid request method.");
    }
    exit();
}
?>
