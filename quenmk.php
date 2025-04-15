<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
  
    <link rel="stylesheet" href="assets/css/dangkyy.css">
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
                <h2>Nhập email</h2>
                <form class="my-form" action="#" method="POST">            
                  
                    <input type="text" id="email" name="email" placeholder="Nhập Email cuản bạn" required>
                    
                    <button type="submit" >Gửi yêu cầu</button>
                </form>
                
               
        </div>  </div>  </div>


<script>
    const popup = document.querySelector('#popup'); // Sử dụng ID hoặc selector phù hợp
const overlay = document.querySelector('#overlay'); // Đảm bảo overlay cũng được gán đúng

function openPopup(title, message) {
    if (popup) {
        popup.querySelector('h2').innerText = title;
        popup.querySelector('p').innerText = message;
        popup.style.display = 'block';
    } else {
        console.error('Không tìm thấy popup trong DOM.');
    }


    if (overlay) {
        overlay.style.display = 'block';
    } else {
        console.error('Không tìm thấy overlay trong DOM.');
    }
}

function closePopup() {
    if (popup) {
        popup.style.display = 'none';
    }
    if (overlay) {
        overlay.style.display = 'none';
    }
}

</script>
<?php 
include_once("./quenmk/forgot_password_process.php");

?>
</body>
</html>
