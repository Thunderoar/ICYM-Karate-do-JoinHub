<?php
require '../../include/db_conn.php';
page_protect();

// Retrieve form data
$memID = $_POST['m_id'];
$healthID = $_POST['h_id'];
$addressID = $_POST['a_id'];
$uname = $_POST['u_name'];
$stname = $_POST['street_name'];
$city = $_POST['city'];
$zipCODE = $_POST['zipcode'];
$state = $_POST['state'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$phn = $_POST['mobile'];
$email = $_POST['email'];
$plan = $_POST['plan'];
$pass_key = $_POST['pass_key'];
$fullName = $_POST['fullName'];
$matrix_number = $_POST['matrix_number'];
$no_ic = $_POST['no_ic'];

// Set timezone and get current date (without time)
date_default_timezone_set("Asia/Kuala_Lumpur");
$joining_date = date("Y-m-d");

// Insert into users table with formatted joining_date
$query = "INSERT INTO users(username, fullName, gender, mobile, email, dob, joining_date, imageid, userid, pass_key, hasApproved, matrixNumber, no_ic) 
          VALUES ('$uname', '$uname', '$gender', '$phn', '$email', '$dob', '$joining_date', UUID(), '$memID', '$pass_key', 'No', '$matrix_number', '$no_ic')";
if (mysqli_query($con, $query)) {
    
    // Retrieve information about the selected plan
    $query1 = "SELECT * FROM plan WHERE planid='$plan'";
    $result = mysqli_query($con, $query1);

    if ($result) {
        $value = mysqli_fetch_row($result);

        // Calculate the expiration date based on the plan validity
        $d = strtotime("+" . $value[3] . " Months");
        $cdate = date("Y-m-d"); // Current date
        $expiredate = date("Y-m-d", $d); // Expiration date

        // Insert into enrolls_to table
        $query2 = "INSERT INTO enrolls_to(planid, userid, paid_date, expire, hasPaid) 
                   VALUES ('$plan', '$memID', '$cdate', '$expiredate', 'no')";
        if (mysqli_query($con, $query2)) {
            
            // Insert into health_status table
            $query4 = "INSERT INTO health_status(healthid, userid) 
                       VALUES ('$healthID', '$memID')";
            if (mysqli_query($con, $query4)) {
                
                // Insert into address table
                $query5 = "INSERT INTO address(addressid, userid, streetName, state, city, zipcode) 
                           VALUES ('$addressID', '$memID', '$stname', '$state', '$city', '$zipCODE')";
                if (mysqli_query($con, $query5)) {
                    // Address inserted successfully, proceed with login table
                    $query6 = "INSERT INTO login(loginid, userid, username, pass_key, securekey, authority) 
                              VALUES (UUID(), '$memID', '$uname', '$pass_key', UUID(), 'member')";
                    if (mysqli_query($con, $query6)) {
                        // Handle image upload
                        handleImageUpload($con, $memID);
                        
                        // Success message
                        echo "<head><script>alert('Member Added Successfully');</script></head></html>";
                        echo "<meta http-equiv='refresh' content='0; url=new_entry.php'>";
                    } else {
                        // Login insert failed
                        handleErrorAndRollback("login", $memID);
                    }
                } else {
                    // Address insert failed
                    handleErrorAndRollback("address", $memID);
                }
            } else {
                // Health status insert failed
                handleErrorAndRollback("health_status", $memID);
            }
        } else {
            // Enrolls_to insert failed
            handleErrorAndRollback("enrolls_to", $memID);
        }
    } else {
        // Plan retrieval failed
        handleErrorAndRollback("plan", $memID);
    }
} else {
    // User insert failed
    echo "<head><script>alert('Member Addition Failed');</script></head></html>";
    echo "Error: " . mysqli_error($con);
}

/**
 * Handles errors by rolling back the user insert and displaying a message.
 */
function handleErrorAndRollback($failedAt, $memID)
{
    global $con;
    echo "<head><script>alert('Member Addition Failed at $failedAt');</script></head></html>";
    echo "Error: " . mysqli_error($con);

    // Clean up all related records
    $tables = ['login', 'address', 'health_status', 'enrolls_to', 'images', 'users'];
    foreach ($tables as $table) {
        $query = "DELETE FROM $table WHERE userid='$memID'";
        mysqli_query($con, $query);
    }
}

/**
 * Handles the image upload process
 */
function handleImageUpload($con, $memID) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "uploads/user_profile/";
        
        // Create the target directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $uploadOk = 1;
        $target_file = "";

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate image
            if (!getimagesize($_FILES["image"]["tmp_name"])) {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            if ($_FILES["image"]["size"] > 5000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        }

        if ($uploadOk == 1) {
            if (!empty($target_file)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    chmod($target_file, 0777);
                    $sql = "INSERT INTO images (imageid, userid, image_path) VALUES (UUID(), '$memID', '$target_file')";
                    if (!mysqli_query($con, $sql)) {
                        echo "Error inserting image data into database.";
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                $sql = "INSERT INTO images (imageid, userid, image_path) VALUES (UUID(), '$memID', NULL)";
                if (!mysqli_query($con, $sql)) {
                    echo "Error inserting data into database.";
                }
            }
        }
    }
}
?>