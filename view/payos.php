<style>
  main {
    background: #f5f5f5;
    padding: 30px 0;
  }

  .choose-text, label {
    text-align: center;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: bold;
    color:rgb(68, 147, 230);
  }

  #xemqr-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
  }

  .payment-card {
    background: #fff;
    border: 2px solid #ccc;
    border-radius: 14px;
    padding: 20px;
    width: auto;
    height:auto;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    text-align: center;
    position: relative;
    cursor: pointer;
    transition: all 0.3s;
  }

  .payment-card.selected {
    border-color: #007bff;
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.15);
  }

  .payment-card .payment-title {
    font-weight: bold;
    font-size: 18px;
    margin-top: 12px;
    color: #333;
  }

  .payment-card .payment-amount {
    font-size: 14px;
    color: #666;
    margin-top: 4px;
  }

  .payment-card a {
    margin-top: 20px;
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
  }

  .payment-card a:hover {
    background-color: #0056b3;
  }
</style>



<div id="xemqr-container"></div>


<script>

  function xemqr() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour1 = urlParams.get('vietqr');

    if (!idtour1) {
      $('#xemqr-container').html('<div>Không tìm thấy mã đơn hàng.</div>');
      return;
    }

    // Gửi yêu cầu đến API PHP để tạo thanh toán VietQR
    $.ajax({
      url: './api/api.php?action=xemthanhtoanvietqr&vietqr=' + encodeURIComponent(idtour1),
      type: 'GET',
      dataType: 'json',
      success: function (res) {
        console.log(res);

        if (res.code === "00" && res.data) {
          const data = res.data;
          const checkoutUrl = data.checkoutUrl;
          const amount = parseInt(data.amount).toLocaleString();
          const description = data.description || 'Thanh toán';

          $('#xemqr-container').html(`
            <div class="payment-card selected">
              <div class="payment-title">Thanh toán - ${description}</div>
              <div class="payment-amount">Số tiền: ${amount} VND</div>
              <a href="${checkoutUrl}" target="_blank" class="btn btn-primary">Thanh toán ngay</a>
            </div>
          `);
        } else {
          $('#xemqr-container').html('<div>Không thể tạo thanh toán.</div>');
        }
      },
      error: function () {
        $('#xemqr-container').html('<div>Lỗi khi gọi API thanh toán.</div>');
      }
    });
  }

  $(document).ready(function () {
    xemqr();
  });
</script>



