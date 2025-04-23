<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if the ID is set in the GET request
    $imageId = $_GET['id'];

    if (!empty($imageId)) {
        // Escape the company ID to prevent SQL injection
        $imageId = Database::escape_string($imageId);

        // Start a transaction
        Database::setUpConnection();
        Database::$connection->begin_transaction();

        try {
            // Delete related records in the logo table
            $sqlLogo = "DELETE FROM `gallary` WHERE `id` = '$imageId'";
            Database::iud($sqlLogo);

     
            // Commit the transaction
            Database::$connection->commit();
            echo "Image deleted successfully";
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            Database::$connection->rollback();
            echo "Error deleting Image: " . $e->getMessage();
        }
    } else {
        echo "Invalid Image ID";
    }
} else {
    echo "Invalid request method";
}
?>