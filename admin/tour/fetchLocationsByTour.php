<?php
require_once "../connection.php";

$tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : '';

if ($tour_id === '') {
    // If 'All' is selected, return nothing (no rows, not even 'No locations found.')
    echo '';
    exit;
}

$where = '';
if ($tour_id !== '0') {
    $where = "WHERE tour_id = '" . intval($tour_id) . "'";
}

$query = "SELECT * FROM location $where";
$result = Database::search($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <tr class="text-center">
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo htmlspecialchars($row["name"]); ?></td>
            <td>
                <?php
                $address = explode(',', $row["address"], 2);
                echo htmlspecialchars($address[0]);
                if (isset($address[1])) {
                    echo "<br>" . htmlspecialchars($address[1]);
                }
                ?>
            </td>
            <td><?php echo $row["lat"]; ?></td>
            <td><?php echo $row["lng"]; ?></td>
            <td>
                <?php if (!empty($row["icon_url"])): ?>
                    <img src="<?php echo htmlspecialchars($row["icon_url"]); ?>" alt="Icon" style="width:32px;height:32px;">
                <?php endif; ?>
            </td>
            <td style="max-width:200px; word-break:break-word; white-space:pre-line;">
                <?php echo htmlspecialchars($row["description"]); ?>
            </td>
            <td><?php echo $row["stop_duration_time"]; ?></td>
            <td>
                <button class="btn btn-sm btn-success edit-btn" onclick="confirmUpdateLocation(<?php echo $row['id']; ?>);">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteLocation(<?php echo $row['id']; ?>);">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php
    }
} // No else! Don't print anything if no results
?>
