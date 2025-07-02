<?php

include '../connection.php'; // Adjust path if needed

$query = Database::search("SELECT * FROM `tour` WHERE `status_id` = '3'");
if ($query && $query->num_rows > 0) {
    echo '<select id="SelectTourName" class="form-select">';
    echo '<option value="">All</option>';
    while ($row = $query->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
    }
    echo '</select>';
} else {
    echo '<select id="SelectTourName" class="form-select">';
    echo '<option value="">No processing tours found</option>';
    echo '</select>';
}
?>

<script>
    $(document).ready(function() {
        $.ajax({
            url: 'fechprocessingTour.php',
            method: 'GET',
            success: function(data) {
                $('#SelectTourName').html(data);
            },
            error: function() {
                $('#SelectTourName').html('<option value="">Error loading tours</option>');
            }
        });
    });
</script>