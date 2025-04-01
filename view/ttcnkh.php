<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Người Dùng</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   
    <style>
       
        .container {
            margin-top: 30px;
        }
        .profile-section {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color:black;
        }
        .avatar {
            width: 230px;
            height: 230px;
            border-radius: 50%;
            object-fit: cover;
        }
        .btn-primary {
            background-color: #17a2b8;
            border: none;
        }
        label{
            color:black;
        }
        #tuoi {
            font-size: 18px;
            
            color: black;
        }
    </style>
</head>
<body>
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2></h2>
        <p></p>
        <button onclick="closePopup()">Ok</button>
    </div>
    <div class="container">
        <!-- Thông tin cơ bản -->
        <div class="profile-section">
            <div class="profile-header">Thông Tin cá nhân</div>
            <form class="updatettcn" id="updatettcn" action="./api/api.php" method="post"> 
                <input type="hidden" name="action" value="updatettcn">
               <div id='ttcn'></div>
               <div id='xemdiem'></div>
             
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>

        <!-- Ảnh đại diện và đổi mật khẩu -->
        <div class="row">
            <!-- Ảnh đại diện -->
            <div class="col-md-12">
                <div class="profile-section text-center">
                <form class="updateanh" id="updateanh" action="./api/api.php" method="post" enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="updateanh">
                    <div id="anhnen"></div>
                    <br>
                    <input style="color:black" type="file" id="anh" name="anh">
                    <div>
                        <button class="btn btn-primary">Cập nhật ảnh</button>
                    </div>
                </form>
                </div>
            </div>

           
    </div>
    <script>
       function updatettcn() {
        $('#updatettcn').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: './api/api.php',
                data: $(this).serialize(),
                success: function(response) {
                  console.log(response)
                    if(response === 'update_success'){
                        openPopup('Thông báo','cập nhật thành công')
                        setTimeout(function() {
                            window.location.href = 'index.php?ttcnkh';
                        }, 2000);
                    }
                    else if(response === 'missing_data'){
                        openPopup('thông báo','Rỗng');
                    }else{
                        openPopup('Lỗi','Lỗi');
                    }
                    
                    
                }
            });
        });
        
      }; 
      function updateanh() {
    $('#updateanh').submit(function(e) {
        e.preventDefault();

        // Tạo FormData từ form
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: './api/api.php',
            data: formData,
            processData: false, // Không xử lý dữ liệu
            contentType: false, // Không đặt kiểu nội dung mặc định
            success: function(response) {
                console.log(response);
                if (response === 'update_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function() {
                        window.location.href = 'index.php?ttcnkh';
                    }, 2000);
                } else if (response === 'invalid_image') {
                    openPopup('Lỗi', 'Tệp ảnh không hợp lệ! Chỉ chấp nhận các định dạng JPG, PNG, GIF.');
                } else if (response === 'upload_error') {
                    openPopup('Lỗi', 'Lỗi khi tải lên tệp ảnh!');
                } else {
                    openPopup('Lỗi', 'Lỗi không xác định: ' + response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi AJAX:', error);
            }
        });
    });
}

function get_user_info() {
    $.ajax({
        url: './api/api.php?action=get_user_info',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    // Tính tuổi
                    let tuoi = calculateAge(event.Datetime);

                    eventHtml += `
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Tên</label>
                            <input type="text" class="form-control" id="name" name="name" value="${event.Name}">
                        </div>
                        <div class="col-md-4">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="${event.sdt}">
                        </div>
                        <div class="col-md-4">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="dc" name="dc" value="${event.Address}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="dob" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control" id="ns" name="ns" value="${event.Datetime}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tuổi</label>
                            <input type="text" class="form-control" id="tuoi" value="${tuoi}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="EM" name="EM" value="${event.Email}" readonly>
                        </div>
                    </div>`;
                });
                $('#ttcn').html(eventHtml);

                // Gán sự kiện tính tuổi khi thay đổi ngày sinh
                document.getElementById("ns").addEventListener("change", function () {
                    let tuoi = calculateAge(this.value);
                    document.getElementById("tuoi").value = tuoi;
                });
            } else {
                $('#ttcn').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#ttcn').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function xemdiem() {
    $.ajax({
        url: './api/api.php?action=xemdiem',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
          console.log(response)
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                        
        <div class="row mb-3">
                        <div class="col-md-4" style="color:black">
                            <label for="name" class="form-label">Điểm hiện có :</label>
                            ${event.diem} <img src="./assets/img/coin.jpg" width=25px height=25px alt="" srcset=""> 
                        </div>
                        
                    </div>

     

      
     
     `;
                });
                $('#xemdiem').html(eventHtml);
            } else {
                $('#xemdiem').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemdiem').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
// Hàm tính tuổi từ ngày sinh
function calculateAge(dob) {
    if (!dob) return "Chưa có";
    let birthDate = new Date(dob);
    let today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    let monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}
function get_anh() {
    $.ajax({
        url: './api/api.php?action=get_anh',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                    <img src="assets/img/user/${event.profile}" alt="Avatar" class="avatar mb-3">
                   `;
                });
                $('#anhnen').html(eventHtml);
            } else {
                $('#anhnen').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#anhnen').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
      $(document).ready(function() {
        updatettcn();
        get_user_info();
        updateanh();
        get_anh();
        xemdiem();
    });
    </script>
   
</body>
</html>
