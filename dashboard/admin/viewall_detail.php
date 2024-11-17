<?php
require '../../include/db_conn.php';
page_protect();

if (isset($_POST['name'])) {
    $memid = $_POST['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SPORTS CLUB | Edit Member</title>
    <link rel="stylesheet" href="../../css/style.css" id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
        #button1 { width:126px; }
        #boxxe { width:230px; }
        .page-container .sidebar-menu #main-menu li#hassubopen > a {
            background-color: #2b303a; color: #ffffff;
        }
        #space {
            line-height:0.5cm;
        }
        .home-button {
            position: fixed; /* Fixed positioning */
            bottom: 20px; /* Distance from the bottom of the viewport */
            right: 20px; /* Distance from the right of the viewport */
            background-color: #007bff; /* Bootstrap primary color */
            color: white; /* Text color */
            padding: 20px 25px; /* Padding around the button */
            border-radius: 5px; /* Rounded corners */
            text-decoration: none; /* No underline */
            font-size: 16px; /* Font size */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
            transition: background-color 0.3s; /* Transition effect */
        }

        .home-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body class="page-body page-fade" onload="collapseSidebar()">

<div class="page-container sidebar-collapsed" id="navbarcollapse">    
    <div class="sidebar-menu">
        <header class="logo-env">
            <!-- logo -->
            <?php
             require('../../element/loggedin-logo.html');
            ?>
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
                        <a href="logout.php">
                            Log Out <i class="entypo-logout right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <h3>Member Details</h3>
        <hr />

<?php
// Initialize variables with default values
$name = $gender = $mobile = $email = $dob = $jdate = '';
$streetname = $state = $city = $zipcode = '';
$calorie = $height = $weight = $fat = $remarks = '';
$planname = $pamount = $pvalidity = $pdescription = '';
$paiddate = $expire = '';

// SQL query to retrieve user, address, health, enrolls, and plan data using LEFT JOIN
$query = "
SELECT u.username, u.gender, u.mobile, u.email, u.dob, u.joining_date, u.matrixNumber, courseName, no_ic,
       a.streetName, a.state, a.city, a.zipcode,
       h.calorie, h.height, h.weight, h.fat, h.remarks,
       e.planid, e.paid_date, e.expire,
       p.planName, p.amount, p.validity, p.description
FROM users u
LEFT JOIN address a ON u.userid = a.userid
LEFT JOIN health_status h ON u.userid = h.userid
LEFT JOIN enrolls_to e ON u.userid = e.userid
LEFT JOIN plan p ON e.planid = p.planid
WHERE u.userid = ?";

