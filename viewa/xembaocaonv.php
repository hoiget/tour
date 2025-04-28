<?php
include './api/connect.php';
$user_id=$_SESSION['id'] ;
$stmt = $conn->query("SELECT r.*, e.Name as guide_name,t.Name AS tourname
                     FROM reports r 
                     JOIN employees e ON r.guide_id = e.id
                     JOIN tour t ON r.tour =t.id
                     WHERE r.guide_id='$user_id'");

$reports = [];
while ($row = $stmt->fetch_assoc()) {
    $reports[] = $row;
}?>
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
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Hướng dẫn viên</th>
            <th>Loại báo cáo</th>
            <th>Nội dung</th>
            <th>Tên tour</th>
            <th>File đính kèm</th>
            <th>Trạng thái</th>
         
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reports as $r) { ?>
            <tr>
                <td data-label="ID"><?= htmlspecialchars($r['id']) ?></td>
                <td data-label="Hướng dẫn viên"><?= htmlspecialchars($r['guide_name']) ?></td>
                <td data-label="Loại báo cáo"><?= ($r['report_type'] == 'tour') ? 'Báo cáo tour' : 'Báo cáo công việc' ?></td>
                <td data-label="Nội dung">

                    <div class="details" >
                        <?= nl2br(htmlspecialchars($r['report_content'])) ?>
                    </div>
                    <button class="details-btn" onclick="toggleDetails(this)">Xem chi tiết</button>
                </td>
                <td data-label="Tên tour">
                <?= htmlspecialchars($r['tourname']) ?>
                
                </td>
               
                <td data-label="File đính kèm">
                    <?php if (!empty($r['report_file'])) { ?>
                       
                        <a href="./uploads/reports/<?=$r['report_file']?>" download target="_blank" class="pdf-btn1">Tải file</a>


                    <?php } else { ?>
                        Không có file
                    <?php } ?>
                </td>
                <td data-label="Trạng thái"><?= ucfirst(htmlspecialchars($r['status'])) ?></td>
               
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
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