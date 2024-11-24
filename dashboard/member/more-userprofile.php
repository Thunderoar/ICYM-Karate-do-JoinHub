<?php
require '../../include/db_conn.php';
page_protect();

if (isset($_POST['submit'])) {
    $userid = $_SESSION['userid'];

    // User information fields
    $usrname = $_POST['login_id'];
    $fulname = $_POST['full_name'];
    $course = $_POST['courseName'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $matrix = $_POST['matrixNumber'];
    $ic = $_POST['no_ic'];
    $dob = $_POST['dob'];
    $joining_date = $_POST['joining_date'];
    $email = $_POST['email'];
    $no_ic = $_POST['no_ic'];

    // Address fields
    $street_name = $_POST['street_name'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];

    // Health status fields
    $calorie = $_POST['calorie'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $fat = $_POST['fat'];
    $remarks = $_POST['remarks'];

    // Update user details
    $query = "UPDATE users SET username='$usrname', gender='$gender', fullName='$fulname', courseName='$course', mobile='$mobile', matrixNumber='$matrix', no_ic='$no_ic', dob='$dob', joining_date='$joining_date', email='$email' WHERE userid='$userid'";
    mysqli_query($con, $query);

    // Check if address exists, if not, insert new address
    $address_check_query = "SELECT * FROM address WHERE userid='$userid'";
    $address_result = mysqli_query($con, $address_check_query);

    if (mysqli_num_rows($address_result) > 0) {
        // Update existing address
        $query_address = "UPDATE address SET streetName='$street_name', state='$state', city='$city', zipcode='$zip_code' WHERE userid='$userid'";
    } else {
        // Insert new address with unique ID
        $address_id = uniqid('addr_');
        $query_address = "INSERT INTO address (addressid, userid, streetName, state, city, zipcode) VALUES ('$address_id', '$userid', '$street_name', '$state', '$city', '$zip_code')";
    }
    mysqli_query($con, $query_address);

    // Check if health_status exists, if not, insert new health_status
    $health_check_query = "SELECT * FROM health_status WHERE userid='$userid'";
    $health_result = mysqli_query($con, $health_check_query);

    if (mysqli_num_rows($health_result) > 0) {
        // Update existing health_status
        $query_health = "UPDATE health_status SET height='$height', weight='$weight', remarks='$remarks' WHERE userid='$userid'";
    } else {
        // Insert new health_status with unique ID
        $health_id = uniqid('health_');
        $query_health = "INSERT INTO health_status (healthid, userid, calorie, height, weight, fat, remarks) VALUES ('$health_id', '$userid', '$calorie', '$height', '$weight', '$fat', '$remarks')";
    }
    mysqli_query($con, $query_health);

    // Image handling code
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
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
        $sql_check = "SELECT imageid, image_path FROM images WHERE userid = '$userid'";
        $result_check = mysqli_query($con, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            // Step 2: If an image exists, delete the old image file
            $row = mysqli_fetch_assoc($result_check);
            $existing_image_path = $row['image_path'];
            $imageid = $row['imageid'];

            // Delete the old image if it exists
            if ($existing_image_path && file_exists($existing_image_path)) {
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
                    $sql_update_image = "UPDATE images SET image_path='$target_file' WHERE userid='$userid'";
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
                    $imageid = uniqid('img_');
                    $sql_insert = "INSERT INTO images (imageid, userid, image_path) VALUES ('$imageid', '$userid', '$target_file')";
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

        // Update the users table with the imageid
        $query_update_user_image = "UPDATE users SET imageid='$imageid' WHERE userid='$userid'";
        mysqli_query($con, $query_update_user_image);
    } else {
        // No file uploaded - just update the profile without an image
        echo "No file uploaded.";
    }

    echo "<head><script>alert('Profile Change Successful');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url='>";
}


$userid = $_SESSION['userid'];

// Fetch user data
$user_id = $_SESSION['userid']; // Assuming you have a user ID stored in the session
$sql = "SELECT * FROM users WHERE userid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Fetch address data
$sql = "SELECT * FROM address WHERE userid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$address_data = $result->fetch_assoc();

// Fetch health status data
$sql = "SELECT * FROM health_status WHERE userid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$health_data = $result->fetch_assoc();

// Fetch image data
$sql = "SELECT * FROM images WHERE userid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$image_data = $result->fetch_assoc();


// Fetch the password for the logged-in user
$query = "SELECT pass_key FROM users WHERE userid = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_password);
$stmt->fetch();



$stmt->close();
$con->close();
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0px;
        }
        .form-container {
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
.form-group {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: space-between;
}
        .form-group label {
            flex: 1 1 200px;
            margin-right: 20px;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group input[type="submit"],
        .form-group input[type="reset"] {
            flex: 1 1 calc(100% - 220px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"],
        .form-group input[type="reset"] {
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        .form-group input[type="submit"]:hover,
        .form-group input[type="reset"]:hover {
            background-color: #0056b3;
        }
        .form-group img {
            max-width: 100px;
            border-radius: 4px;
        }
        /* Custom styles for file input */
        .form-group .custom-file-input {
            display: none;
        }
        .form-group .custom-file-label {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            width: 200px;
        }
        .form-group .custom-file-label:hover {
            background-color: #0056b3;
        }
        .form-group .file-name {
            margin-left: 10px;
            font-style: italic;
            color: #555;
        }
        .error { color: red; }
        .valid { color: green;}
		
/* Common style for all input fields and dropdown menus */
.input-field, .dropdown-menu {
    width: 100%;
    padding: 10px;
    margin: 10px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

.input-field:focus, .dropdown-menu:focus {
    background-color: #ddd;
    outline: none;
}
/* Common style for all input fields and dropdown menus */
.input-field-email {
    width: 60%!important;
    padding: 10px!important;
    margin: 10px 0 22px 0!important;
    display: inline-block!important;
    border: none!important;
    background: #f1f1f1!important;
}

.input-field-email:focus {
    background-color: #ddd!important;
    outline: none!important;
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
            <!-- (You will be required to Login Again After Profile Update)-->
            <hr />

            <div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
                <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
                    <div class="a1-container a1-dark-gray a1-center">
                        <h6>CHANGE PROFILE</h6>
                    </div>


<div class="form-container">
    <h2>Update Profile</h2>
    <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
<div class="form-group">
    <label for="image"></label>
    <div>
        <button id="file-upload-btn" class="btn btn-primary">Choose Profile Image</button>
        <input id="file-upload" type="file" name="image" class="custom-file-input" accept="image/*" style="display:none;">
        <br>
        <div id="image-container" style="margin-top: 25px!important;">
            <img id="preview-image" src="<?php echo isset($image_data['image_path']) ? htmlspecialchars($image_data['image_path'], ENT_QUOTES, 'UTF-8') : ''; ?>" alt="Profile Image" style="<?php echo isset($image_data['image_path']) ? '' : 'display:none;'; ?>">
        </div>
        <div id="empty-box" style="width: 150px; height: 150px; border: 1px solid #ccc; display: <?php echo isset($image_data['image_path']) ? 'none' : 'block'; ?>;"></div>
    </div>
</div>

<script>
    document.getElementById('file-upload-btn').addEventListener('click', function(event) {
        event.preventDefault();  // Prevents the default button behavior
        document.getElementById('file-upload').click();
    });

    document.getElementById('file-upload').addEventListener('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-image').style.display = 'block';
            document.getElementById('empty-box').style.display = 'none';
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>







<h4>User Information:</h4>
<!-- User Information Section -->
<div class="form-group">
    <label for="login_id">ID:</label>
    <input type="text" name="login_id" value="<?php echo htmlspecialchars($user_data['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required pattern="[a-zA-Z0-9]{1,25}" title="Only alphanumeric characters are allowed, up to 25 characters." readonly>
</div>
<div class="form-group">
    <label for="full_name">Full Name:</label>
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($user_data['fullName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="25" required pattern="[a-zA-Z\s]{1,25}" title="Only letters and spaces are allowed, up to 25 characters.">
</div>
<div style="margin-bottom: 10px;">
    <label for="gender">Gender:</label>
    <select id="gender" name="gender" class="dropdown-menu" required>
        <option value="">--Please Select--</option>
        <option value="Male" <?php echo (isset($user_data['gender']) && $user_data['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo (isset($user_data['gender']) && $user_data['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
    </select>
</div>

<div class="form-group">
    <label for="mobile">Phone Number</label>
    <input 
        type="text" 
        class="form-control" 
        name="mobile" 
        id="mobile" 
        placeholder="###-########" 
        maxlength="12"
        autocomplete="off"
		value="<?php echo htmlspecialchars($user_data['mobile'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
        required>
</div>
<script>
    const phoneInput = document.getElementById('mobile');
    
    phoneInput.addEventListener('input', function(e) {
        // Remove all non-digits
        let value = e.target.value.replace(/\D/g, '');
        
        // Format the number
        if (value.length > 0) {
            if (value.length <= 3) {
                value = value;
            } else {
                value = value.slice(0, 3) + '-' + value.slice(3);
            }
        }
        
        // Update input value
        e.target.value = value;
        
        // Validation (optional)
        const isComplete = value.replace(/-/g, '').length === 11;
        e.target.style.borderColor = isComplete ? 'green' : '';
    });

    // Prevent non-numeric input (optional)
    phoneInput.addEventListener('keypress', function(e) {
        if (!/^\d$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault();
        }
    });
</script>
<div class="form-group">
    <label for="email">Email:</label>
    <input class="input-field-email" type="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="50" required pattern=".{1,50}" title="Up to 50 characters.">
</div>
<div class="form-group">
    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" value="<?php echo htmlspecialchars($user_data['dob'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
</div>
<div class="form-group">
    <label for="joining_date">Joining Date:</label>
    <input type="date" 
           name="joining_date" 
           value="<?php echo htmlspecialchars($user_data['joining_date'] ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8'); ?>" 
           required>
</div>

<div class="form-group">
    <label for="matrixNumber">Matrix Number:</label>
    <input type="text" name="matrixNumber" value="<?php echo htmlspecialchars($user_data['matrixNumber'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="25" required pattern="[a-zA-Z0-9]{1,25}" title="Only alphanumeric characters are allowed, up to 25 characters.">
</div>
<div class="form-group">
    <label for="courseName">Course Name:</label>
    <input type="text" name="courseName" value="<?php echo htmlspecialchars($user_data['courseName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="50" required pattern="[a-zA-Z\s]{1,50}" title="Only letters and spaces are allowed, up to 50 characters.">
</div>
<div class="form-group">
  <label for="no_ic">IC Number</label>
  <input 
    type="text" 
    class="form-control" 
    name="no_ic" 
    id="no_ic" 
    placeholder="######-##-####" 
    autocomplete="off" 
    maxlength="14"
	value="<?php echo htmlspecialchars($user_data['no_ic'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
    required>
</div>
<script>
  const icInput = document.getElementById('no_ic');
  
  icInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
    
    if (value.length > 0) {
      // Format with hyphens
      if (value.length <= 6) {
        value = value;
      } else if (value.length <= 8) {
        value = value.slice(0, 6) + '-' + value.slice(6);
      } else {
        value = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8, 12);
      }
    }
    
    e.target.value = value;
    
    // Validation
    const isComplete = value.replace(/-/g, '').length === 12;
    e.target.style.borderColor = isComplete ? 'green' : 'red';
  });
</script>
<div class="form-group">
    <label for="street_name">Street Name:</label>
    <input type="text" name="street_name" value="<?php echo htmlspecialchars($address_data['streetName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="50" required>
</div>
<div class="form-group">
    <label for="state">State:</label>
    <input type="text" name="state" value="<?php echo htmlspecialchars($address_data['state'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="25" required pattern="[a-zA-Z\s]{1,25}" title="Only letters and spaces are allowed, up to 25 characters.">
</div>
<div class="form-group">
    <label for="city">City:</label>
    <input type="text" name="city" value="<?php echo htmlspecialchars($address_data['city'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="25" required pattern="[a-zA-Z\s]{1,25}" title="Only letters and spaces are allowed, up to 25 characters.">
</div>
<div class="form-group">
    <label for="zip_code">Zip Code:</label>
    <input type="text" name="zip_code" value="<?php echo htmlspecialchars($address_data['zipcode'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="10" required pattern="\d{5,10}" title="Only digits are allowed, between 5 to 10 characters.">
</div>
<?php
// Securely retrieve the secure key from the login table
$query = "SELECT securekey FROM login WHERE userid = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$securekey = "";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $securekey = $row['securekey'];
}

$stmt->close();
$con->close();
?>
<tr>
    <td height="35">Secure Key:</td>
    <td height="35">
        <div style="display: flex; align-items: center; gap: 5px;">
            <input type="password" id="secureKey" name="securekey" value="<?php echo htmlspecialchars($securekey); ?>" class="form-control" style="flex: 1; max-width: 60%; margin-right: 5px;" readonly required/>
            <button type="button" onclick="handleSecureKeyVisibility(event)" class="btn btn-primary" style="white-space: nowrap;">Show Key</button>
        </div>
        <!-- Success message container for secure key -->
        <div id="secureKeySuccessMessage" style="color: green; margin-top: 5px; display: none;">
            Key verified successfully! ✓
        </div>
        <small style="display: block; margin-top: 5px;">This key is used for additional security verification</small>
    </td>
</tr>

<tr>
    <td height="35">Password:</td>
    <td height="35">
        <div style="display: flex; align-items: center; gap: 5px;">
            <input type="password" id="userPassword" class="form-control" value="<?php echo htmlspecialchars($user_password); ?>" style="flex: 1; max-width: 60%; margin-right: 5px;" readonly>
            <button type="button" onclick="handlePasswordVisibility(event)" class="btn btn-primary" style="white-space: nowrap;">Show Password</button>
            <a href="change_pwd.php" class="a1-btn a1-orange" style="white-space: nowrap;">Change password</a>
        </div>
    </td>
</tr>



<script>
function handleSecureKeyVisibility(event) {
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
    if (userInput === '<?php echo htmlspecialchars($user_password); ?>') {
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


<script>
function handlePasswordVisibility(event) {
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
    if (userInput === '<?php echo htmlspecialchars($user_password); ?>') {
        passwordField.type = "text";
        button.innerText = "Hide Password";
    } else {
        alert("Incorrect password. Access denied.");
    }
}
</script>






<!-- Health Status Section -->
<h4 id="health_status_section">Health Status:</h4>
<!--<div class="form-group">
    <label for="calorie">Calorie:</label>
    <input type="text" name="calorie" value="<?php echo htmlspecialchars($health_data['calorie'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="10" required pattern="\d{1,10}" title="Only digits are allowed, up to 10 characters.">
</div>-->
<div class="form-group">
    <label for="height">Height:</label>
    <input type="text" name="height" value="<?php echo htmlspecialchars($health_data['height'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="5" required pattern="\d{1,5}" title="Only digits are allowed, up to 5 characters.">
</div>
<div class="form-group">
    <label for="weight">Weight:</label>
    <input type="text" name="weight" value="<?php echo htmlspecialchars($health_data['weight'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="5" required pattern="\d{1,5}" title="Only digits are allowed, up to 5 characters.">
</div>
<!--<div class="form-group">
    <label for="fat">Fat:</label>
    <input type="text" name="fat" value="<?php echo htmlspecialchars($health_data['fat'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" maxlength="5" required pattern="\d{1,5}" title="Only digits are allowed, up to 5 characters.">
</div>-->
<div class="form-group">
    <label for="remarks">Remarks:</label>
    <textarea name="remarks" maxlength="255"><?php echo htmlspecialchars($health_data['remarks'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
</div> 







<div class="form-group">
    <input type="submit" name="submit" value="SUBMIT" class="btn btn-primary" style="margin-right: 10px;">
    <input type="reset" name="reset" value="Reset" class="btn btn-secondary">
</div>

    </form>
</div>







                </div>
            </div>

            <?php include('footer.php'); ?>
        </div>
    </body>
</html>
