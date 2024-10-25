<?php
require '../../include/db_conn.php';
page_protect();

$memID = $_POST['m_id'];
$plan = $_POST['plan'];

// Default expire date for all plans.
// If you have specific expire dates based on plan types, adjust accordingly.
$expire_date = '9999-12-31'; // Arbitrary future date for lifetime plans.

$target_dir = "../../dashboard/admin/uploads/payment/";
$uploadOk = 1;
$receiptIMG = "";

// Check if a file was uploaded
if (isset($_FILES['receiptIMG']) && $_FILES['receiptIMG']['error'] === UPLOAD_ERR_OK) {
    // Set the target file path
    $target_file = $target_dir . basename($_FILES["receiptIMG"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["receiptIMG"]["tmp_name"]);
    if ($check === false) {
        echo "<head><script>alert('File is not an image.');</script></head></html>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<head><script>alert('Sorry, file already exists.');</script></head></html>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["receiptIMG"]["size"] > 5000000) {
        echo "<head><script>alert('Sorry, your file is too large.');</script></head></html>";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<head><script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script></head></html>";
        $uploadOk = 0;
    }

    // Attempt to move the file to the target directory
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["receiptIMG"]["tmp_name"], $target_file)) {
            chmod($target_file, 0777); // Set permissions for the file
            $receiptIMG = $target_file; // Store the file path
        } else {
            echo "<head><script>alert('Sorry, there was an error uploading your file.');</script></head></html>";
            $uploadOk = 0;
        }
    }
} else {
    echo "<head><script>alert('No receipt uploaded, proceeding with the payment update.');</script></head></html>";
}

// Proceed with the update query if the file upload was successful or no file was uploaded
if ($uploadOk == 1) {
    $receiptIMG = !empty($receiptIMG) ? $receiptIMG : NULL; // Use NULL if no image was uploaded

    $query = "UPDATE enrolls_to 
              SET hasPaid='yes', paid_date=NOW(), expire='$expire_date', hasApproved='no', receiptIMG='$receiptIMG'
              WHERE userid='$memID' AND planid='$plan'";

    if (mysqli_query($con, $query)) {
        echo "<head><script>alert('Payment successfully updated.');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=payments.php'>";
    } else {
        echo "<head><script>alert('Payment update failed: " . mysqli_error($con) . "');</script></head></html>";
    }
} else {
    echo "<head><script>alert('Payment update aborted due to file upload error.');</script></head></html>";
}
?>
