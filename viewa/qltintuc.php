
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
<h1>Quản lý tin tức</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="capnhattintuc" id="capnhattintuc" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="capnhattintuc">
            <div id="xemtintuc"></div>
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
                        <h2> Thêm tin tức</h2>
                    <form class="themtintuc" id="themtintuc" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="themtintuc">
                        <div class="form-group">
                            <div>
                                <label for="Title">Tiêu đề:</label>
                               
                                <textarea id="dereption" name="Title" rows="5"></textarea>
                            </div>
                            <div>
                                <label for="dereption">Nội dung:</label>
                                <textarea id="dereption" name="dereption" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="anh">Chọn ảnh mới:</label>
                                <input type="file" id="anh" name="anh">
                            </div>
                            <div>
                            <label for="video">Chọn video mới:</label>
                                <!-- Chọn video mới -->
                            <input type="text" id="video" name="video" >
                            </div>
                        </div>
                      
                        <div class="form-group">
                         <div>
                                <label for="Content">Content:</label>
                                <textarea id="Content" name="Content" rows="5"></textarea>
                            </div>
                            <div hidden>
                                <label for="emid">Người tạo:</label>
                                <input type="text"  id="emid" name="emid" value="<?php echo $user_id; ?>">
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
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Ảnh</th>
                    <th>video</th>
                    <th>Content</th>
                    <th>Ngày tạo</th>
                    <th>người tạo</th>
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

 
      function xemtintuc() {
    $.ajax({
        url: './api/apia.php?action=xemtintuc',
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
                    <td class="description">${event.Title}</td>
                    <td class="description">${event.dereption}</td>
                    <td><img style="width:50px;height:50px;" src="./assets/img/gallery/${event.Image}" alt="${event.Title}" class="card-img-top"></td>
                    <td >${event.video}</td>
                    <td class="description">${event.Content}</td>
                    <td>${event.Published_at}</td>
                    <td>${event.Name}</td>`;
                
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.id}')">🖉</button>
                            <button class="btn delete" onclick="xoatintuc('${event.id}')">🗑</button>
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



function xoatintuc(id) {
       
       fetch('./api/apia.php?action=xoatintuc&idtt=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qltintuc';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
function openRatingModal(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    fetch(`./api/apia.php?action=xemtintuc1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                document.getElementById('xemtintuc').innerHTML = `
                    <div class="form-container">
                        <h2>Sửa tin tức</h2>
                        <input hidden type="number" id="id" name="id" value="${data[0].id}">
                        <div class="form-group">
                            <div>
                                <label for="Title">Tiêu đề:</label>
                               
                                <textarea id="dereption" name="Title" rows="5">${data[0].Title}</textarea>
                            </div>
                            <div>
                                <label for="dereption">Nội dung:</label>
                                <textarea id="dereption" name="dereption" rows="5">${data[0].dereption}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="anh">Ảnh hiện tại:</label>
                                <img src="./assets/img/gallery/${data[0].Image}" alt="${data[0].Title}" style="width: 500px; height: 400px; border-radius: 4px; object-fit: cover;">
                            </div>
                            <div>
                                <label for="anh">Chọn ảnh mới:</label>
                                <input type="file" id="anh" name="anh">
                            </div>
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="video">Video hiện tại:</label>
                                <!-- Hiển thị video hiện tại -->
                                 <iframe width="500" height="400" 
                                    src="https://www.youtube.com/embed/${data[0].video}" 
                                    title="YouTube video player" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div>
                                <label for="video">Chọn video mới:</label>
                                <!-- Chọn video mới -->
                                <input type="text" id="video" name="video">
                            </div>
                        </div>

                      
                        <div class="form-group">
                         <div>
                                <label for="Content">Content:</label>
                                <textarea id="Content" name="Content" rows="5">${data[0].Content}</textarea>
                            </div>
                            <div hidden>
                                <label for="emid">Người tạo:</label>
                                <input type="text"  id="emid" name="emid" value="${sessionId}">
                            </div>
                        </div>
                        <center><button type="submit" class="submit-btn">Cập nhật</button></center>
                    </div>`;
            } else {
                document.getElementById('xemtintuc').innerHTML = 'Không tìm thấy tour';
            }
        })
        .catch(error => console.error('Error:', error));
}


function themtintuc() {
    $('#themtintuc').submit(function (e) {
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
                        window.location.href = 'indexa.php?qltintuc';
                    }, 2000);
                } else if (response === 'invalid_image') {
                    openPopup('Thông báo', 'Không đúng loại ảnh (jpg, png, jpeg)');
                } else if (response === 'error_points') {
                    openPopup('Thông báo', 'Thêm không thành công');
                } else if (response === 'upload_error') {
                    openPopup('Thông báo', 'Không upload ảnh được');
                }else if (response === 'invalid_video') {
                    openPopup('Thông báo', 'Không đúng loại video (mp4, avi, mov)');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

function capnhattintuc() {
    $('#capnhattintuc').submit(function (e) {
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
                        window.location.href = 'indexa.php?qltintuc';
                    }, 2000);
                } else if (response === 'invalid_image') {
                    openPopup('Thông báo', 'Không đúng loại ảnh (jpg, png, jpeg)');
                } else if (response === 'error_points') {
                    openPopup('Thông báo', 'Cập nhật không thành công');
                } else if (response === 'upload_error') {
                    openPopup('Thông báo', 'Không upload ảnh được');
                }else if (response === 'invalid_video') {
                    openPopup('Thông báo', 'Không đúng loại video (mp4, avi, mov)');
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
       themtintuc();
       xemtintuc();
       capnhattintuc();
    
   });
</script>
