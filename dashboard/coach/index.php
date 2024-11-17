<?php
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

.tile-stats {
    display: flex;
    flex-direction: column; /* Stacks elements vertically */
    justify-content: space-between; /* Makes sure contents fill the height */
    height: 100%; /* Ensures all boxes take the same height */
}

/* Hover Effects */
.tile-stats:hover {
    transform: scale(1.05); /* Slightly enlarges the tile */
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); /* Adds a shadow */
}
.custom-tile {
    padding: 10px 0;
    color: white;
    text-align: center;
    border-radius: 4px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    /* Smooth transition for hover effects */
}

.custom-tile.redcolor {
    background-color: #f56954;
}

.custom-tile.greencolor {
    background-color: #4CAF50;
}

.custom-tile.deepbluecolor {
    background-color: #0073b7;
}

.custom-tile .num h4 {
    margin: 0;
    font-size: 15px;
}

/* Hover Effects */
.custom-tile:hover {
    transform: scale(1.05); /* Slightly enlarges the tile */
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); /* Adds a shadow */
}

/* Optional: Change background color slightly on hover */
.custom-tile.redcolor:hover {
    background-color: #e74c3c; /* Darker red */
}

.custom-tile.greencolor:hover {
    background-color: #388e3c; /* Darker green */
}

.custom-tile.deepbluecolor:hover {
    background-color: #005b9f; /* Darker blue */
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

			<h2>ICYM Karate-Do</h2>

			<hr>

<div class="row">
    <div class="col-sm-3">
        <a href="revenue_month.php">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-users"></i></div>
                <div style="font-size: 30px" class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Income This Month</h2><br>
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date('Y-m');
$staffid = $_SESSION['staffid']; // Assuming this is set upon login

// Modified query to fetch the paid amount
$query_paid = "SELECT et.planid, p.amount 
               FROM enrolls_to et 
               JOIN plan p ON et.planid = p.planid 
               JOIN event_staff es ON es.planid = p.planid 
               WHERE et.paid_date LIKE '$date%' 
               AND et.hasPaid = 'yes' 
               AND et.hasApproved = 'yes' 
               AND es.staffid = '$staffid'";
$result_paid = mysqli_query($con, $query_paid);
$revenue = 0;

if ($result_paid && mysqli_num_rows($result_paid) > 0) {
    while ($row = mysqli_fetch_assoc($result_paid)) {
        $revenue += floatval($row['amount']);
    }
} else {
    error_log("No enrollments found for date: $date or query failed. Error: " . mysqli_error($con));
}

// Modified query to fetch the unpaid amount
$query_unpaid = "SELECT et.planid, p.amount 
                 FROM enrolls_to et 
                 JOIN plan p ON et.planid = p.planid 
                 JOIN event_staff es ON es.planid = p.planid 
                 WHERE et.hasPaid = 'yes' 
                 AND et.hasApproved != 'yes' 
                 AND es.staffid = '$staffid'";
$result_unpaid = mysqli_query($con, $query_unpaid);
$unpaid_amount = 0;

if ($result_unpaid && mysqli_num_rows($result_unpaid) > 0) {
    while ($row = mysqli_fetch_assoc($result_unpaid)) {
        $unpaid_amount += floatval($row['amount']);
    }
} else {
    error_log("No unpaid enrollments found for date: $date or query failed. Error: " . mysqli_error($con));
}

// Format and display the revenue and unpaid amount
echo "RM" . number_format($revenue, 2) . " (Unpaid: RM" . number_format($unpaid_amount, 2) . ")";
?>
                </div>
            </div>
        </a>
		    <a href="payments.php">
        <div class="custom-tile redcolor">
            <div class="num" style="display: flex; align-items: center; justify-content: center;">
                <i class="entypo-star" style="margin-right: 10px;"></i>
                <h4>Manage Payment</h4>
            </div>
        </div>
    </a>
    </div>


<div class="col-sm-3">
    <a href="view_mem.php">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div style="font-size: 30px" class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Your <br>Students</h2><br>
                <?php
                // Assuming this is set upon login
                $staffid = $_SESSION['staffid'];

                // Query to count all approved members the coach is responsible for
                $query_total = "SELECT COUNT(DISTINCT e.userid) as total_members
                                FROM enrolls_to e
                                JOIN plan p ON e.planid = p.planid
                                JOIN event_staff es ON es.planid = p.planid
                                JOIN users u ON e.userid = u.userid
                                WHERE es.staffid = '$staffid' 
                                AND e.hasPaid = 'yes' 
                                AND e.hasApproved = 'yes'";
                $result_total = mysqli_query($con, $query_total);
                $total_members = 0;
                if ($result_total) {
                    $row_total = mysqli_fetch_array($result_total);
                    $total_members = $row_total['total_members'];
                }

                // Query to count unapproved members the coach is responsible for
                $query_unapproved = "SELECT COUNT(DISTINCT e.userid) as unapproved_members
                                     FROM enrolls_to e
                                     JOIN plan p ON e.planid = p.planid
                                     JOIN event_staff es ON es.planid = p.planid
                                     JOIN users u ON e.userid = u.userid
                                     WHERE es.staffid = '$staffid' 
                                     AND (e.hasPaid != 'yes' OR e.hasApproved != 'yes')";
                $result_unapproved = mysqli_query($con, $query_unapproved);
                $unapproved_members = 0;
                if ($result_unapproved) {
                    $row_unapproved = mysqli_fetch_array($result_unapproved);
                    $unapproved_members = $row_unapproved['unapproved_members'];
                }

                // Display total members and unapproved members in parentheses
                echo $total_members;
                if ($unapproved_members > 0) {
                    echo " <br>($unapproved_members Unapproved: Pending Payment)";
                }
                ?>
            </div>
        </div>
    </a>
	<a href="view_mem.php">
    <div class="custom-tile greencolor" style="margin-top:10px;">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
            <i class="entypo-users" style="margin-right: 10px;"></i>
            <h4>Manage Your Student</h4>
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
				<a href="view_plan.php">
    <div class="custom-tile deepbluecolor" style="margin-top:10px;">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
            <i class="entypo-quote" style="margin-right: 10px;"></i>
            <h4>Manage Event</h4>
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
