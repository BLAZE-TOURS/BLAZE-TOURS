<?php
require_once("../../connection.php");
header('Content-Type: application/json');

$tour_id = intval($_POST['tour_id'] ?? 0);
$locations = json_decode($_POST['locations'] ?? '[]', true);

if ($tour_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid tour selected.']);
    exit;
}

if (!is_array($locations) || count($locations) === 0) {
    echo json_encode(['success' => false, 'message' => 'No locations provided.']);
    exit;
}

$iconUploadDir = __DIR__ . '/../images/marker/';
if (!is_dir($iconUploadDir)) {
    mkdir($iconUploadDir, 0777, true);
}

function normalizeIconPathForDb($iconPath)
{
    $iconPath = trim((string)$iconPath);
    if ($iconPath === '') return '';

    if (strpos($iconPath, '../tour/') === 0) {
        return substr($iconPath, 8);
    }

    if (strpos($iconPath, './') === 0) {
        return ltrim(substr($iconPath, 2), '/');
    }

    return ltrim($iconPath, '/');
}

try {
    Database::iud("DELETE FROM `location` WHERE `tour_id`='" . Database::escape_string($tour_id) . "'");

    foreach ($locations as $loc) {
        $required = ['name', 'address', 'lat', 'lng', 'description', 'stop_duration_time'];
        foreach ($required as $field) {
            if (!isset($loc[$field]) || trim((string)$loc[$field]) === '') {
                echo json_encode(['success' => false, 'message' => "Location field '$field' is required."]);
                exit;
            }
        }

        $iconUrlForDb = '';
        $iconPreview = $loc['iconPreview'] ?? '';
        $iconPath = $loc['iconPath'] ?? '';

        if (is_string($iconPreview) && strpos($iconPreview, 'data:image/') === 0) {
            if (preg_match('/^data:image\/([a-zA-Z0-9\-\+\.]+);base64,/', $iconPreview, $type)) {
                $iconExt = strtolower($type[1]);
                if (
                    $iconExt !== 'x-icon' &&
                    $iconExt !== 'ico' &&
                    $iconExt !== 'vnd.microsoft.icon' &&
                    $iconExt !== 'png'
                ) {
                    echo json_encode(['success' => false, 'message' => 'Only .ico or .png files are allowed for location icons.']);
                    exit;
                }

                $rawData = substr($iconPreview, strpos($iconPreview, ',') + 1);
                $decoded = base64_decode($rawData);
                if ($decoded === false) {
                    echo json_encode(['success' => false, 'message' => 'Invalid icon image data.']);
                    exit;
                }

                $ext = ($iconExt === 'png') ? '.png' : '.ico';
                $fileName = uniqid('icon_') . $ext;
                $fullPath = $iconUploadDir . $fileName;

                if (file_put_contents($fullPath, $decoded) === false) {
                    echo json_encode(['success' => false, 'message' => 'Failed to save icon image.']);
                    exit;
                }

                $iconUrlForDb = 'images/marker/' . $fileName;
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid icon image format.']);
                exit;
            }
        } else {
            $normalizedExistingPath = normalizeIconPathForDb($iconPath);
            if ($normalizedExistingPath === '') {
                echo json_encode(['success' => false, 'message' => 'Location icon is required.']);
                exit;
            }
            $iconUrlForDb = $normalizedExistingPath;
        }

        $name = Database::escape_string(trim((string)$loc['name']));
        $address = Database::escape_string(trim((string)$loc['address']));
        $lat = Database::escape_string(trim((string)$loc['lat']));
        $lng = Database::escape_string(trim((string)$loc['lng']));
        $description = Database::escape_string(trim((string)$loc['description']));
        $stopDuration = Database::escape_string(trim((string)$loc['stop_duration_time']));
        $icon = Database::escape_string($iconUrlForDb);

        $sql = "INSERT INTO `location` (`name`, `address`, `lat`, `lng`, `icon_url`, `description`, `stop_duration_time`, `tour_id`) VALUES ('$name', '$address', '$lat', '$lng', '$icon', '$description', '$stopDuration', '$tour_id')";
        Database::iud($sql);
    }

    echo json_encode(['success' => true, 'message' => 'Locations updated successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to update locations.']);
}
