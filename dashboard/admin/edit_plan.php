<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SPORTS CLUB | New Plan</title>
    <link rel="stylesheet" href="../../css/style.css" id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
        .page-container .sidebar-menu #main-menu li#planhassubopen > a {
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
                            <a href="logout.php">Log Out <i class="entypo-logout right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <h3>Update Plan</h3>
            <hr />
            <?php
            $id = mysqli_real_escape_string($con, $_GET['id']); // Sanitize the input
            $sql = "SELECT * FROM plan WHERE planid='$id'"; // Use single quotes around $id
            $res = mysqli_query($con, $sql);
            
            if ($res && mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
            } else {
                echo "<p>Plan not found or invalid ID.</p>";
                exit; // Stop script execution if no results are found
            }
            ?>
            
            <div class="a1-container a1-small a1-padding-32" style="margin-top:2px; margin-bottom:2px;">
                <div class="a1-card-8 a1-light-gray" style="width:600px; margin:0 auto;">
                    <div class="a1-container a1-dark-gray a1-center">
                        <h6>PLAN UPDATE</h6>
                    </div>
<form id="form1" name="form1" method="post" class="a1-container" action="updateplan.php">
    <input type="hidden" name="origin" value="view_plan">
    <table width="100%" border="0" align="center">
        <tr>
            <td height="35">Plan ID:</td>
            <td height="35">
                <input type="text" name="planid" id="planID" readonly value='<?php echo $row['planid']; ?>'>
            </td>
        </tr>
        <tr>
            <td height="35">Plan Name:</td>
            <td height="35">
                <input name="planname" id="planName" type="text" value='<?php echo $row['planName']; ?>' size="40">
            </td>
        </tr>
        <tr>
            <td height="35">Plan Description:</td>
            <td height="35">
                <input type="text" name="desc" id="planDesc" value='<?php echo $row['description']; ?>' size="40">
            </td>
        </tr>
        <tr>
            <td height="35">Plan Type:</td>
            <td height="35">
                <input type="text" name="plantype" id="planType" value='<?php echo $row['planType']; ?>' size="40">
            </td>
        </tr>
        <tr>
            <td height="35">Start Date:</td>
            <td height="35">
                <input type="date" name="startdate" id="startDate" value='<?php echo $row['startDate']; ?>' size="40" onchange="calculateDuration()">
            </td>
        </tr>
        <tr>
            <td height="35">End Date:</td>
            <td height="35">
                <input type="date" name="enddate" id="endDate" value='<?php echo $row['endDate']; ?>' size="40" onchange="calculateDuration()">
            </td>
        </tr>
        <tr>
            <td height="35">Duration (Days):</td>
            <td height="35">
                <input type="text" name="duration" id="duration" value='<?php echo $row['duration']; ?>' size="40" readonly>
            </td>
        </tr>
        <tr>
            <td height="35">Plan Amount:</td>
            <td height="35">
                <input type="text" name="amount" id="planAmnt" value='<?php echo $row['amount']; ?>' size="40">
            </td>
        </tr>
        <tr>
            <td height="35">&nbsp;</td>
            <td height="35">
                <input class="a1-btn a1-blue" type="submit" name="submit" id="submit" value="UPDATE PLAN">
                <input class="a1-btn a1-blue" type="reset" name="reset" id="reset" value="Reset">
            </td>
        </tr>
    </table>
</form>

                </div>
            </div>   
            <?php include('footer.php'); ?>
        </div>
    </body>
	<script>
function calculateDuration() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const durationInput = document.getElementById('duration');

    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (startDate && endDate && startDate <= endDate) {
        const duration = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)); // Convert milliseconds to days
        durationInput.value = duration;
    } else {
        durationInput.value = ''; // Clear duration if dates are invalid
    }
}
</script>
</html>
