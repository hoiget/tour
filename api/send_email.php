<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpemail/vendor/autoload.php';

function sendUnlockEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tranhung87609@gmail.com';
        $mail->Password = 'hkxn qvll ssae elhq'; // Kiểm tra lại mật khẩu ứng dụng
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('Gowander@gmail.com', 'Security Team');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = '🔓 Mở khóa tài khoản';
        $mail->Body = "Nhấn vào link để mở khóa tài khoản: <br>
                      <a href='http://localhost/tour/api/api.php?action=unlock&token=$token&email=$email'>Mở khóa tài khoản</a>";

        $mail->send();
        $mail->SMTPDebug = 2;  // Bật debug SMTP
        $mail->Debugoutput = 'html';  // Hiển thị lỗi trong trình duyệt

    } catch (Exception $e) {
        die("Lỗi gửi email: " . $mail->ErrorInfo);
    }
}

?>
