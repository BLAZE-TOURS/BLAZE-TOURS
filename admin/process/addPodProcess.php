<?php

require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if all required fields are set
    if (isset($_POST["pod_name"], $_POST["description"]) && isset($_FILES["img"]) && isset($_FILES["podcast"])) {
        $pod_name = Database::escape_string($_POST["pod_name"]);
        $description = Database::escape_string($_POST["description"]);

        // Directories for saving files
        $img_dir = "../admin/assets/podcast/img/";
        $podcast_dir = "../admin/assets/podcast/";

        // Handle image upload
        $img_file = $_FILES["img"];
        $img_name = uniqid() . "_" . basename($img_file["name"]);
        $img_path = $img_dir . $img_name;

        // Handle podcast upload
        $podcast_file = $_FILES["podcast"];
        $podcast_name = uniqid() . "_" . basename($podcast_file["name"]);
        $podcast_path = $podcast_dir . $podcast_name;

        // Validate and move uploaded files
        if (move_uploaded_file($img_file["tmp_name"], $img_path) && move_uploaded_file($podcast_file["tmp_name"], $podcast_path)) {
            // Prepare file URLs for database
            $img_url = str_replace("../", "", $img_path);
            $podcast_url = str_replace("../", "", $podcast_path);

            // Insert data into the database
            $query = "INSERT INTO `pod` (`pod_name`, `pod_description`, `pod_img_url`, `pod_url`) VALUES ('$pod_name', '$description', '$img_url', '$podcast_url')";
            Database::iud($query);

            echo "New Podcast added successfully";
        } else {
            echo "Failed to upload files. Please try again.";
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>