<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<style>
    .main{
        background:grey;
        color:black;
    }
    .container-wrapper {
  display: flex; /* Sử dụng Flexbox */
  gap: 20px; /* Khoảng cách giữa hai phần tử */
  justify-content: center; /* Căn giữa nội dung */
  align-items: flex-start; /* Căn các phần tử theo chiều trên/dưới */
  flex-wrap: wrap; /* Đảm bảo không bị tràn trên màn hình nhỏ */
}

.container4 {
  flex: 1; /* Để container4 mở rộng linh hoạt */
  max-width: 800px; /* Giữ nguyên kích thước của container */
  font-family: Arial, sans-serif;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background:white;
}

#calendar {
  flex: 1; /* Để lịch mở rộng linh hoạt */
  max-width: 800px;
  height: 500px;
  font-family: Arial, sans-serif;
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
#totalchild,#totalad{
  border: none;
  background-color: white;
}

</style>
<br><br>
<div class="container-wrapper">
<div id="calendar"></div>
<div class="container4">
  <h2>THÔNG TIN ĐẶT TOUR</h2>

<form class="my-form" id="dattourfull" action="./api/api.php" method="get"> 
    <input type="hidden" name="action" value="dattourfull">
  <div class="user-info">
    <h3>Thông tin người dùng</h3>
    <form>
        <div id="xemtt"></div>
    
  </div>

  <!-- Thông tin tour -->
  <div class="tour-info">
    <h3>Thông tin tour</h3>
   
      <div id="xemtour"></div>
    
  </div>

  <!-- Thông tin thành viên tham gia -->
  <div class="pricing-info">
    <h3>Thông tin thành viên tham gia cùng</h3>
   
                  
      <div class="form-row">
        <div>
          <label for="adults">Người lớn :</label>
          <input type="number" id="adults" name="adults" value="1" min="0" oninput="calculateTotal()">
          <span id="totalad">0</span> VNĐ
        </div>
        <div>
          <label for="children">Trẻ em (dưới 11 tuổi):</label>
          <input type="number" id="children" name="children" value="0" min="0" oninput="calculateTotal()">
          <span id="totalchild">0</span> VNĐ
        </div>
      </div>

      <div class="form-row">
        
        <div>
          <label for="babies">Em bé (dưới 2 tuổi, miễn phí):</label>
          <input type="number" id="babies" name="babies" value="0" min="0"  oninput="calculateTotal()">
        </div>
        
      </div>

      <div class="form-row">
        <div></div>
        <div>
        
          <label for="total-price">Tổng tiền:</label>
          <div id="xemtour1"></div>
        </div>
      </div>
    
  </div>

  <!-- Nút -->
  <br>
  <center>
  
   
    <button type="submit" id="book-button" onclick="dattourfull()">Đặt giữ chỗ</button>
  </center>
  </form>
</div>

