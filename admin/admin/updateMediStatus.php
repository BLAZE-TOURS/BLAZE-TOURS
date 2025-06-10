<?php
require_once "../connection.php";
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    Database::iud("UPDATE meditation SET status_id = 2 WHERE id = $id");
    echo "success";
} else {
    echo "error";
}
?>