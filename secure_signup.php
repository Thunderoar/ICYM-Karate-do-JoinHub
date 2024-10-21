<?php
require 'include/db_conn.php';

// Retrieve form data and escape input to prevent SQL injection
$memID = mysqli_real_escape_string($con, $_POST['m_id']);
$healthID = mysqli_real_escape_string($con, $_POST['h_id']);
$addressID = mysqli_real_escape_string($con, $_POST['address_id']);
$uname = mysqli_real_escape_string($con, $_POST['u_name']);
$stname = mysqli_real_escape_string($con, $_POST['street_name']);
$city = mysqli_real_escape_string($con, $_POST['city']);
$zipCODE = mysqli_real_escape_string($con, $_POST['zipcode']);
$state = mysqli_real_escape_string($con, $_POST['state']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$dob = mysqli_real_escape_string($con, $_POST['dob']);
$phn = mysqli_real_escape_string($con, $_POST['mobile']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$jdate = mysqli_real_escape_string($con, $_POST['jdate']);
$plan = isset($_POST['plan']) && !empty($_POST['plan']) ? mysqli_real_escape_string($con, $_POST['plan']) : 'XTWIOL';
$pass_key = mysqli_real_escape_string($con, $_POST['pass_key']);
$hasApproved = mysqli_real_escape_string($con, $_POST['hasApproved']);


try {
    // Start transaction
    mysqli_begin_transaction($con);

    // Check if user already exists
    $checkUserQuery = "SELECT * FROM users WHERE userid='$memID'";
    $checkUserResult = mysqli_query($con, $checkUserQuery);
    if (mysqli_num_rows($checkUserResult) > 0) {
        throw new Exception("User already exists.");
    }

    // Insert into users table
$query = "INSERT INTO users (username, fullName, gender, mobile, email, dob, joining_date, imageid, userid, pass_key, hasApproved)
          VALUES ('$uname', '$uname', '$gender', '$phn', '$email', '$dob', '$jdate', UUID(), '$memID', '$pass_key', '$hasApproved')";
    if (!mysqli_query($con, $query)) {
        throw new Exception("User Insert Failed: " . mysqli_error($con));
    }

    // Retrieve plan information (use default if no plan selected)
    $query1 = "SELECT * FROM plan WHERE planid='$plan'";
    $result = mysqli_query($con, $query1);
    if (!$result || mysqli_num_rows($result) == 0) {
        throw new Exception("Plan not found.");
    }
    $value = mysqli_fetch_row($result);
    
    // Calculate expiration date
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $d = strtotime("+" . $value[4] . " Months"); // Validity is in the 5th column (index 4)
    $cdate = date("Y-m-d"); // Current date
    $expiredate = date("Y-m-d", $d); // Expiration date
    
    // Insert into enrolls_to table
    $query2 = "INSERT INTO enrolls_to (planid, userid, paid_date, expire, hasPaid) 
               VALUES ('$plan', '$memID', '$cdate', '$expiredate', 'no')";
    if (!mysqli_query($con, $query2)) {
        throw new Exception("Enrolls_to Insert Failed: " . mysqli_error($con));
    }
    
    // Insert into health_status table
    $query3 = "INSERT INTO health_status (healthid, userid) VALUES ('$healthID', '$memID')";
    if (!mysqli_query($con, $query3)) {
        throw new Exception("Health_status Insert Failed: " . mysqli_error($con));
    }
    
    // Insert into address table
    $query4 = "INSERT INTO address (addressid, userid, streetName, state, city, zipcode)
               VALUES ('$addressID', '$memID', '$stname', '$state', '$city', '$zipCODE')";
    if (!mysqli_query($con, $query4)) {
        throw new Exception("Address Insert Failed: " . mysqli_error($con));
    }

    // Insert into login table
    $query5 = "INSERT INTO login (loginid, userid, username, pass_key, securekey, authority)
               VALUES (UUID(), '$memID', '$uname', '$pass_key', UUID(), 'member')";
    if (!mysqli_query($con, $query5)) {
        throw new Exception("Login Insert Failed: " . mysqli_error($con));
    }

    // Image upload handling
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "uploads/user_profile/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $uploadOk = 1; // Variable to track upload status
        $target_file = ""; // Initialize the target file variable
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                throw new Exception("File is not an image.");
            }
            if (file_exists($target_file)) {
                throw new Exception("Sorry, file already exists.");
            }
            if ($_FILES["image"]["size"] > 5000000) {
                throw new Exception("Sorry, your file is too large.");
            }
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            }
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    chmod($target_file, 0777);
                    // Insert the image path into the images table
                    $sql = "INSERT INTO images (imageid, userid, image_path) VALUES (UUID(), '$memID', '$target_file')";
                    if (!mysqli_query($con, $sql)) {
                        throw new Exception("Image Insert Failed: " . mysqli_error($con));
                    }
                } else {
                    throw new Exception("Sorry, there was an error uploading your file.");
                }
            }
        } else {
            // Proceed without image
            $sql = "INSERT INTO images (imageid, userid, image_path) VALUES (UUID(), '$memID', NULL)";
            if (!mysqli_query($con, $sql)) {
                throw new Exception("Image Insert Failed: " . mysqli_error($con));
            }
        }
    }

    // Commit the transaction
    mysqli_commit($con);
    echo "<script>alert('Member Added Successfully');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
} catch (Exception $e) {
    // Rollback the transaction in case of error
    mysqli_rollback($con);
    // Log error and show user-friendly message
    error_log($e->getMessage());
    echo "<script>alert('Member Addition Failed: " . $e->getMessage() . "');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}
?>
