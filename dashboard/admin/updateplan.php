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
n exists before updating
    $check_query = "SELECT planid FROM plan WHERE planid='$id'";
    $check_result = mysqli_query($con, $check_query);
    
    if (mysqli_num_rows($check_result) == 0) {
        echo "<html><head><script>alert('ERROR! Plan ID not found in database');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=../../events.php'>";
        exit;
    }

    // Construct and execute update query
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
        echo "error: " . mysqli_error($con);
    }

    // Handle image upload if provided
    if (isset($_FILES['newImage']) && $_FILES['newImage']['size'] > 0) {
        $imageId = mysqli_real_escape_string($con, $_POST['imageid']);
        
        $targetDir = "uploads/";
        $fileName = basename($_FILES["newImage"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        
        // Validate file type
        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["newImage"]["tmp_name"], $targetFilePath)) {
                $imageQuery = "UPDATE images SET image_path = '$targetFilePath' WHERE imageid = '$imageId'";
                mysqli_query($con, $imageQuery);
            }
        }
    }
} else {
    echo "<html><head><script>alert('ERROR! Invalid Request Method');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=../../events.php'>";
}
?>origin) {
        case 'eventpage':
            echo "<html><head><script>alert('PLAN Updated Successfully');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=../../events.php'>";
            break;
        case 'view_plan':
            echo "<html><head><script>alert('PLAN Updated Successfully');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
            break;
        default:
            echo "<html><head><script>alert('PLAN Updated Successfully');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=../../events.php'>";
            break;
    }

} catch (Exception $e) {
    echo "<html><head><script>alert('ERROR! " . addslashes($e->getMessage()) . "');</script></head></html>";
    echo "Error: " . mysqli_error($con);
    echo "<meta http-equiv='refresh' content='2; url=../../events.php'>";
}
?>