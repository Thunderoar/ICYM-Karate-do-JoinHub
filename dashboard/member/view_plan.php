﻿
<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do  | View Plan</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link href="a1style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
	<style>
 		#button1
		{
		width:126px;
		}
		.page-container .sidebar-menu #main-menu li#planhassubopen > a {
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

		<h3>Manage Plan</h3>

		<hr />

<table class="table table-bordered datatable" id="table-1" border=1>
    <thead>
        <tr>
            <th>No</th>
            <th>Plan name</th>
            <th>Plan Details</th>
            <th>Duration</th>
            <th>Rate</th>
            <th>Action</th>
        </tr>
    </thead>		
    <tbody>
    <?php
    $userid = $_SESSION['userid']; // Make sure session has started and userid is available
    $query  = "SELECT * FROM plan WHERE active='yes' ORDER BY amount DESC"; // Fetch active plans sorted by amount
    $result = mysqli_query($con, $query);
    $sno = 1; // Serial number for the table rows

    // Check if the query returned any results
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { // Use mysqli_fetch_assoc for clarity
            $msgid = $row['planid'];

            // Start the table row
            echo "<tr>";
            echo "<td>" . $sno . "</td>"; // Serial number
            echo "<td>" . htmlspecialchars($row['planName']) . "</td>"; // Plan name
            echo "<td width='380'>" . htmlspecialchars($row['description']) . "</td>"; // Description
            echo "<td>" . htmlspecialchars($row['validity']) . "</td>"; // Validity
            echo "<td>RM" . htmlspecialchars($row['amount']) . "</td>"; // Amount

            // Increment the serial number for the next row
            $sno++;

            // Check if the user is already enrolled in the plan
            $check_query = "SELECT * FROM enrolls_to WHERE userid = '$userid' AND planid = '$msgid'";
            $check_result = mysqli_query($con, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                // If the user is already enrolled, display a message
                echo '<td><span class="a1-label">Already Joined</span></td>';
            } else {
                // If the user is not enrolled, show the "Join Event" button
                echo '<td>
                        <form action="join_plan.php" method="POST">
                            <input type="hidden" name="planid" value="' . $msgid . '"/>
                            <input type="hidden" name="userid" value="' . $userid . '"/>
                            <input type="submit" class="a1-btn a1-green" style="width:100%" value="Join Event">
                        </form>
                      </td>';
            }

            // End the table row
            echo "</tr>";
        }
    } else {
        // Optionally handle the case where no plans are found
        echo "<tr><td colspan='6'>No active plans available.</td></tr>";
    }
    ?>													 
    </tbody>
</table>



<?php include('footer.php'); ?>
    	</div>

    </body>
</html>



				
