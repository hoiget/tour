<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/dangkyy.css">
    <link rel="stylesheet" href="../assets/css/popup.css">
    <link rel="stylesheet" href="../assets/css/mat.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
// Kết nối cơ sở dữ liệu
require '../api/connect.php'; // Tải thư viện PHPMailer


// Kiểm tra nếu có token trong URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Kiểm tra token hợp lệ và chưa hết hạn
    $query = $conn->prepare("SELECT id FROM user_credit WHERE reset_token = ? AND token_expiry > NOW()");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Token hợp lệ, hiển thị form đổi mật khẩu
        echo '
        
          <div class="container">
    <div class="columns">
    <div class="register-form">
         <h2>Nhập mật khẩu</h2>
               <form class="my-form" action="#" method="POST" id="passwordForm"> 
                <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">

                  <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới">
                        <i class="far fa-eye" id="eye" onclick="togglePasswordVisibility("password", "eye")"></i>
                    </div>
           
                   <button type="submit"class="my-form__button" onclick="mk()"> Đổi mật khẩu</button> 
           </form>
              </div> </div> </div>
              
              
              ';

             
    } else {
        echo "<script>openPopup('Liên kết không hợp lệ hoặc đã hết hạn.','');</script>";
        echo "<script>
        setTimeout(function() {
                        window.location.href = 'http://localhost/tour/dangnhap.php';
        }, 5000);
        </script>";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
<script>


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



function mk() {
    $('#passwordForm').submit(function(e) {
        e.preventDefault();
        let password = document.getElementById('password').value;
  

         let passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    

        if (password === "") {
            openPopup('Lỗi', 'Vui lòng điền đầy đủ thông tin.');
        
            return;
        }

        

        else if(!passwordPattern.test(password)) {
            openPopup('Lỗi',"Mật khẩu phải chứa ít nhất 1 chữ cái, 1 số và 1 ký tự đặc biệt và có ít nhất 8 ký tự!");
            
            return;
        }
        this.submit(); 
    });

    
       

}
    

   

</script>

<?php
include_once("reset_password_process.php");

?>
</body>
</html>
