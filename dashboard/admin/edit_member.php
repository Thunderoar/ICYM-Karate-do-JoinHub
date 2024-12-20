﻿<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>SPORTS CLUB | Edit Member</title>
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link href="a1style.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="../../css/dashboard/sidebar.css">
	
	<style>
 	#button1
	{
	width:126px;
	}
	#boxxe
	{
		width:230px;
	}
	.page-container .sidebar-menu #main-menu li#hassubopen > a {
	background-color: #2b303a;
	color: #ffffff;
	}

	</style>

</head>
    <body class="page-body  page-fade" onload="collapseSidebar()">

    	<div class="page-container sidebar-collapsed" id="navbarcollapse">	
	
		<div class="sidebar-menu">
	
			<header class="logo-env">
			
      <?php require('../../element/loggedin-logo.html'); ?>
			
					<!-- logo collapse icon -->
					<div class="sidebar-collapse" onclick="collapseSidebar()">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a>
			</div>
							
			
		
			</header>
    		<?php include('nav.php'); ?>
    	</div>

    		<div class="main-content">
		
				<div class="row">
					
					<!-- Profile Info and Notifications -->
					<div class="col-md-6 col-sm-8 clearfix">	

					</div>
				
					<!-- Raw Links -->
					<div class="col-md-6 col-sm-4 clearfix hidden-xs">
						
						<ul class="list-inline links-list pull-right">


						<?php
						require('../../element/loggedin-welcome.html');
					?>
							</li>							
						
							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>
					</div>
			</div>
			<h3>Edit Member Details</h3>
			
			<hr/>
<?php
// Initialize variables with default values
$name = $gender = $mobile = $email = $dob = $jdate = '';
$streetname = $state = $city = $zipcode = '';
$calorie = $height = $weight = $fat = $remarks = '';
$planname = $pamount = $pvalidity = $pdescription = '';
$paiddate = $expire = '';

