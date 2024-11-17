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

// Get the logged-in user's ID from the session
$user_id = $_SESSION['userid'];

// Fetch the user profile
$sql = "SELECT * FROM users WHERE userid = $user_id";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $userProfile = $result->fetch_assoc();

    // Check if the profile is complete
    $isProfileComplete = true;
    foreach ($userProfile as $key => $value) {
        if ($value === null) {
            $isProfileComplete = false;
            break;
        }
    }
} else {
    // Handle case where user is not found
    $isProfileComplete = false;
}

$con->close();
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


.profile-button {
  display: none;
  padding: 10px 20px;
  font-size: 16px;
  color: #fff;
  background-color: #28a745;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: background-color 0.3s ease;
  margin: 0 auto; /* Center the button horizontally */
  display: block; /* Needed to use margin auto */
  text-align: center; /* Center the text inside the button */
}
.profile-button:hover {
  background-color: #218838;
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
<div class="approval-message complete-profile">Please do complete your profile.</div><br>
<div class="approval-message wait-approval" style="display: none;">You have completed your profile. <br>Please wait for approval by the Club Manager <br> which might take up to 3 days.</div>
<button class="profile-button" style="display: none;" onclick="window.location.href='more-userprofile.php'">Complete Your Profile</button>

<script>
  // Custom function to display appropriate message or button based on profile completion
  function showProfileStatus() {
    <?php if ($isProfileComplete): ?>
      document.querySelector('.complete-profile').style.display = 'none';
      document.querySelector('.wait-approval').style.display = 'block';
    <?php else: ?>
      document.querySelector('.complete-profile').style.display = 'block';
      document.querySelector('.profile-button').style.display = 'block';
    <?php endif; ?>
  }

  // Call the custom function on window load
  window.addEventListener('load', showProfileStatus);
</script>


            <?php else: ?>
                <div class="row">
<div class="col-sm-3">
<div class="tile-stats tile-aqua">
    <div class="icon"><i class="entypo-calendar"></i></div>
    <div class="num">
        <h2>Upcoming Events</h2><br>
        <?php
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $currentDate = date('Y-m-d'); // Get the current date
        
        // Query to fetch upcoming active events
        $query = "
            SELECT planName, startDate, description, planid, tid
            FROM plan 
            WHERE startDate > '$currentDate' 
              AND active = 1 
            ORDER BY startDate ASC 
            LIMIT 5"; // Limit to 5 upcoming events
        
        $result = mysqli_query($con, $query);
        
        if (mysqli_affected_rows($con) > 0) {
            echo '<ul>';
            while ($row = mysqli_fetch_assoc($result)) {
                $description = htmlspecialchars($row['description']);
                // Truncate description to 50 characters
                if (strlen($description) > 50) {
                    $description = substr($description, 0, 50) . '...';
                }

                echo '<li style="font-size: 20px; line-height: 1.4;">';
                echo '<strong>' . htmlspecialchars($row['planName']) . '</strong><br>';
                echo 'Date: ' . htmlspecialchars($row['startDate']) . '<br>';
                echo 'Description: ' . $description . '<br>';
                echo '<a href="../../dashboard/admin/timetable_detail.php?planid=' . htmlspecialchars($row['planid']) . '&id=' . htmlspecialchars($row['tid']) . '">';
                echo '<button style="font-size: 14px; padding: 10px 20px; background-color: #e67e22; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Event Detail</button>';
                echo '</a></li>';
            }
            echo '</ul>';
        } else {
            echo '<p style="font-size: 12px;">No upcoming events.</p>';
        }
        ?>
    </div>
</div>

</div>



<div class="col-sm-3"><a href="payments.php">
<div class="tile-stats tile-red">
    <div class="icon"><i class="entypo-users"></i></div>
    <div class="num" data-postfix="" data-duration="1500" data-delay="0">
        <h2>You have paid</h2><br>
        <?php
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $date = date('Y-m');
            
            // Get the user's ID from the session
            $userId = $_SESSION['userid']; // Make sure to start the session at the top of your PHP file
            
            // Updated query to use 'yes' instead of 1
            $query = "SELECT planid FROM enrolls_to 
                     WHERE userid = '$userId' 
                     AND paid_date LIKE '$date%' 
                     AND hasPaid = 'yes' 
                     AND hasApproved = 'yes'";
            
            $result = mysqli_query($con, $query);
            $revenue = 0;
            
            // Check if there are any payments made
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    // Query to get the plan details based on the plan ID
                    $query1 = "SELECT amount FROM plan WHERE planid='" . $row['planid'] . "'";
                    $result1 = mysqli_query($con, $query1);
                    
                    if ($result1) {
                        $value = mysqli_fetch_assoc($result1);
                        
                        // Ensure the amount is numeric before addition
                        if (isset($value['amount'])) {
                            $revenue += floatval($value['amount']); // Use floatval to ensure it's treated as a number
                        }
                    }
                }
            }
            
            // Display the calculated revenue only if it's greater than zero
            if ($revenue > 0) {
                echo "RM" . number_format($revenue, 2); // Format to two decimal places
            } else {
                echo "No payments made this month.";
            }
        ?>
    </div>
