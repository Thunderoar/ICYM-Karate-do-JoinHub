<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>ICYM Karate-Do | Income per Month</title>
    <link rel="stylesheet" href="../../css/style.css"  id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" href="../../css/dashMain.css">
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    
    <style>
        .page-container .sidebar-menu #main-menu li#overviewhassubopen > a {
            background-color: #2b303a;
            color: #ffffff;
        }
    </style>

</head>
<body class="page-body page-fade" onload="collapseSidebar(); showMember(); autoloadTable();">

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
                    <?php
                        require('../../element/loggedin-welcome.html');
                    ?>
                        <li><a href="logout.php">Log Out <i class="entypo-logout right"></i></a></li>
                    </ul>
                </div>
            </div>

            <h3>Income Per Month</h3>
            <hr />

            <form>
            <?php
            // Set start and end year range
            $yearArray = range(2000, date('Y'));
            // Get current year and month
            $currentYear = date('Y');
            $currentMonth = date('m');
            ?>
            <!-- Dropdown for years with current year selected -->
            <select name="year" id="syear" onchange="showMember();">
                <option value="0">Select Year</option>
                <?php
                foreach ($yearArray as $year) {
                    $selected = ($year == $currentYear) ? 'selected' : '';
                    echo '<option ' . $selected . ' value="' . $year . '">' . $year . '</option>';
                }
                ?>
            </select>

            <?php
            // Set the month array
            $formattedMonthArray = array(
                "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                "09" => "September", "10" => "October", "11" => "November", "12" => "December"
            );
            ?>
            <!-- Dropdown for months with current month selected -->
            <select name="month" id="smonth" onchange="showMember();">
                <option value="0">Select Month</option>
                <?php
                foreach ($formattedMonthArray as $key => $month) {
                    $selected = ($key == $currentMonth) ? 'selected' : '';
                    echo '<option ' . $selected . ' value="' . $key . '">' . $month . '</option>';
                }
                ?>
            </select>

            </form>

            <!-- Table to display income -->
            <table class="table table-bordered datatable" id="memmonth" border="2" style="font-size:15px;"></table>

            <script>
            // Function to ensure the table loads on page load
            function autoloadTable() {
                // Get the current year and month from the select elements
                var yearSelect = document.getElementById("syear");
                var monthSelect = document.getElementById("smonth");
                
                // If both dropdowns have valid selections, load the table
                if (yearSelect.value != "0" && monthSelect.value != "0") {
                    showMember();
                }
            }

            function showMember() {
                var year = document.getElementById("syear").value;
                var month = document.getElementById("smonth").value;

                // Ensure both month and year are selected
                if (month == "0" || year == "0") {
                    document.getElementById("memmonth").innerHTML = "";
                    return;
                }

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("memmonth").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "income_month.php?mm=" + month + "&yy=" + year, true);
                xmlhttp.send();
            }

            // Add event listener for when the DOM is fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                autoloadTable();
            });
            </script>

            <?php include('footer.php'); ?>
        </div>
    </div>
</body>
</html>
