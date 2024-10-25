<?php
require '../../include/db_conn.php';
page_protect();
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do | View Member</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link href="a1style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
	
	<style>
 	#button1
	{
	width:126px;
	}

	.page-container .sidebar-menu #main-menu li#hassubopen > a {
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

		<h3>Member Detail</h3>

		<hr />
		
<table class="table table-bordered datatable" id="table-1" border=1>
    <thead>
        <tr><h2>
            <th>Sl.No</th>
            <th>Member ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>E-Mail</th>
            <th>Gender</th>
            <th>Joining Date</th>
            <th>Action</th></h2>
        </tr>
    </thead>
    <tbody>

    <?php
    $query  = "SELECT * FROM users ORDER BY joining_date";
    $result = mysqli_query($con, $query);
    $sno    = 1;

    if ($result && mysqli_num_rows($result) > 0) { // Check if the query was successful and has rows
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $uid = $row['userid'];

            // Output user data directly from the users table
            echo "<tr><td>" . $sno . "</td>";
            echo "<td>" . htmlspecialchars($row['userid']) . "</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['joining_date']) . "</td>";

            // Increment the serial number
            $sno++;

            // Create a form to view all details
            echo "<td>
                    <form action='viewall_detail.php' method='post'>
                        <input type='hidden' name='name' value='" . htmlspecialchars($uid) . "'/>
                        <input type='submit' class='a1-btn a1-blue' value='View All'/>
                    </form>
                  </td></tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found</td></tr>"; // Display message if no users found
    }
    ?>
    </tbody>
</table>


<script>
	
	function ConfirmDelete(name){
	
    var r = confirm("Are you sure! You want to Delete this User?");
    if (r == true) {
       return true;
    } else {
        return false;
    }
}

</script>
		
			<?php include('footer.php'); ?>
    	</div>

    </body>
</html>


