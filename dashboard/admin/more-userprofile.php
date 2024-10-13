<?php
require '../../include/db_conn.php';
page_protect();

if (isset($_POST['submit'])) {
    $usrname = $_POST['login_id'];
    $fulname = $_POST['full_name'];
    $adminid = $_SESSION['adminid'];

    // Update username and full name
    $query = "UPDATE admin SET username='$usrname', Full_name='$fulname' WHERE adminid='$adminid'";

    if (isset($_FILES['image'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the uploads directory if it doesn't exist
        }

        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check for upload errors
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo "Upload error: " . $_FILES['image']['error'];
            exit;
        }

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Step 1: Check if an image already exists for the admin
        $sql_check = "SELECT image_path FROM images WHERE adminid = '$adminid'";
        $result_check = mysqli_query($con, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            // Step 2: If an image exists, delete the old image file
            $row = mysqli_fetch_assoc($result_check);
            $existing_image_path = $row['image_path'];

            // Delete the old image
            if (file_exists($existing_image_path)) {
                unlink($existing_image_path); // Delete the old image
            }

            // Step 3: Proceed with uploading the new image
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                // Attempt to move the uploaded file to the target location
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

                    // Change file permissions to 0777
                    chmod($target_file, 0777);

                    // Update the image path in the database for the current admin
                    $sql_update_image = "UPDATE images SET image_path='$target_file' WHERE adminid='$adminid'";
                    if (mysqli_query($con, $sql_update_image)) {
                        echo "Image updated successfully!";
                        $_SESSION['profile_pic'] = $target_file; // Update session with new image
                    } else {
                        echo "Error updating image: " . mysqli_error($con);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            // No previous image exists, insert the new image
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                // Attempt to move the uploaded file to the target location
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

                    // Change file permissions to 0777
                    chmod($target_file, 0777);

                    // Insert the new image path into the database
                    $sql_insert = "INSERT INTO images (imageid, adminid, image_path) VALUES (UUID(), '$adminid', '$target_file')";
                    if (mysqli_query($con, $sql_insert)) {
                        echo "New image inserted successfully!";
                        $_SESSION['profile_pic'] = $target_file; // Update session with new image
                    } else {
                        echo "Error inserting image: " . mysqli_error($con);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    } else {
        echo "No file uploaded.";
    }

    // Execute profile update query
    if (mysqli_query($con, $query)) {
        echo "<head><script>alert('Profile Change Successful');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=logout.php'>";
    } else {
        echo "<head><script>alert('NOT SUCCESSFUL, Check Again');</script></head></html>";
        echo "error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do | Admin</title>
    <link rel="stylesheet" href="../../css/style.css" id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
        .page-container .sidebar-menu #main-menu li#adminprofile > a {
            background-color: #2b303a;
            color: #ffffff;
        }
    </style>
</head>
<body class="page-body page-fade" onload="collapseSidebar()">
    <div class="page-container sidebar-collapsed" id="navbarcollapse">    
        <div class="sidebar-menu">
            <header class="logo-env">
                <?php require('../../element/loggedin-logo.html'); ?>
                <div class="sidebar-collapse" onclick="collapseSidebar()">
                    <a href="#" class="sidebar-collapse-icon with-animation">
                        <i class="entypo-menu"></i>
                    </a>
                </div>
            </header>
            <?php include('nav.php'); ?>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-md-6 col-sm-8 clearfix"></div>
                <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                    <ul class="list-inline links-list pull-right">
                    <?php
						require('../../element/loggedin-welcome.html');
					?>                  
                        <li>
                            <a href="logout.php">Log Out <i class="entypo-logout right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <h3>Edit user profile</h3>
            (You will be required to Login Again After Profile Update)
            <hr />

            <div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
                <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
                    <div class="a1-container a1-dark-gray a1-center">
                        <h6>CHANGE PROFILE</h6>
                    </div>
                    <form id="form1" name="form1" method="post" class="a1-container" action="" enctype="multipart/form-data">
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td height="35">
                                    <table width="100%" border="0" align="center">
                                        <tr>
                                            <td height="35">Profile Image: </td>
                                            <td height="35">
                                                <input type="file" name="image" accept="image/*">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="35">ID:</td>
                                            <td height="35"><input type="text" name="login_id" value="<?php echo $_SESSION['user_data']; ?>" class="form-control" required/></td>
                                        </tr>
                                        <tr>
                                            <td height="35">Full Name:</td>
                                            <td height="35"><input class="form-control" type="text" name="full_name" value="<?php echo $_SESSION['username']; ?>" maxlength="25" required></td>
                                        </tr>
                                        <tr>
                                            <td height="35">Password:</td>
                                            <td height="35"><span class="form-control">*********</span> <a href="change_pwd.php" class="a1-btn a1-orange">Change password</a></td>
                                        </tr>
                                        <tr>
                                            <td height="35">&nbsp;</td>
                                            <td height="35">
                                                <input class="a1-btn a1-blue" type="submit" name="submit" value="SUBMIT">
                                                <input class="a1-btn a1-blue" type="reset" name="reset" value="Reset">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <?php include('footer.php'); ?>
        </div>
    </body>
</html>
