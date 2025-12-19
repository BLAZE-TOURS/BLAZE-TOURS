
<?php
require_once "../connection.php";
if (isset($_POST['id'])) {
    // treat id as string (booking.id is VARCHAR)
    $id = $_POST['id'];
    $idEsc = Database::escape_string($id);
    Database::iud("UPDATE booking 
SET status = 'Done'
WHERE id = '$idEsc';
");
    echo "success";
} else {
    echo "error";
}
?>