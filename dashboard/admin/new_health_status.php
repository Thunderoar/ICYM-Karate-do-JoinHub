<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>SPORTS CLUB | Health Status</title>
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
    	.page-container .sidebar-menu #main-menu li#health_status > a {
    	background-color: #2b303a;
    	color: #ffffff;
		}

    </style>
	
	<style>
 	#button1
	{
	width:126px;
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

		<h2>Health Status</h2>

		<hr />

		<table class="table table-bordered datatable" id="table-1" border=1>
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Member ID</th>
            <th>Name</th>
            <th>Contact</th>
            <!-- <th>E-Mail</th> -->
            <th>Gender</th>
            <!-- <th>Date Of Birth</th> -->
            <th>Joining Date</th>
            <th>Calories</th>
            <th>Weight</th>
            <th>Height</th>
            <!-- <th>Fat</th> -->
            <th>Remarks</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
	<?php
$query = "
    SELECT u.userid, u.username, u.mobile, u.email, u.gender, u.dob, u.joining_date,
           hs.calorie, hs.weight, hs.height, hs.fat, hs.remarks
    FROM users u
    LEFT JOIN health_status hs ON u.userid = hs.userid
";
$result = mysqli_query($con, $query);
$sno = 1;

if (mysqli_affected_rows($con) != 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $sno . "</td>";
        echo "<td>" . $row['userid'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['mobile'] . "</td>";
        // echo "<td>" . $row['email'] . "</td>";  // Uncomment if email is needed
        echo "<td>" . $row['gender'] . "</td>";
        //echo "<td>" . $row['dob'] . "</td>";
        echo "<td>" . $row['joining_date'] . "</td>";

        // Display health status details if they exist
        echo "<td>" . (isset($row['calorie']) ? $row['calorie'] : 'N/A') . "</td>";
        echo "<td>" . (isset($row['weight']) ? $row['weight'] : 'N/A') . "</td>";
        echo "<td>" . (isset($row['height']) ? $row['height'] : 'N/A') . "</td>";
        // echo "<td>" . (isset($row['fat']) ? $row['fat'] : 'N/A') . "</td>";  // Uncomment if fat is needed
        echo "<td>" . (isset($row['remarks']) ? $row['remarks'] : 'N/A') . "</td>";

        // Increment serial number
        $sno++;

        // Action form for health status entry
        echo "<td>
                <form action='health_status_entry.php' method='post'>
                    <input type='hidden' name='uid' value='" . $row['userid'] . "'/>
                    <input type='hidden' name='uname' value='" . $row['username'] . "'/>
                    <input type='hidden' name='udob' value='" . $row['dob'] . "'/>
                    <input type='hidden' name='ujoin' value='" . $row['joining_date'] . "'/>
                    <input type='hidden' name='ugender' value='" . $row['gender'] . "'/>
                    <input type='submit' class='a1-btn a1-blue' value='Update Health Status'/>
                </form>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='14'>Please log in to view health status.</td></tr>";
}
?>
					</tbody>
				</table>


			<?php include('footer.php'); ?>
    	</div>

    </body>
</html>

