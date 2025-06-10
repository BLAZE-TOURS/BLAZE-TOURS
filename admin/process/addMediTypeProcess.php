<?php

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    if (
        empty($_POST['meditation_name']) ||
        empty($_POST['meditation_start_time']) ||
        empty($_POST['meditation_end_time']) ||
        empty($_POST['meditation_description']) ||
        empty($_POST['meditation_category_id'])
    ) {
        die("All fields are required.");
    }

    if (!isset($_FILES['meditation_image']) || $_FILES['meditation_image']['error'] != 0) {
        die("Image is required.");
    }

    $meditation_name = Database::escape_string($_POST['meditation_name']);
    $meditation_start_time = Database::escape_string($_POST['meditation_start_time']);
    $meditation_end_time = Database::escape_string($_POST['meditation_end_time']);
    $meditation_description = Database::escape_string($_POST['meditation_description']);
    $meditation_category_id = Database::escape_string($_POST['meditation_category_id']);

    // Handle image upload
    $target_dir = __DIR__ . "/../admin/images/medi/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $imageFileType = strtolower(pathinfo($_FILES["meditation_image"]["name"], PATHINFO_EXTENSION));
    $imageName = uniqid('meditype_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $imageName;

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Invalid image type. Allowed: jpg, jpeg, png, gif, webp.");
    }

    if (!move_uploaded_file($_FILES["meditation_image"]["tmp_name"], $target_file)) {
        die("Failed to upload image.");
    }

    // Only the filename is stored in the DB
    $img_url = $imageName;

    // Insert data into the meditation_type table
    Database::setUpConnection();
    $sql = "INSERT INTO meditation_type(`name`, `description`, `img_url`, `start`, `end`, `meditation_category_id`) VALUES ('$meditation_name', '$meditation_description', '$img_url', '$meditation_start_time', '$meditation_end_time', '$meditation_category_id')";

    if (Database::$connection->query($sql) === TRUE) {
        echo "Meditation type added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . Database::$connection->error;
    }
}
?>