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
                <label for="itinerary" class="form-label">Lịch Trình</label>
                <textarea class="form-control" id="itinerary" name="itinerary" rows="4" required></textarea>
            </div>

            <!-- Thời Gian Tour -->
            <div class="mb-3">
                <label for="tour_duration" class="form-label">Thời Gian Tour</label>
                <select class="form-control" id="tour_duration" name="tour_duration" required>
                    <option value="1 Ngày">1 Ngày</option>
                    <option value="2 Ngày 1 Đêm">2 Ngày 1 Đêm</option>
                    <option value="3 Ngày 2 Đêm">3 Ngày 2 Đêm</option>
                    <option value="4 Ngày 3 Đêm">4 Ngày 3 Đêm</option>
                </select>
            </div>

            <!-- Nút Submit -->
            <button type="submit" id="button" class="btn btn-primary w-100">Gửi Yêu Cầu</button>

        </form>
        <br><br>
    </div>

    <script>
 function guitouryeucau() {
        

        $.ajax({
            url: './api/api.php',
            type: 'POST',
            data: $('#guitouryeucau').serialize(),
            success: function(response) {
                  console.log(response);
                  if (response === 'Phản hồi của bạn đã được gửi thành công!') {
                      openPopup('Thông báo', 'Phản hồi của bạn đã được gửi thành công!');
                      setTimeout(function() {
                          window.location.href = 'index.php?custom_tour'; // Chuyển hướng sau 2 giây
                      }, 2000);
                  }else{
                      openPopup('Lỗi', 'Có lỗi xảy ra');
                  }   
                  
              }
        });
    }

    // Gọi hàm gửi tin nhắn khi nhấn nút gửi
    $('#button').on('click', function (e) {
        e.preventDefault();
        guitouryeucau();
    });
</script>
