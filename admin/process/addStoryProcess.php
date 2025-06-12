<?php

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        empty($_POST['story_name']) ||
        empty($_POST['story_description']) 
    ) {
        die("All fields are required.");
    }

    if (!isset($_FILES['story_image']) || $_FILES['story_image']['error'] != 0) {
        die("Image is required.");
    }

    $story_name = Database::escape_string($_POST['story_name']);
    $story_date = empty($_POST['story_date']) ? date('Y-m-d') : Database::escape_string($_POST['story_date']);
    $story_description = Database::escape_string($_POST['story_description']);

    $target_dir = __DIR__ . "/../admin/images/story/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $imageFileType = strtolower(pathinfo($_FILES["story_image"]["name"], PATHINFO_EXTENSION));
    $imageName = uniqid('story_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $imageName;

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Invalid image type. Allowed: jpg, jpeg, png, gif, webp.");
    }

    if (!move_uploaded_file($_FILES["story_image"]["tmp_name"], $target_file)) {
        die("Failed to upload image.");
    }

    $img_url = $imageName;

    Database::setUpConnection();
    $sql = "INSERT INTO story(`title`, `description`, `date_time`, `img_url`) VALUES ('$story_name', '$story_description', '$story_date', '$img_url')";

    if (Database::$connection->query($sql) === TRUE) {
        echo "Story added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . Database::$connection->error;
    }
}
?>