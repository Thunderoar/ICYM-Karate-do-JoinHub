<?php
require '../../include/db_conn.php';
page_protect();

$planid = $_POST['planid'];
$name = $_POST['planname'];
$desc = $_POST['desc'];
$planType = $_POST['plantype'];
$amount = $_POST['amount'];

// Insert data into plan table
$query = "INSERT INTO plan(planid, planName, description, planType, amount, active) VALUES('$planid', '$name', '$desc', '$planType', '$amount', 'yes')";

if (mysqli_query($con, $query)) {
    echo "<head><script>alert('PLAN Added');</script></head></html>";
    echo "<meta http-equiv='refresh' content='0; url=view_plan.php'>";
} else {
    echo "<head><script>alert('NOT SUCCESSFUL, Check Again');</script></head></html>";
    echo "Error: " . mysqli_error($con);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check for upload errors
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo "Upload error: " . $_FILES['image']['error'];
            exit;
        }

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'mp4'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if everything is ok
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

                // Change file permissions to 0777
                chmod($target_file, 0777);
                
                // Insert the image path into the database
                $sql = "INSERT INTO images (imageid, planid, image_path) VALUES (UUID(), '$planid', '$target_file')";
                if (mysqli_query($con, $sql)) {
                    echo "Image path stored in the database.";
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file uploaded.";
    }
}
?>
