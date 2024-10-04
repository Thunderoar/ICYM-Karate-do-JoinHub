<?php
require '../../include/db_conn.php';
page_protect();

//$planid  = $_POST['name'];
// Check if the plan ID is provided
if (isset($_POST['name'])) {
    $planid = $_POST['name'];

    // Check if the plan ID is the core plan
    if ($planid === 'XTWIOL') {
        echo "<html><head><script>alert('You cannot delete a core plan');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
    } else {
        // Step 1: Get all image paths associated with the plan
        $sql = "SELECT image_path FROM images WHERE planid = '$planid'";
        $result = mysqli_query($con, $sql);

        // Step 2: Delete each image file from the server
        while ($row = mysqli_fetch_assoc($result)) {
            $image_path = $row['image_path'];
            if (file_exists($image_path)) {
                unlink($image_path); // Delete the file
            }
        }

        // Step 3: Delete images from the database
        $sql = "DELETE FROM images WHERE planid = '$planid'";
        mysqli_query($con, $sql);

        // Step 4: Delete the plan from the database
        $sql = "DELETE FROM plan WHERE planid = '$planid'";
        if (mysqli_query($con, $sql)) {
            echo "<head><script>alert('Plan and associated images deleted successfully.');</script></head></html>";
            echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
        } else {
            echo "<head><script>alert('Error deleting plan or images.');</script></head></html>";
            echo "error: " . mysqli_error($con);
        }
    }
} else {
    echo "<head><script>alert('No plan ID provided.');</script></head></html>";
}

//
//elseif (strlen($planid ) > 0) {
//    mysqli_query($con, "update plan set active ='no' WHERE planid='$planid '");
//    echo "<html><head><script>alert('Plan Deleted');</script></head></html>";
//    echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
//} else {
//    echo "<html><head><script>alert('ERROR! Delete Opertaion Unsucessfull');</script></head></html>";
//  echo "error".mysqli_error($con);
//}

?>
