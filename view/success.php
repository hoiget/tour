
   <style>
    /* Reset default styles */


/* Centered main box */
.main-box {
  background-color: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 100%;
 
}

/* Title styling */
.payment-title {
  font-size: 24px;
  color: #2ecc71; /* Green color for success */
  margin-bottom: 20px;
}

/* Paragraph styling */
p {
  font-size: 16px;
  color: #333;
  margin-bottom: 20px;
}

/* Link styling for email */
.email-link {
  color: #2980b9;
  text-decoration: none;
  font-weight: bold;
}

.email-link:hover {
  text-decoration: underline;
}

/* Button styling */
#return-page-btn {
  display: inline-block;
  padding: 12px 30px;
  background-color: #3498db;
  color: white;
  font-size: 16px;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

#return-page-btn:hover {
  background-color: #2980b9;
}

/* Mobile responsiveness */
@media (max-width: 600px) {
  .main-box {
    padding: 20px;
  }

  .payment-title {
    font-size: 20px;
  }

  p {
    font-size: 14px;
  }

  #return-page-btn {
    font-size: 14px;
    padding: 10px 20px;
  }
}

   </style>

  <body>
    <div class="main-box">
      <h4 class="payment-title">
        Thanh toán thành công. Cảm ơn bạn đã sử dụng payOS!
      </h4>
      <p>
        Nếu có bất kỳ câu hỏi nào, hãy gửi email tới
        <a href="mailto:support@payos.vn" class="email-link">support@payos.vn</a>
      </p>
      <a href="index.php?xemdattour" id="return-page-btn" class="btn">Trở về trang Tạo Link thanh toán</a>
    </div>
  </body>
  <?php include_once("./api/connect.php") ?>
  <?php
// Lấy orderCode từ phản hồi API
$orderCode = $_GET['orderCode']; // Hoặc lấy từ GET, tùy vào cách nhận dữ liệu
$numbersOnly = preg_replace('/\D/', '', $orderCode); // Loại bỏ tất cả ký tự không phải số
$firstTwoDigits = substr($numbersOnly, 0, 3);
// Kiểm tra nếu payment thành công (mã trạng thái trả về từ API thành công, có thể thay đổi theo cấu trúc trả về)
if ($_GET['status'] == 'SUCCESS') {
    // Kết nối cơ sở dữ liệu
   

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Cập nhật Payment_status thành 2 (thành công) dựa trên orderCode
    $updateQuery = "UPDATE booking_ordertour SET Payment_status = 2 WHERE Booking_id = ?";
    
    if ($stmt = $conn->prepare($updateQuery)) {
        // Gắn giá trị cho câu truy vấn
        $stmt->bind_param("i", $firstTwoDigits);  // "i" cho integer (kiểu của Booking_id)

        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Lỗi cập nhật Payment_status: " . $stmt->error;
        }

        // Đóng statement
        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu truy vấn: " . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
} else {
    echo "Thanh toán không thành công.";
}

  ?>
