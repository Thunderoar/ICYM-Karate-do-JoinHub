<?php
require '../../include/db_conn.php';
page_protect();
include('checkAccess.php');
check_access('admin', 'index.php');


if (isset($_GET['message_id'])) {
    $messageId = intval($_GET['message_id']);
    $updateQuery = "UPDATE contact_messages SET read_status = 1 WHERE message_id = $messageId";
    mysqli_query($conn, $updateQuery);
}


?>
<!DOCTYPE html>
<html lang="en">
<head> 

    
    <title>ICYM Karate-Do Hub  | Dashboard </title>

    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
	<link rel="stylesheet" href="../../css/insidedashboard.css">
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
	<style>
		.page-container .sidebar-menu #main-menu li#dash > a {
    background-color: #2b303a;
    color: #ffffff;
    }
	.row {
    display: flex;
    flex-wrap: wrap; /* Allows wrapping of tiles on smaller screens */
    justify-content: space-between; /* Space between tiles */
}

.tile-stats {
    display: flex;
    flex-direction: column; /* Stacks elements vertically */
    justify-content: space-between; /* Makes sure contents fill the height */
    height: 100%; /* Ensures all boxes take the same height */
}

/* Hover Effects */
.tile-stats:hover {
    transform: scale(1.05); /* Slightly enlarges the tile */
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); /* Adds a shadow */
}
.custom-tile {
    padding: 10px 0;
    color: white;
    text-align: center;
    border-radius: 4px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    /* Smooth transition for hover effects */
}

.custom-tile.redcolor {
    background-color: #f56954;
}

.custom-tile.greencolor {
    background-color: #4CAF50;
}

.custom-tile.deepbluecolor {
    background-color: #0073b7;
}

.custom-tile .num h4 {
    margin: 0;
    font-size: 15px;
}

/* Hover Effects */
.custom-tile:hover {
    transform: scale(1.05); /* Slightly enlarges the tile */
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); /* Adds a shadow */
}

/* Optional: Change background color slightly on hover */
.custom-tile.redcolor:hover {
    background-color: #e74c3c; /* Darker red */
}

.custom-tile.greencolor:hover {
    background-color: #388e3c; /* Darker green */
}

