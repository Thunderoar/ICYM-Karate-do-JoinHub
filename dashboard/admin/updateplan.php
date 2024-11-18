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

// Handle selected members data
if (isset($_POST['selected_members_data']) && !empty($_POST['selected_members_data'])) {
    $selectedMembers = json_decode($_POST['selected_members_data'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // Create array of selected user IDs
        $selectedUserIds = array_map(function($member) {
            return $member['userId'];
        }, $selectedMembers);
        
        // Convert array to comma-separated string for SQL
        $selectedUserIdsString = "'" . implode("','", array_map(function($id) use ($con) {
            return mysqli_real_escape_string($con, $id);
        }, $selectedUserIds)) . "'";
        
        // Delete entries for users who are no longer selected from event_members
        $deleteMembersQuery = "DELETE FROM event_members 
                              WHERE planid = '$planid' 
                              AND userid NOT IN ($selectedUserIdsString)";
        mysqli_query($con, $deleteMembersQuery);
        
        // Note: Skipping the deletion step for `enrolls_to` table
        
        // First, get existing event members entries
        $existingEventMembersQuery = "SELECT userid FROM event_members WHERE planid = '$planid'";
        $existingEventMembersResult = mysqli_query($con, $existingEventMembersQuery);
        $existingEventMembers = [];
        while ($row = mysqli_fetch_assoc($existingEventMembersResult)) {
            $existingEventMembers[] = $row['userid'];
        }

        // Process each selected member
        foreach ($selectedMembers as $member) {
            $userId = mysqli_real_escape_string($con, $member['userId']);
            
            // Insert or update event_members only if not existing
            if (!in_array($userId, $existingEventMembers)) {
                $insertMemberQuery = "INSERT INTO event_members (planid, userid, joined_at) 
                                    VALUES ('$planid', '$userId', NOW())
                                    ON DUPLICATE KEY UPDATE joined_at = NOW()";
                mysqli_query($con, $insertMemberQuery);
            }
            
            // Insert or update enrolls_to
            $insertEnrollQuery = "INSERT INTO enrolls_to 
                                (planid, userid, paid_date, hasPaid, hasApproved) 
                                VALUES ('$planid', '$userId', NOW(), 0, 0)
                                ON DUPLICATE KEY UPDATE paid_date = COALESCE(paid_date, NOW())";
            mysqli_query($con, $insertEnrollQuery);
        }
    } else {
        throw new Exception("Invalid JSON in selected members data");
    }
}



if (isset($_POST['selected_staff_data']) && !empty($_POST['selected_staff_data'])) {
    $selectedStaff = json_decode($_POST['selected_staff_data'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // Create array of selected staff IDs
        $selectedStaffIds = array_map(function($staff) {
            return $staff['staffid'];
        }, $selectedStaff);
        
        $selectedStaffIdsString = "'" . implode("','", array_map(function($id) use ($con) {
            return mysqli_real_escape_string($con, $id);
        }, $selectedStaffIds)) . "'";
        
        // Delete entries for staff who are no longer selected
        $deleteStaffQuery = "DELETE FROM event_staff 
                            WHERE planid = '$planid' 
                            AND staffid NOT IN ($selectedStaffIdsString)";
        mysqli_query($con, $deleteStaffQuery);

        // First, get existing event staff entries
        $existingEventStaffQuery = "SELECT staffid FROM event_staff WHERE planid = '$planid'";
        $existingEventStaffResult = mysqli_query($con, $existingEventStaffQuery);
        $existingEventStaff = [];
        while ($row = mysqli_fetch_assoc($existingEventStaffResult)) {
            $existingEventStaff[] = $row['staffid'];
        }

        // Get existing timetable entries
        $existingTimetableQuery = "SELECT tid, staffid, tname FROM sports_timetable WHERE planid = '$planid'";
        $existingTimetableResult = mysqli_query($con, $existingTimetableQuery);
        $existingTimetables = [];
        while ($row = mysqli_fetch_assoc($existingTimetableResult)) {
            $existingTimetables[$row['staffid']] = $row;
        }

        // Process each selected staff member
        foreach ($selectedStaff as $staff) {
            $staffid = mysqli_real_escape_string($con, $staff['staffid']);
            
            // Insert or update event_staff only if not existing
            if (!in_array($staffid, $existingEventStaff)) {
                $insertStaffQuery = "INSERT INTO event_staff (planid, staffid, joined_at) 
                                    VALUES ('$planid', '$staffid', NOW())
                                    ON DUPLICATE KEY UPDATE joined_at = NOW()";
                mysqli_query($con, $insertStaffQuery);
            }
            
            // Check if staff exists in sports_timetable
            if (isset($existingTimetables[$staffid])) {
                // Update existing timetable entry
                $existingTid = $existingTimetables[$staffid]['tid'];
                
                $updateTimetableQuery = "UPDATE sports_timetable 
                                       SET hasApproved = COALESCE(hasApproved, 0), tid = '$existingTid'
                                       WHERE planid = '$planid' 
                                       AND staffid = '$staffid' 
                                       AND tid = '$existingTid'";
                mysqli_query($con, $updateTimetableQuery);
            } else {
                // Generate a random tid
                $randomTid = rand(100000, 999999);
                // Insert new timetable entry
                $insertTimetableQuery = "INSERT INTO sports_timetable 
                                       (planid, staffid, tid, hasApproved, tname) 
                                       VALUES ('$planid', '$staffid', '$randomTid', 0, 'New Schedule')";
                mysqli_query($con, $insertTimetableQuery);
            }
        }
        
        // Now handle removals
        if (!empty($selectedStaffIdsString)) {
            $updateRemovedQuery = "UPDATE sports_timetable 
                                 SET hasApproved = 0 
                                 WHERE planid = '$planid' 
                                 AND staffid NOT IN ($selectedStaffIdsString)";
            mysqli_query($con, $updateRemovedQuery);
        }
    } else {
        throw new Exception("Invalid JSON in selected staff data");
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
