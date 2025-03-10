
<style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    width: 90%;
    margin: 20px auto;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.search-bar {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 10px;
}

.search-bar input {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 250px;
}

/* Bảng phân lịch */
.table-container {
    width: 100%;
    overflow-x: auto;
    max-height: 500px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: white;
    padding: 10px;
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
    background-color: #007bff;
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

/* Nút bấm */
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
    transition: 0.3s;
}

.btn.edit {
    background-color: #007bff;
    color: white;
}

.btn.edit:hover {
    background-color: #0056b3;
}

.btn.delete {
    background-color: #dc3545;
    color: white;
}

.btn.delete:hover {
    background-color: #a71d2a;
}

/* Form cập nhật hướng dẫn viên */
.form-container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: auto;
}

.form-container h2 {
    text-align: center;
    margin-bottom: 15px;
    font-size: 18px;
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

.form-container select, .form-container input, .form-container textarea {
    width: 100%;
    padding: 8px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.submit-btn {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s;
}

.submit-btn:hover {
    background-color: #0056b3;
}

/* Hiệu ứng khi hiển thị danh sách hướng dẫn viên */
#hdv {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 8px;
    background-color: #fff;
}

/* Chỉnh sửa modal */
.modal-content {
    border-radius: 10px;
    overflow: hidden;
}

.modal-header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    font-size: 18px;
}

.modal-body {
    padding: 20px;
}

/* Hiển thị lịch trình dạng cột */
.description {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
}


    </style>
<h1>Phân lịch hướng dẫn viên</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="capnhathdv" id="capnhathdv" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="capnhathdv">
            <div class="form-container">
            <div id="xemhdv"></div>
            <div class="form-group">
            <div>
                           <label for="hdv">Tên nhân viên:</label>
                           <select name="hdv1" id="hdv">
                            <option value="" selected>Chọn nhân viên</option>
                        </select>

                            </div>
                            
            </div>
            <center><button type="submit" class="submit-btn">Cập nhật</button></center>
            </div>
            </form>
            </div>
        </div>
    </div>
</div> 
    <div class="container">
  

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên tour</th>
                <th>Ngày khởi hành</th>
                <th>Lịch trình</th>
                <th>Địa điểm khởi hành</th>
                <th>Lượt đặt</th>
                <th>Hướng dẫn viên</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="employee-table"></tbody>
    </table>
</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
      function xemlichtrinh() {
    $.ajax({
        url: './api/apia.php?action=xemlichtrinh',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.idsh}</td>
                    <td>${event.Name}</td>
                    <td>${event.Date}</td>
                    <td>${event.Schedule}</td>
                    <td>${event.Locations}</td>
                     <td>${event.Orders}</td>
                    <td>${event.emna || ""}</td>
                  `;
                
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.idsh}')">🖉</button>
                           
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





function openRatingModal(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    fetch(`./api/apia.php?action=xemlichtrinh1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                const tour = data[0]; // Lưu thông tin phòng từ API
                document.getElementById('xemhdv').innerHTML = `
                   
                        <h2>Phân hướng dẫn viên</h2>
                        <input hidden type="number" id="id" name="id" value="${tour.id}">
                        <input hidden type="datetime" id="date" name="date" value="${tour.Date}">
                        <div class="form-group">
                             <div>
                           <label for="hdv">Tên lịch trình:${tour.Name}</label>
                    
                            
                            </div>
                    
                            
                        </div>
                        
                        
                        `;
                 
            } else {
                document.getElementById('xemhdv').innerHTML = 'Không tìm thấy tour';
            }
        })
        .catch(error => console.error('Error:', error));
}

function xemhdv() {
    $.ajax({
        url: './api/apia.php?action=xemHDV',
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
                $('#hdv').html(eventHtml);
            } else {
                console.warn('Không tìm thấy HDV');
                $('#hdv').html('<option value="">Không tìm thấy thông tin người dùng.</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi gọi API:', error); // Kiểm tra lỗi API
            $('#hdv').html('<option value="">Đã xảy ra lỗi khi tải thông tin người dùng.</option>');
        }
    });
}



function capnhathdv() {
    $('#capnhathdv').submit(function (e) {
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
                console.log(response); // Để kiểm tra chính xác dữ liệu phản hồi
                if (response === 'update_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?hdv';
                    }, 2000);
                }else if (response === 'insert_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?hdv';
                    }, 2000);
                }
                else if (response === 'duplicate_date') {
                    openPopup('Thông báo', 'Hướng dẫn viên này đã có lịch');
                }else if (response.startsWith('schedule_conflict|')) {
                    let messageParts = response.split('|');
                    openPopup('Cảnh báo',messageParts[1]+'\nVui lòng chọn nhân viên khác');
                } 
                 else{
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





$(document).ready(function() {
      
  xemlichtrinh();
      capnhathdv();
    xemhdv();
   });
</script>
