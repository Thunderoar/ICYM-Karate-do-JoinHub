<?php
require '../../include/db_conn.php';
page_protect();
 


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do | View Timetable</title>
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link href="a1style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
	<style>
	#boxxe
	{
		width:126px;
	}
    	.page-container .sidebar-menu #main-menu li#routinehassubopen > a {
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

		

		
			<h2>Timetables</h2>

		<hr />
		
<table class="table table-bordered datatable" id="table-1" border=1>
    <tr>
        <th>Sl.No</th>
        <th>Timetable Name</th>
        <th>Timetable Details</th>
        <th>Delete Timetable</th>
    </tr>
    <tbody>
    <?php
// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
        $currentStaffId = $_SESSION['staffid']; // Make sure you set this in your login process

        // Modify the query to fetch timetables only for the current coach
        $query = "SELECT * FROM sports_timetable WHERE staffid = '$currentStaffId'";
        $result = mysqli_query($con, $query);
        $sno = 1;

        if (mysqli_affected_rows($con) != 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr><td>".$sno."</td>";
                echo "<td>" . $row['tname'] . "</td>";
                echo '<td><a href="editdetailroutine.php?id='.$row['tid'].'"><input type="button" class="a1-btn a1-blue" id="boxxe" value="Edit Timetable" ></a></td>';
                echo "<td><form action='deleteroutine.php' method='post' onsubmit='return ConfirmDelete()'><input type='hidden' name='name' value='" . $row['tid'] . "'/><input type='submit' value='Delete' width='20px' id='boxxe' class='a1-btn a1-orange'/></form></td></tr>";
                $sno++;
            }
        }
    ?>
    </tbody>
</table>



				
		
		
		
		
		
		
		

			

    	</div>

    </body>
	<?php include('footer.php'); ?>
</html>


										
