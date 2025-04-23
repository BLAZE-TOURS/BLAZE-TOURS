<?php

require "../connection.php";

if (isset($_GET['id'])) {
    $id = Database::escape_string($_GET['id']);

    $query = "SELECT `url`, `title` FROM gallary WHERE `id` = '$id'";
    $result = Database::search($query);

    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc();
        $filePath = $image['url'];
        $fileName = basename($filePath);

        // Check if the file exists
        if (file_exists($filePath)) {
            echo json_encode([
                'url' => $filePath,
                'filename' => $fileName
            ]);
        } else {
            echo json_encode(['error' => 'File not found on the server.']);
        }
    } else {
        echo json_encode(['error' => 'Image not found in the database.']);
    }
} else {
    echo json_encode(['error' => 'No ID provided.']);
}

?>