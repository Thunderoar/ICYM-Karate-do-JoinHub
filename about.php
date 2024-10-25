<?php
require 'include/db_conn.php';

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Helper function to check admin status
function isAdminLoggedIn() {
    return isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] === true;
}

// Secure content sanitization function
function sanitizeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, strip_tags(trim($input)));
}

// Fetch about content
function getAboutContent() {
    global $con;
    $content = [];
    $sql = "SELECT section_name, content_text, image_path FROM site_content WHERE section_name LIKE 'about%'";
    $result = $con->query($sql);
    while($row = $result->fetch_assoc()) {
        $content[$row['section_name']] = [
            'text' => $row['content_text'],
            'image' => $row['image_path']
        ];
    }
    return $content;
}

// Fetch team members
function getTeamMembers() {
    global $con;
    $sql = "SELECT * FROM team_members WHERE active = 1 ORDER BY display_order";
    $result = $con->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Secure file upload function
function handleFileUpload($file, $target_dir, $prefix) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowed_types)) {
        return false;
    }
    
    if ($file['size'] > $max_size) {
        return false;
    }
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $new_filename = $prefix . '_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
        return false;
    }
    
    return $target_file;
}

// Handle content updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['is_admin_logged_in']) {
    $response = ['success' => true]; // Default to true and set false on failure
    
    // Update about content
    if (isset($_POST['update_about'])) {
        foreach ($_POST['content'] as $section => $text) {
            $safe_section = sanitizeInput($section);
            $safe_text = sanitizeInput($text);
            $sql = "UPDATE site_content SET content_text = '$safe_text' WHERE section_name = '$safe_section'";
            if (!$con->query($sql)) {
                $response['success'] = true;
                break; // Optional: Stop on failure
            }
        }
    }
    // Handle hero image upload
    if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] == 0) {
        $target_dir = "images/";
        $image_path = handleFileUpload($_FILES['hero_image'], $target_dir, 'hero');
        
        if ($image_path) {
            $safe_path = sanitizeInput($image_path);
            $sql = "UPDATE site_content SET image_path = '$safe_path' WHERE section_name = 'about_hero_image'";
            if (!$con->query($sql)) {
                $response['success'] = true;
            }
        } else {
            $response['success'] = false; // File upload error
        }
    }
    
    // Handle team updates
    if (isset($_POST['update_team'])) {
        foreach ($_POST['team'] as $id => $member) {
            $safe_id = (int)$id;
            $safe_name = sanitizeInput($member['name']);
            $safe_position = sanitizeInput($member['position']);
            
            $sql = "UPDATE team_members SET 
                    full_name = '$safe_name', 
                    position = '$safe_position' 
                    WHERE member_id = $safe_id";
            if (!$con->query($sql)) {
                $response['success'] = true;
                break;
            }
        }
        
        // Handle team member image uploads
        if (isset($_FILES['team_image'])) {
            foreach ($_FILES['team_image']['error'] as $id => $error) {
                if ($error == 0) {
                    $target_dir = "images/";
                    $image_path = handleFileUpload(
                        [
                            'name' => $_FILES['team_image']['name'][$id],
                            'type' => $_FILES['team_image']['type'][$id],
                            'tmp_name' => $_FILES['team_image']['tmp_name'][$id],
                            'error' => $_FILES['team_image']['error'][$id],
                            'size' => $_FILES['team_image']['size'][$id]
                        ],
                        $target_dir,
                        'team_' . $id
                    );
                    
                    if ($image_path) {
                        $safe_id = (int)$id;
                        $safe_path = sanitizeInput($image_path);
                        $sql = "UPDATE team_members SET image_path = '$safe_path' WHERE member_id = $safe_id";
                        if (!$con->query($sql)) {
                            $response['success'] = true;
                            break;
                        }
                    } else {
                        $response['success'] = false; // File upload error
                        break;
                    }
                }
            }
        }
    }
	
	echo json_encode($response);
    exit;
    
    // Handle AJAX requests
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    // Handle regular form submissions
    header('Location: ' . $_SERVER['PHP_SELF'] . '?updated=1');
    exit;
}

