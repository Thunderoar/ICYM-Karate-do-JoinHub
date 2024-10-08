<?php
require '../../include/db_conn.php';
page_protect();

 $memID=$_POST['m_id'];
 $plan=$_POST['plan'];

// Retrieve the validity first
$validity_query = "SELECT validity FROM plan WHERE planid='$plan'";
$validity_result = mysqli_query($con, $validity_query);
$validity_row = mysqli_fetch_assoc($validity_result);
$validity = $validity_row['validity'] ?? null; // Default to null if no validity found

if ($validity !== null) {
    // Handle lifetime case
    if (strcasecmp($validity, 'Lifetime') == 0) {
        // For lifetime plans, set expire to NULL or a future date
        $expire_date = '9999-12-31'; // This is an arbitrary far future date
    } elseif (is_numeric($validity)) {
        // Proceed with the calculation for numeric validity
        $expire_date = "DATE_ADD(NOW(), INTERVAL $validity MONTH)";
    } else {
        echo "<head><script>alert('Invalid plan validity.');</script></head></html>";
        exit; // Stop execution if validity is not valid
    }

    // Proceed with the update query
    $query = "UPDATE enrolls_to 
              SET hasPaid='yes', paid_date=NOW(), 
                  expire=$expire_date 
              WHERE userid='$memID' AND planid='$plan'";

    if (mysqli_query($con, $query)) {
        echo "<head><script>alert('Payment successfully updated.');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=payments.php'>";
    } else {
        echo "<head><script>alert('Payment update failed');</script></head></html>";
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "<head><script>alert('Invalid plan validity.');</script></head></html>";
}

?>
