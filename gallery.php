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

<?php
if (isset($_POST['delete_section_id'])) {
    $section_id_to_delete = $_POST['delete_section_id'];

    // Use prepared statements to prevent SQL injection
    // First, delete the images related to this section
    $delete_images_query = "DELETE FROM gallery_images WHERE section_id = ?";
    if ($stmt = mysqli_prepare($con, $delete_images_query)) {
        mysqli_stmt_bind_param($stmt, 'i', $section_id_to_delete); // 'i' is for integer
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing delete images query: " . mysqli_error($con);
        exit;
    }

    // Now, delete the section
    $delete_section_query = "DELETE FROM gallery_sections WHERE section_id = ?";
    if ($stmt = mysqli_prepare($con, $delete_section_query)) {
        mysqli_stmt_bind_param($stmt, 'i', $section_id_to_delete);
        if (mysqli_stmt_execute($stmt)) {
            echo "Section deleted successfully!";
        } else {
            echo "Error deleting section: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing delete section query: " . mysqli_error($con);
    }
}
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
	<link rel="stylesheet" href="css/customBanner.css?v=<?php echo time(); ?>">
    
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
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%; /* Ensure it stretches across the full width */
}

.button-container {
    display: flex;
    gap: 10px; /* Space between the buttons */
}

.add-image-btn {
    flex-grow: 0; /* Prevents it from expanding */
}

.delete-section-btn {
    flex-grow: 0; /* Prevents it from expanding */
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
    
<div class="row">
    <?php
    // Fetch sections from the database
    $query = "SELECT * FROM gallery_sections";
    $sections_result = mysqli_query($con, $query);

    while ($section = mysqli_fetch_assoc($sections_result)) {
        echo "<div class='col-12 col-md-4 mb-4 position-relative'>"; // Added position-relative to section container
        echo "<div class='section-header mb-2 d-flex justify-content-between align-items-center'>"; // Using flexbox for buttons alignment

        // Section title
        echo "<h3 class='d-inline-block'>{$section['section_name']}</h3>";

        // Flex container for buttons
        echo "<div class='button-container d-flex gap-2'>";
        
        // Add image button aligned to the left
        echo "<button class='btn btn-primary add-image-btn' data-section-id='{$section['section_id']}'>+</button>";

        // Delete section button aligned to the right
        echo "<button class='btn btn-danger delete-section-btn' data-section-id='{$section['section_id']}'>Delete</button>";
        
        echo "</div>"; // Close button container

        echo "</div>"; // Close section header

        // Section description
        echo "<p>{$section['section_description']}</p>";

        // Fetch images for this section
        $section_id = $section['section_id'];
        $images_query = "SELECT * FROM gallery_images WHERE section_id = '$section_id'";
        $images_result = mysqli_query($con, $images_query);

        echo "<div class='row'>";

        // Display images if they exist
        while ($image = mysqli_fetch_assoc($images_result)) {
            $image_path = 'dashboard/admin/' . $image['image_path']; // Prepending the correct path to the image

            echo "<div class='col-6 col-sm-6 col-md-4 col-lg-3 mb-4'>";
            echo "<div class='image-container d-flex position-relative'>";

            // Display image
            echo "<a href='{$image_path}' data-fancybox='gal' class='flex-grow-1'>
                    <img src='{$image_path}' alt='Image' class='img-fluid rounded shadow'>
                  </a>";

            // Delete button for every image
            echo "<button class='btn btn-danger btn-sm delete-image-btn position-absolute' style='top: 10px; right: 10px;' data-image-id='{$image['image_id']}'>Delete</button>";

            echo "</div>";
            echo "</div>";
        }

        echo "</div>"; // Closing row for images

        echo "</div>"; // Closing column for section

        // Add a horizontal rule divider between sections
        echo "<hr class='my-4'>"; // Adds space around the divider
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

document.addEventListener("DOMContentLoaded", function() {
    // Attach click event listener to all delete buttons
    document.querySelectorAll('.delete-image-btn').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            
            if (confirm("Are you sure you want to delete this image?")) {
                // Send request to server to delete image
                fetch('dashboard/admin/delete_image.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ image_id: imageId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the image element from the page
                        this.closest('.col-6').remove();
                    } else {
                        alert("Failed to delete the image.");
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});

    $(document).ready(function() {
        // Delete section AJAX
        $('.delete-section-btn').click(function() {
            var section_id = $(this).data('section-id');
            
            if (confirm('Are you sure you want to delete this section?')) {
                $.ajax({
                    type: 'POST',
                    url: 'your_php_file.php', // Replace with the correct PHP file path
                    data: { delete_section_id: section_id },
                    success: function(response) {
                        alert(response);
                        location.reload(); // Refresh the page to reflect the changes
                    },
                    error: function() {
                        alert('An error occurred while deleting the section.');
                    }
                });
            }
        });
    });

  </script>
  
  </body>
</html>
<?php
require 'important_include.php';
?>
