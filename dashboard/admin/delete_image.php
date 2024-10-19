<?php
// Connect to database
require '../../include/db_conn.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['image_id'])) {
    $image_id = $data['image_id'];

    // Fetch image path
    $query = "SELECT image_path FROM gallery_images WHERE image_id = '$image_id'";
    $result = mysqli_query($con, $query);
    $image = mysqli_fetch_assoc($result);

    if ($image) {
        $image_path = 'dashboard/admin/' . $image['image_path'];

        // Delete image from database
        $delete_query = "DELETE FROM gallery_images WHERE image_id = '$image_id'";
        if (mysqli_query($con, $delete_query)) {
            // Delete image file from server
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Return success response
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete from database.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Image not found.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>
