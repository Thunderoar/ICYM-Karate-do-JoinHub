<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SPORTS CLUB | Member per Month</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css" id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <style>
        .page-container .sidebar-menu #main-menu li#overviewhassubopen > a {
            background-color: #2b303a;
            color: #ffffff;
        }
    </style>
</head>
<body class="page-body page-fade" onload="collapseSidebar();">

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
                    <li>Welcome <?php echo $_SESSION['full_name']; ?></li>
                    <li>
                        <a href="logout.php">
                            Log Out <i class="entypo-logout right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <h2>Member Per Month</h2>
        <hr />

        <form id="filter-form">
            <?php
            // Set start and end year range
            $yearArray = range(2000, date('Y'));
            ?>
            <!-- Year Dropdown -->
            <select name="year" id="syear">
                <option value="0">Select Year</option>
                <?php
                foreach ($yearArray as $year) {
                    $selected = ($year == date('Y')) ? 'selected' : '';
                    echo "<option $selected value='$year'>$year</option>";
                }
                ?>
            </select>

            <?php
            // Month array with numeric values and names
            $formattedMonthArray = [
                "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                "09" => "September", "10" => "October", "11" => "November", "12" => "December",
            ];
            ?>
            <!-- Month Dropdown -->
            <select name="month" id="smonth">
                <option value="0">Select Month</option>
                <?php
                foreach ($formattedMonthArray as $key => $month) {
                    $selected = ($key == date('m')) ? 'selected' : '';
                    echo "<option $selected value='$key'>$month</option>";
                }
                ?>
            </select>

            <!-- Search Button -->
            <input type="button" class="a1-btn a1-blue" style="margin-bottom:5px;" onclick="showMember();" value="Search">
        </form>

        <!-- Table for displaying results -->
        <table id="memmonth" border="1" class="table table-bordered">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Gender</th>
                    <th>State</th>
                    <th>City</th>
                    <th>DOB</th>
                    <th>Joining Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by AJAX -->
            </tbody>
        </table>

        <script>
            function showMember() {
                var year = document.getElementById("syear");
                var month = document.getElementById("smonth");
                var ynumber = year.value;
                var mnumber = month.value;

                // If either year or month is not selected, clear the table and stop
                if (mnumber == "0" || ynumber == "0") {
                    document.getElementById("memmonth").getElementsByTagName('tbody')[0].innerHTML = "<tr><td colspan='10'>Please select both year and month.</td></tr>";
                    return;
                }

                // Create a new XMLHttpRequest object
                var xmlhttp = new XMLHttpRequest();

                // Define what happens when the response is received
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // Populate the table with the response
                        document.getElementById("memmonth").getElementsByTagName('tbody')[0].innerHTML = this.responseText;
                    }
                };

                // Make the AJAX request
                xmlhttp.open("GET", "over_month.php?mm=" + mnumber + "&yy=" + ynumber + "&flag=0", true);
                xmlhttp.send();
            }
        </script>

        <?php include('footer.php'); ?>
    </div>
</div>
</body>
</html>
