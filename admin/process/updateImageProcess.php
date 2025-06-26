<?php

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = Database::escape_string($_POST['id']);
    $image_title = Database::escape_string($_POST['image_title']);
    $tour_id = isset($_POST['tour_id']) && $_POST['tour_id'] !== "" ? Database::escape_string($_POST['tour_id']) : "NULL";

    // Update the title
    $sql = "UPDATE gallary SET `title` = '$image_title', `tour_id` = $tour_id WHERE `id` = '$id'";
    if (Database::$connection->query($sql) === TRUE) {
        // Handle image upload if a new image is provided
        if (!empty($_FILES['logo']['name'])) {
            $image = $_FILES['logo'];
            $target_dir = "../admin/images/gallry/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
            $target_file = $target_dir . basename($image_title) . "." . $imageFileType;

            // Validate the image
            $check = getimagesize($image["tmp_name"]);
            if ($check === false) {
                die("File is not an image.");
            }

            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                die("Only JPG, JPEG, PNG & GIF files are allowed.");
            }

            // Move the uploaded file
            if (!move_uploaded_file($image["tmp_name"], $target_file)) {
                die("Error uploading the file.");
            }

            // Update the image URL in the database
            $image_sql = "UPDATE gallary SET `url` = '$target_file' WHERE `id` = '$id'";
            if (Database::$connection->query($image_sql) !== TRUE) {
                die("Error updating image URL: " . Database::$connection->error);
            }
        }

        echo "Image updated successfully";
    } else {
        echo "Error updating title: " . Database::$connection->error;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = Database::escape_string($_GET['id']);
    $sql = "SELECT * FROM gallary WHERE `id` = '$id'";
    $result = Database::search($sql);

    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc();

        // Prepend the base path to the image URL if necessary
        if (!empty($image['url'])) {
            $image['url'] = "../admin/images/gallry/" . basename($image['url']);
        }

        echo json_encode($image);
    } else {
        echo json_encode(["error" => "Image not found"]);
    }
}
?>