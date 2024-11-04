<?php
require '../../include/db_conn.php';
page_protect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate required IDs
        if (!isset($_POST['planid']) || empty($_POST['planid'])) {
            throw new Exception("Plan ID is required");
        }
        if (!isset($_POST['tid']) || empty($_POST['tid'])) {
            throw new Exception("Timetable ID is required");
        }

        // Sanitize the IDs
        $planid = mysqli_real_escape_string($con, $_POST['planid']);
        $tid = mysqli_real_escape_string($con, $_POST['tid']);

        // Verify the plan and timetable relationship
        $check_query = "SELECT st.tid, p.planid FROM sports_timetable st INNER JOIN plan p ON st.planid = p.planid WHERE st.tid = '$tid' AND p.planid = '$planid'";
        $result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($result) == 0) {
            throw new Exception("Invalid plan and timetable combination");
        }

        // Sanitize all input data
        $planname = isset($_POST['planname']) ? mysqli_real_escape_string($con, $_POST['planname']) : null;
        $desc = isset($_POST['desc']) ? mysqli_real_escape_string($con, $_POST['desc']) : null;
        $plantype = isset($_POST['plantype']) ? mysqli_real_escape_string($con, $_POST['plantype']) : null;
        $startdate = isset($_POST['startDate']) ? mysqli_real_escape_string($con, $_POST['startDate']) : null;
        $enddate = isset($_POST['endDate']) ? mysqli_real_escape_string($con, $_POST['endDate']) : null;
        $duration = isset($_POST['duration']) ? mysqli_real_escape_string($con, $_POST['duration']) : null;
        $amount = isset($_POST['amount']) ? mysqli_real_escape_string($con, $_POST['amount']) : null;

        // Build update query dynamically based on provided fields
        $updateFields = [];
        if ($planname !== null) $updateFields[] = "planName = '$planname'";
        if ($desc !== null) $updateFields[] = "description = '$desc'";
        if ($plantype !== null) $updateFields[] = "planType = '$plantype'";
        if ($startdate !== null) $updateFields[] = "startDate = '$startdate'";
        if ($enddate !== null) $updateFields[] = "endDate = '$enddate'";
        if ($duration !== null) $updateFields[] = "duration = '$duration'";
        if ($amount !== null) $updateFields[] = "amount = $amount";

        if (!empty($updateFields)) {
            $update_query = "UPDATE plan SET " . implode(", ", $updateFields) . " WHERE planid = '$planid'";
            
            if (!mysqli_query($con, $update_query)) {
                throw new Exception("Failed to update plan: " . mysqli_error($con));
            }
        }



        // Handle image upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            
            if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and GIF are allowed.");
            }
            
            $uploadDir = "../../uploads/plans/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Check if image record exists
                $check_image = "SELECT imageid FROM images WHERE planid = ?";
                $stmt = mysqli_prepare($con, $check_image);
                mysqli_stmt_bind_param($stmt, "i", $planid);
                mysqli_stmt_execute($stmt);
                $image_result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($image_result) > 0) {
                    // Update existing image
                    $update_image = "UPDATE images SET image_path = ?, uploaded_at = NOW() WHERE planid = ?";
                    $stmt = mysqli_prepare($con, $update_image);
                    mysqli_stmt_bind_param($stmt, "si", $targetPath, $planid);
                } else {
                    // Insert new image
                    $insert_image = "INSERT INTO images (planid, image_path, uploaded_at) VALUES (?, ?, NOW())";
                    $stmt = mysqli_prepare($con, $insert_image);
                    mysqli_stmt_bind_param($stmt, "is", $planid, $targetPath);
                }
                mysqli_stmt_execute($stmt);
            }
        }
		
        // Success message with both IDs
        echo "<html><head><script>alert('Plan (ID: $planid) and Timetable (ID: $tid) updated successfully!');</script></head></html>";
        // Redirect to view_plan.php
        echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";

    } catch (Exception $e) {
        echo "<html><head><script>alert('Error: " . addslashes($e->getMessage()) . "');</script></head></html>";
        echo "<meta http-equiv='refresh' content='2; url=view_plan.php'>";
    }
} else {
    echo "<html><head><script>alert('Invalid request method');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
}
?>