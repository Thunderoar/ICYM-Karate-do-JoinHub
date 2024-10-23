<?php
require '../../include/db_conn.php';
page_protect();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $userid = $_POST['userid'];
    $planid = $_POST['planid'];
    
    // Ensure both values are set
    if (isset($userid) && isset($planid)) {
        // Check if the user is already enrolled in the plan
        $check_query = "SELECT * FROM enrolls_to WHERE userid = '$userid' AND planid = '$planid'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) == 0) {
            // If not already enrolled, insert the enrollment record
            $insert_query = "INSERT INTO enrolls_to (userid, planid, expire, hasPaid) 
            VALUES ('$userid', '$planid', DATE_ADD(NOW(), INTERVAL 1 MONTH), 'no')";
            if (mysqli_query($con, $insert_query)) {
                // Redirect on successful enrollment
                header("Location: payments.php?msg=Enrollment successful!");
                exit();
            } else {
                // Redirect on error
                header("Location: payments.php?msg=Error enrolling user: " . mysqli_error($con));
                exit();
            }
        } else {
            // Redirect if user is already enrolled
            header("Location: payments.php?msg=User is already enrolled in this plan.");
            exit();
        }
    } else {
        // Redirect if invalid input
        header("Location: payments.php?msg=Invalid input. Please try again.");
        exit();
    }
} else {
    // Redirect for invalid request
    header("Location: payments.php?msg=Invalid request.");
    exit();
}
?>
