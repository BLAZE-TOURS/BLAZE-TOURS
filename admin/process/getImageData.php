<?php

require "../connection.php";

if (isset($_GET['id'])) {
    $id = Database::escape_string($_GET['id']);

    $query = "SELECT i.id, i.title, i.url FROM gallary i WHERE i.id = '$id'";
    $result = Database::search($query);

    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc();

        // Ensure the URL is correctly formatted
        if (!empty($image['url']) && !str_starts_with($image['url'], "../admin/images/gallry/")) {
            $image['url'] = "../admin/images/gallry/" . basename($image['url']);
        }

        echo json_encode($image);
    } else {
        echo json_encode(['error' => 'Image not found']);
    }
} else {
    echo json_encode(["error" => "No Image ID provided"]);
}

?>

