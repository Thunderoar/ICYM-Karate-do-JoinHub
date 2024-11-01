<?php
require '../../include/db_conn.php';
page_protect();

function createPlanDirectory($slug) {
    $base_dir = "../../plans/";
    if (!is_dir($base_dir)) {
        mkdir($base_dir, 0777, true);
        $main_index_content = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Plans Directory</title>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
    <h1>Sports Plans Directory</h1>
    <p>Select a plan to view more details.</p>
</body>
</html>';
        file_put_contents($base_dir . "index.html", $main_index_content);
    }

    $plan_dir = $base_dir . $slug . "/";
    if (!is_dir($plan_dir)) {
        mkdir($plan_dir, 0777, true);
        
        // Blog-style layout for new plan
        $index_content = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Details</title>
    <meta name="robots" content="noindex, nofollow">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
        .article-content { margin-top: 20px; }
        .edit-btn { display: ' . ($_SESSION['is_admin_logged_in'] ? 'block' : 'none') . '; margin-top: 10px; }
    </style>
</head>
<body>
    <header>
        <h1>Plan: {PLAN_TITLE}</h1>
        <p><em>Posted on {CREATED_DATE}</em></p>
    </header>
    <article class="article-content">
        <p>{PLAN_DESCRIPTION}</p>
    </article>
    <div class="edit-btn">
        <button onclick="window.location.href=\'edit_plan.php?slug=' . $slug . '\'">Edit this Plan</button>
    </div>
</body>
</html>';

        // Replace placeholders with dynamic data in actual usage
        file_put_contents($plan_dir . "index.html", $index_content);
        
        // .htaccess for security
        $htaccess_content = "Options -Indexes\nDirectoryIndex index.html index.php";
        file_put_contents($plan_dir . ".htaccess", $htaccess_content);
    }
    return true;
}

// Unique slug generation function remains the same
function generateUniqueSlug($con, $name, $planid = null) {
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug); 
    $slug = trim($slug, '-'); 
    $original_slug = $slug;
    $counter = 1;

    do {
        $exists = false;
        $check_query = $planid ? "SELECT COUNT(*) as count FROM plan_pages WHERE slug = '$slug' AND planid != '$planid'" 
                               : "SELECT COUNT(*) as count FROM plan_pages WHERE slug = '$slug'";
        $result = mysqli_query($con, $check_query);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0) {
            $exists = true;
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
    } while ($exists);

    return $slug;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    mysqli_begin_transaction($con);
    try {
        $planid = mysqli_real_escape_string($con, $_POST['planid']);
        $name = mysqli_real_escape_string($con, $_POST['planname']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        $planType = mysqli_real_escape_string($con, $_POST['plantype']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $startDate = mysqli_real_escape_string($con, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($con, $_POST['endDate']);
        $duration = mysqli_real_escape_string($con, $_POST['duration']);

        $slug = generateUniqueSlug($con, $name);
        
        if (!createPlanDirectory($slug)) {
            throw new Exception("Error creating plan directory");
        }

        $query = "INSERT INTO plan (planid, planName, description, planType, startDate, endDate, duration, amount, active) 
                  VALUES ('$planid', '$name', '$desc', '$planType', '$startDate', '$endDate', '$duration', '$amount', 'yes')";
        if (!mysqli_query($con, $query)) {
            throw new Exception("Error inserting plan: " . mysqli_error($con));
        }

        $page_id = uniqid('page_', true);
        $page_query = "INSERT INTO plan_pages (page_id, planid, page_title, page_content, meta_description, slug, created_at) 
                       VALUES ('$page_id', '$planid', '$name', '$desc', '$desc', '$slug', NOW())";
        if (!mysqli_query($con, $page_query)) {
            throw new Exception("Error creating page: " . mysqli_error($con));
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $filename = uniqid() . '_' . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $target_file = mysqli_real_escape_string($con, $target_file);
                $sql = "INSERT INTO images (imageid, planid, image_path) VALUES (UUID(), '$planid', '$target_file')";
                if (!mysqli_query($con, $sql)) {
                    throw new Exception("Error saving image: " . mysqli_error($con));
                }
            }
        }

        mysqli_commit($con);
        echo "<script>alert('Plan and page created successfully!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";

    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
