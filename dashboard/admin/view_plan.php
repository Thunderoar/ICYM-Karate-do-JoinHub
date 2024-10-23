
<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do | View sports Plan</title>
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

		.page-container .sidebar-menu #main-menu li#planhassubopen > a {
    		background-color: #2b303a;
    		color: #ffffff;
		}
		.full-width-button {
    width: 100%;
}
th {
    cursor: pointer; /* Change cursor to pointer for clickable headers */
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

		<h3>Manage Plan</h3>

		<hr />

<table class="table table-bordered datatable" id="table-1" border="1">
    <thead>
        <tr>
            <th onclick="sortTable(0)">No</th>
            <th onclick="sortTable(1)">Sports Plan ID</th>
            <th onclick="sortTable(2)">Sports Plan Name</th>
            <th onclick="sortTable(3)">Sports Plan Details</th>
            <th onclick="sortTable(4)">Plan Type</th>
            <th onclick="sortTable(5)">Start Date</th>
            <th onclick="sortTable(6)">End Date</th>
            <th onclick="sortTable(7)">Duration (Days)</th>
            <th onclick="sortTable(8)">Rate</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Update the query to fetch additional fields
        $query = "SELECT planid, planName, description, planType, startDate, endDate, duration, amount 
                    FROM plan 
                    WHERE active='yes' 
                    ORDER BY amount DESC";
        
        $result = mysqli_query($con, $query);
        $sno = 1;

        if (mysqli_affected_rows($con) != 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $msgid = $row['planid'];
                
                echo "<tr><td>" . $sno . "</td>";
                echo "<td>" . $row['planid'] . "</td>";
                echo "<td>" . $row['planName'] . "</td>";
                echo "<td width='380'>" . $row['description'] . "</td>";
                echo "<td>" . $row['planType'] . "</td>";
                echo "<td>" . date('Y-m-d', strtotime($row['startDate'])) . "</td>";
                echo "<td>" . date('Y-m-d', strtotime($row['endDate'])) . "</td>";
                echo "<td>" . $row['duration'] . "</td>";
                echo "<td>RM" . $row['amount'] . "</td>";
                
                $sno++;
                
                echo '<td>
                        <a href="edit_plan.php?id=' . $row['planid'] . '">
                            <input type="button" class="a1-btn a1-blue" id="boxxe" style="width:100%" value="Edit Plan">
                        </a>
                        <form action="del_plan.php" method="post" onSubmit="return ConfirmDelete();">
                            <input type="hidden" name="name" value="' . $msgid . '"/>
                            <input type="submit" id="button1" value="Delete Plan" class="a1-btn a1-orange" style="width:100%"/>
                        </form>
                    </td></tr>';
                
                $msgid = 0;
            }
        }
        ?>																
    </tbody>
</table>




<?php include('footer.php'); ?>
    	</div>

    </body>
<script>
let currentSortColumn = -1; // To track the currently sorted column
let currentSortDirection = 'asc'; // To track the current sort direction

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("table-1");
    switching = true;
    
    // Reset all indicators
    resetIndicators();

    // Set the sorting direction to ascending initially
    if (currentSortColumn === n) {
        dir = (currentSortDirection === 'asc') ? 'desc' : 'asc'; // Toggle direction
    } else {
        dir = 'asc'; // Start with ascending for a new column
    }
    currentSortColumn = n;
    currentSortDirection = dir;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }

    // Update the indicator for the sorted column
    updateIndicator(n, dir);
}

// Function to reset all column indicators
function resetIndicators() {
    const headers = document.querySelectorAll('#table-1 th');
    headers.forEach(header => {
        header.innerHTML = header.innerHTML.replace(/▼|▲/, ''); // Remove existing arrows
    });
}

// Function to update the indicator for the currently sorted column
function updateIndicator(columnIndex, direction) {
    const header = document.querySelectorAll('#table-1 th')[columnIndex];
    header.innerHTML += direction === 'asc' ? ' ▲' : ' ▼'; // Add the appropriate arrow
}
</script>


</html>



				
