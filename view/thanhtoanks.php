

<html>
<head>
<title>Thanh toán online</title>
<style>
    main{
        background:white;
        color:black;
    }
    label{
        color:black;
    }
   
    .header-clearfix{
        background:white;
    }
       table {
            width: 400px;
           
            background-color: #fff;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        table td {
            padding: 10px;
        }

        table tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            display: block;
            width: 100px;
           
            padding: 8px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        #qrcode{
            float: right;
            padding-right:50px;
           
        }
        #fm{
            float: left;
            padding-right:50px;
            
        }
        #inp{float: none;}

</style>
</head>
<body>

 
 <div id="nh" class="tabcontent">
 <?php require_once("config.php"); ?>             
        <div class="container">
            <div class="header-clearfix">
                <h3 class="text-muted">Thanh toán online</h3>
            </div>
           
            <div class="table-responsive">
                <form action="view/vnpay_create_paymentks.php" id="create_form" method="post">       
<table style="margin:auto;width:100%;">
    <tr>
        
        
       
    <td >
    <div class="form-group">
    <h3 style="color:black">Tạo mới đơn hàng</h3>
</div>
                    <div class="form-group">

                        <label for="language">Loại hàng hóa </label>

                        <select name="order_type" id="order_type" class="form-control">
                            
                            <option value="billpayment">Thanh toán hóa đơn</option>
                           
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Thời hạn thanh toán</label>
                        <input class="form-control" id="txtexpire"
                               name="txtexpire" type="text" value="<?php echo $expire; ?>" readonly/>
                    </div>
                    <div id="thanhtoan"></div>
               
               
                    </tr>
</table>
<br><center>
                  
                    <button type="submit" name="redirect" id="redirect" class="btn btn-primary">Thanh toán</button></center>

                </form>
            </div>
            <p>
                &nbsp;
            </p>
            
        </div>  
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function generateRandomString(length) {
        const characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let randomString = '';
        for (let i = 0; i < length; i++) {
            randomString += characters[Math.floor(Math.random() * characters.length)];
        }
        return randomString;
    }
    
    const randomString = generateRandomString(8);
   
    
 function xemthanhtoan() {
        const urlParams6 = new URLSearchParams(window.location.search);
        const id = urlParams6.get('idttks');
    


        $.ajax({
            url: './api/api.php?action=thanhtoanks&idttks=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
console.log(response)
                let eventHtml = '';
    
                if (response && response.length > 0) {
                    const event = response[0]; // Lấy phần tử đầu tiên của mảng
                    // ${event.Idht}
                    eventHtml += `
                     <div class="form-group">
                        <label for="order_id">Mã hóa đơn</label>
                        <input class="form-control"  id="order_id" name="order_id" type="text" value="${event.Booking_id + randomString}" readonly/>
                        
                    </div>
                    <div class="form-group">
                        <label for="amount">Số tiền</label>
                        <input class="form-control" id="amount"
                               name="amount" type="number" value="${event.total_pay}">
                    </div>
                    <div class="form-group">
                        <label for="order_desc">Nội dung thanh toán</label>
                        
                        <input class="form-control" id="order_desc" name="order_desc" type="text" value="${event.room_name}" readonly >
                    </div>
                    <div class="form-group">
                        <label for="bank_code">Ngân hàng</label>
                        <select name="bank_code" id="bank_code" class="form-control">
                            <option value="">Không chọn</option>
                            <option value="NCB"> Ngan hang NCB</option>
                            <option value="AGRIBANK"> Ngan hang Agribank</option>
                            <option value="SCB"> Ngan hang SCB</option>
                            <option value="SACOMBANK">Ngan hang SacomBank</option>
                            <option value="EXIMBANK"> Ngan hang EximBank</option>
                            <option value="MSBANK"> Ngan hang MSBANK</option>
                            <option value="NAMABANK"> Ngan hang NamABank</option>
                            <option value="VNMART"> Vi dien tu VnMart</option>
                            <option value="VIETINBANK">Ngan hang Vietinbank</option>
                            <option value="VIETCOMBANK"> Ngan hang VCB</option>
                            <option value="HDBANK">Ngan hang HDBank</option>
                            <option value="DONGABANK"> Ngan hang Dong A</option>
                            <option value="TPBANK"> Ngân hàng TPBank</option>
                            <option value="OJB"> Ngân hàng OceanBank</option>
                            <option value="BIDV"> Ngân hàng BIDV</option>
                            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                            <option value="VPBANK"> Ngan hang VPBank</option>
                            <option value="MBBANK"> Ngan hang MBBank</option>
                            <option value="ACB"> Ngan hang ACB</option>
                            <option value="OCB"> Ngan hang OCB</option>
                            <option value="IVB"> Ngan hang IVB</option>
                            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="language">Ngôn ngữ</label>
                        <select name="language" id="language" class="form-control">
                            <option value="vn">Tiếng Việt</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                   
                    </td>
                     <td >
                    <div class="form-group">
                        <h3 style="color:black;">Thông tin hóa đơn (Billing)</h3>
                    </div>
                    <div class="form-group">
                        <label >Họ tên (*)</label>
                        <input class="form-control" id="txt_billing_fullname"
                               name="txt_billing_fullname" type="text" value="${event.user_name}"/>             
                    </div>
                    <div class="form-group">
                        <label >Email (*)</label>
                        <input class="form-control" id="txt_billing_email"
                               name="txt_billing_email" type="text" value="${event.Email}"/>   
                    </div>
                    <div class="form-group">
                        <label >Số điện thoại (*)</label>
                        <input class="form-control" id="txt_billing_mobile"
                               name="txt_billing_mobile" type="text" value="${event.phonenum}"/>   
                    </div>
                    <div class="form-group">
                        <label >Địa chỉ (*)</label>
                        <input class="form-control" id="txt_billing_addr1"
                               name="txt_billing_addr1" type="text" value="${event.address}"/>   
                    </div>
                    <div class="form-group">
                        <label >Mã bưu điện (*)</label>
                        <input class="form-control" id="txt_postalcode"
                               name="txt_postalcode" type="text" value="100000"/> 
                    </div>
                    <div class="form-group">
                        <label >Tỉnh/TP (*)</label>
                        <input class="form-control" id="txt_bill_city"
                               name="txt_bill_city" type="text" value="TP Hồ Chí Minh"/> 
                    </div>
                    <div class="form-group">
                        <label ></label>
                        <input class="form-control" id="txt_bill_city"
                               name="txt_bill_city" type="text"/> 
                    </div>
                   
                    </td>
                   
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



