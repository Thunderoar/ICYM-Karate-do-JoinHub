<?php
require '../../include/db_conn.php';
page_protect();

// Capture form data
$planid = $_POST['planid'];
$name = $_POST['planname'];
$desc = $_POST['desc'];
$planType = $_POST['plantype'];
$amount = $_POST['amount'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$duration = $_POST['duration'];

// Insert data into plan table
$query = "INSERT INTO plan (planid, planName, description, planType, startDate, endDate, duration, amount, active) 
          VALUES ('$planid', '$name', '$desc', '$planType', '$startDate', '$endDate', '$duration', '$amount', 'yes')";

if (mysqli_query($con, $query)) {
    echo "<head><script>alert('PLAN Added');</script></head>";
    echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
} else {
    echo "<head><script>alert('NOT SUCCESSFUL, Check Again');</script></head>";
    echo "Error: " . mysqli_error($con);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $filename = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;
        $uploadOk = true;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check for upload errors
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo "Upload error: " . $_FILES['image']['error'];
            $uploadOk = false;
        }

        // Validate MIME type and file extension
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $mimeType = mime_content_type($_FILES["image"]["tmp_name"]);
        if (!in_array($mimeType, $allowedTypes) || !in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = false;
        }

        // Check file size (limit: 5MB)
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = false;
        }

        // Check if file already exists and append unique suffix if it does
        if (file_exists($target_file)) {
            $filename = pathinfo($filename, PATHINFO_FILENAME);
            $uniqueSuffix = uniqid();
            $target_file = $target_dir . $filename . "_" . $uniqueSuffix . "." . $imageFileType;
        }

        if ($uploadOk) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
                chmod($target_file, 0777);

                // Insert image path into the database
                $sql = "INSERT INTO images (imageid, planid, image_path) VALUES (UUID(), '$planid', '$target_file')";
                if (mysqli_query($con, $sql)) {
                    echo "Image path stored in the database.";
                } else {
                    echo "Database error: " . mysqli_error($con);
                }
            } else {
                echo "Sorry, there was an error moving your file.";
            }
        } else {
            echo "File not uploaded due to validation failure.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>
