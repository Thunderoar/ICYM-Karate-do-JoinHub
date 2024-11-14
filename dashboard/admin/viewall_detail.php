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

// Fetch member details
$query = "SELECT * FROM users u
LEFT JOIN address a ON u.userid = a.userid
LEFT JOIN health_status h ON u.userid = h.userid
LEFT JOIN enrolls_to e ON u.userid = e.userid
LEFT JOIN plan p ON e.planid = p.planid
WHERE u.userid = ?";

if ($stmt = mysqli_prepare($con, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $memid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        // Assign values
        $name = htmlspecialchars($row['username'] ?? '');
        $gender = htmlspecialchars($row['gender'] ?? '');
        $mobile = htmlspecialchars($row['mobile'] ?? '');
        $email = htmlspecialchars($row['email'] ?? '');
        $dob = htmlspecialchars($row['dob'] ?? '');
        $jdate = htmlspecialchars($row['joining_date'] ?? '');
        $streetname = htmlspecialchars($row['streetName'] ?? '');
        $state = htmlspecialchars($row['state'] ?? '');
        $city = htmlspecialchars($row['city'] ?? '');
        $zipcode = htmlspecialchars($row['zipcode'] ?? '');
        $calorie = htmlspecialchars($row['calorie'] ?? '');
        $height = htmlspecialchars($row['height'] ?? '');
        $weight = htmlspecialchars($row['weight'] ?? '');
        $fat = htmlspecialchars($row['fat'] ?? '');
        $planname = htmlspecialchars($row['planName'] ?? '');
        $pamount = htmlspecialchars($row['amount'] ?? '');
        $pvalidity = htmlspecialchars($row['validity'] ?? '');
        $pdescription = htmlspecialchars($row['description'] ?? '');
        $paiddate = htmlspecialchars($row['paid_date'] ?? '');
        $expire = htmlspecialchars($row['expire'] ?? '');
        $remarks = htmlspecialchars($row['remarks'] ?? '');
    } else {
        echo "<script>alert('No records found for the selected user.');</script>";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Database query failed.');</script>";
}
?>



        <div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
            <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
                <div class="a1-container a1-dark-gray a1-center">
                    <h6>Edit Member Details</h6>
                </div>
                <form id="form1" name="form1" method="post" class="a1-container" action="edit_member.php">
                    <table width="100%" border="0" align="center">
                        <tbody>
                            <tr>
                                <td height="35">USER ID:</td>
                                <td height="35"><input type="text" name="name" id="boxxe" readonly value='<?php echo $memid ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">NAME:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $name ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">GENDER:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $gender ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">MOBILE:</td>
                                <td height="35"><input type="text" id="boxxe" readonly maxlength="10" value='<?php echo $mobile ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">EMAIL:</td>
                                <td height="35"><input type="email" id="boxxe" readonly required value='<?php echo $email ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">DATE OF BIRTH:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $dob ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">JOINING DATE:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $jdate ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">STREET NAME:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $streetname ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">STATE:</td>
                                <td height="35"><input type="text" id="boxxe" readonly name="state" value='<?php echo $state ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">CITY:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $city ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">ZIPCODE:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $zipcode ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">CALORIE:</td>
                                <td height="35"><input type="text" id="boxxe" readonly value='<?php echo $calorie ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">HEIGHT:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $height ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">WEIGHT:</td>
                                <td height="35"><input type="text" readonly value='<?php echo $weight ?>' id="boxxe"></td>
                            </tr>
                            <tr>
                                <td height="35">FAT:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $fat ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">PLAN NAME:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $planname ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">PLAN AMOUNT:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $pamount ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">PLAN VALIDITY:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $pvalidity . ' Month' ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">PLAN DESCRIPTION:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $pdescription ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">PAID DATE:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $paiddate ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">EXPIRED DATE:</td>
                                <td height="35"><input type="text" readonly id="boxxe" value='<?php echo $expire ?>'></td>
                            </tr>
                            <tr>
                                <td height="35">REMARKS:</td>
                                <td height="35">
                                    <textarea readonly style="resize:none; margin: 0px; width: 230px; height: 53px;"><?php echo $remarks ?></textarea>
                                </td>
                            </tr>
<tr>
    <td height="35">&nbsp;</td>
    <td height="35">
        <input class="a1-btn" type="submit" name="submit" id="submit" value="EDIT" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px;"> <!-- Green color -->
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
