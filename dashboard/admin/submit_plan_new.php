<?php
require '../../include/db_conn.php';
page_protect();

function createPlanDirectory($con, $slug) {
    try {
        // Use prepared statement to prevent SQL injection
        $plan_sql = "SELECT p.planid, p.planName, p.description, p.planType, p.startDate, 
                            p.duration, p.validity, p.amount,
                            pp.page_title, pp.page_content, pp.created_at,
                            pp.meta_description,
                            pps.section_title, pps.section_content
                     FROM plan p
                     JOIN plan_pages pp ON p.planid = pp.planid
                     LEFT JOIN plan_page_sections pps ON pp.page_id = pps.page_id
                     WHERE pp.slug = ? AND pp.published = 1";
                     
        $stmt = mysqli_prepare($con, $plan_sql);
        mysqli_stmt_bind_param($stmt, "s", $slug);
        mysqli_stmt_execute($stmt);
        $plan_result = mysqli_stmt_get_result($stmt);

        if (!$plan_result) {
            throw new Exception("Error fetching plan details: " . mysqli_error($con));
        }

        $plan_data = mysqli_fetch_assoc($plan_result);
        if (!$plan_data) {
            throw new Exception("No published plan found with slug: " . $slug);
        }

        // Fetch timetable data using prepared statement
        $timetable_sql = "SELECT st.tid, st.planid, st.tname, st.hasApproved,
                                td.day_number, td.activities,
                                s.name as staff_name, s.role as staff_role
                         FROM sports_timetable st
                         LEFT JOIN timetable_days td ON st.tid = td.tid
                         LEFT JOIN staff s ON st.staffid = s.staffid
                         WHERE st.planid = ? AND st.hasApproved = 1
                         ORDER BY td.day_number";

        $stmt = mysqli_prepare($con, $timetable_sql);
        mysqli_stmt_bind_param($stmt, "i", $plan_data['planid']);
        mysqli_stmt_execute($stmt);
        $timetable_result = mysqli_stmt_get_result($stmt);

        if (!$timetable_result) {
            throw new Exception("Error fetching timetable: " . mysqli_error($con));
        }

        // Process timetable data
        $timetable_days = [];
        $staff_info = [];
        while ($row = mysqli_fetch_assoc($timetable_result)) {
            if ($row['day_number']) {
                $timetable_days[$row['day_number']] = $row['activities'];
            }
            if ($row['staff_name']) {
                $staff_info[] = [
                    'name' => $row['staff_name'],
                    'role' => $row['staff_role']
                ];
            }
        }

        // Fetch images using prepared statement
        $image_sql = "SELECT i.image_path 
                     FROM images i 
                     WHERE i.planid = ? 
                     ORDER BY i.uploaded_at DESC 
                     LIMIT 1";

        $stmt = mysqli_prepare($con, $image_sql);
        mysqli_stmt_bind_param($stmt, "i", $plan_data['planid']);
        mysqli_stmt_execute($stmt);
        $image_result = mysqli_stmt_get_result($stmt);
        $image_data = mysqli_fetch_assoc($image_result);
        $plan_image = $image_data['image_path'] ?? 'default_plan.jpg';

$schedule_html = '
<section class="content-section" id="schedule-section">
    <h2>Schedule</h2>
    <div class="schedule-controls">
        <select id="dayFilter" class="schedule-filter">
            <option value="all">All Days</option>
            <option value="weekday">Weekdays</option>
            <option value="weekend">Weekends</option>
        </select>
    </div>
    
    <div class="schedule-grid">';

        // Directory and file setup with proper permissions
        $base_dir = "../../plans/";
        if (!is_dir($base_dir)) {
            if (!mkdir($base_dir, 0755, true)) {
                throw new Exception("Failed to create base directory");
            }
            
            // Create main index with proper security headers
            $main_index_content = '<!DOCTYPE html><html lang="en"><head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-Content-Type-Options" content="nosniff">
                <meta http-equiv="X-Frame-Options" content="DENY">
                <title>Sports Plans Directory</title>
                <meta name="robots" content="noindex, nofollow">
                </head><body>
                <h1>Sports Plans Directory</h1>
                <p>Select a plan to view details.</p>
                </body></html>';
            file_put_contents($base_dir . "index.html", $main_index_content);
        }

        // Create plan-specific directory
        $plan_dir = $base_dir . $slug . "/";
        if (!is_dir($plan_dir)) {
            if (!mkdir($plan_dir, 0755, true)) {
                throw new Exception("Failed to create plan directory");
            }

            // Enhanced HTML template with better styling and security
$index_content = '<!DOCTYPE html><html lang="en"><head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-Content-Type-Options" content="nosniff">
                <meta http-equiv="X-Frame-Options" content="DENY">
                <meta name="description" content="' . htmlspecialchars($plan_data['meta_description']) . '">
                <title>' . htmlspecialchars($plan_data['planName']) . ' - Plan Details</title>
                <meta name="robots" content="noindex, nofollow">
                <style>
                    :root {
                        --primary-color: #2c3e50;
                        --secondary-color: #34495e;
                        --accent-color: #3498db;
                        --text-color: #333;
                        --light-gray: #ecf0f1;
                    }
                    body { 
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, sans-serif;
                        margin: 0; 
                        line-height: 1.6;
                        color: var(--text-color);
                    }
                    .content-wrapper {
                        max-width: 1200px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    header.plan-header { 
                        background: var(--primary-color);
                        color: white;
                        padding: 2rem;
                        border-radius: 8px;
                        margin-bottom: 2rem;
                    }
                    .meta-info {
                        display: flex;
                        gap: 2rem;
                        flex-wrap: wrap;
                        margin: 1rem 0;
                    }
                    .meta-info > div {
                        background: var(--light-gray);
                        padding: 0.5rem 1rem;
                        border-radius: 4px;
                    }
                    .schedule-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                        gap: 1rem;
                        margin: 1rem 0;
                    }
                    .schedule-day {
                        background: var(--light-gray);
                        padding: 1rem;
                        border-radius: 8px;
                    }
                    .schedule-day h3 {
                        color: var(--primary-color);
                        margin-top: 0;
                    }
                    .content-section {
                        background: white;
                        padding: 2rem;
                        border-radius: 8px;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        margin-bottom: 2rem;
                    }
                    .img-container {
                        text-align: center;
                        margin: 2rem 0;
                    }
                    .img-container img {
                        max-width: 100%;
                        height: auto;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    }
                    .staff-section {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 1rem;
                        margin: 1rem 0;
                    }
                    .staff-card {
                        background: var(--light-gray);
                        padding: 1rem;
                        border-radius: 4px;
                        flex: 1 1 200px;
                    }
                    @media (max-width: 768px) {
                        .content-wrapper { padding: 10px; }
                        .meta-info { flex-direction: column; gap: 1rem; }
                    }

    .schedule-controls {
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .schedule-filter {
        padding: 8px 12px;
        border: 1px solid var(--accent-color);
        border-radius: 4px;
        background: white;
        color: var(--primary-color);
        cursor: pointer;
    }
    
    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .schedule-day {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    
    .schedule-day:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .schedule-day-header {
        background: var(--primary-color);
        color: white;
        padding: 15px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .schedule-day-header h3 {
        margin: 0;
        font-size: 1.2rem;
    }
    
    .day-indicator {
        background: rgba(255,255,255,0.2);
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
    }
    
    .activities {
        padding: 20px;
        min-height: 100px;
        white-space: pre-line;
        line-height: 1.6;
    }
    
    .schedule-footer {
        padding: 10px 20px;
        border-top: 1px solid #eee;
        color: var(--secondary-color);
        font-size: 0.9rem;
    }
    
    .time-indicator {
        display: inline-block;
        padding: 4px 8px;
        background: var(--light-gray);
        border-radius: 12px;
    }
    
    .schedule-placeholder {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        background: var(--light-gray);
        border-radius: 8px;
        color: var(--secondary-color);
    }
    
    @media (max-width: 768px) {
        .schedule-grid {
            grid-template-columns: 1fr;
        }
        
        .schedule-controls {
            flex-direction: column;
            align-items: stretch;
        }
    }

                </style>
				<script>
document.getElementById("dayFilter").addEventListener("change", function() {
    const filter = this.value;
    const days = document.querySelectorAll(".schedule-day");
    
    days.forEach(day => {
        if (filter === "all") {
            day.style.display = "block";
        } else {
            day.style.display = day.dataset.dayType === filter ? "block" : "none";
        }
    });
});

// Initialize tooltips
document.querySelectorAll(".schedule-day").forEach(day => {
    day.addEventListener("mouseover", function() {
        this.style.transform = "translateY(-2px)";
    });
    
    day.addEventListener("mouseout", function() {
        this.style.transform = "translateY(0)";
    });
});
</script>
                </head>
                <body>
                <?php include "../header.php"; ?>
                
                <div class="content-wrapper">
                    <header class="plan-header">
                        <h1>' . htmlspecialchars($plan_data['planName']) . '</h1>
                        <div class="meta-info">
                            <div style="background-color:black;">Published: ' . date('F j, Y', strtotime($plan_data['created_at'])) . '</div>
                            <div style="background-color:black;">Type: ' . htmlspecialchars($plan_data['planType']) . '</div>
                            <div style="background-color:black;">Duration: ' . htmlspecialchars($plan_data['duration']) . '</div>
                            <div style="background-color:black;">Price: $' . htmlspecialchars($plan_data['amount']) . '</div>
                        </div>
                    </header>

                    <main>
                        <section class="content-section">
                            <h2>Overview</h2>
                            ' . nl2br(htmlspecialchars($plan_data['description'])) . '
                        </section>

                        ' . $schedule_html;

            // Add staff section if available
            if (!empty($staff_info)) {
                $index_content .= '<section class="content-section">
                        <h2>Training Staff</h2>
                        <div class="staff-section">';
                foreach ($staff_info as $staff) {
                    $index_content .= sprintf(
                        '<div class="staff-card">
                            <h3>%s</h3>
                            <p>Role: %s</p>
                        </div>',
                        htmlspecialchars($staff['name']),
                        htmlspecialchars($staff['role'])
                    );
                }
                $index_content .= '</div></section>';
            }

            // Add plan sections if available
            if (!empty($plan_data['section_content'])) {
                $index_content .= sprintf(
                    '<section class="content-section">
                        <h2>%s</h2>
                        %s
                    </section>',
                    htmlspecialchars($plan_data['section_title']),
                    nl2br(htmlspecialchars($plan_data['section_content']))
                );
            }

            $index_content .= '<section class="img-container">
                        <img src="../../images/' . htmlspecialchars($plan_image) . '" 
                             alt="' . htmlspecialchars($plan_data['planName']) . ' Highlight">
                    </section>
                    </main>
                </div>
                </body></html>';

            // Write files with proper permissions
            if (!file_put_contents($plan_dir . "index.html", $index_content)) {
                throw new Exception("Failed to write index.html");
            }

            $htaccess_content = "Options -Indexes\nDirectoryIndex index.html index.php\n";
            if (!file_put_contents($plan_dir . ".htaccess", $htaccess_content)) {
                throw new Exception("Failed to write .htaccess");
            }
        }

        return true;

    } catch (Exception $e) {
        error_log("Error in createPlanDirectory: " . $e->getMessage());
        throw $e;
    } finally {
        if (isset($stmt)) {
            mysqli_stmt_close($stmt);
        }
    }
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

// Initialize the script and check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start transaction for atomic operations
    mysqli_begin_transaction($con);
    try {
        // Retrieve and sanitize form data for plan details
		$tid = mysqli_real_escape_string($con, $_POST['timetable_id']);
        $planid = mysqli_real_escape_string($con, $_POST['planid']);
        $name = mysqli_real_escape_string($con, $_POST['planname']);
        $desc = mysqli_real_escape_string($con, $_POST['desc']);
        $planType = mysqli_real_escape_string($con, $_POST['plantype']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $startDate = mysqli_real_escape_string($con, $_POST['startDate']);
        $endDate = mysqli_real_escape_string($con, $_POST['endDate']);
        $duration = mysqli_real_escape_string($con, $_POST['duration']);
        
        // Generate slug for the plan based on the name
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $name), '-'));

        // Insert the new plan into the `plan` table
        $insertPlan = "INSERT INTO plan (planid, tid, planName, description, planType, startDate, endDate, duration, amount, active) 
                       VALUES ('$planid', '$tid', '$name', '$desc', '$planType', '$startDate', '$endDate', '$duration', '$amount', 'yes')";
        
        if (!mysqli_query($con, $insertPlan)) {
            throw new Exception("Error creating plan: " . mysqli_error($con));
        }

// Get and sanitize data
$tid = mysqli_real_escape_string($con, $_POST['timetable_id']);
$tname = mysqli_real_escape_string($con, $_POST['planname']);
$hasApproved = isset($_POST['hasApproved']) ? 1 : 0;
$staffData = json_decode($_POST['selected_staff_data'], true);

if ($staffData && is_array($staffData)) {
    foreach ($staffData as $staff) {
        $staffId = mysqli_real_escape_string($con, $staff['staffid']);
        
        // Insert data into sports_timetable
        $insertTimetable = "INSERT INTO sports_timetable (tid, planid, staffid, tname, hasApproved) 
                           VALUES ('$tid', '$planid', '$staffId', '$tname', '$hasApproved')";
        
        if (!mysqli_query($con, $insertTimetable)) {
            echo "Error inserting timetable: " . mysqli_error($con);
        }
        
        // Insert data into event_staff
        $insertEventStaff = "INSERT INTO event_staff (es_id, planid, staffid, joined_at) 
                            VALUES (NULL, '$planid', '$staffId', NOW())";
        
        if (!mysqli_query($con, $insertEventStaff)) {
            echo "Error inserting event staff: " . mysqli_error($con);
        }
    }
}


        // Preemptively add days to `timetable_days` based on duration
        $numDays = (int)((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24)) + 1;
        for ($i = 1; $i <= $numDays; $i++) {
            $day_id = uniqid('day_', true);
            $insertDay = "INSERT INTO timetable_days (day_id, tid, day_number, activities) 
                          VALUES ('$day_id', '$tid', $i, NULL)";
            if (!mysqli_query($con, $insertDay)) {
                throw new Exception("Error adding day $i: " . mysqli_error($con));
            }
        }

        // Update `timetable_days` with specific activities if provided
        if (!empty($_POST['days'])) {
            foreach ($_POST['days'] as $index => $activities) {
                $day_number = $index + 1;
                $activities = mysqli_real_escape_string($con, $activities);
                
                $updateDay = "UPDATE timetable_days SET activities='$activities' 
                              WHERE tid='$tid' AND day_number='$day_number'";
                
                if (!mysqli_query($con, $updateDay)) {
                    throw new Exception("Error updating day $day_number: " . mysqli_error($con));
                }
            }
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


        // Insert the initial page for the plan
        $page_id = uniqid('page_', true);
        $current_time = date('Y-m-d H:i:s');
        
        $insertPage = "INSERT INTO plan_pages (page_id, planid, page_title, page_content, meta_description, slug, created_at, published) 
                       VALUES ('$page_id', '$planid', '$name', '$desc', '$desc', '$slug', '$current_time', 1)";
        
        if (!mysqli_query($con, $insertPage)) {
            throw new Exception("Error creating plan page: " . mysqli_error($con));
        }
        
        // Call function to create plan directory if it exists
        if (function_exists('createPlanDirectory')) {
            createPlanDirectory($con, $slug);
        }

        // Commit the transaction if everything is successful
        mysqli_commit($con);
        
        // Display success message
echo "<script>
        alert('Plan created successfully!');
        window.location.href = 'timetable_detail.php?id=" . $tid . "&planid=" . $planid . "#timetable-details';
      </script>";

        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        
        // Display error message
        echo "<script>
                alert('Error: " . mysqli_real_escape_string($con, $e->getMessage()) . "');
                window.location.href = 'new_plan.php';
              </script>";
    }
}
?>
uery($con, $insertPage)) {
            throw new Exception("Error creating plan page: " . mysqli_error($con));
        }
        
        // Call function to create plan directory if it exists
        if (function_exists('createPlanDirectory')) {
            createPlanDirectory($con, $slug);
        }

        // Commit the transaction if everything is successful
        mysqli_commit($con);
        
        // Display success message
echo "<script>
        alert('Plan created successfully!');
        window.location.href = 'timetable_detail.php?id=" . $tid . "&planid=" . $planid . "#timetable-details';
      </script>";

        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        
        // Display error message
        echo "<script>
                alert('Error: " . mysqli_real_escape_string($con, $e->getMessage()) . "');
                window.location.href = 'new_plan.php';
              </script>";
    }
}
?>
