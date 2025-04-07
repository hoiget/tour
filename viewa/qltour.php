
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
<h1>Quản lý tour</h1>
<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="capnhatour" id="capnhatour" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
            <input type="hidden" name="action" value="capnhatour">
            <div id="xemtour"></div>
            </form>
            </div>
        </div>
    </div>
</div> 
    <div class="container">
    <div class="search-bar">
    
    <input type="text" id="search" name="MAT" placeholder="Tìm kiếm mã tour" onkeydown="searchtour(event)">
   

    <button class="btn edit1" data-bs-toggle="modal" data-bs-target="#ratingModalthem">+</button>
<div class="modal fade" id="ratingModalthem" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="form-container">
                        <h2> Thêm tour</h2>
                    <form class="themtour" id="themtour" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="themtour">
                        <div class="form-group">
                            <div>
                                <label for="Title">Tên tour:</label>
                               
                                <input type="text" id="ten" name="ten" value="">
                            </div>
                            <div>
                                <label for="Title">Chọn khách sạn:</label>
                               
                                <div id="ks"></div>
                            </div>
                             <div>
                                <label for="Title">Phong cách:</label>
                               
                                <input type="text" id="pc" name="pc" value="">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="Title">Gía tour:</label>
                               
                                <input type="number" id="price" name="price" value="">
                            </div>
                             <div>
                                <label for="Title">Phần trăm trẻ em:</label>
                               
                                <input type="number" id="te" name="te" value="">
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
                                <label for="Title">Số lương tối đa:</label>
                               
                                <input type="number" id="td" name="td" value="">
                            </div>
                             <div>
                                <label for="Title">Số lương tối thiểu:</label>
                               
                                <input type="number" id="tt" name="tt" value="">
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                          
                            <div>
                                <label for="dereption">Nội dung:</label>
                                <textarea id="dereption" name="dereption" rows="5"></textarea>
                            </div>
                            <div>
                                <label for="Title">Status:</label>
                               
                                <input type="text" id="status" name="status" value="">
                            </div>
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Ngày khởi hành:</label>
                               
                                <input type="date" id="nkh" name="nkh" value="">
                                <input type="date" id="departure_date">
                                <button type="button" onclick="addDate()">Thêm ngày</button>
                                <ul id="dateList"></ul>
                                <input type="hidden" name="departure_dates" id="departure_dates">
                            </div>
                             <div>
                                <label for="Title">Địa điểm khởi hành:</label>
                               
                                <input type="text" id="ddkh" name="ddkh" value="">
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Lịch trình:</label>
                                <textarea id="itinerary" id="cd" name="cd"></textarea>
                               
                            </div>
                             <div hidden>
                                <label for="Title">Người tạo:</label>
                               
                                <input type="text"  id="emid" name="emid" value="<?php echo $user_id; ?>">
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Kiểu tour:</label>
                               <select name="kt">
                             
                               <option value="Gia đình">Gia đình</option>
                               <option value="Theo đoàn" >Theo đoàn</option>
                               <option value="Theo nhóm nhỏ" >Theo nhóm nhỏ</option>
                               </select>
                               
                            </div>
                             <div>
                                <label for="Title">Ngày ở:</label>
                               
                                <input type="text" id="no" name="no" value="">
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Giảm giá:</label>
                               
                                <input type="number" id="gg" name="gg" value="">
                            </div>
                             <div>
                                <label for="Title">Phương tiện:</label>
                                <select name="PT">
                             
                             <option value="Xe khách">Xe khách</option>
                             <option value="Máy bay" >Máy bay</option>
                             <option value="Du thuyền" >Du thuyền</option>
                             </select>
                              
                            </div>
                            
                        </div>
                        <div class="form-group">
                           
                             <div>
                                <label for="Title">Vùng:</label>
                                <select name="vung">
                             
                             <option value="Nam">Miền Nam</option>
                             <option value="Bắc" >Miền Bắc</option>
                             <option value="Tây" >Miền Tây</option>
                             <option value="Trung" >Miền Trung</option>
                             <option value="Ngoài nước" >Nước ngoài</option>
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
                <th>Tên tour</th>
                <th>Tên khách sạn</th>
                <th>Phong cách</th>
                <th>Gía</th>
                <th>Ảnh</th>
                <th>Phần trăm trẻ em</th>
                <th>Số lượng tối đa</th>
                <th>Số lượng tối thiểu</th>
                <th>Nội dung</th>
                <th>Status</th>
                <th>Ngày khởi hành</th>
                <th>Địa điểm khởi hành</th>
                <th>Chuyến đi</th>
                <th>Người tạo</th>
                <th>Kiểu tour</th>
                <th>Ngày ở</th>
                <th>Giảm giá</th>
                <th>Phương tiện</th>
                <th>Vùng</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="employee-table"></tbody>
    </table>
