
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


    </style>
<h1>Xem tour theo yêu cầu</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
            <div id="xemchitiet"></div>
            </form>
            </div>
        </div>
    </div>
</div> 
    <div class="container">
    <div class="search-bar">
 
</div>


        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Tên tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Gía tour</th>
                    <th>Lịch trình</th>
                    <th>Ngày ở</th>
                    <th>Phương tiện</th>
                    <th>Action</th>
                </tr>
            </thead>
           
            <tbody id="employee-table">
            </tbody>
                <!-- Add more rows as needed -->
           
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
      function xemtouryeucau() {
    $.ajax({
        url: './api/apia.php?action=xemtouryeucau',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.id_request}</td>
                    <td>${event.customer_name}</td>
                    <td>${event.tour_name}</td>
                    <td>${event.departure_date}</td>
                    <td>${event.tour_price}</td>
                    <td class="description">${event.itinerary}</td>
                      <td>${event.tour_duration}</td>
                        <td>${event.phuongtien}</td>
                    `;
                
                    
                     eventHtml +=`<td><div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.id_request}')">Xem chi tiết</button>
                            <button class="btn delete" onclick="xoatu('${event.id_request}')">🗑</button>
                        </div></td>
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

function openRatingModal(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    fetch(`./api/apia.php?action=xemtouryeucau1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                document.getElementById('xemchitiet').innerHTML = `
                    <div class="form-container">
                        <h2>xem chi tiết</h2>
                        <span><b>Tên khách hàng:</b> ${data[0].customer_name}</span><br>
                        <span><b>Tên tour:</b> ${data[0].tour_name}</span><br>
                        <span><b>Ngày khởi hành:</b> ${data[0].departure_date}</span><br>
                         <span><b>Gía tour:</b> ${data[0].tour_price}</span><br>
                        <span><b>Ngày ở:</b> ${data[0].tour_duration}</span><br>
                        <span><b>Phương tiện:</b> ${data[0].phuongtien}</span><br>
                        <span><b>Lịch trình:</b> ${data[0].itinerary}</span><br>
                        
                        
                        
                    </div>`;
            } else {
                document.getElementById('xemchitiet').innerHTML = 'Không tìm thấy tour';
            }
        })
        .catch(error => console.error('Error:', error));
}

function xoatu(id) {
       
       fetch('./api/apia.php?action=xoatu&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?touryeucau';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}


$(document).ready(function() {
      
       xemtouryeucau();
     
   });
</script>
