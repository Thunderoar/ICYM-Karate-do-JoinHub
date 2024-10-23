<?php
// Assume you have already established a database connection in $con
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
            // Redirect to a success page or back to the previous page
            header("Location: payments.php?message=Payment canceled successfully.");
            exit(); // Make sure to call exit after header to prevent further script execution
        } else {
			header("Location: payments.php?message=Error canceling payment.");
			exit(); // Make sure to call exit after header to prevent further script execution
        }
    } else {
		header("Location: payments.php?message=Required data is missing.");
		exit(); // Make sure to call exit after header to prevent further script execution
    }
} else {
	header("Location: payments.php?message=Invalid request method.");
	exit(); // Make sure to call exit after header to prevent further script execution
}
?>
