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
            <th>Name</th>
            <th>Member ID</th>
            <th>Phone</th>
            <th>E-Mail</th>
            <th>Plan Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
<?php
    // Update query to include plan.amount
    $query  = "SELECT enrolls_to.*, users.username, users.mobile, users.email, 
               plan.planName, plan.amount 
               FROM enrolls_to 
               JOIN users ON enrolls_to.userid = users.userid 
               JOIN plan ON enrolls_to.planid = plan.planid 
               WHERE enrolls_to.userid = '$current_user_id' 
               ORDER BY enrolls_to.expire";
    $result = mysqli_query($con, $query);
    $sno    = 1;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $et_id = $row['et_id'];  // Get the enrollment ID for payment reference
        $uid = $row['userid'];
        $planid = $row['planid'];
        $hasPaid = $row['hasPaid'];         // Check if the user has already paid
        $hasApproved = $row['hasApproved']; // Check if the payment is approved
        $planName = $row['planName'];       // Retrieve the plan name
        $amount = $row['amount'] ?? 0;      // Get the amount from plan table with null check
        echo "<tr><td>" . $sno . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['userid'] . "</td>";
        echo "<td>" . $row['mobile'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $planName . ($amount > 0 ? " <b>(Fee: RM" . number_format($amount, 2) . ")" : "") . "</b></td>";
        $sno++;
        // Display different actions based on payment and approval status
        if ($hasPaid === 'no') {
            // If the payment has not been made
            echo "<td>
                    <form action='make_payments.php' method='post'>
                        <input type='hidden' name='userID' value='" . $uid . "'/>
                        <input type='hidden' name='planID' value='" . $planid . "'/>
                        <input type='hidden' name='et_id' value='" . $et_id . "'/>
                        <input type='submit' class='a1-btn a1-blue' value='Add Payment'/>
                    </form>
                    <p>Payment ID: $et_id</p>
                  </td>";
        } elseif ($hasPaid === 'yes' && $hasApproved === 'no') {
            // If the payment has been made but not approved
            echo "<td>
                    <p>Payment Pending Approval</p>
                    <p>Payment ID: $et_id</p>
                  </td>";
        } elseif ($hasPaid === 'yes' && $hasApproved === 'yes') {
            // If the payment has been made and approved
            echo "<td>
                    <p>Payment Approved</p>
                    <p>Payment ID: $et_id</p>
                  </td>";
        } else {
            // Default case if something goes wrong
            echo "<td>No Action Needed</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No payment records found.</td></tr>"; // Adjust colspan to match the number of columns
}
?>
    </tbody>
</table>




            <?php include('footer.php'); ?>
        </div>
    </body>
</html>
