<?php 
ob_start();
?>
<?php

session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['Email']) && isset($_SESSION['sdt'])) {
   // Lưu thông tin người dùng từ session
   $user_id = $_SESSION['id']; // Lấy id từ session
   $username = $_SESSION['Name']; // Lấy tên người dùng từ session
   $email = $_SESSION['Email'];
   $sdt = $_SESSION['sdt']; // Lưu số điện thoại
   $dia_chi = $_SESSION['Address']; // Lưu địa chỉ
   $profile = $_SESSION['profile']; // Lưu đường dẫn ảnh đại diện (nếu có)
   $namsinh = $_SESSION['Datetime']; // Lưu ngày giờ tạo tài khoản

   // Tạo cookie phiên (chỉ tồn tại đến khi đóng trình duyệt)
   setcookie('login_cookie', $email, 0, "/"); // Cookie phiên

   if (!isset($_SESSION['login_time'])) {
       $_SESSION['login_time'] = time();
   }
   
   // Lưu thông tin người dùng trong JavaScript (nếu cần)
 

}

// Kiểm tra thời gian đăng nhập
$currentTime = time();
if (isset($_SESSION['login_time']) && ($currentTime - $_SESSION['login_time'] > 3600)) { // Kiểm tra nếu vượt quá 1 tiếng
   // Xóa session (cookie sẽ tự động bị xóa khi đóng trình duyệt)
   session_unset();
   session_destroy();

   // Chuyển hướng về trang đăng nhập
   header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập
   exit();

}
?>
<script>
// Lấy sessionId từ PHP session
const sessionId = <?php echo json_encode($_SESSION['id']); ?>;

console.log("Session ID:", sessionId); // Kiểm tra giá trị
</script>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Hệ thống đăth tour/khách sạn trực tuyến</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/logo.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Cardo:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/indexx.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>





    <!-- =======================================================
  * Template Name: PhotoFolio
  * Template URL: https://bootstrapmade.com/photofolio-bootstrap-photography-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2></h2>
        <p></p>
        <button onclick="closePopup()">Ok</button>
    </div>





    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

            <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="assets/img/logo.png" alt="">
                <!-- <i class="bi bi-camera"></i> -->
                <h1 class="sitename">GoWander</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php" class="active">Trang chủ<br></a></li>
                    <li><a href="index.php?about">Giới thiệu</a></li>
                    <li class="dropdown"><a href="#"><span>Dịch vụ</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li class="dropdown">
                                <a href="index.php?tour"><span>Đặt tour</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul class="submenu-right">
                                    <li><a href="index.php?tour&mien=Nam">Tour miền nam</a></li>
                                    <li><a href="index.php?tour&mien=Bắc">Tour miền bắc</a></li>
                                    <li><a href="index.php?tour&mien=Trung">Tour miền trung</a></li>
                                    <li><a href="index.php?tour&mien=Tây">Tour miền tây</a></li>
                                    <li><a href="index.php?tour&mien=Ngoài nước">Tour nước ngoài</a></li>
                                    <?php if(isset($_SESSION['Email']) && isset($_SESSION['sdt'])) { ?>
                                    <li><a href="index.php?custom_tour">Tour theo yêu cầu</a></li>
                                    <?php }?>

                                </ul>          
                            </li>
                            <li><a href="index.php?ks">Khách sạn</a></li>
                          

                        </ul>
                    </li>
                    <li><a href="index.php?tintuc">Tin tức</a></li>
                    <li><a href="index.php?contact">Liên hệ</a></li>
                    <?php
if (!isset($_SESSION['Email']) && !isset($_SESSION['sdt'])) {
?>
                    <li><a href="dangnhap.php"> <i class="fas fa-user"></i>Đăng nhập</a></li>
                    <li><a href="dangky.php"><i class="fas fa-user-plus"></i>ĐĂNG KÝ</a></li>
                    <?php }elseif(isset($_SESSION['Email']) && isset($_SESSION['sdt'])) {?>
                    <?php

?>
                    <li class="dropdown">
                        <a href="index.php">
                            <span>
                                <?php echo '<img style="width:40px;height:40px;border-radius:30px" src="assets/img/user/'.$profile.'" alt=""> '.$username; ?></span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="#"><?php echo $username;?></a></li>
                            <hr>
                            <li><a href="index.php?ttcnkh">Thông tin cá nhân</a></li>
                            <li><a href="index.php?xemdattour">Xem đơn đặt tour</a></li>
                            <li><a href="index.php?xemdatks">Xem đơn đặt khách sạn</a></li>
                            <li><a href="logout.php">Đăng xuất</a></li>
                          
                        </ul>
                    </li>
                    <?php
}
?>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <div class="header-social-links">
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>



            </div>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->

        <?php
 $show=true;
if(isset($_REQUEST['about'])){
    $show = false;
    include_once("view/about.php");
}if(isset($_REQUEST['tintuc'])){
    $show = false;
    include_once("view/tintuc.php");
}if(isset($_REQUEST['contact'])){
    $show = false;
    include_once("view/contact.php");
}if(isset($_REQUEST['ttcnkh'])){
  $show = false;
  include_once("view/ttcnkh.php");
}if(isset($_REQUEST['tour'])){
  $show = false;
  include_once("view/xemtour.php");
}if(isset($_REQUEST['tour1'])){
    $show = false;
    include_once("view/xemtour.php");
  }
if(isset($_REQUEST['idtour'])){
  $show = false;
  include_once("view/xemtourchitiet.php");
}if(isset($_REQUEST['ks'])){
  $show = false;
  include_once("view/xemkhachsan.php");
}if(isset($_REQUEST['idks'])){
  $show = false;
  include_once("view/xemkschitiet.php");
}

