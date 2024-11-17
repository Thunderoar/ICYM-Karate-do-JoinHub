<?php
require '../../include/db_conn.php';
page_protect();

$msgid = $_POST['name'];

if (strlen($msgid) > 0) {
    // Prepare the database connection for secure queries
    $stmt_login = mysqli_prepare($con, "DELETE FROM login WHERE userid = ?");
    $stmt_users = mysqli_prepare($con, "DELETE FROM users WHERE userid = ?");
    
    if ($stmt_login && $stmt_users) {
        // Start transaction to ensure both operations succeed or both fail
        mysqli_begin_transaction($con);
        
        try {
            // Bind the userid parameter to both statements
            mysqli_stmt_bind_param($stmt_login, "s", $msgid);
            mysqli_stmt_bind_param($stmt_users, "s", $msgid);
            
            // Execute both deletions
            $login_success = mysqli_stmt_execute($stmt_login);
            $users_success = mysqli_stmt_execute($stmt_users);
            
            if ($login_success && $users_success) {
                // If both operations successful, commit the transaction
                mysqli_commit($con);
                echo "<html><head><script>alert('Member and login data deleted successfully');</script></head></html>";
                echo "<meta http-equiv='refresh' content='0; url=view_mem.php'>";
            } else {
                throw new Exception("Delete operation failed");
            }
        } catch (Exception $e) {
            // If any operation fails, rollback the transaction
            mysqli_rollback($con);
            echo "<html><head><script>alert('ERROR! Delete Operation Unsuccessful');</script></head></html>";
            echo "Error: " . mysqli_error($con);
        }
        
        // Close the prepared statements
        mysqli_stmt_close($stmt_login);
        mysqli_stmt_close($stmt_users);
    } else {
        echo "<html><head><script>alert('ERROR! Could not prepare database statements');</script></head></html>";
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "<html><head><script>alert('ERROR! Invalid user ID provided');</script></head></html>";
}
?>