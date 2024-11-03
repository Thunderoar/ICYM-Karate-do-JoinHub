<?php
session_start();
include '../../include/db_conn.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 'start' || $_SESSION['authority'] != 'admin') {
    echo "<script>alert('Unauthorized access');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    exit;
}

// Loop through each member's data and update the database
foreach ($_POST['members'] as $index => $member) {
    $member_id = intval($member['member_id']);
    $full_name = mysqli_real_escape_string($con, trim($member['full_name']));
    $position = mysqli_real_escape_string($con, trim($member['position']));
    $image_path = null;

    // Check if a new image was uploaded for this member
    if (isset($_FILES['members']['name'][$index]['image_path']) && $_FILES['members']['error'][$index]['image_path'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/uploads/team_members/'; // Absolute path for uploads directory
        $file_name = basename($_FILES['members']['name'][$index]['image_path']);
        $target_file = $upload_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Create the directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Validate file type and size
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types) && $_FILES['members']['size'][$index]['image_path'] <= 2 * 1024 * 1024) {
            // Move uploaded file and check for errors
            if (move_uploaded_file($_FILES['members']['tmp_name'][$index]['image_path'], $target_file)) {
                $image_path = 'uploads/team_members/' . $file_name; // Relative path to save in database
            } else {
                error_log("Error: Failed to move uploaded file. Temp file: " . $_FILES['members']['tmp_name'][$index]['image_path']);
            }
        } else {
            error_log("Error: Invalid file type or file size too large for member ID: $member_id");
        }
    } else {
        error_log("Error: No file uploaded or upload error for member ID: $member_id");
    }

    // Update the team_members table
    $sql = "UPDATE team_members SET full_name = '$full_name', position = '$position'";
    if ($image_path) {
        $sql .= ", image_path = '$image_path'";
    }
    $sql .= " WHERE member_id = $member_id";

    if (mysqli_query($con, $sql)) {
        error_log("Member ID $member_id updated successfully.");
    } else {
        error_log("Error updating member ID $member_id: " . mysqli_error($con));
    }
}

echo "<script>alert('Member information updated successfully');</script>";
echo "<meta http-equiv='refresh' content='0; url=../../players.php'>";
?>
