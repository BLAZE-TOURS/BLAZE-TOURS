<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $companyId = $_POST['id'];

    if (!empty($companyId)) {
        // Escape the company ID to prevent SQL injection
        $companyId = Database::escape_string($companyId);

        // Start a transaction
        Database::setUpConnection();
        Database::$connection->begin_transaction();

        try {
            // Delete related records in the logo table
            $sqlLogo = "DELETE FROM `logo` WHERE `company_id` = '$companyId'";
            Database::iud($sqlLogo);

            // Delete the company from the database
            $sqlCompany = "DELETE FROM `company` WHERE `id` = '$companyId'";
            Database::iud($sqlCompany);

            // Commit the transaction
            Database::$connection->commit();
            echo "Company deleted successfully";
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            Database::$connection->rollback();
            echo "Error deleting company: " . $e->getMessage();
        }
    } else {
        echo "Invalid company ID";
    }
} else {
    echo "Invalid request method";
}
?>