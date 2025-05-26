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
    $days = preg_split('/\bNGÀY (\d+):/u', $itinerary, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    
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
    

    ob_end_clean(); // Dọn dẹp bộ đệm đầu ra (rất quan trọng nếu không sẽ bị lỗi header)

    // Tên file PDF
    $filename = 'booking_details_' . $bookingId . '.pdf';
    
    // Xuất PDF trực tiếp để trình duyệt tải về
    $pdf->Output($filename, 'D'); // 'D' để force download
    exit;

}
?>
<link rel="stylesheet" href="./assets/css/form.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        .search-bar {
            margin-bottom: 10px;
            display: flex;
            justify-content: flex-end;
        }
        .search-bar input {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table thead {
            background-color: #333;
            color: white;
        }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            font-size: 14px;
            text-transform: uppercase;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .btn {
            display: inline-block;
            padding: 6px 10px;
            font-size: 14px;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn.edit {
            background-color: #007bff;
            color: white;
            
        }
        .btn.edit1 {
            background-color: #007bff;
            color: white;
            width: 50px;
            
        }
        .btn.delete {
            background-color: #dc3545;
            color: white;
        }
        .btn.edit:hover {
            background-color: #0056b3;
        }
        .btn.delete:hover {
            background-color: #a71d2a;
        }
        
        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: auto;
          
            
           
            align-items: center;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }
        .form-group {
           
          
            margin-bottom: 15px;
        }
        .form-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }
        textarea {
    width: 100%; /* Chiều rộng đầy đủ */
    padding: 8px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical; /* Cho phép thay đổi chiều cao */
}

        .submit-btn {
            display: block;
            width: 20%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    
.form-container {
    width: 100%; /* Chiều rộng đầy đủ */
    overflow-x: auto; /* Cuộn ngang nếu nội dung vượt quá chiều rộng */
    overflow-y: auto; /* Cuộn dọc nếu cần */
    max-height: 500px; /* Giới hạn chiều cao tối đa */
    border: 1px solid #ddd; /* Đường viền để dễ nhận diện */
    border-radius: 8px;
    background-color: white; /* Đảm bảo nền trắng cho vùng cuộn */
}
#btn-xem{
     background-color: black;
    color: white;         
}
.containerql {
    display: flex;
    flex-direction: row;
    width: 90%;
    margin: 20px auto;
}

.table-container {
    width: 100%;
    overflow-x: auto;
    border-radius: 8px;
    background-color: white;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* .qr-container {
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: white;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-left: 10px;
}

.qr-container h2 {
    font-size: 18px;
    margin-bottom: 10px;
}

#qrcode {
    margin-top: 10px;
} */
@media (max-width: 768px) {
    .containerql {
        flex-direction: column; /* Xếp dọc thay vì ngang */
    }

    .table-container, .qr-container {
        width: 100%;
        margin-left: 0;
        margin-top: 15px;
    }

    .search-bar {
        justify-content: center;
    }

    .search-bar input {
        width: 100%;
        max-width: 300px;
    }

    table {
        font-size: 12px;
    }

    table thead {
        display: none; /* Ẩn tiêu đề bảng để hiển thị dạng thẻ */
    }

    table tbody tr {
        display: block;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        background-color: white;
    }

    table td {
        display: flex;
        justify-content: space-between;
        padding: 6px 10px;
        border: none;
        border-bottom: 1px solid #eee;
    }

    table td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #555;
    }

    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .btn {
        width: 100%;
        margin-bottom: 5px;
    }

    .submit-btn {
        width: 100%;
    }
}

.dropdown {
    margin: 30px 0;
    display: flex;
    flex-direction: column; /* 2 hàng dọc */
    gap: 15px;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: center;
}

.filter-row label {
    font-weight: 600;
    color: var(--dark-color);
    white-space: nowrap;
}
.filter-row input{
    width: 200px;
}
.filter-row select,.filter-row input,
.filter-row button {
    flex-shrink: 0;
    padding: 10px 15px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    background-color: white;
    transition: var(--transition);
}

