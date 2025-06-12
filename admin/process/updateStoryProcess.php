<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $story_name = Database::escape_string($_POST['story_name']);
    $story_date = empty($_POST['story_date']) ? date('Y-m-d') : Database::escape_string($_POST['story_date']);
    $story_description = Database::escape_string($_POST['story_description']);

    $img_url = "";
    if (isset($_FILES['story_image']) && $_FILES['story_image']['error'] == 0) {
        $target_dir = __DIR__ . "/../admin/images/news/";
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
    }

    Database::setUpConnection();
    if ($img_url) {
        $sql = "UPDATE story SET title='$story_name', description='$story_description', date_time='$story_date', img_url='$img_url' WHERE id=$id";
    } else {
        $sql = "UPDATE story SET title='$story_name', description='$story_description', date_time='$story_date' WHERE id=$id";
    }

    if (Database::$connection->query($sql) === TRUE) {
        echo "Story updated successfully";
    } else {
        echo "Error: " . Database::$connection->error;
    }
}
?>
<script>
document.getElementById('update_story_date').value = data.date_time;
</script>