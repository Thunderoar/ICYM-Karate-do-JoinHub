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
<<<<<<< HEAD
    <div class="col-sm-3">
        <a href="revenue_month.php">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-users"></i></div>
                <div style="font-size: 30px" class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Income This Month</h2><br>
=======
<div class="col-sm-3">
    <a href="revenue_month.php">
        <div class="tile-stats tile-red">
            <div class="icon"><i class="entypo-users"></i></div>
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Income This Month</h2><br>
>>>>>>> 31aa2ff6280f08a6e13a4bb730013ebf96d0f2b6
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date('Y-m');
$staffid = $_SESSION['staffid']; // Assuming this is set upon login

// Query to fetch the paid amount
$query_paid = "SELECT SUM(p.amount) as revenue 
               FROM enrolls_to et 
               JOIN plan p ON et.planid = p.planid 
               JOIN event_staff es ON es.planid = et.planid 
               WHERE et.paid_date LIKE '$date%' 
               AND et.hasPaid = 'yes' 
               AND et.hasApproved = 'yes' 
               AND es.staffid = '$staffid'";
$result_paid = mysqli_query($con, $query_paid);
$revenue = 0;

if ($result_paid && mysqli_num_rows($result_paid) > 0) {
    $row = mysqli_fetch_assoc($result_paid);
    $revenue = floatval($row['revenue']);
} else {
    error_log("No enrollments found for date: $date or query failed. Error: " . mysqli_error($con));
}

// Query to fetch the unpaid amount
$query_unpaid = "SELECT SUM(p.amount) as unpaid_amount 
                 FROM enrolls_to et 
                 JOIN plan p ON et.planid = p.planid 
                 JOIN event_staff es ON es.planid = et.planid 
                 WHERE et.paid_date LIKE '$date%' 
                 AND et.hasPaid = 'yes' 
                 AND et.hasApproved != 'yes' 
                 AND es.staffid = '$staffid'";
$result_unpaid = mysqli_query($con, $query_unpaid);
$unpaid_amount = 0;

if ($result_unpaid && mysqli_num_rows($result_unpaid) > 0) {
    $row = mysqli_fetch_assoc($result_unpaid);
    $unpaid_amount = floatval($row['unpaid_amount']);
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
<<<<<<< HEAD
    <a href="view_mem.php">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div style="font-size: 30px" class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Your <br>Students</h2><br>
                <?php
                // Assuming this is set upon login
                $staffid = $_SESSION['staffid'];
=======
<?php
$staffid = $_SESSION['staffid']; // Get logged-in staff ID
>>>>>>> 31aa2ff6280f08a6e13a4bb730013ebf96d0f2b6

// Query to get all members and their approval status for events assigned to the logged-in coach
$query = "SELECT 
    COUNT(DISTINCT u.userid) as total_members,
    SUM(CASE WHEN u.hasApproved = 'No' THEN 1 ELSE 0 END) as unapproved_members
FROM staff s
JOIN event_staff es ON s.staffid = es.staffid
JOIN plan p ON es.planid = p.planid
JOIN event_members em ON p.planid = em.planid
JOIN users u ON em.userid = u.userid
WHERE s.staffid = '$staffid'";

$result = mysqli_query($con, $query);
$counts = mysqli_fetch_array($result);

$total_members = $counts['total_members'] ?? 0;
$unapproved_members = $counts['unapproved_members'] ?? 0;
?>

<a href="view_mem.php">
    <div class="tile-stats tile-green">
        <div class="icon"><i class="entypo-chart-bar"></i></div>
        <div style="font-size:30px" class="num" data-postfix="" data-duration="1500" data-delay="0">
            <h2>Members in Your Events</h2><br>
            <?php
            echo $total_members;
            
            // Display unapproved count if any exist
            if ($unapproved_members > 0) {
                echo "<br><span style='font-size: 20px; color: #e74c3c;'>";
                echo "($unapproved_members Pending Approval)";
                echo "</span>";
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
