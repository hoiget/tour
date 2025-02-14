<?php


require_once('./tcpdf/tcpdf.php'); // Đảm bảo thư viện TCPDF đã được tải lên
require_once('./api/connect.php'); // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Booking_id'])) {
    $bookingId = $_POST['Booking_id'];

    // Lấy dữ liệu từ bảng booking_ordertour
    $queryOrder = "SELECT * FROM booking_orderks WHERE Booking_id = ?";
    $stmtOrder = $conn->prepare($queryOrder);
    $stmtOrder->bind_param("s", $bookingId);
    $stmtOrder->execute();
    $resultOrder = $stmtOrder->get_result();

    if ($resultOrder->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Booking not found.']);
        exit;
    }

    $orderData = $resultOrder->fetch_assoc();

    // Lấy dữ liệu từ bảng booking_detail_tour
    $queryDetails = "SELECT * FROM booking_details_ks WHERE Booking_id = ?";
    $stmtDetails = $conn->prepare($queryDetails);
    $stmtDetails->bind_param("s", $bookingId);
    $stmtDetails->execute();
    $resultDetails = $stmtDetails->get_result();

    $details = [];
    while ($row = $resultDetails->fetch_assoc()) {
        $details[] = $row;
    }

    // Khởi tạo đối tượng TCPDF
    $pdf = new TCPDF();
    $pdf->SetFont('dejavusans', '', 12); // 'dejavusans' là phông chữ hỗ trợ tiếng Việt
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Room Booking System');
    $pdf->SetTitle('Booking Details');
    $pdf->SetHeaderFont(array('dejavusans', '', 12)); // Phông chữ cho phần header
    $pdf->SetHeaderData('', 0, 'Chi tiết đặt phòng', '', array(0,64,255), array(0,64,128));
    $pdf->SetMargins(15, 27, 15); // Lề
    $pdf->AddPage();
   

    // Nội dung PDF
    $html = '<h1>Chi tiết đặt phòng</h1>';
    $html .= '<h3>Thông tin chính:</h3>';
    $html .= '<p><strong>Booking ID:</strong> ' . $orderData['Booking_id'] . '</p>';
    $html .= '<p><strong>Ngày nhận phòng:</strong> ' . $orderData['Check_in'] . '</p>';
    $html .= '<p><strong>Ngày trả phòng:</strong> ' . $orderData['Check_out'] . '</p>';
    $html .= '<p><strong>Thời gian đặt:</strong> ' . $orderData['Datetime'] . '</p>';

    $html .= '<h3>Chi tiết phòng:</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên phòng</th>
                        <th>Giá</th>
                        <th>Tổng thanh toán</th>
                        <th>Người đặt</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($details as $index => $detail) {
        $html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . $detail['room_name'] . '</td>
                    <td>' . number_format($detail['price'], 0, ',', '.') . ' VNĐ </td>
                    <td>' . number_format($detail['total_pay'], 0, ',', '.') . ' VNĐ </td>
                    <td>' . $detail['user_name'] . '</td>
                    <td>' . $detail['phonenum'] . '</td>
                    <td>' . $detail['address'] . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Viết nội dung vào PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    ob_end_clean(); // Dọn dẹp bộ đệm đầu ra trước khi gửi PDF
    // Xuất file PDF
    $pdf->Output('booking_details_room_' . $bookingId . '.pdf', 'D'); // 'D' để tải file xuống
  
    exit; // Dừng tiến trình PHP sau khi xuất PDF
}
?>

<style>

.main{
    background-color: #f9f9f9;
}
.container6 {
    width: 90%;
    max-width: 1200px;
    margin: 20px auto;
   
}

h1 {
    text-align: center;
    color: #333;
}

.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: left;
}

.card h3 {
    margin: 0 0 10px;
    color: #333;
}

.card p {
    margin: 5px 0;
    font-size: 14px;
    color: #555;
}

.btn {
    display: inline-block;
    margin: 5px 5px 0 0;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
}
.exportPdfBtn{
  display: inline-block;
    margin: 5px 5px 0 0;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    width: 99%;
}
.btn.cancel {
    background-color: #e74c3c;
    color: #fff;
}
.exportPdfBtn {
    background-color: #3498db;
    color: #fff;
}

.btn.detail {
    background-color: #000;
    color: #fff;
}

.btn.pdf {
    background-color: #3498db;
    color: #fff;
}

.btn.review {
    background-color: #2ecc71;
    color: #fff;
}

.btn:hover {
    opacity: 0.9;
}

.container4 {
  max-width: 800px;
  margin: 0 auto;
  font-family: Arial, sans-serif;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background:white;
}

h2, h3,label {
  text-align: center;
  color:black;
}

