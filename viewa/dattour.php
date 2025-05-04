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
#top{
  flex: 1; /* Để lịch mở rộng linh hoạt */
  font-family: Arial, sans-serif;
  background:white;
}
#calendar {
  
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
.passenger-form {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    font-family: Arial, sans-serif;
}

.passenger-form h4 {
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 5px;
    color:black;
}

.passenger-form h4 img {
    width: 20px;
    height: 20px;
    
}

.passenger-form label {
    font-weight: bold;
    font-size: 14px;
    color: #333;
}

.passenger-form input, .passenger-form select {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.passenger-form input[disabled] {
    background-color: #f1f1f1;
    color: #888;
    border: none;
}
.payment-methods {
  width: 100%;
   padding: 10px;
    font-family: Arial, sans-serif;
}

.payment-option {
    display: flex;
    align-items: center;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    cursor: pointer;
    margin-bottom: 10px;
    transition: 0.3s;
    background-color: #f1eded;
    
}

.payment-option:hover {
    background-color: #f9f9f9;
}

.checkbox {
    width: 20px;
    height: 20px;
    border: 2px solid #ccc;
    border-radius: 4px;
    margin-right: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: bold;
}

.checkbox.checked {
    border-color: #4CAF50;
    background-color: #4CAF50;
    color: white;
}

</style>
<br><br>

<form class="my-form" id="dattourfulll" action="./api/apia.php" method="get">
<input type="hidden" name="action" value="dattourfulll">
<div class="container-wrapper">
<div id="top">
<h1 id="ns1" style="color:red;font-family: Arial, sans-serif;
  background:white; text-align: right;"></h1>
<div id="calendar">

</div>
<h2>Thông tin khách hàng</h2>

<div id="adult-forms"></div>
<div id="children-forms"></div>
<div id="babies-forms"></div>
<br>

<h2>Phương thức thanh toán</h2>
<div class="payment-methods">
    <div class="payment-option" data-method="cash" onclick="selectPayment(this)">
        <div class="checkbox"></div>
        <img style="padding-right:10px" src="./assets/img/cash.jpg" width=50px height=30px alt="">
        <span>Thanh toán tiền mặt</span>
    </div>
    <div class="payment-option" data-method="vnpay" onclick="selectPayment(this)">
        <div class="checkbox"></div>
        <img style="padding-right:10px" src="./assets/img/VNPAY.png" width=50px height=30px alt="">
        <span>Thanh toán VNPAY</span>
       
    </div>
  
</div>



    <script>let selectedMethod = "";

function selectPayment(selectedOption) {
    document.querySelectorAll(".checkbox").forEach(box => {
        box.classList.remove("checked");
        box.innerHTML = "";
    });

    let checkbox = selectedOption.querySelector(".checkbox");
    checkbox.classList.add("checked");
    checkbox.innerHTML = "✔";

    // Lưu phương thức thanh toán được chọn
    selectedMethod = selectedOption.getAttribute("data-method");
}</script>
</div>

<div class="container4">
  <h2>THÔNG TIN ĐẶT TOUR</h2>

   
  <div class="user-info">
    <h3>Thông tin người dùng</h3>
    <form>
    <div class="form-row">
        <div>
          <label for="fullname">Tên tài khoản:</label>
          <input type="text" id="fullname" name="fullname" value="" >
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="" >
        </div>
      </div>

      <div class="form-row">
       
        <div>
          <label for="phone">Số điện thoại:</label>
          <input type="text" id="phone" name="phone" value="" >
        </div>
        <div>
          <label for="address">Địa chỉ:</label>
          <input type="text" id="address" name="address" value="" >
        </div>
      </div>

      
    
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
          <input type="number" id="adults" name="adults" value="1" min="0" oninput="calculateTotal();generateForms();" >
          <span id="totalad">0</span> VNĐ
        </div>
        <div>
          <label for="children">Trẻ em (dưới 11 tuổi):</label>
          <input type="number" id="children" name="children" value="0" min="0" oninput="calculateTotal();generateForms();">
          <span id="totalchild">0</span> VNĐ
        </div>
      </div>

      <div class="form-row">
        
        <div>
          <label for="babies">Em bé (dưới 2 tuổi, miễn phí):</label>
          <input type="number" id="babies" name="babies" value="0" min="0"  oninput="calculateTotal();generateForms();">
        </div>
        
      </div>

      <div class="form-row">
        <div></div>
        <div>
        <input type="hidden" id="single-room" name="tienks" value="1000000"> <!-- Giá phòng đơn -->
        <p>Tổng phòng đơn: <span id="totalsingle">0</span> VND</p>

          <label for="total-price">Tổng tiền:</label>
          <div id="xemtour1"></div>
        </div>
      </div>
    
  </div>

  <!-- Nút -->
  <br>
  <center>
  
   
    <button type="submit" id="book-button" onclick="dattourfulll()">Đặt giữ chỗ</button>
  </center>
 
</div>

</div>
</form>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    let calendarEl = document.getElementById('calendar');

    if (typeof FullCalendar === 'undefined') {
        console.error("Lỗi: FullCalendar chưa được load đúng cách!");
        return;
    }

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'vi',
        selectable: true,
        buttonText: {
        today: 'HÔM NAY'  // ← Đổi chữ tại đây
    },
    datesSet: function(arg) {
    const titleEl = document.querySelector('.fc-toolbar-title');
    if (titleEl) {
        // Dùng currentStart là ngày 1 của tháng đang xem
        const currentDate = new Date(arg.view.currentStart);
        const displayedMonth = currentDate.getMonth(); // 0-11
        const year = currentDate.getFullYear();

        const customMonthNames = [
            "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
        ];

        titleEl.textContent = `${customMonthNames[displayedMonth]} năm ${year}`;
    }
}

,

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
                    title: item.Price.toLocaleString('vi-VN') + "₫", // Định dạng tiền tệ
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
    let selectedDate = new Date(info.dateStr);
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Đặt giờ về 00:00 để chỉ so sánh ngày

    // Tạo ngày giới hạn (ngày hiện tại + 2)
    let limitDate = new Date(today);
    limitDate.setDate(today.getDate() + 2);

    if (selectedDate < limitDate) { // Không cho chọn trước ngày khởi hành 2 ngày
        openPopup("Bạn không thể chọn ngày khởi hành này!", '');
        return;
    }

    let selectedEvent = calendar.getEvents().find(event => event.startStr === info.dateStr);
    if (selectedEvent && selectedEvent.extendedProps.isAvailable) {
        document.getElementById('ns').value = info.dateStr;

        const dateStr = info.dateStr; 
        const [year, month, day] = dateStr.split("-");
        const formattedDate = `${day}/${month}/${year}`;
        document.getElementById('ns1').innerText = formattedDate;

        openPopup("Bạn đã chọn ngày khởi hành: " + formattedDate, '');
    } else {
        openPopup("Ngày này không khả dụng!", '');
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
          <input type="date" id="ns" name="ns"  readonly>
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
          <label for="arrival">Tên khách sạn:</label>
          <input type="text" id="ks" name="ks" value="${event.roomname}" min="1" readonly>
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
  
  
  function dattourfulll() {
    // Lấy giá trị từ input type="date"
    if (!selectedMethod) {
        alert("Vui lòng chọn phương thức thanh toán!");
        return;
    }

  

    
    $(document).ready(function () {
    $('#dattourfulll').submit(function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của form

        let formData = new FormData(this); // Chuyển form thành FormData

        // Thêm dữ liệu hành khách từ form động
        $(".passenger-form").each(function (index) {
            formData.append("hot[]", $(this).find("input[name^='hot']").val());
            formData.append("ngaysi[]", $(this).find("input[name^='ngaysi']").val());
            
            formData.append("gioit[]", $(this).find("select[name^='gioit']").val());
            formData.append("phanloai[]", $(this).find("input[name^='phanloai']").val());
            formData.append("method", selectedMethod);
        });

        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: formData,
            contentType: false, // Bắt buộc để FormData hoạt động đúng
            processData: false, // Không xử lý dữ liệu FormData thành chuỗi
            success: function (response) {
                console.log(response);
                if (response === 'insert_success') {
                    openPopup('Thông báo', 'Đặt thành công!');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?qldichvu';
                    }, 2000);
                } else if (response === 'missing_data') {
                    openPopup('Thông báo', 'Dữ liệu còn thiếu. Vui lòng kiểm tra lại!');
                }else if (response === 'missing_data1') {
                    openPopup('Thông báo', 'Vui lòng chọn ngày khởi hành');
                }
                 else if (response.startsWith('quaso|')) {
                    let messageParts = response.split('|');
                    openPopup('Cảnh báo', messageParts[1] + '\n');
                } else {
                    openPopup('Lỗi', 'Lỗi không xác định');
                }
            },
            error: function (xhr, status, error) {
                console.error('Lỗi:', error);
                console.error('Phản hồi từ server:', xhr.responseText);
                openPopup('Lỗi', 'Chi tiết lỗi: ' + xhr.responseText);
            }
        });
    });
});

}


