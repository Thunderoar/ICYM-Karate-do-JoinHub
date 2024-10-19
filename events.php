
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sports Team &mdash; Colorlib Website Template</title>
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
    
  
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/homepagestyle.css">
    
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
    
    <div>
      <div class="row">
        <div class="col-lg-12">
          <div class="hero-wrap text-center" style="background-image: url('images/karate_main.jpg');" data-stellar-background-ratio="0.5">
            <div class="hero-contents">
            <h2>Events</h2>
            <p><a href="index.php">Home</a> <span class="mx-2">/</span> <strong>Events</strong></p>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php
require 'include/db_conn.php';

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Fetch active plans from the database
$query = "SELECT * FROM plan WHERE active = 'yes'"; // Fetch only active plans
$result = mysqli_query($con, $query);

// Check if there are any plans available
if (mysqli_num_rows($result) > 0):
?>

  <div class="site-section">
    <div class="container site-section pb-0">
<div class="row mb-5">
  
<?php
// Loop through the plans and display them
while ($plan = mysqli_fetch_assoc($result)):
  // Sanitize and fetch the planid (as it is a string) to prevent SQL injection
  $planid = mysqli_real_escape_string($con, $plan['planid']);

  // Ensure $planid is properly set
  if (isset($planid)) {
      // Fetch image associated with the plan
      $image_query = "SELECT image_path FROM images WHERE planid = '$planid' LIMIT 1";
      $image_result = mysqli_query($con, $image_query);

      // Check if query was successful and if there's an image
      if ($image_result && mysqli_num_rows($image_result) > 0) {
          $image = mysqli_fetch_assoc($image_result);
          // Prepend the path to the image
          $image_path = 'dashboard/admin/' . $image['image_path'];
      } else {
          // Use default image if no image is found
          $image_path = 'images/default_plan_image.jpg';
      }
  } else {
      // Use default image if planid is not set
      $image_path = 'images/default_plan_image.jpg';
  }
?>
  <div class="col-sm-6 col-md-4 col-lg-3 mb-5 mb-lg-0">
    <div class="custom-media d-block">
      <div class="img-wrap mb-3">
        <a href="<?php echo $image_path; ?>" data-fancybox="gal">
          <img src="<?php echo $image_path; ?>" alt="Plan Image" class="img-fluid">
        </a>
      </div>
      <div>
        <span class="caption"><?php echo date('d F, Y', strtotime($plan['validity'])); ?></span>
        <h3><?php echo $plan['planName']; ?></h3>
        <p><?php echo $plan['description']; ?></p>
        <!-- <p><strong>Price: </strong> RM <?php echo $plan['amount']; ?></p> -->
      </div>
    </div>
  </div>
<?php endwhile; ?>

</div>
</div>
</div>
<?php
else:
  echo "<p>No plans available at the moment.</p>";
endif;

// Close the database connection
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