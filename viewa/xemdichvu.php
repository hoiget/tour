
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
    
.table-container,.form-container {
    width: 100%; /* Chiều rộng đầy đủ */
    overflow-x: auto; /* Cuộn ngang nếu nội dung vượt quá chiều rộng */
    overflow-y: auto; /* Cuộn dọc nếu cần */
    max-height: 500px; /* Giới hạn chiều cao tối đa */
    border: 1px solid #ddd; /* Đường viền để dễ nhận diện */
    border-radius: 8px;
    background-color: white; /* Đảm bảo nền trắng cho vùng cuộn */
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
/* Kiểu cho nút .but */
.but {
    background-color: #4CAF50; /* Màu nền xanh lá */
    color: white; /* Màu chữ trắng */
    padding: 10px 14px; /* Khoảng cách xung quanh chữ */
    border: none; /* Không viền */
    border-radius: 8px; /* Bo tròn góc */
    cursor: pointer; /* Hiển thị con trỏ chuột khi di chuột lên nút */
    font-size: 16px; /* Kích thước chữ */
    text-align: center; /* Canh giữa chữ */
    transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu nền khi hover */
}

/* Hiệu ứng khi hover */
.but:hover {
    background-color: #45a049; /* Màu nền tối hơn khi hover */
}

/* Responsive: Cải thiện hiển thị trên màn hình nhỏ */
@media (max-width: 600px) {
    .but {
        width: 100%; /* Nút chiếm toàn bộ chiều rộng trên màn hình nhỏ */
        padding: 12px; /* Điều chỉnh khoảng cách khi màn hình nhỏ */
    }
}
  .description {
    white-space: nowrap; /* Không cho phép xuống dòng */
    overflow: hidden; /* Ẩn nội dung vượt quá */
    text-overflow: ellipsis; /* Thêm dấu "..." khi nội dung bị cắt */
    max-width: 200px; /* Đặt độ rộng tối đa của cột (tùy chỉnh theo nhu cầu) */
}

    </style>

<h1>Quản lý dịch vụ tour</h1>

<div class="container">
    <div class="search-bar">
 
  
</div>


<div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tour</th>
                    <th>Thời gian khởi hành</th>
                    <th>Thời gian</th>
                    <th>Địa điểm</th>
                    <th>Lịch trình</th>
                    <th>Trạng thái</th>
                   <th>Thao tác</th>
                    
                </tr>
            </thead>
           
            <tbody id="employee-table">
            </tbody>
                <!-- Add more rows as needed -->
           
        </table>
</div>
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

 
      function xemdichvuhdv() {
    $.ajax({
        url: './api/apia.php?action=xemdichvuhdv',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.idtourshe}</td>
                    <td>${event.tourname}</td>
                    <td>${event.Date}</td>
                    <td>${event.Schedule}</td>
                    <td>${event.Locations}</td>
                    <td class="description">${event.Itinerary}</td>
                    
                  
                    `;
               
                    if(event.Trangthai == 1){
                     eventHtml += '<td><span style="color:green">Hoạt động</span></td><td>Lịch trình chưa thể viết báo cáo</td>' 
                    }else if(event.Trangthai == 2){
                        eventHtml += '<td><span style="color:purple">Sắp khởi hành</span></td><td>Lịch trình chưa thể viết báo cáo</td>' 
                    }else if(event.Trangthai == 3){
                        eventHtml += '<td><span style="color:red">Lịch trình bị hủy</span></td><td>Lịch trình chưa thể viết báo cáo</td>'
                    }else if(event.Trangthai == 4){
                        eventHtml += '<td><span style="color:violet">Lịch trình đã hoàn thành</span></td>'
                        eventHtml += '<td><a href="indexa.php?baocao&idtour='+ event.id_tour +'"><button class="but">Viết báo cáo </button></a></td>'
                        
                    }
                
                    
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
    
      xemdichvuhdv();

    
   });
</script>
