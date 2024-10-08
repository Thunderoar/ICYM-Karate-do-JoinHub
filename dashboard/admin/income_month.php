<?php
require '../../include/db_conn.php';

// Check if the month and year are passed as GET parameters
if (isset($_GET['mm']) && isset($_GET['yy'])) {
    $month = $_GET['mm'];
    $year = $_GET['yy'];

    // Check if valid inputs are provided
    if ($month != "0" && $year != "0") {
        // Format the start and end date for the month
        $startDate = $year . '-' . $month . '-01';
        $endDate = date("Y-m-t", strtotime($startDate)); // Get last day of the month

        // Query to calculate total revenue for the given month and year
        $query = "SELECT SUM(p.amount) as total_revenue
                  FROM enrolls_to e
                  JOIN plan p ON e.planid = p.planid
                  WHERE e.paid_date BETWEEN '$startDate' AND '$endDate'";

        $result = mysqli_query($con, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalRevenue = $row['total_revenue'] ? $row['total_revenue'] : 0;

            // Output the result
            echo "<tr><th>Total Revenue for $month/$year</th></tr>";
            echo "<tr><td>RM" . number_format($totalRevenue, 2) . "</td></tr>";
        } else {
            echo "<tr><td>Error fetching data.</td></tr>";
        }
    } else {
        echo "<tr><td>Please select valid month and year.</td></tr>";
    }
} else {
    echo "<tr><td>No data received.</td></tr>";
}
?>