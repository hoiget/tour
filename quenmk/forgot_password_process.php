<?php
require './api/connect.php'; // Tải thư viện PHPMailer

require './phpemail/vendor/autoload.php'; // Tải thư viện PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Kiểm tra email có tồn tại không
    $query = $conn->prepare("SELECT id FROM user_credit WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Tạo token và thời hạn
        $token = bin2hex(random_bytes(32)); // Tạo một token ngẫu nhiên
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Hết hạn sau 1 giờ

        // Lưu token vào cơ sở dữ liệu
        $update = $conn->prepare("UPDATE user_credit SET reset_token = ?, token_expiry = ? WHERE Email = ?");
        $update->bind_param("sss", $token, $expiry, $email);
        $update->execute();

        // Tạo đường link
        $resetLink = "http://localhost/tour/quenmk/reset_password.php?token=$token"; // Cập nhật đường dẫn website của bạn

        // Gửi email bằng PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server (ví dụ: Gmail)
            $mail->SMTPAuth = true;
            $mail->Username = 'tranhung87609@gmail.com'; // Địa chỉ email của bạn
            $mail->Password = 'slhn ugzk trnx wdxp'; // Mật khẩu ứng dụng (nếu sử dụng Gmail)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Thông tin người gửi và nhận
            $mail->setFrom('Gowander@gmail.com', 'Gowander');
            $mail->addAddress($email); // Địa chỉ email của người dùng

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'RESSET PASSWORD';
            $mail->Body = "
                <p>Xin chào,</p>
                <p>Bạn đã yêu cầu đặt lại mật khẩu. Vui lòng nhấn vào liên kết bên dưới để đặt lại mật khẩu:</p>
                <a href='$resetLink'>$resetLink</a>
                <p>Liên kết này sẽ hết hạn sau 1 giờ.</p>
            ";

            // Gửi email
            $mail->send();
            echo "<script>openPopup('Email xác nhận đã được gửi.','Vui lòng kiểm tra email của bạn.');</script>";
            echo"
            <script>
            setTimeout(function() {
                            window.location.href = 'http://localhost/tour/dangnhap.php';
            }, 5000);
            </script>
            
           ";
        } catch (Exception $e) {
            echo "Không thể gửi email. Chi tiết lỗi: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>openPopup('Email không tồn tại.','');</script>";
         
     }
}
?>


