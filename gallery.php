<?php
require 'include/db_conn.php';
page_protect();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sports Team &mdash; Colorlib Website Template</title>
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
    
    <!-- Add custom CSS to align button to the right -->
    <style>
.add-section-container {
    display: flex !important;
    justify-content: flex-end !important;
    margin-bottom: 20px !important;
}
.image-container {
    position: relative !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
}

.add-image-btn {
    width: 50px !important;
    height: 50px !important;
    font-size: 2rem !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    padding: 0 !important;
    border-radius: 50% !important;  /* Ensure it’s circular */
    background-color: rgba(0, 123, 255, 0.7) !important;
    position: absolute !important;
    top: 50% !important;  /* Vertically center the button */
    right: -10px !important; /* Push button slightly to the right of the image */
    transform: translateY(-50%) !important; /* Align button properly */
}

.add-image-btn:hover {
    background-color: #218838 !important;
}

/* Image styles */
.image-container .img-fluid {
    width: 150% !important;
    height: auto !important;
    max-height: 400px !important;
}

.image-container a {
    flex-grow: 1 !important;
}


.btn-primary {
    background-color: rgba(0, 123, 255, 0.7) !important; /* Optional: make the button slightly transparent */
    border: none !important;
}

  .custom-hero-section {
    background-color: #fff;
    padding: 20px 0;
  }

  /* Customizing the hero image and contents */
  .custom-hero-image {
    background-image: url('images/karate_main.jpg');
    background-size: cover;
    background-position: center;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    overflow: hidden;
  }

  .custom-hero-contents {
    padding-top: 80px;
  }

  .custom-hero-title {
    font-size: 2.5rem;
    color: #fff; /* White text */
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7); /* Drop shadow for readability */
    margin: 0;
  }

  /* Breadcrumb link styling */
  .custom-breadcrumb-link {
    color: #fff !important; /* White text for breadcrumb */
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7); /* Drop shadow for breadcrumb link */
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background to stand out */
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none !important;
    font-weight: bold;
    transition: background-color 0.3s ease-in-out;
  }

  .custom-breadcrumb-link:hover {
    background-color: rgba(0, 0, 0, 0.7); /* Darker background on hover */
    text-decoration: underline;
  }

  .custom-breadcrumb-text {
    color: #fff; /* White text for the "Gallery" */
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7); /* Drop shadow for "Gallery" */
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .custom-hero-title {
      font-size: 2rem !important;
    }

    .custom-hero-contents {
      padding-top: 50px !important;
    }
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
            <h2 class="custom-hero-title">Gallery</h2>
            <nav aria-label="breadcrumb">
              <p>
                <a href="index.php" class="custom-breadcrumb-link">Home</a>
                <span class="mx-2">/</span> 
                <strong>Gallery</strong>
              </p>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

    <!-- Button to trigger the form -->
    <div class="add-section-container">
      <button id="addSectionBtn" class="btn btn-info mb-4">Add New Section</button>
    </div>

<!-- Modal for adding a new section -->
<div class="modal fade" id="newSectionModal" tabindex="-1" aria-labelledby="newSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSectionModalLabel">Add New Section to Gallery</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="dashboard/admin/add_section.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="section_name">Section Name</label>
                        <input type="text" class="form-control" id="section_name" name="section_name" required>
                    </div>
                    <div class="form-group">
                        <label for="section_description">Section Description</label>
                        <textarea class="form-control" id="section_description" name="section_description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Section</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for uploading images -->
<div class="modal fade" id="imageUploadModal" tabindex="-1" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageUploadModalLabel">Add Images to Section</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="dashboard/admin/upload_images.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="section_id">Select Section</label>
                        <select class="form-control" id="section_id" name="section_id">
                            <?php
                            require 'include/db_conn.php';
                            $query = "SELECT * FROM gallery_sections";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['section_id']}'>{$row['section_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Select Image</label>
                        <input type="file" class="form-control" id="image" name="image[]" multiple required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload Images</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
<!-- Display Gallery Sections dynamically from database -->
<div class="row">
    <?php
    // Fetch sections from the database
    $query = "SELECT * FROM gallery_sections";
    $sections_result = mysqli_query($con, $query);

    while ($section = mysqli_fetch_assoc($sections_result)) {
        echo "<div class='col-12 col-md-4 mb-4'>";
        echo "<h3>{$section['section_name']}</h3>";
        echo "<p>{$section['section_description']}</p>";

        // Fetch images for this section
        $section_id = $section['section_id'];
        $images_query = "SELECT * FROM gallery_images WHERE section_id = '$section_id'";
        $images_result = mysqli_query($con, $images_query);

        $image_count = mysqli_num_rows($images_result);
        $image_index = 0;

        echo "<div class='row'>";

        while ($image = mysqli_fetch_assoc($images_result)) {
            $image_path = 'dashboard/admin/' . $image['image_path']; // Prepending the correct path to the image
            $is_rightmost = $image_index + 1 == $image_count; // Mark last image in row
            
            echo "<div class='col-6 col-sm-6 col-md-4 col-lg-3 mb-4'>";
            echo "<div class='image-container d-flex'>";
            echo "<a href='{$image_path}' data-fancybox='gal' class='flex-grow-1'>
                    <img src='{$image_path}' alt='Image' class='img-fluid rounded shadow'>
                  </a>";
            if ($is_rightmost) {
                echo "<button class='btn btn-primary add-image-btn' data-section-id='{$section['section_id']}' data-image-id='{$image['image_id']}'>+</button>";
            }
            echo "</div>";
            echo "</div>";
            
            $image_index++;
        }

        echo "</div></div>";
    }
    ?>
</div>


    <?php
    require('footer.html');
    ?>
  

  </div>

  <!-- Include JS scripts -->
  <script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

  <script>
  const addSectionBtn = document.getElementById('addSectionBtn');
  const formContainer = document.getElementById('formContainer');

// Button to trigger the form for adding a new section
document.getElementById('addSectionBtn').addEventListener('click', function() {
    // Hide the image upload form if visible
    $('#imageUploadModal').modal('hide');
    
    // Show the new section modal
    $('#newSectionModal').modal('show');
});

// Button to trigger the form for adding images to a section
document.querySelectorAll('.add-image-btn').forEach(button => {
    button.addEventListener('click', function() {
        const sectionId = this.getAttribute('data-section-id');

        // Set the section ID in the image upload form
        document.getElementById('section_id').value = sectionId;

        // Hide the new section form if visible
        $('#newSectionModal').modal('hide');
        
        // Show the image upload modal
        $('#imageUploadModal').modal('show');
    });
});

document.querySelector('.close').addEventListener('click', function() {
    $('#newSectionModal').modal('hide');
    $('#imageUploadModal').modal('hide');
});
  </script>
  
  </body>
</html>
<?php
require 'important_include.php';
?>
