<?php
require '../../include/db_conn.php';
page_protect();

$memID = $_POST['m_id'];
$plan = $_POST['plan'];

// Default expire date for all plans.
// If you have specific expire dates based on plan types, adjust accordingly.
$expire_date = '9999-12-31'; // Arbitrary future date for lifetime plans.

// Proceed with the update query
$query = "UPDATE enrolls_to 
          SET hasPaid='yes', paid_date=NOW(), 
              expire='$expire_date' 
          WHERE userid='$memID' AND planid='$plan'";

if (mysqli_query($con, $query)) {
    echo "<head><script>alert('Payment successfully updated.');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=payments.php'>";
} else {
    echo "<head><script>alert('Payment update failed: " . mysqli_error($con) . "');</script></head></html>";
}
?>