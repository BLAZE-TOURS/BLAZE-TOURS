<?php
require_once("../../connection.php");
header('Content-Type: application/json');

try {
    // --- Validate required fields ---
    $requiredFields = [
        'name', 'tourType', 'message', 'Duration', 'subject', 'adult-price', 'body-title'
    ];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => "Field '$field' is required."]);
            exit;
        }
    }

    $tour_id = $_POST['tour_id'] ?? null;
    $name = Database::escape_string(trim($_POST['name']));
    $tourType = Database::escape_string(trim($_POST['tourType']));
    $message = Database::escape_string(trim($_POST['message']));
    $duration = Database::escape_string(trim($_POST['Duration']));
    $kids_price = Database::escape_string(trim($_POST['subject']));
    $adult_price = Database::escape_string(trim($_POST['adult-price']));
    $max_people = Database::escape_string(trim($_POST['body-title']));
    $status_id = 3; // Processing status

    $times = json_decode($_POST['times'] ?? '[]', true);
    $highlights = json_decode($_POST['highlights'] ?? '[]', true);
    $locations = json_decode($_POST['locations'] ?? '[]', true);

    // --- 1. Update/Insert main tour table ---
    try {
        if ($tour_id) {
            $tour_id = Database::escape_string($tour_id);
            Database::iud(
                "UPDATE `tour` SET `name`='$name', `tours_type_id`='$tourType', `description`='$message', `duration`='$duration', `kids_price`='$kids_price', `adult_price`='$adult_price', `maximum_people_count`='$max_people', `status_id`='$status_id' WHERE `id`='$tour_id'"
            );
        } else {
            Database::iud(
                "INSERT INTO `tour` (`name`, `tours_type_id`, `description`, `duration`, `kids_price`, `adult_price`, `maximum_people_count`, `status_id`) VALUES ('$name', '$tourType', '$message', '$duration', '$kids_price', '$adult_price', '$max_people', '$status_id')"
            );
            $tour_id = Database::$connection->insert_id;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Tour insert/update error: ' . $e->getMessage()]);
        exit;
    }

    // --- 2. Handle images (main, second) ---
    $main_image_url = null;
    $second_image_url = null;
    $upload_dir = "../../assets/uploads/tour_images/";
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    try {
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
            if (in_array($_FILES['main_image']['type'], $allowed_types)) {
                $main_image_url = $upload_dir . uniqid('main_') . "_" . basename($_FILES['main_image']['name']);
                move_uploaded_file($_FILES['main_image']['tmp_name'], $main_image_url);
            } else {
                throw new Exception("Invalid main image type.");
            }
        }
        if (isset($_FILES['second_image']) && $_FILES['second_image']['error'] == 0) {
            if (in_array($_FILES['second_image']['type'], $allowed_types)) {
                $second_image_url = $upload_dir . uniqid('second_') . "_" . basename($_FILES['second_image']['name']);
                move_uploaded_file($_FILES['second_image']['tmp_name'], $second_image_url);
            } else {
                throw new Exception("Invalid second image type.");
            }
        }
        Database::iud("DELETE FROM `tour_image` WHERE `tour_id`='$tour_id'");
        Database::iud("INSERT INTO `tour_image` (`main_image`, `second_image`, `tour_id`) VALUES ('$main_image_url', '$second_image_url', '$tour_id')");
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Image upload error: ' . $e->getMessage()]);
        exit;
    }

    // --- 3. Handle times ---
    try {
        Database::iud("DELETE FROM `idx_time` WHERE `tour_id`='$tour_id'");
        $times = array_unique($times);
        foreach ($times as $t) {
            if (!empty($t)) {
                $t_esc = Database::escape_string($t);
                $res = Database::search("SELECT `id` FROM `time` WHERE `timeslot`='$t_esc'");
                if ($row = $res->fetch_assoc()) {
                    $time_id = $row['id'];
                } else {
                    Database::iud("INSERT INTO `time` (`timeslot`) VALUES ('$t_esc')");
                    $time_id = Database::$connection->insert_id;
                }
                $check = Database::search("SELECT 1 FROM `idx_time` WHERE `tour_id`='$tour_id' AND `time_id`='$time_id'");
                if (!$check->fetch_assoc()) {
                    Database::iud("INSERT INTO `idx_time` (`tour_id`, `time_id`) VALUES ('$tour_id', '$time_id')");
                }
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Times insert error: ' . $e->getMessage()]);
        exit;
    }

    // --- 4. Handle highlights ---
    try {
        Database::iud("DELETE FROM `idx_highlight` WHERE `tour_id`='$tour_id'");
        $highlights = array_unique($highlights);
        foreach ($highlights as $h) {
            if (!empty($h)) {
                $highlight_id = null;
                $h_esc = Database::escape_string($h);
                $res = Database::search("SELECT `id` FROM `highlight` WHERE `name`='$h_esc'");
                if ($row = $res->fetch_assoc()) {
                    $highlight_id = $row['id'];
                } else {
                    Database::iud("INSERT INTO `highlight` (`name`) VALUES ('$h_esc')");
                    $highlight_id = Database::$connection->insert_id;
                }
                $check = Database::search("SELECT 1 FROM `idx_highlight` WHERE `tour_id`='$tour_id' AND `highlight_id`='$highlight_id'");
                if (!$check->fetch_assoc()) {
                    Database::iud("INSERT INTO `idx_highlight` (`tour_id`, `highlight_id`) VALUES ('$tour_id', '$highlight_id')");
                }
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Highlights insert error: ' . $e->getMessage()]);
        exit;
    }

    // --- 5. Handle locations ---
    try {
        Database::iud("DELETE FROM `location` WHERE `tour_id`='$tour_id'");
        foreach ($locations as $loc) {
            // Validate location fields
            $locFields = ['name', 'address', 'lat', 'lng', 'description', 'stop_duration_time'];
            foreach ($locFields as $lf) {
                if (empty($loc[$lf])) {
                    echo json_encode(['success' => false, 'message' => "Location field '$lf' is required."]);
                    exit;
                }
            }
            // Handle icon image (base64)
            $icon_url = null;
            if (!empty($loc['iconPreview'])) {
                $icon_data = $loc['iconPreview'];
                if (preg_match('/^data:image\/(\w+);base64,/', $icon_data, $type)) {
                    $icon_data = substr($icon_data, strpos($icon_data, ',') + 1);
                    $icon_data = base64_decode($icon_data);
                    $icon_ext = strtolower($type[1]);
                    $icon_filename = $upload_dir . uniqid('icon_') . ".$icon_ext";
                    if (file_put_contents($icon_filename, $icon_data) === false) {
                        echo json_encode(['success' => false, 'message' => "Failed to save icon image."]);
                        exit;
                    }
                    $icon_url = Database::escape_string($icon_filename);
                }
            }
            $loc_name = Database::escape_string($loc['name']);
            $loc_address = Database::escape_string($loc['address']);
            $loc_lat = Database::escape_string($loc['lat']);
            $loc_lng = Database::escape_string($loc['lng']);
            $loc_desc = Database::escape_string($loc['description']);
            $loc_stop = Database::escape_string($loc['stop_duration_time']);
            $sql = "INSERT INTO `location` (`name`, `address`, `lat`, `lng`, `icon_url`, `description`, `stop_duration_time`, `tour_id`) VALUES ('$loc_name', '$loc_address', '$loc_lat', '$loc_lng', '$icon_url', '$loc_desc', '$loc_stop', '$tour_id')";
            Database::iud($sql);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Location insert error: ' . $e->getMessage()]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Tour saved successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}