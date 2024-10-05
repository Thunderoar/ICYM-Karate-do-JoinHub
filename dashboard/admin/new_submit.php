<?php
require '../../include/db_conn.php';
page_protect();

// Retrieve form data
$memID = $_POST['m_id'];
$healthID = $_POST['h_id'];
$addressID = $_POST['address_id'];
$uname = $_POST['u_name'];
$stname = $_POST['street_name'];
$city = $_POST['city'];
$zipCODE = $_POST['zipcode'];
$state = $_POST['state'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$phn = $_POST['mobile'];
$email = $_POST['email'];
$jdate = $_POST['jdate'];
$plan = $_POST['plan'];

// Insert into users table
$query = "INSERT INTO users(username, fullName, gender, mobile, email, dob, joining_date, imageid, userid) 
          VALUES ('$uname', '$uname', '$gender', '$phn', '$email', '$dob', '$jdate', 'UUID()', '$memID')";
if (mysqli_query($con, $query)) {
    
    // Retrieve information about the selected plan
    $query1 = "SELECT * FROM plan WHERE planid='$plan'";
    $result = mysqli_query($con, $query1);

    if ($result) {
        $value = mysqli_fetch_row($result);

        // Calculate the expiration date based on the plan validity
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $d = strtotime("+" . $value[3] . " Months");
        $cdate = date("Y-m-d"); // Current date
        $expiredate = date("Y-m-d", $d); // Expiration date

        // Insert into enrolls_to table
        $query2 = "INSERT INTO enrolls_to(planid, userid, paid_date, expire, renewal) 
                   VALUES ('$plan', '$memID', '$cdate', '$expiredate', 'yes')";
        if (mysqli_query($con, $query2)) {
            
            // Insert into health_status table
            $query4 = "INSERT INTO health_status(healthid, userid) 
                       VALUES ('$healthID', '$memID')";
            if (mysqli_query($con, $query4)) {
                
                // Insert into address table
                $query5 = "INSERT INTO address(addressid, userid, streetName, state, city, zipcode) 
                           VALUES ('$addressID', '$memID', '$stname', '$state', '$city', '$zipCODE')";
                if (mysqli_query($con, $query5)) {

                    // Handling image upload
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
                        $target_dir = "uploads/user_profile/";
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0777, true);
                        }

                        $target_file = $target_dir . basename($_FILES["image"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Check if the file is an actual image
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        if ($check === false) {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }

                        // Check if file already exists
                        if (file_exists($target_file)) {
                            echo "Sorry, file already exists.";
                            $uploadOk = 0;
                        }

                        // Check file size
                        if ($_FILES["image"]["size"] > 5000000) {
                            echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }

                        // Allow only certain file formats
                        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                        }

                        // Check if upload is ok
                        if ($uploadOk == 1) {
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                // Change file permissions
                                chmod($target_file, 0777);

                                // Insert the image path into the database
                                $sql = "INSERT INTO images (imageid, userid, image_path) VALUES (UUID(), '$memID', '$target_file')";
                                if (mysqli_query($con, $sql)) {
                                    echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
                                } else {
                                    echo "Error inserting image data into database.";
                                }
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        } else {
                            echo "Sorry, your file was not uploaded.";
                        }
                    } else {
                        echo "No file uploaded.";
                    }

                    // Success message
                    echo "<head><script>alert('Member Added');</script></head></html>";
                    echo "<meta http-equiv='refresh' content='0; url=new_entry.php'>";

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
    echo "<head><script>alert('Member Added Failed');</script></head></html>";
    echo "Error: " . mysqli_error($con);
}

/**
 * Handles errors by rolling back the user insert and displaying a message.
 */
function handleErrorAndRollback($failedAt, $memID)
{
    global $con;
    echo "<head><script>alert('Member Added Failed at $failedAt');</script></head></html>";
    echo "Error: " . mysqli_error($con);

    // Rollback user insert
    $query3 = "DELETE FROM users WHERE userid='$memID'";
    mysqli_query($con, $query3);
}
?>
