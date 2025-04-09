<?php
require_once('./tcpdf/tcpdf.php');
require_once('./api/connect.php');

if (isset($_GET['xemlichsu']) && isset($_GET['download']) && $_GET['download'] == 1) {
    // XUẤT PDF
    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Tour System');
    $pdf->SetTitle('Lịch sử hoạt động');
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->AddPage();
    $pdf->SetFont('dejavusans', '', 10);

    // Truy vấn dữ liệu
    $query = "
        SELECT activity_logs.*, 
               employees.Username, 
               user_credit.Name 
        FROM activity_logs
        LEFT JOIN employees ON activity_logs.user_id = employees.id AND activity_logs.user_type = 'employees'
        LEFT JOIN user_credit ON activity_logs.user_id = user_credit.id AND activity_logs.user_type = 'user'
        ORDER BY created_at DESC
    ";
    $result = $conn->query($query);

    // HTML PDF
    $html = '<h2 style="text-align:center;">Lịch sử hoạt động</h2>';
    $html .= '<table border="1" cellpadding="5">
        <thead>
            <tr>
               
                <th><b>Tên</b></th>
                <th><b>Hoạt động</b></th>
                <th><b>Tóm tắt</b></th>
                <th><b>Vai trò</b></th>
                <th><b>Ngày</b></th>
            </tr>
        </thead><tbody>';

    while ($row = $result->fetch_assoc()) {
        $name = ($row['user_type'] === 'user') ? $row['Name'] : $row['Username'];
        $html .= '<tr>
         
            <td>' . htmlspecialchars($name) . '</td>
            <td>' . htmlspecialchars($row['action_type']) . '</td>
            <td>' . htmlspecialchars($row['description']) . '</td>
            <td>' . htmlspecialchars($row['user_type']) . '</td>
            <td>' . $row['created_at'] . '</td>
        </tr>';
    }

    $html .= '</tbody></table>';
    ob_end_clean();
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('lich_su_hoat_dong.pdf', 'D'); // Tải về
    exit;
}
?>

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
        .form-container input{
            width: 100%;
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
        .description {
    white-space: nowrap; /* Không cho phép xuống dòng */
    overflow: hidden; /* Ẩn nội dung vượt quá */
    text-overflow: ellipsis; /* Thêm dấu "..." khi nội dung bị cắt */
    max-width: 100px; /* Đặt độ rộng tối đa của cột (tùy chỉnh theo nhu cầu) */
}

@media screen and (max-width: 768px) {
  table thead {
    display: none;
  }

  table, table tbody, table tr, table td {
    display: block;
    width: 100%;
  }

  table tr {
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    background-color: white;
  }

  table td {
    text-align: left;
    padding-left: 50%;
    position: relative;
  }

  table td::before {
    position: absolute;
    left: 15px;
    width: 45%;
    white-space: nowrap;
    font-weight: bold;
    color: #333;
    content: attr(data-header); /* lấy label từ thuộc tính data-header */
  }
}
    </style>
<h1>Xem lịch sử hoạt động</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="suatienich" id="suatienich" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="suatienich">
            <div id="xemtienich"></div>
            </form>
            </div>
        </div>
    </div>
</div> 
    <div class="container">
    <div class="search-bar">
    
    <a href="indexa.php?xemlichsu&download=1" class="btn"><i class="fas fa-file-pdf"></i> Tải PDF</a>


</div>


        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Hoạt động</th>
                    <th>Tóm tắt</th>
                    <th>Vai trò</th>
                    <th>Ngày</th>

                </tr>
            </thead>
           
            <tbody id="employee-table">
            </tbody>
                <!-- Add more rows as needed -->
           
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    
    function applyResponsiveTableHeaders() {
  const table = document.querySelector('table');
  const headers = Array.from(table.querySelectorAll('thead th'));
  const rows = table.querySelectorAll('tbody tr');

  rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    cells.forEach((cell, index) => {
      if (headers[index]) {
        cell.setAttribute('data-header', headers[index].innerText);
      }
    });
  });
}

document.addEventListener('DOMContentLoaded', applyResponsiveTableHeaders);

 
      function xemlichsu() {
    $.ajax({
        url: './api/apia.php?action=xemlog',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            console.log(response); // Kiểm tra dữ liệu nhận được từ server
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.id}</td>`;
                    if(event.user_type == 'user'){
                        eventHtml += `<td>${event.Name}</td>`;
                    }else if(event.user_type == 'employees'){
                       
                      eventHtml += `<td>${event.Username}</td>`;
                    }
                     eventHtml += ` <td>${event.action_type}</td>
                    <td>${event.description}</td>
                    <td>${event.user_type}</td>
                    <td>${event.created_at}</td>
                    `;
                
                    
                     eventHtml +=`
                </tr> 
`;
                });
                $('#employee-table').html(eventHtml);
                applyResponsiveTableHeaders();
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









$(document).ready(function() {
     
       xemlichsu();
    
   });
</script>