</div>

</a>
		    <a href="payments.php">
        <div class="custom-tile redcolor">
            <div class="num" style="display: flex; align-items: center; justify-content: center;">
                <i class="entypo-star" style="margin-right: 10px;"></i>
                <h4>Make Payments</h4>
            </div>
        </div>
    </a></div>

<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$bmiMessage = "No Health Data Available - Please update your height and weight.";
$bmi = null;

// Check if user is logged in
if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
    $userid = intval($_SESSION['userid']); // Convert to integer for security
    
    // Use prepared statement to prevent SQL injection
    $query = "SELECT height, weight FROM health_status WHERE userid = ?";
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $height = floatval($row['height']); // Convert to float
            $weight = floatval($row['weight']); // Convert to float
            
            if (empty($height) || empty($weight)) {
                $bmiMessage = "Incomplete Health Data - Please update your height and weight.";
            } elseif ($height > 0 && $weight > 0) {
                // Check if height is in meters (assuming height should be between 1 and 3 meters)
                if ($height > 3) {
                    $height = $height / 100; // Convert from cm to meters if necessary
                }
                
                $bmi = $weight / ($height * $height);
                $bmi = round($bmi, 2);
                
// Determine health status based on BMI
                if ($bmi < 18.5) {
                    $bmiMessage = htmlspecialchars("Underweight") . "<br><br><br><br>" . htmlspecialchars("(BMI: $bmi)");
                    $tileClass = "tile-red"; // Add visual indicator
                } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
                    $bmiMessage = htmlspecialchars("Healthy") . "<br><br><br><br>" . htmlspecialchars("(BMI: $bmi)");
                    $tileClass = "tile-green";
                } elseif ($bmi >= 25 && $bmi <= 29.9) {
                    $bmiMessage = htmlspecialchars("Overweight") . "<br><br><br><br>" . htmlspecialchars("(BMI: $bmi)");
                    $tileClass = "tile-orange";
                } else {
                    $bmiMessage = htmlspecialchars("Obese") . "<br><br><br><br>" . htmlspecialchars("(BMI: $bmi)");
                    $tileClass = "tile-red";
                }
            } else {
                $bmiMessage = htmlspecialchars("Invalid Health Data") . "<br>" . htmlspecialchars("Please update your height and weight.");
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $bmiMessage = "System Error - Please try again later.";
        error_log("Failed to prepare BMI calculation query: " . mysqli_error($con));
    }
} else {
    $bmiMessage = "Please log in to view your health status.";
}

// Set default tile class if not set
if (!isset($tileClass)) {
    $tileClass = "tile-blue";
}
?>

<div class="col-sm-3">
    <a href="more-userprofile.php">
        <div class="tile-stats <?php echo htmlspecialchars($tileClass); ?>">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2><?php echo $bmiMessage; ?></h2>
            </div>
        </div>
    </a>
<a href="more-userprofile.php#health_status_section">
    <div class="custom-tile greencolor" style="margin-top:10px;">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
            <i class="entypo-users" style="margin-right: 10px;"></i>
            <h4>Edit Your Health Status</h4>
        </div>
    </div>
</a>

</div>






<div class="col-sm-3">
    <a href="view_plan.php">
        <div class="tile-stats tile-blue">
            <div class="icon"><i class="entypo-rss"></i></div>
            <div class="num" data-postfix="" data-duration="1500" data-delay="0">
                <h2>Joined Activity</h2><br>
                <?php
                if (!isset($_SESSION['userid'])) {
                    echo "0"; // Show 0 if not logged in
                } else {
                    $userid = mysqli_real_escape_string($con, $_SESSION['userid']);
                    
                    // Query to count active plans that the user has joined
                    $query = "SELECT COUNT(*) as plan_count 
                             FROM enrolls_to e 
                             INNER JOIN plan p ON e.planid = p.planid 
                             WHERE e.userid = '$userid' 
                             AND p.active = 'yes' 
                             AND e.hasApproved = 'yes'";
                    
                    $result = mysqli_query($con, $query);
                    
                    if ($result && mysqli_affected_rows($con) != 0) {
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo htmlspecialchars($row['plan_count']);
                    } else {
                        echo "0";
                    }
                }
                ?>
            </div>
        </div>
    </a>
					<a href="view_plan.php">
    <div class="custom-tile deepbluecolor" style="margin-top:10px;">
        <div class="num" style="display: flex; align-items: center; justify-content: center;">
            <i class="entypo-quote" style="margin-right: 10px;"></i>
            <h4>See Active Event</h4>
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