// Fetch and bind the parameters
if ($stmt = mysqli_prepare($con, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $memid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if at least one record is found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        // Safely assign values or set defaults for nulls
$name = htmlspecialchars($row['username'] ?? 'No name available');
$matrixNumber = htmlspecialchars($row['matrixNumber'] ?? 'No Matrix Number');
$courseName = htmlspecialchars($row['courseName'] ?? 'No Selected Course');
$no_ic = htmlspecialchars($row['no_ic'] ?? 'No IC Number');
$gender = htmlspecialchars($row['gender'] ?? 'Not specified');
$mobile = htmlspecialchars($row['mobile'] ?? 'No phone number');
$email = htmlspecialchars($row['email'] ?? 'No email provided');
$dob = htmlspecialchars($row['dob'] ?? 'Unknown');
$jdate = htmlspecialchars($row['joining_date'] ?? 'Not available');
$streetname = htmlspecialchars($row['streetName'] ?? 'No street provided');
$state = htmlspecialchars($row['state'] ?? 'Unknown state');
$city = htmlspecialchars($row['city'] ?? 'Unknown city');
$zipcode = htmlspecialchars($row['zipcode'] ?? 'No ZIP');
$calorie = htmlspecialchars($row['calorie'] ?? 'Not measured');
$height = htmlspecialchars($row['height'] ?? 'Not measured');
$weight = htmlspecialchars($row['weight'] ?? 'Not measured');
$fat = htmlspecialchars($row['fat'] ?? 'Not measured');
$remarks = htmlspecialchars($row['remarks'] ?? 'No remarks');
$planname = htmlspecialchars($row['planName'] ?? 'No plan assigned');
$pamount = htmlspecialchars($row['amount'] ?? '0.00');
$pvalidity = htmlspecialchars($row['validity'] ?? 'Unknown');
$pdescription = htmlspecialchars($row['description'] ?? 'No description');
$paiddate = htmlspecialchars($row['paid_date'] ?? 'Not paid');
$expire = htmlspecialchars($row['expire'] ?? 'N/A');

    } else {
        echo "<script>alert('No records found for the selected user.');</script>";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Database query failed: " . mysqli_error($con) . "');</script>";
}
?>




<script>
    function toggleEdit() {
        var inputs = document.querySelectorAll('#form1 input');
        var editButton = document.getElementById('editButton');
        var updateButton = document.getElementById('updateButton');
        var exitButton = document.getElementById('exitButton');
        
        inputs.forEach(input => {
            if (input.readOnly) {
                input.readOnly = false;
            } else {
                input.readOnly = true;
            }
        });
        
        if (updateButton.style.display === 'none') {
            // Entering edit mode
            updateButton.style.display = 'inline-block';
            exitButton.style.display = 'inline-block';
            editButton.style.display = 'none';
        } else {
            // Exiting edit mode
            updateButton.style.display = 'none';
            exitButton.style.display = 'none';
            editButton.style.display = 'inline-block';
        }
    }
</script>
<div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
    <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
        <div class="a1-container a1-dark-gray a1-center">
            <h6>Edit Member Details</h6>
        </div>
        <!-- Mode Indicator -->
        <div id="modeIndicator" class="a1-center" style="margin: 10px; font-weight: bold; color: #ff0000;">
            Currently in View Mode
        </div>
        <form id="form1" name="form1" method="post" class="a1-container" action="edit_mem_submit.php">
            <table width="100%" border="0" align="center">
                <tbody>
                    <!-- Personal Details Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center" style="font-weight: bold; padding: 8px; background-color: #f1f1f1; border-radius: 5px;">Personal Details</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">User ID:</td>
                        <td><input type="text" name="uid" readonly value='<?php echo $memid; ?>' class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="uname" readonly value='<?php echo $name; ?>' class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Matrix Number:</td>
                        <td><input type="text" name="matrixNumber" readonly value='<?php echo $matrixNumber; ?>' class="form-control"></td>
                    </tr>
					<tr>
                        <td>IC Number:</td>
                        <td><input type="text" name="no_ic" readonly value='<?php echo $no_ic; ?>' class="form-control"></td>
                    </tr>
<tr>
    <td>Gender:</td>
    <td>
        <select name="gender" class="form-control" disabled>
            <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
            <option value="other" <?php if ($gender == 'other') echo 'selected'; ?>>Other</option>
        </select>
    </td>
</tr>


<tr>
    <td>Date of Birth:</td>
    <td>
        <input type="date" value='<?php echo $dob; ?>' class="form-control" disabled>
        <input type="hidden" name="dob" value='<?php echo $dob; ?>'>
    </td>
</tr>


					<!-- Address Details Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center" style="font-weight: bold; padding: 8px; background-color: #f1f1f1; border-radius: 5px;">Address  Details</td>
                    </tr>
                    <tr>
                        <td>STREET NAME:</td>
                        <td><input type="text" name="stname"  readonly value='<?php echo $streetname ?>'  class="form-control"></td>
                    </tr>
                    <tr>
                        <td>STATE:</td>
                        <td><input type="text" name="state" readonly name="state" value='<?php echo $state ?>'  class="form-control"></td>
                    </tr>
                    <tr>
                        <td>CITY:</td>
                        <td><input type="text" name="city" readonly value='<?php echo $city ?>'  class="form-control"></td>
                    </tr>
<tr>
    <td>ZIPCODE:</td>
    <td>
        <input type="text" name="zipcode" readonly value='<?php echo $zipcode; ?>' class="form-control" pattern="\d{5}" title="Please enter exactly 5 digits" maxlength="5">
    </td>
</tr>

                    <!-- Contact Details Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center" style="font-weight: bold; padding: 8px; background-color: #f1f1f1; border-radius: 5px;">Contact Details</td>
                    </tr>
<tr>
    <td>Mobile:</td>
    <td>
        <input 
            type="text" 
            name="phone" 
            readonly 
            maxlength="12" 
            value='<?php echo $mobile; ?>' 
            class="form-control" 
            placeholder="###-########"
            oninput="formatPhoneNumber(this)">
    </td>
</tr>




                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" readonly required value='<?php echo $email; ?>' class="form-control"></td>
                    </tr>
                    <!-- Membership Details Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center" style="font-weight: bold; padding: 8px; background-color: #f1f1f1; border-radius: 5px;">Membership Details</td>
                    </tr>
<tr>
    <td>Joining Date:</td>
    <td>
        <input type="date" name="jdate" readonly value='<?php echo $jdate; ?>' class="form-control uneditable" disabled>
    </td>
</tr>
<tr>
    <td>Plan Name:</td>
    <td><input type="text" readonly value='<?php echo $planname; ?>' class="form-control uneditable" disabled></td>
</tr>
<tr>
    <td>Plan Amount:</td>
    <td><input type="text" readonly value='<?php echo $pamount; ?>' class="form-control uneditable" disabled></td>
</tr>
<tr>
    <td>Paid Date:</td>
    <td><input type="text" readonly value='<?php echo $paiddate; ?>' class="form-control uneditable" disabled></td>
</tr>


                    <!--<tr>
                        <td>Expired Date:</td>
                        <td><input type="text" readonly value='<?php echo $expire; ?>' class="form-control"></td>
                    </tr>-->
                    <!-- Additional Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center" style="font-weight: bold; padding: 8px; background-color: #f1f1f1; border-radius: 5px;">Additional Details</td>
                    </tr>
<tr>
    <td>Remarks:</td>
    <td>
        <textarea readonly name="remarks" class="form-control" style="resize: vertical;"><?php echo $remarks; ?></textarea>
    </td>
</tr>


                </tbody>
            </table>

            <!-- Buttons -->
<div class="a1-center" style="margin-top: 20px;">
    <input class="a1-btn a1-blue" type="button" id="editButton" value="Enter Edit Mode" onclick="toggleEdit()">
    <input class="a1-btn a1-blue" type="submit" id="updateButton" value="UPDATE" style="display:none;">
    <input class="a1-btn a1-blue" type="button" id="exitButton" value="Exit Edit Mode" onclick="toggleEdit()" style="display:none;">
    <a href="<?php echo (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'view_mem.php' : '../../dashboard/coach/view_mem.php'); ?>">
        <input class="a1-btn a1-blue" type="button" value="BACK">
    </a>
</div>
        </form>
    </div>
</div>

<script>
    function toggleEdit() {
        const isEditMode = document.getElementById("editButton").style.display === "none";
        const modeIndicator = document.getElementById("modeIndicator");

        // Toggle between edit and view mode
        if (isEditMode) {
            // Switch to View Mode
            document.getElementById("editButton").style.display = "inline-block";
            document.getElementById("updateButton").style.display = "none";
            document.getElementById("exitButton").style.display = "none";
            Array.from(document.querySelectorAll("#form1 input:not(.uneditable), #form1 textarea, #form1 select")).forEach((input) => {
                input.setAttribute("readonly", "readonly");
                input.classList.remove("edit-mode-field");
                if (input.tagName === "SELECT" || input.type === "date" || input.type === "text") {
                    input.setAttribute("disabled", "disabled");
                }
            });
            modeIndicator.textContent = "Currently in View Mode";
            modeIndicator.style.color = "#ff0000";
        } else {
            // Switch to Edit Mode
            document.getElementById("editButton").style.display = "none";
            document.getElementById("updateButton").style.display = "inline-block";
            document.getElementById("exitButton").style.display = "inline-block";
            Array.from(document.querySelectorAll("#form1 input:not(.uneditable), #form1 textarea, #form1 select")).forEach((input) => {
                input.removeAttribute("readonly");
                input.classList.add("edit-mode-field");
                if (input.tagName === "SELECT" || input.type === "date" || input.type === "text") {
                    input.removeAttribute("disabled");
                }
            });
            modeIndicator.textContent = "Currently in Edit Mode";
            modeIndicator.style.color = "#ff0000";
        }
    }

    function enableAllFields() {
        Array.from(document.querySelectorAll("#form1 input:not(.uneditable), #form1 textarea, #form1 select")).forEach((input) => {
            input.removeAttribute("disabled");
        });
    }

    function formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 3) {
            value = value.slice(0, 3) + '-' + value.slice(3);
        }
        input.value = value.slice(0, 12); // Ensure no more than 12 characters
    }
</script>











<style>
    .edit-mode-field {
        border: 2px solid #add8e6;
        background-color: #e8f4ff;
    }

    .edit-mode-field:focus {
        outline: 2px solid #0056b3;
    }
</style>

<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#2a2e32" 
   href="<?php echo (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'view_mem.php' : '../../dashboard/coach/view_mem.php'); ?>">
    Return Back
</a>
            </div>
        </div>   

        <?php include('footer.php'); ?>


</body>

</html>    

<?php
} else {
    echo "<script>alert('Invalid access. Please return to the main page.');</script>";
}
?>
