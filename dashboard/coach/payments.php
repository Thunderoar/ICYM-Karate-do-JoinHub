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
			
					<!-- logo collapse icon 
					<div class="sidebar-collapse" onclick="collapseSidebar()">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition
					<i class="entypo-menu"></i>
				</a>
			</div>-->
							
			
		
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
            <th>Plan Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php
// Assuming the coach's staffid is stored in the session after login
if (!isset($_SESSION['staffid'])) {
    die("Please login first");
}
$staffid = $_SESSION['staffid'];

// Modified query to only show payments for events where the coach is assigned
$query = "SELECT e.*, u.username, u.mobile, u.email, p.planName 
          FROM enrolls_to e
          JOIN users u ON e.userid = u.userid
          JOIN plan p ON e.planid = p.planid
          JOIN event_staff es ON e.planid = es.planid
          WHERE es.staffid = ? 
          AND p.planType = 'event'  -- Assuming there's a planType column to distinguish events
          ORDER BY e.expire";

// Using prepared statement for security
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $staffid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$sno = 1;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $uid = $row['userid'];
        $planid = $row['planid'];
        $planName = $row['planName'];
        $hasPaid = $row['hasPaid'];
        $hasApproved = $row['hasApproved'];
        $et_id = $row['et_id'];
        $receiptIMG = $row['receiptIMG'];

        echo "<tr>";
        echo "<td>" . $sno . "</td>";
        echo "<td>" . htmlspecialchars($row['userid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($planName) . "</td>";

        $sno++;

        // Action based on payment and approval status
        if ($hasPaid === 'no') {
            echo "<td>
                    <form action='../../dashboard/admin/make_payments.php' method='post'>
                        <input type='hidden' name='userID' value='" . htmlspecialchars($uid) . "'/>
                        <input type='hidden' name='planID' value='" . htmlspecialchars($planid) . "'/>
                        <input type='hidden' name='et_id' value='" . htmlspecialchars($et_id) . "'/>
                        <input type='submit' class='a1-btn a1-blue' value='Confirm Payment'/>
                    </form>
                    <p>Payment ID: $et_id</p>
                  </td>";
        } elseif ($hasPaid === 'yes' && $hasApproved === 'no') {
            echo "<td>
                    <form action='../../dashboard/admin/approve_payment.php' method='post' style='display:inline;'>
                        <input type='hidden' name='userID' value='" . htmlspecialchars($uid) . "'/>
                        <input type='hidden' name='planID' value='" . htmlspecialchars($planid) . "'/>
                        <input type='hidden' name='et_id' value='" . htmlspecialchars($et_id) . "'/>
                        <input type='submit' class='a1-btn a1-green' value='Approve Payment'/>
                    </form>
                    <form action='../../dashboard/admin/cancel_payment.php' method='post' style='display:inline;'>
                        <input type='hidden' name='et_id' value='" . htmlspecialchars($et_id) . "'/>
                        <input type='hidden' name='userID' value='" . htmlspecialchars($uid) . "'/>
                        <input type='submit' class='a1-btn a1-yellow' value='Cancel Payment' onclick='return confirm(\"Are you sure you want to cancel this payment?\");'/>
                    </form>";
            
            if (!empty($receiptIMG)) {
                echo "<a href='$receiptIMG' class='a1-btn a1-orange' target='_blank'>View Receipt</a>";
            } else {
                echo "<p>No Receipt Available</p>";
            }
            
            echo "<p>Payment Pending Approval</p>
                    <p>Payment ID: $et_id</p>
                  </td>";
        } elseif ($hasPaid === 'yes' && $hasApproved === 'yes') {
            echo "<td>
                    <p>Payment Approved</p>
                    <p>Payment ID: $et_id</p>";

            if (!empty($receiptIMG)) {
                echo "<a href='$receiptIMG' class='a1-btn a1-orange' target='_blank'>View Receipt</a>";
            } else {
                echo "<p>No Receipt Available</p>";
            }

            echo "<form action='../../dashboard/admin/undo_payment.php' method='post' style='display:inline;'>
                    <input type='hidden' name='et_id' value='" . htmlspecialchars($et_id) . "'/>
                    <input type='hidden' name='userID' value='" . htmlspecialchars($uid) . "'/>
                    <input type='hidden' name='planID' value='" . htmlspecialchars($planid) . "'/>
                    <input type='submit' class='a1-btn a1-red' value='Undo Approved Payment' onclick='return confirm(\"Are you sure you want to undo this payment?\");'/>
                  </form>";

            echo "</td>";
        } else {
            echo "<td>No Action Needed</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}

// Clean up
mysqli_stmt_close($stmt);
?>
    </tbody>
</table>







			<?php include('footer.php'); ?>
    	</div>

    </body>
</html>


