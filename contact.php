<?php
require 'include/db_conn.php';


// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables for form processing
$success_message = '';
$error_message = '';

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validate inputs
    if (empty($fullname)) {
        $error_message = "Full name is required";
    }
    elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Valid email is required";
    }
    elseif (empty($subject)) {
        $error_message = "Subject is required";
    }
    elseif (empty($message)) {
        $error_message = "Message is required";
    }
    else {
        // Sanitize all inputs
        $fullname = sanitize_input($fullname);
        $email = sanitize_input($email);
        $subject = sanitize_input($subject);
        $message = sanitize_input($message);

        // Prepare and execute the database insert
        $query = "INSERT INTO contact_messages (fullname, email, subject, message, created_at) 
                 VALUES (?, ?, ?, ?, NOW())";
                 
        $stmt = mysqli_prepare($con, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $subject, $message);
            
if (mysqli_stmt_execute($stmt)) {
    $success_message = "Thank you, $fullname, for contacting us. We will get back to you soon!";
    // Clear form data after successful submission
    $fullname = $email = $subject = $message = '';
} else {
    $error_message = "Sorry, there was an error sending your message. Please try again later.";
}

            
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Database error. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ICYM Karate-Do &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Oswald:400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="css/customBanner.css?v=<?php echo time(); ?>">
	
    
  
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/homepagestyle.css">
    
	<style>
.is-invalid {
    border-color: #dc3545;
}
.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 80%;
    margin-top: 0.25rem;
}
.timer {
    animation: expand 3s linear forwards;
}

@keyframes expand {
    from { width: 0; }
    to { width: 100%; }
}

.alert-success {
    position: relative;
    padding: 1rem;
    border-radius: 0.25rem;
    margin-bottom: 1rem;
}

#success-message.fade-out {
    transition: opacity 1s ease-out;
    opacity: 0;
}

</style>
  </head>
  
  <body>
  
    
  
  <div>


    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
	
<?php
require('header.php');
?>
    
<div class="container-fluid">
  <section class="custom-hero-section" aria-label="Gallery Hero Section">
    <div class="row">
      <div class="col-lg-12">
        <div class="custom-hero-image" role="img" aria-label="Karate background" data-stellar-background-ratio="0.5">
          <div class="custom-hero-contents text-center">
            <h2 class="custom-hero-title">Contact</h2>
            <nav aria-label="breadcrumb">
              <p>
                <a href="index.php" class="custom-breadcrumb-link">Home</a>
                <span class="mx-2">/</span> 
                <strong>Contact</strong>
              </p>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<body>
    <div class="site-section" style="background-color:white;">
        <div class="container p-5">
            <div class="row">
<div class="col-md-12 col-lg-7 mb-5">
    <?php if ($success_message): ?>
        <div id="success-message" class="alert alert-success">
            <?php echo $success_message; ?>
            <div id="countdown" style="display: inline; margin-left: 10px;"></div>
            <div class="timer" style="width: 100%; height: 5px; background: green; animation: expand 3s linear;"></div>
        </div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="contact-form">
        <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
                <label class="font-weight-bold" for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" class="form-control"
                    placeholder="Full Name" required
                    value="<?php echo isset($fullname) ? htmlspecialchars($fullname) : ''; ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <label class="font-weight-bold" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                    placeholder="Email Address" required
                    value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <label class="font-weight-bold" for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control"
                    placeholder="Enter Subject" required
                    value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <label class="font-weight-bold" for="message">Message</label>
                <textarea name="message" id="message" cols="30" rows="5" class="form-control"
                    placeholder="Say hello to us" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary py-2 px-4">Send Message</button>
            </div>
        </div>
    </form>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        var successMessage = document.getElementById('success-message');
        var countdownElement = document.getElementById('countdown');
        
        if (successMessage) {
            var countdown = 3; // countdown in seconds
            
            // Update the countdown every second
            var countdownInterval = setInterval(function() {
                countdownElement.innerText = countdown;
                countdown--;
                
                if (countdown < 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
            
            // Hide the success message after the countdown
            setTimeout(function() {
                successMessage.classList.add('fade-out');
            }, countdown * 1000);
            
            // Remove the success message from DOM after fade-out
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, (countdown + 1) * 1000);
        }
    });
</script>





<div class="col-lg-4 ml-auto">
    <div class="p-4 mb-3 bg-white">
        <h3 class="h5 text-black mb-3">Contact Info</h3>
        
        <?php
        require 'include/db_conn.php';

        // Start the session if it hasn't been started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize variables
        $contactAddress = '';
        $contactPhone = '';
        $contactEmail = '';

        // Retrieve existing data from the database
        $result = $con->query("SELECT contactAddress, contactPhone, contactEmail FROM ContactInfo WHERE contactinfoid = 1");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contactAddress = $row['contactAddress'];
            $contactPhone = $row['contactPhone'];
            $contactEmail = $row['contactEmail'];
        }

        // Check if admin is logged in
        if (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] === true): ?>
            <!-- Editable fields for admin -->
            <form action="dashboard/admin/update_contact_info.php" method="post">
                <p class="mb-0 font-weight-bold text-black">Address</p>
                <textarea class="form-control mb-4" name="contactAddress" id="contactAddress"><?php echo htmlspecialchars($contactAddress); ?></textarea>
                
                <p class="mb-0 font-weight-bold text-black">Phone</p>
                <input type="text" class="form-control mb-4" name="contactPhone" id="contactPhone" value="<?php echo htmlspecialchars($contactPhone); ?>">
                
                <p class="mb-0 font-weight-bold text-black">Email Address</p>
                <input type="email" class="form-control mb-0" name="contactEmail" id="contactEmail" value="<?php echo htmlspecialchars($contactEmail); ?>">
                
                <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
            </form>
        <?php else: ?>
            <!-- Static content for non-admins -->
            <p class="mb-0 font-weight-bold text-black">Address</p>
            <p class="mb-4 text-black" id="contactAddress"><?php echo htmlspecialchars($contactAddress); ?></p>
            
            <p class="mb-0 font-weight-bold text-black">Phone</p>
            <p class="mb-4"><a href="#" id="contactPhone"><?php echo htmlspecialchars($contactPhone); ?></a></p>
            
            <p class="mb-0 font-weight-bold text-black">Email Address</p>
            <p class="mb-0"><a href="#" id="contactEmail"><?php echo htmlspecialchars($contactEmail); ?></a></p>
        <?php endif; ?>
    </div>
</div>

            </div>
        </div>
    </div>
	
	    <?php
    // Close database connection
    mysqli_close($con);
    ?>


<?php
require('footer.html');
?>

  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>
<?php
require 'important_include.php';
?>