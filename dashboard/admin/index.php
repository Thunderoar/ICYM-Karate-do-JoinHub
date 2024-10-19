<?php
require '../../include/db_conn.php';
page_protect();
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

			<div class="col-sm-3"><a href="revenue_month.php">
				<div class="tile-stats tile-red">
					<div class="icon"><i class="entypo-users"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>Paid Income This Month</h2><br>
<?php
    // Set timezone and get current year and month in 'Y-m' format
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date  = date('Y-m');

    // Query to fetch all enrollments for the current month
    $query = "SELECT * FROM enrolls_to WHERE paid_date LIKE '$date%'";

    // Execute the query
    $result  = mysqli_query($con, $query);
    $revenue = 0;  // Initialize the revenue sum

    // Check if there are rows in the result
    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Get the plan details using planid from enrolls_to
            $query1 = "SELECT amount FROM plan WHERE planid='" . $row['planid'] . "'";
            $result1 = mysqli_query($con, $query1);
            
            if ($result1) {
                // Fetch the row for the selected plan
                $plan = mysqli_fetch_assoc($result1);

                // Add the amount to the total revenue, ensuring it is numeric
                $revenue += floatval($plan['amount']);
            }
        }
    }

    // Display the total revenue for the current month
    echo "RM" . number_format($revenue, 2); // Format the number to 2 decimal places
?>
						</div>
				</div></a>
			</div>


			<div class="col-sm-3"><a href="table_view.php">
				<div class="tile-stats tile-green">
					<div class="icon"><i class="entypo-chart-bar"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>Total <br>Members</h2><br>
							<?php
							$query = "select COUNT(*) from users";

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

<div class="col-sm-3">
    <a href="over_members_month.php">
        <div class="tile-stats tile-aqua">
            <div class="icon"><i class="entypo-mail"></i></div>
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Joined This Month</h2><br>
                <?php
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $date = date('Y-m'); // Get current year and month

                // Ensure the database connection is made
                require_once '../../include/db_conn.php'; 

                $query = "SELECT COUNT(*) as total FROM users WHERE joining_date LIKE '$date%'"; // Count the users joined this month
                $result = mysqli_query($con, $query); // Execute query

                if ($result) { // Check if the query was successful
                    $row = mysqli_fetch_assoc($result); // Fetch the result
                    echo $row['total']; // Display the count
                } else {
                    echo "Error: " . mysqli_error($con); // Display any error
                }
                ?>
            </div>
        </div>
    </a>
</div>

			<div class="col-sm-3"><a href="view_plan.php">
				<div class="tile-stats tile-blue">
					<div class="icon"><i class="entypo-rss"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>Total Plan Available</h2><br>
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

<!--marquee direction="right"><img src="fball.gif" width="88" height="70" alt="Tutorials " border="0"></marquee-->


<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#303641" href="../../">Go to Homepage</a>
    	<?php include('footer.php'); ?>
</div>


    </body>
</html>