$(document).ready(function() {
 
       xemdattour();
       xemdattour1();
     
       
    });
</script>
<script>

function calculateTotal() {
    const maxParticipants = parseInt(document.getElementById("max").value) || 0;
    const currentOrder = parseInt(document.getElementById("order").value) || 0;

    // Lấy số lượng
    const adults = parseInt(document.getElementById("adults").value) || 0;
    const children = parseInt(document.getElementById("children").value) || 0;
    const babies = parseInt(document.getElementById("babies").value) || 0;

    const totalPeople = adults + children + babies;
    const remainingSlots = maxParticipants - currentOrder;

    if (totalPeople > remainingSlots) {
      openPopup("Số lượng khách vượt quá số chỗ còn lại!","Số lượng người còn lại là " + remainingSlots);
        // Điều chỉnh số lượng sao cho không vượt quá
        if (adults > 0) {
            document.getElementById("adults").value = Math.max(0, adults - (totalPeople - remainingSlots));
        } else if (children > 0) {
            document.getElementById("children").value = Math.max(0, children - (totalPeople - remainingSlots));
        } else if (babies > 0) {
            document.getElementById("babies").value = Math.max(0, babies - (totalPeople - remainingSlots));
        }
        return;
    }

    // Kiểm tra xem các input giá có tồn tại không
    const priceInput = document.getElementById("price");
    const childInput = document.getElementById("child");
    const singleRoomInput = document.getElementById("single-room"); // Giá phòng đơn

    if (!priceInput || !childInput) {
        console.warn("Giá tour chưa được tải, không thể tính tổng.");
        return;
    }

    const adultPrice = parseInt(priceInput.value) || 0; // Giá người lớn
    const childRate = parseFloat(childInput.value) / 100 || 0; // Tỷ lệ giá trẻ em (5-11 tuổi)
    const babyPrice = 0; // Em bé miễn phí
    const singleRoomPrice = parseInt(singleRoomInput.value) || 0;

// Đếm số người chọn phòng đơn
    const singleRoomCheckboxes = document.querySelectorAll('input[name="phongdon"]:checked');
    const singleRoomCount = singleRoomCheckboxes.length;
    const totalSingleRoom = singleRoomCount * singleRoomPrice;

    // Tính tổng giá trị
    const totalAdult = adults * adultPrice;
    const totalChild = children * (adultPrice * childRate);
   
    const total = totalAdult + totalChild + (babies * babyPrice) + totalSingleRoom;
    // Hiển thị tổng tiền (bỏ dấu chấm nếu có)
    document.getElementById("total-price").value = total.toLocaleString('vi-VN').replace(/\./g, '');
    document.getElementById("totalad").innerText = totalAdult.toLocaleString('vi-VN');
    document.getElementById("totalchild").innerText = totalChild.toLocaleString('vi-VN');
    document.getElementById("totalsingle").innerText = totalSingleRoom.toLocaleString('vi-VN');
}


