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
SELECT u.username, u.gender, u.mobile, u.email, u.dob, u.joining_date, u.matrixNumber, courseName,
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
        
        inputs.forEach(input => {
            if (input.readOnly) {
                input.readOnly = false;
            } else {
                input.readOnly = true;
            }
        });
        
        if (updateButton.style.display === 'none') {
            updateButton.style.display = 'inline-block';
            editButton.style.display = 'none';
        } else {
            updateButton.style.display = 'none';
            editButton.style.display = 'inline-block';
        }
    }
</script>

<div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
    <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
        <div class="a1-container a1-dark-gray a1-center">
            <h6>Edit Member Details</h3>
        </div>
        <form id="form1" name="form1" method="post" class="a1-container" action="edit_mem_submit.php">
            <table width="100%" border="0" align="center">
                <tbody>
                    <!-- Personal Details Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center"><strong>Personal Details</strong></td>
                    </tr>
                    <tr>
                        <td>USER ID:</td>
                        <td><input type="text" name="uid" id="boxxe" readonly value='<?php echo $memid ?>'></td>
                    </tr>
                    <tr>
                        <td>NAME:</td>
                        <td><input type="text" name="uname" id="boxxe" readonly value='<?php echo $name ?>'></td>
                    </tr>
                    <tr>
                        <td>MATRIX NUMBER:</td>
                        <td><input type="text" id="boxxe" readonly value='<?php echo $matrixNumber ?>'></td>
                    </tr>
                    <tr>
                        <td>GENDER:</td>
                        <td><input type="text" name="gender"id="boxxe" readonly value='<?php echo $gender ?>'></td>
                    </tr>
                    <tr>
                        <td>DATE OF BIRTH:</td>
                        <td><input type="text" name="dob"id="boxxe" readonly value='<?php echo $dob ?>'></td>
                    </tr>
                    <tr>
                        <td>STREET NAME:</td>
                        <td><input type="text" name="stname" id="boxxe" readonly value='<?php echo $streetname ?>'></td>
                    </tr>
                    <tr>
                        <td>STATE:</td>
                        <td><input type="text" name="state" id="boxxe" readonly name="state" value='<?php echo $state ?>'></td>
                    </tr>
                    <tr>
                        <td>CITY:</td>
                        <td><input type="text" name="city" id="boxxe" readonly value='<?php echo $city ?>'></td>
                    </tr>
                    <tr>
                        <td>ZIPCODE:</td>
                        <td><input type="text" name="zipcode" id="boxxe" readonly value='<?php echo $zipcode ?>'></td>
                    </tr>
                    <!-- Contact Details Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center"><strong>Contact Details</strong></td>
                    </tr>
                    <tr>
                        <td>MOBILE:</td>
                        <td><input type="text" name="phone" id="boxxe" readonly maxlength="10" value='<?php echo $mobile ?>'></td>
                    </tr>
                    <tr>
                        <td>EMAIL:</td>
                        <td><input type="email" name="email" id="boxxe" readonly required value='<?php echo $email ?>'></td>
                    </tr>
                    <!-- Membership Details Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center"><strong>Membership Details</strong></td>
                    </tr>
                    <tr>
                        <td>JOINING DATE:</td>
                        <td><input type="text" name="jdate" id="boxxe" readonly value='<?php echo $jdate ?>'></td>
                    </tr>
                    <tr>
                        <td>COURSES:</td>
                        <td><input type="text" id="boxxe" readonly value='<?php echo $courseName ?>'></td>
                    </tr>
                    <tr>
                        <td>PLAN NAME:</td>
                        <td><input type="text" readonly id="boxxe" value='<?php echo $planname ?>'></td>
                    </tr>
                    <tr>
                        <td>PLAN AMOUNT:</td>
                        <td><input type="text" readonly id="boxxe" value='<?php echo $pamount ?>'></td>
                    </tr>
                    <!--<tr>
                        <td>PLAN VALIDITY:</td>
                        <td><input type="text" readonly id="boxxe" value='<?php echo $pvalidity . ' Month' ?>'></td>
                    </tr>-->
                    <tr>
                        <td>PLAN DESCRIPTION:</td>
                        <td><input type="text" readonly id="boxxe" value='<?php echo $pdescription ?>'></td>
                    </tr>
                    <tr>
                        <td>PAID DATE:</td>
                        <td><input type="text" readonly id="boxxe" value='<?php echo $paiddate ?>'></td>
                    </tr>
                    <tr>
                        <td>EXPIRED DATE:</td>
                        <td><input type="text" readonly id="boxxe" value='<?php echo $expire ?>'></td>
                    </tr>
                    <!-- Health Metrics Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center"><strong>Health Metrics</strong></td>
                    </tr>
                    <!--<tr>
                        <td>CALORIE:</td>
                        <td><input type="text" name="calorie" id="boxxe" readonly value='<?php echo $calorie ?>'></td>
                    </tr>-->
                    <tr>
                        <td>HEIGHT:</td>
                        <td><input type="text" name="height" readonly id="boxxe" value='<?php echo $height ?>'></td>
                    </tr>
                    <tr>
                        <td>WEIGHT:</td>
                        <td><input type="text" name="weight" readonly value='<?php echo $weight ?>' id="boxxe"></td>
                    </tr>
                    <!--<tr>
                        <td>FAT:</td>
                        <td><input type="text" name="fat" readonly id="boxxe" value='<?php echo $fat ?>'></td>
                    </tr>-->
                    <!-- Additional Section -->
                    <tr>
                        <td colspan="2" class="a1-dark-gray a1-center"><strong>Additional Details</strong></td>
                    </tr>
                    <tr>
                        <td>REMARKS:</td>
                        <td>
                            <textarea readonly name="remarks" style="resize:none; margin: 0px; width: 230px; height: 53px;"><?php echo $remarks ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
            <input class="a1-btn a1-blue" type="button" id="editButton" value="EDIT" onclick="toggleEdit()">
            <input class="a1-btn a1-blue" type="submit" id="updateButton" value="UPDATE" style="display:none;">
                            <a href="<?php echo (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'view_mem.php' : '../../dashboard/coach/view_mem.php'); ?>">
                                <input class="a1-btn" value="BACK" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>
</div>
            </div>
        </div>   

        <?php include('footer.php'); ?>
<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#2a2e32" 
   href="<?php echo (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] ? 'view_mem.php' : '../../dashboard/coach/view_mem.php'); ?>">
    Return Back
</a>

    </div>

</div>

</body>

</html>    

<?php
} else {
    echo "<script>alert('Invalid access. Please return to the main page.');</script>";
}
?>
