<?php
require 'include/db_conn.php';

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
$plan = 'XTWIOL';

$pass_key = $_POST['pass_key'];

// Insert into users table
$query = "INSERT INTO users(username, fullName, gender, mobile, email, dob, joining_date, imageid, userid, pass_key, hasApproved) 
          VALUES ('$uname', '$uname', '$gender', '$phn', '$email', '$dob', '$jdate', 'UUID()', '$memID', '$pass_key', 'No')";
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

                    // Insert into login table
                    $query6 = "INSERT INTO login(loginid, userid, username, pass_key, securekey, authority) 
                               VALUES (UUID(), '$memID', '$uname', '$pass_key', UUID(), 'member')";
                    if (mysqli_query($con, $query6)) {

                        // Handling image upload outside the final if condition
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $target_dir = "uploads/user_profile/";

                            if (!is_dir($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }

                            $uploadOk = 1;
                            $target_file = "";

                            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                $check = getimagesize($_FILES["image"]["tmp_name"]);
                                if ($check === false) {
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
                            } else {
                                echo "No file uploaded. Proceeding without an image.";
                            }

                            if ($uploadOk == 1) {
                                if (!empty($target_file)) {
                                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                        chmod($target_file, 0777);
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
                                    $sql = "INSERT INTO images (imageid, userid, image_path) VALUES (UUID(), '$memID', NULL)";
                                    if (mysqli_query($con, $sql)) {
                                        echo "Record inserted without an image.";
                                    } else {
                                        echo "Error inserting data into database.";
                                    }
                                }
                            } else {
                                echo "Sorry, your file was not uploaded.";
                            }
                        } else {
                            echo "No file uploaded.";
                        }

                        echo "<head><script>alert('Member Added');</script></head>";
                        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
                    } else {
                        handleErrorAndRollback("address", $memID);
                    }
                } else {
                    handleErrorAndRollback("health_status", $memID);
                }
            } else {
                handleErrorAndRollback("enrolls_to", $memID);
            }
        } else {
            handleErrorAndRollback("plan", $memID);
        }
    } else {
        echo "<head><script>alert('Member Added Failed');</script></head>";
        echo "Error: " . mysqli_error($con);
    }
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
