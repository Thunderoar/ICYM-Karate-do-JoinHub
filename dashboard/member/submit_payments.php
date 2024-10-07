<?php
require '../../include/db_conn.php';
page_protect();

$memID = $_POST['m_id'];
$plan = $_POST['plan'];

// Update renewal status to 'no' for the existing plan in enrolls_to table
$query = "UPDATE enrolls_to SET renewal='no' WHERE userid='$memID'";
if (mysqli_query($con, $query)) {

    // Check if the new plan already exists for this user
    $check_query = "SELECT * FROM enrolls_to WHERE userid='$memID' AND planid='$plan'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If a record exists, avoid duplicate entry
        echo "<head><script>alert('Plan already exists for this user. No new entry created.');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=payments.php'>";
    } else {
        // Fetch the plan details from the plan table
        $query1 = "SELECT * FROM plan WHERE planid='$plan'";
        $result = mysqli_query($con, $query1);

        if ($result) {
            $value = mysqli_fetch_row($result);
            date_default_timezone_set("Asia/Calcutta"); 
            $d = strtotime("+" . $value[3] . " Months");
            $cdate = date("Y-m-d"); // current date
            $expiredate = date("Y-m-d", $d); // expiry date based on plan duration

            // Insert the new enrollment data for the user if no duplicate is found
            $query2 = "INSERT INTO enrolls_to(planid, userid, paid_date, expire, renewal) VALUES('$plan', '$memID', '$cdate', '$expiredate', 'yes')";
            if (mysqli_query($con, $query2)) {
                echo "<head><script>alert('Payment Successfully updated');</script></head></html>";
                echo "<meta http-equiv='refresh' content='0; url=payments.php'>";
            } else {
                echo "<head><script>alert('Payment update Failed');</script></head></html>";
                echo "error: " . mysqli_error($con);
            }
        } else {
            echo "<head><script>alert('Payment update Failed');</script></head></html>";
            echo "error: " . mysqli_error($con);
        }
    }
} else {
    echo "<head><script>alert('Payment update Failed');</script></head></html>";
    echo "error: " . mysqli_error($con);
}
?>
