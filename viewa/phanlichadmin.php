
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
<h1>Phân lịch</h1>

<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="thaytglv" id="thaytglv" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="thaytglv">
            <div class="form-container">
            <div id="xemhdv"></div>
            
                            
            </div>
            <center><button type="submit" class="submit-btn">Cập nhật</button></center>
            </div>
            </form>
            </div>
        </div>
    </div>
</div> 
    <div class="container">
  
    <div class="search-bar">
 
 <button class="btn edit1" data-bs-toggle="modal" data-bs-target="#ratingModalthem">+</button>
<div class="modal fade" id="ratingModalthem" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
     <div class="modal-content">
         <div class="modal-header">
            
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
         <div class="form-container">
                     <h2> Phân lịch làm việc</h2>
                 <form class="phanlich" id="phanlich" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
                     <input type="hidden" name="action" value="phanlich">
                     <div class="form-group">
                             <div>
                           <label for="hdv">Thời gian làm việc:</label>
                            <input type="datetime-local" name="dat" id="dat" >
                            
                            </div>
                             <div>
                           <label for="hdv">Tên nhân viên:</label>
                           <select name="emi" id="emi">
                            <option value="" selected>Chọn nhân viên</option>
                        </select>

                            </div>
                    
                            
                        </div>
                     
                     <center><button type="submit" class="submit-btn">Thêm</button></center>
                 </form>
                 </div>
         </div>
     </div>
 </div>
</div> 
</div>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Lịch làm việc</th>
                <th>Nhân viên</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="employee-table"></tbody>
    </table>
</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
      function xemlichad() {
    $.ajax({
        url: './api/apia.php?action=phanlichadmin',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
         
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.idschedule}</td>
                    <td>${event.work_date}</td>
                    
                    <td>${event.Name}</td>
                  `;
                
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.idschedule}')">🖉</button>
                            <button class="btn delete" onclick="xoalich('${event.idschedule}')">🗑</button>
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


function phanlich() {
    $('#phanlich').submit(function (e) {
        e.preventDefault();

        // Thu thập dữ liệu form
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: formData,
            contentType: false, // Bắt buộc khi sử dụng FormData
            processData: false, // Ngăn jQuery xử lý dữ liệu
            success: function (response) {
                console.log(response);
               // Để kiểm tra chính xác dữ liệu phản hồi
                if (response === 'insert_success') {
                    openPopup('Thông báo', 'Thêm thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?PL';
                    }, 2000);
                }else if (response === 'duplicate_date'){
                    openPopup('Thông báo', 'Ngày đẫ tồn tại');
                }      
                else  {
                    openPopup('Thông báo', 'Không thêm được');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}


function openRatingModal(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    fetch(`./api/apia.php?action=plsua&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                const tour = data[0]; // Lưu thông tin phòng từ API
                document.getElementById('xemhdv').innerHTML = `
                   
                        <h2>Thay đổi thời gian làm việc</h2>
                        <input type="number" hidden id="id" name="id" value="${tour.idschedule}">
                        <div class="form-group">
                             <div>
                           <label for="hdv">Thời gian làm việc:</label>
                            <input type="datetime-local" name="dat" id="dat" value="${tour.work_date}">
                            
                            </div>
                             <div>
                           <label for="hdv">Tên nhân viên:</label>
                             <input hidden type="text" name="emi" id="emi" value="${tour.idem}">
                            <input type="text" name="emi1" id="emi1" value="${tour.Name}">
                            
                            </div>
                    
                            
                        </div>
                        
                        
                        `;
                 
            } else {
                document.getElementById('xemhdv').innerHTML = 'Không tìm thấy tour';
            }
        })
        .catch(error => console.error('Error:', error));
}

function xemem() {
    $.ajax({
        url: './api/apia.php?action=xemem',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '<option value="" selected>Chọn nhân viên</option>'; // Giữ option mặc định

                // Lặp qua các sự kiện và tạo các option tương ứng
                events.forEach(function(event) {
                    eventHtml += `<option value="${event.id}">${event.Name}</option>`;
                });

                // Cập nhật nội dung của thẻ <select>
                $('#emi').html(eventHtml);
            } else {
                console.warn('Không tìm thấy HDV');
                $('#emi').html('<option value="">Không tìm thấy thông tin người dùng.</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi gọi API:', error); // Kiểm tra lỗi API
            $('#emi').html('<option value="">Đã xảy ra lỗi khi tải thông tin người dùng.</option>');
        }
    });
}



function thaytglv() {
    $('#thaytglv').submit(function (e) {
        e.preventDefault();

        // Thu thập dữ liệu form
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: formData,
            contentType: false, // Bắt buộc khi sử dụng FormData
            processData: false, // Ngăn jQuery xử lý dữ liệu
            success: function (response) {
               // Để kiểm tra chính xác dữ liệu phản hồi
                if (response === 'update_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?PL';
                    }, 2000);
                } else{
                    openPopup('Thông báo', 'Lỗi');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

function xoalich(id) {
       
       fetch('./api/apia.php?action=xoalich&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?PL';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}



$(document).ready(function() {
      xemem();
  xemlichad();
     thaytglv();
     phanlich();
   });
</script>
