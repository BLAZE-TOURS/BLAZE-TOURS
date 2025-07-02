<?php
require_once '../connection.php';

header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$lat = trim($_POST['lat'] ?? '');
$lng = trim($_POST['lng'] ?? '');
$description = trim($_POST['description'] ?? '');
$stop_duration_time = intval($_POST['stop_duration_time'] ?? 0);
$tour_id = intval($_POST['tour_id'] ?? 0);

if ($id <= 0 || $name == '' || $tour_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

Database::setUpConnection();
$id_escaped = Database::escape_string($id);
$name_escaped = Database::escape_string($name);
$address_escaped = Database::escape_string($address);
$lat_escaped = Database::escape_string($lat);
$lng_escaped = Database::escape_string($lng);
$description_escaped = Database::escape_string($description);
$stop_duration_time_escaped = Database::escape_string($stop_duration_time);
$tour_id_escaped = Database::escape_string($tour_id);

// Handle icon upload (optional)
$icon_sql = '';
if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
    $allowedExts = ['jpg', 'jpeg', 'png', 'ico', 'webp', 'svg'];
    $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/x-icon',
        'image/vnd.microsoft.icon',
        'image/webp',
        'image/svg+xml'
    ];
    $ext = strtolower(pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION));
    $type = mime_content_type($_FILES['icon']['tmp_name']);
    if (in_array($ext, $allowedExts) && in_array($type, $allowedTypes)) {
        $iconName = 'icon_' . uniqid() . '.' . $ext;
        $uploadDir = __DIR__ . '/../tour/images/marker/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        move_uploaded_file($_FILES['icon']['tmp_name'], $uploadDir . $iconName);
        $iconPath = '../tour/images/marker/' . $iconName;
        $iconPath_escaped = Database::escape_string($iconPath);
        $icon_sql = ", icon_url='$iconPath_escaped'";
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit;
    }
}

$query = "UPDATE location SET name='$name_escaped', address='$address_escaped', lat='$lat_escaped', lng='$lng_escaped', description='$description_escaped', stop_duration_time='$stop_duration_time_escaped', tour_id='$tour_id_escaped' $icon_sql WHERE id='$id_escaped'";

try {
    Database::iud($query);
    echo json_encode(['success' => true, 'message' => 'Location updated successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
}
?>