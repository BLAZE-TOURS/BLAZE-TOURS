<?php
require "../connection.php";

// Function to remove 4-byte UTF-8 characters (like emojis)
function remove_4byte_utf8($string)
{
    return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $string);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["name"], $_POST["description"]) && isset($_FILES["shorts"])) {
        $name = Database::escape_string(remove_4byte_utf8($_POST["name"]));
        $description = Database::escape_string(remove_4byte_utf8($_POST["description"]));
        $video_file = $_FILES["shorts"];

        // Validate file size (max 15MB)
        if ($video_file["size"] > 15 * 1024 * 1024) {
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
        $video_name = basename($video_file["name"]);
        $video_path = $video_dir . $video_name;

        if (move_uploaded_file($video_file["tmp_name"], $video_path)) {
            $video_url = $video_name;
            $query = "INSERT INTO `shorts` (`name`, `description`, `url`) VALUES ('$name', '$description', '$video_url')";
            Database::iud($query);
            echo json_encode([
                "success" => true,
                "message" => "New Shorts added successfully"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to upload video."
            ]);
        }
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