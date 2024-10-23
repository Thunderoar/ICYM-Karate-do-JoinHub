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

        // Execute the query and check for success
        if (mysqli_query($con, $query)) {
            echo "<head><script>alert('Payment successfully undone.');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=payments.php'>"; // Redirect to the view_plan page
        } else {
            // Handle query failure and display error
            echo "<head><script>alert('Failed to undo payment: " . mysqli_error($con) . "');</script></head></html>";
        }
    } else {
        // Handle case when either userid or planid is not set
        echo "<head><script>alert('Invalid input. User ID or Plan ID missing.');</script></head></html>";
    }
} else {
    // Handle invalid request method
    echo "<head><script>alert('Invalid request.');</script></head></html>";
}
?>
