<link rel="stylesheet" href="./assets/css/form.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

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
    
.form-container {
    width: 100%; /* Chiều rộng đầy đủ */
    overflow-x: auto; /* Cuộn ngang nếu nội dung vượt quá chiều rộng */
    overflow-y: auto; /* Cuộn dọc nếu cần */
    max-height: 500px; /* Giới hạn chiều cao tối đa */
    border: 1px solid #ddd; /* Đường viền để dễ nhận diện */
    border-radius: 8px;
    background-color: white; /* Đảm bảo nền trắng cho vùng cuộn */
}
#btn-xem{
     background-color: black;
    color: white;
           
}
.containerql {
    display: flex;
    flex-direction: row;
    width: 90%;
    margin: 20px auto;
}

.table-container {
    width: 80%;
    overflow-x: auto;
    border-radius: 8px;
    background-color: white;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.qr-container {
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: white;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-left: 10px;
}

.qr-container h2 {
    font-size: 18px;
    margin-bottom: 10px;
}

#qrcode {
    margin-top: 10px;
}

    </style>

<h1>Quản lý dịch vụ tour</h1>
<div class="modal fade" id="ratingModalxem" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
            <div id="xemtour"></div>
           
          
            </div>
        </div>
    </div>
</div> 

<div class="container">
    <div class="search-bar">
    <span style="padding-right:10px">Tìm kiếm:</span><input style="width:400px;height:40px" type="text" id="search" name="KH" placeholder="Tên khách hàng/Mã tour" onkeydown="searchkh(event)"> 
  
</div>


<div class="containerql">
    <!-- Khu vực bảng (70%) -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tour</th>
                    <th>Gía tour</th>
                    <th>Tổng thanh toán</th>
                    <th>Người đặt</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Phương tiện</th>
                    <th>Ngày đặt</th>
                    <th>Số lượng người tham gia</th>
                    <th>Trạng Thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="employee-table">
                <!-- Dữ liệu sẽ được load từ AJAX -->
            </tbody>
        </table>
    </div>
    
    <!-- Khu vực QR Code (30%) -->
    <div class="qr-container">
        <h2>QR Code</h2>
        <div id="qrcode"></div>
    </div>
