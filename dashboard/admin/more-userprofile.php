<?php
require '../../include/db_conn.php';
page_protect();
include('checkAccess.php');
check_access('admin', 'more-userprofile.php');

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $fullname = mysqli_real_escape_string($con, $_POST['full_name']);
    $securekey = mysqli_real_escape_string($con, $_POST['securekey']);
    $adminid = $_SESSION['adminid'];

    // Update admin information
    $query = "UPDATE admin SET 
              username = '$username',
              Full_name = '$fullname',
              securekey = '$securekey'
              WHERE adminid = '$adminid'";

    // Also update the login table to keep username in sync
    $login_query = "UPDATE login SET 
                    username = '$username',
                    securekey = '$securekey'
                    WHERE adminid = '$adminid'";
    // Check if a file was actually uploaded (not empty)
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
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

        // Check if an image already exists for the admin
        $sql_check = "SELECT image_path FROM images WHERE adminid = '$adminid'";
        $result_check = mysqli_query($con, $sql_check);

        if ($uploadOk == 1) {  // Only proceed if all checks passed
            if (mysqli_num_rows($result_check) > 0) {
                // Update existing image
                $row = mysqli_fetch_assoc($result_check);
                $existing_image_path = $row['image_path'];

                // Delete old image if it exists
                if (file_exists($existing_image_path)) {
                    unlink($existing_image_path);
                }

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    chmod($target_file, 0777);
                    $sql_update_image = "UPDATE images SET image_path='$target_file' WHERE adminid='$adminid'";
                    if (mysqli_query($con, $sql_update_image)) {
                        $_SESSION['profile_pic'] = $target_file;
                    }
                }
            } else {
                // Insert new image
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    chmod($target_file, 0777);
                    $sql_insert = "INSERT INTO images (imageid, adminid, image_path) 
                                 VALUES (UUID(), '$adminid', '$target_file')";
                    if (mysqli_query($con, $sql_insert)) {
                        $_SESSION['profile_pic'] = $target_file;
                    }
                }
            }
        }
    }


    // Execute the profile update queries
    $success = true;
    if (!mysqli_query($con, $query)) {
        $success = false;
        echo "Error updating admin table: " . mysqli_error($con);
    }
    
    if (!mysqli_query($con, $login_query)) {
        $success = false;
        echo "Error updating login table: " . mysqli_error($con);
    }

    if ($success) {
        // Update session variables
        $_SESSION['user_data'] = $username;
        $_SESSION['username'] = $fullname;
        $_SESSION['securekey'] = $securekey;

        echo "<head><script>alert('Profile Updated Successfully');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=more-userprofile.php'>";
    } else {
        echo "<head><script>alert('Update Failed, Please Check The Information');</script></head></html>";
    }
}
?>

<?php
require '../../include/db_conn.php';

$admin_username = $_SESSION['username']; // Adjust based on your session variable name

// Fetch the admin password from the database (hashed or encrypted for security)
$sql = "SELECT pass_key FROM admin WHERE username = '$admin_username'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $admin_password = $row['pass_key'];
} else {
    $admin_password = "********"; // Default display if password is not found or query fails
}
?>

<?php
// Assuming you have already started the session and connected to the database as $conn

