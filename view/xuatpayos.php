<?php
   require './phpemail/vendor/autoload.php'; 
                          use PHPMailer\PHPMailer\PHPMailer;
                          use PHPMailer\PHPMailer\Exception;
// Nhận dữ liệu callback từ PayOS
$code = $_POST['code'] ?? null;
$status = $_POST['status'] ?? null;
                            $emailnguoinhan = $_SESSION['Email'];
 $username1 = $_SESSION['Name']; // Lấy tên người dùng từ session

    
        // Tạo email với PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';         // Ví dụ SMTP Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'tranhung87609@gmail.com';   // Email gửi
            $mail->Password = 'slhn ugzk trnx wdxp';    // Mật khẩu app hoặc mật khẩu email
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            // Người gửi và người nhận
            $mail->setFrom('Gowander@gmail.com', 'Công ty Gowander');
            $mail->addAddress($emailnguoinhan, $username1);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = "Hóa đơn thanh toán đơn hàng #$orderCode";
            
            $body = "<h2>Hóa đơn thanh toán</h2>";
            $body .= "<p>Chào <b>$username1</b>,</p>";
            $body .= "<p>Cảm ơn bạn đã thanh toán thành công đơn hàng <b>#$orderCode</b>.</p>";
            $body .= "<p>Trân trọng,<br>Đội ngũ hỗ trợ Công ty Gowander</p>";
            
            $mail->Body = $body;

            // Gửi email
            $mail->send();
           
        } catch (Exception $e) {
            echo "Lỗi gửi email: {$mail->ErrorInfo}";
        }
    

 
 