</div>

    </div>
   
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
      function xemdichvu() {
    $.ajax({
        url: './api/apia.php?action=xemdichvu',
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
                    <td>${event.Tour_name}</td>
                    <td>${event.Price}</td>
                    <td>${event.Total_pay}</td>
                    <td>${event.User_name}</td>
                    <td>${event.Phone_num}</td>
                    <td>${event.Address}</td>
                    <td>${event.Arrival}</td>
                    <td>${event.Datetime}</td>
                    <td>${event.participants}</td>     
                    `;
                if(event.refund == '1'){
                    eventHtml += '<td><span style="color:red">Hủy đơn</span>' 
                    if(event.Payment_status =='2'){
                        eventHtml += '<br><span style="color:orange;">Chưa hoàn tiền</span></td>' 
                    }
                }else if(event.Booking_status == '1'){
                    
                     eventHtml += '<td><span style="color:green">Chưa xác nhận</span></td>' 
                    
                }else{
                    eventHtml += '<td><span style="color:green">Xác nhận</span></td>' 
                }
                    
                     eventHtml +=`<td>
                        <div class="action-buttons">
                            <button class="btn edit" onclick="xacnhan('${event.Booking_id}')">✔</button>
                            <button style="width:200px;height:40px" id="btn-xem" class="btn xem" data-bs-toggle="modal" data-bs-target="#ratingModalxem" onclick="openRatingModalxem('${event.Booking_id}')">Xem chi tiết</button>
                            <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button> 
                           
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

function searchkh(event) {
    if (event && event.key === "Enter") {  // Kiểm tra nếu event và phím bấm là Enter
        var searchValue = $('#search').val(); // Lấy giá trị từ ô input với id "search"

        // Nếu không có gì để tìm kiếm, không làm gì
        if (searchValue.trim() === "") {
            xemdichvu();
            return;
        }

        $.ajax({
            url: './api/apia.php', // API tìm kiếm nhân viên
            type: 'GET', // Sử dụng phương thức GET
            data: { action: 'timkhMT', KH: searchValue }, // Gửi mã nhân viên tìm kiếm qua GET
            dataType: 'json', // Kết quả trả về là JSON
            success: function(response) {
                console.log(response)
                if (Array.isArray(response) && response.length > 0) {
                    var events = response;
                    var eventHtml = '';
                    events.forEach(function(event) {
                     
                        eventHtml += `
                     
                     <tr>
                   <td>${event.Booking_id}</td>
                   <td>${event.Tour_name}</td>
                   <td>${event.Price}</td>
                   <td>${event.Total_pay}</td>
                   <td>${event.User_name}</td>
                   <td>${event.Phone_num}</td>
                   <td>${event.Address}</td>
                   <td>${event.Arrival}</td>
                   <td>${event.Datetime}</td>
                   <td>${event.participants}</td>     
                   `;
               if(event.refund == '1'){
                   eventHtml += '<td><span style="color:red">Hủy đơn</span>' 
                   if(event.Payment_status =='2'){
                       eventHtml += '<br><span style="color:orange;">Chưa hoàn tiền</span></td>' 
                   }
               }else if(event.Booking_status == '1'){
                   
                    eventHtml += '<td><span style="color:green">Chưa xác nhận</span></td>' 
                   
               }else{
                   eventHtml += '<td><span style="color:green">Xác nhận</span></td>' 
               }
                   
                    eventHtml +=`<td>
                       <div class="action-buttons">
                           <button class="btn edit" onclick="xacnhan('${event.Booking_id}')">✔</button>
                          <button style="width:200px;height:30px" id="btn-xem" class="btn xem" data-bs-toggle="modal" data-bs-target="#ratingModalxem" onclick="openRatingModalxem('${event.Booking_id}')">Xem chi tiết</button>
                            <button class="exportPdfBtn" data-booking-id="${event.Booking_id}">Xuất PDF</button> 
                           
                           </div>
                   </td>
               </tr> 
`;
            
                    });
                    $('#employee-table').html(eventHtml);
                } else {
                    $('#employee-table').html('<tr><td colspan="8">Không tìm thấy tour nào.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi lấy thông tin:', error);
                $('#employee-table').html('<tr><td colspan="8">Đã xảy ra lỗi khi tải thông tin.</td></tr>');
            }
        });
    }
}
function xacnhan(id) {
       
       fetch('./api/apia.php?action=xacnhantour&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xác nhận thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qldichvu';
                   }, 1000);
               } else {
                   openPopup('Xác nhận không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
function huydon(id) {
       
       fetch('./api/apia.php?action=huydon&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?qldichvu';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}






function openRatingModalxem(Id) {
    // Lấy thông tin tour và hiển thị trong modal
    $.ajax({
        url: './api/apia.php?action=xemtoursua&idt=' + Id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response)
            if (response && response.length > 0) {
                var item = response[0]; // Lấy thông tin chung từ bản ghi đầu tiên
                var detailsHtml = `
                   
                    <div class="container4">
                        <h2>THÔNG TIN ĐẶT TOUR</h2>
                        <input type="hidden" id="idtour" name="idtour" value="${item.Tour_id}" >
                        <!-- Thông tin người đặt tour -->
                        <div class="user-info">
                            <h3>Thông tin người đặt</h3>
                            <div class="form-row">
                                <div>
                                    <label for="fullname">Tên tài khoản: ${item.User_name}</label>
                                   
                                </div>
                                <div>
                                    <label for="phone">Số điện thoại: ${item.Phone_num}</label>
                                    
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="address">Địa chỉ: ${item.Address}</label>                               
                                </div>
                                
                            </div>
                        </div>
                         <br><br>
                        <!-- Thông tin tour -->
                        <div class="tour-info">
                            <h3>Thông tin tour</h3>
                            <div class="form-row">
                                <div>
                                    <label for="tour-code">Mã: ${item.Booking_id}</label>
                               
                                </div>
                                <div>
                                    <label for="tour-name">Tên tour: ${item.Tour_name}<label>
                                   
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="departure-date">Thời gian khởi hành: ${item.Datetime}</label>
                                </div>
                                <div>
                                    <label for="duration">Thời gian diễn ra tour (ngày): ${item.Day_depart}</label>
                                   
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="arrival">Phương tiện di chuyển: ${item.Arrival}</label>
                                </div>
                                <div>
                                    <label for="participants">Số lượng người: ${item.participants}</label>
                                    
                                     
                                </div>
                            </div>
                        </div>
                         <br><br>
                        <!-- Thông tin giá -->
                        <div class="pricing-info">
                            <h3>Thông tin giá</h3>
                            <div class="form-row">
                                <div>
                                    <label for="price">Giá vé: ${item.Price}</label>
                                </div>
                                <div>
                                    <label for="total-price">Tổng tiền: ${item.Total_pay}</label>
                               
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <!-- Thông tin thành viên tham gia -->
                        <div class="participant-info">
                            <h3>Thông tin thành viên tham gia</h3>
                `;

                // Duyệt qua danh sách tất cả thành viên
                response.forEach((participant, index) => {
                    
                    detailsHtml += `
                        <div class="form-row1">
                            <div>
                                <label>${participant.phanloai}:</label>
                              <input type="hidden" name="id" value="${participant.idpar}" >
                            </div>
                            <div>
                                <label>Họ tên:</label>
                                <input type="text" name="ht" value="${participant.hoten}" readonly>
                            </div>
                            <div>
                                <label>Ngày sinh:</label>
                                <input type="date" name="ns" value="${participant.ngaysinh}" readonly>
                            </div>
                            <div>
                                <label>Giới tính:</label>
                               <br>
                                <label>${participant.gioitinh}</label>
                                   
                                    
                                
                            </div>
                             <div>
                               
                            </div>
                        </div>
                    <br>`;
                });

                detailsHtml += `
                        </div> <!-- Kết thúc thông tin thành viên -->
                    </div> <!-- Kết thúc container -->
                `;

                $('#xemtour').html(detailsHtml); 
            } else {
                $('#xemtour').html('<div class="col">Không tìm thấy dữ liệu.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy dữ liệu:', error);
            $('#xemtour').html('<div class="col">Đã xảy ra lỗi khi tải dữ liệu.</div>');
        }
    });
}



$(document).ready(function() {
    
      xemdichvu();

    
   });
</script>
<script>
    $(document).on('click', '.exportPdfBtn', function() {
            const bookingId = $(this).data('booking-id');
            if (!bookingId) {
                alert("Vui lòng nhập Booking ID!");
                return;
            }

            $.post('viewa/test.php', { Booking_id: bookingId }, function(response) {
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    // Hiển thị QR Code
                    let qrContainer = document.getElementById('qrcode');
                    qrContainer.innerHTML = ''; // Xóa QR cũ nếu có
                    new QRCode(qrContainer, {
                        text: data.pdf_url,
                        width: 200,
                        height: 200
                    });
                } else {
                    alert('Lỗi khi tạo PDF!');
                }
            });
        });
</script>