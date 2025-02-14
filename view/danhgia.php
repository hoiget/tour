
    <style>
        h3,h5{
            color:black;
        }
        .stars {
            display: flex;
            cursor: pointer;
        }

        .star {
            font-size: 2rem;
            color: #ccc;
        }

        .star.selected {
            color: #f39c12;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>

    <!-- Nút mở modal -->
    <div class="text-center mt-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ratingModal">
            Đánh giá Tour
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ratingModalLabel">Đánh giá Tour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="danhgiatour" action="./api/api.php" method="post">
                        <input type="hidden" name="action" value="danhgiatour">
                        <input type="hidden" name="star" id="star-value" value="">
                        <div id="dg"></div>
                        <div class="rating-container">
                            <div class="stars">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                            </div>
                        </div>
                        <div class="comment-box">
                            <textarea id="review" name="review" placeholder="Nhập bình luận của bạn..."></textarea>
                        </div>
                        <button type="submit" id="submit-btn" class="btn btn-success w-100" disabled>Gửi đánh giá</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Chọn sao
        const stars = document.querySelectorAll('.star');
        const reviewInput = document.getElementById('review');
        const submitBtn = document.getElementById('submit-btn');
        let selectedRating = 0;

        stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => {
                stars.forEach((s, i) => s.classList.toggle('selected', i <= index));
            });

            star.addEventListener('mouseout', () => {
                stars.forEach((s, i) => s.classList.toggle('selected', i < selectedRating));
            });

            star.addEventListener('click', () => {
                selectedRating = index + 1;
                stars.forEach((s, i) => s.classList.toggle('selected', i < selectedRating));
                document.getElementById('star-value').value = selectedRating; // Cập nhật giá trị
                checkFormValidity();
            });
        });

        // Kiểm tra form
        reviewInput.addEventListener('input', checkFormValidity);

        function checkFormValidity() {
            submitBtn.disabled = !(selectedRating > 0 && reviewInput.value.trim().length > 0);
        }

        // Gửi form
        document.querySelector('#danhgiatour').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('./api/api.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        openPopup(data.message, '');
                        
                        reviewInput.value = '';
                        selectedRating = 0;
                        stars.forEach(s => s.classList.remove('selected'));
                        submitBtn.disabled = true;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                        modal.hide();
                       
                        setTimeout(function() {
                            window.location.href = 'index.php?xemdattour'; // Chuyển hướng sau 2 giây
                        }, 3000);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Load thông tin tour
        function laythongtindanhgia() {
            const urlParams = new URLSearchParams(window.location.search);
            const idtour = urlParams.get('danhgia');

            fetch(`./api/api.php?action=laythongtindanhgia&danhgia=${idtour}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data[0]) {
                        document.getElementById('dg').innerHTML = `
                            <h5>Tên tour: ${data[0].Tour_name}</h5>
                            <input type="hidden" name="tour" value="${data[0].Tour_id}">
                            <input type="hidden" name="booking" value="${data[0].Booking_id}">
                        `;
                    } else {
                        document.getElementById('dg').innerHTML = 'Không tìm thấy tour';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', laythongtindanhgia);
    </script>

