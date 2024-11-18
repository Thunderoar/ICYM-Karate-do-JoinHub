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

<?php
if (!isset($_SESSION['staffid'])) {
    die("Please login first");
}
$staffid = $_SESSION['staffid'];

// Modified query to get payment status for coach's assigned events
$query = "SELECT DISTINCT
            e.et_id,
            e.userid,
            e.planid,
            e.hasPaid,
            e.hasApproved,
            e.receiptIMG,
            u.username,
            u.mobile,
            u.email,
            p.planName,
            p.amount,
            p.planType
          FROM event_staff es
          INNER JOIN plan p ON es.planid = p.planid
          INNER JOIN enrolls_to e ON p.planid = e.planid
          INNER JOIN users u ON e.userid = u.userid
          WHERE es.staffid = ? 
          AND p.planType = 'event'
          ORDER BY e.expire";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $staffid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$sno = 1;
?>

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
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $uid = $row['userid'];
            $planid = $row['planid'];
            $planName = $row['planName'];
            $amount = $row['amount'] ?? 0;
            $hasPaid = $row['hasPaid'];
            $hasApproved = $row['hasApproved'];
            $et_id = $row['et_id'];
            $receiptIMG = $row['receiptIMG'];
            ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo htmlspecialchars($row['userid']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <?php 
                    echo htmlspecialchars($planName);
                    if ($amount > 0) {
                        echo " <b>(Fee: RM" . number_format($amount, 2) . ")</b>";
                    }
                    ?>
                </td>
                <td>
                    <?php if ($hasPaid === 'no'): ?>
                        <form action='../../dashboard/admin/make_payments.php' method='post'>
                            <input type='hidden' name='userID' value='<?php echo htmlspecialchars($uid); ?>'/>
                            <input type='hidden' name='planID' value='<?php echo htmlspecialchars($planid); ?>'/>
                            <input type='hidden' name='et_id' value='<?php echo htmlspecialchars($et_id); ?>'/>
                            <input type='submit' class='a1-btn a1-blue' value='Confirm Payment'/>
                        </form>
                        <p>Payment ID: <?php echo $et_id; ?></p>

                    <?php elseif ($hasPaid === 'yes' && $hasApproved === 'no'): ?>
                        <form action='../../dashboard/admin/approve_payment.php' method='post' style='display:inline;'>
                            <input type='hidden' name='userID' value='<?php echo htmlspecialchars($uid); ?>'/>
                            <input type='hidden' name='planID' value='<?php echo htmlspecialchars($planid); ?>'/>
                            <input type='hidden' name='et_id' value='<?php echo htmlspecialchars($et_id); ?>'/>
                            <input type='submit' class='a1-btn a1-green' value='Approve Payment'/>
                        </form>
                        <form action='../../dashboard/admin/cancel_payment.php' method='post' style='display:inline;'>
                            <input type='hidden' name='et_id' value='<?php echo htmlspecialchars($et_id); ?>'/>
                            <input type='hidden' name='userID' value='<?php echo htmlspecialchars($uid); ?>'/>
                            <input type='submit' class='a1-btn a1-yellow' value='Cancel Payment' 
                                   onclick='return confirm("Are you sure you want to cancel this payment?");'/>
                        </form>
                        
                        <?php if (!empty($receiptIMG)): ?>
                            <a href='<?php echo htmlspecialchars($receiptIMG); ?>' class='a1-btn a1-orange' target='_blank'>View Receipt</a>
                        <?php else: ?>
                            <p>No Receipt Available</p>
                        <?php endif; ?>
                        
                        <p>Payment Pending Approval</p>
                        <p>Payment ID: <?php echo $et_id; ?></p>

                    <?php elseif ($hasPaid === 'yes' && $hasApproved === 'yes'): ?>
                        <p>Payment Approved</p>
                        <p>Payment ID: <?php echo $et_id; ?></p>
                        
                        <?php if (!empty($receiptIMG)): ?>
                            <a href='<?php echo htmlspecialchars($receiptIMG); ?>' class='a1-btn a1-orange' target='_blank'>View Receipt</a>
                        <?php else: ?>
                            <p>No Receipt Available</p>
                        <?php endif; ?>

                        <form action='../../dashboard/admin/undo_payment.php' method='post' style='display:inline;'>
                            <input type='hidden' name='et_id' value='<?php echo htmlspecialchars($et_id); ?>'/>
                            <input type='hidden' name='userID' value='<?php echo htmlspecialchars($uid); ?>'/>
                            <input type='hidden' name='planID' value='<?php echo htmlspecialchars($planid); ?>'/>
                            <input type='submit' class='a1-btn a1-red' value='Undo Approved Payment' 
                                   onclick='return confirm("Are you sure you want to undo this payment?");'/>
                        </form>

                    <?php else: ?>
                        <p>No Action Needed</p>
                    <?php endif; ?>
                </td>
            </tr>
            <?php
            $sno++;
        }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
    </tbody>
</table>







			<?php include('footer.php'); ?>
    	</div>

    </body>
</html>


