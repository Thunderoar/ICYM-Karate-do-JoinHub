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
</div>


			<div class="col-sm-3"><a href="viewroutine.php">
				<div class="tile-stats tile-aqua">
					<div class="icon"><i class="entypo-mail"></i></div>
						<div class="num" data-postfix="" data-duration="1500" data-delay="0">
						<h2>Today's activity</h2><br>
							<?php
							date_default_timezone_set("Asia/Kuala_Lumpur");
							$date  = date('Y-m');
							$query = "select COUNT(*) from users WHERE joining_date LIKE '$date%'";
							//echo $query;
							$result = mysqli_query($con, $query);
							$i      = 1;
							if (mysqli_affected_rows($con) != 0) {
							    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
							        echo $row['COUNT(*)'];
							    }
							}
							$i = 1;
							?>
						</div>
				</div></a>
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
</div>
                </div>
            <?php endif; ?>

            <a class="btn-sm px-4 py-3 d-flex home-button" style="background-color:#303641" href="../../">Go to Homepage</a>
            <?php include('footer.php'); ?>
        </div>
    </div>
</body>
</html>
