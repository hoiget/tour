<?php


require_once('./tcpdf/tcpdf.php'); // Đảm bảo thư viện TCPDF đã được tải lên
require_once('./api/connect.php'); // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Booking_id'])) {
    $bookingId = $_POST['Booking_id'];

    // Lấy dữ liệu từ bảng booking_ordertour
    $queryOrder = "SELECT * FROM booking_ordertour WHERE Booking_id = ?";
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
    $queryDetails = "SELECT * FROM booking_detail_tour WHERE Booking_id = ?";
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
    $pdf->SetAuthor('Tour Booking System');
    $pdf->SetTitle('Booking Details');
    $pdf->SetHeaderFont(array('dejavusans', '', 12)); // Phông chữ cho phần header
    $pdf->SetHeaderData('', 0, 'Chi tiết đặt tour', '', array(0,64,255), array(0,64,128));
    $pdf->SetMargins(15, 27, 15); // Lề
    $pdf->AddPage();
   

    // Nội dung PDF
    $html = '<h1>Chi tiết đặt tour</h1>';
    $html .= '<h3>Thông tin chính:</h3>';
    $html .= '<p><strong>Booking ID:</strong> ' . $orderData['Booking_id'] . '</p>';
    $html .= '<p><strong>Ngày khởi hành:</strong> ' . $orderData['Departure_id'] . '</p>';
    $html .= '<p><strong>Điểm đến:</strong> ' . $orderData['Arrival'] . '</p>';
    $html .= '<p><strong>Số người tham gia:</strong> ' . $orderData['participants'] . '</p>';

    $html .= '<h3>Chi tiết tour:</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Tour</th>
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
                    <td>' . $detail['Tour_name'] . '</td>
                    <td>' . number_format($detail['Price'], 0, ',', '.') . ' VNĐ </td>
                    <td>' . number_format($detail['Total_pay'], 0, ',', '.') . ' VNĐ </td>
                    <td>' . $detail['User_name'] . '</td>
                    <td>' . $detail['Phone_num'] . '</td>
                    <td>' . $detail['Address'] . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Viết nội dung vào PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    ob_end_clean(); // Dọn dẹp bộ đệm đầu ra trước khi gửi PDF
    // Xuất file PDF
    $pdf->Output('booking_details_' . $bookingId . '.pdf', 'D'); // 'D' để tải file xuống
  
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
#btn-sua {
    background-color: orange;
    color: #fff;
}
#btn.detail {
    background-color: #000;
    color: #fff;
}

.exportPdfBtn {
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
.form-row1 {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr; /* 2 cột bằng nhau */
  gap: 10px; /* Khoảng cách giữa các cột */
}

.form-row1 label {
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
  <!-- Modal -->
  <div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="capnhathoadon" id="capnhathoadon" action="./api/api.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="capnhathoadon">
            <div id="suatour"></div>
            <button type="submit" onclick="capnhathoadon()">Cập nhật</button>
            </form>
            </div>
        </div>
    </div>
</div> 
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

<br><br>
    <div class="container6">
        <h1>TRẠNG THÁI ĐƠN</h1>
        
            
          <div id="xemtrangthai"></div>
            <!-- Thêm các thẻ card khác theo nhu cầu -->
        
    </div>
    <br><br>
   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>


function xemtrangthai() {
    $.ajax({
        url: './api/apia.php?action=xemtrangthai',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (Array.isArray(response) && response.length > 0) {
                let eventHtml = '';
                response.forEach(function(event, index) {
                    if (index % 3 === 0) {
                        eventHtml += '<div class="card-container">';
                    }

                    eventHtml += `
                    <div class="card">
                        <h3>${event.User_name}</h3>
                        <p><strong>Tên tour:</strong> ${event.Tour_name}</p>
                        <p><strong>Giá tour:</strong> ${event.Price}</p>
                        <p><strong>Tổng tiền:</strong> ${event.Total_pay}</p>
                        <p><strong>Mã đơn:</strong> ${event.Booking_id}</p>
                        <p><strong>Thời gian đặt:</strong> ${event.booking_time}</p>
                         <input type="hidden" id="participants" name="participants" value="${event.participants}" readonly>
                          <input type="hidden" id="idtour" name="idtour" value="${event.Tour_id}" readonly>
                         <!-- Thêm id duy nhất cho mỗi đơn -->
                    `;

                    if (event.Payment_status == '1') {
                        eventHtml += '<p><strong>TT thanh toán:</strong> Chưa thanh toán</p>';
                    } else if (event.Payment_status == '2') {
                        eventHtml += '<p><strong>TT thanh toán:</strong> Đã thanh toán</p>';
                        eventHtml += '<p><strong>Thời gian thanh toán:</strong> 2024-12-04 15:45:11</p>';
                    }

                    if (event.refund == '0') {
                        
                        if (event.Booking_status == '1') {
                            eventHtml += '<button class="btn review">Chưa xác nhận</button>';
                        } else if (event.Booking_status == '2') {
                            eventHtml += '<button class="btn review">Đã xác nhận</button>';
                            if (event.Payment_status == '2') {
                                eventHtml += `<button type="button" class="btn review" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal(${event.Booking_id})">Đánh giá Tour</button>`;
                            } else {
                                eventHtml += `<button class="btn review"><a style="text-decoration:none;color:white" href="index.php?idtt=${event.Booking_id}">Thanh toán</a></button>`;
                            }
                            eventHtml += `
                        <div>
                            <input type="hidden" id="bookingIdInput_${index}" value="${event.Booking_id}" readonly>
                            <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button>
                        </div>
                    `;
                        }
                    } else if (event.refund == '1') {
                        eventHtml += '<button class="btn cancel">Đã hủy</button>';
                        if (event.Payment_status == '2') {
                            eventHtml += '<button class="btn review">Chưa hoàn tiền</button>';
                        }
                    }

                    eventHtml += `
                        
                    </div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === response.length) {
                        eventHtml += '</div><br>';
                    }
                });

                $('#xemtrangthai').html(eventHtml);

                // Gọi loadBookingData cho từng đơn đặt tour
                response.forEach(event => loadBookingData(event));

                $('.view-details').on('click', function(e) {
                    e.preventDefault();
                    var newsId = $(this).data('id');
                    view_news_details(newsId);
                });

            } else {
                $('#xemtrangthai').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemtrangthai').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}



$(document).ready(function() {
    xemtrangthai();
   
});
</script>




