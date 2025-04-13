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
            <div class="mb-3">
                <label for="phuongtien" class="form-label">Tài xế</label>
                <div id="tx"></div>
            </div>
            <div class="mb-3">
            <label for="phuongtien" class="form-label">Khách sạn</label>
                <div id="ks"></div>
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
        <input type="number" id="days" placeholder="" style="width: 50px; border-radius: 5px; border: 1px solid black;"> ngày
        <input type="number" id="nights" placeholder="" style="width: 50px; border-radius: 5px; border: 1px solid black;"> đêm
    </span>
    <input type="hidden" name="tour_duration" id="tour_duration">
</div>


            <!-- Nút Submit -->
            <div style="width: 100%; text-align: center;">
                <button type="submit" id="button" class="btn btn-primary">Gửi Yêu Cầu</button>
            </div>
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
   
function xemtaixe(phuongtien = '') {
    $.ajax({
        url: './api/api.php?action=xemtaixe&phuongtien=' + encodeURIComponent(phuongtien),
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var eventHtml = '<select class="form-control" id="taixe" name="taixe" required>';
                eventHtml += '<option value="">Chọn tài xế</option>'; // Tuỳ chọn mặc định

                response.forEach(function(event) {
                    eventHtml += `<option value="${event.driver_id}">${event.name}</option>`;
                });

                eventHtml += '</select>';
                $('#tx').html(eventHtml);
            } else {
                $('#tx').html('<div class="col">Không tìm thấy tài xế phù hợp.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#tx').html('<div class="col">Đã xảy ra lỗi khi tải thông tin tài xế.</div>');
        }
    });
}

// Gọi lại xemtaixe() khi chọn phương tiện
$('#phuongtien').on('change', function() {
    let selectedPhuongTien = $(this).val();
    xemtaixe(selectedPhuongTien);
});

// Gọi API lần đầu khi trang tải
$(document).ready(function () {
    xemks();
    xemtaixe($('#phuongtien').val());
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
                }else if(response.trim() === 'empty'){
                    openPopup('Thông báo', 'Thiếu dữ liệu!');
                } 
                else {
                    openPopup('Lỗi', );
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
<script>
    $(document).ready(function () {
    // Lắng nghe khi nhập tên tour
    $('#tour_name').on('input', function () {
        let tourName = $(this).val().trim(); // Lấy giá trị nhập vào
        if (tourName.length > 2) { // Chỉ tìm kiếm nếu nhập ít nhất 3 ký tự
            let diaDiem = layDiaDiem(tourName); // Hàm trích xuất địa điểm từ tên tour
            if (diaDiem) {
                xemks(diaDiem); // Gọi API tìm khách sạn theo địa điểm
            }
        }
    });
});

// Hàm trích xuất địa điểm từ tên tour (ví dụ: "Tour Đà Nẵng 3N2Đ" -> "Đà Nẵng")
function layDiaDiem(tourName) {
    let regex = /\b([\p{L}]+(?:\s[\p{L}]+)?)\b/ui; // Lấy đúng 2 từ đầu tiên
    let match = tourName.match(regex);
    return match ? match[1].trim() : null;
}

// Hàm lấy danh sách khách sạn theo địa điểm
function xemks(diaDiem = '') {
    $.ajax({
    url: `./api/api.php?action=xemkss&diadiem=${encodeURIComponent(diaDiem)}`,
    type: 'GET',
    dataType: 'json',
    success: function (response) {
        if (Array.isArray(response) && response.length > 0) {
            let eventHtml = '<select class="form-control" id="khachsan" name="khachsan" required>';
            eventHtml += '<option value="">Chọn khách sạn</option>'; // Tuỳ chọn mặc định

            response.forEach(function (event) {
                eventHtml += `<option value="${event.id}">${event.Name} - ${event.Diadiem}</option>`;
            });

            eventHtml += '</select>';
            $('#ks').html(eventHtml);
        } else {
            $('#ks').html('<div class="col">Không tìm thấy khách sạn phù hợp.</div>');
        }
    },
    error: function (xhr, status, error) {
        console.error('Lỗi khi tải thông tin khách sạn:', xhr.responseText);
        $('#ks').html(`<div class="col text-danger">Lỗi: ${xhr.status} - ${xhr.statusText}<br>${xhr.responseText}</div>`);
    }
});

}

</script>