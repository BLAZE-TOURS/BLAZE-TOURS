<?php

session_start();

require "../connection.php";

if (isset($_SESSION["adminuser"])) {

?>

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->


            <div class="container-xxl">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Add Tour Plan</h4>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a onclick=" changeDashboardView();">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Tour Plan</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Tour Plan</h5>
                            </div>
                            <div class="card-body col-12">
                                <form>
                                    <div class="form-group ">
                                        <label for="tourType">Tour Type</label>
                                        <select class="form-control" id="tourType" name="tourType">
                                            <option value="" disabled selected>Select Tour Type</option>
                                            <?php
                                            $rs = Database::search("SELECT * FROM `toure_type`");
                                            $n = $rs->num_rows;
                                            for ($x = 0; $x < $n; $x++) {
                                                $d = $rs->fetch_assoc();
                                                echo "<option value='{$d["id"]}'>{$d["name"]}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="tourTitle">Tour Title</label>
                                        <input type="text" class="form-control" id="tourTitle" name="tourTitle" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tourSubtitle">Tour Subtitle</label>
                                        <input type="text" class="form-control" id="tourSubtitle" name="tourSubtitle">
                                    </div>
                                    <div class="form-group">
                                        <label for="adultPrice">Adult Price (USD)</label>
                                        <input type="number" class="form-control" id="adultPrice" name="adultPrice" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="childrenPrice">Children's Price (USD)</label>
                                        <input type="number" class="form-control" id="childrenPrice" name="childrenPrice">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="maxCount">Maximum Count</label>
                                        <input type="number" class="form-control" id="maxCount" name="maxCount" required>
                                    </div>
                                    
                                    <div class="form-group mb-2">
                                        <label for="images">Add Images</label>
                                        <input type="file" class="form-control-file " id="images" name="images[]" multiple onchange="previewImages()">
                                        <div id="imagePreview" class="mt-3"></div>


                                    </div>
                                    <div class="form-group  mt-3"><button type="button" class="btn btn-danger col-12">Create Tour</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col fs-13 text-muted text-center">
                    &copy; <script>
                        document.write(new Date().getFullYear())
                    </script> - Blaze Tuk-Tuk
                    <span class="text-danger"></span>
                    Design and Developed By
                    <a href="#!" class="text-reset fw-semibold">Malindu Prabod Wm</a> <br>
                    <a> Blaze Tuk Tuk All Rights Reserved</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->



<?php

} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}

?>