<?php


require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"], $_POST["pod_name"], $_POST["description"])) {
        $id = intval($_POST["id"]);
        $pod_name = Database::escape_string($_POST["pod_name"]);
        $description = Database::escape_string($_POST["description"]);

        // Fetch current data for file paths
        $result = Database::search("SELECT * FROM `pod` WHERE `id` = $id LIMIT 1");
        if (!$result || $result->num_rows == 0) {
            echo "Podcast not found.";
            exit;
        }
        $row = $result->fetch_assoc();

        $img_url = $row["pod_img_url"];
        $podcast_url = $row["pod_url"];

        // Handle image upload if provided
        if (isset($_FILES["img"]) && $_FILES["img"]["size"] > 0) {
            $img_dir = "../admin/assets/podcast/img/";
            $img_file = $_FILES["img"];
            $img_name = uniqid() . "_" . basename($img_file["name"]);
            $img_path = $img_dir . $img_name;
            if (move_uploaded_file($img_file["tmp_name"], $img_path)) {
                $img_url = str_replace("../", "", $img_path);
            } else {
                echo "Failed to upload image.";
                exit;
            }
        }

        // Handle podcast upload if provided
        if (isset($_FILES["podcast"]) && $_FILES["podcast"]["size"] > 0) {
            $podcast_dir = "../admin/assets/podcast/";
            $podcast_file = $_FILES["podcast"];
            $podcast_name = uniqid() . "_" . basename($podcast_file["name"]);
            $podcast_path = $podcast_dir . $podcast_name;
            if (move_uploaded_file($podcast_file["tmp_name"], $podcast_path)) {
                $podcast_url = str_replace("../", "", $podcast_path);
            } else {
                echo "Failed to upload podcast.";
                exit;
            }
        }

        // Update database
        $query = "UPDATE `pod` SET `pod_name`='$pod_name', `pod_description`='$description', `pod_img_url`='$img_url', `pod_url`='$podcast_url' WHERE `id`=$id";
        Database::iud($query);

        echo "Podcast updated successfully";
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>