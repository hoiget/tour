<?php
require_once('tcpdf/tcpdf.php');

// Tạo một lớp mới kế thừa từ FPDF
class PDF extends TCPDF {
    // Phương thức để vẽ bảng dữ liệu
    function DrawTable($header, $data, $columnWidths, $title, $titleColor) {
        // Định dạng font chữ và kích thước
        $this->SetFont('dejavusans', '', 12);

        // Đặt màu sắc cho tiêu đề
        $this->SetFillColor($titleColor[0], $titleColor[1], $titleColor[2]);

        // Vẽ tiêu đề
        $this->Cell(array_sum($columnWidths), 10, $title, 1, 0, 'C', true);
        $this->Ln();

        // Thiết lập lại màu sắc cho dữ liệu hàng
        $this->SetFillColor(255, 255, 255);

        // Vẽ tiêu đề cột
        foreach ($header as $colIndex => $col) {
            $this->Cell($columnWidths[$colIndex], 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();

        // Vẽ dữ liệu hàng
        foreach ($data as $row) {
            foreach ($row as $colIndex => $col) {
                $this->Cell($columnWidths[$colIndex], 10, $col, 1, 0, 'C');
            }
            $this->Ln();
        }
    }
}
?>