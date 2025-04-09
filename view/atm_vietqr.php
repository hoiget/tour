<style>
  main {
    background: #f5f5f5;
    padding: 30px 0;
  }

  .choose-text,label {
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

  .qr-card {
    background: #fff;
    border: 2px solid #ccc;
    border-radius: 14px;
    padding: 20px;
    width: 480px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    text-align: center;
    position: relative;
    cursor: pointer;
    transition: all 0.3s;
    filter: blur(3px);
    opacity: 0.5;
  }

  .qr-card.selected {
    filter: none;
    opacity: 1;
    border-color: #007bff;
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.15);
  }

  .qr-card img {
    max-width: 100%;
    border-radius: 8px;
  }

  .qr-title {
    font-weight: bold;
    font-size: 18px;
    margin-top: 12px;
    color: #333;
  }

  .qr-amount {
    font-size: 14px;
    color: #666;
    margin-top: 4px;
  }
</style>

<div class="choose-text">Chọn 1 tài khoản để hiển thị mã QR thanh toán</div>
<div id="xemqr-container"></div>

<div style="text-align:center; margin-top: 30px;">
  <label for="payment-proof">Tải ảnh xác nhận thanh toán:</label><br>
  <input type="file" id="payment-proof" accept="image/*" onchange="uploadPaymentProof()" />
</div>
<div id="upload-status"></div>

<script>
  function xemqr() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour1 = urlParams.get('vietqr');
    $.ajax({
      url: './api/api.php?action=xemthanhtoanvietqr&vietqr=' + idtour1,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (Array.isArray(response) && response.length > 0) {
          const qrAccounts = [
            {
              bank: "Techcombank",
              accNumber: "3564188030005834",
              name: "TUAN A"
            },
            {
              bank: "MBBank",
              accNumber: "VQRQABZDC7962",
              name: "DTDP"
            }
          ];

          let eventHtml = '';

          qrAccounts.forEach(function (account, i) {
            response.forEach(function (event) {
              eventHtml += `
               <div class="qr-card ${i === 1 ? 'selected' : ''}" onclick="selectCard(this)">
                  <img src="https://img.vietqr.io/image/${account.bank}-${account.accNumber}-compact2.jpg?amount=${event.Total_pay}&addInfo=${event.Tour_name}&accountName=${event.Tour_name}" alt="QR code">
                  <div class="qr-title">${event.Tour_name} - ${account.name}</div>
                  <div class="qr-amount">Số tiền: ${parseInt(event.Total_pay).toLocaleString()} VND</div>
                </div>
              `;
            });
          });

          $('#xemqr-container').html(eventHtml);
        } else {
          $('#xemqr-container').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
        }
      },
      error: function (xhr, status, error) {
        console.error('Lỗi khi lấy thông tin:', error);
        $('#xemqr-container').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
      }
    });
  }

  function selectCard(card) {
    $('.qr-card').removeClass('selected');
    $(card).addClass('selected');
  }

  $(document).ready(function () {
    xemqr();
  });
</script>
