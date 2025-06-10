<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $podId = $_GET['id'];

    if (!empty($podId)) {
        $podId = Database::escape_string($podId);

        Database::setUpConnection();
        Database::$connection->begin_transaction();

        try {
            $sql = "DELETE FROM `pod` WHERE `id` = '$podId'";
            Database::iud($sql);

            Database::$connection->commit();
            echo "Podcast deleted successfully";
        } catch (Exception $e) {
            Database::$connection->rollback();
            echo "Error deleting Podcast: " . $e->getMessage();
        }
    } else {
        echo "Invalid Podcast ID";
    }
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $result = Database::search("SELECT * FROM `shorts` WHERE `id` = $id LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $videoPath = "../" . $row["url"];
        if (file_exists($videoPath)) {
            unlink($videoPath);
        }
        Database::iud("DELETE FROM `shorts` WHERE `id` = $id");
        echo "Shorts deleted successfully";
    } else {
        echo "Shorts not found.";
    }
} else {
    echo "Invalid request.";
}
?>