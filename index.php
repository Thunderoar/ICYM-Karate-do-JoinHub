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

    .section-title {
      font-size: 1.5rem !important;
      font-weight: bold !important;
      margin-bottom: 1rem !important;
      text-align: center !important;
      color: #000 !important;
    }
    
    .container {
      max-width: 1200px !important;
      margin: 0 auto !important;
      padding: 0 0.5rem !important;
    }
    
    .grid {
      display: grid !important;
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 1rem !important;
      padding: 0.5rem !important;
      justify-items: center !important;
      align-items: center !important;
    }
    
    @media (max-width: 600px) {
      .grid {
        grid-template-columns: 1fr !important;
      }
    }
    
    .coach-card {
      background: #fff !important;
      border-radius: 0.25rem !important;
      overflow: hidden !important;
      text-align: center !important;
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      justify-content: center !important;
      width: 100% !important;
      max-width: 300px !important;
    }
    
    .coach-card img {
      object-fit: cover !important;
      border-radius: 0.25rem !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
      display: block !important;
      margin: 0 auto !important;
    }
    
    .coach-card h3 {
      font-size: 0.9rem !important;
      margin: 0.5rem 0 !important;
      padding: 0 0.5rem !important;
      color: #333 !important;
      font-weight: 500 !important;
      text-align: center !important;
    }
    
    .mb-8 {
      margin-bottom: 1rem !important;
    }
    
    .p-4 {
      padding: 0.5rem !important;
    }
	        .site-section {
            background-color: #f8f9fa;
            padding: 40px;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 2rem;
        }
        
        .gallery-item {
            position: relative;
            width: 100%;
            margin-bottom: 24px;
        }
        
        .image-container {
            position: relative;
            width: 100%;
            padding-bottom: 100%; /* Creates a square aspect ratio */
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .gallery-item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Makes images cover the square container */
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
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


    
<div id="event-slideshow" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php
      $sql = "SELECT p.planid, p.planName, p.description, i.image_path
              FROM plan p 
              INNER JOIN images i ON p.planid = i.planid 
              WHERE p.planid IS NOT NULL";
      $result = $con->query($sql);
      $isActive = true;

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $planName = $row['planName'];
          $description = $row['description'];
          $imagePath = htmlspecialchars($row['image_path']);
          $activeClass = $isActive ? 'active' : '';
          $isActive = false;

          echo '<div class="carousel-item ' . $activeClass . '">';
          echo '<div class="hero-wrap" style="background-image: url(dashboard/admin/' . $imagePath . ');" data-stellar-background-ratio="0.5">';
          echo '<div class="hero-contents">';
          echo '<h2>' . htmlspecialchars($planName) . '</h2>';
          echo '<p>' . htmlspecialchars($description) . '</p>';
          echo '</div></div></div>';
        }
      } else {
        echo "No plans found. Please create a New Plan with Images.";
      }
    ?>
  </div>

  <!-- Previous Button -->
  <a class="carousel-control-prev" href="#event-slideshow" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>

  <!-- Next Button -->
  <a class="carousel-control-next" href="#event-slideshow" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>



  <div class="site-section custom-coach-section">
    <div class="container">
      <div class="mb-8">
        <h2 class="section-title">Our Coach</h2>
      </div>
      
      <div class="grid">
        <div class="coach-card">
          <img src="images/coach_umayy.jpeg" alt="Coach Umayyah">
          <div class="p-4">
            <h3>Cik Nur Umayyah Binti Mohamed Yusof</h3>
          </div>
        </div>
        
        <div class="coach-card">
          <img src="images/sensei_selvan.jpeg" alt="Sensei Tamil Selvan">
          <div class="p-4">
            <h3>Sensei Tamil Selvan A/L Vengadesan</h3>
          </div>
        </div>
      </div>
    </div>
  </div>



<?php
require 'include/db_conn.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Update query to include slug from plan_pages
$query = "SELECT p.*, pp.slug, pp.page_title 
          FROM plan p 
          LEFT JOIN plan_pages pp ON p.planid = pp.planid 
          WHERE p.active = 'yes' LIMIT 8";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0):
?>
<div class="site-section">
    <div class="container pb-0">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title">Events</h2>
            </div>

            <?php
            while ($plan = mysqli_fetch_assoc($result)):
                $planid = mysqli_real_escape_string($con, $plan['planid']);

                // Fetch plan images
                $image_query = "SELECT image_path FROM images WHERE planid = '$planid' LIMIT 1";
                $image_result = mysqli_query($con, $image_query);
                $image_path = ($image_result && mysqli_num_rows($image_result) > 0) 
                    ? 'dashboard/admin/' . mysqli_fetch_assoc($image_result)['image_path'] 
                    : 'images/default_plan_image.jpg';
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-5">
                <div class="card h-100">
                    <img src="<?php echo $image_path; ?>" alt="Plan Image" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $plan['planName']; ?></h5>
                        <p class="card-text flex-grow-1"><?php echo substr($plan['description'], 0, 100) . '...'; ?></p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <!--<span class="text-primary">RM<?php //echo number_format($plan['amount'], 2); ?></span> -->
                                <?php if ($plan['slug']): ?>
                                    <a href="plans/<?php echo $plan['slug']; ?>" class="btn btn-primary">Read More...</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled>Coming Soon</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php else: ?>
    <p>No plans available at the moment.</p>
<?php endif; ?>

<?php

// Fetch images from the gallery_images table
$query = "SELECT image_path FROM gallery_images LIMIT 10";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
?>
<div class="site-section" style="background-color: #f8f9fa; padding: 40px;">
    <div class="text-center mb-4">
        <h2 class="section-title" style="font-size: 2.5rem; font-weight: bold; color: #343a40;">Gallery</h2>
    </div>

    <!-- Inner container to center the gallery content -->
    <div class="">
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