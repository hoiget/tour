<style>
  .container90 {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 900px;
    margin: auto;
    display: grid;
   
}
#rent-car-form{
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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

@media (max-width: 768px) {
    .input-group button {
       
       font-size: 10px;
    }
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container90 mt-5">
    <h2 class="text-center mb-4">Thuê Xe</h2>
    <form id="rent-car-form">
       
        <label>Họ tên:</label>
        <input type="text" class="form-control" name="customer_name" value="<?php echo $username; ?>" required >

        <label>Số điện thoại:</label>
        <input type="text" class="form-control" name="customer_phone" value="<?php echo $sdt; ?>" required>

        <label>Email:</label>
        <input type="email" class="form-control" name="customer_email" value="<?php echo $email; ?>">

        <label>Loại xe:</label>
        <select name="vehicle_type" class="form-select" required>
            <option value="4 chỗ">4 chỗ</option>
            <option value="7 chỗ">7 chỗ</option>
            <option value="16 chỗ">16 chỗ</option>
        </select>
        <label>Số ngày thuê:</label>
        <input type="number" id="rental-days" name="rental_days" class="form-control" min="1" required>

        <label>Giá tiền dự kiến (VNĐ):</label>
        <input type="text" id="total-price" name="total-price" class="form-control" readonly>

        <label>Chọn tài xế:</label>
        <div class="input-group">
            <input type="text" id="selected-driver-name" class="form-control" readonly placeholder="Chưa chọn tài xế" style="width:80%">
            <input type="hidden" id="selected-driver-id" name="driver_id">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#driverModal" style="width:20%;height:43px;margin-top:5px">Chọn tài xế</button>
        </div>

        <label>Ngày & Giờ đón:</label>
        <input type="datetime-local" class="form-control" name="pickup_time" required>

        <label>Địa điểm đón:</label>
        <input type="text" class="form-control" name="pickup_location" required>

        <label>Địa điểm đến:</label>
        <input type="text" class="form-control" name="dropoff_location" required>

        <label>Ghi chú:</label>
        <textarea name="notes" class="form-control"></textarea>
        <div style="width: 100%; text-align: center;">
            <button type="submit" class="btn btn-success mt-3" style="width: 200px">Thuê xe ngay</button>
        </div>
    </form>
</div>
<div class="modal fade" id="driverModal" tabindex="-1" aria-labelledby="driverModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Danh sách tài xế</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Họ tên</th>
              <th>Điện thoại</th>
              <th>Loại xe</th>
              <th>Biển số</th>
              <th>Chọn</th>
            </tr>
          </thead>
          <tbody id="driver-list">
            <tr><td colspan="5" class="text-center">Đang tải danh sách tài xế...</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  
  $(document).ready(function () {
   
    const pricePerKm = {
        "4 chỗ": 20000,  
        "7 chỗ": 30000,  
        "16 chỗ": 40000  
    };

    const pricePerDay = 1000000; // Giá tiền mỗi ngày

    // Khi chọn loại xe hoặc nhập số ngày thuê, cập nhật giá tiền
    $("select[name='vehicle_type'], #rental-days").on("input change", function () {
        calculatePrice();
    });

    function calculatePrice() {
        let vehicleType = $("select[name='vehicle_type']").val();
        let rentalDays = parseInt($("#rental-days").val()) || 0;
        let pricePerKmValue = pricePerKm[vehicleType] || 0;

        let totalPrice = (pricePerDay + pricePerKmValue) * rentalDays; // Tính tổng tiền

        $("#total-price").val(totalPrice.toLocaleString("vi-VN") + " VNĐ"); // Hiển thị giá tiền
    }


    // Load danh sách tài xế
    $.ajax({
        url: "./api/api.php?action=get_drivers",
        type: "GET",
        dataType: "json",
        success: function (response) {
            let driverList = $("#driver-list");
            driverList.empty();
            if (Array.isArray(response)) {
                response.forEach(driver => {
                    driverList.append(`
                        <tr>
                            <td>${driver.name}</td>
                            <td>${driver.phone}</td>
                            <td>${driver.vehicle_type}</td>
                            <td>${driver.vehicle_plate}</td>
                            <td>
                                <button class="btn btn-success select-driver" 
                                        data-id="${driver.driver_id}" 
                                        data-name="${driver.name}">
                                    Chọn
                                </button>
                            </td>
                        </tr>
                    `);
                });
            }
        },
        error: function () {
            $("#driver-list").html('<tr><td colspan="5" class="text-center">Không thể tải tài xế</td></tr>');
        }
    });
    $(document).on("click", ".select-driver", function () {
        let driverId = $(this).data("id");
        let driverName = $(this).data("name");

        $("#selected-driver-id").val(driverId);
        $("#selected-driver-name").val(driverName);

        $("#driverModal").modal("hide");
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
                openPopup(response.success || response.error);
                setTimeout(function() {
                            window.location.href = 'index.php?xemxe'; // Chuyển hướng sau 2 giây
                }, 2000);
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