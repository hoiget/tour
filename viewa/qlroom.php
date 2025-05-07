
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
<h1>Quản lý phòng</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="capnhatroom" id="capnhatroom" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="capnhatroom">
            <div id="xemks"></div>
           
            
            <center><button type="submit" class="submit-btn">Cập nhật</button></center>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div> 
    <div class="container">
    <div class="search-bar">
    
    <input type="text" id="search" name="MAR" placeholder="Tìm kiếm mã room" onkeydown="searchroom(event)">
   

    <button style="margin-left: 10px;" class="btn edit1" data-bs-toggle="modal" data-bs-target="#ratingModalthem">+</button>
<div class="modal fade" id="ratingModalthem" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                    <form class="themroom" id="themroom" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="themroom">
                        <div class="form-container">
                        <h2>Thêm room</h2>
                        <input hidden type="number" id="id" name="id" >
                        <div class="form-group">
                            <div>
                                <label for="ten">Tên phòng:</label>
                                <input type="text" id="ten" name="ten" >
                            </div>
                            <div>
                                <label for="dt">Diện tích:</label>
                                <input type="text" id="dt" name="dt" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="ten">Địa điểm:</label>
                                <input type="text" id="ddd" name="ddd">
                            </div>
                    
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="price">Giá phòng:</label>
                                <input type="number" id="price" name="price" >
                            </div>
                            <div>
                                <label for="status">Status:</label>
                                <select id="status" name="status">
                                    <option value="Hoạt động" selected>Hoạt động</option>
                                    <option value="ko Hoạt động">Không Hoạt động</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="anh">Chọn ảnh mới:</label>
                                <input type="file" id="anh" name="anh">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="td">Người lớn:</label>
                                <input type="number" id="td" name="td" >
                            </div>
                            <div>
                                <label for="tt">Trẻ em:</label>
                                <input type="number" id="tt" name="tt" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="dereption">Ngày nhận:</label>
                               <input type="date" id="ngaynhan" name="ngaynhan" >
                            </div>
                            <div>
                                <label for="emid">Ngày trả:</label>
                                <input type="date" id="ngaytra" name="ngaytra">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="dereption">Nội dung:</label>
                                <textarea id="dereption" name="dereption" rows="5"></textarea>
                            </div>
                            <div hidden>
                                <label for="emid">Người tạo:</label>
                                <input type="text" id="emid" name="emid" value="<?php echo $user_id ?>">
                            </div>
                        </div>
                        <div class="form-group">
                        <div>
                                <label for="dd">Đặc điểm phòng:</label>
                                <select id="dd" name="dd">
                                
                                </select>
                        </div>
                            <div>
                                <label for="ti">Tiện ích phòng:</label>
                                <select id="ti" name="ti">
                                 
                                </select>
                            </div>
                        </div>
                    </div>
                        <center><button type="submit" class="submit-btn">Thêm</button></center>
                    </form>
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
                <th>Tên phòng</th>
                <th>Địa điểm</th>
                <th>Diện tích</th>
                <th>Gía</th>
                <th>Ảnh</th>
                <th>Người lớn</th>
                <th>Trẻ em</th>
                <th>Status</th>
                <th>Đặc điểm phòng</th>
                <th>Tiện nghi phòng</th>
                <th>Ngày nhận</th>
                <th>Ngày trả</th>   
                <th>Nội dung</th>
                <th>Người tạo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="employee-table"></tbody>
    </table>
