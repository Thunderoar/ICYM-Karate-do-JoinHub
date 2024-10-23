<?php
require '../../include/db_conn.php';
page_protect();

$id = $_POST['planid'];
$pname = $_POST['planname'];
$pdesc = $_POST['desc'];
$plantype = $_POST['plantype'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$duration = $_POST['duration'];
$pval = $_POST['planval'];
$pamt = $_POST['amount'];
$origin = $_POST['origin'];

$query1 = "UPDATE plan SET 
                planName = '$pname', 
                description = '$pdesc', 
                planType = '$plantype',
                startDate = '$startdate',
                endDate = '$enddate',
                duration = '$duration',
                validity = '$pval', 
                amount = '$pamt' 
            WHERE planid = '$id'";

if (mysqli_query($con, $query1)) {
    echo "<html><head><script>alert('PLAN Updated Successfully');</script></head></html>";

    // Redirect based on the origin of the request
    if ($origin === 'eventpage') {
        echo "<meta http-equiv='refresh' content='0; url=../../events.php'>";
    } else if ($origin === 'view_plan') {
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
    } else {
        // Default fallback
        echo "<meta http-equiv='refresh' content='0; url=../../events.php'>";
    }
} else {
    echo "<html><head><script>alert('ERROR! Update Operation Unsuccessful');</script></head></html>";
    echo "error" . mysqli_error($con);
}
?>
