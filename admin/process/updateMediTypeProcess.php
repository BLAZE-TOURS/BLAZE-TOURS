<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        empty($_POST['id']) ||
        empty($_POST['meditation_name']) ||
        empty($_POST['meditation_start_time']) ||
        empty($_POST['meditation_end_time']) ||
        empty($_POST['meditation_description']) ||
        empty($_POST['meditation_category_id'])
    ) {
        die("All fields are required.");
    }

    $id = Database::escape_string($_POST['id']);
    $meditation_name = Database::escape_string($_POST['meditation_name']);
    $meditation_start_time = Database::escape_string($_POST['meditation_start_time']);
    $meditation_end_time = Database::escape_string($_POST['meditation_end_time']);
    $meditation_description = Database::escape_string($_POST['meditation_description']);
    $meditation_category_id = Database::escape_string($_POST['meditation_category_id']);

    // Handle image upload if provided
    $img_sql = "";
    if (isset($_FILES['meditation_image']) && $_FILES['meditation_image']['error'] == 0) {
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
        $img_sql = ", img_url='$imageName'";
    }

    Database::setUpConnection();
    $sql = "UPDATE meditation_type SET 
        name='$meditation_name',
        description='$meditation_description',
        start='$meditation_start_time',
        end='$meditation_end_time',
        meditation_category_id='$meditation_category_id'
        $img_sql
        WHERE id='$id'";

    if (Database::$connection->query($sql) === TRUE) {
        echo "Meditation type updated successfully";
    } else {
        echo "Error: " . Database::$connection->error;
    }
}
?>