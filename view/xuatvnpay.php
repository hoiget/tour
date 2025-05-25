<?php

     require './phpemail/vendor/autoload.php'; 
                          use PHPMailer\PHPMailer\PHPMailer;
                          use PHPMailer\PHPMailer\Exception;
                            $thoigian = date('d/m/Y H:i:s');
                            $emailnguoinhan = $_SESSION['Email'];
                            $mail = new PHPMailer(true);
                            try {
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // hoặc SMTP server của bạn
                                $mail->SMTPAuth = true;
                                $mail->Username = 'tranhung87609@gmail.com'; // email gửi
                                $mail->Password = 'slhn ugzk trnx wdxp';   // mật khẩu ứng dụng (App Password, không phải mật khẩu Gmail)
                                $mail->SMTPSecure = 'tls'; // hoặc 'ssl'
                                $mail->Port = 587; // hoặc 465 nếu dùng ssl
                                $mail->CharSet = 'UTF-8';
                                $mail->Encoding = 'base64';
                                $mail->setFrom('Gowander@gmail.com', 'Thông báo thanh toán');
                                $mail->addAddress($emailnguoinhan); // Địa chỉ email người nhận

                                $mail->isHTML(true);
                                $mail->Subject = 'Xác nhận thanh toán thành công';
                                $mail->Body    = "
                                    <h3>Chào quý khách,</h3>
                                    <p>Chúng tôi xác nhận giao dịch thanh toán tour đã thành công:</p>
                                    <ul>
                                        <li><strong>Tên tour:</strong> $tourName</li>
                                        <li><strong>Số tiền:</strong> " . number_format($sotien, 0, ',', '.') . " VND</li>
                                        <li><strong>Mã đơn hàng:</strong> $booking_id</li>
                                        <li><strong>Thời gian thanh toán:</strong> $thoigian</li>
                                    </ul>
                                    <p>Cảm ơn quý khách đã sử dụng dịch vụ.</p>
                                ";

                                $mail->send();
                                echo "<p>Email xác nhận đã được gửi.</p>";
                            } catch (Exception $e) {
                                echo "<p>Không gửi được email. Lỗi: {$mail->ErrorInfo}</p>";
                            }

?>