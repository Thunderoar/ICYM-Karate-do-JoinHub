﻿
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
    .status-messages {
        margin-top: 10px;
    }
    .status-messages p {
        margin: 5px 0;
        font-size: 14px;
    }
    .status-text {
        color: #555;
        font-weight: bold;
    }
	.description-container {
    position: relative;
    scroll-margin-top: 20px; /* Adds some space when scrolling */
}
.short-description {
    word-wrap: break-word;
}
.full-description {
    word-wrap: break-word;
}
.read-more-btn {
    color: #0d6efd;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    font-size: 0.9em;
}
.read-more-btn:hover {
    text-decoration: underline;
}
/* Add smooth scroll behavior */
html {
    scroll-behavior: smooth;
}
</style>
<script>
function toggleDescription(btn) {
    const container = btn.parentElement;
    const shortDesc = container.querySelector('.short-description');
    const fullDesc = container.querySelector('.full-description');
    
    if (fullDesc.style.display === 'none') {
        shortDesc.style.display = 'none';
        fullDesc.style.display = 'block';
        btn.textContent = 'Read Less';
        
        // Scroll into view with a slight delay to ensure content is expanded
        setTimeout(() => {
            container.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'nearest'
            });
        }, 100);
    } else {
        shortDesc.style.display = 'block';
        fullDesc.style.display = 'none';
        btn.textContent = 'Read More';
    }
}
// Add focus handling for the container
document.addEventListener('DOMContentLoaded', function() {
    const descriptions = document.querySelectorAll('.description-container');
    
    descriptions.forEach(container => {
        container.addEventListener('click', function(e) {
            // Only scroll if it's not the button being clicked
            if (!e.target.classList.contains('read-more-btn')) {
                this.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'nearest'
                });
            }
        });

        // Handle keyboard focus
        container.setAttribute('tabindex', '0'); // Make it focusable
        container.addEventListener('focus', function() {
            this.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'nearest'
            });
        });
    });
});
</script>
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
// Pagination settings
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Get search parameters
$search_term = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$search_column = isset($_GET['search_column']) ? $_GET['search_column'] : 'planName';
$show_inactive = isset($_GET['show_inactive']) ? $_GET['show_inactive'] : 'no';

// Base query for counting total records
$count_query = "SELECT COUNT(DISTINCT p.planid) as total FROM plan p ";

// Base query for fetching records
$query = "SELECT DISTINCT p.planid, p.planName, p.description, p.planType, p.startDate, p.endDate, 
          p.duration, p.amount, p.active, pp.slug, 
          (SELECT COUNT(*) FROM images i WHERE i.planid = p.planid) as image_count,
          (SELECT slug FROM plan_pages WHERE planid = p.planid LIMIT 1) as page_slug 
          FROM plan p 
          LEFT JOIN plan_pages pp ON p.planid = pp.planid 
          LEFT JOIN sports_timetable st ON p.planid = st.planid 
          LEFT JOIN timetable_days td ON st.tid = td.tid ";

// Build WHERE clause
$where_conditions = [];
if ($show_inactive !== 'yes') {
    $where_conditions[] = "p.active='yes'";
}
if ($search_term !== '') {
    $where_conditions[] = "$search_column LIKE '%$search_term%'";
}

if (!empty($where_conditions)) {
    $where_clause = "WHERE " . implode(' AND ', $where_conditions);
    $query .= $where_clause;
    $count_query .= $where_clause;
}

// Add ordering and pagination
$query .= " GROUP BY p.planid ORDER BY p.active DESC, p.amount DESC LIMIT $offset, $records_per_page";

// Get total records for pagination
$total_records_result = mysqli_query($con, $count_query);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];
$total_pages = ceil($total_records / $records_per_page);

// Execute main query
$result = mysqli_query($con, $query);
$sno = $offset + 1;
?>

<?php
// Get the filter parameter, default to showing only active plans
$show_inactive = isset($_GET['show_inactive']) ? $_GET['show_inactive'] : 'no';