form {
  display: grid;
  gap: 10px;
}

label {
  font-weight: bold;
}

input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%; /* Để input tự căn chỉnh kích thước */
}

button {
  display: inline-block;
  padding: 12px 20px;
  font-size: 16px;
  font-weight: bold;
  color: #fff;
  background-color: black;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin-left: 20px;
}

button:hover {
  background-color: #0056b3;
}

/* Styling cho 2 input nằm chung một dòng */
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr; /* 2 cột bằng nhau */
  gap: 10px; /* Khoảng cách giữa các cột */
}

.form-row label {
  margin-bottom: 5px; /* Căn chỉnh khoảng cách giữa label và input */
}
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
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ratingModalLabel">Đánh giá phòng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="danhgiaks" action="./api/api.php" method="post">
                        <input type="hidden" name="action" value="danhgiaks">
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
<br><br>

    <div class="container6">
        <h1>TRẠNG THÁI ĐƠN</h1>
        
            
          <div id="xemtrangthaiks"></div>
            <!-- Thêm các thẻ card khác theo nhu cầu -->
        
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function xemtrangthai() {
    $.ajax({
        url: './api/api.php?action=xemtrangthaiks',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event, index) {
                    if (index % 3 === 0) {
                        eventHtml += '<div class="card-container">';
                    }
                    eventHtml += `
                    <div class="card">
                <h3>${event.user_name}</h3>
                <p><strong>Giá tour:</strong> ${event.price}</p>
                <p><strong>Tổng tiền:</strong> ${event.total_pay}</p>
                <p><strong>Mã đơn:</strong> ${event.Booking_id}</p>
                <p><strong>Ngày bắt đầu:</strong> ${event.Check_in}</p>
                <p><strong>Ngày kết thúc:</strong> ${event.Check_out}</p>
                 `
                 if(event.Payment_status == '1'){
                    
                    eventHtml +=' <p><strong>TT thanh toán:</strong> Chưa thanh toán</p>'
                 }else if(event.Payment_status == '2'){
                    eventHtml +=' <p><strong>TT thanh toán:</strong> Đã thanh toán</p>'
                    eventHtml +='<p><strong>Thời gian thanh toán:</strong> 2024-12-04 15:45:11</p>'
                 }
                 
                 if(event.Refund == '0'){
                    
                     eventHtml +=' <button class="btn cancel" onclick="huydonks('+event.Booking_id+')">Hủy đơn</button>'
                    if(event.Booking_status == '1'){
                    
                        eventHtml +=' <button class="btn review">Chưa xác nhận</button>'
                    }else if(event.Booking_status == '2'){
                        eventHtml +=' <button class="btn review">Đã xác nhận</button>'
                        if(event.Payment_status == '2'){
                          eventHtml +='<button type="button" class="btn review" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('+event.Booking_id +')">Đánh giá phòng</button>'
                   
                 }else{
                  eventHtml +=' <button class="btn review" ><a style="text-decoration:none;color:white" href="index.php?idttks='+event.Booking_id +'">Thanh toán</a></button>'

                 }
                 eventHtml += `
                    <div>
                        <input type="hidden" id="bookingIdInput_${index}" value="${event.Booking_id}" readonly>
                        <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button>
                    </div>
                `;
                    }
                    
                   
                 }else if(event.Refund == '1'){
                    eventHtml +='  <button class="btn cancel">Đã hủy</button>'
                    if(event.Payment_status == '2'){
                        eventHtml +=' <button class="btn review">Chưa hoàn tiền</button>'
                        
                 }
                 }
              
                eventHtml +=`
                <a href="#" id="btn detail" class="btn btn-dark view-details" data-id="${event.Booking_id}">Xem chi tiết</a>
            </div>
                        
                         `
                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtrangthaiks').html(eventHtml);
                $('.view-details').on('click', function(e) {
                    e.preventDefault();
                    var newsId = $(this).data('id');
                    view_news_details(newsId);
                });
            } else {
                $('#xemtrangthaiks').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemtrangthaiks').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function huydonks(idve) {
        // Gửi yêu cầu đến api.php để cập nhật trạng thái
        fetch('./api/api.php?action=huydonks&id=' + idve)
            .then(response => response.text())
            .then(data => {
                
                if (data === 'gui') {
                    // Chuyển hướng người dùng sau khi cập nhật thành công
                    openPopup('Hủy đơn thành công', '');
                    setTimeout(function() {
                        window.location.href = 'index.php?xemdatks';
                    }, 1000);
                } else {
                    openPopup('Cập nhật không thành công','');
                }
            })
            .catch(error => console.error('Lỗi:', error));
    }

    function view_news_details(id) {
    $.ajax({
      url: './api/api.php?action=xemtrangthaikschitiet&id=' + id,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response && response.length > 0) {
          var item = response[0];
          var detailsHtml = `
            <a href="index.php?xemdatks" class="btn btn-secondary">Trở Lại</a>
            <div class="container4">
  <h2>THÔNG TIN ĐẶT TOUR</h2>

<form class="my-form" id="dattourfull" action="./api/api.php" method="get"> 
    <input type="hidden" name="action" value="dattourfull">
  <div class="user-info">
    <h3>Thông tin người dùng</h3>
    <form>
          <div class="form-row">
        <div>
          <label for="fullname">Tên tài khoản:</label>
          <input type="text" id="fullname" name="fullname" value="${item.user_name}" readonly>
        </div>
        <div>
          <label for="phone">Số điện thoại:</label>
          <input type="text" id="phone" name="phone" value="${item.phonenum}" readonly>
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="address">Địa chỉ:</label>
          <input type="text" id="address" name="address" value="${item.address}" readonly>
        </div>
      </div>
     
    
  </div>

  <!-- Thông tin tour -->
  <div class="tour-info">
    <h3>Thông tin tour</h3>
   
       <div class="form-row">
        <div>
          <label for="tour-code">Mã phòng:</label>
          <input type="text" id="tour-code" name="tour_id" value="${item.room_no}" readonly>
        </div>
        <div>
          <label for="tour-name">Tên phòng:</label>
          <input type="text" id="tour-name" name="tour_name" value="${item.room_name}" readonly>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="departure-date">Thời gian bắt đầu:</label>
          <input type="date" id="ns" name="ns" value="${item.Check_in}">
        </div>
        <div>
          <label for="duration">Thời gian kết thúc:</label>
          <input type="text" id="duration" name="duration" value="${item.Check_out}" min="1" readonly>
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="arrival">Ngày đặt phòng:</label>
          <input type="text" id="arrival" name="arrival" value="${item.Datetime}" min="1" readonly>
        </div>
        
      </div>
    
  </div>

  <!-- Thông tin thành viên tham gia -->
  <div class="pricing-info">
 <h3>Thông tin giá</h3>
      <div class="form-row">
        <div>
        <label for="total-price">Gía vé:</label>
        <input type="text" id="price" name="price" value="${item.price}" readonly>

        </div>
        <div>
        
          <label for="total-price">Tổng tiền:</label>
        <input type="text" id="total-price" name="total-price" value="${item.total_pay}" readonly>
        </div>
      </div>
   
  </div> 
`;
          $('#xemtrangthaiks').html(detailsHtml); // Replace the news section with the detailed view
        } else {
          $('#xemtrangthaiks').html('<div class="col">Không tìm thấy bài viết chi tiết.</div>');
        }
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi lấy chi tiết:', error);
        $('#xemtrangthaiks').html('<div class="col">Đã xảy ra lỗi khi tải chi tiết bài viết.</div>');
      }
    });
  }
