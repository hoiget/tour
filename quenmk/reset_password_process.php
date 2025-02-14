<?php
// Kết nối cơ sở dữ liệu


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = md5($_POST['password']); // Mã hóa mật khẩu mới bằng MD5
    // Kiểm tra token hợp lệ
    $query = $conn->prepare("SELECT id FROM user_credit WHERE reset_token = ? AND token_expiry > NOW()");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Cập nhật mật khẩu mới và xóa token
        $update = $conn->prepare("UPDATE user_credit SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
        $update->bind_param("si", $newPassword, $user['id']);
        $update->execute();

        echo "<script>openPopup('Mật khẩu của bạn đã được thay đổi thành công. Bạn có thể đăng nhập lại.','');</script>";
        echo"
        <script>
        setTimeout(function() {
                        window.location.href = 'http://localhost/tour/dangnhap.php';
        }, 5000);
        </script>";
    } else {
        echo "<script>openPopup('Liên kết không hợp lệ hoặc đã hết hạn.','');</script>";
        echo"
        <script>
        setTimeout(function() {
                        window.location.href = 'http://localhost/tour/dangnhap.php';
        }, 3000);
        </script>";
    }
}
?>
