
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
    </style>

<h1>Quản lý dịch vụ khách sạn</h1>
<div class="container">
    <div class="search-bar">
 
  
</div>


<div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên phòng</th>
                    <th>Gía tour</th>
                    <th>Tổng thanh toán</th>
                    <th>Số phòng</th>
                    <th>Người đặt</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Ngày đặt</th>
                    <th>Trạng Thái</th>
                    <th>Action</th>
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
      function xemdichvuks() {
    $.ajax({
        url: './api/apia.php?action=xemdichvuks',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.Booking_id}</td>
                    <td>${event.room_name}</td>
                    <td>${event.price}</td>
                    <td>${event.total_pay}</td>
                    <td>${event.room_no}</td>
                    <td>${event.user_name}</td>
                    <td>${event.phonenum}</td>
                    <td>${event.address}</td>
                    <td>${event.Check_in}</td>
                    <td>${event.Check_out}</td>
                    <td>${event.Datetime}</td>
                    
                    `;
                if(event.Refund == '1'){
                    eventHtml += '<td><span style="color:red">Hủy đơn</span>' 
                    if(event.Payment_status =='2')[
                        eventHtml += '<br><span style="color:orange;">Chưa hoàn tiền</span></td>' 
                    ]
                }else{
                    if(event.Booking_status == '1'){
                     eventHtml += '<td><span style="color:green">Chưa xác nhận</span></td>' 
                    }
                }
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" onclick="xacnhanks('${event.Booking_id}')">✔</button>
                            <button class="btn delete" onclick="huydonks('${event.Booking_id}')">🗑</button>
                        </div>
                    </td>
                </tr> 
`;
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


function xacnhanks(id) {
       
       fetch('./api/apia.php?action=xacnhanks&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xác nhận thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qldichvuks';
                   }, 1000);
               } else {
                   openPopup('Xác nhận không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
function huydonks(id) {
       
       fetch('./api/apia.php?action=huydonks&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qldichvuks';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}

$(document).ready(function() {
    
      xemdichvuks();

    
   });
</script>
