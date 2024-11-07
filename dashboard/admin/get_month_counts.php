<?php
// get_month_counts.php
require '../../include/db_conn.php';
page_protect();

if (isset($_GET['year'])) {
    $year = mysqli_real_escape_string($con, $_GET['year']);
    
    // Query to count members per month for the selected year
    $query = "SELECT 
                DATE_FORMAT(joining_date, '%m') as month,
                COUNT(*) as count
              FROM members 
              WHERE YEAR(joining_date) = ?
              GROUP BY month
              ORDER BY month";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $counts = [];
    while ($row = $result->fetch_assoc()) {
        $counts[$row['month']] = $row['count'];
    }
    
    // Make sure all months are represented
    for ($i = 1; $i <= 12; $i++) {
        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
        if (!isset($counts[$month])) {
            $counts[$month] = 0;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($counts);
} else {
    echo json_encode([]);
}
?>