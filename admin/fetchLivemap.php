    <?php
    require 'connection.php';

    Database::setUpConnection();

    $sql = "SELECT * FROM `location`";
    $result = Database::search($sql);

    $markers = [];

    while ($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($markers);