if(isset($_SESSION['Email']) && isset($_SESSION['sdt'])) {
if(isset($_REQUEST['dattour'])){
  $show = false;
  include_once("view/dattour.php");
}if(isset($_REQUEST['xemdattour'])){
  $show = false;
 
  include_once("view/xemdattour.php");
  
}if(isset($_REQUEST['datks'])){
  $show = false;
  include_once("view/datks.php");
}if(isset($_REQUEST['xemdatks'])){
  $show = false;
  include_once("view/xemdatks.php");
}if(isset($_REQUEST['return'])){
  $show = false;
  include_once("view/vnpay_return.php");
}if(isset($_REQUEST['idtt'])){
  $show = false;
  include_once("view/thanhtoan.php");
}if(isset($_REQUEST['momo'])){
    $show = false;
    include_once("view/thanhtoanmomo.php");
  }if(isset($_REQUEST['cash'])){
    $show = false;
    include_once("view/tienmat.php");
  }
if(isset($_REQUEST['idttks'])){
  $show = false;
  include_once("view/thanhtoanks.php");
}if(isset($_REQUEST['returnks'])){
  $show = false;
  include_once("view/vnpay_returnks.php");
}
if(isset($_REQUEST['custom_tour'])){
    $show = false;
    include_once("view/themtouryeucau.php");
 }
include_once("view/mes.php");
}
if($show){
    include_once("view/layout.php");
}

?>


    </main>

    <footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-left">
              
                <ul class="footer-nav">
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="index.php?about">Giới thiệu</a></li>
                   
                    <li><a href="index.php?contact">Liên hệ</a></li>
                    <li><a href="index.php?tintuc">Tin tức</a></li>

                    <li>   <a style='text-decoration: none;' href="#" class="site-footer-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Chính sách bảo mật</a></li>
                 


<div style="width:900px" class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Chính sách bảo mật</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
<p style="color:black;text-align:justify;white-space:pre-line;font-size:20px"><b>1. Giới thiệu

Chúng tôi,GoWander, cam kết bảo vệ quyền riêng tư và dữ liệu cá nhân của khách hàng khi sử dụng dịch vụ đặt tour và khách sạn trực tuyến. Chính sách bảo mật này giải thích cách chúng tôi thu thập, sử dụng và bảo vệ thông tin<br>
2. Thông tin thu thập
- Khi sử dụng hệ thống, chúng tôi có thể thu thập các loại thông tin sau:
- Thông tin cá nhân: Họ tên, email, số điện thoại, địa chỉ.
- Thông tin thanh toán: Số thẻ tín dụng/ghi nợ (được mã hóa), phương thức thanh toán.
- Thông tin đặt chỗ: Ngày đặt tour, khách sạn, số lượng khách.
- Thông tin thiết bị: Địa chỉ IP, trình duyệt, hệ điều hành.<br>
3. Mục đích sử dụng thông tin
- Chúng tôi sử dụng thông tin thu thập được để:
- Xử lý và xác nhận đơn đặt chỗ.
- Cung cấp dịch vụ hỗ trợ khách hàng.
- Gửi thông tin khuyến mãi, ưu đãi (nếu khách hàng đồng ý).
- Cải thiện chất lượng dịch vụ và trải nghiệm người dùng.<br>
4. Chia sẻ thông tin
Chúng tôi cam kết không bán, trao đổi thông tin cá nhân của bạn cho bên thứ ba. Tuy nhiên, chúng tôi có thể chia sẻ thông tin với:
-Nhà cung cấp dịch vụ khách sạn, tour du lịch để xử lý đặt chỗ.
-Đối tác thanh toán để thực hiện giao dịch.
-Cơ quan pháp luật khi có yêu cầu hợp pháp.<br>
5. Bảo mật thông tin
Chúng tôi áp dụng các biện pháp bảo mật như mã hóa dữ liệu, tường lửa và kiểm soát truy cập để bảo vệ thông tin khách hàng khỏi rủi ro truy cập trái phép.<br>
6. Quyền lợi khách hàng
Khách hàng có quyền:
- Yêu cầu xem, chỉnh sửa hoặc xóa thông tin cá nhân của mình.
- Hủy đăng ký nhận email quảng cáo.
- Khiếu nại nếu phát hiện hành vi vi phạm bảo mật.<br>
7. Thời gian lưu trữ
Thông tin cá nhân của khách hàng sẽ được lưu trữ trong thời gian cần thiết để cung cấp dịch vụ, hoặc theo quy định pháp luật.
</b></p>

  </div>
</div>
                </ul>
                <div class="contact-info">
                    <p>📍 123 Đường ABC, Quận 1, TP.HCM</p>
                    <p>📧 contact@gowander.com</p>
                    <p>📞 0123-456-789</p>
                </div>
            </div>

            <div class="footer-right">
                <div class="social-links">
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
                <div class="newsletter">
                    <p>Nhận tin khuyến mãi & ưu đãi:</p>
                    <input type="email" placeholder="Nhập email của bạn">
                    <button>Đăng ký</button>
                </div>
                <div class="footer-logo">
                    <img src="assets/img/logo.png" width=80px height=80px alt="GoWander Logo">
                    GoWander
                </div>
            </div>
        </div>
    </div>
    <center><p> © 2025 <strong>GoWander</strong>. All Rights Reserved</p></center>
</footer>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>



    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script>
    // Đảm bảo popup được định nghĩa đúng
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

<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  chat-title="chat"
  agent-id="6ba7722e-f169-4c21-a783-8bb322ff9377"
  language-code="vi"
  style="height: 100px; width: 100px;"
></df-messenger>
</body>

</html>