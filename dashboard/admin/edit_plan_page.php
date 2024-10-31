<?php
require '../../include/db_conn.php';
page_protect();

if (!isset($_SESSION['admin_type'])) {
    header('Location: login.php');
    exit();
}

$planid = isset($_GET['id']) ? mysqli_real_escape_string($con, $_GET['id']) : '';

// Get plan and page details
$query = "SELECT p.*, pp.* 
          FROM plan p 
          JOIN plan_pages pp ON p.planid = pp.planid 
          WHERE p.planid = '$planid'";

$result = mysqli_query($con, $query);
$plan = mysqli_fetch_assoc($result);

if (!$plan) {
    header('Location: 404.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $page_title = mysqli_real_escape_string($con, $_POST['page_title']);
    $page_content = mysqli_real_escape_string($con, $_POST['page_content']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    
    $update_query = "UPDATE plan_pages 
                     SET page_title = '$page_title', 
                         page_content = '$page_content', 
                         meta_description = '$meta_description' 
                     WHERE planid = '$planid'";
    
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Page updated successfully!');</script>";
        $plan['page_title'] = $page_title;
        $plan['page_content'] = $page_content;
        $plan['meta_description'] = $meta_description;
    } else {
        echo "<script>alert('Error updating page: " . mysqli_error($con) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do | Edit <?php echo htmlspecialchars($plan['planName']); ?></title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/dashMain.css">
    
    <!-- Include TinyMCE for rich text editing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.7/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#page_content',
            height: 500,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                     alignleft aligncenter alignright alignjustify | \
                     bullist numlist outdent indent | removeformat | help'
        });
    </script>
</head>
<body class="page-body page-fade" onload="collapseSidebar()">
    <div class="page-container sidebar-collapsed" id="navbarcollapse">
        <?php include('nav.php'); ?>

        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <h2>Edit: <?php echo htmlspecialchars($plan['planName']); ?></h2>
                    
                    <form method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label for="page_title">Page Title</label>
                            <input type="text" name="page_title" id="page_title" 
                                   class="form-control" 
                                   value="<?php echo htmlspecialchars($plan['page_title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" 
                                      class="form-control" rows="3"><?php echo htmlspecialchars($plan['meta_description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="page_content">Page Content</label>
                            <textarea name="page_content" id="page_content" 
                                      class="form-control"><?php echo htmlspecialchars($plan['page_content']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="a1-btn a1-blue">Save Changes</button>
                            <a href="view_plan_page.php?slug=<?php echo $plan['slug']; ?>" 
                               class="a1-btn a1-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <?php include('footer.php'); ?>
        </div>
    </div>
</body>
</html>