<?php
include '../../include/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the `tid` and `action` from the POST request
    $tid = isset($_POST['tid']) ? mysqli_real_escape_string($con, $_POST['tid']) : '';  // Treat `tid` as a string
    $action = isset($_POST['action']) ? mysqli_real_escape_string($con, $_POST['action']) : '';

    // Debug: Print the values to see what is being passed
    echo "TID: $tid, Action: $action";

    // Validate that `tid` and `action` are provided and valid
    if (!empty($tid) && ($action == 'approve' || $action == 'reject')) {
        // Determine the approval status based on the action
        $hasApproved = ($action == 'approve') ? 'yes' : 'rejected';

        // Update the `hasApproved` column in the `sports_timetable` table
        $query = "UPDATE sports_timetable SET hasApproved = '$hasApproved' WHERE tid = '$tid'";
        
        // Execute the query and check if the update was successful
        if (mysqli_query($con, $query)) {
            echo "<html><head><script>alert('Routine status updated successfully!');</script></head></html>";
        } else {
            echo "<html><head><script>alert('Error updating status: " . mysqli_error($con) . "');</script></head></html>";
        }
    } else {
        echo "<html><head><script>alert('Invalid routine ID or action');</script></head></html>";
    }

    // Redirect back to the timetable page after the operation
    echo "<meta http-equiv='refresh' content='0; url=editroutine.php'>";
}
?>
<!-- comment -->