.custom-tile.deepbluecolor:hover {
    background-color: #005b9f; /* Darker blue */
}
        .notification {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .icon {
            font-size: 24px;
        }
        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
        }
        .popup {
            display: none;
            position: absolute;
            top: 30px;
            right: 0;
            width: 300px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .popup-header {
            padding: 10px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
        }
        .popup-message {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .popup-message:last-child {
            border-bottom: none;
        }
        .popup-message a {
            text-decoration: none;
            color: black;
        }
        .popup-message a:hover {
            text-decoration: underline;
        }
	</style>

    <script>
        function togglePopup() {
            var popup = document.getElementById("popup");
            if (popup.style.display === "none" || popup.style.display === "") {
                popup.style.display = "block";
            } else {
                popup.style.display = "none";
            }
        }
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
			
					<!-- logo collapse icon>
					<div class="sidebar-collapse" onclick="collapseSidebar()">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition >
					<i class="entypo-menu"></i>
				</a>
			</div-->
							
			
		
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
						require('../../element/notification.php');
					?>
					<?php
						require('../../element/loggedin-welcome.html');
					?>

							<li>
								<a href="logout.php">
									Log Out <i class="entypo-logout right"></i>
								</a>
							</li>
						</ul>

					</div>

				</div>

			<h2>ICYM Karate-Do Hub</h2>

			<hr>

<div class="row">
<div class="col-sm-3">
    <a href="revenue_month.php">
        <div class="tile-stats tile-red">
            <div class="icon"><i class="entypo-users"></i></div>
            <div style="font-size:30px" class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Paid Income This Month</h2><br>
                <?php
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $date = date('Y-m');

                // Fetch the paid amount
                $query_paid = "SELECT SUM(p.amount) as total_paid FROM enrolls_to e
                               JOIN plan p ON e.planid = p.planid
                               WHERE e.paid_date LIKE '$date%'
                               AND e.hasPaid = 'yes'
                               AND e.hasApproved = 'yes'";
                $result_paid = mysqli_query($con, $query_paid);
                $revenue = 0;
                if ($result_paid) {
                    $row = mysqli_fetch_assoc($result_paid);
                    $revenue = floatval($row['total_paid']);
                }

                // Fetch the unpaid amount
                $query_unpaid = "SELECT SUM(p.amount) as total_unpaid FROM enrolls_to e
                                 JOIN plan p ON e.planid = p.planid
                                 WHERE e.hasPaid = 'yes'
                                 AND e.hasApproved != 'yes'";
                $result_unpaid = mysqli_query($con, $query_unpaid);
                $unpaid_amount = 0;
                if ($result_unpaid) {
                    $row = mysqli_fetch_assoc($result_unpaid);
                    $unpaid_amount = floatval($row['total_unpaid']);
                }

                echo "RM" . number_format($revenue, 2) . " (Unpaid: RM" . number_format($unpaid_amount, 2) . ")";
                ?>
            </div>
        </div>
    </a>
    <a href="payments.php">
        <div class="custom-tile redcolor">
            <div class="num" style="display: flex; align-items: center; justify-content: center;">
                <i class="entypo-star" style="margin-right: 10px;"></i>
                <h4>Manage Payment</h4>
            </div>
        </div>
    </a>
</div>





<div class="col-sm-3">
    <a href="view_mem.php">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div style="font-size:30px" class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Total <br>Members</h2><br>
                <?php
                // Query to count all users
                $query_total = "SELECT COUNT(*) as total_members FROM users";
                $result_total = mysqli_query($con, $query_total);
                $total_members = 0;
                if ($result_total) {
                    $row_total = mysqli_fetch_array($result_total);
                    $total_members = $row_total['total_members'];
                }
                // Query to count unapproved users (where hasApproved is 'No')
                $query_unapproved = "SELECT COUNT(*) as unapproved_members FROM users WHERE hasApproved = 'No'";
                $result_unapproved = mysqli_query($con, $query_unapproved);
                $unapproved_members = 0;
                if ($result_unapproved) {
                    $row_unapproved = mysqli_fetch_array($result_unapproved);
                    $unapproved_members = $row_unapproved['unapproved_members'];
                }
                // Display total members and unapproved members in parentheses
                echo $total_members;
                if ($unapproved_members > 0) {
                    echo " <br>($unapproved_members Unapproved)";
                }
                ?>
            </div>
        </div>
    </a>
<a href="new_entry.php">
    <div class="custom-tile greencolor">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
		            <i class="entypo-user-add" style="margin-right: 10px;"></i>
            <h4>Register New Member</h4>
        </div>
    </div>
</a>

<a href="view_mem.php">
    <div class="custom-tile greencolor" style="margin-top:10px;">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
            <i class="entypo-users" style="margin-right: 10px;"></i>
            <h4>Manage Member</h4>
        </div>
    </div>
</a>


</div>



    <div class="col-sm-3">
        <a href="over_members_month.php">
            <div class="tile-stats tile-aqua">
                <div class="icon"><i class="entypo-mail"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Joined This Month</h2><br>
                    <?php
                    date_default_timezone_set("Asia/Kuala_Lumpur");
                    $date = date('Y-m');
                    $query = "SELECT COUNT(*) as total FROM users WHERE joining_date LIKE '$date%'";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                    ?>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-3">
        <a href="view_plan.php">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-rss"></i></div>
                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                    <h2>Total Active Event</h2><br>
                    <?php
                    $query = "SELECT COUNT(*) FROM plan WHERE active='yes'";
                    $result = mysqli_query($con, $query);
                    if ($result) {
                        $row = mysqli_fetch_array($result);
                        echo $row['COUNT(*)'];
                    }
                    ?>
                </div>
            </div>
        </a>
<a href="new_plan.php">
    <div class="custom-tile deepbluecolor">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
            <i class="entypo-plus" style="margin-right: 10px;"></i>
            <h4>Add New Planning</h4>
        </div>
    </div>
</a>		
		<a href="view_plan.php">
    <div class="custom-tile deepbluecolor" style="margin-top:10px;">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
            <i class="entypo-quote" style="margin-right: 10px;"></i>
            <h4>Manage Event</h4>
        </div>
    </div>
</a>
    </div>
</div>


<!--marquee direction="right"><img src="fball.gif" width="88" height="70" alt="Tutorials " border="0"></marquee-->


<a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#303641" href="../../">Go to Homepage</a>
    	<?php include('footer.php'); ?>
</div>
</div>


    </body>
</html>
