<?php
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
		.min-height-100 {
    min-height: 100px;
}

.badge {
    font-size: 14px;
}

.badge button {
    color: white !important;
    font-size: 16px !important;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0 !important;
    margin-left: 5px;
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
    <form id="planForm" method="post" action="submit_plan_new.php?action=create_plan" enctype="multipart/form-data">
<h3 style="text-align: center;"><u>Enter Plan Details</u></h3>

        <div class="row">
<div class="col-md-6">



                <!-- Plan Image -->
<div class="form-group">
    <label><b>Event Image:</b></label>
    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
    <img id="image-preview" src="" alt="Image Preview" style="display: none; margin-top: 10px;" width="400">
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('image-preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>




                <!-- Plan ID (Read-only) -->
                <div class="form-group">
                    <label><b>Plan ID:</b></label>
                    <input type="text" name="planid" id="planID" class="form-control" readonly 
                        value="<?php echo getRandomWord(); ?>">
                </div>

                <!-- Hidden Timetable ID -->
                <input type="hidden" name="timetable_id" value="<?php echo mt_rand(1, 1000000000); ?>">

                <!-- Plan Name -->
                <div class="form-group">
                    <label><b>Plan Name:</b></label>
                    <input type="text" name="planname" id="planName" class="form-control" placeholder="Enter plan name" required>
                </div>
				
                <!-- Plan Type -->
                <div class="form-group">
                    <label><b>Type of Plan:</b></label>
                    <select name="plantype" id="plantype" class="form-control" required onchange="updateFeeLabel()">
                        <option value="">--Please Select--</option>
                        <option value="Core">Core</option>
                        <option value="Event">Event</option>
                        <option value="Tournament">Tournament</option>
                        <option value="Collaboration">Collaboration</option>
                    </select>
                </div>
				
        <h3><u>Involved Staff</u></h3>				
    <!-- Staff Selection with Add Button -->
    <div class="form-group">
        <label><b>Choose Staff:</b></label>
        <div class="input-group">
            <select name="staff_select" id="boxx" class="form-control" onchange="mystaffdetail(this.value)">
                <option value="">--Please Select--</option>
                <?php
                // Query to select all staff
                $query = "SELECT * FROM staff";
                $result = mysqli_query($con, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['staffid']}' 
                              data-username='{$row['username']}' 
                              data-role='{$row['role']}'>"
                              . htmlspecialchars($row['name']) . "</option>";
                    }
                }
                ?>
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-success" onclick="addStaffMember()">Add Staff</button>
            </div>
        </div>
    </div>

    <!-- Selected Staff Members Display -->
    <div class="form-group">
        <label><b>Selected Staff Members:</b></label>
        <div id="selectedStaffContainer" class="border rounded p-2 min-height-100">
            <!-- Selected staff will be displayed here -->
        </div>
        <!-- Hidden inputs to store staff data -->
        <input type="hidden" name="selected_staff_data" id="selectedStaffData" value="">
    </div>



            </div>

            <div class="col-md-6">
                <!-- Description -->
                <div class="form-group">
                    <label><b>Description:</b></label>
                    <textarea name="desc" id="planDesc" class="form-control" placeholder="Enter plan description" rows="3"></textarea>
                </div>

                <!-- Start Date, End Date, and Duration -->
                <div class="form-group">
                    <label><b>Start Date:</b></label>
                    <input type="date" name="startDate" id="startDate" class="form-control" onchange="calculateDuration()" required>
                </div>
                <div class="form-group">
                    <label><b>End Date:</b></label>
                    <input type="date" name="endDate" id="endDate" class="form-control" onchange="calculateDuration()" required>
                </div>
                <div class="form-group">
                    <label><b>Duration (Days):</b></label>
                    <input type="number" name="duration" id="duration" class="form-control" readonly>
                </div>

                <!-- Plan Amount -->
                <div class="form-group">
                    <label id="feeLabel"><b>Plan Fee:</b></label>
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
let selectedStaff = new Map(); // Using Map to store staff data

function addStaffMember() {
    const select = document.getElementById('boxx');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!select.value) {
        alert('Please select a staff member');
        return;
    }

    // Check if staff is already added
    if (selectedStaff.has(select.value)) {
        alert('This staff member is already added');
        return;
    }

    // Generate timetable name (you can modify this format)
    // const tname = `${selectedOption.text}'s Schedule`;

    // Add to Map with staff data
    selectedStaff.set(select.value, {
        staffid: select.value,
        name: selectedOption.text,
        //tname: tname
    });

    // Create staff member display element
    const container = document.getElementById('selectedStaffContainer');
    const staffElement = document.createElement('div');
    staffElement.className = 'badge badge-primary m-1 p-2 d-inline-flex align-items-center';
    staffElement.innerHTML = `
        ${selectedOption.text}
        <button type="button" class="btn btn-link p-0 ml-2" 
                style="color: white !important; font-size: 16px !important; background: none; border: none;"
                onclick="removeStaffMember('${select.value}', this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(staffElement);

    // Update hidden input with staff data
    updateSelectedStaffData();

    // Reset select
    select.value = '';
}



function removeStaffMember(staffId, buttonElement) {
    selectedStaff.delete(staffId);
    buttonElement.closest('.badge').remove();
    updateSelectedStaffData();
}

function updateSelectedStaffData() {
    const staffData = Array.from(selectedStaff.values());
    document.getElementById('selectedStaffData').value = JSON.stringify(staffData);
}

// Optional: Add validation before form submission
document.getElementById('planForm').onsubmit = function(e) {
    if (selectedStaff.size === 0) {
        alert('Please select at least one staff member');
        e.preventDefault();
        return false;
    }
    return true;
};
    </script>
</body>
</html>