.filter-row select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
}

.filter-row button {
    background-color: var(--primary-color);
    color: black;
    border: none;
    font-weight: 600;
    cursor: pointer;
}

.filter-row button:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
}

#stk{
    border:none;
    font-weight: bold;

}



    </style>

<h1>Quản lý dịch vụ tour</h1>
<div class="modal fade" id="ratingModalxem" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
            <div id="xemtour"></div>
           
          
            </div>
        </div>
    </div>
</div> 

<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="capnhathoadon" id="capnhathoadon" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="capnhathoadon">
            <div id="suatour"></div>
            <button type="submit">Cập nhật</button>
            </form>
            </div>
        </div>
    </div>
</div> 
<div class="container">
    <div class="search-bar">
    <span style="padding-right:10px">Tìm kiếm:</span><input style="width:400px;height:40px" type="text" id="search" name="KH" placeholder="Tên khách hàng hoặc Mã tour" onkeydown="searchkh(event)"> 
  
</div>
<div class="tour-search">
            <div class="dropdown">
            <div class="filter-row">
                <label for="year">Năm:</label>
                <select id="year">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>
                <label for="day">Từ Ngày:</label>        
                <input class="day" type="date" id="from_date" name="from_date">
                <label for="to_date">Đến ngày:</label>
                <input class="day" type="date" id="to_date" name="to_date">
                <label for="month">Tháng:</label>
                <select id="month">
                    <option value="" selected>Tất cả</option>
                    <option value="1">Tháng 1</option>
                    <option value="2">Tháng 2</option>
                    <option value="3">Tháng 3</option>
                    <option value="4">Tháng 4</option>
                    <option value="5">Tháng 5</option>
                    <option value="6">Tháng 6</option>
                    <option value="7">Tháng 7</option>
                    <option value="8">Tháng 8</option>
                    <option value="9">Tháng 9</option>
                    <option value="10">Tháng 10</option>
                    <option value="11">Tháng 11</option>
                    <option value="12">Tháng 12</option>
                    <!-- Các tháng khác -->
                </select>
                
                
                </div>
                <div class="filter-row">
                <label for="vung">Vùng:</label>
                <select id="vung">
                    <option value="" selected>Tất cả</option>
                    <option value="Nam">Miền Nam</option>
                    <option value="Bắc">Miền Bắc</option>
                    <option value="Trung">Miền Trung</option>
                    <option value="Tây">Miền Tây</option>
                    <option value="Ngoài nước">Ngoài nước</option>
                  
                    <!-- Các vùng khác -->
                </select>
                <label for="huy">Trang thái đơn:</label>
                <select id="huy">
                    <option value="" selected>Tất cả</option>
                    <option value="0">Chưa hủy</option>
                    <option value="1">Đã hủy đơn</option>
                  
                    <!-- Các vùng khác -->
                </select>
                <label for="thanh">Trang thái thanh toán:</label>
                <select id="thanh">
                    <option value="" selected>Tất cả</option>
                    <option value="1">Chưa thanh toán</option>
                    <option value="2">Đã thanh toán</option>
                     <option value="3">Đã hoàn tiền</option>
                  
                    <!-- Các vùng khác -->
                </select>
                
                <button onclick="applyFilter()">Lọc</button>
                </div>
            </div>
        </div>
<script>
     function applyFilter() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;
    const vung = document.getElementById('vung').value; // Lấy giá trị vùng miền
    const from_date = document.getElementById('from_date').value;
    const to_date = document.getElementById('to_date').value;
    const huy = document.getElementById('huy').value; // Lấy giá trị vùng miền
    const thanh = document.getElementById('thanh').value; // Lấy giá trị vùng miền

    locdanhsach(year, month, vung,from_date, to_date,huy,thanh); // Gửi thêm tham số `vung`
    
}
   

