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

        // Query to calculate total revenue and fetch individual payments
        $query = "SELECT u.fullName, u.username, p.planName, p.amount, e.paid_date, e.expire, e.hasPaid
                  FROM enrolls_to e
                  JOIN users u ON e.userid = u.userid
                  JOIN plan p ON e.planid = p.planid
                  WHERE e.paid_date BETWEEN '$startDate' AND '$endDate' 
                  AND e.hasPaid = 'yes'";  // Only fetch successful payments

        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $totalRevenue = 0;

            // Table headers
            echo "<tr>
                    <th>User Name</th>
                    <th>Plan Name</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Expiry Date</th>
                  </tr>";

            // Fetch and display individual payments
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['fullName']} ({$row['username']})</td>
                        <td>{$row['planName']}</td>
                        <td>RM" . number_format($row['amount'], 2) . "</td>
                        <td>{$row['paid_date']}</td>
                        <td>{$row['expire']}</td>
                      </tr>";

                // Accumulate total revenue
                $totalRevenue += $row['amount'];
            }

            // Display total revenue for the selected month
            echo "<tr><th colspan='5'>Total Revenue for $month/$year</th></tr>";
            echo "<tr><td colspan='5'>RM" . number_format($totalRevenue, 2) . "</td></tr>";
        } else {
            echo "<tr><td colspan='5'>No payments found for this period.</td></tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Please select a valid month and year.</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>No data received.</td></tr>";
}
?>
