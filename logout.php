<?php
session_start();
require './api/connect.php';
require './log/log_helper.php';

if (isset($_SESSION['id'])) {
  $user_id = $_SESSION['id'];

  // Nếu tồn tại session Permissions → là nhân viên
  if (isset($_SESSION['Permissions'])) {
      log_action($conn, $user_id, 'logout', 'Nhân viên đăng xuất khỏi hệ thống', 'employees');
  } else {
      log_action($conn, $user_id, 'logout', 'Khách hàng đăng xuất khỏi hệ thống', 'user');
  }
}


session_unset();
session_destroy();

echo "<script>location.href = 'index.php';</script>";
exit();
