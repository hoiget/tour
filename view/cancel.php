
   <style>

/* Full page background */


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
  color: #e74c3c;
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
      <h4 class="payment-title">Thanh toán thất bại</h4>
      <p>
        Nếu có bất kỳ câu hỏi nào, hãy gửi email tới
        <a href="mailto:support@payos.vn" class="email-link">support@payos.vn</a>
      </p>
      <a href="index.php?xemdattour" id="return-page-btn" class="btn">Trở về trang Tạo Link thanh toán</a>
    </div>
  </body>


