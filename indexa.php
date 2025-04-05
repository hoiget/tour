<?php 
ob_start();
?>
<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['Admin_name'])) {
   // Lưu thông tin người dùng từ session
   $user_id = $_SESSION['Sr_no']; // Lấy id từ session
   $username = $_SESSION['Admin_name']; // Lấy tên người dùng từ session
   
   // Tạo cookie phiên (chỉ tồn tại đến khi đóng trình duyệt)
   setcookie('login_cookie', $username, 0, "/"); // Cookie phiên

   if (!isset($_SESSION['login_time'])) {

       $_SESSION['login_time'] = time();
   }
   
   // Lưu thông tin người dùng trong JavaScript (nếu cần)
   echo "<script>var sessionId = " . json_encode($user_id) . ";</script>";
   $currentTime = time();
if (isset($_SESSION['login_time']) && ($currentTime - $_SESSION['login_time'] > 3600)) { // Kiểm tra nếu vượt quá 1 tiếng
   // Xóa session (cookie sẽ tự động bị xóa khi đóng trình duyệt)
   session_unset();
   session_destroy();

   // Chuyển hướng về trang đăng nhập
   header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập
   exit();}
}elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
  $user_id=$_SESSION['id'] ;
  $code=$_SESSION['Employee_code']; // Mã nhân viên
  $name=$_SESSION['Name'] ; // Tên người dùng
  $username1=$_SESSION['Username']; // Tên đăng nhập
  $email=$_SESSION['Email'] ; // Email
  $sdt=$_SESSION['Phone_number']; // Số điện thoại
  $dc=$_SESSION['Address'] ; // Địa chỉ
  $role=$_SESSION['Permissions'] ; // Quyền hạn (QL, CSKH, HDV)
  $ng=$_SESSION['Created_at'] ; // Ngày tạo tài khoản
  setcookie('login_cookie', $email, 0, "/"); // Cookie phiên

  if (!isset($_SESSION['login_time'])) {
      $_SESSION['login_time'] = time();
  }
  
  // Lưu thông tin người dùng trong JavaScript (nếu cần)
  echo "<script>var sessionId = " . json_encode($user_id) . ";</script>";
  $currentTime = time();
if (isset($_SESSION['login_time']) && ($currentTime - $_SESSION['login_time'] > 3600)) { // Kiểm tra nếu vượt quá 1 tiếng
   // Xóa session (cookie sẽ tự động bị xóa khi đóng trình duyệt)
   session_unset();
   session_destroy();

   // Chuyển hướng về trang đăng nhập
   header("Location: dangnhap.php"); // Chuyển hướng về trang đăng nhập
   exit();
}}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
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

  <link rel="stylesheet" href="assets/css/popup.css">
  <!-- Template Main CSS File -->
  <link href="assets/css/a.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


 
</head>

<body>
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2></h2>
        <p></p>
        <button onclick="closePopup()">Ok</button>
    </div>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="indexa.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">NiceAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
    <span><h3><?php 
            if(isset($_SESSION['Admin_name'])){
              echo "<center>Quản trị viên</center>"; 
            }elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
              if($role == 'QL'){
                echo "<center>Nhân viên dịch vụ</center>"; 
              }elseif($role == 'CSKH'){
                echo "<center>Nhân viên chăm sóc khách hàng</center>";
              }elseif($role == 'HDV'){
                echo "<center>Hướng dẫn viên</center>";
              }
              
            }
           ?></h3></span>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

      
         
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php 
            if(isset($_SESSION['Admin_name'])){
              echo $username; 
            }elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
              echo $username1; 
            }
           ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php 
            if(isset($_SESSION['Admin_name'])){
              echo $username; 
            }elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
              echo $username1; 
            }
           ?></h6>
              <span><?php 
            if(isset($_SESSION['Admin_name'])){
              echo "Quản trị viên"; 
            }elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
              if($role == 'QL'){
                echo "Nhân viên dịch vụ"; 
              }elseif($role == 'CSKH'){
                echo "Nhân viên chăm sóc khách hàng";
              }elseif($role == 'HDV'){
                echo "Hướng dẫn viên";
              }
              
            }
           ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="indexa.php?ttcna">
                <i class="bi bi-person"></i>
                <span>Thông tin cá nhân</span>
              </a>
            </li>
           
           
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
<?php
 if(isset($_SESSION['Admin_name'])){
?>

      <li class="nav-item">
        <a class="nav-link" href="indexa.php">
        <i class="bi bi-house"></i>
          <span>Trang chủ</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?taonhanvien">
        <i class="bi bi-person-plus"></i>
          <span>Tạo nhân viên</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?qlnhanvien">
        <i class="bi bi-gear"></i>
          <span>Quản lý nhân viên</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?feedback">
        <i class="bi bi-chat-square-dots"></i>
          <span>xem feedback</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?xembaocao">
        <i class="bi bi-table"></i>

          <span>xem báo cáo</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?PL">
        <i class="bi bi-calendar-check"></i>
          <span>Phân lịch nhân viên</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?PQ">
        <i class="bi bi-person-gear"></i>
          <span>Phân quyền nhân viên</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?TKK">
        <i class="bi bi-lock-fill"></i>
          <span>Tài khoản bị khóa</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?qldichvu">
        <i class="bi bi-clipboard-check"></i>
        <span>Quản lý đơn tour</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="indexa.php?qldichvuks">
        <i class="bi bi-building"></i>
          <span>Quản lý đơn dịch vụ khách sạn</span>
        </a>
          </li>
      <?php
}
elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
?>
<li class="nav-item">
        <a class="nav-link " href="indexa.php">
        <i class="bi bi-house"></i>
          <span>Trang chủ</span>
        </a>
