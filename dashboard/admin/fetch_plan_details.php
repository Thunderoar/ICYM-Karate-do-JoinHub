<?php
// Include your database connection code here
require '../../include/db_conn.php';

if (isset($_GET['planid'])) {
  $planid = $_GET['planid'];

  $query = "SELECT * FROM plan WHERE planid = $planid";
  $result = mysqli_query($conn, $query);
  
  if ($result && mysqli_num_rows($result) > 0) {
    $plan = mysqli_fetch_assoc($result);
    echo json_encode($plan);
  } else {
    echo json_encode(array('error' => 'No plan found'));
  }
}
?>
