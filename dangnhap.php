<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/dangk.css">
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
                    
                    <!-- <div class="h-captcha" data-sitekey="7cc22840-c9f4-49f0-942c-f3f0e9ce8f08"></div> -->
                    <button type="submit" onclick="showlogio()">Đăng nhập</button>
                    
                </form>
                <!-- <script src="https://hcaptcha.com/1/api.js" async defer></script> -->
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

$(document).ready(function() {
    $("#loginform").submit(function(e) {
        e.preventDefault(); // Ngăn chặn load lại trang mặc định

        let email = $("#email").val().trim();
        let password = $("#password").val().trim();

        if (email === "" || password === "") {
            openPopup("Lỗi", "Vui lòng điền đầy đủ thông tin.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "./api/api.php",
            data: $(this).serialize(),
            success: function(response) {
                if (response === "customer") {
                    openPopup("Đăng nhập thành công", "");
                    setTimeout(() => { window.location.href = "index.php"; }, 1000);
                } else if (response === "staff" || response === "admin") {
                    openPopup("Đăng nhập thành công", "");
                    setTimeout(() => { window.location.href = "indexa.php"; }, 1000);
                } else {
                    openPopup("Đăng nhập thất bại", "Thông tin không chính xác.");
                }
            },
            error: function() {
                openPopup("Lỗi kết nối", "Không thể kết nối đến server.");
            }
        });
    });
});


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
