<style>
    .container9{
        background-color: #f5f5f5;
        color:black;
        width: 100%;

    }
    h2{
        color:black;
    }
    .guitour{
        width: 80%;
        margin: auto;
    }
</style>

    <div class="container9 mt-5">
    <br><br>
        <h2 class="text-center">Đặt Tour Theo Yêu Cầu</h2>
       
        <form id="guitouryeucau" class="guitour" action="./api/api.php" method="post">
                <input type="hidden" name="action" value="guitouryeucau">
            <!-- ID Khách Hàng -->
            <div hidden class="mb-3 ">
                <label for="user_id" class="form-label">ID Khách Hàng</label>
                <input  type="number" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id; ?>" required>
            </div>

            <!-- Tên Khách Hàng -->
            <div class="mb-3">
                <label for="customer_name" class="form-label">Tên Khách Hàng</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $username; ?>" required>
            </div>

            <!-- Tên Tour -->
            <div class="mb-3">
                <label for="tour_name" class="form-label">Tên Tour</label>
                <input type="text" class="form-control" id="tour_name" name="tour_name" required>
            </div>

            <!-- Ngày Khởi Hành -->
            <div class="mb-3">
                <label for="departure_date" class="form-label">Ngày Khởi Hành</label>
                <input type="date" class="form-control" id="departure_date" name="departure_date" required>
            </div>
            <div class="mb-3">
                <label for="phuongtien" class="form-label">Phương tiện di chuyển</label>
                <select class="form-control" id="phuongtien" name="phuongtien" required>
                    <option value="Xe khách">Xe khách</option>
                    <option value="Du thuyền">Du thuyền</option>
                    <option value="Máy bay">Máy bay</option>
                  
                </select>
            </div>
            <!-- Giá Tour -->
            <div class="mb-3">
                <label for="tour_price" class="form-label">Giá Tour (VND)</label>
                <input type="number" class="form-control" id="tour_price" name="tour_price" required>
            </div>

            <!-- Lịch Trình -->
            <div class="mb-3">
            <div id="itinerary-container"></div>

            <!-- Ô nhập liệu ẩn để chứa toàn bộ lịch trình dạng JSON -->
            <textarea id="itinerary" name="itinerary" hidden></textarea>
            </div>

            <!-- Thời Gian Tour -->
       <!-- Thời Gian Tour -->
<div class="mb-3">
    <label for="tour_duration" class="form-label">Thời Gian Tour</label>
    <span>
        <input type="number" id="days" placeholder="Số ngày"> ngày
        <input type="number" id="nights" placeholder="Số đêm"> đêm
    </span>
    <input type="hidden" name="tour_duration" id="tour_duration">
</div>


            <!-- Nút Submit -->
            <button type="submit" id="button" class="btn btn-primary w-100">Gửi Yêu Cầu</button>

        </form>
        <br><br>
    </div>

    <script>

$(document).ready(function () {
    // Khi nhập số ngày, tự động tạo các ô nhập liệu lịch trình
    $("#days").on("input", function () {
        let days = parseInt($(this).val()) || 0;
        let itineraryContainer = $("#itinerary-container");

        itineraryContainer.empty(); // Xóa nội dung cũ

        for (let i = 1; i <= days; i++) {
            itineraryContainer.append(`
                <div class="mb-3">
                    <label for="itinerary_day_${i}" class="form-label">Lịch trình Ngày ${i}:</label>
                    <textarea class="form-control" id="itinerary_day_${i}" name="itinerary_day_${i}" rows="3" required></textarea>
                </div>
            `);
        }
    });

    // Hàm gửi form
    function guitouryeucau() {
        let days = $("#days").val();
        let nights = $("#nights").val();
        let duration = days + " ngày " + nights + " đêm";
        $("#tour_duration").val(duration);

        // Gom dữ liệu lịch trình thành chuỗi JSON
        let itineraryData = {};
        for (let i = 1; i <= days; i++) {
            itineraryData[`Ngày ${i}`] = $(`#itinerary_day_${i}`).val();
        }
        $("#itinerary").val(JSON.stringify(itineraryData)); // Lưu dưới dạng JSON

        // Gửi form bằng AJAX
        $.ajax({
            url: './api/api.php',
            type: 'POST',
            data: $('#guitouryeucau').serialize(),
            success: function (response) {
                console.log(response);
                if (response.trim() === 'Phản hồi của bạn đã được gửi thành công!') {
                    openPopup('Thông báo', 'Phản hồi của bạn đã được gửi thành công!');
                    setTimeout(function () {
                        window.location.href = 'index.php?custom_tour';
                    }, 2000);
                } else {
                    openPopup('Lỗi', response);
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX:", status, error);
                openPopup("Lỗi", "Không thể gửi yêu cầu. Vui lòng thử lại!");
            }
        });
    }

    // Gửi form khi nhấn nút
    $('#button').on('click', function (e) {
        e.preventDefault();
        guitouryeucau();
    });
});
</script>
