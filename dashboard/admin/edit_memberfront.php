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
        $upload_dir = 'uploads/team_members/';
        $file_name = basename($_FILES['members']['name'][$index]['image_path']);
        $target_file = $upload_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type and size
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types) && $_FILES['members']['size'][$index]['image_path'] <= 2 * 1024 * 1024) {
            if (move_uploaded_file($_FILES['members']['tmp_name'][$index]['image_path'], $target_file)) {
                $image_path = $target_file;
            }
        }
    }

    // Update the team_members table
    $sql = "UPDATE team_members SET full_name = '$full_name', position = '$position'";
    if ($image_path) {
        $sql .= ", image_path = '$image_path'";
    }
    $sql .= " WHERE member_id = $member_id";

    mysqli_query($con, $sql);
}

echo "<script>alert('Member information updated successfully');</script>";
echo "<meta http-equiv='refresh' content='0; url=../../players.php'>";
?>