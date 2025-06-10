<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $news_name = Database::escape_string($_POST['news_name']);
    $news_start_date = Database::escape_string($_POST['news_start_date']);
    $news_end_date = Database::escape_string($_POST['news_end_date']);
    $news_description = Database::escape_string($_POST['news_description']);

    // Handle image upload if a new image is provided
    $img_url = "";
    if (isset($_FILES['news_image']) && $_FILES['news_image']['error'] == 0) {
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
        $img_url = $imageName;
    }

    Database::setUpConnection();
    if ($img_url) {
        $sql = "UPDATE news SET title='$news_name', description='$news_description', date_time_start='$news_start_date', date_time_end='$news_end_date', img_url='$img_url' WHERE id=$id";
    } else {
        $sql = "UPDATE news SET title='$news_name', description='$news_description', date_time_start='$news_start_date', date_time_end='$news_end_date' WHERE id=$id";
    }

    if (Database::$connection->query($sql) === TRUE) {
        echo "News updated successfully";
    } else {
        echo "Error: " . Database::$connection->error;
    }
}
?>