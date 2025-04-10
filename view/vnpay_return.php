


        <!-- Bootstrap core CSS -->
        <!-- Custom styles for this template -->
      
        <style>

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f2f2f2;
        margin: 0;
        padding: 0;
    }

    .main {
        background: white;
        color: black;
        padding: 20px;
        border-radius: 10px;
        max-width: 1000px;
        margin: 40px auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .header-clearfix {
        background: white;
        padding: 20px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .header-clearfix h3 {
        margin: 0;
        font-size: 28px;
        color: #007bff;
    }

    .form-group {
        margin-bottom: 20px;
        padding: 0 10px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        background-color: #f9f9f9;
    }

    .form-group input[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    .form-group span {
        font-weight: bold;
        font-size: 18px;
    }

    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #ffffff;
        padding: 25px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        max-width: 420px;
        width: 90%;
        text-align: center;
        z-index: 9999;
        animation: fadeIn 0.4s ease-in-out;
    }

    .popup h2 {
        color: #333;
        font-size: 24px;
        margin-bottom: 12px;
    }

    .popup p {
        color: #555;
        font-size: 16px;
        margin-bottom: 24px;
    }

    .popup button {
        padding: 10px 25px;
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
    }

    .popup button:hover {
        background: #218838;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 9998;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translate(-50%, -60%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
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
        require_once("config.php");
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
                    <label><input style="border:none;" type="text" name="nd" value="<?php echo $_GET['vnp_OrderInfo'] ;?> " readonly></label>
                </div> 
                <div class="form-group">
                    <label >Mã phản hồi (vnp_ResponseCode):</label>
                    <label style="background-color: #e9ecef;height:40px;padding: 8px 12px;"><?php echo $_GET['vnp_ResponseCode']; ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã GD Tại VNPAY:</label>
                    <label style="background-color: #e9ecef;height:40px;padding: 8px 12px;"><?php echo $_GET['vnp_TransactionNo'] ;?></label>
                </div> 
                <div class="form-group">
                    <label >Mã Ngân hàng:</label>
                    <label style="background-color: #e9ecef;height:40px;padding: 8px 12px;"><?php echo $_GET['vnp_BankCode'] ;?></label>
                </div> 
                <div class="form-group">
                    <label >Thời gian thanh toán:</label>
                    <label><input style="border:none;" type="text" name="tg" value="<?php echo $_GET['vnp_PayDate']; ?>" readonly></label>
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
                                $sotien= $_GET['vnp_Amount'] /100 ;

                                $status = '2';
                           
                                $booking_id = $_GET['vnp_TxnRef'];
                                $numbersOnly = preg_replace('/\D/', '', $booking_id); // Loại bỏ tất cả ký tự không phải số
                                $firstTwoDigits = substr($numbersOnly, 0, 3);
                        
                                $query = "UPDATE booking_ordertour SET Payment_status = ? WHERE Booking_id = ?";
                                $stmt = $mysqli->prepare($query);
                                $stmt->bind_param("ss", $status, $firstTwoDigits);
                                $stmt->execute();
                                $Diem= ($sotien * 0.05) / 100;
                                $query = "UPDATE tichdiem SET diem = ? WHERE  idkh = ?";
                                $stmt = $mysqli->prepare($query);
                                $stmt->bind_param("ii", $Diem,$user_id);
                                $stmt->execute();
                        
                                echo "<span style='color:blue'>GD thành công</span>";
                                $tourName = $_GET['vnp_OrderInfo'];

                                $textToRead = "Giao dịch thành công với số tiền " . number_format($sotien, 0, ',', '.') . " đồng của tour " . $tourName;
                                echo "<script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const text = " . json_encode($textToRead) . ";
                                    document.getElementById('popup').style.display = 'block';
                                    document.getElementById('overlay').style.display = 'block';
                                    document.querySelector('.popup h2').innerText = 'Thông báo';
                                    document.querySelector('.popup p').innerText = text;
                        
                                    document.querySelector('.popup button').addEventListener('click', function () {
                                        document.getElementById('popup').style.display = 'none';
                                        document.getElementById('overlay').style.display = 'none';
                        
                                        const msg = new SpeechSynthesisUtterance(text);
                                        msg.lang = 'vi-VN';
                                        speechSynthesis.speak(msg);
                                    });
                                });
                            </script>";
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
<?php

?>



    </body>


