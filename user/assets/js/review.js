document.addEventListener("DOMContentLoaded", function () {
    const tourId = window.location.search.match(/id=(\d+)/) ? RegExp.$1 : 0;
    const reviewList = document.querySelector(".comment-list");
    const reviewCount = document.querySelector(".blog-inner-title.h4");
    const submitBtn = document.querySelector(".th-comment-form .th-btn");
    const nameInput = document.querySelector('.th-comment-form input[placeholder="Full Name*"]');
    const emailInput = document.querySelector('.th-comment-form input[placeholder="Your Email*"]');
    const ratingInput = document.getElementById("rating");
    const commentInput = document.querySelector('.th-comment-form textarea');
    const notyf = new Notyf({ position: { x: 'center', y: 'top' } });

    // Load reviews
    function loadReviews() {
        fetch(`assets/process/fetchReview.php?tour_id=${tourId}`)
            .then(res => res.json())
            .then(data => {
                reviewList.innerHTML = "";
                reviewCount.textContent = `Reviews (${data.length})`;
                data.forEach(r => {
                    let starsHtml = "";
                    for (let i = 1; i <= 5; i++) {
                        starsHtml += `<i class="fa-solid fa-star" style="color:${i<=r.stars?'#FFD700':'#ccc'}"></i>`;
                    }
                    reviewList.innerHTML += `
                        <li class="th-comment-item">
                            <div class="th-post-comment">
                                <div class="comment-avater">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(r.name)}&background=0D8ABC&color=fff&size=64" alt="Comment Author">
                                </div>
                                <div class="comment-content">
                                    <div>
                                        <h3 class="name">${r.name}</h3>
                                        <div class="commented-wrapp">
                                            <span class="commented-on">${r.date}</span>
                                            <span class="commented-time">${r.time}</span>
                                            <span class="comment-review">${starsHtml}</span>
                                        </div>
                                    </div>
                                    <p class="text">${r.comment}</p>
                                </div>
                            </div>
                        </li>
                    `;
                });
            });
    }
    loadReviews();

    // Submit review
    submitBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const rating = ratingInput.value;
        const comment = commentInput.value.trim();

        if (!name || !email || !comment || !rating) {
            notyf.error("All fields are required!");
            return;
        }
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            notyf.error("Invalid email address!");
            return;
        }

        fetch("assets/process/addReviewProcess.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                name, email, comment, rating, tour_id: tourId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                notyf.success("Review submitted successfully!");
                nameInput.value = "";
                emailInput.value = "";
                ratingInput.value = "5";
                commentInput.value = "";
                loadReviews();
            } else {
                notyf.error(data.error || "Failed to submit review!");
            }
        })
        .catch(() => {
            notyf.error("Server error!");
        });
    });
});