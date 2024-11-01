
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
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
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

<?php
// Get the filter parameter, default to showing only active plans
$show_inactive = isset($_GET['show_inactive']) ? $_GET['show_inactive'] : 'no';

// Modify the query to handle both active and inactive plans
$query = "SELECT p.planid, p.planName, p.description, p.planType, p.startDate, p.endDate, 
          p.duration, p.amount, p.active, pp.slug, 
          (SELECT COUNT(*) FROM images i WHERE i.planid = p.planid) as image_count,
          (SELECT slug FROM plan_pages WHERE planid = p.planid LIMIT 1) as page_slug 
          FROM plan p 
          LEFT JOIN plan_pages pp ON p.planid = pp.planid ";

// Add WHERE clause based on filter
if ($show_inactive !== 'yes') {
    $query .= "WHERE p.active='yes' ";
}

$query .= "ORDER BY p.active DESC, p.amount DESC";

$result = mysqli_query($con, $query);
$sno = 1;
?>

<div class="mb-3">
    <form method="GET" class="form-inline" id="filterForm" style="display: flex; align-items: center; gap: 10px;">
        <label class="switch">
            <input type="checkbox" 
                   name="show_inactive" 
                   value="yes" 
                   <?php echo isset($_GET['show_inactive']) && $_GET['show_inactive'] === 'yes' ? 'checked' : ''; ?>
                   onchange="this.form.submit()">
            <span class="slider round"></span>
        </label>
        <label>Show Inactive Plans</label>
    </form>
</div>

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
            <th onclick="sortTable(9)">Page URL</th>
            <th onclick="sortTable(10)">Status</th>
            <th onclick="sortTable(11)">Images</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_affected_rows($con) != 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $msgid = $row['planid'];
                $status_class = $row['active'] === 'yes' ? 'text-success' : 'text-danger';
                $status_text = $row['active'] === 'yes' ? 'Active' : 'Inactive';
                
                echo "<tr>";
                echo "<td>" . $sno . "</td>";
                echo "<td>" . $row['planid'] . "</td>";
                echo "<td>" . $row['planName'] . "</td>";
                echo "<td width='380'>" . $row['description'] . "</td>";
                echo "<td>" . $row['planType'] . "</td>";
                echo "<td>" . date('Y-m-d', strtotime($row['startDate'])) . "</td>";
                echo "<td>" . date('Y-m-d', strtotime($row['endDate'])) . "</td>";
                echo "<td>" . $row['duration'] . "</td>";
                echo "<td>RM" . $row['amount'] . "</td>";
                
                // Add slug URL column with status indicator
                if ($row['page_slug']) {
                    $url_status = $row['active'] === 'yes' ? '' : ' (Inactive)';
                    echo "<td><a href='../../plans/" . $row['page_slug'] . "' target='_blank'>" . 
                         $row['page_slug'] . $url_status . "</a></td>";
                } else {
                    echo "<td><span class='text-muted'>No URL yet</span></td>";
                }
                
                // Add status column
                echo "<td class='" . $status_class . "'>" . $status_text . "</td>";
                
                // Add images count column
                echo "<td>" . $row['image_count'] . " images</td>";
                
                $sno++;
                
                echo '<td>';
                echo '<a href="edit_plan.php?id=' . $row['planid'] . '">
                        <input type="button" class="a1-btn a1-blue" id="boxxe" style="width:100%" value="Edit Plan">
                      </a>';
                
                // Change button text and action based on active status
                if ($row['active'] === 'yes') {
                    echo '<form action="del_plan.php" method="post" onSubmit="return ConfirmDeactivate();">
                            <input type="hidden" name="name" value="' . $msgid . '"/>
                            <input type="submit" id="button1" value="Mark as Inactive" class="a1-btn a1-orange" style="width:100%"/>
                          </form>';
                } else {
                    echo '<form action="activate_plan.php" method="post" onSubmit="return ConfirmActivate();">
                            <input type="hidden" name="name" value="' . $msgid . '"/>
                            <input type="submit" id="button1" value="Mark as Active" class="a1-btn a1-green" style="width:100%"/>
                          </form>';
                }
                echo '</td></tr>';
                
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

    function ConfirmDeactivate() {
        return confirm("Are you sure you want to deactivate this plan? The plan, its images, and URL will be retained but hidden from view.");
    }
    
    function ConfirmActivate() {
        return confirm("Are you sure you want to activate this plan?");
    }
	
// Optional: Add smooth transitions when filtering
document.querySelector('input[name="show_inactive"]').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});
</script>


</html>



				
