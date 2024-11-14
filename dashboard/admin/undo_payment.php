<?php
require '../../include/db_conn.php';
page_protect();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user ID and plan ID from the form
    $userid = $_POST['userID'];
    $planid = $_POST['planID'];

    // Ensure both values are set and not empty
    if (!empty($userid) && !empty($planid)) {
        // Update the 'enrolls_to' table to undo the payment
        $query = "UPDATE enrolls_to 
                  SET hasPaid = 'yes', paid_date = NULL, expire = NULL, hasApproved = 'no'
                  WHERE userid = '$userid' AND planid = '$planid'";

        // Remove entry from 'event_members' table
        $deleteQuery = "DELETE FROM event_members 
                        WHERE planid = '$planid' AND userid = '$userid'";

        // Execute the queries and check for success
        if (mysqli_query($con, $query) && mysqli_query($con, $deleteQuery)) {
            echo "<head><script>alert('Payment successfully undone.');</script></head></html>";
            
            // Redirect to the appropriate directory based on session
            if (isset($_SESSION['is_admin_logged_in'])) {
                echo "<meta http-equiv='refresh' content='0; url=../../dashboard/admin/payments.php'>";
            } elseif (isset($_SESSION['is_coach_logged_in'])) {
                echo "<meta http-equiv='refresh' content='0; url=../../dashboard/coach/payments.php'>";
            }
        } else {
            // Handle query failure and display error
            echo "<head><script>alert('Failed to undo payment: " . mysqli_error($con) . "');</script></head></html>";
            
            // Redirect to the appropriate directory with an error message
            if (isset($_SESSION['is_admin_logged_in'])) {
                echo "<meta http-equiv='refresh' content='0; url=../../dashboard/admin/payments.php'>";
            } elseif (isset($_SESSION['is_coach_logged_in'])) {
                echo "<meta http-equiv='refresh' content='0; url=../../dashboard/coach/payments.php'>";
            }
        }
    } else {
        // Handle case when either userid or planid is not set
        echo "<head><script>alert('Invalid input. User ID or Plan ID missing.');</script></head></html>";
        
        // Redirect to the appropriate directory with an error message
        if (isset($_SESSION['is_admin_logged_in'])) {
            echo "<meta http-equiv='refresh' content='0; url=../../dashboard/admin/payments.php'>";
        } elseif (isset($_SESSION['is_coach_logged_in'])) {
            echo "<meta http-equiv='refresh' content='0; url=../../dashboard/coach/payments.php'>";
        }
    }
} else {
    // Handle invalid request method
    echo "<head><script>alert('Invalid request.');</script></head></html>";
    
    // Redirect to the appropriate directory with an error message
    if (isset($_SESSION['is_admin_logged_in'])) {
        echo "<meta http-equiv='refresh' content='0; url=../../dashboard/admin/payments.php'>";
    } elseif (isset($_SESSION['is_coach_logged_in'])) {
        echo "<meta http-equiv='refresh' content='0; url=../../dashboard/coach/payments.php'>";
    }
}
?>
