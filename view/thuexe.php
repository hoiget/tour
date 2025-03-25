<style>
  .container90 {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    width: 50%;
    margin: auto;
}

.container90 label {
    font-weight: bold;
    margin-top: 10px;
}

.container90 input, .container90 select, .container90 textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.container90 button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.container90 button:hover {
    background-color: #218838;
}

.error-msg {
    color: red;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}
ul li a {
    text-decoration: none !important;
}
a{
    text-decoration: none !important;
}
ul li a:hover {
    text-decoration: none !important;
}


</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container90 mt-5">
    <h2 class="text-center mb-4">Thuê Xe</h2>
    <form id="rent-car-form">
        <label>Họ tên:</label>
        <input type="text" class="form-control" name="customer_name" required>

        <label>Số điện thoại:</label>
        <input type="text" class="form-control" name="customer_phone" required>

        <label>Email:</label>
        <input type="email" class="form-control" name="customer_email">

        <label>Loại xe:</label>
        <select name="vehicle_type" class="form-select" required>
            <option value="4 chỗ">4 chỗ</option>
            <option value="7 chỗ">7 chỗ</option>
            <option value="16 chỗ">16 chỗ</option>
        </select>

        <label>Chọn tài xế:</label>
        <select name="driver_id" id="driver-select" class="form-select" required>
            <option value="">Đang tải danh sách tài xế...</option>
        </select>

        <label>Ngày & Giờ đón:</label>
        <input type="datetime-local" class="form-control" name="pickup_time" required>

        <label>Địa điểm đón:</label>
        <input type="text" class="form-control" name="pickup_location" required>

        <label>Địa điểm đến:</label>
        <input type="text" class="form-control" name="dropoff_location" required>

        <label>Ghi chú:</label>
        <textarea name="notes" class="form-control"></textarea>

        <button type="submit" class="btn btn-success mt-3">Thuê xe ngay</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  
  $(document).ready(function () {
    // Load danh sách tài xế
    $.ajax({
        url: "./api/api.php?action=get_drivers",
        type: "GET",
        dataType: "json",
        success: function (response) {
            let driverSelect = $("#driver-select");
            driverSelect.html('<option value="">Chọn tài xế</option>');
            if (Array.isArray(response)) {
                response.forEach(driver => {
                    driverSelect.append(`<option value="${driver.driver_id}">${driver.name} - ${driver.vehicle_type}</option>`);
                });
            }
        },
        error: function () {
            $("#driver-select").html('<option value="">Không thể tải tài xế</option>');
        }
    });

    // Kiểm tra số điện thoại ngay khi nhập
    $("input[name='customer_phone']").on("input", function () {
        let phone = $(this).val().trim();
        let phoneRegex = /^0\d{9}$/;
        if (!phoneRegex.test(phone)) {
            showError($(this), "Số điện thoại không hợp lệ! Phải bắt đầu bằng 0 và có đúng 10 chữ số.");
        } else {
            hideError($(this));
        }
    });

    // Kiểm tra email ngay khi nhập
    $("input[name='customer_email']").on("input", function () {
        let email = $(this).val().trim();
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) {
            showError($(this), "Email không hợp lệ! Hãy nhập đúng định dạng (ví dụ: example@gmail.com).");
        } else {
            hideError($(this));
        }
    });

    // Kiểm tra ngày & giờ đón ngay khi chọn
    $("input[name='pickup_time']").on("change", function () {
        let pickupTime = new Date($(this).val());
        let currentTime = new Date();
        if (pickupTime <= currentTime) {
            showError($(this), "Ngày & giờ đón phải sau thời điểm hiện tại.");
        } else {
            hideError($(this));
        }
    });

    // Xử lý gửi form
    $("#rent-car-form").submit(function (e) {
        e.preventDefault();

        // Nếu còn lỗi thì không gửi form
        if ($(".error-msg:visible").length > 0) {
            alert("Vui lòng kiểm tra lại thông tin!");
            return;
        }

        let formData = $(this).serialize() + "&action=rent_car";
        $.ajax({
            url: "./api/api.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                alert(response.success || response.error);
            },
            error: function () {
                alert("Lỗi khi đặt xe!");
            }
        });
    });

    // Hàm hiển thị lỗi
    function showError(element, message) {
        let errorLabel = element.next(".error-msg");
        if (errorLabel.length === 0) {
            element.after(`<span class="error-msg" style="color:red; font-size:12px;">${message}</span>`);
        } else {
            errorLabel.text(message);
        }
    }

    // Hàm ẩn lỗi
    function hideError(element) {
        element.next(".error-msg").remove();
    }
});


</script>