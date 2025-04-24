<style>
    .main{
        background:grey;
        color:black;
    }
.container4 {
  max-width: 800px;
  margin: 0 auto;
  font-family: Arial, sans-serif;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background:white;
}

h2, h3 {
  text-align: center;
  color:black;
}

form {
  display: grid;
  gap: 10px;
}

label {
  font-weight: bold;
}

input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%; /* Để input tự căn chỉnh kích thước */
}

button {
  display: inline-block;
  padding: 12px 20px;
  font-size: 16px;
  font-weight: bold;
  color: #fff;
  background-color: black;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin-left: 20px;
}

button:hover {
  background-color: #0056b3;
}

/* Styling cho 2 input nằm chung một dòng */
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr; /* 2 cột bằng nhau */
  gap: 10px; /* Khoảng cách giữa các cột */
}

.form-row label {
  margin-bottom: 5px; /* Căn chỉnh khoảng cách giữa label và input */
}

</style>
<br><br>
<div class="container4">
  <h2>THÔNG TIN ĐẶT KHÁCH SẠN</h2>

<form class="my-form" id="datksfull" action="./api/api.php" method="get"> 
    <input type="hidden" name="action" value="datksfull">
  <div class="user-info">
    <h3>Thông tin người dùng</h3>
    <form>
        <div id="xemtt"></div>
    
  </div>

  <!-- Thông tin tour -->
  <div class="tour-info">
    <h3>Thông tin khách sạn</h3>
   
      <div id="xemks"></div>
    
  </div>

  <!-- Thông tin thành viên tham gia -->
  <div class="pricing-info">
    <h3>Thông tin thành viên tham gia cùng</h3>
   
    <div id="xemkss"></div>
      
   
   
  </div>

  <!-- Nút -->
  <br>
  <center>
    
   
    <button type="submit" id="book-button" onclick="datksfull()">Đặt giữ chỗ</button>
  </center>
  </form>
