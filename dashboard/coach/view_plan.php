﻿
<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>SPORTS CLUB  | View sports Plan</title>
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

							<li>Welcome <?php echo $_SESSION['full_name']; ?> 
							</li>						
						
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
					<th>S.No</th>
					<th>Sports Plan ID</th>
					<th>Sports Plan name</th>
					<th>Sports Plan Details</th>
					<th>Duration</th>
					<th>Rate</th>
					<th>Action</th>
				</tr>
			</thead>		
				<tbody>
					<?php


					$query  = "select * from plan where active='yes' ORDER BY amount DESC";
					//echo $query;
					$result = mysqli_query($con, $query);
					$sno    = 1;

					if (mysqli_affected_rows($con) != 0) {
					    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					        $msgid = $row['planid'];
					        
					        
					        echo "<tr><td>" . $sno . "</td>";
					        echo "<td>" . $row['planid'] . "</td>";
					        echo "<td>" . $row['planName'] . "</td>";
					        echo "<td width='380'>" . $row['description'] . "</td>";
					        echo "<td>" . $row['validity'] . "</td>";
					        echo "<td>RM" . $row['amount'] . "</td>";
					        
					        $sno++;
					        
					        echo '<td><a href=edit_plan.php?id="'.$row['planid'].'"><input type="button" class="a1-btn a1-blue" id="boxxe" style="width:86%" value="Edit Plan" ></a><form action="del_plan.php" method="post" onSubmit="return ConfirmDelete();"><input type="hidden" name="name" value="' . $msgid .'"/><input type="submit" id="button1" value="Delete Plan" class="a1-btn a1-orange"/></form></td></tr>';
					        
							$msgid = 0;
					    }
					    
					}

					?>																
				</tbody>
		</table>


<?php include('footer.php'); ?>
    	</div>

    </body>
</html>



				