// Modify the query to handle both active and inactive plans
$query = "SELECT DISTINCT p.planid, p.planName, p.description, p.planType, p.startDate, p.endDate, 
          p.duration, p.amount, p.active, pp.slug, 
          (SELECT COUNT(*) FROM images i WHERE i.planid = p.planid) as image_count,
          (SELECT slug FROM plan_pages WHERE planid = p.planid LIMIT 1) as page_slug,
          st.tname, td.day_number, td.activities, st.tid
          FROM plan p 
          LEFT JOIN plan_pages pp ON p.planid = pp.planid 
          LEFT JOIN sports_timetable st ON p.planid = st.planid 
          LEFT JOIN timetable_days td ON st.tid = td.tid ";

// Add WHERE clause based on filter
$where_conditions = [];
if ($show_inactive !== 'yes') {
    $where_conditions[] = "p.active='yes'";
}

// Combine WHERE conditions if any
if (!empty($where_conditions)) {
    $query .= "WHERE " . implode(" AND ", $where_conditions) . " ";
}

// Append ordering
$query .= " GROUP BY p.planid ORDER BY p.active DESC, p.amount DESC";

$result = mysqli_query($con, $query);
$sno = 1;
?>



<div class="mb-3">
    <form method="GET" class="form-inline" id="filterForm" style="display: flex; align-items: center; gap: 10px;">
<form id="filterForm" action="your_page.php" method="get">
    <label class="switch">
        <input type="checkbox" 
               name="show_inactive" 
               value="yes" 
               <?php echo isset($_GET['show_inactive']) && $_GET['show_inactive'] === 'yes' ? 'checked' : ''; ?>
               onchange="this.form.submit()">
        <span class="slider round"></span>
    </label>
    <input type="hidden" name="toggle_state" id="toggleState" value="<?php echo isset($_GET['show_inactive']) ? '1' : '0'; ?>">
        <label>View Joined Past Event</label>
    </form>
</div>

<!-- Results Summary -->
<div class="mb-3">
    Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $records_per_page, $total_records); ?> 
    of <?php echo $total_records; ?> entries
