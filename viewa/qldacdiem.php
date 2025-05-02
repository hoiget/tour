
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
<h1>Quản lý đặc điểm</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="suadacdiem" id="suadacdiem" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="suadacdiem">
            <div id="xemdacdiem"></div>
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
                        <h2> Thêm đạc điểm</h2>
                    <form class="themdacdiem" id="themdacdiem" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="themdacdiem">
                        <div class="form-group">
                            <div>
                                <label for="Title">Tên đặc điểm:</label>
                               
                                <input type="text" name="ten" id="ten">
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


        <table>
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th>Tên đặc điểm</th>
                    <th style="width: 100px">Action</th>
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

      function xemdacdiem() {
    $.ajax({
        url: './api/apia.php?action=xemdacdiem',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.id}</td>
                    <td>${event.Name}</td>
                  
                    `;
                
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.id}')">🖉</button>
                            <button class="btn delete" onclick="xoadacdiem('${event.id}')">🗑</button>
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



function xoadacdiem(id) {
       
       fetch('./api/apia.php?action=xoadacdiem&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qldacdiem';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
function openRatingModal(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    fetch(`./api/apia.php?action=xemdacdiem1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                document.getElementById('xemdacdiem').innerHTML = `
                    <div class="form-container">
                        <h2>Sửa tiện ích</h2>
                        <input hidden type="number" id="id" name="id" value="${data[0].id}">
                        <div class="form-group">
                            <div>
                                <label for="Title">Tên:</label>
                                <input type="text" name="ten" id="ten" value="${data[0].Name}">
                               
                            </div>
                            
                        </div>
                        
                        <center><button type="submit" class="submit-btn">Cập nhật</button></center>
                    </div>`;
            } else {
                document.getElementById('xemdacdiem').innerHTML = 'Không tìm thấy tour';
            }
        })
        .catch(error => console.error('Error:', error));
}


function themdacdiem() {
    $('#themdacdiem').submit(function (e) {
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
                if (response === 'insert_success') {
                    openPopup('Thông báo', 'Thêm thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?qldacdiem';
                    }, 2000);
                }else  {
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

function suadacdiem() {
    $('#suadacdiem').submit(function (e) {
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
                        window.location.href = 'indexa.php?qldacdiem';
                    }, 2000);
                } else{
                    openPopup('Thông báo', 'Không cập nhật thành công');
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
       xemdacdiem();
       themdacdiem();
       suadacdiem();
   });
</script>
