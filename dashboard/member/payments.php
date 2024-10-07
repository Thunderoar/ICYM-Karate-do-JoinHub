<?php
require '../../include/db_conn.php';
page_protect();
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title>SPORTS CLUB  | Payments</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
    <style>
    	.page-container .sidebar-menu #main-menu li#paymnt > a {
    	background-color: #2b303a;
    	color: #ffffff;
		}

    </style>

</head>
      <body class="page-body  page-fade" onload="collapseSidebar()">

    	<div class="page-container sidebar-collapsed" id="navbarcollapse">	
	
		<div class="sidebar-menu">
	
			<header class="logo-env">
			
			<!-- logo -->
			<?php
			 require('../../element/loggedin-logo.html');
			?>
			
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

							<li>Welcome <?php echo $_SESSION['full_name']; ?> 
							</li>								
						
							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>
						
					</div>
					
				</div>

				<table class="table table-bordered">
				<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Membership Expiry</th>
            <!-- <th>Name</th> -->
            <!-- <th>Member ID</th> -->
            <!-- <th>Phone</th> -->
            <!-- <th>E-Mail</th> -->
            <!-- <th>Gender</th> -->
            <th>Plan Name</th>
            <th>Amount</th>
			<th>Plan Type</th>
			<th>Validity</th>
			<th>Action</th>
        </tr>
    </thead>

    <tbody>

	<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['userid'])) {
    $logged_in_userid = $_SESSION['userid']; // Fetch the logged-in user's ID

    // Query to fetch only the logged-in user's plan details
    $query = "
        SELECT e.*, u.username, u.userid, u.mobile, u.email, u.gender, p.planName, p.amount, p.planType, p.validity 
        FROM enrolls_to e 
        JOIN users u ON e.userid = u.userid
        JOIN plan p ON e.planid = p.planid
        WHERE e.userid = '$logged_in_userid' AND e.renewal='yes'
        ORDER BY e.expire
    ";

    $result = mysqli_query($con, $query);
    $sno = 1;

    if (mysqli_affected_rows($con) != 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $uid = $row['userid'];
            $planid = $row['planid'];

            // Display the logged-in user's plan and personal details
            echo "<tr>";
            echo "<td>" . $sno . "</td>";
            echo "<td>" . $row['expire'] . "</td>";
            //echo "<td>" . $row['username'] . "</td>";
            //echo "<td>" . $row['userid'] . "</td>";
            //echo "<td>" . $row['mobile'] . "</td>";
            //echo "<td>" . $row['email'] . "</td>";
            //echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['planName'] . "</td>"; // Plan Name from the plan table
            echo "<td>" . $row['amount'] . "</td>"; // Amount from the plan table
            echo "<td>" . $row['planType'] . "</td>"; // Plan Type
            echo "<td>" . $row['validity'] . "</td>"; // Plan Validity
            $sno++;

            echo "<td>
                    <form action='make_payments.php' method='post'>
                        <input type='hidden' name='userID' value='" . $uid . "'/>
                        <input type='hidden' name='planID' value='" . $planid . "'/>
                        <input type='submit' class='a1-btn a1-blue' value='Add Payment' class='btn btn-info'/>
                    </form>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='12'>No records found for the logged-in user.</td></tr>";
    }
} else {
    echo "<tr><td colspan='12'>Please log in to view your membership details.</td></tr>";
}
?>

				
				</tbody>

		</table>


			<?php include('footer.php'); ?>
    	</div>

    </body>
</html>