</div>
<br><br>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
let loginForm = document.querySelector(".my-form"); 
loginForm.addEventListener("submit", (e) => { 
    e.preventDefault(); 
   
});
     function get_user_info() {
    $.ajax({
        url: './api/api.php?action=get_user_info',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                         <div class="form-row">
        <div>
          <label for="fullname">Tên tài khoản:</label>
          <input type="text" id="fullname" name="fullname" value="${event.Name}" readonly>
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="${event.Email}" readonly>
        </div>
      </div>

      <div class="form-row">
       
        <div>
          <label for="phone">Số điện thoại:</label>
          <input type="text" id="phone" name="phone" value="${event.sdt}" readonly>
        </div>
        <div>
          <label for="address">Địa chỉ:</label>
          <input type="text" id="address" name="address" value="${event.Address}">
        </div>
      </div>

     
     
     `;
                });
                $('#xemtt').html(eventHtml);
            } else {
                $('#xemtt').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemtt').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function xemks() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour = urlParams.get('datks'); // Lấy ID từ URL

    $.ajax({
      url: './api/api.php?action=xemks&datks=' + idtour,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
       console.log(response)
        if (Array.isArray(response) && response.length > 0) {
          const event = response[0]; // Lấy phần tử đầu tiên
          const eventHtml = `
        <div class="form-row">
        <div>
          <label for="tour-code">Mã khách sạn:</label>
          <input type="text" id="ks-code" name="ks_id" value="${event.idroom}" readonly>
        </div>
        <div>
          <label for="tour-name">Tên khách sạn:</label>
          <input type="text" id="ks-name" name="ks_name" value="${event.Name}" readonly>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="departure-date">Thời gian vào ở:</label>
          <input type="date" id="ns" name="ns" value="${event.Ngaynhan}" >
        </div>
       <div>
          <label for="departure-date">Thời gian vào kết thúc:</label>
          <input type="date" id="ns1" name="ns1" value="${event.Ngaytra}" >
        </div>
      </div>
      `;
          $('#xemks').html(eventHtml);
        } else {
          $('#xemks').html('Không tìm thấy tour với ID ' + idtour);
        }
      },
      error: function (xhr, status, error) {
        console.error('Lỗi khi lấy tour:', error);
        $('#xemks').html('Đã xảy ra lỗi khi tải thông tin tour.');
      }
    });
  }
  function xemkss() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour = urlParams.get('datks'); // Lấy ID từ URL

    $.ajax({
        url: './api/api.php?action=xemks&datks=' + idtour,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          
            if (Array.isArray(response) && response.length > 0) {
                const event = response[0]; // Lấy phần tử đầu tiên
                let eventHtml = `
                <div class="form-row">
                    <div>
                        <label for="adults">Người lớn:</label>
                        <input type="number" id="adults" name="adults" value="${event.Adult}" min="0" oninput="calculateTotal()">
                    </div>
                    <div>
                        <label for="children">Trẻ em:</label><br>
                        <input type="number" style="width:100%" id="children" name="children" value="${event.Children}" min="0" oninput="calculateTotal()">
                    </div>
                    <div>
                        <label for="babies">Em bé:</label>
                        <input type="number" id="babies" name="babies" value="0" min="0" oninput="calculateTotal()">
                    </div>
                </div>

    
                    <div class="form-row">
                        <div></div>
                        <div>
                         <!-- Giá được hiển thị với dấu phân cách, nhưng input có giá trị là số nguyên thuần -->
            <input type="number" hidden id="price" name="price" value="${event.Price}" readonly>
            <input type="text" hidden  id="price1" name="price1" value="${event.Price}" readonly>
           
            <label for="total-price">Tổng tiền:</label>
            <input type="text" id="total-price" name="total-price" value="0" readonly>
                        </div>
                    </div>
                    
                   
                `;
                $('#xemkss').html(eventHtml);

                // Gọi hàm calculateTotal() để tính toán ban đầu
                calculateTotal();
            } else {
                $('#xemkss').html('Không tìm thấy tour với ID ' + idtour);
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi lấy tour:', error);
            $('#xemkss').html('Đã xảy ra lỗi khi tải thông tin tour.');
        }
    });
}
 
  function datksfull() {
    // Lấy giá trị từ input type="date"
   
    $(document).ready(function() {
        $('#datksfull').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của form
            $.ajax({
                type: 'POST',
                url: './api/api.php',
                data: $(this).serialize(),
                success: function(response) {
                  console.log(response)
                    if (response === 'insert_success') {
                        openPopup('Thông báo', 'Cập nhật thành công!');
                        setTimeout(function() {
                            window.location.href = 'index.php?xemdatks'; // Chuyển hướng sau 2 giây
                        }, 2000);
                    } else if (response === 'missing_data') {
                        openPopup('Thông báo', 'Dữ liệu còn thiếu. Vui lòng kiểm tra lại!');
                    } else if (response === 'query_error') {
                        openPopup('Lỗi', 'Có lỗi xảy ra khi thực hiện truy vấn!');
                    } else if (response === 'insert_error') {
                        openPopup('Lỗi', 'lỗi không insert');
                    }else{
                        openPopup('Lỗi', 'lỗi không thêm được order');
                    }   
                    
                },
                error: function(xhr, status, error) {
                    // In lỗi chi tiết ra console
                    console.error('Lỗi AJAX:', status, error); // In thông tin lỗi
                    console.error('Chi tiết lỗi:', xhr.responseText); // In chi tiết thông báo lỗi từ server
                    openPopup('Lỗi', 'Không thể gửi yêu cầu. Vui lòng thử lại!');
                }
            });
        });
    });
}


$(document).ready(function() {
 
       xemks();
    
       xemkss();
    get_user_info();
       
    });
</script>
<script>
function calculateTotal() {
  const adultPrice = document.getElementById("price").value; // Giá người lớn
  const childRate = 0.4; // Tỷ lệ giá trẻ em (5-11 tuổi)
  const babyPrice = 0; // Em bé miễn phí

  // Lấy số lượng
  const adults = document.getElementById("adults").value || 0;
  const children = document.getElementById("children").value || 0;
  const babies = document.getElementById("babies").value || 0;

  // Tính tiền
  const total =
    adults * adultPrice +
    children * (adultPrice * childRate) +
    babies * babyPrice;

  // Hiển thị tổng tiền (không có dấu chấm)
  document.getElementById("total-price").value = total.toLocaleString('vi-VN').replace(/\./g, '');
}

// Tính tiền ngay khi trang được tải lần đầu
window.onload = calculateTotal;


</script>