<style>
    .review-wrapper {
        position: relative;
        overflow: hidden;
        height: auto;
        /* Allow expansion based on content */
    }

    .review-text {
        display: block;
        transition: height 0.3s ease;
        white-space: normal;
        height: 50px;
        /* Limit height for collapsed state */
        overflow: hidden;
        margin-right: 30px;
        /* Add some space to the right for the button */
    }

    .toggle-review-btn {
        position: absolute;
        top: 0;
        right: 0;
        /* Align it to the right side */
        background: transparent;
        border: none;
        font-size: 1rem;
        color: #007bff;
        cursor: pointer;
        z-index: 1;
        /* Ensure the button stays above the text */
    }
</style>


<div class="content-page mt-5 fade-in">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Donation List</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableDonation" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Full Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Slip</th>
                                    <th>Send Whatsapp Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($donate_n > 0) {
                                    while ($row = $donate_rs->fetch_assoc()) {
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo $row["fullName"]; ?></td>
                                            <td><?php echo $row["mobile"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["dateTime"]; ?></td>
                                            <td>
                                                <?php
                                                $fileUrl = $row["url"];
                                                $filePath = "../../user/assets/img/donate/" . $fileUrl;
                                                $fileExt = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
                                                if (in_array($fileExt, ['jpg', 'jpeg', 'png'])) {
                                                    // Show image thumbnail, clickable to open full image
                                                    echo '<a href="' . $filePath . '" target="_blank">';
                                                    echo '<img src="' . $filePath . '" alt="Slip" style="max-width:70px;max-height:70px;border-radius:4px;border:1px solid #ccc;box-shadow:0 2px 6px rgba(0,0,0,0.1);">';
                                                    echo '</a><br>';
                                                } elseif ($fileExt === 'pdf') {
                                                    // Show PDF icon, clickable to open PDF
                                                    echo '<a href="' . $filePath . '" target="_blank" style="display:inline-block;">';
                                                    echo '<img src="https://cdn.jsdelivr.net/gh/edent/SuperTinyIcons/images/svg/pdf.svg" alt="PDF" style="width:32px;height:32px;vertical-align:middle;">';
                                                    echo '</a><br>';
                                                    echo '<small>' . htmlspecialchars($fileUrl) . '</small>';
                                                } else {
                                                    // Just show the file name as fallback
                                                    echo htmlspecialchars($fileUrl);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="https://wa.me/<?php echo $row["mobile"]; ?>?text=Namo%20Buddhaya%20<?php echo urlencode($row["fullName"]); ?>,Thank%20you%20for%20your%20donation%20at%20Rakkiththakanda%20Raja%20Maha%20Viharaya"
                                                    target="_blank"
                                                    class="btn btn-success btn-sm">
                                                    Send Message
                                                </a>
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
</div>

<script>
    function toggleReview(id) {
        const reviewText = document.getElementById('review-text-' + id);
        const button = document.querySelector('[data-id="' + id + '"]');

        // Check the current state of the review text and toggle visibility
        if (reviewText.style.height === "auto") {
            reviewText.style.height = "50px"; // Collapse to the original height
            button.innerHTML = '<i class="fas fa-plus"></i>'; // Change to "+" icon
        } else {
            reviewText.style.height = "auto"; // Expand to show full review
            button.innerHTML = '<i class="fas fa-minus"></i>'; // Change to "-" icon
        }
    }
</script>

<!-- <script>
  $(document).ready(function() {
    $('#datatable-buttons').DataTable({
      responsive: true, // Enable responsiveness
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
  });
</script> -->