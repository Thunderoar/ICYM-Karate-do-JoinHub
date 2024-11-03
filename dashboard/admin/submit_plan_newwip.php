<?php
require '../../include/db_conn.php';
page_protect();

function createPlanDirectory($con, $slug) {
// Fetch plan details based on slug
$plan_sql = "SELECT p.planid, p.planName, p.description, p.planType, p.startDate, p.duration, p.validity, p.amount, 
                    pp.page_title, pp.page_content, pp.created_at
             FROM plan p
             JOIN plan_pages pp ON p.planid = pp.planid
             WHERE pp.slug = '" . mysqli_real_escape_string($con, $slug) . "'";
$plan_result = mysqli_query($con, $plan_sql);

if (!$plan_result) {
    throw new Exception("Error fetching plan details: " . mysqli_error($con));
}

$plan_data = mysqli_fetch_assoc($plan_result);

if (!$plan_data) {
    throw new Exception("No plan found with slug: " . $slug);
}

// Now fetch timetable data only if we have a valid plan
$timetable_sql = "SELECT t.tid, t.planid, t.tname, t.hasApproved, 
                         td.day_number, td.activities
                  FROM sports_timetable t
                  LEFT JOIN timetable_days td ON t.tid = td.timetable_id
                  WHERE t.planid = '" . mysqli_real_escape_string($con, $plan_data['planid']) . "'
                  ORDER BY td.day_number";
                  
$timetable_result = mysqli_query($con, $timetable_sql);
if (!$timetable_result) {
    throw new Exception("Error fetching timetable: " . mysqli_error($con));
}

$timetable_days = [];
while ($row = mysqli_fetch_assoc($timetable_result)) {
    $timetable_days[$row['day_number']] = $row['activities'];
}


    // Process schedule data into HTML
    $schedule_html = '<section class="content-section"><h2>Schedule</h2>';
    if (!empty($timetable_days)) {
        foreach ($timetable_days as $day_number => $activities) {
            $day_name = date("l", strtotime("Sunday +{$day_number} days"));
            $schedule_html .= '<p>' . htmlspecialchars($day_name) . ': ' . htmlspecialchars($activities) . '</p>';
        }
    } else {
        $schedule_html .= '<p>No schedule available</p>';
    }
    $schedule_html .= '</section>';

    // Fetch the highlight image (if available) for the plan
    $image_sql = "SELECT image_path FROM gallery_images WHERE section_id = (SELECT section_id FROM gallery_sections WHERE section_name = 'Highlights') LIMIT 1";
    $image_result = mysqli_query($con, $image_sql);
    $image_data = mysqli_fetch_assoc($image_result);
    $highlight_image = $image_data['image_path'] ?? 'default_highlight.jpg';

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

                ' . $schedule_html . '
                
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

    // Close the database connection
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
        // Get and sanitize form data
        $planid = mysqli_real_escape_string($con, $_POST['planid']);
        $name = mysqli_real_escape_string($con, $_POST['planname']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        $planType = mysqli_real_escape_string($con, $_POST['plantype']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $startDate = mysqli_real_escape_string($con, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($con, $_POST['endDate']);
        $duration = mysqli_real_escape_string($con, $_POST['duration']);
        $tname = mysqli_real_escape_string($con, $_POST['tname']);
        $hasApproved = isset($_POST['hasApproved']) ? 1 : 0;

        // Generate slug for the plan
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $name), '-'));

        // Insert into plan table
        $insertPlan = "INSERT INTO plan (planid, planName, description, planType, startDate, endDate, duration, amount, active) 
                       VALUES ('$planid', '$name', '$desc', '$planType', '$startDate', '$endDate', '$duration', '$amount', 'yes')";
        
        if (!mysqli_query($con, $insertPlan)) {
            throw new Exception("Error creating plan: " . mysqli_error($con));
        }

        // Insert timetable
        $insertTimetable = "INSERT INTO sports_timetable (tid, planid, tname, hasApproved) 
                           VALUES (UUID(), '$planid', '$tname', $hasApproved)";
        
        if (!mysqli_query($con, $insertTimetable)) {
            throw new Exception("Error creating timetable: " . mysqli_error($con));
        }

        // Get the tid of the inserted timetable
        $getTid = "SELECT tid FROM sports_timetable WHERE planid = '$planid'";
        $tidResult = mysqli_query($con, $getTid);
        
        if (!$tidResult) {
            throw new Exception("Error getting timetable ID: " . mysqli_error($con));
        }
        
        $tidRow = mysqli_fetch_assoc($tidResult);
        $tid = $tidRow['tid'];

        // Handle days input
        if (!empty($_POST['days'])) {
            foreach ($_POST['days'] as $index => $activities) {
                $day_number = $index + 1;
                $activities = mysqli_real_escape_string($con, $activities);
                $day_id = uniqid('day_', true);
                
                $insertDay = "INSERT INTO timetable_days (day_id, timetable_id, day_number, activities) 
                             VALUES ('$day_id', '$tid', $day_number, '$activities')";
                
                if (!mysqli_query($con, $insertDay)) {
                    throw new Exception("Error adding day $day_number: " . mysqli_error($con));
                }
            }
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = "../../uploads/plans/";
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid('plan_', true) . '.' . $file_extension;
            $target_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $relative_path = 'uploads/plans/' . $new_filename;
                $relative_path = mysqli_real_escape_string($con, $relative_path);
                
                $insertImage = "INSERT INTO images (imageid, planid, image_path) 
                               VALUES (UUID(), '$planid', '$relative_path')";
                
                if (!mysqli_query($con, $insertImage)) {
                    throw new Exception("Error saving image: " . mysqli_error($con));
                }
            } else {
                throw new Exception("Error uploading image");
            }
        }

        // Create plan page
        $page_id = uniqid('page_', true);
        $current_time = date('Y-m-d H:i:s');
        
        $insertPage = "INSERT INTO plan_pages (page_id, planid, page_title, page_content, meta_description, slug, created_at, published) 
                       VALUES ('$page_id', '$planid', '$name', '$desc', '$desc', '$slug', '$current_time', 1)";
        
        if (!mysqli_query($con, $insertPage)) {
            throw new Exception("Error creating plan page: " . mysqli_error($con));
        }

        mysqli_commit($con);
        
        echo "<script>
                alert('Plan created successfully!');
                window.location.href = 'view_plan.php';
              </script>";
        
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo "<script>
                alert('Error: " . mysqli_real_escape_string($con, $e->getMessage()) . "');
                window.location.href = 'new_plan.php';
              </script>";
    }
}
?>