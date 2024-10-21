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

		<h3>Edit Member</h3>

		<hr />
		
<table class="table table-bordered datatable" id="table-1" border=1>
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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php
$limit = 10;  // Number of members per page

// Get the current page number from URL, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Modified query for pagination
$query  = "SELECT u.userid, u.username, u.mobile, u.email, u.gender, u.joining_date, u.hasApproved, e.expire 
           FROM users u
           LEFT JOIN enrolls_to e ON u.userid = e.userid
           ORDER BY u.joining_date 
           LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
    $sno    = 1;

    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $uid = $row['userid'];

            echo "<tr><td>".$sno."</td>";

            // Display user information
            echo "<td>" . $row['userid'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['mobile'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['joining_date'] ."</td>";

            // Display approval status
            echo "<td>" . $row['hasApproved'] . "</td>";

            $sno++;

            // Action buttons
            echo "<td>
            <div class='btn-group' role='group'>
                <form action='read_member.php' method='post' style='display:inline-block;'>
                    <input type='hidden' name='name' value='" . $uid . "'/>
                    <input type='submit' class='a1-btn a1-blue btn' id='button1' value='View History'/>
                </form>
                <form action='edit_member.php' method='post' style='display:inline-block;'>
                    <input type='hidden' name='name' value='" . $uid . "'/>
                    <input type='submit' class='a1-btn a1-green btn' id='button1' value='Edit'/>
                </form>
                <form action='del_member.php' method='post' onsubmit='return ConfirmDelete()' style='display:inline-block;'>
                    <input type='hidden' name='name' value='" . $uid . "'/>
                    <input type='submit' class='a1-btn a1-orange btn' id='button1' value='Delete'/>
                </form>";

            // Show Approve button if not approved yet
            if ($row['hasApproved'] == 'Not Yet' || $row['hasApproved'] == 'No') {
                echo "<form action='approve_member.php' method='post' style='display:inline-block;'>
                    <input type='hidden' name='userid' value='" . $uid . "'/>
                    <input type='submit' class='a1-btn a1-yellow btn' id='button1' value='Approve'/>
                </form>";
            }

            // Show Disapprove button if already approved
            if ($row['hasApproved'] == 'Yes') {
                echo "<form action='disapprove_member.php' method='post' style='display:inline-block;'>
                    <input type='hidden' name='userid' value='" . $uid . "'/>
                    <input type='submit' class='a1-btn a1-red btn' id='button1' value='Disapprove'/>
                </form>";
            }

            echo "</div></td></tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No records found</td></tr>";
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





