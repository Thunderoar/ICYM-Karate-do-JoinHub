<?php
require '../../include/db_conn.php';
page_protect();

$show_inactive = isset($_GET['show_inactive']) && $_GET['show_inactive'] === 'yes';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the plan ID from the form
    $planid = mysqli_real_escape_string($con, $_POST['planid']);

    // Check if plan ID is set
    if (isset($planid)) {
        // Prevent deletion of the plan with ID XTWIOL
        if ($planid === 'XTWIOL') {
            echo "The plan XTWIOL cannot be deleted.";
        } else {
            // Begin transaction
            mysqli_begin_transaction($con);

            try {
                // Delete from plan_page_sections
                $query1 = "DELETE FROM plan_page_sections WHERE page_id IN (SELECT page_id FROM plan_pages WHERE planid = '$planid')";
                mysqli_query($con, $query1);

                // Delete from plan_pages
                $query2 = "DELETE FROM plan_pages WHERE planid = '$planid'";
                mysqli_query($con, $query2);

                // Delete from timetable_days
                $query3 = "DELETE FROM timetable_days WHERE tid IN (SELECT tid FROM sports_timetable WHERE planid = '$planid')";
                mysqli_query($con, $query3);

                // Delete from sports_timetable
                $query4 = "DELETE FROM sports_timetable WHERE planid = '$planid'";
                mysqli_query($con, $query4);

                // Delete from plan
                $query5 = "DELETE FROM plan WHERE planid = '$planid'";
                mysqli_query($con, $query5);

                // Commit transaction
                mysqli_commit($con);

                echo "Plan and related data deleted successfully!";
                // Redirect to plans page after deletion
                header("Location: view_plan.php?show_inactive=" . ($show_inactive ? "yes" : "no"));
                exit();
            } catch (Exception $e) {
                // Rollback transaction on error
                mysqli_roll_back($con);
                echo "Error deleting plan and related data: " . $e->getMessage();
            }
        }
    } else {
        echo "No plan ID received!";
    }
} else {
    echo "Invalid request method!";
}

// Close database connection
mysqli_close($con);
?>
