<?php
require 'include/db_conn.php';
// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_data']) || !isset($_SESSION['logged'])) {
} else {
    // If the user IS logged in, ensure the page is protected
    page_protect(); // Ensure this function exists
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ICYM Karate-Do &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
    
	<style>
.custom-coach-section .owl-carousel .item {
  display: none; /* Hide all items */
}

.custom-coach-section .owl-carousel .item:nth-of-type(1),
.custom-coach-section .owl-carousel .item:nth-of-type(2) {
  display: block; /* Show only the first two items */
}

.custom-coach-section .owl-carousel img {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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


    
<div>
  <div class="row">
    <div class="col-lg-12">
      <?php
        // Assuming we want to fetch the first image and details associated with a plan
        // Adjust the query to select the plan details and image from the database
        $sql = "SELECT p.planName, p.description, i.image_path 
                FROM plan p 
                INNER JOIN images i ON p.planid = i.planid 
                WHERE p.planid IS NOT NULL LIMIT 1"; // Fetch plan details along with an associated image
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
          // Fetch the result for the first plan
          $row = $result->fetch_assoc();
          $planName = $row['planName'];
          $description = $row['description'];
          $imagePath = htmlspecialchars($row['image_path']); // Safe way to echo the image path
          echo '<div class="hero-wrap" style="background-image: url(dashboard/admin/' . $imagePath . ');" data-stellar-background-ratio="0.5">';
        } else {
          echo "No plans found. Please create a New Plan with Images.";
        }
      ?>
        <div class="hero-contents">
          <h2><?php echo htmlspecialchars($planName); ?></h2>
          <p><?php echo htmlspecialchars($description); ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

    <div class="site-section">
      <div class="container">
        <div class="col-lg-8 ml-auto">
          <div class="row">
            <div class="col-md-6 col-lg-6 mb-5 mb-lg-0">
              <div class="custom-media d-flex">
                <div class="img-wrap mr-3">
                  <a href="#"><img src="images/image_1.jpg" alt="Image" class="img-fluid"></a>
                </div>
                <div>
                  <span class="caption">Latest News</span>
                  <h3><a href="#">Roman Greg scorer 4 goals</a></h3>
                  <p class="mb-0"><a href="#" class="more"><span class="mr-2">+</span>Learn More</a></p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 mb-5 mb-lg-0">
              <div class="custom-media d-flex">
                <div class="img-wrap mr-3">
                  <a href="#"><img src="images/image_2.jpg" alt="Image" class="img-fluid"></a>
                </div>
                <div>
                  <span class="caption">Team</span>
                  <h3><a href="#">Line for the upcoming match</a></h3>
                  <p class="mb-0"><a href="#" class="more"><span class="mr-2">+</span>Learn More</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="site-section custom-coach-section">
  <div class="container">
    <div class="row align-items-center mb-4">
      <div class="col-12 text-center">
        <h2 class="section-title">Our Coach</h2>
      </div>
      <div class="col-6 text-right">
        <a href="#" class="custom-prev js-custom-prev-v2">Prev</a>
        <span class="mx-2">/</span>
        <a href="#" class="custom-next js-custom-next-v2">Next</a>
      </div>
    </div>
    <div class="owl-4-slider owl-carousel">
      <div class="item player">
        <a href="#"><img src="images/coach_umayy.jpeg" alt="Image" class="img-fluid rounded shadow"></a>
        <div class="p-4">
          <h3>Cik Nur Umayyah Binti Mohamed Yusof</h3>
        </div>
      </div>
      <div class="item player">
        <a href="#"><img src="images/sensei_selvan.jpeg" alt="Image" class="img-fluid rounded shadow"></a>
        <div class="p-4">
          <h3>Sensei Tamil Selvan A/L Vengadesan</h3>
        </div>
      </div>
    </div>
  </div>
</div>




<?php

// Fetch images from the gallery_images table
$query = "SELECT image_path FROM gallery_images";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
?>
<div class="site-section" style="background-color: #f8f9fa; padding: 40px;">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title" style="font-size: 2.5rem; font-weight: bold; color: #343a40;">Gallery</h2>
            </div>
        </div>

        <div class="row">
        <?php
        // Loop through the fetched images
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = 'dashboard/admin/' . $row['image_path']; // Prepend the correct folder
        ?>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="<?php echo $imagePath; ?>" data-fancybox="gal">
                    <img src="<?php echo $imagePath; ?>" alt="Image" class="img-fluid rounded shadow">
                </a>
            </div>
        <?php
        }
        ?>
        </div>
    </div>
</div>
<?php
} else {
    echo "<p>No images found in the gallery.</p>";
}
?>



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
    <div class="container pb-0">
<div class="row mb-5">
      <div class="col-12 text-center">
        <h2 class="section-title">Events</h2>
      </div>

  
<?php
// Loop through the plans and display them
while ($plan = mysqli_fetch_assoc($result)):
  $planid = mysqli_real_escape_string($con, $plan['planid']);
  $image_query = "SELECT image_path FROM images WHERE planid = '$planid' LIMIT 1";
  $image_result = mysqli_query($con, $image_query);
  $image_path = ($image_result && mysqli_num_rows($image_result) > 0) ? 'dashboard/admin/' . mysqli_fetch_assoc($image_result)['image_path'] : 'images/default_plan_image.jpg';
?>
  <div class="col-sm-6 col-md-4 col-lg-3 mb-5">
    <div class="card">
      <img src="<?php echo $image_path; ?>" alt="Plan Image" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title"><?php echo $plan['planName']; ?></h5>
        <p class="card-text"><?php echo $plan['description']; ?></p>
      </div>
    </div>
  </div>

<?php endwhile; ?>

    </div>
  </div>

<?php else: ?>
  <p>No plans available at the moment.</p>
<?php endif; ?>

    
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
  <script>
  $(document).ready(function() {
  // Custom settings for this section
  $('.custom-coach-section .owl-carousel').owlCarousel({
    items: 1, // or the appropriate number of visible items
    loop: false, // Ensure no looping
    nav: true, // Navigation buttons
    dots: false, // Dots indicator
  });
  
  // Explicitly remove other items if any are dynamically added
  var items = $('.custom-coach-section .owl-carousel .item');
  items.slice(2).remove(); // Ensure only first two items remain
  </script>
</html>
<?php
require 'important_include.php';
?>   