</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('ngaynhan').setAttribute('min', today);
    document.getElementById('ngaytra').setAttribute('min', today);

     
 $("input[name='ngaynhan']").on("change", function () {
    let pickupTime = new Date($(this).val());
    let currentTime = new Date();
    currentTime.setDate(currentTime.getDate() + 3); // Cộng thêm 1 ngày

    if (pickupTime <= currentTime) {
        showError($(this), "Ngày phải sau ít nhất 3 ngày so với hiện tại.");
    } else {
        hideError($(this));
    }
});
$("input[name='ngaytra']").on("change", function () {
    let pickupTime = new Date($(this).val());
    let currentTime = new Date();
    currentTime.setDate(currentTime.getDate() + 3); // Cộng thêm 1 ngày

    if (pickupTime <= currentTime) {
        showError($(this), "Ngày phải sau ít nhất 3 ngày so với hiện tại.");
    } else {
        hideError($(this));
    }
});
function showError(element, message) {
        let errorLabel = element.next(".error-msg");
        if (errorLabel.length === 0) {
            element.after(`<span class="error-msg" style="color:red; font-size:12px;">${message}</span>`);
        } else {
            errorLabel.text(message);
        }
    }

    // Hàm ẩn lỗi
    function hideError(element) {
        element.next(".error-msg").remove();
    }
