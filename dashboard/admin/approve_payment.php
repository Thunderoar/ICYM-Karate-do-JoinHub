<?php
require '../../include/db_conn.php';
page_protect();

$memID = $_POST['userID'];
$plan = $_POST['planID'];
$et_id = $_POST['et_id'];

// Default expire date for all plans.
$expire_date = '9999-12-31'; // Arbitrary future date for lifetime plans.

// Proceed with the update query to approve the payment
$query = "UPDATE enrolls_to 
          SET hasPaid='yes', hasApproved='yes', paid_date=NOW(), expire='$expire_date'
          WHERE userid='$memID' AND planid='$plan' AND et_id='$et_id'";

if (mysqli_query($con, $query)) {
    echo "<head><script>alert('Payment successfully approved.');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=payments.php'>";
} else {
    echo "<head><script>alert('Payment approval failed: " . mysqli_error($con) . "');</script></head></html>";
}
?>
