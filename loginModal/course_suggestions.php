<?php

require '../include/db_conn.php';

// Fetch all course names for the dropdown
$sql = "SELECT course_name FROM courses";
$result = $con->query($sql);

$suggestions = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $suggestions[] = $row['course_name'];
  }
}

echo json_encode($suggestions);
$con->close();
?>
