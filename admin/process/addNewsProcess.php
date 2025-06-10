<?php

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    if (
        empty($_POST['news_name']) ||
        empty($_POST['news_start_date']) ||
        empty($_POST['news_end_date']) ||
        empty($_POST['news_description']) 
    ) {
        die("All fields are required.");
    }

    if (!isset($_FILES['news_image']) || $_FILES['news_image']['error'] != 0) {
        die("Image is required.");
    }

    $news_name = Database::escape_string($_POST['news_name']);
    $news_start_date = Database::escape_string($_POST['news_start_date']);
    $news_end_date = Database::escape_string($_POST['news_end_date']);
    $news_description = Database::escape_string($_POST['news_description']);

    // Handle image upload
    $target_dir = __DIR__ . "/../admin/images/news/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $imageFileType = strtolower(pathinfo($_FILES["news_image"]["name"], PATHINFO_EXTENSION));
    $imageName = uniqid('news_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $imageName;

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Invalid image type. Allowed: jpg, jpeg, png, gif, webp.");
    }

    if (!move_uploaded_file($_FILES["news_image"]["tmp_name"], $target_file)) {
        die("Failed to upload image.");
    }

    // Only the filename is stored in the DB
    $img_url = $imageName;

    // Insert data into the news table
    Database::setUpConnection();
    $sql = "INSERT INTO news(`title`, `description`, `date_time_start`, `date_time_end`, `img_url`) VALUES ('$news_name', '$news_description', '$news_start_date', '$news_end_date', '$img_url')";

    if (Database::$connection->query($sql) === TRUE) {
        echo "News added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . Database::$connection->error;
    }
}
?>