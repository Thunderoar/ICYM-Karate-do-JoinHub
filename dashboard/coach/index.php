﻿<?php
require '../../include/db_conn.php';
page_protect();
?>
<!DOCTYPE html>
<html lang="en">
<head> 

    
    <title>ICYM Karate-Do  | Dashboard </title>

    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
     <style>
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
    <body class="page-body  page-fade" onload="collapseSidebar()">

    	<div class="page-container sidebar-collapsed" id="navbarcollapse">	
	
		<div class="sidebar-menu">
	
			<header class="logo-env">
			
			<!-- logo -->
			<div class="logo">
				<a href="main.php">
					<img src="../../images/logok.png" alt="" width="192" height="80" />
				</a>
			</div>
			
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

							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>

					</div>

				</div>

			<h2>SPORTS CLUB </h2>

			<hr>

<div class="row">
    <div class="col-sm-3">
        <a href="revenue_month.php">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Paid Income This Month</h2><br>
                    <?php
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $date = date('Y-m');
                    // Modified query to include hasPaid and hasApproved conditions
                    $query = "SELECT enrolls_to.* FROM enrolls_to 
                             WHERE paid_date LIKE '$date%' 
                             AND hasPaid = 'yes' 
                             AND hasApproved = 'yes'";
                    $result = mysqli_query($con, $query);
                    $revenue = 0;
                    if (mysqli_num_rows($result) != 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $query1 = "SELECT amount FROM plan WHERE planid='" . $row['planid'] . "'";
                            $result1 = mysqli_query($con, $query1);
                            if ($result1) {
                                $plan = mysqli_fetch_assoc($result1);
                                $revenue += floatval($plan['amount']);
                            }
                        }
                    }
                    echo "RM" . number_format($revenue, 2); // Format to 2 decimal places
                    ?>
                </div>
            </div>
        </a>
    </div>

<div class="col-sm-3">
    <a href="view_mem.php">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Total <br>Members</h2><br>
                <?php
                // Query to count all users
                $query_total = "SELECT COUNT(*) as total_members FROM users";
                $result_total = mysqli_query($con, $query_total);
                $total_members = 0;
                if ($result_total) {
                    $row_total = mysqli_fetch_array($result_total);
                    $total_members = $row_total['total_members'];
                }
                // Query to count unapproved users (where hasApproved is 'No')
                $query_unapproved = "SELECT COUNT(*) as unapproved_members FROM users WHERE hasApproved = 'No'";
                $result_unapproved = mysqli_query($con, $query_unapproved);
                $unapproved_members = 0;
                if ($result_unapproved) {
                    $row_unapproved = mysqli_fetch_array($result_unapproved);
                    $unapproved_members = $row_unapproved['unapproved_members'];
                }
                // Display total members and unapproved members in parentheses
                echo $total_members;
                if ($unapproved_members > 0) {
                    echo " <br>($unapproved_members Unapproved)";
                }
                ?>
            </div>
        </div>
    </a>
</div>

    <div class="col-sm-3">
        <a href="over_members_month.php">
            <div class="tile-stats tile-aqua">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Joined This Month</h2><br>
                    <?php
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $date = date('Y-m');
                    $query = "SELECT COUNT(*) as total FROM users WHERE joining_date LIKE '$date%'";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                    ?>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="view_plan.php">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-rss"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Total Active Event</h2><br>
                    <?php
                    $query = "SELECT COUNT(*) FROM plan WHERE active='yes'";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        $row = mysqli_fetch_array($result);
                        echo $row['COUNT(*)'];
                    }
                    ?>
                </div>
            </div>
        </a>
		<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#303641" href="../../">Go to Homepage</a>  
    </div>
</div>

<!--marquee direction="right"><img src="fball.gif" width="88" height="70" alt="Tutorials " border="0"></marquee-->



    	<?php include('footer.php'); ?>
</div>


    </body>
</html>
