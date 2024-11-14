<?php

require '../include/db_conn.php';


$query = $_GET['query'];
$sql = "SELECT course_name FROM courses WHERE course_name LIKE '%$query%' LIMIT 10";
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
