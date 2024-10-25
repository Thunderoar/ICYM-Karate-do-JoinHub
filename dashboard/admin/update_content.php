<?php
require '../../include/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $section = $_POST['section'];
  $content = $_POST['content'];

  // Determine if the update is for text or an image based on the section
  if (strpos($section, 'text') !== false) {
    $query = "UPDATE site_content SET content_text = ?, last_updated = NOW() WHERE section_name = ?";
  } else {
    $query = "UPDATE site_content SET image_path = ?, last_updated = NOW() WHERE section_name = ?";
  }

  // Prepare and execute the query
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'ss', $content, $section);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo 'success';
  } else {
    echo 'error';
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>
