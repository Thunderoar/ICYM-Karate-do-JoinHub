<?php
// contact_process.php
require_once '../../include/config.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $fullName = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    
    // Validate input
    $errors = [];
    if (empty($fullName)) $errors[] = "Full name is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($subject)) $errors[] = "Subject is required";
    if (empty($message)) $errors[] = "Message is required";
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (full_name, email, subject, message) 
                                 VALUES (:full_name, :email, :subject, :message)");
            
            $result = $stmt->execute([
                ':full_name' => $fullName,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message
            ]);
            
            $response = [
                'status' => 'success',
                'message' => 'Your message has been sent successfully!'
            ];
        } catch (PDOException $e) {
            $response = [
                'status' => 'error',
                'message' => 'There was an error sending your message. Please try again later.'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Please correct the following errors: ' . implode(', ', $errors)
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>