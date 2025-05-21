<?php

require_once('./tcpdf/tcpdf.php'); // Đảm bảo thư viện TCPDF đã được tải lên
require_once('./api/connect.php'); // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Booking_id'])) {
    $bookingId = $_POST['Booking_id'];

    // Lấy dữ liệu từ bảng booking_ordertour
    $queryOrder = "SELECT * FROM booking_ordertour INNER JOIN tour ON booking_ordertour.Tour_id=tour.id  WHERE Booking_id = ?";
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
    $queryDetails = "SELECT * FROM booking_detail_tour INNER JOIN participant ON booking_detail_tour.Booking_id = participant.idbook 
    INNER JOIN booking_ordertour ON booking_detail_tour.Booking_id = booking_ordertour.Booking_id WHERE booking_detail_tour.Booking_id = ?";
    $stmtDetails = $conn->prepare($queryDetails);
    $stmtDetails->bind_param("s", $bookingId);
    $stmtDetails->execute();
    $resultDetails = $stmtDetails->get_result();

    $details = [];
    while ($row = $resultDetails->fetch_assoc()) {
        $details[] = $row;
    }

    // Khởi tạo đối tượng TCPDF với header và footer
    class MYPDF extends TCPDF {
        public function Header() {
            // Thêm banner ảnh PNG
            $this->Image('./assets/img/banner.jpg', 5, 5, 200, 40, 'PNG');
            $this->Ln(25); // Xuống dòng sau ảnh
        }

        public function Footer() {
            $this->SetY(-45); // Dịch footer lên cao hơn nếu bị che
            $this->Image('./assets/img/footer.jpg', 5, $this->GetY(), 200, 40, 'PNG'); // Giảm chiều cao từ 40 xuống 25
        }
        
    }

    $pdf = new MYPDF();
    $pdf->SetAutoPageBreak(TRUE, 50); // 50 là khoảng cách từ nội dung đến footer
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Tour Booking System');
    $pdf->SetTitle('Booking Details');
    $pdf->SetMargins(5, 55, 5);
    $pdf->AddPage();
   
    // Nội dung PDF
    $itinerary = $orderData['Itinerary'];
    $days = preg_split('/\bNgày (\d+):/u', $itinerary, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    
    $html = '<h1 style="text-align:center; color:#004085;">Chi tiết đặt tour</h1>';
    $html .= '<center><h1 class="title" style="text-align:center;   font-size: 30px; /* Cỡ chữ */
    font-weight: bold; /* In đậm */
    color: black; /* Màu chữ chính */
   ">'.$orderData['Name'].'</h1>';
    $html .= '<p style="text-align:center;"><strong>Mã tour:</strong> ' . $orderData['Booking_id'] . '</p>';
    $departureDate = new DateTime($orderData['Datetime']);
    $html .= '<p style="text-align:center;"><strong>Thời gian:</strong> ' . $orderData['timetour']  . '</p>';
    $html .= '<p style="text-align:center;"><strong>Ngày khởi hành:</strong> ' . $departureDate->format('d/m/Y') . '</p>';
    $html .= '<p style="text-align:center;"><strong>Phương tiện:</strong> ' . $orderData['Arrival'] . '</p>';
    $html .= '<p style="text-align:center;"><strong>Số người tham gia:</strong> ' . $orderData['participants'] . '</p>';
    $html .= '<h1 style="text-align:center; color:#004085;">Lịch trình</h1>';
    for ($i = 0; $i < count($days); $i += 2) {
        $dayNumber = trim($days[$i]); // Lấy số ngày (1, 2, 3,...)
        $content = nl2br(trim($days[$i + 1])); // Lấy nội dung lịch trình ngày đó
        $firstLine = strtok($content, "\n"); // Lấy dòng đầu tiên (ngày tháng & tuyến đường)
        $remainingContent = nl2br(substr($content, strlen($firstLine))); // Nội dung còn lại
    
        // Bố cục hàng ngang bằng Flexbox
        $html .= '<div style="display: flex; align-items: center; margin-bottom: 5px;">';
        
        // Ô NGÀY (30%)
        $html .= '<div style="background-color:#dc3545; color:#fff; padding:10px; font-weight:bold; font-size:16px; width:30%; text-align:center;">
                    NGÀY ' . $dayNumber . '
                  </div>';
        
        // Ô NGÀY THÁNG & TUYẾN ĐƯỜNG (70%)
        $html .= '<div style="background-color:#007bff; color:#fff; padding:10px; font-weight:bold; width:70%;">
                    ' . $firstLine . '
                  </div>';
        
        $html .= '</div>'; // Kết thúc flexbox
    
        // Nội dung chi tiết của ngày đó
        $html .= '<p style="text-align:justify;">' . $remainingContent . '</p>';
    }

    $html .= '<h3>Thành viên tham gia:</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4" style="width:100%; text-align:center;">';
    $html .= '<thead><tr style="background-color:#004085; color:#fff;"><th>STT</th><th>Họ tên</th><th>Ngày sinh</th><th>Giới tính</th><th>Phân loại</th></tr></thead><tbody>';
    
    foreach ($details as $index => $detail) {
        $departureDate1 = new DateTime($detail['ngaysinh']);
        $html .= '<tr><td>' . ($index + 1) . '</td><td>' . $detail['hoten'] . '</td><td>' . $departureDate1->format('d/m/Y') . '</td><td>' . $detail['gioitinh'] . '</td><td>' . $detail['phanloai'] . '</td></tr>';
    }

    $html .= '</tbody></table>';
    $html .= '<h3>Chi tiết tour:</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4" style="width:100%; text-align:center;">';
    $html .= '<thead><tr style="background-color:#004085; color:#fff;"><th>STT</th><th>Tên Tour</th><th>Giá</th><th>Tổng thanh toán</th><th>Người đặt</th><th>Số điện thoại</th><th>Địa chỉ</th></tr></thead><tbody>';

    if (!empty($details)) {
        $detail = $details[0];
        $html .= '<tr><td>1</td><td>' . $detail['Tour_name'] . '</td><td>' . number_format($detail['Price'], 0, ',', '.') . ' VNĐ </td><td>' . number_format($detail['Total_pay'], 0, ',', '.') . ' VNĐ </td><td>' . $detail['User_name'] . '</td><td>' . $detail['Phone_num'] . '</td><td>' . $detail['Address'] . '</td></tr>';
    }

    $html .= '</tbody></table>';

    // Viết nội dung vào PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    
    ob_end_clean(); // Dọn dẹp bộ đệm đầu ra trước khi gửi PDF
    // Xuất file PDF
    $pdf->Output('booking_details_' . $bookingId . '.pdf', 'D');
    
    exit;
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
        .calendar-btn {
    background-color: #007bff; /* Màu xanh */
    color: white; /* Chữ màu trắng */
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.calendar-btn:hover {
    background-color:rgb(7, 16, 27); /* Màu xanh đậm khi hover */
    color:white;
}

@media (max-width: 768px) {
#orderDetails{
    width: auto;
}
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
  <div class="modal fade" id="ratingModaldanhgia" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
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

function loadBookingData(event) {
    if (!event || !event.booking_time) return; // Kiểm tra dữ liệu hợp lệ

    const bookingTime = new Date(event.booking_time); // Thời gian đặt đơn
    const currentTime = new Date(); // Thời gian hiện tại
    const diffInMinutes = Math.floor((currentTime - bookingTime) / 60000); // Tính số phút đã trôi qua
    const remainingMinutes = 1440 - diffInMinutes; // 5 ngày = 7200 phút

    let cancelButton = '';
    let countdownText = '';
    let suaButton = '';

    if (remainingMinutes > 0 && event.refund == '0') {
        // Tính toán ngày, giờ, phút còn lại
        const days = Math.floor(remainingMinutes / 1440); // 1 ngày = 1440 phút
        const hours = Math.floor((remainingMinutes % 1440) / 60); // Lấy phần giờ còn lại
        const minutes = remainingMinutes % 60; // Lấy phần phút còn lại

        cancelButton = `<button style="width:340px;" class="btn cancel" onclick="huydontour(${event.Booking_id}, ${event.participants}, ${event.Tour_id},  '${event.Datetime}')">Hủy đơn</button>`;

        countdownText = `<p style="color: red; font-weight: bold;">Thời gian còn lại để hủy và sửa: ${days} ngày ${hours} giờ ${minutes} phút</p>`;

        suaButton = `<button style="width:340px;" id="btn-sua" class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal1('${event.Booking_id}')">Sửa tour</button>`;
    }

    let detailsHtml = `
        ${countdownText}  <!-- Hiển thị thời gian còn lại -->
        ${cancelButton}   <!-- Chỉ hiển thị nếu còn trong 5 ngày -->
        ${suaButton}
    `;

    $('#orderDetails_' + event.Booking_id).html(detailsHtml); // Cập nhật phần tử đúng ID
}




function xemtrangthai() {
    $.ajax({
        url: './api/api.php?action=xemtrangthai',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (Array.isArray(response) && response.length > 0) {
                let eventHtml = '';

                response.forEach(function (event, index) {
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
                            <input type="hidden" name="participants" value="${event.participants}" readonly>
                            <input type="hidden" name="idtour" value="${event.Tour_id}" readonly>
                            <input type="date" hidden name="ngaykhoihanh" value="${event.Datetime}" readonly>
                    `;

                    // Trạng thái thanh toán
                    if (event.Payment_status == '1') {
                        eventHtml += '<p><strong>TT thanh toán:</strong> Chưa thanh toán</p>';
                    } else if (event.Payment_status == '2') {
                        eventHtml += '<p><strong>TT thanh toán:</strong> Đã thanh toán</p>';
                    }

                    // Trạng thái đơn chưa hoàn tiền
                    if (event.refund == '0') {
                        if (event.Payment_status == '1') {
                            eventHtml += `<div id="orderDetails_${event.Booking_id}"></div>`;
                        }

                        // Xử lý trạng thái xác nhận
                        if (event.Booking_status == '1') {
                            eventHtml += '<button class="btn review">Chưa xác nhận</button>';
                        } else if (event.Booking_status == '2') {
                            eventHtml += '<button class="btn review">Đã xác nhận</button>';

                            // Nếu đã thanh toán => hiển thị đánh giá + PDF + Calendar
                            if (event.Payment_status == '2') {
                                eventHtml += `
                                    <button type="button" class="btn review" data-bs-toggle="modal" data-bs-target="#ratingModaldanhgia" onclick="openRatingModal(${event.Booking_id})">Đánh giá Tour</button>
                                    <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button>
                                    <button class="btn calendar-btn" onclick="addToGoogleCalendar('${event.Tour_name}', '${event.Datetime}', '08:00', 'Địa điểm tour', '${event.Day_depart}')">📅 Thêm vào Google Calendar</button>
                                `;
                            } else {
                                // Xử lý các phương thức thanh toán khác nhau
                                if (event.method === "vnpay") {
                                    eventHtml += `<button class="btn review"><a style="text-decoration:none;color:white" href="index.php?idtt=${event.Booking_id}">Thanh toán</a></button>`;
                                } else if (event.method === "vietqr") {
                                    const qrContainerId = `xemqr-container-${event.Booking_id}`;
                                    eventHtml += `<div id="${qrContainerId}" class="btn review">Đang tải...</div>`;

                                    // Gọi AJAX riêng sau khi tạo giao diện
                                    setTimeout(() => {
                                        $.ajax({
                                            url: './api/api.php?action=xemthanhtoanvietqr&vietqr=' + encodeURIComponent(event.Booking_id),
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function (res) {
                                             
                                                if (res.code === "00" && res.data) {
                                                    const checkoutUrl = res.data.checkoutUrl;
                                                    $(`#${qrContainerId}`).html(`<a style="text-decoration:none;color:white;" href="${checkoutUrl}" target="_blank">Thanh toán</a>`);
                                                } else {
                                                    $(`#${qrContainerId}`).html('<div>Không thể tạo thanh toán.</div>');
                                                }
                                            },
                                            error: function () {
                                                $(`#${qrContainerId}`).html('<div>Lỗi khi lấy QR thanh toán.</div>');
                                            }
                                        });
                                    }, 0);
                                } else if (event.method === "cash") {
                                    eventHtml += `<button class="btn review"><a style="text-decoration:none;color:white" href="index.php?cash=${event.Booking_id}">Thanh toán</a></button>`;
                                }
                            }
                        }
                    } else if (event.refund == '1') {
                        eventHtml += '<button class="btn cancel">Đã hủy</button>';
                        if (event.Payment_status == '2') {
                            eventHtml += '<button class="btn review">Chưa hoàn tiền</button>';
                        }
                         if (event.Payment_status == '3') {
                            eventHtml += '<button class="btn review">Đã hoàn tiền</button>';
                        }
                    }else if (event.refund == '2') {
                        eventHtml += '<button class="btn cancel">Đã hủy</button>';
                        if (event.Payment_status == '1') {
                            eventHtml += '<button class="btn review">Quá thời gian thanh toán</button>';
                        }
                    }

                    // Nút xem chi tiết
                    eventHtml += `
                        <a href="#" class="btn btn-dark view-details" data-id="${event.Booking_id}">Xem chi tiết</a>
                        </div>
                    `;

                    if ((index + 1) % 3 === 0 || index + 1 === response.length) {
                        eventHtml += '</div><br>';
                    }
                });

                $('#xemtrangthai').html(eventHtml);

                // Gọi hàm loadBookingData cho từng đơn
                response.forEach(event => loadBookingData(event));

                // Xem chi tiết
                $('.view-details').on('click', function (e) {
                    e.preventDefault();
                    let newsId = $(this).data('id');
                    view_news_details(newsId);
                });

            } else {
                $('#xemtrangthai').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemtrangthai').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}

function addToGoogleCalendar(tourName, tourDate, tourTime, tourLocation, dayDepart) {
    console.log("Tour Name:", tourName);
    console.log("Tour Date:", tourDate);
    console.log("Tour Time:", tourTime);
    console.log("Tour Duration:", dayDepart);

    // Chuyển đổi `tourDate` thành định dạng `YYYY-MM-DD`
    let dateParts = tourDate.split(" ");
    let formattedDate = dateParts[0]; // Lấy phần ngày (bỏ giờ nếu có)

    let fullDateTime = new Date(formattedDate + "T" + tourTime + ":00");

    if (isNaN(fullDateTime)) {
        console.error("Invalid Date:", fullDateTime);
        alert("Lỗi: Ngày đặt tour không hợp lệ.");
        return;
    }

    // Chuyển đổi `Day_depart` thành số ngày (vd: "4 ngày 3 đêm" => lấy số 4)
    let tourDays = parseInt(dayDepart.match(/\d+/)?.[0] || "1", 10);

    // Tính `endDate` bằng cách cộng thêm số ngày vào `startDate`
    let endDateObj = new Date(fullDateTime);
    endDateObj.setDate(endDateObj.getDate() + tourDays);

    // Format ngày tháng theo Google Calendar
    const startDate = fullDateTime.toISOString().replace(/-|:|\.\d+/g, "");
    const endDate = endDateObj.toISOString().replace(/-|:|\.\d+/g, "");

    const calendarUrl = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(tourName)}
        &dates=${startDate}/${endDate}
        &location=${encodeURIComponent(tourLocation)}
        &details=${encodeURIComponent(`Tour kéo dài ${dayDepart}.`)}`;

    window.open(calendarUrl, "_blank");
}


function huydontour(idve, participants, idtour,datetime) {
   
    fetch(`./api/api.php?action=huydontour&id=${idve}&participants=${participants}&idtour=${idtour}&ngaykhoihanh=${datetime}`)
        .then(response => response.text())
        .then(data => {
            console.log(data);
            if (data === 'gui') {
                openPopup('Hủy đơn thành công', '');
                setTimeout(() => {
                    window.location.href = 'index.php?xemdattour';
                }, 1000);
            } else {
                openPopup('Cập nhật không thành công', '');
            }
        })
        .catch(error => console.error('Lỗi:', error));
}

    function view_news_details(id) {
    $.ajax({
        url: './api/api.php?action=xemtrangthaichitiet&id=' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && response.length > 0) {
                var item = response[0]; // Lấy thông tin chung từ bản ghi đầu tiên
                var detailsHtml = `
                    <a href="index.php?xemdattour" class="btn btn-secondary">Trở Lại</a>
                    <div class="container4">
                        <h2>THÔNG TIN ĐẶT TOUR</h2>

                        <!-- Thông tin người đặt tour -->
                        <div class="user-info">
                            <h3>Thông tin người đặt</h3>
                            <div class="form-row">
                                <div>
                                    <label for="fullname">Tên tài khoản:</label>
                                    <input type="text" id="fullname" value="${item.User_name}" readonly>
                                </div>
                                <div>
                                    <label for="phone">Số điện thoại:</label>
                                    <input type="text" id="phone" value="${item.Phone_num}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" id="address" value="${item.Address}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin tour -->
                        <div class="tour-info">
                            <h3>Thông tin tour</h3>
                            <div class="form-row">
                                <div>
                                    <label for="tour-code">Mã:</label>
                                    <input type="text" id="tour-code" value="${item.Booking_id}" readonly>
                                </div>
                                <div>
                                    <label for="tour-name">Tên tour:</label>
                                    <input type="text" id="tour-name" value="${item.Tour_name}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="departure-date">Thời gian khởi hành:</label>
                                    <input type="date" id="ns" value="${item.Datetime}" readonly>
                                </div>
                                <div>
                                    <label for="duration">Thời gian diễn ra tour (ngày):</label>
                                    <input type="text" id="duration" value="${item.Day_depart}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="arrival">Phương tiện di chuyển:</label>
                                    <input type="text" id="arrival" value="${item.Arrival}" readonly>
                                </div>
                                <div>
                                    <label for="participants">Số lượng người:</label>
                                    <input type="text" id="participants" value="${item.participants}" readonly>
                                </div>
                            </div>
                             <div class="form-row">
                                <div>
                                    <label for="arrival">Tên khách sạn:</label>
                                    <input type="text" id="arrival" value="${item.tenks}" readonly>
                                </div>
                               
                            </div>
                        </div>

                        <!-- Thông tin giá -->
                        <div class="pricing-info">
                            <h3>Thông tin giá</h3>
                            <div class="form-row">
                                <div>
                                    <label for="price">Giá vé:</label> <br>
                                    <input style="width:100%;height:65%" type="text" id="price" value="${item.Price}" readonly>
                                </div>
                                 <div>
                                    <label for="price">Tổng tiền phòng:</label> <br>
                                   <input type="text" id="total-price" value="${item.tienks}" readonly>
                                </div>
                                <div></div>
                                <div>
                                    <label for="total-price">Tổng tiền:</label>
                                    <input type="text" id="total-price" value="${item.Total_pay}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin thành viên tham gia -->
                        <div class="participant-info">
                            <h3>Thông tin thành viên tham gia</h3>
                `;

                // Duyệt qua danh sách tất cả thành viên
                response.forEach((participant, index) => {
                    
                    detailsHtml += `
                        <div class="form-row1">
                            <div>
                                <label>${participant.phanloai}:</label>
                                
                            </div>
                            <div>
                                <label>Họ tên:</label>
                                <input type="text" value="${participant.hoten}" readonly>
                            </div>
                            <div>
                                <label>Ngày sinh:</label>
                                <input type="text" value="${participant.ngaysinh}" readonly>
                            </div>
                            <div>
                                <label>Giới tính:</label>
                                <input type="text" value="${participant.gioitinh}" readonly>
                            </div>
                        </div>
                    <br>`;
                });

                detailsHtml += `
                        </div> <!-- Kết thúc thông tin thành viên -->
                    </div> <!-- Kết thúc container -->
                `;

                $('#xemtrangthai').html(detailsHtml); 
            } else {
                $('#xemtrangthai').html('<div class="col">Không tìm thấy dữ liệu.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy dữ liệu:', error);
            $('#xemtrangthai').html('<div class="col">Đã xảy ra lỗi khi tải dữ liệu.</div>');
        }
    });
}

function openRatingModal1(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    $.ajax({
        url: './api/api.php?action=xemtoursua&idt=' + Id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response)
            if (response && response.length > 0) {
                var item = response[0]; // Lấy thông tin chung từ bản ghi đầu tiên
                var detailsHtml = `
                   
                    <div class="container4">
                        <h2>THÔNG TIN ĐẶT TOUR</h2>
            <input type="hidden" id="idtour" name="idtour" value="${item.Tour_id}" readonly>
                        <!-- Thông tin người đặt tour -->
                        <div class="user-info">
                            <h3>Thông tin người đặt</h3>
                            <div class="form-row">
                                <div>
                                    <label for="fullname">Tên tài khoản:</label>
                                    <input type="text" id="fullname" value="${item.User_name}" readonly>
                                </div>
                                <div>
                                    <label for="phone">Số điện thoại:</label>
                                    <input type="text" id="phone" value="${item.Phone_num}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" id="address" value="${item.Address}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin tour -->
                        <div class="tour-info">
                            <h3>Thông tin tour</h3>
                            <div class="form-row">
                                <div>
                                    <label for="tour-code">Mã:</label>
                                    <input type="text" id="tour-code" name="booking_id" value="${item.Booking_id}" readonly>
                                </div>
                                <div>
                                    <label for="tour-name">Tên tour:</label>
                                    <input type="text" id="tour-name" value="${item.Tour_name}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="departure-date">Thời gian khởi hành:</label>
                                    <input type="date" id="ns" value="${item.Datetime}" readonly>
                                </div>
                                <div>
                                    <label for="duration">Thời gian diễn ra tour (ngày):</label>
                                    <input type="text" id="duration" value="${item.Day_depart}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="arrival">Phương tiện di chuyển:</label>
                                    <input type="text" id="arrival" value="${item.Arrival}" readonly>
                                </div>
                                <div>
                                    <label for="participants">Số lượng người:</label>
                                    <input type="text" id="participants" name="participants" value="${item.participants}" readonly>
                                     
                                </div>
                            </div>
                             <div class="form-row">
                                <div>
                                    <label for="arrival">Tên khách sạn:</label>
                                    <input type="text" id="arrival" value="${item.tenks}" readonly>
                                </div>
                               
                            </div>
                        </div>

                        <!-- Thông tin giá -->
                        <div class="pricing-info">
                            <h3>Thông tin giá</h3>
                            <div class="form-row">
                                <div>
                                    <label for="price">Giá vé:</label>
                                    <input type="text" id="adult_price" name="adult_price" value="${item.Price}" readonly>
                                    <input type="hidden" id="child_rate" name="child_rate" value="${item.Child_price_percen}" readonly>
                                </div>
                                 <div>
                                    <label for="price">Tổng tiền phòng:</label> <br>
                                   <input type="text" id="total-price" value="${item.tienks}" readonly>
                                </div>
                                <div></div>
                                <div>
                                    <label for="total-price">Tổng tiền:</label>
                                    <input type="text" id="total-price" name="" value="${item.Total_pay}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin thành viên tham gia -->
                        <div class="participant-info">
                            <h3>Thông tin thành viên tham gia</h3>
                `;

                // Duyệt qua danh sách tất cả thành viên
                response.forEach((participant, index) => {
                    
                    detailsHtml += `
                        <div class="form-row1">
                            <div>
                                <label>${participant.phanloai}:</label>
                              <input type="hidden" name="id" value="${participant.idpar}" >
                            </div>
                            <div>
                                <label>Họ tên:</label>
                                <input type="text" name="ht" value="${participant.hoten}" >
                            </div>
                            <div>
                                <label>Ngày sinh:</label>
                                <input type="date" name="ns" value="${participant.ngaysinh}" >
                            </div>
                            <div>
                                <label>Giới tính:</label>
                               <br>
                                <select name="gioit" style="height:40px;width:100px">
                                    <option value="${participant.gioitinh}">${participant.gioitinh}</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                             <div>
                                <label>Thao tác:</label>
                               <br>
                                    <button type="button" class="btn btn-danger" onclick="xoapar(${participant.idpar}, ${participant.Tour_id}, ${participant.Booking_id}, ${participant.Price}, ${participant.Child_price_percen})">Xóa</button>
                            </div>
                        </div>
                    <br>`;
                });

                detailsHtml += `
                        </div> <!-- Kết thúc thông tin thành viên -->
                    </div> <!-- Kết thúc container -->
                `;

                $('#suatour').html(detailsHtml); 
            } else {
                $('#suatour').html('<div class="col">Không tìm thấy dữ liệu.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy dữ liệu:', error);
            $('#suatour').html('<div class="col">Đã xảy ra lỗi khi tải dữ liệu.</div>');
        }
    });
}
function xoapar(id, idtour, booking_id, adult_price, child_rate) {
    fetch(`./api/api.php?action=xoapar&id=${id}&idtour=${idtour}&booking_id=${booking_id}&adult_price=${adult_price}&child_rate=${child_rate}`)
        .then(response => response.text())
        .then(data => {
            console.log(data);
            if (data === 'gui') {
                openPopup('Xóa thành viên tham gia thành công', '');
                
            } else {
                openPopup('Cập nhật không thành công', '');
            }
        })
        .catch(error => console.error('Lỗi:', error));
}

let loginForm = document.querySelector(".capnhathoadon"); 
loginForm.addEventListener("submit", (e) => { 
    e.preventDefault(); 
    
    
});
function capnhathoadon() {
    let data = [];

    $(".form-row1").each(function () {
        let id = $(this).find("input[name='id']").val();
        let hoten = $(this).find("input[name='ht']").val();
        let ngaysinh = $(this).find("input[name='ns']").val();
        let gioitinh = $(this).find("select[name='gioit']").val();

        data.push({ id, hoten, ngaysinh, gioitinh });
    });

    $.ajax({
        type: 'POST',
        url: './api/api.php',  // Không cần thêm ?action=capnhathoadon vào URL
        data: JSON.stringify({ action: 'capnhathoadon', participants: data }), // Gửi action trong dữ liệu JSON
        contentType: 'application/json',
        success: function (response) {
          
            if (response.trim() === 'cập nhật thành công!') {
                openPopup('Thông báo', 'Cập nhật thành công!');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                openPopup('Cập nhật thành công!','');
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi AJAX:', status, error);
            console.error('Chi tiết lỗi:', xhr.responseText);
            openPopup('Lỗi', 'Không thể gửi yêu cầu. Vui lòng thử lại!');
        }
    });
}


$(document).ready(function() {
    xemtrangthai();
   
});
</script>

<script>
   
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
                    }, 2000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Load thông tin tour
    function openRatingModal(tourId) {
        // Lấy thông tin tour và hiển thị trong modal
        fetch(`./api/api.php?action=laythongtindanhgia&danhgia=${tourId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data && data[0]) {
                    document.getElementById('dg').innerHTML = `
                        <h5>Tên tour: ${data[0].Tour_name}</h5>
                        <input type="hidden" name="username" value="${data[0].User_name}">
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