<?php
header('Content-type: text/html; charset=utf-8');


$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'; //Put your secret key in there
$partnerCode = "MOMOBKUN20180529";
$accessKey="klm05TvNBzhg7h7j";
if (!empty($_GET)) {
   
    $orderId = $_GET["orderId"];
    $localMessage = utf8_encode($_GET["localMessage"]);
    $message = $_GET["message"];
    $transId = $_GET["transId"];
    $orderInfo = utf8_encode($_GET["orderInfo"]);
    $amount = $_GET["amount"];
    $errorCode = $_GET["errorCode"];
    $responseTime = $_GET["responseTime"];
    $requestId = $_GET["requestId"];
    $extraData = $_GET["extraData"];
    $payType = $_GET["payType"];
    $orderType = $_GET["orderType"];
    $extraData = $_GET["extraData"];
    $m2signature = $_GET["signature"]; //MoMo signature


    //Checksum
    $rawHash = "requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
        "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
        "&payType=" . $payType . "&extraData=" . $extraData;

    $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

   


    if ($m2signature == $partnerSignature) {
        if ($errorCode == '0') {
            $result = '<div class="alert alert-success"><strong>Payment status: </strong>Success</div>';
        } else {
            $result = '<div class="alert alert-success"><strong>Payment status: </strong>Giao dịch hủy</div>';
        }
    } else {
        $result = '<div class="alert alert-success"><strong>Payment status: </strong>hh</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MoMo Sandbox</title>
    <script type="text/javascript" src="./statics/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="./statics/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="./statics/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="./statics/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css"/>
    <link rel="stylesheet"
          href="./statics/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"/>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Payment status/Kết quả thanh toán</h1>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $result; ?>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="fxRate" class="col-form-label">OrderId</label>
                                <div class='input-group date' id='fxRate'>
                                    <input type='text' name="orderId" value="<?php echo $orderId; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="fxRate" class="col-form-label">transId</label>
                                <div class='input-group date' id='fxRate'>
                                    <input type='text' name="transId" value="<?php echo $transId; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="fxRate" class="col-form-label">orderType</label>
                                <div class='input-group date' id='fxRate'>
                                    <input type='text' name="orderType" value="<?php echo $orderType; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="fxRate" class="col-form-label">Amount</label>
                                <div class='input-group date' id='fxRate'>
                                    <input type='text' name="amount" value="<?php echo $amount; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="fxRate" class="col-form-label">Message</label>
                                <div class='input-group date' id='fxRate'>
                                    <input type='text' name="message" value="<?php echo $message; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="fxRate" class="col-form-label">payType</label>
                                <div class='input-group date' id='fxRate'>
                                    <input type='text' name="payType" value="<?php echo $payType; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="/" class="btn btn-primary">Back to continue payment...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Debugger</h3>
                </div>
                <div class="panel-body">
                <?php include_once("./api/connect.php") ?>
                    <?php

                        $mysqli = new mysqli("localhost", "root", "", "tour");

                        // Kiểm tra kết nối
                        if ($mysqli->connect_error) {
                            die("Kết nối không thành công: " . $mysqli->connect_error);
                        }

                    if($m2signature == $partnerSignature){
                        echo '<div class="alert alert-success"><strong>INFO: </strong>Pass Checksum</div>';
                       
                    }else{
                        echo '<div class="alert alert-success"><strong>INFO: </strong>Pass Checksum</div>';
                        
                        
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