</div>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    let calendarEl = document.getElementById('calendar');

    // Kiểm tra xem FullCalendar có thực sự được load không
    if (typeof FullCalendar === 'undefined') {
        console.error("Lỗi: FullCalendar chưa được load đúng cách!");
        return;
    }

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'vi', // Set ngôn ngữ tiếng Việt
        selectable: true,
        events: async function (fetchInfo, successCallback, failureCallback) {
            try {
              const urlParams = new URLSearchParams(window.location.search);
              const idtour = urlParams.get('dattour'); // Lấy ID từ URL
                let response = await fetch('./api/api.php?action=xemdattour&dattour=' + idtour);
                if (!response.ok) {
                    throw new Error("Lỗi khi tải dữ liệu từ API");
                }
                let data = await response.json();

                let events = data.map(item => ({
                    title: item.Price.toLocaleString() + "₫",
                    start: item.departure_date,
                    color: item.is_available ? '#ff0000' : '#cccccc',
                    textColor: item.is_available ? '#ffffff' : '#666666',
                    extendedProps: {
                        isAvailable: item.is_available
                    }
                }));

                successCallback(events);
            } catch (error) {
                console.error("Lỗi tải dữ liệu:", error);
                failureCallback(error);
            }
        },
        dateClick: function (info) {
            let selectedEvent = calendar.getEvents().find(event => event.startStr === info.dateStr);
            if (selectedEvent && selectedEvent.extendedProps.isAvailable) {
                // Cập nhật giá trị ngày khởi hành vào input
                document.getElementById('ns').value = info.dateStr;
                alert("Bạn đã chọn ngày khởi hành: " + info.dateStr);
            } else {
                alert("Ngày này không khả dụng!");
            }
        }
    });

    calendar.render();
});
</script>
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
function xemdattour() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour = urlParams.get('dattour'); // Lấy ID từ URL

    $.ajax({
      url: './api/api.php?action=xemdattour&dattour=' + idtour,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        
        if (Array.isArray(response) && response.length > 0) {
          const event = response[0]; // Lấy phần tử đầu tiên
          const eventHtml = `
        <div class="form-row">
        <div>
          <label for="tour-code">Mã tour:</label>
          <input type="text" id="tour-code" name="tour_id" value="${event.idtour}" readonly>
        </div>
        <div>
          <label for="tour-name">Tên tour:</label>
          <input type="text" id="tour-name" name="tour_name" value="${event.Name}" readonly>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="departure-date">Thời gian khởi hành:</label>
          <input type="date" id="ns" name="ns" value="${event.Depart}" readonly>
        </div>
        <div>
          <label for="duration">Thời gian diễn ra tour (ngày):</label>
          <input type="text" id="duration" name="duration" value="${event.timetour}" min="1" readonly>
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="arrival">Phương tiện di chuyển:</label>
          <input type="text" id="arrival" name="arrival" value="${event.vehicle}" min="1" readonly>
        </div>
        <div>
          
          <input type="text" hidden id="depart_id" name="depart_id" value="${event.iddeparture || 'không có'}" min="1" readonly>
        </div>
      </div>
      `;
          $('#xemtour').html(eventHtml);
        } else {
          $('#xemtour').html('Không tìm thấy tour với ID ' + idtour);
        }
      },
      error: function (xhr, status, error) {
        console.error('Lỗi khi lấy tour:', error);
        $('#xemtour').html('Đã xảy ra lỗi khi tải thông tin tour.');
      }
    });
  }
  function xemdattour1() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour = urlParams.get('dattour'); // Lấy ID từ URL

    $.ajax({
      url: './api/api.php?action=xemdattour&dattour=' + idtour,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
      
        if (Array.isArray(response) && response.length > 0) {
          const event = response[0]; // Lấy phần tử đầu tiên
          let eventHtml = ``;
          if (parseInt(event.discount)==0) {
            eventHtml +=`
            <input type="text" hidden name="max" id="max" value="${event.Max_participant}">
              <input type="text"  hidden name="order" id="order" value="${event.Order}">
            <input type="number" hidden name="child" id="child" value="${event.Child_price_percen}" min="0">
            <input type="number" hidden id="price" name="price" value="${event.Price}" readonly>
            <input type="text" hidden id="price1" name="price1" value="${event.Price}" readonly>
            <input type="text" id="total-price" name="total-price" value="`+event.Price+`" readonly>
          `;
          }else if(parseInt(event.discount) > 0){
            eventHtml +=`
             <input type="text"  hidden name="max" id="max" value="${event.Max_participant}">
             <input type="text"  hidden name="order" id="order" value="${event.Orders}">
            <input type="number" hidden name="child" id="child" value="${event.Child_price_percen}" min="0">
            <input type="number" hidden id="price" name="price" value="${event.discount}" readonly>
            <input type="text" hidden id="price1" name="price1" value="${event.discount}" readonly>
            <input type="text" id="total-price" name="total-price" value="`+event.discount+`" readonly>
          `;}
          
          
          $('#xemtour1').html(eventHtml);
        } else {
          $('#xemtour1').html('Không tìm thấy tour với ID ' + idtour);
        }
      },
      error: function (xhr, status, error) {
        console.error('Lỗi khi lấy tour:', error);
        $('#xemtour1').html('Đã xảy ra lỗi khi tải thông tin tour.');
      }
    });
  }
  function dattourfull() {
    // Lấy giá trị từ input type="date"
   
    $(document).ready(function() {
        $('#dattourfull').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của form
            $.ajax({
                type: 'POST',
                url: './api/api.php',
                data: $(this).serialize(),
                success: function(response) {
                console.log(response);
                    if (response === 'insert_success') {
                        openPopup('Thông báo', 'Đặt thành công!');
                        setTimeout(function() {
                            window.location.href = 'index.php?xemdattour'; // Chuyển hướng sau 2 giây
                        }, 2000);
                    } else if (response === 'missing_data') {
                        openPopup('Thông báo', 'Dữ liệu còn thiếu. Vui lòng kiểm tra lại!');
                    } else if (response === 'query_error') {
                        openPopup('Lỗi', 'Có lỗi xảy ra khi thực hiện truy vấn!');
                    } else if (response === 'invalid_date') {
                        openPopup('Lỗi', 'Có lỗi về ngày không hợp lệ');
                    }else if (response === 'query_error') {
                        openPopup('Lỗi', 'lỗi truy vấn');
                    }else if (response === 'update_departure_error') {
                        openPopup('Lỗi', 'lỗi không update dược departure');
                    }else if (response === 'insert_detail_error') {
                        openPopup('Lỗi', 'lỗi không thêm dược detail');
                    }else if (response === 'insert_order_error') {
                        openPopup('Lỗi', 'lỗi không thêm được order');
                    }else if (response.startsWith('quaso|')) {
                    let messageParts = response.split('|');
                    openPopup('Cảnh báo',messageParts[1]+'\n');
                } 
                    else{
                      openPopup('Lỗi', 'lỗi');
                    }   
                    
                },
                error: function(xhr, status, error) {
    // In lỗi chi tiết ra console
    console.error('Trạng thái:', status);
    console.error('Thông báo lỗi:', error);
    console.error('Phản hồi từ server:', xhr.responseText);

    // Hiển thị popup lỗi với thông tin từ server
    openPopup('Lỗi', 'Chi tiết lỗi: ' + xhr.responseText);
}

            });
        });
    });
}


