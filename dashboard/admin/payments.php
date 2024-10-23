<?php
require '../../include/db_conn.php';
page_protect();
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do  | Payments</title>
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
    <link rel="stylesheet" href="../../css/insidedashboard.css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
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

				<h2>Payments</h2>
<hr />

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Member ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>E-Mail</th>
            <th>Plan Name</th> <!-- New column for Plan Name -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php
$query = "SELECT e.*, u.username, u.mobile, u.email, p.planName 
          FROM enrolls_to e
          JOIN users u ON e.userid = u.userid
          JOIN plan p ON e.planid = p.planid
          ORDER BY e.expire";
$result = mysqli_query($con, $query);
$sno = 1;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $uid = $row['userid'];
        $planid = $row['planid'];
        $planName = $row['planName'];
        $hasPaid = $row['hasPaid'];

        echo "<tr>";
        echo "<td>" . $sno . "</td>";
        echo "<td>" . htmlspecialchars($row['userid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($planName) . "</td>"; // Display the plan name

        $sno++;

        // Only show "Add Payment" button if user has not paid
        if ($hasPaid === 'no') {
            echo "<td>
                    <form action='make_payments.php' method='post'>
                        <input type='hidden' name='userID' value='" . htmlspecialchars($uid) . "'/>
                        <input type='hidden' name='planID' value='" . htmlspecialchars($planid) . "'/>
                        <input type='submit' class='a1-btn a1-blue' value='Add Payment' class='btn btn-info'/>
                    </form>
                  </td>";
        } else {
            // Show "Undo Payment" button if the user has already paid
            echo "<td>
                    <form action='undo_payment.php' method='post'>
                        <input type='hidden' name='userID' value='" . htmlspecialchars($uid) . "'/>
                        <input type='hidden' name='planID' value='" . htmlspecialchars($planid) . "'/>
                        <input type='submit' class='a1-btn a1-red' value='Undo Payment' class='btn btn-warning'/>
                    </form>
                  </td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}
?>
    </tbody>
</table>



			<?php include('footer.php'); ?>
    	</div>

    </body>
</html>


