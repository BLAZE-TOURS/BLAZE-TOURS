<div class="content-page mt-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4">Update Tour</h3>
                    <div id="validation-errors1" class="alert alert-danger d-none" role="alert"></div>
                    <div id="success-message1" class="alert alert-success d-none" role="alert"></div>

                    <!-- Section 1: Basic Tour Details -->
                    <h5 class="mb-3">Basic Tour Details</h5>
                    <form id="email-form">
                        <div class="form-group mb-3 d-flex gap-2 align-items-end">
                            <div class="flex-fill" style="flex:2;">
                                <label for="name" class="form-label">Tour Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="flex-fill" style="flex:1; max-width:380px;">
                                <label for="tourType" class="form-label">Tour Type</label>
                                <select class="form-select" id="tourType" name="tourType" required>
                                    <option value="" disabled selected>Select Tour Type</option>
                                    <?php
                                    include '../tour/fetchToursTypeForAdd.php';
                                    foreach ($toursType as $type) {
                                        echo "<option value='{$type['id']}'>{$type['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Description</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="form-group mb-3 d-flex gap-2 align-items-end">
                            <div class="flex-fill">
                                <label for="Duration" class="form-label">Duration</label>
                                <input type="number" class="form-control" id="Duration" name="Duration">
                            </div>
                            <div class="flex-fill">
                                <label for="subject" class="form-label">Kids Price:</label>
                                <input type="number" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="flex-fill">
                                <label for="adult-price" class="form-label">Adult Price:</label>
                                <input type="number" class="form-control" id="adult-price" name="adult-price" required>
                            </div>
                            <div class="flex-fill">
                                <label for="body-title" class="form-label">Maximum People Count</label>
                                <input type="number" class="form-control" id="body-title" name="body-title" required>
                            </div>
                        </div>

                        <!-- Section 2: Time & Highlight -->
                        <div class="row mb-4 mt-4">
                            <div class="col-md-6">
                                <h5>Time Select</h5>
                                <div class="input-group mb-2">
                                    <input type="time" class="form-control" id="tour-time-input">
                                    <button type="button" class="btn btn-outline-primary" id="add-time-btn">Add</button>
                                </div>
                                <ul class="list-group" id="time-list"></ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Add Highlight</h5>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="highlight-input" placeholder="Enter highlight">
                                    <button type="button" class="btn btn-outline-success" id="add-highlight-btn">Add</button>
                                </div>
                                <ul class="list-group" id="highlight-list"></ul>
                            </div>
                        </div>

                        <!-- Section 3: Image Add -->
                        <div class="row mb-4">
                            <h5>Images</h5>
                            <div class="col-md-6 mb-2">
                                <label for="main-image" class="form-label">Main Image</label>
                                <input type="file" class="form-control" id="main-image" accept="image/*">
                                <div id="main-image-preview" class="mt-2"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="second-image" class="form-label">Second Image</label>
                                <input type="file" class="form-control" id="second-image" accept="image/*">
                                <div id="second-image-preview" class="mt-2"></div>
                            </div>
                        </div>

                        <!-- Section 4: Add Location -->
                        <div class="mb-4">
                            <h5>Add Location</h5>
                            <div class="border rounded p-3 text-muted" style="min-height:60px;">Location section placeholder</div>
                        </div>

                        <!-- Section 5: Update Button -->
                        <div id="loading-spinner1" class="d-none">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addTourBtn" class="btn btn-primary col-12 mt-3 mx-auto d-block btn-animate" style="font-size:1.3rem; padding: 0.75rem 0;">Update Tour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS for dynamic add/remove and image preview -->
<script>
// Time add/remove
let times = [];
const timeInput = document.getElementById('tour-time-input');
const timeList = document.getElementById('time-list');
document.getElementById('add-time-btn').onclick = function() {
    if (timeInput.value && !times.includes(timeInput.value)) {
        times.push(timeInput.value);
        renderTimeList();
        timeInput.value = '';
    }
};
function renderTimeList() {
    timeList.innerHTML = '';
    times.forEach((t, i) => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.textContent = t;
        const btn = document.createElement('button');
        btn.className = 'btn btn-sm btn-danger';
        btn.textContent = 'Remove';
        btn.onclick = () => { times.splice(i,1); renderTimeList(); };
        li.appendChild(btn);
        timeList.appendChild(li);
    });
}
// Highlight add/remove
let highlights = [];
const highlightInput = document.getElementById('highlight-input');
const highlightList = document.getElementById('highlight-list');
document.getElementById('add-highlight-btn').onclick = function() {
    if (highlightInput.value.trim() && !highlights.includes(highlightInput.value.trim())) {
        highlights.push(highlightInput.value.trim());
        renderHighlightList();
        highlightInput.value = '';
    }
};
function renderHighlightList() {
    highlightList.innerHTML = '';
    highlights.forEach((h, i) => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.textContent = h;
        const btn = document.createElement('button');
        btn.className = 'btn btn-sm btn-danger';
        btn.textContent = 'Remove';
        btn.onclick = () => { highlights.splice(i,1); renderHighlightList(); };
        li.appendChild(btn);
        highlightList.appendChild(li);
    });
}
// Image preview and remove
function handleImagePreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    input.onchange = function() {
        preview.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '120px';
                img.style.maxHeight = '120px';
                img.className = 'me-2 mb-2 rounded shadow-sm';
                const rmBtn = document.createElement('button');
                rmBtn.className = 'btn btn-sm btn-danger ms-2';
                rmBtn.textContent = 'Remove';
                rmBtn.onclick = function() {
                    input.value = '';
                    preview.innerHTML = '';
                };
                preview.appendChild(img);
                preview.appendChild(rmBtn);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
}
handleImagePreview('main-image', 'main-image-preview');
handleImagePreview('second-image', 'second-image-preview');
</script>

<style>
.content-page {
    animation: fadeIn 1s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.btn-animate {
    transition: background-color 0.3s, transform 0.3s;
}
.btn-animate:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}
.card {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}
.form-control {
    border-radius: 0.25rem;
}
.form-label {
    font-weight: bold;
}
#main-image-preview img, #second-image-preview img {
    border: 1px solid #ddd;
    margin-bottom: 4px;
}
</style>