// Retrieve the admin's secure key
$admin_id = $_SESSION['adminid']; // Assuming this session variable holds the admin's ID
$sql = "SELECT securekey FROM admin WHERE adminid = '$admin_id'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['securekey'] = $row['securekey'];
} else {
    echo "Unable to retrieve secure key.";
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
                <!-- <div class="sidebar-collapse" onclick="collapseSidebar()">
                    <a href="#" class="sidebar-collapse-icon with-animation">
                        <i class="entypo-menu"></i>
                    </a>
                </div>-->
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
        <input type="file" name="image" accept="image/*" onchange="previewImage(this);">
        <div id="imagePreview" style="margin-top: 10px;">
            <img id="preview" 
                 src="<?php echo isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : ''; ?>" 
                 alt="Preview" 
                 style="max-width: 200px; max-height: 200px; <?php echo isset($_SESSION['profile_pic']) ? '' : 'display: none;'; ?>">
        </div>
    </td>
</tr>
<tr>
    <td height="35">Username:</td>
    <td height="35">
        <input type="text" name="username" value="<?php echo $_SESSION['user_data']; ?>" 
               class="form-control" required/>
    </td>
</tr>
<tr>
    <td height="35">Full Name:</td>
    <td height="35">
        <input class="form-control" type="text" name="full_name" 
               value="<?php echo $_SESSION['username']; ?>" maxlength="50" required>
    </td>
</tr>
<tr>
    <td height="35">Secure Key:</td>
    <td height="35">
        <div style="display: flex; align-items: center; gap: 5px;">
            <input type="password" id="secureKey" name="securekey" 
                   value="<?php echo isset($_SESSION['securekey']) ? $_SESSION['securekey'] : ''; ?>" 
                   class="form-control" style="flex: 1; max-width: 60%; margin-right: 5px;" readonly required/>
            <button type="button" onclick="handleSecureKeyVisibility()" class="btn btn-primary" style="white-space: nowrap;">Show Key</button>
        </div>
        <!-- Success message container for secure key 
        <div id="secureKeySuccessMessage" style="color: green; margin-top: 5px; display: none;">
            Key verified successfully! ✓
        </div>-->
        <small style="display: block; margin-top: 5px;">This key is used for additional security verification</small>
    </td>
</tr>

<script>
function handleSecureKeyVisibility() {
    var secureKeyField = document.getElementById("secureKey");
    var button = event.target;
    var successMsg = document.getElementById("secureKeySuccessMessage");
    
    // If key is currently visible, hide it without verification
    if (secureKeyField.type === "text") {
        secureKeyField.type = "password";
        button.innerText = "Show Key";
        successMsg.style.display = "none"; // Hide success message when hiding key
        return;
    }
    
    // For showing key, require verification
    const userInput = prompt("Please enter your current password for verification:");
    
    // If user cancels the prompt or enters nothing, return early
    if (!userInput) {
        return;
    }

    // Verify password (replace with secure server-side verification in production)
    if (userInput === '<?php echo htmlspecialchars($admin_password); ?>') {
        secureKeyField.type = "text";
        button.innerText = "Hide Key";
        
        // Show success message
        successMsg.style.display = "block";
        
        // Hide the success message after 3 seconds
        setTimeout(() => {
            successMsg.style.display = "none";
        }, 3000);
    } else {
        alert("Incorrect password. Access denied.");
    }
}
</script>
<tr>
    <td height="35">Authority Level:</td>
    <td height="35">
        <input type="text" name="authority" 
               value="<?php echo isset($_SESSION['authority']) ? $_SESSION['authority'] : ''; ?>" 
               class="form-control" readonly/>
        <small>Authority level cannot be changed directly</small>
    </td>
</tr>
<tr>
    <td height="35">Last Login:</td>
    <td height="35">
        <span class="form-control" style="background-color: #f5f5f5;">
            <?php echo isset($_SESSION['last_login']) ? $_SESSION['last_login'] : 'N/A'; ?>
        </span>
    </td>
</tr>
<tr>
    <td height="35">Password:</td>
    <td height="35">
        <div style="display: flex; align-items: center; gap: 5px;">
            <!-- Hidden password input -->
            <input type="password" id="userPassword" class="form-control" value="<?php echo htmlspecialchars($admin_password); ?>" style="flex: 1; max-width: 60%; margin-right: 5px;" readonly>
            <button type="button" onclick="handlePasswordVisibility()" class="btn btn-primary" style="white-space: nowrap;">Show Password</button>
            <a href="change_pwd.php" class="a1-btn a1-orange" style="white-space: nowrap;">Change password</a>
        </div>
    </td>
</tr>

<script>
function handlePasswordVisibility() {
    var passwordField = document.getElementById("userPassword");
    var button = event.target;
    
    // If password is currently visible, hide it without verification
    if (passwordField.type === "text") {
        passwordField.type = "password";
        button.innerText = "Show Password";
        return;
    }
    
    // For showing password, require verification
    const userInput = prompt("Please enter your current password for verification:");
    
    // If user cancels the prompt or enters nothing, return early
    if (!userInput) {
        return;
    }

    // Verify password (replace with secure server-side verification in production)
    if (userInput === '<?php echo htmlspecialchars($admin_password); ?>') {
        passwordField.type = "text";
        button.innerText = "Hide Password";
    } else {
        alert("Incorrect password. Access denied.");
    }
}
</script>


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
