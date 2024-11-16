<?php
require '../../include/db_conn.php';
page_protect();

$mm = $_GET['mm'];
$yy = $_GET['yy'];

$query = "
    SELECT 
        u.userid,
        u.username,
        u.fullName,
        COALESCE(u.mobile, '') as mobile,
        COALESCE(u.email, '') as email,
        COALESCE(u.gender, '') as gender,
        COALESCE(u.dob, '') as dob,
        u.joining_date,
        COALESCE(a.state, '') as state,
        COALESCE(a.city, '') as city,
        GROUP_CONCAT(DISTINCT COALESCE(p.planName, '')) as plans
    FROM users u
    LEFT JOIN address a ON u.userid = a.userid
    LEFT JOIN enrolls_to e ON u.userid = e.userid
    LEFT JOIN plan p ON e.planid = p.planid
    WHERE MONTH(u.joining_date) = ? 
    AND YEAR(u.joining_date) = ?
    GROUP BY u.userid
    ORDER BY u.joining_date DESC
";

try {
    $stmt = $con->prepare($query);
    $stmt->bind_param('ss', $mm, $yy);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sl = 1;
        while ($row = $result->fetch_assoc()) {
            // Function to safely display values
if (!function_exists('safe_display')) {
    function safe_display($value) {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('safe_date')) {
    function safe_date($date) {
        return $date ? date('d-m-Y', strtotime($date)) : '';
    }
}


            echo "<tr>";
            echo "<td>" . $sl . "</td>";
            echo "<td>" . safe_display($row['userid']) . "</td>";
            echo "<td>" . safe_display($row['fullName']) . "</td>";
            
            // Contact information
            $contact_info = [];
            if (!empty($row['mobile'])) $contact_info[] = safe_display($row['mobile']);
            if (!empty($row['email'])) $contact_info[] = safe_display($row['email']);
            echo "<td>" . implode("<br>", $contact_info) . "</td>";
            
            echo "<td>" . safe_display($row['gender']) . "</td>";
            echo "<td>" . safe_display($row['state']) . "</td>";
            echo "<td>" . safe_display($row['city']) . "</td>";
            echo "<td>" . safe_date($row['dob']) . "</td>";
            echo "<td>" . safe_date($row['joining_date']) . "</td>";
            echo "<td>" . (empty($row['plans']) ? 'No plans enrolled' : safe_display($row['plans'])) . "</td>";
            echo "</tr>";
            $sl++;
        }
    } else {
        echo "<tr><td colspan='10' class='text-center'>No members joined during this period.</td></tr>";
    }
} catch (Exception $e) {
    echo "<tr><td colspan='10' class='text-center'>Error retrieving data. Please try again.</td></tr>";
}

$stmt->close();
$con->close();
?>