$(document).ready(function() {
    xemtrangthai();
});
</script>

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
    document.querySelector('#danhgiaks').addEventListener('submit', function (e) {
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
                        window.location.href = 'index.php?xemdatks'; // Chuyển hướng sau 2 giây
                    }, 2000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Load thông tin tour
    function openRatingModal(roomId) {
        // Lấy thông tin tour và hiển thị trong modal
        fetch(`./api/api.php?action=laythongtindanhgiaks&danhgiaks=${roomId}`)
            .then(response => response.json())
            .then(data => {
                if (data && data[0]) {
                    document.getElementById('dg').innerHTML = `
                        <h5>Tên phòng: ${data[0].room_name}</h5>
                        <input type="hidden" name="username" value="${data[0].user_name}">
                        <input type="hidden" name="room" value="${data[0].Room_id}">
                        <input type="hidden" name="booking" value="${data[0].Booking_id}">
                    `;
                } else {
                    document.getElementById('dg').innerHTML = 'Không tìm thấy room';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', laythongtindanhgia);
</script>

<script>
$(document).on('click', '.exportPdfBtn', function () {
    const bookingId = $(this).data('booking-id'); // Lấy Booking ID từ data attribute

    if (!bookingId) {
        alert('Không tìm thấy Booking ID.');
        return;
    }

    // Gửi yêu cầu POST để xuất PDF
    const form = $('<form>', {
        action: '',
        method: 'POST',
        target: '_blank'  // Tải PDF trong tab mới
    });

    form.append($('<input>', {
        type: 'hidden',
        name: 'Booking_id',
        value: bookingId
    }));

    $('body').append(form);
    form.submit(); // Gửi yêu cầu POST để xuất PDF
    form.remove(); // Xóa form sau khi gửi
});


</script>