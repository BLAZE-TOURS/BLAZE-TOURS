<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $meditationTypeId = $_POST['id'];

    if (!empty($meditationTypeId)) {
        // Escape the ID to prevent SQL injection
        $meditationTypeId = Database::escape_string($meditationTypeId);

        // Start a transaction
        Database::setUpConnection();
        Database::$connection->begin_transaction();

        try {
            // Delete the meditation type from the database
            $sql = "DELETE FROM `meditation_type` WHERE `id` = '$meditationTypeId'";
            Database::iud($sql);

            // Commit the transaction
            Database::$connection->commit();
            echo "Meditation type deleted successfully";
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            Database::$connection->rollback();
            echo "Error deleting meditation type: " . $e->getMessage();
        }
    } else {
        echo "Invalid meditation type ID";
    }
} else {
    echo "Invalid request method";
}
?>