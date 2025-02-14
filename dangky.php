<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/css/dangky.css">
    <link rel="stylesheet" href="assets/css/popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/mat.css">

</head>
<body>
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2></h2>
        <p></p>
        <button onclick="closePopup()">Ok</button>
    </div>
    <div class="container">
        <div class="columns">
            <div class="register-form">
            <p><a href="index.php">Quay lại trang chủ</a></p>
                <h2>Đăng ký</h2>
                <form class="my-form" id="registerForm" action="./api/api.php" method="post" enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="register">
                    <input type="text" id="name" name="name" placeholder="Tên tài khoản" >
                    <input type="email" id="email" name="email" placeholder="Email" >
                    <input type="tel" id="sdt" name="sdt" placeholder="Số điện thoại" >
                    <input type="file" id="anh" name="anh">
                    <input type="text" id="dc" name="dc" placeholder="Địa chỉ" >
                    <input type="date" id="ns" name="ns">
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Mật khẩu">
                        <i class="far fa-eye" id="eye" onclick="togglePasswordVisibility('password', 'eye')"></i>
                    </div>
                    <div class="password-container">
                        <input type="password" id="Repassword" name="Repassword" placeholder="Nhập lại mật khẩu">
                        <i class="far fa-eye" id="eye1" onclick="togglePasswordVisibility('Repassword', 'eye1')"></i>
                    </div>
                   
                    <button type="submit" onclick="showss()">Tạo tài khoản mới</button>
                    
                </form>
                <p>Đã có tài khoản <a href="dangnhap.php">Đăng nhập</a></p>
            </div>
            <div class="info-box">
                <h3>Tại sao mọi người chọn?</h3>
                <ul>
                    <li>📉 Giá tốt</li>
                    <li>🎧 Dịch vụ hàng đầu</li>
                    <li>💳 Thanh toán an toàn</li>
                    <li>✅ Đáng tin cậy</li>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <script>
        let loginForm = document.querySelector(".my-form"); 
loginForm.addEventListener("submit", (e) => { 
    e.preventDefault(); 
    let name = document.getElementById('name');
    let email = document.getElementById('email');
    let phone = document.getElementById('sdt');
    let address = document.getElementById('dc');
    let birthdate = document.getElementById('ns');
    let password = document.getElementById('password');
    let rePassword = document.getElementById('Repassword');
    let fileInput = document.getElementById('anh'); // Input file
   
});

function openPopup(title, message) {
    popup.querySelector('h2').innerText = title;
    popup.querySelector('p').innerText = message;
    popup.style.display = 'block';
    overlay.style.display = 'block';
}
function closePopup() {
        popup.style.display = 'none';
        overlay.style.display = 'none';
}
function showss() {
    // Lấy các phần tử từ biểu mẫu
    let name = document.getElementById('name').value.trim();
    let email = document.getElementById('email').value.trim();
    let phone = document.getElementById('sdt').value.trim();
    let address = document.getElementById('dc').value.trim();
    let birthdate = document.getElementById('ns').value.trim();
    let password = document.getElementById('password').value.trim();
    let rePassword = document.getElementById('Repassword').value.trim();
    let fileInput = document.getElementById('anh'); // Input file

    // Các mẫu kiểm tra dữ liệu
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^0\d{9}$/; // Số điện thoại Việt Nam 10 chữ số
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    // Kiểm tra các trường dữ liệu
    if (!name || !email || !phone || !address || !birthdate || !password || !rePassword) {
        openPopup('Lỗi', 'Vui lòng điền đầy đủ thông tin.');
        return;
    }

    if (!emailPattern.test(email)) {
        openPopup('Lỗi', 'Email không hợp lệ! Vui lòng nhập đúng định dạng.');
        return;
    }

    if (!phonePattern.test(phone)) {
        openPopup('Lỗi', 'Số điện thoại không hợp lệ! Vui lòng nhập đúng định dạng (0xxxxxxxxx).');
        return;
    }

    if (!passwordPattern.test(password)) {
        openPopup('Lỗi', 'Mật khẩu phải chứa ít nhất 1 chữ cái, 1 số, 1 ký tự đặc biệt và ít nhất 8 ký tự.');
        return;
    }

    if (password !== rePassword) {
        openPopup('Lỗi', 'Mật khẩu và xác nhận mật khẩu không khớp!');
        return;
    }

    // Tạo đối tượng FormData để gửi dữ liệu và tệp
    let formData = new FormData();
    formData.append('action', 'register');
    formData.append('name', name);
    formData.append('email', email);
    formData.append('sdt', phone);
    formData.append('dc', address);
    formData.append('ns', birthdate);
    formData.append('password', password);
    formData.append('Repassword', rePassword);

    // Kiểm tra và thêm tệp ảnh (nếu có)
    if (fileInput.files.length > 0) {
        formData.append('anh', fileInput.files[0]);
    }

    // Gửi yêu cầu AJAX
    $.ajax({
        type: 'POST',
        url: './api/api.php',
        data: formData,
        processData: false, // Không xử lý dữ liệu
        contentType: false, // Không đặt kiểu Content-Type mặc định
        success: function (response) {
            console.log(response);
            if (response === 'registration_success') {
                openPopup('Thành công', 'Đăng ký thành công!');
            } else if (response === 'user_exists') {
                openPopup('Lỗi', 'Email hoặc số điện thoại đã được sử dụng!');
            } else if (response === 'password_mismatch') {
                openPopup('Lỗi', 'Mật khẩu không khớp!');
            } else if (response === 'invalid_image') {
                openPopup('Lỗi', 'Tệp ảnh không hợp lệ! Chỉ chấp nhận các định dạng JPG, PNG, GIF.');
            } else if (response === 'upload_error') {
                openPopup('Lỗi', 'Lỗi khi tải lên tệp ảnh!');
            } else {
                openPopup('Lỗi', 'Đăng ký thất bại. Vui lòng thử lại!');
            }
        },
        error: function () {
            openPopup('Lỗi', 'Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau!');
        }
    });
}
function togglePasswordVisibility(inputId, iconId) {
    let passwordInput = document.getElementById(inputId);
    let eyeIcon = document.getElementById(iconId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}

    </script>
</body>
</html>
