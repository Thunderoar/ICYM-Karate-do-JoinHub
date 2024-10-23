<?php
require '../../include/db_conn.php';
page_protect();

// Assuming you have the user ID stored in the session after login
$userId = $_SESSION['userid'];

// Check if the user is approved
$query = "SELECT hasApproved FROM users WHERE userid = '$userId'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$isApproved = $row['hasApproved'];

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
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .tile-stats {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        /* Style for the approval message */
        .approval-message {
            color: grey;
            font-size: 36px; /* Change size as needed */
            text-align: center;
            margin: 20px 0; /* Add some spacing around the message */
        }
    </style>
</head>
<body class="page-body page-fade" onload="collapseSidebar()">

    <div class="page-container sidebar-collapsed" id="navbarcollapse">    
        <div class="sidebar-menu">
            <header class="logo-env">
                <?php require('../../element/loggedin-logo.html'); ?>
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
                <div class="col-md-6 col-sm-8 clearfix"></div>
                <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                    <ul class="list-inline links-list pull-right">
                        <?php require('../../element/loggedin-welcome.html'); ?>
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

            <?php if ($isApproved == 'No'): ?>
                <div class="approval-message">You have not been approved yet.</div>
				<div class="approval-message">Please wait for approval by the Club Manager.</div><br>
            <?php else: ?>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="revenue_month.php">
                            <div class="tile-stats tile-red">
                                <div class="icon"><i class="entypo-users"></i></div>
                                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                                    <h2>Paid Income This Month</h2><br>
                                    <?php
                                    date_default_timezone_set("Asia/Kuala_Lumpur");
                                    $date = date('Y-m');
                                    $query = "SELECT * FROM enrolls_to WHERE paid_date LIKE '$date%'";
                                    $result = mysqli_query($con, $query);
                                    $revenue = 0;
                                    if (mysqli_num_rows($result) != 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $query1 = "SELECT amount FROM plan WHERE planid='" . $row['planid'] . "'";
                                            $result1 = mysqli_query($con, $query1);
                                            if ($result1) {
                                                $plan = mysqli_fetch_assoc($result1);
                                                $revenue += floatval($plan['amount']);
                                            }
                                        }
                                    }
                                    echo "RM" . number_format($revenue, 2);
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-3">
                        <a href="table_view.php">
                            <div class="tile-stats tile-green">
                                <div class="icon"><i class="entypo-chart-bar"></i></div>
                                <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                                    <h2>Total <br>Members</h2><br>
                                    <?php
                                    $query = "SELECT COUNT(*) FROM users";
                                    $result = mysqli_query($con, $query);
                                    if ($result) {
                                        $row = mysqli_fetch_array($result);
                                        echo $row['COUNT(*)'];
                                    }
                                    ?>
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
                                    <h2>Total Plan Available</h2><br>
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
                    </div>
                </div>
            <?php endif; ?>

            <a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#303641" href="../../">Go to Homepage</a>
            <?php include('footer.php'); ?>
        </div>
    </div>
</body>
</html>
