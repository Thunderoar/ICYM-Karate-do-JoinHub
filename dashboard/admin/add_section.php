<?php
// Include the database connection
require '../../include/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $section_name = mysqli_real_escape_string($con, $_POST['section_name']);
    $section_description = mysqli_real_escape_string($con, $_POST['section_description']);

    $query = "INSERT INTO gallery_sections (section_name, section_description) VALUES ('$section_name', '$section_description')";
    if (mysqli_query($con, $query)) {
        echo "New section added successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
