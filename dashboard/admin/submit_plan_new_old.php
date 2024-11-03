<?php
require '../../include/db_conn.php';
page_protect();

function createPlanDirectory($con, $slug) {
    // Fetch plan details based on slug
    $plan_sql = "SELECT p.planName, p.description, p.planType, p.startDate, p.duration, p.validity, p.amount, 
                        pp.page_title, pp.page_content, pp.created_at
                 FROM plan p
                 JOIN plan_pages pp ON p.planid = pp.planid
                 WHERE pp.slug = '$slug'";
    $plan_result = mysqli_query($con, $plan_sql);
    $plan_data = mysqli_fetch_assoc($plan_result);

    // Fetch timetable data (assuming there is a record for this plan)
    $timetable_sql = "SELECT day1, day2, day3, day4, day5, day6 FROM timetable WHERE planid = '{$plan_data['planid']}' LIMIT 1";
    $timetable_result = mysqli_query($con, $timetable_sql);
    $timetable_data = mysqli_fetch_assoc($timetable_result);

    // Fetch the highlight image (if available) for the plan
    $image_sql = "SELECT image_path FROM gallery_images WHERE section_id = (SELECT section_id FROM gallery_sections WHERE section_name = 'Highlights') LIMIT 1";
    $image_result = mysqli_query($con, $image_sql);
    $image_data = mysqli_fetch_assoc($image_result);
    $highlight_image = $image_data['image_path'] ?? 'default_highlight.jpg'; // Use a default if no image is found

    // Directory and file setup
    $base_dir = "../../plans/";
    if (!is_dir($base_dir)) {
        mkdir($base_dir, 0777, true);
        $main_index_content = '<!DOCTYPE html><html lang="en"><head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sports Plans Directory</title>
            <meta name="robots" content="noindex, nofollow"></head><body>
            <h1>Sports Plans Directory</h1>
            <p>Select a plan to view more details.</p></body></html>';
        file_put_contents($base_dir . "index.html", $main_index_content);
    }

    // Create directory for this plan
    $plan_dir = $base_dir . $slug . "/";
    if (!is_dir($plan_dir)) {
        mkdir($plan_dir, 0777, true);

        // HTML Template with dynamic content replacement
        $index_content = '<!DOCTYPE html><html lang="en"><head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . htmlspecialchars($plan_data['planName']) . ' - Plan Details</title>
            <meta name="robots" content="noindex, nofollow">
            <style>
                body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; line-height: 1.6; }
                header { border-bottom: 1px solid #ccc; padding-bottom: 15px; margin-bottom: 20px; }
                .date, .author { color: #888; font-size: 0.9em; }
                .content-section { margin-bottom: 20px; }
                .content-section h2 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
                .edit-btn { display: ' . ($_SESSION['is_admin_logged_in'] ? 'block' : 'none') . '; margin-top: 10px; text-align: center; }
                .img-container { text-align: center; margin-top: 20px; }
                .img-container img { max-width: 100%; height: auto; }
            </style>
            </head><body>

            <header>
                <h1>' . htmlspecialchars($plan_data['planName']) . '</h1>
                <p class="date">Published on ' . date('F j, Y', strtotime($plan_data['created_at'])) . '</p>
                <p class="author">Plan Type: ' . htmlspecialchars($plan_data['planType']) . '</p>
            </header>

            <article>
                <section class="content-section">
                    <h2>Overview</h2>
                    <p>' . nl2br(htmlspecialchars($plan_data['description'])) . '</p>
                </section>
                
                <section class="content-section">
                    <h2>Details</h2>
                    <p>Duration: ' . htmlspecialchars($plan_data['duration']) . '</p>
                    <p>Validity: ' . htmlspecialchars($plan_data['validity']) . '</p>
                    <p>Amount: $' . htmlspecialchars($plan_data['amount']) . '</p>
                </section>

                <section class="content-section">
                    <h2>Schedule</h2>
                    <p>Monday: ' . htmlspecialchars($timetable_data['day1']) . '</p>
                    <p>Tuesday: ' . htmlspecialchars($timetable_data['day2']) . '</p>
                    <p>Wednesday: ' . htmlspecialchars($timetable_data['day3']) . '</p>
                    <!-- Continue for other days -->
                </section>
                
                <section class="img-container">
                    <h2>Highlights</h2>
                    <img src="../../images/' . htmlspecialchars($highlight_image) . '" alt="Plan Highlights">
                </section>

                <div class="edit-btn">
                    <button onclick="window.location.href=\'edit_plan.php?slug=' . $slug . '\'">Edit this Plan</button>
                </div>
            </article>
            
            </body></html>';
        
        // Write content to the new plan's index.html
        file_put_contents($plan_dir . "index.html", $index_content);

        // Create .htaccess for directory security
        $htaccess_content = "Options -Indexes\nDirectoryIndex index.html index.php";
        file_put_contents($plan_dir . ".htaccess", $htaccess_content);
    }

    // Close the database conection
    mysqli_close($con);
    return true;
}


function generateUniqueSlug($con, $name, $planid = null) {
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    $original_slug = $slug;
    $counter = 1;
    do {
        $exists = false;
        $check_query = $planid ? "SELECT COUNT(*) as count FROM plan_pages WHERE slug = '$slug' AND planid != '$planid'" : "SELECT COUNT(*) as count FROM plan_pages WHERE slug = '$slug'";
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
        // Retrieve form data
        $planid = mysqli_real_escape_string($con, $_POST['planid']);
        $name = mysqli_real_escape_string($con, $_POST['planname']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        $planType = mysqli_real_escape_string($con, $_POST['plantype']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $startDate = mysqli_real_escape_string($con, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($con, $_POST['endDate']);
        $duration = mysqli_real_escape_string($con, $_POST['duration']);
        $slug = generateUniqueSlug($con, $name);

        // Insert new plan data
        $query = "INSERT INTO plan (planid, planName, description, planType, startDate, endDate, duration, amount, active) 
                  VALUES ('$planid', '$name', '$desc', '$planType', '$startDate', '$endDate', '$duration', '$amount', 'yes')";
        if (!mysqli_query($con, $query)) {
            throw new Exception("Error inserting plan: " . mysqli_error($con));
        }

        // Insert plan page data
        $page_id = uniqid('page_', true);
        $page_query = "INSERT INTO plan_pages (page_id, planid, page_title, page_content, meta_description, slug, created_at) 
                       VALUES ('$page_id', '$planid', '$name', '$desc', '$desc', '$slug', NOW())";
        if (!mysqli_query($con, $page_query)) {
            throw new Exception("Error creating page: " . mysqli_error($con));
        }

        // Save uploaded image
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

        // Add timetable days
        if (!empty($_POST['days'])) {
            foreach ($_POST['days'] as $day) {
                $day = mysqli_real_escape_string($con, $day);
                $day_query = "INSERT INTO timetable (tid, planid, tname, hasApproved) 
                              VALUES (UUID(), '$planid', '$day', 'yes')";
                if (!mysqli_query($con, $day_query)) {
                    throw new Exception("Error adding timetable day: " . mysqli_error($con));
                }
            }
        }
		
        // Create plan directory
        if (!createPlanDirectory($con, $slug)) {
            throw new Exception("Error creating plan directory");
        }
        // Commit transaction
        mysqli_commit($con);
        echo "<script>alert('Plan, page, and timetable created successfully!');</script>";
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

?>