</div>
    <h3 style="margin-right: 20px;">Current Active Plan</h3>



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
            $userid = $_SESSION['userid']; // Make sure session has started and userid is available
        
            if (mysqli_affected_rows($con) != 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $msgid = $row['planid'];
                    $tid = $row['tid']; 
                    $status_class = $row['active'] === 'yes' ? 'text-success' : 'text-danger';
                    $status_text = $row['active'] === 'yes' ? 'Active' : 'Inactive';

                    // Check if the user is already enrolled in the plan
                    $check_query = "SELECT * FROM enrolls_to WHERE userid = '$userid' AND planid = '$msgid'";
                    $check_result = mysqli_query($con, $check_query);

                    $isPaid = "Not Yet";
                    $isApproved = "no";
                    $isJoined = false;

                    if ($enrollment = mysqli_fetch_assoc($check_result)) {
                        $isPaid = $enrollment['hasPaid'] === 'yes' ? 'Yes' : 'no';
                        $isApproved = $enrollment['hasApproved'] === 'yes' ? 'Yes' : 'Wait Manager approval';
                        $isJoined = true; // User has joined the event
                    }

                    echo "<tr>";
                    echo "<td>" . $sno . "</td>";
                    echo "<td>" . $row['planid'] . "</td>";
                    echo "<td>" . $row['planName'] . "</td>";
echo "<td width='380'>";
echo "<div class='description-container'>";
    echo "<div class='short-description'>" . substr($row['description'], 0, 100) . 
         (strlen($row['description']) > 100 ? "..." : "") . "</div>";
    
    if(strlen($row['description']) > 100) {
        echo "<div class='full-description' style='display:none'>" . $row['description'] . "</div>";
        echo "<button class='read-more-btn' onclick='toggleDescription(this)'>Read More</button>";
    }
echo "</div>";
echo "</td>";
                    echo "<td>" . $row['planType'] . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($row['startDate'])) . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($row['endDate'])) . "</td>";
                    echo "<td>" . $row['duration'] . "</td>";
                    echo "<td>RM" . $row['amount'] . "</td>";

                    if ($row['page_slug']) {
                        $url_status = $row['active'] === 'yes' ? '' : ' (Inactive)';
                        echo "<td><a href='../../plans/" . $row['page_slug'] . "' target='_blank'>" . 
                             $row['page_slug'] . $url_status . "</a></td>";
                    } else {
                        echo "<td><span class='text-muted'>No URL yet</span></td>";
                    }

                    echo "<td class='" . $status_class . "'>" . $status_text . "</td>";
                    echo "<td>" . $row['image_count'] . " images</td>";

                    echo "<td>";
                    // Check if the user is enrolled to decide between "Join Event" and "Unjoin"
                    if ($row['active'] === 'yes') {
                        if (mysqli_num_rows($check_result) > 0) {
                            // Fetch enrollment details to check the payment status
                            $enroll = mysqli_fetch_assoc($check_result);
                            $hasPaid = $enrollment['hasPaid'];

                            if ($hasPaid === 'yes') {
                                // If the user has paid, show the "You've already joined" message
                                echo '<p style="color:green; width:100%; text-align:center;">You\'ve already joined</p>';
                            } else {
                                // If the user has not paid, show the "Unjoin" button
                                echo '<form action="unjoin_plan.php" method="POST">
                                        <input type="hidden" name="planid" value="' . $msgid . '"/>
                                        <input type="hidden" name="userid" value="' . $userid . '"/>
                                        <input type="submit" class="a1-btn a1-red" style="width:100%" value="Unjoin">
                                      </form>';
                            }
                        } else {
                            // If the user is not enrolled, show the "Join Event" button
                            echo '<form action="join_plan.php" method="POST">
                                    <input type="hidden" name="planid" value="' . $msgid . '"/>
                                    <input type="hidden" name="userid" value="' . $userid . '"/>
                                    <input type="submit" class="a1-btn a1-green" style="width:100%" value="Join Event">
                                  </form>';
                        }
                    }

                    // Show the "View Plan" and "View Timetable" buttons below
                    if (!empty($tid)) {
                        echo '<a href="../../dashboard/admin/timetable_detail.php?id=' . $tid . '&planid=' . $row['planid'] . '">
                                <input type="button" class="a1-btn a1-blue" style="width:100%" value="View Event Details">
                            </a>';

                        echo '<a href="../../dashboard/admin/timetable_detail.php?id=' . $tid . '&planid=' . $row['planid'] . '&scroll=1#timetable-details">
                                <input type="button" class="a1-btn a1-purple" style="width:100%" value="View Timetable">
                            </a>';
                    } else {
                        echo "<span class='text-muted'>No Timetable</span>";
                    }

                    // Check if the member has joined the event and display status
                    if ($isJoined) {
                        // Display Approval and Payment status as a message
                        echo "<div class='status-messages'>";
                        echo "<p><strong>Approved?</strong> <span class='status-text'>" . $isApproved . "</span></p>";
echo "<p><strong>Paid?</strong> <span class='status-text'>" . $isPaid . "</span>";

// Check if the user has paid
if ($isPaid === 'no') {
    echo " <a href='payments.php' class='btn btn-sm btn-primary ml-2'>Pay Now</a>";
}
echo "</p>";
                        echo "</div>";
                    }

                    echo "</td>";
                    $sno++;
                }
            } else {
                echo "<tr><td colspan='14' class='text-center'>No records found</td></tr>";
            }       
        ?>                                                              
    </tbody>
</table>









<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=1&search=<?php echo urlencode($search_term); ?>&search_column=<?php echo urlencode($search_column); ?>&show_inactive=<?php echo urlencode($show_inactive); ?>">First</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search_term); ?>&search_column=<?php echo urlencode($search_column); ?>&show_inactive=<?php echo urlencode($show_inactive); ?>">Previous</a>
            </li>
        <?php endif; ?>

        <?php
        // Show up to 5 page numbers, centered around current page
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $page + 2);

        for ($i = $start_page; $i <= $end_page; $i++): ?>
            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search_term); ?>&search_column=<?php echo urlencode($search_column); ?>&show_inactive=<?php echo urlencode($show_inactive); ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search_term); ?>&search_column=<?php echo urlencode($search_column); ?>&show_inactive=<?php echo urlencode($show_inactive); ?>">Next</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search_term); ?>&search_column=<?php echo urlencode($search_column); ?>&show_inactive=<?php echo urlencode($show_inactive); ?>">Last</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

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
    document.querySelector('input[name="show_inactive"]').addEventListener('change', function() {
        document.getElementById('toggleState').value = this.checked ? '1' : '0';
        document.getElementById('filterForm').submit();
    });

function ConfirmDelete() {
    return confirm('Are you sure you want to delete this plan?');
}

</script>


</html>



				
