<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/dangky.css">
    <link rel="stylesheet" href="assets/css/popup.css">
    <link rel="stylesheet" href="assets/css/mat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                <h2>Đăng nhập</h2>
                <form class="my-form" id="loginform" action="./api/api.php" method="post"> 
                <input type="hidden" name="action" value="login">
                  
                    <input type="text" id="email" name="email" placeholder="Email/Số điện thoại" required>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Mật khẩu">
                        <i class="far fa-eye" id="eye" onclick="togglePasswordVisibility('password', 'eye')"></i>
                    </div>
                    <button type="submit" onclick="showlogio()">Đăng nhập</button>
                </form>
                <table style="width:100%">
                    <tr>
                        <td > <p><a href="dangky.php">Chưa có tài khoản</a></p></td>
                        <td style="text-align: right;"> <p><a href="quenmk.php">Quên mật khẩu</a></p></td>
                    </tr>
                </table>
               
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
    let email = document.getElementById("email"); 
    let password = document.getElementById("password"); 
    
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



function showlogio() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (email === "" || password === "") {
        openPopup('Vui lòng điền đầy đủ thông tin.', '');
        return;
    }

    $(document).ready(function() {
        $('#loginform').submit(function(e) {
            e.preventDefault(); // Prevents the form from submitting the traditional way
            $.ajax({
                type: 'POST',
                url: './api/api.php',
                data: $(this).serialize(),
                success: function(response) {
                    if (response === 'success') {
                        openPopup('Đăng nhập Thành công', '');
                        window.location.href = 'index.php'; // Redirect after successful login
                    } else {
                        
                        openPopup('Đăng nhập thất bại', 'Thông tin không đúng.');
                    }
                },
                error: function() {
                    openPopup('Lỗi kết nối', 'Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });
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
