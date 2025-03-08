<?php
header('Content-type: text/html; charset=utf-8');


function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}


$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode1 = 'MOMOBKUN20180529';
$accessKey1 = 'klm05TvNBzhg7h7j';
$secretKey1 = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua MoMo";
$orderId = time() ."";
$returnUrl1 = "http://localhost/tour/index.php?result_atm";
$notifyurl = "http://localhost/php/basic.example/atm/ipn_momo.php";
// Lưu ý: link notifyUrl không phải là dạng localhost
$extraData = "";


if (!empty($_POST)) {
    $partnerCode ='MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    $orderid = $_POST["orderId"] + time()."";
    $orderInfo = $_POST["orderInfo"];
    $amount = $_POST["amount"];
    $ipnUrl = "http://localhost/php/basic.example/atm/ipn_momo.php";
    $redirectUrl = "http://localhost/tour/index.php?result_atm";
    $extraData = $_POST["extraData"];

    $requestId = time() . "";
    $requestType = "payWithATM";
    $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $serectkey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there

    header('Location: ' . $jsonResult['payUrl']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MoMo Sandbox</title>
  
    <!-- CSS -->
    <style>
        body {
            background-color: #f8f8f8;
            font-family: 'Arial', sans-serif;
        }

        .container10 {
            width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .panel-heading {
            background: #d82d8b;
            color: #fff;
            font-weight: bold;
            text-align: center;
            border-radius: 10px 10px 0 0;
            padding: 2px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .col {
            width: 30%;
        }

        .btn-primary {
            background: #d82d8b;
            border: none;
            font-size: 16px;
            font-weight: bold;
            padding: 12px;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #b22474;
        }
    </style>
</head>
<body>
<div class="container10">
    <div class="panel-heading">
        <h3 class="panel-title">Thanh toán MoMo</h3>
    </div>
    <br>
    <div class="panel-body">
    <form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
    action="#">
            
                <!-- Cột 1 -->
              <div id="thanhtoan"></div>
           
            <button type="submit" class="btn-primary">Thanh toán</button>
        </form>
    </div>
</div>
<script>
    function xemthanhtoan() {
        const urlParams6 = new URLSearchParams(window.location.search);
        const id = urlParams6.get('momo');
    


        $.ajax({
            url: './api/api.php?action=thanhtoanmomo&momo=' + id,
            type: 'GET',
           
            success: function(response) {
console.log(response)
                let eventHtml = '';
    
                if (response && response.length > 0) {
                    const event = response[0]; // Lấy phần tử đầu tiên của mảng
                    // ${event.Idht}
                    eventHtml += `
                    <div class="row">
                       <div class="col">
                
                            <div class="form-group">
                                <label>OrderId</label>
                                <input type="text" name="orderId" class="form-control" value="${event.Booking_id}<?php echo $orderId; ?>">
                            </div>
                            <div class="form-group">
                                <label>OrderInfo</label>
                                <input type="text" name="orderInfo" class="form-control" value="Thanh toán ${event.Tour_name}">
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" name="amount" class="form-control" value="${event.Total_pay}">
                            </div>
                       
                </div>

                <!-- Cột 2 -->
                <div class="col">
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input type="text" name="newField1" value="${event.User_name}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="newField2" value="${event.Phone_num}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="newField3" value="${event.Email}" class="form-control">
                    </div>
                </div>

                <!-- Cột 3 -->
                <div class="col">
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" name="newField4" value="${event.Address}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Ngày khởi hành</label>
                        <input type="date" name="newField5" value="${event.Datetime}" class="form-control">
                    </div>
                </div>
                   </div>
                    `;
                } else {
                    eventHtml += '<p>Không tìm thấy dữ liệu.</p>';
                }
    
                $('#thanhtoan').html(eventHtml);
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi lấy sự kiện:', error);
                $('#thannhtoan').html('Đã xảy ra lỗi khi lấy sự kiện.');
            }
        });
    }

    $(document).ready(function() {
        xemthanhtoan();
    });
</script>
</body>
</html>
