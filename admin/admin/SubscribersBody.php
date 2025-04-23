<div class="content-page mt-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title text-center">Send Email for All</h3>
          <div id="validation-errors" class="alert alert-danger d-none" role="alert"></div>
          <div id="success-message" class="alert alert-success d-none" role="alert"></div>

          <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" id="subjectAll" name="subject" required>
          </div>
          <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="messageAll" name="message" rows="4" required></textarea>
          </div>

          <div id="loading-spinner" class="card-body d-none">
            <div class="d-flex justify-content-center">
              <div class="spinner-border m-2" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
          <button type="button" onclick="SendEmailForAll();" class="btn btn-primary col-12 mt-3 mx-auto d-block btn-animate">Send Email For All Subscribers...</button>
        </div>
      </div>
    </div>
  </div>

    <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-header">
                      <h5 class="card-title mb-0">Subscribers List</h5>
                  </div><!-- end card header -->

                  <div c=lass="card-body">
                      <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">
                          <thead>
                              <tr class="Table-header">
                                  <th>#ID</th>
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Mobile</th>
                                  <th>Email</th>
                                  <th>Review</th>
                                  <th>DateTime</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                if ($subscriber_n > 0) {
                                    while ($row = $subscriber_rs->fetch_assoc()) {
                                ?>
                                      <tr class="text-center">
                                          <td><?php echo $row["id"]; ?></td>
                                          <td><?php echo $row["first_name"]; ?></td>
                                          <td><?php echo $row["last_name"]; ?></td>
                                          <td><?php echo $row["mobile"]; ?></td>
                                          <td><?php echo $row["email"]; ?></td>
                                          <td><?php echo $row["review"]; ?></td>
                                          <td><?php echo $row["date"]; ?></td>
                                      </tr>
                              <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No subscribers found.</td></tr>";
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