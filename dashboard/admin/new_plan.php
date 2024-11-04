﻿<?php
require '../../include/db_conn.php';
page_protect();

// Add the getRandomWord function
function getRandomWord($len = 6) {
    $word = array_merge(range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}

?>


<?php
require '../../include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do | New Plan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/style.css" id="style-resource-5">
    <script type="text/javascript" src="../../js/Script.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/entypo.css">
    <link href="a1style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashboard/sidebar.css">
    <style>
        .day-actions {
            display: flex;
            gap: 10px;
        }
        .home-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 20px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }
        .container {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .day-entry {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
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
                <div class="col-md-6 col-sm-8 clearfix">
                </div>
                
                <!-- Raw Links -->
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

            <h2>Create New Plan</h2>
            <hr/>

<div class="container">
    <!-- Plan Creation Form -->
    <form id="planForm" method="post" action="submit_plan_new.php?action=create_plan" enctype="multipart/form-data">
        <h3>Create a New Plan</h3>
        <div class="row">
            <div class="col-md-6">
                <!-- Plan Type -->
                <div class="form-group">
                    <label>Type of Plan:</label>
                    <select name="plantype" id="plantype" class="form-control" required onchange="updateFeeLabel()">
                        <option value="">--Please Select--</option>
                        <option value="Core">Core</option>
                        <option value="Event">Event</option>
                        <option value="Tournament">Tournament</option>
                        <option value="Collaboration">Collaboration</option>
                    </select>
                </div>

                <!-- Plan Image -->
                <div class="form-group">
                    <label>Event Image:</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <!-- Plan ID (Read-only) -->
                <div class="form-group">
                    <label>Plan ID:</label>
                    <input type="text" name="planid" id="planID" class="form-control" readonly 
                        value="<?php echo getRandomWord(); ?>">
                </div>

                <!-- Hidden Timetable ID -->
                <input type="hidden" name="timetable_id" value="<?php echo mt_rand(1, 1000000000); ?>">

                <!-- Plan Name -->
                <div class="form-group">
                    <label>Plan Name:</label>
                    <input type="text" name="planname" id="planName" class="form-control" placeholder="Enter plan name" required>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Description -->
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="desc" id="planDesc" class="form-control" placeholder="Enter plan description" rows="3"></textarea>
                </div>

                <!-- Start Date, End Date, and Duration -->
                <div class="form-group">
                    <label>Start Date:</label>
                    <input type="date" name="startDate" id="startDate" class="form-control" onchange="calculateDuration()" required>
                </div>
                <div class="form-group">
                    <label>End Date:</label>
                    <input type="date" name="endDate" id="endDate" class="form-control" onchange="calculateDuration()" required>
                </div>
                <div class="form-group">
                    <label>Duration (Days):</label>
                    <input type="number" name="duration" id="duration" class="form-control" readonly>
                </div>

                <!-- Plan Amount -->
                <div class="form-group">
                    <label id="feeLabel">Plan Fee:</label>
                    <input type="text" name="amount" id="planAmnt" class="form-control" placeholder="Enter plan amount">
                </div>
            </div>
        </div>
        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">CREATE PLAN</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <a href="view_plan.php" class="btn btn-info">Return to Plans</a>
        </div>
    </form>
</div>

            </div>
        </div>
    </div>

    <a class="home-button" href="view_plan.php">
        Return Back
    </a>

    <?php include('footer.php'); ?>

    <script>
        function updateFeeLabel() {
            const selectedPlanType = document.getElementById('plantype').value;
            const feeLabel = document.getElementById('feeLabel');
            feeLabel.innerText = selectedPlanType ? selectedPlanType + " Fee:" : "Plan Fee:";
        }

        function calculateDuration() {
            const startDateInput = document.getElementById('startDate').value;
            const endDateInput = document.getElementById('endDate').value;
            if (startDateInput && endDateInput) {
                const startDate = new Date(startDateInput);
                const endDate = new Date(endDateInput);
                const duration = (endDate - startDate) / (1000 * 60 * 60 * 24);
                document.getElementById('duration').value = duration >= 0 ? duration : 0;
            } else {
                document.getElementById('duration').value = '';
            }
        }

        let dayCount = 1;

        function addDay() {
            dayCount++;
            const dayEntry = document.createElement('div');
            dayEntry.className = 'day-entry';
            dayEntry.innerHTML = `
                <label>Day ${dayCount} Activities:</label>
                <div class="input-group">
                    <textarea name="days[]" class="form-control" 
                        placeholder="Activities for Day ${dayCount}" rows="3"></textarea>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger" onclick="removeDay(this)">
                            Remove
                        </button>
                    </div>
                </div>
            `;
            document.getElementById('daysContainer').appendChild(dayEntry);
        }

        function removeDay(button) {
            const dayEntry = button.closest('.day-entry');
            dayEntry.remove();
            // Reorder remaining days
            const days = document.querySelectorAll('.day-entry');
            days.forEach((day, index) => {
                day.querySelector('label').textContent = `Day ${index + 1} Activities:`;
            });
            dayCount = days.length;
        }
    </script>
</body>
</html>