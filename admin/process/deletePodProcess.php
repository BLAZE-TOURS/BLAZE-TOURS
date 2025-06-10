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
} else {
    echo "Invalid request method";
}
?>