</li>
<?php if($role == 'CSKH'){?>
<li class="nav-item">
        <a class="nav-link " href="indexa.php?lichcskh">
        <i class="bi bi-calendar"></i>
          <span>Lịch làm việc</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="indexa.php?tour">
        <i class="bi bi-binoculars"></i>
          <span>Xem tour</span>
        </a>
      </li><!-- End Dashboard Nav -->
     
      <?php } ?>
<?php if($role == 'HDV'){?>
  <li class="nav-item">
        <a class="nav-link " href="indexa.php?xemdv">
        <i class="bi bi-info-circle"></i>
          <span>xem dịch vụ</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="indexa.php?baocao">
        <i class="bi bi-journal-text"></i>

          <span>Viết báo cáo</span>
        </a>
      </li><!-- End Dashboard Nav -->   
      <li class="nav-item">
        <a class="nav-link " href="indexa.php?baonv">
        <i class="bi bi-table"></i>

          <span>Xem báo cáo</span>
        </a>
      </li><!-- End Dashboard Nav -->   
          <?php } ?>
      <?php if($role == 'QL'){?>
      <li class="nav-item">
        <a class="nav-link " href="indexa.php?feedback">
        <i class="bi bi-chat-square-dots"></i>
          <span>xem feedback</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="indexa.php?lichql">
        <i class="bi bi-calendar"></i>
          <span>Lịch làm việc</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="indexa.php?hdv">
        <i class="bi bi-calendar-check"></i>
          <span>Phân lịch hướng dẫn viên</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="indexa.php?cskh">
        <i class="bi bi-person-badge text-primary"></i>
          <span>Phân nhân viên chăm sóc khách hàng</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <?php } ?>
      <?php if($role == 'HDV'){
        echo "";}else{?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Quản lý</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <?php if($role == 'QL'){?>
          <li>
            <a href="indexa.php?qlkh">
            <i class="bi bi-person"></i><span>Quản lý khách hàng</span>
            </a>
          </li>
          <li>
            <a href="indexa.php?qltour">
            <i class="bi bi-geo-alt"></i><span>Quản lý tour</span>
            </a>
          </li>
          <li>
            <a href="indexa.php?touryeucau">
            <i class="bi bi-geo-alt"></i><span>Tour theo yêu cầu</span>
            </a>
          </li>
          <li>
            <a href="indexa.php?qlroom">
            <i class="bi bi-house-door"></i><span>Quản lý room</span>
            </a>
            
          </li>
          <li>
            <a href="indexa.php?qltx">
            <i class="bi-person-badge-fill"></i><span>Quản lý tài xế</span>
            </a>
            
          </li>
      
          <li>
            <a href="indexa.php?qltintuc">
            <i class="bi bi-newspaper"></i><span>Quản lý tin tức</span>
            </a>
          </li>
          <li>
            <a href="indexa.php?qldacdiem">
            <i class="bi bi-gear"></i><span>Quản lý đặc điểm phòng</span>
            </a>
          </li>
          <li>
            <a href="indexa.php?qltienich">
            <i class="bi bi-lightbulb"></i><span>Quản lý tiện ích phòng</span>
            </a>
          </li>
          <li>
            <a href="indexa.php?qlthuexe">
            <i class="bi bi-lightbulb"></i><span>Quản lý thuê xe</span>
            </a>
          </li>
         <?php } ?>
         <?php if($role == 'CSKH'){?>
          <li>
            <a href="indexa.php?qldichvu">
            <i class="bi bi-clipboard-check"></i></i><span>Quản lý đơn tour</span>
            </a>
          </li>
          <li>
            <a href="indexa.php?qldichvuks">
            <i class="bi bi-building"></i><span>Quản lý đơn dịch vụ khách sạn</span>
            </a>
          </li>

          <?php }} ?>
          
        </ul>
      </li><!-- End Components Nav -->

    
     

      <?php
}
?>
     

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
 
