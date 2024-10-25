﻿<?php
require '../../include/db_conn.php';
page_protect();

// Assuming you have the user ID stored in the session after login
$userId = $_SESSION['userid'];

// Check if the user is approved
$query = "SELECT hasApproved FROM users WHERE userid = '$userId'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$isApproved = $row['hasApproved'];

?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <title>ICYM Karate-Do Hub  | Dashboard </title>
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link rel="stylesheet" href="../../css/insidedashboard.css">
    <link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
        .page-container .sidebar-menu #main-menu li#dash > a {
            background-color: #2b303a;
            color: #ffffff;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .tile-stats {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        /* Style for the approval message */
        .approval-message {
            color: grey;
            font-size: 36px; /* Change size as needed */
            text-align: center;
            margin: 20px 0; /* Add some spacing around the message */
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
                        <?php require('../../element/loggedin-welcome.html'); ?>
                        <li>
                            <a href="logout.php">
                                Log Out <i class="entypo-logout right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <h2>ICYM Karate-Do Hub</h2>
            <hr>

            <?php if ($isApproved == 'No'): ?>
                <div class="approval-message">You have not been approved yet.</div>
				<div class="approval-message">Please wait for approval by the Club Manager.</div><br>
            <?php else: ?>
                <div class="row">
			<div class="col-sm-3"><a href="payments.php">
				<div class="tile-stats tile-red">
					<div class="icon"><i class="entypo-users"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>You have paid</h2><br>
						<?php
							date_default_timezone_set("Asia/Kuala_Lumpur");
							$date  = date('Y-m');
							$query = "select * from enrolls_to WHERE  paid_date LIKE '$date%'";
							//echo $query;
							$result  = mysqli_query($con, $query);
							$revenue = 0;
							if (mysqli_affected_rows($con) != 0) {
								while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
									$query1 = "SELECT * FROM plan WHERE planid='" . $row['planid'] . "'";
									$result1 = mysqli_query($con, $query1);
									
									if ($result1) {
										$value = mysqli_fetch_row($result1);
										
										// Ensure both $value[4] and $revenue are numeric before addition
										$revenue = floatval($value[4]) + floatval($revenue);
									}
								}
							}
							echo "RM".$revenue;
							?>
						</div>
				</div></a>
			</div>
			<div class="col-sm-3"><a href="new_health_status.php">
				<div class="tile-stats tile-green">
					<div class="icon"><i class="entypo-chart-bar"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>Healthy!<br></h2><br>
							<?php
							$query = "select COUNT(*) from users";
							$result = mysqli_query($con, $query);
							$i      = 1;
							if (mysqli_affected_rows($con) != 0) {
							    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
							        //echo $row['COUNT(*)'];
							    }
							}
							$i = 1;
							?>
						</div>
				</div></a>
			</div>
			<div class="col-sm-3"><a href="viewroutine.php">
				<div class="tile-stats tile-aqua">
					<div class="icon"><i class="entypo-mail"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>Today's activity</h2><br>
							<?php
							date_default_timezone_set("Asia/Kuala_Lumpur");
							$date  = date('Y-m');
							$query = "select COUNT(*) from users WHERE joining_date LIKE '$date%'";
							//echo $query;
							$result = mysqli_query($con, $query);
							$i      = 1;
							if (mysqli_affected_rows($con) != 0) {
							    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
							        echo $row['COUNT(*)'];
							    }
							}
							$i = 1;
							?>
						</div>
				</div></a>
			</div>
			<div class="col-sm-3"><a href="view_plan.php">
				<div class="tile-stats tile-blue">
					<div class="icon"><i class="entypo-rss"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>Joined Activity</h2><br>
							<?php
							$query = "select COUNT(*) from plan where active='yes'";
							//echo $query;
							$result  = mysqli_query($con, $query);
							$i = 1;
							if (mysqli_affected_rows($con) != 0) {
							    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
							        echo $row['COUNT(*)'];
							    }
							}
							$i = 1;
							?>
						</div>
				</div></a>
			</div>
                </div>
            <?php endif; ?>

            <a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#303641" href="../../">Go to Homepage</a>
            <?php include('footer.php'); ?>
        </div>
    </div>
</body>
</html>
