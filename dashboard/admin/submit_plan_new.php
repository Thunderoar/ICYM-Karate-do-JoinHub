<?php
require '../../include/db_conn.php';
page_protect();

// Function to create plan directories and files
function createPlanDirectory($slug) {
    // Base directory for all plans
    $base_dir = "../../plans/";
    
    // Create base directory if it doesn't exist
    if (!is_dir($base_dir)) {
        mkdir($base_dir, 0777, true);
        
        // Create main index.html in plans directory
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
    <p>Please select a specific plan to view details.</p>
</body>
</html>';
        file_put_contents($base_dir . "index.html", $main_index_content);
    }
    
    // Create plan-specific directory
    $plan_dir = $base_dir . $slug . "/";
    if (!is_dir($plan_dir)) {
        mkdir($plan_dir, 0777, true);
        
        // Create plan-specific index.html
        $index_content = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Details</title>
    <meta name="robots" content="noindex, nofollow">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .placeholder {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="placeholder">
        <h1>Plan Details Coming Soon</h1>
        <p>The complete details for this plan will be available here shortly.</p>
    </div>
</body>
</html>';
        file_put_contents($plan_dir . "index.html", $index_content);
        
        // Create .htaccess for security
        $htaccess_content = "Options -Indexes\nDirectoryIndex index.html index.php";
        file_put_contents($plan_dir . ".htaccess", $htaccess_content);
    }
    
    return true;
}

// Function to generate a unique slug (your existing function remains the same)
function generateUniqueSlug($con, $name, $planid = null) {
    // Initial slug creation - convert to lowercase, replace spaces with hyphens
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug); // Replace multiple hyphens with single hyphen
    $slug = trim($slug, '-'); // Trim hyphens from start and end
    
    // Check if slug exists in database
    $original_slug = $slug;
    $counter = 1;
    
    do {
        $exists = false;
        
        // If updating existing plan, exclude current plan from uniqueness check
        if ($planid) {
            $check_query = "SELECT COUNT(*) as count FROM plan_pages WHERE slug = '$slug' AND planid != '$planid'";
        } else {
            $check_query = "SELECT COUNT(*) as count FROM plan_pages WHERE slug = '$slug'";
        }
        
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
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Escape all incoming data
        $planid = mysqli_real_escape_string($con, $_POST['planid']);
        $name = mysqli_real_escape_string($con, $_POST['planname']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        $planType = mysqli_real_escape_string($con, $_POST['plantype']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $startDate = mysqli_real_escape_string($con, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($con, $_POST['endDate']);
        $duration = mysqli_real_escape_string($con, $_POST['duration']);

        // Create slug from plan name
        $slug = generateUniqueSlug($con, $name);
        
        // Create directory structure for the plan
        if (!createPlanDirectory($slug)) {
            throw new Exception("Error creating plan directory structure");
        }
        
        // Insert into plan table
        $query = "INSERT INTO plan (planid, planName, description, planType, startDate, endDate, duration, amount, active) 
                  VALUES ('$planid', '$name', '$desc', '$planType', '$startDate', '$endDate', '$duration', '$amount', 'yes')";
        
        if (!mysqli_query($con, $query)) {
            throw new Exception("Error inserting plan: " . mysqli_error($con));
        }

        // Create plan page
        $page_id = uniqid('page_', true);
        $page_query = "INSERT INTO plan_pages (page_id, planid, page_title, page_content, meta_description, slug, created_at) 
                   VALUES ('$page_id', '$planid', '$name', '$desc', '$desc', '$slug', NOW())";
        
        if (!mysqli_query($con, $page_query)) {
            throw new Exception("Error creating page: " . mysqli_error($con));
        }

        // Handle image upload
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

        // Commit transaction
        mysqli_commit($con);
        
        echo "<head><script>alert('Plan and page created successfully!');</script></head>";
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
        
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "<head><script>alert('Error: " . $e->getMessage() . "');</script></head>";
    }
}
?>