</div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    let departureDates = [];

    function addDate() {
        let dateInput = document.getElementById("departure_date");
        let dateList = document.getElementById("dateList");

        if (dateInput.value && !departureDates.includes(dateInput.value)) {
            departureDates.push(dateInput.value);
            let listItem = document.createElement("li");
            listItem.textContent = dateInput.value;
            dateList.appendChild(listItem);
        }

        document.getElementById("departure_dates").value = JSON.stringify(departureDates);
        dateInput.value = ""; // Xóa input sau khi thêm
    }

    document.getElementById("departureForm").addEventListener("submit", function (event) {
        if (departureDates.length === 0) {
            alert("Vui lòng chọn ít nhất một ngày khởi hành!");
            event.preventDefault();
        }
    });
</script>
<script>
      function xemtour() {
    $.ajax({
        url: './api/apia.php?action=xemtour',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            console.log(response)
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    let departureList = event.departure_dates.map(date => `<li>${date}</li>`).join("");
                    eventHtml += `
                     
                      <tr>
                    <td>${event.idtour}</td>
                   
                    <td>${event.tourname}</td>
                    <td>${event.roomname}</td>
                    <td>${event.Style}</td>
                    <td>${event.tourprice}</td>
                    <td><img style="width:50px;height:50px;" src="./assets/img/tour/${event.Image}" alt="${event.Thumb}" class="card-img-top"></td>
                    <td>${event.Child_price_percen}</td>
                    <td>${event.Max_participant}</td>
                    <td>${event.Min_participant}</td>
                    <td class="description">${event.Description}</td>
                    <td>${event.Status}</td>
                    <td>${event.Depart}
                    <ul>${departureList}</ul>
                    </td>
                    
                    <td>${event.DepartureLocation}</td>
                    <td class="description">${event.Itinerary}</td>
                    <td>${event.tennhanvien}</td>
                    <td>${event.type}</td>
                    <td>${event.timetour}</td>
                    <td>${event.discount}</td>
                    <td>${event.vehicle}</td>
                    <td>${event.vung}</td>`;
                
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.idtour}')">🖉</button>
                            <button class="btn delete" onclick="xoatour('${event.idtour}')">🗑</button>
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



function xoatour(id) {
       
       fetch('./api/apia.php?action=xoatour&id=' + id)
           .then(response => response.text())
           
           .then(data => {
            console.log(data)
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qltour';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}

function openRatingModal(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    fetch(`./api/apia.php?action=xemtour1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                let departureList = data[0].departure_dates.map(date => `<li>${date}</li>`).join("");
                document.getElementById('xemtour').innerHTML = `
                    <div class="form-container">
                        <h2>Sửa tour</h2>
                        <input hidden type="number" id="id" name="id" value="${data[0].idtour}">
                        <div class="form-group">
                            <div>
                                <label for="Title">Tên tour:</label>
                               
                                <input type="text" id="ten" name="ten" value="${data[0].tourname}">
                            </div>
                             <div>
                                <label for="Title">Chọn khách sạn:</label>
                               
                                <input type="text" id="khachsan" name="khachsan" value="${data[0].roomname}" readonly>
                            </div>
                             <div>
                                <label for="Title">Phong cách:</label>
                               
                                <input type="text" id="pc" name="pc" value="${data[0].Style}">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="Title">Gía tour:</label>
                               
                                <input type="number" id="price" name="price" value="${data[0].tourprice}">
                            </div>
                             <div>
                                <label for="Title">Phần trăm trẻ em:</label>
                               
                                <input type="number" id="te" name="te" value="${data[0].Child_price_percen}">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="anh">Ảnh hiện tại:</label>
                                <img src="./assets/img/tour/${data[0].Image}" alt="${data[0].Thumb}" style="width: 500px; height: 400px; border-radius: 4px; object-fit: cover;">
                            </div>
                            <div>
                                <label for="anh">Chọn ảnh mới:</label>
                                <input type="file" id="anh" name="anh">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="Title">Số lương tối đa:</label>
                               
                                <input type="number" id="td" name="td" value="${data[0].Max_participant}">
                            </div>
                             <div>
                                <label for="Title">Số lương tối thiểu:</label>
                               
                                <input type="number" id="tt" name="tt" value="${data[0].Min_participant}">
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                          
                            <div>
                                <label for="dereption">Nội dung:</label>
                                <textarea id="dereption" name="dereption" rows="5">${data[0].Description}</textarea>
                            </div>
                            <div>
                                <label for="Title">Status:</label>
                               
                                <input type="text" id="status" name="status" value="${data[0].Status}">
                            </div>
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Ngày khởi hành:</label>
                               
                                <input type="date" id="nkh" name="nkh" value="${data[0].Depart}">
                                <input type="date" id="departure_date">
                                <button type="button" onclick="addDate()">Thêm ngày</button>
                                <ul id="dateList">
                                ${departureList}</ul>
                                <input type="hidden" name="departure_dates" id="departure_dates" >

                               
                               
                               
                            </div>
                             <div>
                                <label for="Title">Địa điểm khởi hành:</label>
                               
                                <input type="text" id="ddkh" name="ddkh" value="${data[0].DepartureLocation}">
                               
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Lịch trình:</label>
                                <textarea id="itinerary" id="cd" name="cd">${data[0].Itinerary}</textarea>
                               
                              
                            </div>
                             <div hidden>
                                <label for="Title">Người tạo:</label>
                               
                                <input type="text"  id="emid" name="emid" value="${sessionId}">
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Kiểu tour:</label>
                               <select name="kt">
                               <option value="${data[0].type}" selected>${data[0].type}</option>
                               <option value="Gia đình">Gia đình</option>
                               <option value="Theo đoàn" >Theo đoàn</option>
                               <option value="Theo nhóm nhỏ" >Theo nhóm nhỏ</option>
                               </select>
                               
                            </div>
                             <div>
                                <label for="Title">Ngày ở:</label>
                               
                                <input type="text" id="no" name="no" value="${data[0].timetour}">
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <div>
                                <label for="Title">Giảm giá:</label>
                               
                                <input type="number" id="gg" name="gg" value="${data[0].discount}">
                            </div>
                             <div>
                                <label for="Title">Phương tiện:</label>
                                 <select name="PT">
                                <option value="${data[0].vehicle}" selected>${data[0].vehicle}</option>
                             <option value="Xe khách">Xe khách</option>
                             <option value="Máy bay" >Máy bay</option>
                             <option value="Du thuyền" >Du thuyền</option>
                             </select>
                              
                           
                            </div>
                            
                        </div>
                           <div class="form-group">
                            <div>
                                <label for="Title">Vùng:</label>
                                <select name="vung">
                                <option value="${data[0].vung}" selected>${data[0].vung}</option>
                               <option value="Nam">Miền Nam</option>
                                <option value="Bắc" >Miền Bắc</option>
                                <option value="Tây" >Miền Tây</option>
                                <option value="Trung" >Miền Trung</option>
                                <option value="Ngoài nước" >Nước ngoài</option>
                                </select>
                            </div>
                           
                            
                        </div>
                        <center><button type="submit" class="submit-btn">Cập nhật</button></center>
                    </div>`;
            } else {
                document.getElementById('xemtour').innerHTML = 'Không tìm thấy tour';
            }
        })
        .catch(error => console.error('Error:', error));
}



function capnhatour() {
    $('#capnhatour').submit(function (e) {
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
                        window.location.href = 'indexa.php?qltour';
                    }, 2000);
                } else if (response === 'invalid_image') {
                    openPopup('Thông báo', 'Không đúng loại ảnh (jpg, png, jpeg)');
                } else if (response === 'error_points') {
                    openPopup('Thông báo', 'Cập nhật không thành công');
                } else if (response === 'upload_error') {
                    openPopup('Thông báo', 'Không upload ảnh được');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

function themtour() {
    $('#themtour').submit(function (e) {
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
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?qltour';
                    }, 2000);
                } else if (response === 'invalid_image') {
                    openPopup('Thông báo', 'Không đúng loại ảnh (jpg, png, jpeg)');
                } else if (response === 'error_points') {
                    openPopup('Thông báo', 'Cập nhật không thành công');
                } else if (response === 'upload_error') {
                    openPopup('Thông báo', 'Không upload ảnh được');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

function searchtour(event) {
    if (event && event.key === "Enter") {  // Kiểm tra nếu event và phím bấm là Enter
        var searchValue = $('#search').val(); // Lấy giá trị từ ô input với id "search"

        // Nếu không có gì để tìm kiếm, không làm gì
        if (searchValue.trim() === "") {
            xemtour();   
            return;
        }

        $.ajax({
            url: './api/apia.php', // API tìm kiếm nhân viên
            type: 'GET', // Sử dụng phương thức GET
            data: { action: 'timmatour', MAT: searchValue }, // Gửi mã nhân viên tìm kiếm qua GET
            dataType: 'json', // Kết quả trả về là JSON
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    var events = response;
                    var eventHtml = '';
                    events.forEach(function(event) {
                        eventHtml += `
                     
                     <tr>
                   <td>${event.idtour}</td>
                    <td>${event.tourname}</td>
                    <td>${event.roomname}</td>
                   <td>${event.Style}</td>
                   <td>${event.tourprice}</td>
                   <td><img style="width:50px;height:50px;" src="./assets/img/tour/${event.Image}" alt="${event.Thumb}" class="card-img-top"></td>
                   <td>${event.Child_price_percen}</td>
                   <td>${event.Max_participant}</td>
                   <td>${event.Min_participant}</td>
                   <td class="description">${event.Description}</td>
                   <td>${event.Status}</td>
                   <td>${event.Depart}</td>
                   <td>${event.DepartureLocation}</td>
                   <td class="description">${event.Itinerary}</td>
                   <td>${event.tennhanvien}</td>
                   <td>${event.type}</td>
                   <td>${event.timetour}</td>
                   <td>${event.discount}</td>
                   <td>${event.vehicle}</td>
                     <td>${event.vung}</td>`;
               
                   
                    eventHtml +=`<td>
                       <div class="action-buttons">
                           <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.idtour}')">🖉</button>
                           <button class="btn delete" onclick="xoatour('${event.idtour}')">🗑</button>
                       </div>
                   </td>
               </tr> 
`;
                    });
                    $('#employee-table').html(eventHtml);
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
       themtour();
  xemtour();
      capnhatour();
      xemks();
    
   });
</script>
<script>
    $(document).ready(function () {
    // Lắng nghe khi nhập tên tour
    $('#ten').on('input', function () {
        let tourName = $(this).val().trim(); // Lấy giá trị nhập vào
        if (tourName.length > 2) { // Chỉ tìm kiếm nếu nhập ít nhất 3 ký tự
            let diaDiem = layDiaDiem(tourName); // Hàm trích xuất địa điểm từ tên tour
            if (diaDiem) {
                xemks(diaDiem); // Gọi API tìm khách sạn theo địa điểm
            }
        }
    });
});

// Hàm trích xuất địa điểm từ tên tour (ví dụ: "Tour Đà Nẵng 3N2Đ" -> "Đà Nẵng")
function layDiaDiem(tourName) {
    let regex = /\b([\p{L}]+(?:\s[\p{L}]+)?)\b/ui; // Lấy đúng 2 từ đầu tiên
    let match = tourName.match(regex);
    return match ? match[1].trim() : null;
}

// Hàm lấy danh sách khách sạn theo địa điểm
function xemks(diaDiem = '') {
    $.ajax({
    url: `./api/api.php?action=xemkss&diadiem=${encodeURIComponent(diaDiem)}`,
    type: 'GET',
    dataType: 'json',
    success: function (response) {
        if (Array.isArray(response) && response.length > 0) {
            let eventHtml = '<select class="form-control" id="khachsan" name="khachsan" required>';
            eventHtml += '<option value="">Chọn khách sạn</option>'; // Tuỳ chọn mặc định

            response.forEach(function (event) {
                eventHtml += `<option value="${event.id}">${event.Name} - ${event.Diadiem}</option>`;
            });

            eventHtml += '</select>';
            $('#ks').html(eventHtml);
        } else {
            $('#ks').html('<div class="col">Không tìm thấy khách sạn phù hợp.</div>');
        }
    },
    error: function (xhr, status, error) {
        console.error('Lỗi khi tải thông tin khách sạn:', xhr.responseText);
        $('#ks').html(`<div class="col text-danger">Lỗi: ${xhr.status} - ${xhr.statusText}<br>${xhr.responseText}</div>`);
    }
});

}
</script>
