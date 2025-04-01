<?php


require_once('../tcpdf/tcpdf.php'); // Đảm bảo thư viện TCPDF đã được tải lên
require_once('../api/connect.php'); // Kết nối cơ sở dữ liệu

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
            $this->Image('../assets/img/banner.jpg', 5, 5, 200, 40, 'PNG');
            $this->Ln(25); // Xuống dòng sau ảnh
        }

        public function Footer() {
            $this->SetY(-45); // Dịch footer lên cao hơn nếu bị che
            $this->Image('../assets/img/footer.jpg', 5, $this->GetY(), 200, 40, 'PNG'); // Giảm chiều cao từ 40 xuống 25
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
    

// $folder = './pdf/';
$folder = __DIR__ . "/../pdf/";
if (!file_exists($folder)) {
    mkdir($folder, 0777, true); // Tạo thư mục nếu chưa có
}

// Tên file PDF
$filename = 'booking_details_' . $bookingId . '.pdf';
$filePath = $folder . $filename;
ob_end_clean(); 
// Xuất file PDF vào thư mục
$pdf->Output($filePath, 'F'); // 'F' để lưu file trên server

// Trả về URL tải file
$pdfUrl = "http://localhost/tour/pdf/" . $filename; // Đổi yourdomain.com thành tên miền của bạn
echo json_encode(['status' => 'success', 'pdf_url' => $pdfUrl]);

exit;

}
?>