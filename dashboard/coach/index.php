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
    	.page-container .sidebar-menu #main-menu li#dash > a {
    	background-color: #2b303a;
    	color: #ffffff;
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
.row {
    display: flex; /* Enables flexbox layout */
    flex-wrap: wrap; /* Allows wrapping of tiles on smaller screens */
    justify-content: space-between; /* Space between tiles */
}

.tile-stats {
    display: flex; /* Make the tile-stats a flex container */
    flex-direction: column; /* Stack elements vertically */
    justify-content: space-between; /* Distribute space evenly */
    height: 100%; /* Ensures all boxes take the same height */
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
        <a href="payments.php">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>You have paid</h2><br>
                    <?php
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $date = date('Y-m');
                    $query = "SELECT * FROM enrolls_to WHERE paid_date LIKE '$date%'";
                    $result = mysqli_query($con, $query);
                    $revenue = 0;
                    if (mysqli_affected_rows($con) != 0) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $query1 = "SELECT * FROM plan WHERE planid='" . $row['planid'] . "'";
                            $result1 = mysqli_query($con, $query1);
                            if ($result1) {
                                $value = mysqli_fetch_row($result1);
                                $revenue += floatval($value[4]); // Summing up the revenue
                            }
                        }
                    }
                    echo "RM" . number_format($revenue, 2); // Format the revenue
                    ?>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="new_health_status.php">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-chart-bar"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Healthy!<br></h2><br>
                    <?php
                    $query = "SELECT COUNT(*) FROM users";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        $row = mysqli_fetch_array($result);
                        echo $row['COUNT(*)'];
                    }
                    ?>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="viewroutine.php">
            <div class="tile-stats tile-aqua">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Today's activity</h2><br>
                    <?php
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $date = date('Y-m');
                    $query = "SELECT COUNT(*) FROM users WHERE joining_date LIKE '$date%'";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        $row = mysqli_fetch_array($result);
                        echo $row['COUNT(*)'];
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
                    <h2>Joined Activity</h2><br>
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
    </div>
</div>

<!--marquee direction="right"><img src="fball.gif" width="88" height="70" alt="Tutorials " border="0"></marquee-->



    	<?php include('footer.php'); ?>
</div>

<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#303641" href="../../">Go to Homepage</a>  
    </body>
</html>
