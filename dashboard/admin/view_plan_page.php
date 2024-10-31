<?php
require '../../include/db_conn.php';
page_protect();

// Get plan slug from URL and escape it
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($con, $_GET['slug']) : '';

// Get plan and page details
$query = "SELECT p.*, pp.*, i.image_path 
          FROM plan p 
          JOIN plan_pages pp ON p.planid = pp.planid 
          LEFT JOIN images i ON p.planid = i.planid 
          WHERE pp.slug = '$slug'";

$result = mysqli_query($con, $query);
$plan = mysqli_fetch_assoc($result);

if (!$plan) {
    header('Location: 404.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ICYM Karate-Do | <?php echo htmlspecialchars($plan['planName']); ?></title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/dashMain.css">
    <!-- Include your other CSS files -->
</head>
<body class="page-body page-fade" onload="collapseSidebar()">
    <div class="page-container sidebar-collapsed" id="navbarcollapse">
        <!-- Include your sidebar -->
        <?php include('nav.php'); ?>

        <div class="main-content">
            <!-- Header area -->
            <div class="row">
                <div class="col-md-12">
                    <h2><?php echo htmlspecialchars($plan['planName']); ?></h2>
                    
                    <?php if ($plan['image_path']): ?>
                    <div class="plan-image">
                        <img src="<?php echo htmlspecialchars($plan['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($plan['planName']); ?>" 
                             class="img-responsive">
                    </div>
                    <?php endif; ?>

                    <div class="plan-details">
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($plan['planType']); ?></p>
                        <p><strong>Duration:</strong> <?php echo htmlspecialchars($plan['duration']); ?> days</p>
                        <p><strong>Dates:</strong> <?php echo htmlspecialchars($plan['startDate']); ?> to <?php echo htmlspecialchars($plan['endDate']); ?></p>
                        <p><strong>Fee:</strong> $<?php echo htmlspecialchars($plan['amount']); ?></p>
                    </div>

                    <div class="plan-content">
                        <?php echo nl2br(htmlspecialchars($plan['page_content'])); ?>
                    </div>

                    <?php if (isset($_SESSION['admin_type'])): ?>
                    <div class="admin-controls">
                        <a href="edit_plan_page.php?id=<?php echo $plan['planid']; ?>" class="a1-btn a1-blue">Edit Page</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php include('footer.php'); ?>
        </div>
    </div>
</body>
</html>