<?php


 if(isset($_SESSION['Admin_name'])){
  $show=true;
  if(isset($_REQUEST['ttcna'])){
    $show = false;
    include_once("viewa/ttcna.php");
  }if(isset($_REQUEST['taonhanvien'])){
    $show = false;
    include_once("viewa/taonhanvien.php");
  }if(isset($_REQUEST['qlnhanvien'])){
    $show = false;
    include_once("viewa/qlnhanvien.php");
  }if(isset($_REQUEST['feedback'])){
    $show = false;
    include_once("viewa/feedback.php");
  }if(isset($_REQUEST['PL'])){
    $show = false;
    include_once("viewa/phanlichad.php");
  }if(isset($_REQUEST['PQ'])){
    $show = false;
    include_once("viewa/phanquyen.php");
  }if(isset($_REQUEST['xembaocao'])){
    $show = false;
    include_once("viewa/xembaocao.php");
  }if(isset($_REQUEST['TKK'])){
    $show = false;
    include_once("viewa/TKK.php");
  } if(isset($_REQUEST['qldichvu'])){
    $show = false;
    include_once("viewa/qldondichvu.php");
  }if(isset($_REQUEST['qldichvuks'])){
    $show = false;
    include_once("viewa/qldondichvuks.php");
  }
  if($show){
    include_once("viewa/thongke.php");
}
}elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
 
  if($role == 'QL'){
    $show=true;
    if(isset($_REQUEST['ttcna'])){
      $show = false;
      include_once("viewa/ttcna.php");
    }if(isset($_REQUEST['feedback'])){
      $show = false;
      include_once("viewa/feedback.php");
    }if(isset($_REQUEST['qltintuc'])){
      $show = false;
      include_once("viewa/qltintuc.php");
    }if(isset($_REQUEST['qlkh'])){
      $show = false;
      include_once("viewa/qltaikhoankh.php");
    }if(isset($_REQUEST['qltienich'])){
      $show = false;
      include_once("viewa/qltienich.php");
    }if(isset($_REQUEST['qldacdiem'])){
      $show = false;
      include_once("viewa/qldacdiem.php");
    }if(isset($_REQUEST['qltour'])){
      $show = false;
      include_once("viewa/qltour.php");
    }if(isset($_REQUEST['qlroom'])){
      $show = false;
      include_once("viewa/qlroom.php");
    }if(isset($_REQUEST['hdv'])){
      $show = false;
      include_once("viewa/phanlichhdvv.php");
    }if(isset($_REQUEST['lichql'])){
      $show = false;
      include_once("viewa/lichql.php");
    }if(isset($_REQUEST['touryeucau'])){
      $show = false;
      include_once("viewa/xemtouryeucau.php");
    }if(isset($_REQUEST['cskh'])){
      $show = false;
      include_once("viewa/phannvcs.php");
    }if(isset($_REQUEST['qltx'])){
      $show = false;
      include_once("viewa/qltaixe.php");
    }if(isset($_REQUEST['qlthuexe'])){
      $show = false;
      include_once("viewa/qlthuexe.php");
    }
    if($show){
      include_once("viewa/thongke.php");
  }
  }elseif($role == 'CSKH'){
    $show=true;
    if(isset($_REQUEST['ttcna'])){
      $show = false;
      include_once("viewa/ttcna.php");
    } if(isset($_REQUEST['qldichvu'])){
      $show = false;
      include_once("viewa/qldondichvu.php");
    }if(isset($_REQUEST['qldichvuks'])){
      $show = false;
      include_once("viewa/qldondichvuks.php");
    }if(isset($_REQUEST['lichcskh'])){
      $show = false;
      include_once("viewa/lichcskh.php");
    }if(isset($_REQUEST['tour'])){
      $show = false;
      include_once("viewa/xemtoura.php");
    }if(isset($_REQUEST['tour1'])){
        $show = false;
        include_once("viewa/xemtoura.php");
      }
    if(isset($_REQUEST['idtour'])){
      $show = false;
      include_once("viewa/xemtourchitiet.php");
    }if(isset($_REQUEST['dattour'])){
      $show = false;
      include_once("viewa/dattour.php");
    }if(isset($_REQUEST['xemdattour'])){
      $show = false;
     
      include_once("viewa/xemdattour.php");
      
    }
    include_once("viewa/mesnv.php");
    if($show){
      include_once("viewa/thongke.php");
  }
  }
  
  elseif($role == 'HDV'){
    $show=true;
    if(isset($_REQUEST['ttcna'])){
      $show = false;
      include_once("viewa/ttcna.php");
    } if(isset($_REQUEST['xemdv'])){
      $show = false;
      include_once("viewa/xemdichvu.php");
    } if(isset($_REQUEST['baocao'])){
      $show = false;
      include_once("viewa/baocao.php");
    }  if(isset($_REQUEST['baonv'])){
      $show = false;
      include_once("viewa/xembaocaonv.php");
    } 
    if($show){
      include_once("viewa/lich.php");
  }
  }


}

?>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
     
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/mainad.js"></script>
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
</body>

</html>