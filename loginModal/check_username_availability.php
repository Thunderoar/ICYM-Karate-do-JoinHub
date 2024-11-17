<?php
require '../include/db_conn.php';

// Set headers for JSON response
header('Content-Type: application/json');

// Function to validate username format
function isValidUsername($username) {
    if (strlen($username) < 3 || strlen($username) > 20) {
        return false;
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        return false;
    }
    return true;
}

function checkUsernameAvailability($con, $username) {
    $username = mysqli_real_escape_string($con, trim($username));

    $query1 = "SELECT COUNT(*) as count FROM users WHERE username = '$username'";
    $result1 = mysqli_query($con, $query1);
    
    if (!$result1) {
        throw new Exception("Error checking users table: " . mysqli_error($con));
    }

    $usersCount = mysqli_fetch_assoc($result1)['count'];
    if ($usersCount > 0) {
        return false;
    }
    
    $query2 = "SELECT COUNT(*) as count FROM login WHERE username = '$username'";
    $result2 = mysqli_query($con, $query2);

    if (!$result2) {
        throw new Exception("Error checking login table: " . mysqli_error($con));
    }

    $loginCount = mysqli_fetch_assoc($result2)['count'];
    if ($loginCount > 0) {
        return false;
    }

    return true;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    if (!isset($_POST['username'])) {
        throw new Exception('Username parameter is missing');
    }

    $username = trim($_POST['username']);

    if (empty($username)) {
        echo json_encode([
            'available' => false,
            'error' => 'Username cannot be empty'
        ]);
        exit;
    }

    if (!isValidUsername($username)) {
        echo json_encode([
            'available' => false,
            'error' => 'Invalid username format. Use 3-20 characters, letters, numbers, and underscores only.'
        ]);
        exit;
    }

    $isAvailable = checkUsernameAvailability($con, $username);

    echo json_encode([
        'available' => $isAvailable,
        'error' => null
    ]);

} catch (Exception $e) {
    error_log("Username check error: " . $e->getMessage());
    echo json_encode([
        'available' => false,
        'error' => 'An error occurred while checking username availability'
    ]);
}

if (isset($con)) {
    mysqli_close($con);
}
?>