// Retrieve the memid from the POST request
if (isset($_POST['memid'])) {
    $memid = mysqli_real_escape_string($con, $_POST['memid']);

    // SQL query to retrieve user, address, health, enrolls, and plan data using LEFT JOIN
    $query = "SELECT u.username, u.gender, u.mobile, u.email, u.dob, u.joining_date, 
                     a.streetName, a.state, a.city, a.zipcode, 
                     h.calorie, h.height, h.weight, h.fat, h.remarks, 
                     p.planName, p.description, p.planType, p.validity, p.amount, 
                     e.paid_date, e.expire, e.hasPaid
              FROM users u
              LEFT JOIN address a ON u.userid = a.userid
              LEFT JOIN health_status h ON u.userid = h.userid
              LEFT JOIN enrolls_to e ON u.userid = e.userid
              LEFT JOIN plan p ON e.planid = p.planid
              WHERE u.userid = '$memid'";

    // Execute the query
    $result = mysqli_query($con, $query);

    // Check if a row is returned
    if (mysqli_num_rows($result) == 1) {
        // Fetch the row as an associative array
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        // Assign values using htmlspecialchars to sanitize
        $name = htmlspecialchars($row['username'] ?? 'No name available');
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

    // Close the connection
    mysqli_close($con);
} else {
    echo "<script>alert('User ID not provided.');</script>";
}
?>




			
			
<div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
    <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
        <div class="a1-container a1-dark-gray a1-center">
            <h6>EDIT MEMBER PROFILE</h6>
        </div>
        <form id="form1" name="form1" method="post" class="a1-container" action="edit_mem_submit.php">
            <table width="100%" border="0" align="center">
                <!-- Personal Details Section -->
                <tr>
                    <td colspan="2" class="a1-dark-gray a1-center"><strong>Personal Details</strong></td>
                </tr>
                <tr>
                    <td>User ID:</td>
                    <td><input id="boxxe" type="text" name="uid" readonly required value=<?php echo $memid ?>></td>
                </tr>
                <tr>
                    <td>NAME:</td>
                    <td><input id="boxxe" type="text" name="uname" value='<?php echo $name ?>'></td>
                </tr>
                <tr>
                    <td>GENDER:</td>
                    <td>
                        <select id="boxxe" name="gender" required>
                            <option <?php if($gender == 'Male'){echo("selected");}?> value="Male">Male</option>
                            <option <?php if($gender == 'Female'){echo("selected");}?> value="Female">Female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>DATE OF BIRTH:</td>
                    <td><input type="date" id="boxxe" name="dob" value=<?php echo $dob ?>></td>
                </tr>
                <!-- Contact Details Section -->
                <tr>
                    <td colspan="2" class="a1-dark-gray a1-center"><strong>Contact Details</strong></td>
                </tr>
                <tr>
                    <td>MOBILE:</td>
                    <td><input id="boxxe" type="number" name="phone" maxlength="10" value=<?php echo $mobile ?>></td>
                </tr>
                <tr>
                    <td>EMAIL:</td>
                    <td><input id="boxxe" type="email" name="email" required value=<?php echo $email ?>></td>
                </tr>
                <!-- Address Details Section -->
                <tr>
                    <td colspan="2" class="a1-dark-gray a1-center"><strong>Address Details</strong></td>
                </tr>
                <tr>
                    <td>STREET NAME:</td>
                    <td><input type="text" id="boxxe" name="stname" value='<?php echo $streetname ?>'></td>
                </tr>
                <tr>
                    <td>STATE:</td>
                    <td><input type="text" id="boxxe" name="state" value='<?php echo $state ?>'></td>
                </tr>
                <tr>
                    <td>CITY:</td>
                    <td><input type="text" id="boxxe" name="city" value='<?php echo $city ?>'></td>
                </tr>
                <tr>
                    <td>ZIPCODE:</td>
                    <td><input type="text" id="boxxe" name="zipcode" value='<?php echo $zipcode ?>'></td>
                </tr>
                <!-- Membership Details Section -->
                <tr>
                    <td colspan="2" class="a1-dark-gray a1-center"><strong>Membership Details</strong></td>
                </tr>
                <tr>
                    <td>JOINING DATE:</td>
                    <td><input type="date" id="boxxe" name="jdate" value=<?php echo $jdate ?>></td>
                </tr>
                <!-- Health Metrics Section -->
                <tr>
                    <td colspan="2" class="a1-dark-gray a1-center"><strong>Health Metrics</strong></td>
                </tr>
                <tr>
                    <td>CALORIE:</td>
                    <td><input type="text" id="boxxe" name="calorie" value=<?php echo $calorie ?>></td>
                </tr>
                <tr>
                    <td>HEIGHT:</td>
                    <td><input type="text" id="boxxe" name="height" value=<?php echo $height ?>></td>
                </tr>
                <tr>
                    <td>WEIGHT:</td>
                    <td><input type="text" id="boxxe" name="weight" value=<?php echo $weight ?>></td>
                </tr>
                <tr>
                    <td>FAT:</td>
                    <td><input type="text" id="boxxe" name="fat" value=<?php echo $fat ?>></td>
                </tr>
                <!-- Additional Section -->
                <tr>
                    <td colspan="2" class="a1-dark-gray a1-center"><strong>Additional Details</strong></td>
                </tr>
                <tr>
                    <td>REMARKS:</td>
                    <td><textarea style="resize:none; margin: 0px; width: 230px; height: 53px;" name="remarks" id="boxxe"><?php echo $remarks ?></textarea></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="UPDATE">
                        <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
                    </form>
                    <form action='viewall_detail.php' method='post' style="display:inline;">
                        <input type='hidden' name='name' value='<?php echo htmlspecialchars($memid); ?>'/>
                        <input type='submit' class='a1-btn a1-blue' value='Return'/>
                    </form>
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
