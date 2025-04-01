<?php
session_start();

// Xóa tất cả các biến phiên làm việc và hủy phiên làm việc
session_unset();
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập

  echo "<script>
    location.href = 'index.php';
    </script>";
 
exit();
?>