// Tính tiền ngay khi trang được tải lần đầu
window.onload = calculateTotal;

function generateForms() {
    const adultCount = parseInt(document.getElementById("adults").value) || 0;
    const childCount = parseInt(document.getElementById("children").value) || 0;
    const babyCount = parseInt(document.getElementById("babies").value) || 0;

    // Lưu dữ liệu hiện có
    const existingData = saveExistingData();

    createForm("adult-forms", "Người lớn", adultCount, "adult", existingData.adults);
    createForm("children-forms", "Trẻ em (từ 2 -> 11 tuổi)", childCount, "child", existingData.children);
    createForm("babies-forms", "Em bé (từ 2 -> 4 tuổi)", babyCount, "baby", existingData.babies);
}

function saveExistingData() {
    const data = {
        adults: getFormData("adult-forms"),
        children: getFormData("children-forms"),
        babies: getFormData("babies-forms"),
    };
    return data;
}

function getFormData(containerId) {
    const container = document.getElementById(containerId);
    const forms = container.getElementsByClassName("passenger-form");
    let data = [];

    for (let form of forms) {
        const hoten = form.querySelector('input[name="hot"]').value;
        const ngaysinh = form.querySelector('input[name="ngaysi"]').value;
        const gioitinh = form.querySelector('select[name="gioit"]').value;
        const phongdon = form.querySelector('input[name="phongdon"]')?.checked || false; // Kiểm tra nếu có checkbox phòng đơn

        data.push({ hoten, ngaysinh, gioitinh, phongdon });
    }
    return data;
}
function createForm(containerId, label, count, type, existingData = []) {
    const container = document.getElementById(containerId);
    container.innerHTML = "";
 
    for (let i = 0; i < count; i++) {
        const data = existingData[i] || { hoten: "", ngaysinh: "", gioitinh: "Nam", phongdon: false };

        const formHtml = `
            <div class="passenger-form">
                <h4>${label}</h4>
                <label>Họ tên:</label>
                <input type="text" name="hot" value="${data.hoten}" required>

                <label>Ngày sinh:</label>
                <input type="date" name="ngaysi" value="${data.ngaysinh}" required onchange="validateDOB(this)">
                
                <label>Giới tính:</label>
                <select name="gioit">
                    <option value="Nam" ${data.gioitinh === "Nam" ? "selected" : ""}>Nam</option>
                    <option value="Nữ" ${data.gioitinh === "Nữ" ? "selected" : ""}>Nữ</option>
                </select>
                
                <input type="hidden" name="phanloai" value="${label}" required>

                ${type === "adult" ? `
                <label>Phòng đơn:</label>
                <input type="checkbox" name="phongdon" value="1" onchange="calculateTotal()" ${data.phongdon ? "checked" : ""}>
                ` : ""}
            </div>
        `;
        container.innerHTML += formHtml;
    }
}


function validateDOB(input) {
    const selectedDate = new Date(input.value);
    const currentDate = new Date();
    const age = currentDate.getFullYear() - selectedDate.getFullYear();
    
    if (selectedDate > currentDate) {
        openPopup("Ngày sinh không hợp lệ! Vui lòng chọn năm nhỏ hơn năm hiện tại.","");
        input.value = ""; // Xóa giá trị không hợp lệ
        return;
    }

    const formType = input.closest(".passenger-form").querySelector('input[name="phanloai"]').value;

    if (formType.includes("Người lớn") && age < 12) {
        openPopup("Người lớn phải từ 12 tuổi trở lên!","Vui lòng nhập đúng độ tuổi.");
        input.value = "";
    } else if (formType.includes("Trẻ em") && (age < 2 || age > 11)) {
        openPopup("Trẻ em phải từ 2 đến 11 tuổi!","Vui lòng nhập đúng độ tuổi.");
        input.value = "";
    } else if (formType.includes("Em bé") && age >= 2) {
        openPopup("Em bé phải dưới 2 tuổi!","Vui lòng nhập đúng độ tuổi.");
        input.value = "";
    }
}

// Gọi hàm lần đầu để tạo form mặc định
generateForms();

</script>
