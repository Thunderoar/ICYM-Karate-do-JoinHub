<?php
require '../../include/db_conn.php';
page_protect();

if (isset($_POST['name'])) {
    $planid = $_POST['name'];
    
    // Check if the plan exists and get image and slug information
    $sql = "SELECT i.image_path, pp.slug 
            FROM plan p 
            LEFT JOIN images i ON p.planid = i.planid 
            LEFT JOIN plan_pages pp ON p.planid = pp.planid 
            WHERE p.planid = '$planid'";
    $result = mysqli_query($con, $sql);
    
    // Store counts for reference
    $image_count = 0;
    $has_slug = false;
    while ($row = mysqli_fetch_array($result)) {
        if (!empty($row['image_path'])) $image_count++;
        if (!empty($row['slug'])) $has_slug = true;
    }
    
    // Update the plan to active
    $sql = "UPDATE plan SET active = 'yes' WHERE planid = '$planid'";
    
    if (mysqli_query($con, $sql)) {
        $message = "Plan has been activated successfully.";
        if ($image_count > 0) {
            $message .= " $image_count associated images are now visible.";
        }
        if ($has_slug) {
            $message .= " Plan page URL is now accessible.";
        }
        echo "<html><head><script>alert('$message');</script></head></html>";
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
    } else {
        echo "<html><head><script>alert('Error activating plan.');</script></head></html>";
        echo "error: " . mysqli_error($con);
    }
} else {
    echo "<html><head><script>alert('No plan ID provided.');</script></head></html>";
}

mysqli_close($con);
?>