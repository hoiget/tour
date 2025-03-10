
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
                    <th>Trạng thái</th>
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
    function xemtouryeucau() {
    $.ajax({
        url: './api/apia.php?action=xemtouryeucau',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var eventHtml = '';
                response.forEach(function(event) {
                    let itineraryData = JSON.parse(event.itinerary); // Chuyển JSON thành Object
                    let itineraryPreview = '';

                    let count = 0;
                    for (const day in itineraryData) {
                        itineraryPreview += `${day}: ${itineraryData[day]}<br>`;
                        count++;
                        if (count >= 2) break; // Chỉ hiển thị 2 ngày đầu tiên
                    }

                    eventHtml += `
                        <tr>
                            <td>${event.id_request}</td>
                            <td>${event.customer_name}</td>
                            <td>${event.tour_name}</td>
                            <td>${event.departure_date}</td>
                            <td>${event.tour_price}</td>
                            <td class="description">${itineraryPreview}...</td>
                            <td>${event.tour_duration}</td>
                            <td>${event.phuongtien}</td> `
                            if(event.Trangthai == 1){
                                  eventHtml += `<td><span style="color:green">Đã duyệt</span></td>`
                            }else{
                                eventHtml += `<td><span style="color:green">Chưa duyệt</span></td>`

                            }
                              eventHtml += `<td>
                                <div class="action-buttons">
                                    <button class="btn edit" data-bs-toggle="modal" data-bs-target="#ratingModal" onclick="openRatingModal('${event.id_request}')">Xem chi tiết</button>
                                    <button class="btn delete" onclick="xoatu('${event.id_request}')">🗑</button>
                                </div>
                            </td>
                        </tr>`;
                });
                $('#employee-table').html(eventHtml);
            } else {
                $('#employee-table').html('<div class="col">Không tìm thấy thông tin tour.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#employee-table').html('<div class="col">Đã xảy ra lỗi khi tải thông tin.</div>');
        }
    });
}

function openRatingModal(Id) {
    fetch(`./api/apia.php?action=xemtouryeucau1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                let itineraryData = JSON.parse(data[0].itinerary); // Chuyển chuỗi JSON thành object
                let itineraryHtml = '';

                for (const day in itineraryData) {
                    itineraryHtml += `<p><b>${day}:</b> ${itineraryData[day]}</p>`;
                }

                let detailHtml = `
                    <div class="form-container">
                        <h2>Xem Chi Tiết</h2>
                        <span><b>Tên khách hàng:</b> ${data[0].customer_name}</span><br>
                        <span><b>Tên tour:</b> ${data[0].tour_name}</span><br>
                        <span><b>Ngày khởi hành:</b> ${data[0].departure_date}</span><br>
                        <span><b>Gía tour:</b> ${data[0].tour_price}</span><br>
                        <span><b>Ngày ở:</b> ${data[0].tour_duration}</span><br>
                        <span><b>Phương tiện:</b> ${data[0].phuongtien}</span><br>
                        <span><b>Lịch trình:</b></span> ${itineraryHtml}
                `;

                // Nếu tour chưa được duyệt (Trangthai == 0), thêm nút duyệt
                if (data[0].Trangthai == 0) {
                    detailHtml += `
                        <center>
                            <button class="btn edit1" style="width:200px" 
                                data-bs-toggle="modal" data-bs-target="#ratingModalthem" 
                                onclick="loadTourData('${data[0].id_request}'); duyet('${data[0].id_request}')">
                                Duyệt
                            </button>
                        </center>
                    `;
                }else{
                    detailHtml += `<center>
                            <button class="btn edit1" style="width:200px" 
                                data-bs-toggle="modal" data-bs-target="#ratingModalthem" 
                                onclick="loadTourData('${data[0].id_request}')">
                                Thêm
                            </button>
                        </center> `;
                }

                detailHtml += `</div>`; // Đóng div

                document.getElementById('xemchitiet').innerHTML = detailHtml;
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
function duyet(id) {
       
       fetch('./api/apia.php?action=duyet&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Duyệt thành công', '');
                   
               } else {
                   openPopup('Duyệt không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
document.querySelectorAll('.edit1').forEach(button => {
    button.addEventListener('click', function () {
        let tourId = this.getAttribute('data-id'); // Lấy ID của tour
        loadTourData(tourId); // Gọi hàm để tải dữ liệu vào modal
    });
});
function loadTourData(Id) {
    fetch(`./api/apia.php?action=xemtouryeucau1&id=${Id}`)
        .then(response => response.json())
        .then(data => {
            if (data && data[0]) {
                let tour = data[0];

                // Chuyển JSON lịch trình thành chuỗi
                let itineraryText = '';
                let itineraryData = JSON.parse(tour.itinerary);
                for (const day in itineraryData) {
                    itineraryText += `${day}: ${itineraryData[day]}\n`;
                }

                // Đổ dữ liệu vào form modal
                document.getElementById('ten').value = tour.tour_name;
                document.getElementById('pc').value = tour.style || '';
                document.getElementById('price').value = tour.tour_price;
                document.getElementById('te').value = tour.children_discount || '';
                document.getElementById('td').value = tour.max_people || '';
                document.getElementById('tt').value = tour.min_people || '';
                document.getElementById('dereption').value = tour.description || '';
                document.getElementById('status').value = tour.status || '';
                document.getElementById('nkh').value = tour.departure_date;
                document.getElementById('ddkh').value = tour.departure_location || '';
                document.getElementById('itinerary').value = itineraryText;
                document.getElementById('no').value = tour.tour_duration;
                document.getElementById('gg').value = tour.discount || '';
                document.querySelector('select[name="kt"]').value = tour.tour_type || 'Gia đình';
                document.querySelector('select[name="PT"]').value = tour.transport || 'Xe khách';
                document.querySelector('select[name="vung"]').value = tour.region || 'Nam';
            } else {
                console.error('Không tìm thấy dữ liệu tour.');
            }
        })
        .catch(error => console.error('Lỗi tải dữ liệu:', error));
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
$(document).ready(function() {
      themtour();
       xemtouryeucau();
     
   });
</script>
