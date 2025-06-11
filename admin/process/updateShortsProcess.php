<?php
require "../connection.php";

// Function to remove 4-byte UTF-8 characters (like emojis)
function remove_4byte_utf8($string)
{
    return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $string);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["id"], $_POST["name"], $_POST["description"])) {
        $id = intval($_POST["id"]);
        $name = Database::escape_string(remove_4byte_utf8($_POST["name"]));
        $description = Database::escape_string(remove_4byte_utf8($_POST["description"]));

        // Fetch current data for file path
        $result = Database::search("SELECT * FROM `shorts` WHERE `id` = $id LIMIT 1");
        if (!$result || $result->num_rows == 0) {
            echo json_encode([
                "success" => false,
                "message" => "Shorts not found."
            ]);
            exit;
        }
        $row = $result->fetch_assoc();
        $video_url = $row["url"];

        // Handle video upload if provided
        if (isset($_FILES["shorts"]) && $_FILES["shorts"]["size"] > 0) {
            if ($_FILES["shorts"]["size"] > 15 * 1024 * 1024) {
                echo json_encode([
                    "success" => false,
                    "message" => "Video must be less than 15MB."
                ]);
                exit;
            }
            $video_dir = "../admin/assets/shorts/";
            if (!is_dir($video_dir)) {
                mkdir($video_dir, 0777, true);
            }
            $video_name = basename($_FILES["shorts"]["name"]);
            $video_path = $video_dir . $video_name;
            if (move_uploaded_file($_FILES["shorts"]["tmp_name"], $video_path)) {
                $video_url = $video_name;
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to upload video."
                ]);
                exit;
            }
        }

        // Update database
        $query = "UPDATE `shorts` SET `name`='$name', `description`='$description', `url`='$video_url' WHERE `id`=$id";
        Database::iud($query);

        echo json_encode([
            "success" => true,
            "message" => "Shorts updated successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "All fields are required."
        ]);
    }
    exit;
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit;
}
?>