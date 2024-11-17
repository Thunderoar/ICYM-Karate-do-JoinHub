<?php
require '../../include/db_conn.php';
page_protect();

// Capture form data
$uid = $_POST['uid'];
$uname = $_POST['uname'];
$no_ic = $_POST['no_ic'];
$matrixNumber = $_POST['matrixNumber'];
$gender = $_POST['gender'];
$mobile = $_POST['phone'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$jdate = $_POST['jdate'];
$stname = $_POST['stname'];
$state = $_POST['state'];
$city = $_POST['city'];
$zipcode = $_POST['zipcode'];
// $calorie = $_POST['calorie'];
$height = $_POST['height'];
$weight = $_POST['weight'];
// $fat = $_POST['fat'];
$remarks = $_POST['remarks'];

// Update users table
$query1 = "
    UPDATE users 
    SET username = '$uname',
        gender = '$gender',
        mobile = '$mobile',
        no_ic = '$no_ic',
        matrixNumber = '$matrixNumber',
        email = '$email',
        dob = '$dob',
        joining_date = '$jdate' 
    WHERE userid = '$uid'
";

if (mysqli_query($con, $query1)) {
    // Update address table
    $query2 = "
        UPDATE address 
        SET streetName = '$stname',
            state = '$state',
            city = '$city',
            zipcode = '$zipcode' 
        WHERE userid = '$uid'
    ";

    if (mysqli_query($con, $query2)) {
        // Update health_status table
        $query3 = "
            UPDATE health_status 
            SET calorie = '1',
                height = '$height',
                weight = '$weight',
                fat = '1',
                remarks = '$remarks' 
            WHERE userid = '$uid'
        ";

        if (mysqli_query($con, $query3)) {
            // Success: Redirect with a success message
            echo "<html><head><script>alert('Member updated successfully');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";
        } else {
            // Error in health_status update
            logError(mysqli_error($con));
            echo "<html><head><script>alert('ERROR! Health metrics update failed');</script></head></html>";
        }
    } else {
        // Error in address update
        logError(mysqli_error($con));
        echo "<html><head><script>alert('ERROR! Address update failed');</script></head></html>";
    }
} else {
    // Error in users update
    logError(mysqli_error($con));
    echo "<html><head><script>alert('ERROR! User details update failed');</script></head></html>";
}

// Function to log errors
function logError($errorMessage)
{
    $logFile = '../../logs/error_log.txt';
    $currentDateTime = date('Y-m-d H:i:s');
    $logMessage = "[$currentDateTime] $errorMessage" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>
