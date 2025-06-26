<?php
include_once "fetchTours.php";
?>
<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Tour List</h3>
                    <div class="table-responsive col-12 mx-auto mb-5">
                        <table id="datatable-tourType" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Tours Name</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Kids Price</th>
                                    <th>Adult Price</th>
                                    <th>Maximum People Count</th>
                                    <th>Location Name</th>
                                    <th>Tours Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($tours_n > 0) {
                                    while ($row = $tours_rs->fetch_assoc()) {
                                        // Status badge color
                                        $status_badge = '';
                                        if ($row['status_id'] == 1) {
                                            $status_badge = '<span class="badge bg-success">Active</span>';
                                        } else if ($row['status_id'] == 2) {
                                            $status_badge = '<span class="badge bg-danger">Inactive</span>';
                                        } else {
                                            $status_badge = '<span class="badge bg-secondary">' . htmlspecialchars($row['status_name']) . '</span>';
                                        }
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["description"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["duration"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["kids_price"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["adult_price"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["maximum_people_count"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["location_name"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["tours_type_name"]); ?></td>
                                            <td><?php echo $status_badge; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary edit-btn" onclick="changeStatusTours(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success edit-btn" onclick="updateTours(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteTours(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>