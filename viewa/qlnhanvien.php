
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
           
            display: flex;
            justify-content: space-around;
            margin-bottom: 15px;
        }
        .form-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }
        .form-group input, .form-group select {
            width: 120%;
            padding: 8px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group select {
            width: 100%;
        }
        .form-group.full-width select {
            width: 100%;
            height: 40px;
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
        .table-container {
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

    </style>
<h1>Quản lý nhân viên</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="capnhatnv" id="capnhatnv" action="./api/apia.php" method="post"> 
            <input type="hidden" name="action" value="capnhatnv">
            <div id="xemnv1"></div>
            </form>
            </div>
        </div>
    </div>
</div> 
    <div class="container">
    <div class="search-bar">
    <input type="text" id="search" name="MANV" placeholder="Tìm kiếm mã nhân viên" onkeydown="searchEmployee(event)">
</div>


<div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã nhân viên</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày tạo</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
           
            <tbody id="employee-table">
            </tbody>
                <!-- Add more rows as needed -->
           
        </table>
    </div> </div>
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

      function xemnhanvien() {
    $.ajax({
        url: './api/apia.php?action=xemnhanvien',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    applyResponsiveTableHeaders();
                    eventHtml += `
                     
                      <tr>
                    <td>${event.Employee_code}</td>
                    <td>${event.Username}</td>
                    <td>${event.Email}</td>
                    <td>${event.Phone_number}</td>
                    <td>${event.Address}</td>
                    <td>${event.Created_at}</td>`;
                    if(event.Permissions == "QL"){
                    eventHtml +='<td>nhân viên quản lý dịch vụ</td>';
                }else if(event.Permissions == "CSKH"){
                    eventHtml +='<td>nhân viên Chăm sóc khách hàng</td>';
                }else if(event.Permissions == "HDV"){
                    eventHtml +='<td>Hướng dẫn viên</td>';
                }
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.id}')">🖉</button>
                            <button class="btn delete" onclick="xoanhanvien('${event.id}')">🗑</button>
                        </div>
                    </td>
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

function searchEmployee(event) {
    if (event && event.key === "Enter") {  // Kiểm tra nếu event và phím bấm là Enter
        var searchValue = $('#search').val(); // Lấy giá trị từ ô input với id "search"

        // Nếu không có gì để tìm kiếm, không làm gì
        if (searchValue.trim() === "") {
           xemnhanvien();
            return;
        }

        $.ajax({
            url: './api/apia.php', // API tìm kiếm nhân viên
            type: 'GET', // Sử dụng phương thức GET
            data: { action: 'timma', MANV: searchValue }, // Gửi mã nhân viên tìm kiếm qua GET
            dataType: 'json', // Kết quả trả về là JSON
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    var events = response;
                    var eventHtml = '';
                    events.forEach(function(event) {
                        eventHtml += `
                            <tr>
                                <td>${event.Employee_code}</td>
                                <td>${event.Username}</td>
                                <td>${event.Email}</td>
                                <td>${event.Phone_number}</td>
                                <td>${event.Address}</td>
                                <td>${event.Created_at}</td>`;
                        if (event.Permissions == "QL") {
                            eventHtml += '<td>Nhân viên quản lý dịch vụ</td>';
                        } else if (event.Permissions == "CSKH") {
                            eventHtml += '<td>Nhân viên Chăm sóc khách hàng</td>';
                        } else if (event.Permissions == "HDV") {
                            eventHtml += '<td>Hướng dẫn viên</td>';
                        }
                        eventHtml += `<td>
                     
                            <div class="action-buttons">
                                <button class="btn edit">🖉</button>
                                <button class="btn delete" onclick="xoanhanvien('${event.id}')">🗑</button>
                            </div>
                       
                        </td>
                    </tr>`;
                    });
                    $('#employee-table').html(eventHtml);
                    applyResponsiveTableHeaders();
                } else {
                    $('#employee-table').html('<tr><td colspan="8">Không tìm thấy nhân viên nào.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi lấy thông tin:', error);
                $('#employee-table').html('<tr><td colspan="8">Đã xảy ra lỗi khi tải thông tin.</td></tr>');
            }
        });
    }
};

function xoanhanvien(id) {
       
       fetch('./api/apia.php?action=xoanhanvien&idnv=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qlnhanvien';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
function openRatingModal(Id) {
        // Lấy thông tin tour và hiển thị trong modal
        fetch(`./api/apia.php?action=xemnhanvien1&idsua=${Id}`)
            .then(response => response.json())
            .then(data => {
                if (data && data[0]) {
                    document.getElementById('xemnv1').innerHTML = `
                        
                           <div class="form-container">
        <h2>Sửa TÀI KHOẢN NHÂN VIÊN</h2>
       
         
                <input hidden type="number" id="id" name="id" value="${data[0].id}">
            <div class="form-group">
                <div>
                    <label for="employee-id">Mã Nhân Viên:</label>
                    <input type="text" id="employee-id" name="employee-id" value="${data[0].Employee_code}">
                </div>
                <div>
                    <label for="employee-name">Tên Nhân Viên:</label>
                    <input type="text" id="employee-name" name="employee-name" value="${data[0].Name}">
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" value="">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="${data[0].Email}">
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" value="${data[0].Phone_number}">
                </div>
                <div>
                    <label for="address">Địa chỉ:</label>
                    <input type="text" id="address" name="address" value="${data[0].Address}">
                </div>
            </div>
           
                      `;

                    
            document.getElementById('xemnv1').innerHTML += `</div>
            <center><button type="submit" class="submit-btn">Cập nhật</button></center>
      
    </div>
                    `;
                 
                } else {
                    document.getElementById('xemnv1').innerHTML = 'Không tìm thấy tour';
                }
            })
            .catch(error => console.error('Error:', error));
    }
    function capnhatnv() {
    $('#capnhatnv').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response); // Để kiểm tra chính xác dữ liệu phản hồi
                                if (response === 'update_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function() {
                        window.location.href = 'indexa.php?qlnhanvien';
                    }, 2000);
                } else if (response === 'missing_data') {
                    openPopup('Thông báo', 'Dữ liệu rỗng');
                } else if (response.startsWith('update_error')) {
                    // Nếu response là lỗi, in ra lỗi chi tiết
                    openPopup('Lỗi', response); // Hoặc có thể in chi tiết lỗi bằng cách xử lý dữ liệu phía backend trả về
                } else {
                    // In lỗi chi tiết trong trường hợp không phải lỗi "update_error"
                    var errorMessage = response || 'Có lỗi xảy ra';
                    openPopup('Lỗi', errorMessage);
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

$(document).ready(function() {
       
       xemnhanvien();
       searchEmployee();
       capnhatnv();
   });
</script>
