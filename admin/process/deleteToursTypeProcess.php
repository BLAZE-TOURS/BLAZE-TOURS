<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $toursTypeId = $_POST['id'];

    if (!empty($toursTypeId)) {
        $toursTypeId = Database::escape_string($toursTypeId);

        Database::setUpConnection();
        Database::$connection->begin_transaction();

        try {
            $sql = "DELETE FROM `tours_type` WHERE `id` = '$toursTypeId'";
            Database::iud($sql);

            Database::$connection->commit();
            echo "Tour type deleted successfully";
        } catch (Exception $e) {
            Database::$connection->rollback();
            echo "Error deleting tour type: " . $e->getMessage();
        }
    } else {
        echo "Invalid tour type ID";
    }
} else {
    echo "Invalid request method";
}
?>