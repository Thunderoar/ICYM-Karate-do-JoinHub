<?php
// Include the database connection
require '../../include/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $section_id = $_POST['section_id'];
    $files = $_FILES['image'];

    // Loop through the uploaded images and save them to the server
    for ($i = 0; $i < count($files['name']); $i++) {
        $image_name = $files['name'][$i];
        $image_tmp = $files['tmp_name'][$i];
        $image_path = "uploads/" . basename($image_name);

        // Move the file to the uploads directory
        if (move_uploaded_file($image_tmp, $image_path)) {
            $query = "INSERT INTO gallery_images (section_id, image_path) VALUES ('$section_id', '$image_path')";
            if (!mysqli_query($con, $query)) {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Error uploading file.";
        }
    }

    // Redirect back to the index page after successful upload
    header("Location: ../../gallery.php");
    exit();
}
?>
