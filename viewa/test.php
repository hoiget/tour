<?php


require_once('../tcpdf/tcpdf.php'); // Đảm bảo thư viện TCPDF đã được tải lên
require_once('../api/connect.php'); // Kết nối cơ sở dữ liệu

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
    $queryDetails = "SELECT * FROM booking_detail_tour INNER JOIN participant ON booking_detail_tour.Booking_id = participant.idbook 
    INNER JOIN booking_ordertour ON booking_detail_tour.Booking_id = booking_ordertour.Booking_id  WHERE booking_detail_tour.Booking_id = ?";
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
    $html .= '<p><strong>Mã tour:</strong> ' . $orderData['Booking_id'] . '</p>';
    $departureDate = new DateTime($orderData['Datetime']);
    $html .= '<p><strong>Ngày khởi hành:</strong> ' . $departureDate->format('d/m/Y') . '</p>';
    $html .= '<p><strong>Phương tiện:</strong> ' . $orderData['Arrival'] . '</p>';
    $html .= '<p><strong>Số người tham gia:</strong> ' . $orderData['participants'] . '</p>';
    $html .= '<h3>Thành viên tham gia:</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Phân loại</th>
                    </tr>
                </thead>
                <tbody>';
   
    foreach ($details as $index => $detail) {
        $departureDate1 = new DateTime($detail['ngaysinh']);
        $html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . $detail['hoten'] . '</td>
                    <td>' . $departureDate1->format('d/m/Y') . '</td>
                    <td>' . $detail['gioitinh'] . '</td>
                    <td>' . $detail['phanloai'] . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';
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

                if (!empty($details)) {
                    $detail = $details[0]; // Lấy chỉ một bản ghi đầu tiên
                    $html .= '<tr>
                                <td>1</td>
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