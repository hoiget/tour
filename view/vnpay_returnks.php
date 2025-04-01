


        <!-- Bootstrap core CSS -->
        <!-- Custom styles for this template -->
      
        <style>
  .main{
    background:white;
    color:black;
  }
    .header-clearfix{
        background:white;
    }
.popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #f9f9f9;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    max-width: 400px;
    width: 300px;
    text-align: center;
    z-index: 9999;
}

.popup h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

.popup p {
    color: #666;
    font-size: 16px;
    margin-bottom: 20px;
}

.popup button {
    padding: 8px 20px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}
</style>
      
      <body>
           
<div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2></h2>
        <p></p>
        <button onclick="closePopup()">Ok</button>
</div>
        <?php
        require_once("configks.php");
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        ?>
        <!--Begin display -->
        <div class="container">
            <div class="header-clearfix">
                <h3 class="text-muted">Thông tin giao dịch</h3>
            </div>
            <div class="table-responsive">
            <form id="thanh" action="./api/api.php" method="post">
            <input type="hidden" name="action" value="thanh">
                    <input type="hidden" name="iduser" value="<?php echo $user_id; ?>">
                <div class="form-group">

                    <label >Mã đơn hàng:</label>

                    <label><input style="border:none;"  type="text" name="ma" value="<?php echo $_GET['vnp_TxnRef'] ?>" readonly></label>
                    
                </div>    
                <div class="form-group">

                    <label >Số tiền:</label>
                    <label><input style="border:none;" type="text" name="st" value="<?php echo $_GET['vnp_Amount'] /100 ;?>" readonly></label>
                </div>  
                <div class="form-group">
                    <label >Nội dung thanh toán:</label>
                    <label><input style="border:none;width:800px" type="text" name="nd" value="<?php echo $_GET['vnp_OrderInfo'] ;?> " readonly></label>
                </div> 
                <div class="form-group">
                    <label >Mã phản hồi (vnp_ResponseCode):</label>
                    <label><?php echo $_GET['vnp_ResponseCode']; ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã GD Tại VNPAY:</label>
                    <label><?php echo $_GET['vnp_TransactionNo'] ;?></label>
                </div> 
                <div class="form-group">
                    <label >Mã Ngân hàng:</label>
                    <label><?php echo $_GET['vnp_BankCode'] ;?></label>
                </div> 
                <div class="form-group">
                    <label >Thời gian thanh toán:</label>
                    <label><input style="border:none;" type="text" name="tg" value="<?php echo $_GET['vnp_PayDate']; ?>"></label>
                </div> 
                <div class="form-group">
                    
                    <input type="hidden" name="transactionID" value="<?php echo $_GET['vnp_TransactionNo']; ?>">
                </div>

              <div id="contentus1"></div>
                <div class="form-group">
                    <label >Kết quả:</label>
                    
                    <label>
                        <?php include_once("./api/connect.php") ?>
                        <?php
                       
                        $mysqli = new mysqli("localhost", "root", "", "tour");

                        // Kiểm tra kết nối
                        if ($mysqli->connect_error) {
                            die("Kết nối không thành công: " . $mysqli->connect_error);
                        }
                        
                        // Câu lệnh UPDATE
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                $booking_id = $_GET['vnp_TxnRef'];
                                $status = '2';
                              
                                $booking_id = $_GET['vnp_TxnRef'];
                                $numbersOnly = preg_replace('/\D/', '', $booking_id); // Loại bỏ tất cả ký tự không phải số
                                $firstTwoDigits = substr($numbersOnly, 0, 2);
                      
                                $query = "UPDATE booking_orderks SET Payment_status = ? WHERE Booking_id = ?";
                                $stmt = $mysqli->prepare($query);
                                $stmt->bind_param("ss", $status, $firstTwoDigits);
                                $stmt->execute();
                        
                                echo "<span style='color:blue'>GD thành công</span>";
                             
                            } else {
                                echo "<span style='color:red'>GD không thành công</span>";
                            }
                        } else {
                            echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
                        }
                        ?>
                    </label>
                </div>
       
                </form> 
            </div>
            <p>
                &nbsp;
            </p>
         

        </div>  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </body>