</script>
<div class="containerql">
    <!-- Khu vực bảng (70%) -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tour</th>
                    <th>Gía tour</th>
                    <th>Tổng thanh toán</th>
                    <th>Người đặt</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Phương tiện</th>
                    <th>Ngày khởi hành</th>
                    <th>Ngày đặt</th>
                    <th>Số lượng người tham gia</th>
                    <th>Trạng Thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="employee-table">
                <!-- Dữ liệu sẽ được load từ AJAX -->
            </tbody>
        </table>
    </div>
    
    <!-- Khu vực QR Code (30%) -->
    <!-- <div class="qr-container">
        <h2>QR Code</h2>
        <div id="qrcode"></div>
    </div> -->
</div>

    </div>
   
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
function addDataLabels() {
    const table = document.querySelector('table');
    if (!table) return;

    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
    
    table.querySelectorAll('tbody tr').forEach(row => {
        row.querySelectorAll('td').forEach((td, index) => {
            if (headers[index]) {
                td.setAttribute('data-label', headers[index]);
            }
        });
    });
}

// Gọi hàm sau khi dữ liệu được load xong
$(document).ajaxComplete(function() {
    addDataLabels();
});
</script>

<script>
    function xemdichvu() {
    $.ajax({
        url: './api/apia.php?action=xemdichvu',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var today = new Date();
                var eventHtml = '';

                response.forEach(function(event) {
                    var bookingDate = new Date(event.created_at);
                    var timeDiff = Math.abs(today - bookingDate);
                    var dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); // Số ngày chênh lệch
                    
                    eventHtml += `
                        <tr>
                            <td>${event.Booking_id}</td>
                            <td>${event.Tour_name}</td>
                            <td>${event.Price}</td>
                            <td>${event.Total_pay}</td>
                            <td>${event.User_name}</td>
                            <td>${event.Phone_num}</td>
                            <td>${event.Address}</td>
                            <td>${event.Arrival}</td>
                            <td>${event.Datetime}</td>
                            <td>${event.created_at}</td>
                            <td>${event.participants}</td>
                    `;

                    if (event.refund == '1') {
                        eventHtml += '<td><span style="color:red">Hủy đơn</span><br>';
                        if (event.Payment_status == '2') {
                            eventHtml += '<br><span style="color:orange;">Chưa hoàn tiền</span></td>';
                        }
                        else if (event.Payment_status == '3') {
                            eventHtml += '<br><span style="color:green;">Đã hoàn tiền</span></td>';
                        }
                    } else if (event.Booking_status == '1') {
                        eventHtml += '<td><span style="color:green">Chưa xác nhận</span></td>';
                    } else {
                        eventHtml += '<td><span style="color:green">Xác nhận</span></td>';
                    }

                    eventHtml += `<td>
                        <div class="action-buttons">
                            <button class="btn edit" onclick="xacnhan('${event.Booking_id}')">✔</button>
                    `;

                    // Chỉ hiển thị nút "Sửa tour" nếu đơn đặt trong vòng 2 ngày
                    if (dayDiff <= 2) {
                        eventHtml += `
                            <button style="width:100px;height:40px" id="btn-sua" class="btn sua" 
                                data-bs-toggle="modal" data-bs-target="#ratingModal" 
                                onclick="openRatingModal1('${event.Booking_id}')">🖉</button>
                        `;
                    }

                    eventHtml += `
                            <button style="width:200px;height:40px" id="btn-xem" class="btn xem" 
                                data-bs-toggle="modal" data-bs-target="#ratingModalxem" 
                                onclick="openRatingModalxem('${event.Booking_id}')">Xem chi tiết</button>
                            <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button> 
                        </div>
                    </td>
                </tr>`;
                });

                $('#employee-table').html(eventHtml);
            } else {
                $('#employee-table').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#employee-table').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}


function searchkh(event) {
    if (event && event.key === "Enter") {  // Kiểm tra nếu event và phím bấm là Enter
        var searchValue = $('#search').val(); // Lấy giá trị từ ô input với id "search"

        // Nếu không có gì để tìm kiếm, không làm gì
        if (searchValue.trim() === "") {
            xemdichvu();
            return;
        }

        $.ajax({
            url: './api/apia.php', // API tìm kiếm nhân viên
            type: 'GET', // Sử dụng phương thức GET
            data: { action: 'timkhMT', KH: searchValue }, // Gửi mã nhân viên tìm kiếm qua GET
            dataType: 'json', // Kết quả trả về là JSON
            success: function(response) {
             
                if (Array.isArray(response) && response.length > 0) {
                    var events = response;
                    var eventHtml = '';
                    events.forEach(function(event) {
                     
                        eventHtml += `
                     
                     <tr>
                    <td>${event.Booking_id}</td>
                            <td>${event.Tour_name}</td>
                            <td>${event.Price}</td>
                            <td>${event.Total_pay}</td>
                            <td>${event.User_name}</td>
                            <td>${event.Phone_num}</td>
                            <td>${event.Address}</td>
                            <td>${event.Arrival}</td>
                            <td>${event.Datetime}</td>
                            <td>${event.created_at}</td>
                            <td>${event.participants}</td>   
                   `;
               if(event.refund == '1'){
                   eventHtml += '<td><span style="color:red">Hủy đơn</span>' 
                   if(event.Payment_status =='2'){
                       eventHtml += '<br><span style="color:orange;">Chưa hoàn tiền</span></td>' 
                   }
                    else if (event.Payment_status == '3') {
                            eventHtml += '<br><span style="color:green;">Đã hoàn tiền</span></td>';
                        }
               }else if(event.Booking_status == '1'){
                   
                    eventHtml += '<td><span style="color:green">Chưa xác nhận</span></td>' 
                   
               }else{
                   eventHtml += '<td><span style="color:green">Xác nhận</span></td>' 
               }
                   
                    eventHtml +=`<td>
                       <div class="action-buttons">
                           <button class="btn edit" onclick="xacnhan('${event.Booking_id}')">✔</button>
                         
                            <button style="width:50px;height:30px" id="btn-sua" class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal1('${event.Booking_id}')">Sửa tour</button>
                            <button style="width:100px;height:30px" id="btn-xem" class="btn xem" data-bs-toggle="modal" data-bs-target="#ratingModalxem" onclick="openRatingModalxem('${event.Booking_id}')">Xem chi tiết</button>
                            <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button> 
                           
                           </div>
                   </td>
               </tr> 
`;
            
                    });
                    $('#employee-table').html(eventHtml);
                } else {
                    $('#employee-table').html('<tr><td colspan="8">Không tìm thấy tour nào.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi lấy thông tin:', error);
                $('#employee-table').html('<tr><td colspan="8">Đã xảy ra lỗi khi tải thông tin.</td></tr>');
            }
        });
    }
}
function locdanhsach(year, month = null,vung = null,from_date = null, to_date = null,huy = null,thanh = null) {
    let url = `./api/apia.php?action=locdanhsach&year=${year}`;
    if (month) {
        url += `&month=${month}`;
    }
    if (vung) {
        url += `&vung=${vung}`;
    }
    if (from_date && to_date) {
        url += `&from_date=${from_date}&to_date=${to_date}`;
    }
    if (huy) {
        url += `&huy=${huy}`;
    }
    if(thanh){
        url += `&thanh=${thanh}`;
    }
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var today = new Date();
                var eventHtml = '';

                response.forEach(function(event) {
                    var bookingDate = new Date(event.created_at);
                    var timeDiff = Math.abs(today - bookingDate);
                    var dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); // Số ngày chênh lệch
                    
                    eventHtml += `
                        <tr>
                            <td>${event.Booking_id}</td>
                            <td>${event.Tour_name}</td>
                            <td>${event.Price}</td>
                            <td>${event.Total_pay}</td>
                            <td>${event.User_name}</td>
                            <td>${event.Phone_num}</td>
                            <td>${event.Address}</td>
                            <td>${event.Arrival}</td>
                            <td>${event.Datetime}</td>
                            <td>${event.created_at}</td>
                            <td>${event.participants}</td>
                    `;

                    if (event.refund == '1') {
                        eventHtml += '<td><span style="color:red">Hủy đơn</span>';
                        if (event.Payment_status == '2') {
                            eventHtml += '<br><span style="color:orange;">Chưa hoàn tiền</span></td>';
                        }
                         else if (event.Payment_status == '3') {
                            eventHtml += '<br><span style="color:green;">Đã hoàn tiền</span></td>';
                        }
                    } else if (event.Booking_status == '1') {
                        eventHtml += '<td><span style="color:green">Chưa xác nhận</span></td>';
                    } else {
                        eventHtml += '<td><span style="color:green">Xác nhận</span></td>';
                    }

                    eventHtml += `<td>
                        <div class="action-buttons">
                            <button class="btn edit" onclick="xacnhan('${event.Booking_id}')">✔</button>
                    `;

                    // Chỉ hiển thị nút "Sửa tour" nếu đơn đặt trong vòng 2 ngày
                    if (dayDiff <= 2) {
                        eventHtml += `
                            <button style="width:100px;height:40px" id="btn-sua" class="btn sua" 
                                data-bs-toggle="modal" data-bs-target="#ratingModal" 
                                onclick="openRatingModal1('${event.Booking_id}')">🖉</button>
                        `;
                    }

                    eventHtml += `
                            <button style="width:200px;height:40px" id="btn-xem" class="btn xem" 
                                data-bs-toggle="modal" data-bs-target="#ratingModalxem" 
                                onclick="openRatingModalxem('${event.Booking_id}')">Xem chi tiết</button>
                            <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button> 
                        </div>
                    </td>
                </tr>`;
                });

                $('#employee-table').html(eventHtml);
                } else {
                    $('#employee-table').html('<tr><td colspan="8">Không tìm thấy tour nào.</td></tr>');
                }
            },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            console.error('Chi tiết:', xhr.responseText);
            $('#employee-table').html('<div class="col">Đã xảy ra lỗi khi tải thông tin.</div>');
        }
    });
}

