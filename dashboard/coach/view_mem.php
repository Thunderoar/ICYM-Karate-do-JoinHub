<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do | Member View</title>
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
			
					<!-- logo collapse icon 
					<div class="sidebar-collapse" onclick="collapseSidebar()">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition
					<i class="entypo-menu"></i>
				</a>
			</div>-->
							
			
		
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

		<h3>Your Student</h3>

		<hr />
		
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Member ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>E-Mail</th>
            <th>Gender</th>
            <th>Joining Date</th>
            <th>Approval Status</th>
            <th>Joined Event</th>
            <th>Event Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php
$limit = 10;  // Number of members per page

// Get the current page number from URL, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($_SESSION['is_coach_logged_in']) {
    $coachId = $_SESSION['staffid'];
    
    // Modified query to show all members (including not approved) from sports_timetable
    $query = "SELECT DISTINCT 
                u.userid,
                u.username,
                u.mobile,
                u.email,
                u.gender,
                u.joining_date,
                e.hasApproved,
                u.dob,
                p.planName AS event_name,
                p.startDate AS event_date
            FROM sports_timetable st
            INNER JOIN plan p ON st.planid = p.planid
            INNER JOIN enrolls_to e ON p.planid = e.planid
            INNER JOIN users u ON e.userid = u.userid
            WHERE st.staffid = ?
            AND e.hasPaid = 'yes'
            ORDER BY u.joining_date
            LIMIT ? OFFSET ?";
            
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'iii', $coachId, $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $sno = $offset + 1;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $uid = $row['userid'];
            ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo htmlspecialchars($row['userid']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['gender']); ?></td>
                <td><?php echo htmlspecialchars($row['joining_date']); ?></td>
                <td><?php echo htmlspecialchars($row['hasApproved']); ?></td>
                <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                <td>
                    <div class='btn-group' role='group'>
                        <form action='../../dashboard/admin/viewall_detail.php' method='post'>
                            <input type='hidden' name='name' value='<?php echo htmlspecialchars($uid); ?>'/>
                            <input type='submit' class='a1-btn a1-green btn' value='More Info'/>
                        </form>
                        <form action='../../dashboard/admin/read_member.php' method='post' style='display:inline-block;'>
                            <input type='hidden' name='name' value='<?php echo htmlspecialchars($uid); ?>'/>
                            <input type='submit' class='a1-btn a1-blue btn' value='View History'/>
                        </form>
                        <?php if ($row['hasApproved'] == 'Not Yet' || $row['hasApproved'] == 'No'): ?>
                            <form action='approve_member.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='userid' value='<?php echo htmlspecialchars($uid); ?>'/>
                                <input type='submit' class='a1-btn a1-yellow btn' value='Approve'/>
                            </form>
                        <?php endif; ?>
                        <?php if ($row['hasApproved'] == 'Yes'): ?>
                            <form action='disapprove_member.php' method='post' style='display:inline-block;'>
                                <input type='hidden' name='userid' value='<?php echo htmlspecialchars($uid); ?>'/>
                                <input type='submit' class='a1-btn a1-red btn' value='Disapprove'/>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php
            $sno++;
        }
    } else {
        echo "<tr><td colspan='11'>No records found</td></tr>";
    }
}
?>
</tbody>
</table>







<?php
// Get the total number of members for pagination
$total_query = "SELECT COUNT(*) as total FROM users";
$total_result = mysqli_query($con, $total_query);
$total_members = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_members / $limit);
?>

<!-- Pagination Controls -->
<nav aria-label="Page navigation">
  <ul class="pagination">
    <!-- Previous button -->
    <?php if($page > 1): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
    <?php endif; ?>

    <!-- Page number links -->
    <?php for($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?php if($i == $page) echo 'active'; ?>">
        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>

    <!-- Next button -->
    <?php if($page < $total_pages): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>

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





