<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login Employee</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
 

  <!-- Template Main CSS File -->
  <link href="assets/css/a.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/popup.css">
    <link rel="stylesheet" href="assets/css/mat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2></h2>
        <p></p>
        <button onclick="closePopup()">Ok</button>
    </div>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="nv-login.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                  <a class="dn" href="a-login.php">Đăng nhập quản trị viên</a>
                    <h5 class="card-title text-center pb-0 fs-4">Đăng nhập</h5>
                  </div>

                
                  <form class="my-form row g-3 needs-validation" id="loginformnv" action="./api/apia.php" method="post" novalidate> 
                  <input type="hidden" name="action" value="loginnv">
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Tài khoản</label>
                      <div class="input-group has-validation">
                      
                        <input type="text" id="name" name="name" class="form-control" id="yourUsername" required>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" id="password" name="password" class="form-control" id="yourPassword" required>
                    </div>

                    
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" onclick="showloginnv()">Đăng nhập</button>
                    </div>
                   
                  </form>

                </div>
              </div>

            

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/mainad.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script>

let loginForm = document.querySelector(".my-form"); 
loginForm.addEventListener("submit", (e) => { 
e.preventDefault(); 
let email = document.getElementById("name"); 
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


function showloginnv() {
let email = document.getElementById('name').value;
let password = document.getElementById('password').value;

if (email === "" || password === "") {
    openPopup('Vui lòng điền đầy đủ thông tin.', '');
    return;
}

$(document).ready(function() {
    $('#loginformnv').submit(function(e) {
        e.preventDefault(); // Prevents the form from submitting the traditional way
        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response)
                if (response === 'success') {
                    openPopup('Đăng nhập Thành công', '');
                    window.location.href = 'indexa.php'; // Redirect after successful login
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