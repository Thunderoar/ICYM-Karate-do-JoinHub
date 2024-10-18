<?php
require '../../include/db_conn.php';
page_protect();

if (!isset($_SESSION['userid'])) {
    // Redirect to login page or display an error if the user is not logged in
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do | Payments</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css" id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css"> 
    <style>
        .page-container .sidebar-menu #main-menu li#paymnt > a {
            background-color: #2b303a;
            color: #ffffff;
        }
    </style>
</head>
<body class="page-body page-fade" onload="collapseSidebar()">
    <div class="page-container sidebar-collapsed" id="navbarcollapse">	
        <div class="sidebar-menu">
            <header class="logo-env">
                <!-- logo -->
                <?php require('../../element/loggedin-logo.html'); ?>
                <!-- logo collapse icon -->
                <div class="sidebar-collapse" onclick="collapseSidebar()">
                    <a href="#" class="sidebar-collapse-icon with-animation">
                        <i class="entypo-menu"></i>
                    </a>
                </div>
            </header>
            <?php include('nav.php'); ?>
        </div>

        <div class="main-content">
            <div class="row">
                <!-- Profile Info and Notifications -->
                <div class="col-md-6 col-sm-8 clearfix"></div>

                <!-- Raw Links -->
                <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                    <ul class="list-inline links-list pull-right">
					<?php
						require('../../element/loggedin-welcome.html');
					?>							
                        <li>
                            <a href="logout.php">Log Out <i class="entypo-logout right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <h2>Payments</h2>
            <hr />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <!-- <th>Membership Expiry</th> -->
                        <th>Name</th>
                        <th>Member ID</th>
                        <th>Phone</th>
                        <th>E-Mail</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
// Update query to show only the current user's enrollments
$query  = "SELECT * FROM enrolls_to WHERE userid = '$current_user_id' ORDER BY expire";
$result = mysqli_query($con, $query);
$sno    = 1;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $uid = $row['userid'];
        $planid = $row['planid'];
        $hasPaid = $row['hasPaid']; // Check if the user has already paid

        // Debugging: Output the hasPaid value
        echo "<!-- Debug: User ID: $uid, hasPaid: $hasPaid -->"; 

        $query1 = "SELECT * FROM users WHERE userid='$uid'";
        $result1 = mysqli_query($con, $query1);
        if (mysqli_num_rows($result1) == 1) {
            while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                echo "<tr><td>" . $sno . "</td>";
                //echo "<td>" . $row['expire'] . "</td>";
                echo "<td>" . $row1['username'] . "</td>";
                echo "<td>" . $row1['userid'] . "</td>";
                echo "<td>" . $row1['mobile'] . "</td>";
                echo "<td>" . $row1['email'] . "</td>";
                echo "<td>" . $row1['gender'] . "</td>";

                $sno++;

                // Only show "Add Payment" button if user has not paid
                if ($hasPaid === 'no') { // Use strict comparison
                    echo "<td>
                            <form action='make_payments.php' method='post'>
                                <input type='hidden' name='userID' value='" . $uid . "'/>
                                <input type='hidden' name='planID' value='" . $planid . "'/>
                                <input type='submit' class='a1-btn a1-blue' value='Add Payment' class='btn btn-info'/>
                            </form>
                          </td>";
                } else {
                    echo "<td>No Action Needed</td>"; // Indicate no action is needed
                }
            }
        }
    }
} else {
    echo "<tr><td colspan='8'>No payment records found.</td></tr>"; // Message for no records
}
?>

                </tbody>
            </table>

            <?php include('footer.php'); ?>
        </div>
    </body>
</html>
