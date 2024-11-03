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
          WHERE u.userid = ?";

// Prepare the SQL statement
if ($stmt = mysqli_prepare($con, $query)) {
    // Bind the user ID to the query (the "s" indicates string type)
    mysqli_stmt_bind_param($stmt, "s", $memid);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result set from the executed statement
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if a row is returned
    if (mysqli_num_rows($result) == 1) {
        // Fetch the row as an associative array
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        // Assign values using htmlspecialchars to sanitize
        $name        = htmlspecialchars($row['username']);
        $gender      = htmlspecialchars($row['gender']);
        $mobile      = htmlspecialchars($row['mobile']);
        $email       = htmlspecialchars($row['email']);
        $dob         = htmlspecialchars($row['dob']);         
        $jdate       = htmlspecialchars($row['joining_date']);
        $streetname  = htmlspecialchars($row['streetName'] ?? 'N/A');  // Handle nulls with 'N/A'
        $state       = htmlspecialchars($row['state'] ?? 'N/A');
        $city        = htmlspecialchars($row['city'] ?? 'N/A');
        $zipcode     = htmlspecialchars($row['zipcode'] ?? 'N/A');
        $calorie     = htmlspecialchars($row['calorie'] ?? 'N/A');
        $height      = htmlspecialchars($row['height'] ?? 'N/A');
        $weight      = htmlspecialchars($row['weight'] ?? 'N/A');
        $fat         = htmlspecialchars($row['fat'] ?? 'N/A');
        $planname    = htmlspecialchars($row['planName'] ?? 'No Plan');
        $pamount     = htmlspecialchars($row['amount'] ?? 'N/A');
        $pvalidity   = htmlspecialchars($row['validity'] ?? 'N/A');
        $pdescription= htmlspecialchars($row['description'] ?? 'N/A');
        $paiddate    = htmlspecialchars($row['paid_date'] ?? 'N/A');
        $expire      = htmlspecialchars($row['expire'] ?? 'N/A');
        $remarks     = htmlspecialchars($row['remarks'] ?? 'No remarks');
    } else {
        echo "<script>alert('No records found for the selected user.');</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Error handling if the query fails
    echo "<script>alert('Database query failed: " . mysqli_error($con) . "');</script>";
}
?>


			
			
			<div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
        <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
		<div class="a1-container a1-dark-gray a1-center">
        	<h6>EDIT MEMBER PROFILE</h6>
        </div>
       <form id="form1" name="form1" method="post" class="a1-container" action="edit_mem_submit.php">
         <table width="100%" border="0" align="center">
         <tr>
           <td height="35"><table width="100%" border="0" align="center">
           	 <tr>
           	   <td height="35">User ID:</td>
           	   <td height="35"><input id="boxxe" type="text" name="uid" readonly required value=<?php echo $memid?>></td>
         	   </tr>
             <tr>
               <td height="35">NAME:</td>
               <td height="35"><input id="boxxe" type="text" name="uname" value='<?php echo $name?>'></td>
             </tr>
             <tr>
               <td height="35">GENDER:</td>
               <td height="35"><select id="boxxe" name="gender" id="gender" required>

						<option <?php if($gender == 'Male'){echo("selected");}?> value="Male">Male</option>
						<option <?php if($gender == 'Female'){echo("selected");}?> value="Female">Female</option>
						</select></td><br>
             </tr>
			  <tr>
               <td height="35">MOBILE:</td>
               <td height="35"><input id="boxxe" type="number" name="phone" maxlength="10" value=<?php echo $mobile?>></td>
             </tr>
             <tr>
               <td height="35">EMAIL:</td>
               <td height="35"><input id="boxxe" type="email" name="email" required value=<?php echo $email?>></td>
             </tr>
			 <tr>
               <td height="35">DATE OF BIRTH:</td>
               <td height="35"><input type="date" id="boxxe" name="dob" value=<?php echo $dob?>></td>
             </tr>
			 <tr>
               <td height="35">JOINING DATE:</td>
               <td height="35"><input type="date" id="boxxe" name="jdate" value=<?php echo $jdate?>></td>
             </tr>

			<tr>
               <td height="35">STREET NAME:</td>
               <td height="35"><input type="text" id="boxxe" name="stname" value='<?php echo $streetname?>'></td>
             </tr>

			 <tr>
               <td height="35">STATE:</td>
               <td height="35"><input type="text" id="boxxe" name="state" value='<?php echo $state?>'></td>
             </tr>
			 <tr>
               <td height="35">CITY:</td>
               <td height="35"><input type="text" id="boxxe" name="city" value='<?php echo $city?>'></td>
             </tr>
             <tr>
               <td height="35">ZIPCODE:</td>
               <td height="35"><input type="text" id="boxxe" name="zipcode" value='<?php echo $zipcode?>'></td>
             </tr>
			 <tr>
               <td height="35">CALORIE:</td>
               <td height="35"><input type="text" id="boxxe" name="calorie" value=<?php echo $calorie?>></td>
             </tr>
			 <tr>
               <td height="35">HEIGHT:</td>
               <td height="35"><input type="text" id="boxxe" name="height" value=<?php echo $height?>></td>
             </tr>
			 <tr>
               <td height="35">WEIGHT:</td>
               <td height="35"><input type="text" id="boxxe" name="weight" value=<?php echo $weight?>></td>
             </tr>
			 <tr>
               <td height="35">FAT:</td>
               <td height="35"><input type="text" id="boxxe" name="fat" value=<?php echo $fat?>></td>
             </tr>
			 <tr>
               <td height="35">REMARKS:</td>
               <td height="35"><textarea style="resize:none; margin: 0px; width: 230px; height: 53px;" name="remarks" id="boxxe" ><?php echo $remarks?></textarea></td>
             </tr>
			 
			 
			 
             <br>
            
             <tr>
<tr>
    <td height="35">&nbsp;</td>
    <td height="35">
        <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="UPDATE">
        <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
        <input class="a1-btn a1-blue" type="button" value="Return" onclick="window.location.href='view_mem.php'">
    </td>
</tr>

           </table></td>
         </tr>
         </table>
       </form>
    </div>
    </div>   
			
			
			
			
					

			<?php include('footer.php'); ?>
    	</div>

  
</body>
</html>	

<?php
} else {
    
}
?>
