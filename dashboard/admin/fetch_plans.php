<?php
require '../../include/db_conn.php';

if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];

    // Query to select the plans the user is enrolled in and has paid for
    $query = "
        SELECT p.planid, p.planName 
        FROM plan p
        JOIN enrolls_to e ON p.planid = e.planid
        WHERE e.userid = '$userID' 
        AND p.active = 'yes'
        AND e.hasPaid = 1";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<option value=''>-- Please select a plan --</option>";
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<option value='" . $row['planid'] . "'>" . $row['planName'] . "</option>";
        }
    } else {
        echo "<option value=''>No plans available for this user</option>";
    }
}
?>