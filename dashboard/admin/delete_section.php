<?php
require '../../include/db_conn.php';

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['delete_section_id'])) {
    $section_id_to_delete = $_POST['delete_section_id'];

    // Delete related rows in gallery_images first
    $delete_images_query = "DELETE FROM gallery_images WHERE section_id = $section_id_to_delete";
    mysqli_query($con, $delete_images_query);

    // Now delete the section
    $delete_section_query = "DELETE FROM gallery_sections WHERE section_id = $section_id_to_delete";
    if (mysqli_query($con, $delete_section_query)) {
        echo "Section deleted successfully!";
    } else {
        echo "Error deleting section: " . mysqli_error($con);
    }
}

// Close the connection
$con->close();
?>
