<?php
// get_contact_info.php
require_once '../../include/config.php'; // Include your database connection

try {
    $stmt = $pdo->prepare("SELECT section_name, content_text 
                          FROM site_content 
                          WHERE section_name IN ('contact_address', 'contact_phone', 'contact_email')");
    $stmt->execute();
    
    $contactInfo = [
        'address' => '',
        'phone' => '',
        'email' => ''
    ];
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        switch ($row['section_name']) {
            case 'contact_address':
                $contactInfo['address'] = $row['content_text'];
                break;
            case 'contact_phone':
                $contactInfo['phone'] = $row['content_text'];
                break;
            case 'contact_email':
                $contactInfo['email'] = $row['content_text'];
                break;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($contactInfo);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?>