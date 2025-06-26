<?php

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    if (empty($_POST['image_title'])) {
        die("Image title is required.");
    }

    if (empty($_FILES['logo'])) {
        die("Image file is required.");
    }

    $image_title = Database::escape_string($_POST['image_title']);
    $image = $_FILES['logo'];
    $tour_id = isset($_POST['tour_id']) && $_POST['tour_id'] !== "" ? Database::escape_string($_POST['tour_id']) : "NULL";

    // Handle file upload
    $target_dir = "../admin/images/gallry/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . basename($image_title) . "." . $imageFileType;

    // Check if image file is an actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Insert data into the database
    Database::setUpConnection();
    $sql = "INSERT INTO gallary(`title`, `url`, `tour_id`) VALUES ('$image_title', '$target_file', $tour_id)";

    if (Database::$connection->query($sql) === TRUE) {
        echo "New image added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . Database::$connection->error;
    }
}
?>