</script>
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

 
      function xemks() {
    $.ajax({
        url: './api/apia.php?action=xemks',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.idroom}</td>
                    <td>${event.room_name}</td>
                    <td>${event.Diadiem}</td>
                    <td>${event.Area}</td>
                    <td>${event.Price}</td>
                    <td><img style="width:50px;height:50px;" src="./assets/img/KS/${event.Image}" alt="${event.Thumb}" class="card-img-top"></td>
                    <td>${event.Adult}</td>
                    <td>${event.Children}</td>
                    <td>${event.Status}</td>
                    <td>${event.feature_name}</td>
                    <td>${event.facility_name}</td>
                    <td>${event.Ngaynhan}</td>
                   <td>${event.Ngaytra}</td>
                    <td class="description">${event.noidung}</td>
                    <td>${event.tennhanvien}</td>
                   `;
                
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.idroom}')">🖉</button>
                            <button class="btn delete" onclick="xoaphong('${event.idroom}')">🗑</button>
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



function xoaphong(id) {
       
       fetch('./api/apia.php?action=xoaphong&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qlroom';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}

function openRatingModal(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    fetch(`./api/apia.php?action=xemks1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                const room = data[0]; // Lưu thông tin phòng từ API
                document.getElementById('xemks').innerHTML = `
                    <div class="form-container">
                        <h2>Sửa tour</h2>
                        <input hidden type="number" id="id" name="id" value="${room.idroom}">
                        <div class="form-group">
                            <div>
                                <label for="ten">Tên phòng:</label>
                                <input type="text" id="ten" name="ten" value="${room.room_name}">
                            </div>
                            <div>
                                <label for="dt">Diện tích:</label>
                                <input type="text" id="dt" name="dt" value="${room.Area}">
                            </div>
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="ten">Địa điểm:</label>
                                <input type="text" id="ddd" name="ddd" value="${room.Diadiem}">
                            </div>
                    
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="price">Gía phòng:</label>
                                <input type="number" id="price" name="price" value="${room.Price}">
                            </div>
                            <div>
                                <label for="status">Status:</label>
                                <select id="status" name="status">
                                  <option value="${room.Status}" selected>${room.Status}</option>
                                    <option value="Hoạt động">Hoạt động</option>
                                    <option value="ko Hoạt động">ko Hoạt động</option>
                                </select>
                               
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="anh">Ảnh hiện tại:</label>
                                <img src="./assets/img/KS/${room.Image}" alt="${room.Thumb}" 
                                    style="width: 500px; height: 400px; border-radius: 4px; object-fit: cover;">
                            </div>
                            <div>
                                <label for="anh">Chọn ảnh mới:</label>
                                <input type="file" id="anh" name="anh">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="td">Người lớn:</label>
                                <input type="number" id="td" name="td" value="${room.Adult}">
                            </div>
                            <div>
                                <label for="tt">Trẻ em:</label>
                                <input type="number" id="tt" name="tt" value="${room.Children}">
                            </div>
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="dereption">Ngày nhận:</label>
                               <input type="date" id="ngaynhan" name="ngaynhan" value="${room.Ngaynhan}">
                            </div>
                            <div>
                                <label for="emid">Ngày trả:</label>
                                <input type="date" id="ngaytra" name="ngaytra" value="${room.Ngaytra}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="dereption">Nội dung:</label>
                                <textarea id="dereption" name="dereption" rows="5">${room.noidung}</textarea>
                            </div>
                            <div hidden>
                                <label for="emid">Người tạo:</label>
                                <input type="text" id="emid" name="emid" value="${sessionId || ''}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="dd">Đặc điểm phòng:</label>
                                <select id="dd" name="dd">
                                    <option value="${room.idfeature}" selected>${room.feature_name}</option>
                                </select>
                            </div>
                            <div>
                                <label for="ti">Tiện ích phòng:</label>
                                <select id="ti" name="ti">
                                    <option value="${room.idfacility}" selected>${room.facility_name}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;

                // Hàm dùng chung để fetch và thêm các option vào select
                const populateSelect = (url, selectId, selectedId, selectedName) => {
                    fetch(url)
                        .then(response => response.json())
                        .then(items => {
                            if (Array.isArray(items) && items.length > 0) {
                                const options = items.map(item => `
                                    <option value="${item.id}" ${item.id == selectedId ? 'selected' : ''}>${item.Name}</option>
                                `).join('');
                                document.getElementById(selectId).innerHTML += options;
                            } else {
                                document.getElementById(selectId).innerHTML += '<option disabled>Không có dữ liệu</option>';
                            }
                        })
                        .catch(error => console.error(`Lỗi khi lấy dữ liệu từ ${url}:`, error));
                };

                // Lấy danh sách đặc điểm phòng
                populateSelect('./api/apia.php?action=xemdacdiem', 'dd', room.idfeature, room.feature_name);

                // Lấy danh sách tiện ích phòng
                populateSelect('./api/apia.php?action=xemtienich', 'ti', room.idfacility, room.facility_name);
            } else {
                document.getElementById('xemks').innerHTML = 'Không tìm thấy thông tin tour';
            }
        })
        .catch(error => console.error('Lỗi khi lấy dữ liệu tour:', error));
}


function dacdiem() {
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
                     
                            
                                    <option value="${event.id}" selected>${event.Name}</option>
                                
`;
                });
                $('#dd').html(eventHtml);
            } else {
                $('#dd').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#dd').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}

function tienich() {
    $.ajax({
        url: './api/apia.php?action=xemtienich',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                            
                        <option value="${event.id}" selected>${event.Name}</option>
                                
`;
                });
                $('#ti').html(eventHtml);
            } else {
                $('#ti').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#ti').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function capnhatroom() {
    $('#capnhatroom').submit(function (e) {
        e.preventDefault();

        // Thu thập dữ liệu form
        var formData = new FormData(this);
        let departureDate = new Date($('#ngaynhan').val());
        let departureDate1 = new Date($('#ngaytra').val());
    let today = new Date();
    today.setDate(today.getDate() + 3); // Cộng thêm 6 ngày để đủ 1 tuần

    if (departureDate <= today) {
        openPopup('Thông báo', 'Ngày phải sau ít nhất 3 ngày so với hiện tại.');
        return; // Không gửi form nếu sai
    }
    if (departureDate1 <= today) {
        openPopup('Thông báo', 'Ngày phải sau ít nhất 3 ngày so với hiện tại.');
        return; // Không gửi form nếu sai
    }
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
                        window.location.href = 'indexa.php?qlroom';
                    }, 2000);
                } else if (response === 'invalid_image') {
                    openPopup('Thông báo', 'Không đúng loại ảnh (jpg, png, jpeg)');
                } else if (response === 'error_points') {
                    openPopup('Thông báo', 'Cập nhật không thành công');
                } else if (response === 'upload_error') {
                    openPopup('Thông báo', 'Không upload ảnh được');
                }else if (response === 'upload_error') {
                    openPopup('Thông báo', 'Không upload ảnh được');
                }else if (response === 'error day') {
                    openPopup('Thông báo', 'Ngày nhận phải trước ngày trả');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

function themroom() {
    $('#themroom').submit(function (e) {
        e.preventDefault();

        // Thu thập dữ liệu form
        var formData = new FormData(this);
        let departureDate = new Date($('#ngaynhan').val());
        let departureDate1 = new Date($('#ngaytra').val());
    let today = new Date();
    today.setDate(today.getDate() + 3); // Cộng thêm 6 ngày để đủ 1 tuần

    if (departureDate <= today) {
        openPopup('Thông báo', 'Ngày phải sau ít nhất 3 ngày so với hiện tại.');
        return; // Không gửi form nếu sai
    }
    if (departureDate1 <= today) {
        openPopup('Thông báo', 'Ngày phải sau ít nhất 3 ngày so với hiện tại.');
        return; // Không gửi form nếu sai
    }
        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: formData,
            contentType: false, // Bắt buộc khi sử dụng FormData
            processData: false, // Ngăn jQuery xử lý dữ liệu
            success: function (response) {
                console.log(response); // Để kiểm tra chính xác dữ liệu phản hồi
                if (response === 'insert_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?qlroom';
                    }, 2000);
                } else if (response === 'invalid_image') {
                    openPopup('Thông báo', 'Không đúng loại ảnh (jpg, png, jpeg)');
                } else if (response === 'error_points') {
                    openPopup('Thông báo', 'Cập nhật không thành công');
                } else if (response === 'upload_error') {
                    openPopup('Thông báo', 'Không upload ảnh được');
                }else if (response === 'error day') {
                    openPopup('Thông báo', 'Ngày nhận phải trước ngày trả');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

function searchroom(event) {
    if (event && event.key === "Enter") {  // Kiểm tra nếu event và phím bấm là Enter
        var searchValue = $('#search').val(); // Lấy giá trị từ ô input với id "search"

        // Nếu không có gì để tìm kiếm, không làm gì
        if (searchValue.trim() === "") {
           xemks();
            return;
        }

        $.ajax({
            url: './api/apia.php', // API tìm kiếm nhân viên
            type: 'GET', // Sử dụng phương thức GET
            data: { action: 'timmaroom', MAR: searchValue }, // Gửi mã nhân viên tìm kiếm qua GET
            dataType: 'json', // Kết quả trả về là JSON
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    var events = response;
                    var eventHtml = '';
                    events.forEach(function(event) {
                        eventHtml += `
                     
                     <tr>
                   <td>${event.idroom}</td>
                   <td>${event.room_name}</td>
                     <td>${event.Diadiem}</td>
                   <td>${event.Area}</td>
                   <td>${event.Price}</td>
                   <td><img style="width:50px;height:50px;" src="./assets/img/KS/${event.Image}" alt="${event.Thumb}" class="card-img-top"></td>
                   <td>${event.Adult}</td>
                   <td>${event.Children}</td>
                   <td>${event.Status}</td>
                   <td>${event.feature_name}</td>
                   <td>${event.facility_name}</td>
                   <td>${event.Ngaynhan}</td>
                   <td>${event.Ngaytra}</td>
                   <td class="description">${event.noidung}</td>
                   <td>${event.tennhanvien}</td>
                  `;
               
                   
                    eventHtml +=`<td>
                       <div class="action-buttons">
                           <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.idroom}')">🖉</button>
                           <button class="btn delete" onclick="xoaphong('${event.idroom}')">🗑</button>
                       </div>
                   </td>
               </tr> 
`;
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
}

$(document).ready(function() {
      themroom();
       dacdiem();
  xemks();
 tienich();
     capnhatroom();
    
   });
</script>