$(document).ready(function() {
 
       xemdattour();
       xemdattour1();
        get_user_info();
       
    });
</script>
<script>
function calculateTotal() {
  const priceInput = document.getElementById("price");
    const childInput = document.getElementById("child");

    if (!priceInput || !childInput) {
        console.warn("Giá tour chưa được tải, không thể tính tổng.");
        return;
    }
  const adultPrice = document.getElementById("price").value; // Giá người lớn
  const childRate = document.getElementById("child").value / 100; // Tỷ lệ giá trẻ em (5-11 tuổi)
  const babyPrice = 0; // Em bé miễn phí

  // Lấy số lượng
  const adults = document.getElementById("adults").value || 0;
  const children = document.getElementById("children").value || 0;
  const babies = document.getElementById("babies").value || 0;
  const totalAdult = adults * adultPrice;
  const totalChild = children * (adultPrice * childRate);
  
  // Tính tiền
  const total =
    adults * adultPrice +
    children * (adultPrice * childRate) +
    babies * babyPrice;

  // Hiển thị tổng tiền (không có dấu chấm)
  document.getElementById("total-price").value = total.toLocaleString('vi-VN').replace(/\./g, '');
  document.getElementById("totalad").innerText = totalAdult.toLocaleString('vi-VN');
  document.getElementById("totalchild").innerText = totalChild.toLocaleString('vi-VN');
}

// Tính tiền ngay khi trang được tải lần đầu
window.onload = calculateTotal;


</script>