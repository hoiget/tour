<?php
include './api/connect.php';

$stmt = $conn->query("SELECT r.*, e.Name as guide_name,t.Name AS tourname
                     FROM reports r 
                     JOIN employees e ON r.guide_id = e.id
                     JOIN tour t ON r.tour =t.id");

$reports = [];
while ($row = $stmt->fetch_assoc()) {
    $reports[] = $row;
}
if (isset($_GET['action']) && $_GET['action'] == 'exportPdf' && isset($_GET['id'])) {
    require('./tcpdf/tcpdf.php'); // Đảm bảo thư viện đã tải lên

    $id = intval($_GET['id']); // Chống SQL Injection

    $stmt = $conn->prepare("SELECT r.*, e.Name as guide_name FROM reports r 
                            JOIN employees e ON r.guide_id = e.id 
                            WHERE r.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();

    if (!$report) {
        die("Báo cáo không tồn tại!");
    }

    // Khởi tạo PDF
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($report['guide_name']);
    $pdf->SetTitle("Báo cáo ID " . $report['id']);
    $pdf->AddPage();

    // Set Font
    $pdf->SetFont('dejavusans', '', 12);

    // Nội dung báo cáo
    $html = '
        <h2 style="text-align: center;">BÁO CÁO HƯỚNG DẪN VIÊN</h2>
        <p><b>ID Báo Cáo:</b> ' . $report['id'] . '</p>
        <p><b>Hướng dẫn viên:</b> ' . htmlspecialchars($report['guide_name']) . '</p>
        <p><b>Loại báo cáo:</b> ' . (($report['report_type'] == 'tour') ? 'Báo cáo tour' : 'Báo cáo công việc') . '</p>
        <p><b>Nội dung:</b> ' . nl2br(htmlspecialchars($report['report_content'])) . '</p>
    ';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Xuất file PDF
    ob_end_clean(); // Dọn dẹp bộ đệm đầu ra trước khi gửi PDF
    $pdf->Output("baocao_" . $report['id'] . ".pdf", "D");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách báo cáo</title>
    <style>
       body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        margin: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #007bff;
        color: white;
    }
    tr:hover {
        background: #f1f1f1;
    }
    .approve-btn {
        background: #28a745;
        color: white;
        padding: 6px 12px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        margin: 2px;
    }
    .reject-btn {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        margin: 2px;
    }
    .details {
        display: -webkit-box;
        -webkit-line-clamp: 1; /* Giới hạn hiển thị 3 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        white-space: normal;
        word-wrap: break-word;
        transition: all 0.3s ease;
    }
    .details.show {
        display: block;
        -webkit-line-clamp: unset;
    }
    .details-btn {
        background: none;
        color: #007bff;
        border: none;
        cursor: pointer;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }
    .pdf-btn {
    background: #ff9800;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
}
.pdf-btn:hover {
    background: #e68900;
}
.pdf-btn1 {
    background:rgb(55, 70, 201);
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
}

@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    thead {
        display: none;
    }

    tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
        padding: 10px;
        background: white;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    td {
        position: relative;
        padding-left: 50%;
        text-align: left;
        border: none;
        border-bottom: 1px solid #eee;
    }

    td::before {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        color: #555;
        content: attr(data-label);
    }

    .details-btn {
        margin-left: 12px;
    }
   
}

    </style>
</head>
<body>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Hướng dẫn viên</th>
            <th>Loại báo cáo</th>
            <th>Tên tour</th>
            <th>Nội dung</th>
            <th>Xuất nội đung</th>
            <th>File đính kèm</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reports as $r) { ?>
            <tr>
                <td data-label="ID"><?= htmlspecialchars($r['id']) ?></td>
                <td data-label="Hướng dẫn viên"><?= htmlspecialchars($r['guide_name']) ?></td>
                <td data-label="Loại báo cáo"><?= ($r['report_type'] == 'tour') ? 'Báo cáo tour' : 'Báo cáo công việc' ?></td>
                <td data-label="Tên tour"><?= htmlspecialchars($r['tourname']) ?></td>
                <td data-label="Nội dung">
                    <div class="details"><?= nl2br(htmlspecialchars($r['report_content'])) ?></div>
                    <button class="details-btn" onclick="toggleDetails(this)">Xem chi tiết</button>
                </td>
                <td data-label="Xuất nội đung" >
                    <a href="indexa.php?xembaocao&action=exportPdf&id=<?= $r['id'] ?>" target="_blank" class="pdf-btn">Tải về</a>
                </td>
                <td data-label="File đính kèm">
                    <?php if (!empty($r['report_file'])) { ?>
                        <a href="./uploads/reports/<?=$r['report_file']?>" download target="_blank" class="pdf-btn1">Tải file</a>
                    <?php } else { ?>
                        Không có file
                    <?php } ?>
                </td>
                <td data-label="Trạng thái"><?= ucfirst(htmlspecialchars($r['status'])) ?></td>
                <td data-label="Hành động">
                    <?php if ($r['status'] == 'pending') { ?>
                        <button class="approve-btn" onclick="approveReport(<?= $r['id'] ?>)">✔ Duyệt</button>
                        <button class="reject-btn" onclick="rejectReport(<?= $r['id'] ?>)">✖ Từ chối</button>
                    <?php } ?>
                </td>
            </tr>

        <?php } ?>
    </tbody>
</table>
<script>
function approveReport(id) {
    fetch(`./api/apia.php?action=approveReport&id=${id}`)
    .then(response => response.json())
    .then(data => {
        console.log(data)
        alert(data.message);
        location.reload();
    });
}

function rejectReport(id) {
    fetch(`./api/apia.php?action=rejectReport&id=${id}`)
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}
function toggleDetails(button) {
    let details = button.previousElementSibling;
    if (details.classList.contains("show")) {
        details.classList.remove("show");
        button.innerText = "Xem chi tiết";
    } else {
        details.classList.add("show");
        button.innerText = "Ẩn";
    }
}
</script>

</body>
</html>
