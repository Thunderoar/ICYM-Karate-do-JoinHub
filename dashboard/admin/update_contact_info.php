<?php
require '../../include/db_conn.php';

// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the admin is logged in
if (isset($_SESSION['is_admin_logged_in']) && $_SESSION['is_admin_logged_in'] === true) {

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize user input
        $contactAddress = $con->real_escape_string($_POST['contactAddress']);
        $contactPhone = $con->real_escape_string($_POST['contactPhone']);
        $contactEmail = $con->real_escape_string($_POST['contactEmail']);

        // Check if there is already an entry in the table
        $result = $con->query("SELECT * FROM ContactInfo WHERE contactinfoid = 1");
        
        if ($result->num_rows > 0) {
            // Entry exists, update it
            $sql = "UPDATE ContactInfo SET 
                    contactAddress = '$contactAddress', 
                    contactPhone = '$contactPhone', 
                    contactEmail = '$contactEmail'
                    WHERE contactinfoid = 1";
            
            if ($con->query($sql) === TRUE) {
                $_SESSION['success_message'] = "Record updated successfully";
            } else {
                $_SESSION['error_message'] = "Error updating record: " . $con->error;
            }
        } else {
            // No entry exists, create one
            $sql = "INSERT INTO ContactInfo (contactinfoid, contactAddress, contactPhone, contactEmail)
                    VALUES (1, '$contactAddress', '$contactPhone', '$contactEmail')";
            
            if ($con->query($sql) === TRUE) {
                $_SESSION['success_message'] = "Record created successfully";
            } else {
                $_SESSION['error_message'] = "Error creating record: " . $con->error;
            }
        }
        
        // Redirect to the contact page to prevent form resubmission
        header("Location: ../../contact.php");
        exit;
    }

    // Close the database connection
    $con->close();
} else {
    echo "You must be logged in as admin to update contact information.";
}
?>
