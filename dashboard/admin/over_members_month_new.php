<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do | Member per Month</title>
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
	
	<link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
        .page-container .sidebar-menu #main-menu li#overviewhassubopen > a {
            background-color: #2b303a;
            color: #ffffff;
        }
    </style>
</head>
<body class="page-body page-fade" onload="collapseSidebar(); showMember();">

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
                        <a href="logout.php">Log Out <i class="entypo-logout right"></i></a>
                    </li>
                </ul>
            </div>
        </div>

        <h2>New Members for Selected Month</h2>
        <hr />

        <form id="filter-form">
            <?php
            // Set start and end year range
            $yearArray = range(2000, date('Y'));
            ?>
            <!-- Year Dropdown -->
            <select name="year" id="syear" onchange="updateMonthCounts(); showMember();">
                <option value="0">Select Year</option>
                <?php
                foreach ($yearArray as $year) {
                    $selected = ($year == date('Y')) ? 'selected' : '';
                    echo "<option $selected value='$year'>$year</option>";
                }
                ?>
            </select>

            <?php
            $formattedMonthArray = [
                "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                "09" => "September", "10" => "October", "11" => "November", "12" => "December",
            ];
            ?>
            <!-- Month Dropdown -->
            <select name="month" id="smonth" onchange="showMember();">
                <option value="0">Select Month</option>
                <?php
                foreach ($formattedMonthArray as $key => $month) {
                    $selected = ($key == date('m')) ? 'selected' : '';
                    echo "<option $selected value='$key' id='month-$key'>$month</option>";
                }
                ?>
            </select>
        </form>

        <!-- Table for displaying results -->
        <table id="memmonth" border="1" class="table table-bordered datatable">
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
                    <th>Plan Details</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by AJAX -->
            </tbody>
        </table>

        <script>
            // Automatically show members and update month counts when page loads
            document.addEventListener('DOMContentLoaded', function() {
                updateMonthCounts();
                showMember();
            });

            function updateMonthCounts() {
                var year = document.getElementById("syear").value;
                
                // Only proceed if a year is selected
                if (year == "0") {
                    // Reset month options to default
                    var monthSelect = document.getElementById("smonth");
                    for (var i = 1; i <= 12; i++) {
                        var monthNum = i.toString().padStart(2, '0');
                        var option = document.getElementById('month-' + monthNum);
                        if (option) {
                            option.text = monthNames[i-1]; // Reset to original month name
                        }
                    }
                    return;
                }

                // Show loading state in month dropdown
                var monthSelect = document.getElementById("smonth");
                monthSelect.disabled = true;

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var counts = JSON.parse(this.responseText);
                        
                        // Update each month option with count
                        Object.keys(counts).forEach(function(month) {
                            var option = document.getElementById('month-' + month);
                            if (option) {
                                var monthName = monthNames[parseInt(month)-1];
                                option.text = monthName + " (" + counts[month] + " members)";
                            }
                        });
                        
                        monthSelect.disabled = false;
                    }
                };

                xmlhttp.open("GET", "get_month_counts.php?year=" + year, true);
                xmlhttp.send();
            }

            // Array of month names for reference
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            function showMember() {
                var year = document.getElementById("syear");
                var month = document.getElementById("smonth");
                var ynumber = year.value;
                var mnumber = month.value;

                if (mnumber == "0" || ynumber == "0") {
                    document.getElementById("memmonth").getElementsByTagName('tbody')[0].innerHTML = 
                        "<tr><td colspan='10' class='text-center'>Please select both year and month.</td></tr>";
                    return;
                }

                // Show loading message while fetching data
                document.getElementById("memmonth").getElementsByTagName('tbody')[0].innerHTML = 
                    "<tr><td colspan='10' class='text-center'>Loading...</td></tr>";

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("memmonth").getElementsByTagName('tbody')[0].innerHTML = this.responseText;
                    }
                };

                xmlhttp.open("GET", "get_members_by_join_date.php?mm=" + mnumber + "&yy=" + ynumber, true);
                xmlhttp.send();
            }
        </script>

        <?php include('footer.php'); ?>
    </div>
</div>
</body>
</html>