function xacnhan(id) {
       
       fetch('./api/apia.php?action=xacnhantour&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xác nhận thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qldichvu';
                   }, 1000);
               } else {
                   openPopup('Xác nhận không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}

function openRatingModal1(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    $.ajax({
        url: './api/apia.php?action=xemtoursua&idt=' + Id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
           
            if (response && response.length > 0) {
                var item = response[0]; // Lấy thông tin chung từ bản ghi đầu tiên
                var detailsHtml = `
                   
                    <div class="container4">
                        <h2>THÔNG TIN ĐẶT TOUR</h2>
                        <input type="hidden" id="idtour" name="idtour" value="${item.Tour_id}" >
                        <input type="hidden" id="booking_id" name="booking_id" value="${item.Booking_id}" >
                        <!-- Thông tin người đặt tour -->
                        <div class="user-info">
                            <h3>Thông tin người đặt</h3>
                            <div class="form-row">
                                <div>
                                    <label for="fullname">Tên tài khoản:</label>
                                    <input type="text" id="fullname" name="user_name" value="${item.User_name}" >
                                </div>
                                <div>
                                    <label for="phone">Số điện thoại:</label>
                                    <input type="text" id="phone" name="phone_num" value="${item.Phone_num}" >
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" id="address" name="address" value="${item.Address}" >
                                </div>
                                
                            </div>
                        </div>

                        <!-- Thông tin tour -->
                        <div class="tour-info">
                            <h3>Thông tin tour</h3>
                            <div class="form-row">
                                <div>
                                    <label for="tour-code">Mã:</label>
                                    <input type="text" id="tour-code" name="booking_id" value="${item.Booking_id}" >
                                </div>
                                <div>
                                    <label for="tour-name">Tên tour:</label>
                                    <input type="text" id="tour-name" value="${item.Tour_name}" >
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="departure-date">Thời gian khởi hành:</label>
                                    <input type="date" id="ns" value="${item.Datetime}" >
                                </div>
                                <div>
                                    <label for="duration">Thời gian diễn ra tour (ngày):</label>
                                    <input type="text" id="duration" value="${item.Day_depart}" >
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="arrival">Phương tiện di chuyển:</label>
                                    <input type="text" id="arrival" name="arrival" value="${item.Arrival}" >
                                </div>
                                <div>
                                    <label for="participants">Số lượng người:</label>
                                    <input type="text" id="participants" name="participants" value="${item.participants}" >
                                     
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
                                    <input type="text" id="adult_price" name="adult_price" value="${item.Price}" >
                                    <input type="hidden" id="child_rate" name="child_rate" value="${item.Child_price_percen}" >
                                </div>
                                   <div>
                                    <label for="price">Tổng tiền phòng:</label> <br>
                                   <input type="text" id="total-price" value="${item.tienks}" readonly>
                                </div>
                                <div></div>
                                <div>
                                    <label for="total-price">Tổng tiền:</label>
                                    <input type="text" id="total-price" name="" value="${item.Total_pay}" >
                                </div>
                            </div>
                        </div>`
                        if(item.refund == '1' && item.Payment_status == '2'){
                           
                     
                    detailsHtml +=`
                        <div class="pricing-info">
                            <h3>Thông tin tài khoản ngân hàng</h3>
                            <div class="form-row">
                                <div>
                                    <label for="price">Tên ngân hàng: ${item.TenNH}</label>
                                </div>
                                 <div>
                                    <div style="position: relative;">
                            <input type="password" class="form-control" id="stk" name="stk"  maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="${item.SoNH}" readonly>
                            <span onclick="toggleSTK()" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                👁️
                            </span>
                            </div>
                                </div>
                               
                            </div>
                        </div><br><br>`
                        }
                         detailsHtml +=` 
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
                              <input type="hidden" name="idpar" value="${participant.idpar}" >
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
    fetch(`./api/apia.php?action=xoapar&id=${id}&idtour=${idtour}&booking_id=${booking_id}&adult_price=${adult_price}&child_rate=${child_rate}`)
        .then(response => response.text())
        .then(data => {
          
            if (data === 'gui') {
                openPopup('Xóa thành viên tham gia thành công', '');
                setTimeout(() => {
                    window.location.reload(); // Tải lại trang để cập nhật số lượng & tổng tiền
                }, 1000);
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

function openRatingModalxem(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    $.ajax({
        url: './api/apia.php?action=xemtoursua&idt=' + Id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          
            if (response && response.length > 0) {
                var item = response[0]; // Lấy thông tin chung từ bản ghi đầu tiên
                var detailsHtml = `
                   
                    <div class="container4">
                        <h2>THÔNG TIN ĐẶT TOUR</h2>
                        <input type="hidden" id="idtour" name="idtour" value="${item.Tour_id}" >
                        <!-- Thông tin người đặt tour -->
                        <div class="user-info">
                            <h3>Thông tin người đặt</h3>
                            <div class="form-row">
                                <div>
                                    <label for="fullname">Tên tài khoản: ${item.User_name}</label>
                                   
                                </div>
                                <div>
                                    <label for="phone">Số điện thoại: ${item.Phone_num}</label>
                                    
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="address">Địa chỉ: ${item.Address}</label>                               
                                </div>
                                
                            </div>
                        </div>
                         <br><br>
                        <!-- Thông tin tour -->
                        <div class="tour-info">
                            <h3>Thông tin tour</h3>
                            <div class="form-row">
                                <div>
                                    <label for="tour-code">Mã: ${item.Booking_id}</label>
                               
                                </div>
                                <div>
                                    <label for="tour-name">Tên tour: ${item.Tour_name}<label>
                                   
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="departure-date">Thời gian khởi hành: ${item.Datetime}</label>
                                </div>
                                <div>
                                    <label for="duration">Thời gian diễn ra tour (ngày): ${item.Day_depart}</label>
                                   
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="arrival">Phương tiện di chuyển: ${item.Arrival}</label>
                                </div>
                                <div>
                                    <label for="participants">Số lượng người: ${item.participants}</label>
                                    
                                     
                                </div>
                            </div>
                             <div class="form-row">
                                <div>
                                    <label for="arrival">Tên khách sạn: ${item.tenks}</label>
                                </div>
                                
                            </div>
                        </div>
                         <br><br>
                        <!-- Thông tin giá -->
                        <div class="pricing-info">
                            <h3>Thông tin giá</h3>
                            <div class="form-row">
                                <div>
                                    <label for="price">Giá vé: ${item.Price}</label>
                                </div>
                                 <div>
                                    <label for="price">Tổng tiền phòng: ${item.tienks}</label>
                                </div>
                                <div>
                                    <label for="total-price">Tổng tiền: ${item.Total_pay}</label>
                               
                                </div>
                            </div>
                        </div>
                        <br><br>`

                        if(item.refund == '1' && item.Payment_status == '2'){
                           
                     
                    detailsHtml +=`
                        <div class="pricing-info">
                            <h3>Thông tin tài khoản ngân hàng</h3>
                            <div class="form-row">
                                <div>
                                    <label for="price">Tên ngân hàng: ${item.TenNH}</label>
                                </div>
                                 <div>
                                    <div style="position: relative;">
                            <input type="password" class="form-control" id="stk" name="stk"  maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="${item.SoNH}" readonly>
                            <span onclick="toggleSTK()" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                👁️
                            </span>
                            </div>
                                </div>
                               
                            </div>
                        </div><br><br>`
                        }
                     
                         detailsHtml +=` <!-- Thông tin thành viên tham gia -->
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
                                <input type="text" name="ht" value="${participant.hoten}" readonly>
                            </div>
                            <div>
                                <label>Ngày sinh:</label>
                                <input type="date" name="ns" value="${participant.ngaysinh}" readonly>
                            </div>
                            <div>
                                <label>Giới tính:</label>
                               <br>
                                <label>${participant.gioitinh}</label>
                                   
                                    
                                
                            </div>
                             <div>
                               
                            </div>
                        </div>
                    <br>`;
                });

                detailsHtml += `
                        </div> <!-- Kết thúc thông tin thành viên -->
                    </div> <!-- Kết thúc container -->
                `;

                $('#xemtour').html(detailsHtml); 
            } else {
                $('#xemtour').html('<div class="col">Không tìm thấy dữ liệu.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy dữ liệu:', error);
            $('#xemtour').html('<div class="col">Đã xảy ra lỗi khi tải dữ liệu.</div>');
        }
    });
}
function toggleSTK() {
  const input = document.getElementById("stk");
  if (input.type === "password") {
    input.type = "text";
  } else {
    input.type = "password";
  }
}
function capnhathoadon() {
    $('#capnhathoadon').submit(function (e) {
        e.preventDefault(); // Ngăn chặn reload trang khi submit

        let data = {
            action: "capnhathoadon",
            booking_id: $("#booking_id").val(),
            arrival: $("#arrival").val(),
            user_name: $("#fullname").val(),
            phone_num: $("#phone").val(),
            address: $("#address").val(),
            participants: []
        };

        $(".form-row1").each(function () {
            let participant = {
                idpar: $(this).find("input[name='idpar']").val(),
                hoten: $(this).find("input[name='ht']").val(),
                ngaysinh: $(this).find("input[name='ns']").val(),
                gioitinh: $(this).find("select[name='gioit']").val()
            };
            data.participants.push(participant);
        });

        console.log("Dữ liệu gửi đi:", data); // Debug

        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: JSON.stringify(data), // Gửi đúng dữ liệu
            contentType: 'application/json',
            success: function (response) {
               
                openPopup('Cập nhật thành công','');
                setTimeout(function() {
                    window.location.href = 'indexa.php?qldichvu';
                }, 1000);
            },
            error: function (xhr, status, error) {
                console.error('Lỗi AJAX:', status, error);
                console.error('Chi tiết lỗi:', xhr.responseText);
                openPopup('Lỗi', 'Không thể gửi yêu cầu. Vui lòng thử lại!');
            }
        });
    });
}



$(document).ready(function() {
    
      xemdichvu();
capnhathoadon();
    
   });
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