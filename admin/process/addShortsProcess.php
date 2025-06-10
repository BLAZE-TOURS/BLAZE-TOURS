

<?php
require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["name"], $_POST["description"]) && isset($_FILES["shorts"])) {
        $name = Database::escape_string($_POST["name"]);
        $description = Database::escape_string($_POST["description"]);
        $video_file = $_FILES["shorts"];

        // Validate file size (max 5MB)
        if ($video_file["size"] > 5 * 1024 * 1024) {
            echo "Video must be less than 5MB.";
            exit;
        }

        $video_dir = "../admin/assets/shorts/";
        if (!is_dir($video_dir)) mkdir($video_dir, 0777, true);
        $video_name = uniqid() . "_" . basename($video_file["name"]);
        $video_path = $video_dir . $video_name;

        if (move_uploaded_file($video_file["tmp_name"], $video_path)) {
            $video_url = str_replace("../", "", $video_path);
            $query = "INSERT INTO `shorts` (`name`, `description`, `url`) VALUES ('$name', '$description', '$video_url')";
            Database::iud($query);
            echo "New Shorts added successfully";
        } else {
            echo "Failed to upload video.";
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}
?>