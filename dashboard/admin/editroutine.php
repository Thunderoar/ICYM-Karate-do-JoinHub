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
					<th>No</th>
					<th>Timetable Name</th>
					<th>Timetable Details</th>
					<th>Delete Timetable</th>
					<th>Approve Timetable</th>
				</tr>
		
				<tbody>

<?php
$query = "SELECT * FROM sports_timetable";
// Execute the query
$result = mysqli_query($con, $query);
$sno = 1;

if (mysqli_num_rows($result) > 0) { // Use mysqli_num_rows to check for rows
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $hasApproved = $row['hasApproved'];
        
        echo "<tr><td>" . $sno . "</td>";
        echo "<td>" . htmlspecialchars($row['tname']) . "</td>"; // Use htmlspecialchars to prevent XSS
        $sno++;

        // Edit Timetable Button
        echo '<td><a href="editdetailroutine.php?id=' . htmlspecialchars($row['tid']) . '">
              <input type="button" class="a1-btn a1-blue" id="boxxe" value="Edit Timetable"></a></td>';

        // Delete Timetable Button
        echo "<td>
                <form action='deleteroutine.php' method='post' onsubmit='return ConfirmDelete()'>
                    <input type='hidden' name='name' value='" . htmlspecialchars($row['tid']) . "'/>
                    <input type='submit' value='Delete' class='a1-btn a1-orange'/>
                </form>
              </td>";

        // Approval and Rejection Buttons
        echo "<td>";
        
        if ($hasApproved === 'Not Yet') {
            // Show Approve and Reject buttons
            echo "<form action='approve_reject_routine.php' method='post'>
                    <input type='hidden' name='tid' value='" . htmlspecialchars($row['tid']) . "' />
                    <button type='submit' name='action' value='approve' class='a1-btn a1-green'>✔</button>
                    <button type='submit' name='action' value='reject' class='a1-btn a1-red'>✘</button>
                  </form>";
        } elseif ($hasApproved === 'yes') {
            echo "<span class='approved'>Approved</span>";
        } else {
            echo "<span class='rejected'>Rejected</span>";
        }

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>"; // Handle no records found
}
?>
							
				</tbody>

		</table>


				
		
		
		
		
		
		
		

			

    	</div>

    </body>
	<?php include('footer.php'); ?>
</html>


										
