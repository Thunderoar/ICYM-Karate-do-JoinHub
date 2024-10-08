<?php
require '../../include/db_conn.php';

$month = $_GET['mm'];
$year = $_GET['yy'];
$flag = $_GET['flag'];

// Prepare the SQL query based on the flag
if ($flag == 0) {
    // Fetching data for the specific month
    $query = "SELECT u.userid, u.username, u.mobile, u.gender, a.state, a.city, u.dob, u.joining_date, p.amount 
              FROM enrolls_to et 
              INNER JOIN users u ON et.userid = u.userid 
              INNER JOIN address a ON u.userid = a.addressid 
              INNER JOIN plan p ON et.planid = p.planid 
              WHERE et.paid_date LIKE '$year-$month%'";
} else if ($flag == 1) {
    // Fetching data for the entire year
    $query = "SELECT u.userid, u.username, u.mobile, u.gender, a.state, a.city, u.dob, u.joining_date, p.amount 
              FROM enrolls_to et 
              INNER JOIN users u ON et.userid = u.userid 
              INNER JOIN address a ON u.userid = a.addressid 
              INNER JOIN plan p ON et.planid = p.planid 
              WHERE et.paid_date LIKE '$year%'";
}

// Execute the query
$res = mysqli_query($con, $query);

$sno = 1;

if (mysqli_num_rows($res) > 0) {
    // Output table body
    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $sno . "</td>";
        echo "<td>" . $row['userid'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['mobile'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['state'] . "</td>";
        echo "<td>" . $row['city'] . "</td>";
        echo "<td>" . $row['dob'] . "</td>";
        echo "<td>" . $row['joining_date'] . "</td>";
        echo "<td>RM" . $row['amount'] . "</td>"; // Displaying the amount
        echo "</tr>";

        $sno++;
    }
} else {
    // No data found message
    echo "<tr><td colspan='10'>No data found for " . date("F", mktime(0, 0, 0, $month, 10)) . " $year</td></tr>";
}
?>
