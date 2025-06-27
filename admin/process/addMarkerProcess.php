<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $lat = $_POST['lat'] ?? '';
    $lng = $_POST['lng'] ?? '';
    $description = $_POST['description'] ?? '';
    $stop_duration_time = $_POST['stop_duration_time'] ?? 0;

    // Handle icon upload
    $iconName = '';
    $allowedExts = ['jpg', 'jpeg', 'png', 'ico', 'webp', 'svg'];
    $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/x-icon',
        'image/vnd.microsoft.icon',
        'image/webp',
        'image/svg+xml'
    ];
    if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION));
        $type = mime_content_type($_FILES['icon']['tmp_name']);
        if (in_array($ext, $allowedExts) && in_array($type, $allowedTypes)) {
            $iconName = 'icon_' . uniqid() . '.' . $ext;
            $uploadDir = __DIR__ . '/../tour/images/marker/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            move_uploaded_file($_FILES['icon']['tmp_name'], $uploadDir . $iconName);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type']);
            exit;
        }
    }

    $iconPath = '../tour/images/marker/' . $iconName;

    // Escape values to prevent SQL injection
    $name = Database::escape_string($name);
    $address = Database::escape_string($address);
    $lat = Database::escape_string($lat);
    $lng = Database::escape_string($lng);
    $description = Database::escape_string($description);
    $stop_duration_time = (int)$stop_duration_time;
    $iconPath = Database::escape_string($iconPath);

    $sql = sprintf(
        "INSERT INTO `location` (`name`, `address`, `lat`, `lng`, `icon_url`, `description`, `stop_duration_time`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', %d);",
        $name, $address, $lat, $lng, $iconPath, $description, $stop_duration_time
    );
    $result = Database::search($sql);

    echo json_encode([
        'success' => true,
        'message' => 'Marker added successfully',
        'icon' => $iconPath
    ]);
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