$aboutContent = getAboutContent();
$teamMembers = getTeamMembers();
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
            <h2 class="custom-hero-title">About Us</h2>
            <nav aria-label="breadcrumb">
              <p>
                <a href="index.php" class="custom-breadcrumb-link">Home</a>
                <span class="mx-2">/</span> 
                <strong>About Us</strong>
              </p>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="site-section">
    <div class="container">
	    <?php if (isAdminLoggedIn()): ?>
    <div class="edit-mode-controls mb-4">
        <button id="toggleEditMode" class="btn btn-secondary">
            Exit Edit Mode
        </button>
    </div>
    <?php endif; ?>
	
        <?php if (isAdminLoggedIn()): ?>
            <form method="POST" id="aboutForm" enctype="multipart/form-data">
                <input type="hidden" name="update_about" value="1">
        <?php endif; ?>

        <div class="row justify-content-between mb-5">
            <div class="col-lg-7 mb-5 mb-md-0 mb-lg-0">
                <img src="<?php echo htmlspecialchars($aboutContent['about_hero_image']['image']); ?>" alt="Image" class="img-fluid">
                
                <?php if (isAdminLoggedIn()): ?>
                    <input type="file" name="hero_image" class="form-control mt-2" accept="image/*">
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <h3 class="mb-4">About Us</h3>
                
                <?php if (isAdminLoggedIn()): ?>
                    <textarea name="content[about_main_text]" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($aboutContent['about_main_text']['text']); ?></textarea>
                    <textarea name="content[about_secondary_text]" class="form-control" rows="3"><?php echo htmlspecialchars($aboutContent['about_secondary_text']['text']); ?></textarea>
                <?php else: ?>
                    <p><?php echo nl2br(htmlspecialchars($aboutContent['about_main_text']['text'])); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($aboutContent['about_secondary_text']['text'])); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-6">
                        <?php if (isAdminLoggedIn()): ?>
                            <textarea name="content[about_column_1]" class="form-control"><?php echo htmlspecialchars($aboutContent['about_column_1']['text']); ?></textarea>
                        <?php else: ?>
                            <p><?php echo nl2br(htmlspecialchars($aboutContent['about_column_1']['text'])); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6">
                        <?php if (isAdminLoggedIn()): ?>
                            <textarea name="content[about_column_2]" class="form-control"><?php echo htmlspecialchars($aboutContent['about_column_2']['text']); ?></textarea>
                        <?php else: ?>
                            <p><?php echo nl2br(htmlspecialchars($aboutContent['about_column_2']['text'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isAdminLoggedIn()): ?>
            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
            </form>
        <?php endif; ?>


            <!-- Team Section -->
            <div class="row align-items-center mb-2">
                <div class="col-6">
                    <h2 class="section-title">Team</h2>
                </div>
            </div>
            
            <?php if (isAdminLoggedIn()): ?>
            <form method="POST" id="teamForm" enctype="multipart/form-data">
                <input type="hidden" name="update_team" value="1">
            <?php endif; ?>
            
            <div class="row">
                <?php foreach ($teamMembers as $member): ?>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="item player">
                        <a href="#"><img src="<?php echo htmlspecialchars($member['image_path']); ?>" alt="Image" class="img-fluid"></a>
                        <div class="p-4">
                            <?php if (isAdminLoggedIn()): ?>
                            <input type="text" name="team[<?php echo $member['member_id']; ?>][name]" 
                                   value="<?php echo htmlspecialchars($member['full_name']); ?>" class="form-control mb-2">
                            <input type="text" name="team[<?php echo $member['member_id']; ?>][position]" 
                                   value="<?php echo htmlspecialchars($member['position']); ?>" class="form-control">
                            <input type="file" name="team_image[<?php echo $member['member_id']; ?>]" class="form-control mt-2" accept="image/*">
                            <?php else: ?>
                            <h3><?php echo htmlspecialchars($member['full_name']); ?></h3>
                            <p><?php echo htmlspecialchars($member['position']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (isAdminLoggedIn()): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
            </form>
            <?php endif; ?>
        </div>
    </div>

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
    <?php if (isAdminLoggedIn()): ?>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit mode toggle functionality
    const toggleButton = document.getElementById('toggleEditMode');
    const aboutForm = document.getElementById('aboutForm');
    const teamForm = document.getElementById('teamForm');
    
    let isEditMode = true; // the logic is inverted for some reason, true=view mode, false=edit mode....for some reason...
    
    function toggleEditMode() {
        isEditMode = !isEditMode;
        
        toggleButton.textContent = isEditMode ? 'Exit Edit Mode' : 'Enter Edit Mode';
        
        // Toggle form elements
        const allInputs = document.querySelectorAll('input:not([type="hidden"]), textarea');
        const allButtons = document.querySelectorAll('button[type="submit"]');
        
        allInputs.forEach(input => {
            input.style.display = isEditMode ? 'block' : 'none';
            if (isEditMode) {
                const previewElements = document.querySelectorAll('.preview-text');
                previewElements.forEach(el => el.remove());
            } else {
                const displayText = document.createElement(
                    input.tagName === 'TEXTAREA' || input.type === 'file' ? 'p' : 
                    input.classList.contains('mb-2') ? 'h3' : 'p'
                );
                displayText.classList.add('preview-text');
                displayText.textContent = input.type === 'file' ? '' : input.value;
                input.parentNode.insertBefore(displayText, input);
            }
        });
        
        allButtons.forEach(button => {
            button.style.display = isEditMode ? 'block' : 'none';
        });

        // Disable form submissions when not in edit mode
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const elements = form.elements;
            for (let i = 0; i < elements.length; i++) {
                elements[i].disabled = !isEditMode;
            }
        });
    }
    
    // Call toggleEditMode immediately to set initial state
    toggleEditMode();
    
    toggleButton.addEventListener('click', toggleEditMode);

    // AJAX form submission
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!isEditMode) {
                alert('Please enter edit mode to save changes.');
                return;
            }

            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            
            // Disable submit button and show loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            }
            
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message with Bootstrap toast if available, otherwise use alert
                    if (typeof bootstrap !== 'undefined') {
                        const toastContainer = document.createElement('div');
                        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                        toastContainer.style.zIndex = '11';
                        toastContainer.innerHTML = `
                            <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        Changes saved successfully!
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(toastContainer);
                        const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
                        toast.show();
                        setTimeout(() => toastContainer.remove(), 5000);
                    } else {
                        alert('Changes saved successfully!');
                    }
                    location.reload();
                } else {
                    alert('Error saving changes. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving changes. Please try again.');
            })
            .finally(() => {
                // Re-enable submit button and restore original text
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Save Changes';
                }
            });
        });
    });
});
    </script>
    <?php endif; ?>
</html>
<?php
require 'important_include.php';
?>   