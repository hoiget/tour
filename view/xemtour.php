
<style>


.container2 {
    width: 100%;
    margin: auto;
    padding: 20px;
    background:white;
    color:black;
    
}

.menu-tabs {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
    
}

.menu-tabs button {
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    border-radius: 5px;
}

.menu-tabs button:hover {
    background-color: #0056b3;
}

.search-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.search-input,
.date-input,
.budget-select,.month-select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-input {
    flex: 1 1 250px;
}

.date-input,
.budget-select {
    flex: 1 1 150px;
}

.search-button {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    flex: 0 0 auto;
}

.search-button:hover {
    background-color: #0056b3;
}
.container-layout {
    display: flex;
    width: 100%;
    gap: 20px; /* Khoảng cách giữa hai phần */
}

.sidebar {
    flex: 0 0 20%; /* Sidebar chiếm 30% */
    max-width: 20%; /* Đảm bảo tối đa 30% */
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    
    height: auto;
   
}
.timm{
    background-color: #007bff;
    height: 150px;
    padding-left:10px;
    padding-top:10px;
   
}
#xemtour {
    flex: 0 0 80%; /* Phần nội dung chiếm 70% */
    max-width: 80%; /* Đảm bảo tối đa 70% */
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    background-color: white;
   
}

.tour-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Luôn 3 cột */
   
    gap: 15px;
}

.tour-card {
    position: relative; /* Bắt buộc để absolute hoạt động đúng */
  display: inline-block;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
}


.tour-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.tour-card p {
    padding: 10px;
    font-family: Arial, sans-serif;
    font-size: 16px;
    color: #333;
}
.tour-card h4 {
    padding: 0px 0px 0px 10px;
    color: #333;
}
a{
    text-decoration:none;
    color:black;
}
.departure-box {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 5px;
    margin-left: 10px;
}

.departure-date {
    background-color: #f8f9fa; /* Màu nền nhẹ */
    border: 1px solid #ddd; /* Viền nhẹ */
    padding: 5px 10px;
    border-radius: 5px; /* Bo góc */
    font-size: 14px;
    font-weight: bold;
    color: #333;
    text-align: center;
}
.past-date {
    text-decoration: line-through;
    color: gray;
}
@media (max-width: 768px) {
  

    .tour-card p,strong {
        font-size: 14px;
    }

    .tour-card h4 {
        font-size: 16px;
    }

    .tour-card img {
        height: 120px;
    }
    .departure-box span{
        font-size: 12px;
        
    }
    .add-to-compare{
       font-size: 10px;

    }
    .sosanhbt{
       font-size: 10px;

    }
    .sidebar h5{
        font-size:14px;
        
    }
    .sidebar input,label{
        font-size:10px;
        
    }
    .sidebar{
        height: 300px;
        
    }
    .menu-tabs button {
        padding: 5px 10px;
        font-size: 10px;
    }
    .timm{
   
    height: 100%;
   
   
}
}

@media (max-width: 600px) {


    .tour-card p,strong {
        font-size: 12px;
    }
 span,del {
        font-size: 12px;
    }
    .tour-card h4 {
        font-size: 14px;
    }

    .tour-card img {
        height: 100px;
    }
    .departure-box span{
        font-size: 12px;
    }
    .add-to-compare{
       font-size: 10px;

    }
    .sosanhbt{
       font-size: 10px;

    }
    .sidebar h5{
        font-size:14px;
        
    }
    .sidebar input,label{
        font-size:10px;
        
    }
    .sidebar{
        height: 300px;
        
    }
    .menu-tabs button {
        padding: 5px 10px;
        font-size: 10px;
    }
    .timm{
   
   height: 100%;
  
  
}
    
}
.compare-container {
    display: flex;
    gap: 20px;
    overflow-x: auto;
}
.tour-box {
    flex: 0 0 300px;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 10px;
    background: #fff;
}
.sosach{
    margin-top:100px;
   background-color:white;
}

/* Nút chung */
button {
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

/* Nút so sánh */
button.compare-btn {
    background-color: #007bff;
    color: white;
}

button.compare-btn:hover {
    background-color: #0056b3;
}

/* Nút xóa */
button.clear-btn {
    background-color: #dc3545;
    color: white;
}

button.clear-btn:hover {
    background-color: #b02a37;
}

/* Nút đóng */
button.close-modal-btn {
    background-color: #6c757d;
    color: white;
}

button.close-modal-btn:hover {
    background-color: #5a6268;
}

/* Nút so sánh trên từng tour */
button.add-to-compare {
    background-color: #28a745;
    color: white;
    margin-top: 10px;
    padding: 8px 14px;
    border-radius: 6px;
}

button.add-to-compare:hover {
    background-color: #218838;
}
.wishlist-btn{
    position: absolute;
  top: 10px; /* Cách đáy 10px */
  left: 10px;  /* Cách phải 10px */
  padding: 8px 16px;
  background-color: rgba(0, 0, 0, 0.6);
  cursor: pointer;``
}
</style>


    <div class="container2">
        <!-- Menu Tabs -->
        <div class="menu-tabs">
    <button data-filter="caocap">Tour cao cấp</button>
    <button data-filter="tieuchuan">Tour tiêu chuẩn</button>
    <button data-filter="tietkiem">Tour tiết kiệm</button>
    <button data-filter="khuyenmai">Tour khuyến mãi</button>
</div>



<form action="" method="get">
        <!-- Search Bar -->
        <div class="search-bar">
    <input type="text" placeholder="Bạn muốn đi đâu?" class="search-input" id="main-search">
    <input type="date" class="date-input hidden-on-mobile" id="date-input" placeholder="Ngày khởi hành">
    <select class="month-select hidden-on-mobile" id="month-select">
    <option value="">Tháng</option>
    <option value="1">Tháng 1</option>
    <option value="2">Tháng 2</option>
    <option value="3">Tháng 3</option>
    <option value="4">Tháng 4</option>
    <option value="5">Tháng 5</option>
    <option value="6">Tháng 6</option>
    <option value="7">Tháng 7</option>
    <option value="8">Tháng 8</option>
    <option value="9">Tháng 9</option>
    <option value="10">Tháng 10</option>
    <option value="11">Tháng 11</option>
    <option value="12">Tháng 12</option>
</select>

    <select class="budget-select hidden-on-mobile">
        <option value="">Ngân sách</option>
        <option value="low">Dưới 5 triệu</option>
        <option value="medium">5 - 10 triệu</option>
        <option value="high">Trên 10 triệu</option>
    </select>
    <button class="search-button hidden-on-mobile" style="background-color: white; border: 1px solid grey">🔍</button>
</div>
</form>
<script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date-input').setAttribute('min', today);

    const monthSelect = document.getElementById('month-select');
    const currentMonth = new Date().getMonth() + 1; // Tháng hiện tại

    for (let i = 1; i < currentMonth; i++) {
        let option = monthSelect.querySelector(`option[value="${i}"]`);
        if (option) option.disabled = true;
    }


</script>
      
            
        <div class="container-layout">
    <!-- Sidebar -->
<div class="sidebar">
    <div class="timm" style="background-color: white; border: 1px solid grey; border-radius: 5px;">
    <h5 style="color: black;">Loại tour bạn muốn đi?</h5>
    <div>
        <input type="radio" id="family" name="type" value="Gia đình">
        <label for="family">Gia đình</label>
    </div>
    <div>
        <input type="radio" id="group" name="type" value="Theo đoàn">
        <label for="group">Theo đoàn</label>
    </div>
    <div>
        <input type="radio" id="small-group" name="type" value="Theo nhóm nhỏ">
        <label for="small-group">Theo nhóm nhỏ</label>
    </div>
    </div>
    
    
    <div class="sosach">
    <h5 style="color:black">So sánh tour</h5>
    <button class="sosanhbt" onclick="showCompareModal()">🧮 So sánh tour</button> <br><br>
    <button class="sosanhbt" onclick="clearCompare()">🗑️ Xóa danh sách so sánh</button>
    </div>
</div>


    <!-- Content Section -->
     <?php
     if(isset($_REQUEST['tour'])){
?>
     
    <div id="xemtour">
        <!-- Nội dung tour sẽ được thêm vào đây -->
    </div>
    <?php
    }elseif(isset($_REQUEST['tour1'])){
      ?>
       <div id="xemtour">
        <!-- Nội dung tour sẽ được thêm vào đây -->
    </div>
      <?php  
    }   ?>
</div>

       
           
       
        

        <!-- Tour Cards -->
        
           
           
        
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
   

    // Bấm ❤️
    document.addEventListener("click", function (e) {
        if (!e.target.classList.contains("wishlist-btn")) return;
        const btn = e.target;
        const item_id = btn.dataset.id;
        const type = btn.dataset.type;

        fetch("./api/wishlist.php?action=toggle", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `item_id=${item_id}&type=${type}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "added") {
                btn.textContent = "❤️";
            } else if (data.status === "removed") {
                btn.textContent = "🤍";
            } else {
                alert(data.message || "Lỗi xảy ra");
            }
        });
    });
});
function checkWishlist() {
    const userLoggedIn = true;
    if (userLoggedIn) {
        fetch("./api/wishlist.php?action=get&type=tour")
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data.status === "success") {
                    const wishlist = data.items.map(String); // Đảm bảo ID là chuỗi
                    document.querySelectorAll(".wishlist-btn").forEach(btn => {
                        if (wishlist.includes(btn.dataset.id)) {
                            btn.textContent = "❤️";
                            btn.classList.add("liked");
                        }
                    });
                }
            });
    }
}

</script>
<script>
function xemtour() {
    $.ajax({
        url: './api/api.php?action=xemtour',
        type: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            $('#xemtour').html('');
            $('.tour-cards').remove();

            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event, index) {
                    if (index % 3 === 0) {
                        eventHtml += '<div class="tour-cards">';
                    }
                    
                    let departureDates = event.ngaykhoihanh ? event.ngaykhoihanh.split(', ') : [];

                    eventHtml += `
                        <div class="tour-card">
                         <button class="wishlist-btn" data-id="${event.tourid}" data-type="tour">🤍</button>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img style="display: block;" src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4 style=" margin-top: 10px">${event.Name}</h4>
                                <p>

                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong style="margin-left: 10px">Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
    let parts = date.split('-'); // Tách năm, tháng, ngày
    let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM

    // Chuyển đổi thành định dạng Date để so sánh
    let departureDate = new Date(parts[0], parts[1] - 1, parts[2]); 
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Đặt giờ về 0 để so sánh chính xác

    let isPast = departureDate < today ? 'past-date' : ''; // Nếu ngày nhỏ hơn hôm nay, thêm class 'past-date'

    eventHtml += `<span class="departure-date ${isPast}">${formattedDate}</span>`;
});


                    eventHtml += `</div><br>
                               `;

                    if (parseInt(event.discount) == 0) {
                        eventHtml +=` <strong style="margin-left: 10px">Giá: </strong> 
                                <span style="color:red; margin-left: 10px">`+ parseInt(event.Price).toLocaleString('vi-VN') + ` đ </span>`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml +=` <strong style="margin-left: 10px">Giá từ: </strong> 
                                <span style="color:red; margin-left: 10px"><del style="color:black">`+ parseInt(event.Price).toLocaleString('vi-VN') + ` đ</del> </span><br><span style="color:red; margin-left: 10px"> Còn lại: `
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ</span>`;
                    }

                    eventHtml += `</a><br>
                    <center><button class="add-to-compare" data-id="${event.tourid}">So sánh</button></center><br></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
                checkWishlist(); // Kiểm tra danh sách yêu thích sau khi tải tour
            } else {
                $('#xemtour').html('<div class="col">Không tìm thấy thông tin tour.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemtour').html('<div class="col">Đã xảy ra lỗi khi tải thông tin tour.</div>');
        }
    });
}


function xemtourtheomien(mien) {
    $.ajax({
        url: `./api/api.php?action=xemtourtheomien&mien=${mien}`,
        type: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            $('#xemtour').html('');
            $('.tour-cards').remove();

            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event, index) {
                    if (index % 3 === 0) {
                        eventHtml += '<div class="tour-cards">';
                    }
                    
                    let departureDates = event.ngaykhoihanh ? event.ngaykhoihanh.split(', ') : [];

                    eventHtml += `
                        <div class="tour-card">
                         <button class="wishlist-btn" data-id="${event.tourid}" data-type="tour">🤍</button>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4 style=" margin-top: 10px">${event.Name}</h4>
                                <p>
                                   
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong style="margin-left: 10px">Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
    let parts = date.split('-'); // Tách năm, tháng, ngày
    let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM

    // Chuyển đổi thành định dạng Date để so sánh
    let departureDate = new Date(parts[0], parts[1] - 1, parts[2]); 
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Đặt giờ về 0 để so sánh chính xác

    let isPast = departureDate < today ? 'past-date' : ''; // Nếu ngày nhỏ hơn hôm nay, thêm class 'past-date'

    eventHtml += `<span class="departure-date ${isPast}">${formattedDate}</span>`;
});


                    eventHtml += `</div> <br>
                                `;

                    if (parseInt(event.discount) == 0) {
                        eventHtml += `<strong style="margin-left: 10px">Giá:</strong> 
                                  <span style="color:red; margin-left: 10px">` +parseInt(event.Price).toLocaleString('vi-VN') + ` đ </span>`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml +=`<strong style="margin-left: 10px">Giá từ:</strong> 
                                  <span style="color:red; margin-left: 10px"><del style="color:black">`+ parseInt(event.Price).toLocaleString('vi-VN') + ` đ</del> </span><br><span style="color:red; margin-left: 10px">Còn lại: `
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ</span>`;
                    }

                    eventHtml += `</a><br>
                    <br>
                    <center><button class="add-to-compare" data-id="${event.tourid}">So sánh</button></center><br></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
                checkWishlist(); // Kiểm tra danh sách yêu thích sau khi tải tour
            } else {
                $('#xemtour').html('<div class="col">Không có tour nào.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemtour').html('<div class="col">Lỗi tải tour.</div>');
        }
    });
}
function timKiemTourtype(type) {
    $.ajax({
        url: `./api/api.php?action=timkiemtheotype&type=${type}`,
        type: 'GET',
        dataType: 'json',
        cache: false,
        success: function (response) {
            $('#xemtour').html('');
            $('.tour-cards').remove();

            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event, index) {
                    if (index % 3 === 0) {
                        eventHtml += '<div class="tour-cards">';
                    }
                    
                    let departureDates = event.ngaykhoihanh ? event.ngaykhoihanh.split(', ') : [];

                    eventHtml += `
                        <div class="tour-card">
                         <button class="wishlist-btn" data-id="${event.tourid}" data-type="tour">🤍</button>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4 style=" margin-top: 10px">${event.Name}</h4>
                                <p>
                                   
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong style="margin-left: 10px">Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
    let parts = date.split('-'); // Tách năm, tháng, ngày
    let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM

    // Chuyển đổi thành định dạng Date để so sánh
    let departureDate = new Date(parts[0], parts[1] - 1, parts[2]); 
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Đặt giờ về 0 để so sánh chính xác

    let isPast = departureDate < today ? 'past-date' : ''; // Nếu ngày nhỏ hơn hôm nay, thêm class 'past-date'

    eventHtml += `<span class="departure-date ${isPast}">${formattedDate}</span>`;
});


                    eventHtml += `</div>
                               <br>`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml +=`<strong style="margin-left: 10px">Giá:</strong> 
                                  <span style="color:red; margin-left: 10px">` + parseInt(event.Price).toLocaleString('vi-VN') + ` đ </span>`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml +=`<strong style="margin-left: 10px">Giá từ:</strong> 
                                  <span style="color:red; margin-left: 10px"><del style="color:black">`+ parseInt(event.Price).toLocaleString('vi-VN') + ` đ</del> </span><br><span style="color:red; margin-left: 10px">Còn lại: `
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ</span>`;
                    }

                    eventHtml += `</a><br>
                    <br>
                    <center><button class="add-to-compare" data-id="${event.tourid}">So sánh</button></center><br></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
                checkWishlist(); // Kiểm tra danh sách yêu thích sau khi tải tour
            } else {
                $('#xemtour').html('<div class="col">Không tìm thấy tour nào.</div>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi tải dữ liệu:', error);
            $('#xemtour').html('<div class="col">Đã xảy ra lỗi khi tải thông tin tour.</div>');
        }
    });
}

function timKiemThongTin(name, date, budget, month) {


    $.ajax({
        url: `./api/api.php?action=timkiemtheothongtin&name=${name}&date=${date}&budget=${budget}&month=${month}`,
        type: 'GET',
        dataType: 'json',
        cache: false,
        success: function (response) {
            $('#xemtour').html('');
            $('.tour-cards').remove();

            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event, index) {
                    if (index % 3 === 0) {
                        eventHtml += '<div class="tour-cards">';
                    }
                    
                    let departureDates = event.ngaykhoihanh ? event.ngaykhoihanh.split(', ') : [];

                    eventHtml += `
                        <div class="tour-card">
                         <button class="wishlist-btn" data-id="${event.tourid}" data-type="tour">🤍</button>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4 style=" margin-top: 10px">${event.Name}</h4>
                                <p>
                                   
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong style="margin-left: 10px">Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
    let parts = date.split('-'); // Tách năm, tháng, ngày
    let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM

    // Chuyển đổi thành định dạng Date để so sánh
    let departureDate = new Date(parts[0], parts[1] - 1, parts[2]); 
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Đặt giờ về 0 để so sánh chính xác

    let isPast = departureDate < today ? 'past-date' : ''; // Nếu ngày nhỏ hơn hôm nay, thêm class 'past-date'

    eventHtml += `<span class="departure-date ${isPast}">${formattedDate}</span>`;
});


                    eventHtml += `</div>
                                <br>`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml +=`<strong style="margin-left: 10px">Giá:</strong> 
                                  <span style="color:red; margin-left: 10px">` + parseInt(event.Price).toLocaleString('vi-VN') + ` đ </span>`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml +=`<strong style="margin-left: 10px">Giá từ:</strong> 
                                  <span style="color:red; margin-left: 10px"><del style="color:black">`+ parseInt(event.Price).toLocaleString('vi-VN') + ` đ</del> </span><br><span style="color:red; margin-left: 10px">Còn lại: `
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ</span>`;
                    }

                    eventHtml += `</a><br>
                    <br>
                    <center><button class="add-to-compare" data-id="${event.tourid}">So sánh</button></center><br></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
                checkWishlist(); // Kiểm tra danh sách yêu thích sau khi tải tour
            } else {
                $('#xemtour').html('<div class="col">Không tìm thấy tour nào.</div>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi tải dữ liệu:', error);
            $('#xemtour').html('<div class="col">Đã xảy ra lỗi khi tải thông tin tour.</div>');
        }
    });
}

function timKiemThongTintk(name, date, budget, month) {


$.ajax({
    url: `./api/api.php?action=timkiemtheothongtin&name=${name}&date=${date}&budget=${budget}&month=${month}`,
    type: 'GET',
    dataType: 'json',
    cache: false,
    success: function (response) {
        $('#xemtour').html('');
            $('.tour-cards').remove();

            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event, index) {
                    if (index % 3 === 0) {
                        eventHtml += '<div class="tour-cards">';
                    }
                    
                    let departureDates = event.ngaykhoihanh ? event.ngaykhoihanh.split(', ') : [];

                    eventHtml += `
                        <div class="tour-card">
                         <button class="wishlist-btn" data-id="${event.tourid}" data-type="tour">🤍</button>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4 style=" margin-top: 10px">${event.Name}</h4>
                                <p>
                                   
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong style="margin-left: 10px">Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
    let parts = date.split('-'); // Tách năm, tháng, ngày
    let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM

    // Chuyển đổi thành định dạng Date để so sánh
    let departureDate = new Date(parts[0], parts[1] - 1, parts[2]); 
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Đặt giờ về 0 để so sánh chính xác

    let isPast = departureDate < today ? 'past-date' : ''; // Nếu ngày nhỏ hơn hôm nay, thêm class 'past-date'

    eventHtml += `<span class="departure-date ${isPast}">${formattedDate}</span>`;
});


                    eventHtml += `</div>
                                <br>`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml +=`<strong style="margin-left: 10px">Giá:</strong> 
                                  <span style="color:red; margin-left: 10px">` + parseInt(event.Price).toLocaleString('vi-VN') + ` đ </span>`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml +=`<strong style="margin-left: 10px">Giá từ:</strong> 
                                  <span style="color:red; margin-left: 10px"><del style="color:black">`+ parseInt(event.Price).toLocaleString('vi-VN') + ` đ</del> </span><br><span style="color:red; margin-left: 10px">Còn lại: `
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ</span>`;
                    }

                    eventHtml += `</a><br>
                    <br>
                    <center><button class="add-to-compare" data-id="${event.tourid}">So sánh</button></center><br></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
                checkWishlist(); // Kiểm tra danh sách yêu thích sau khi tải tour
        } else {
            $('#xemtour').html('<div class="col">Không tìm thấy tour nào.</div>');
        }
    },
    error: function (xhr, status, error) {
        console.error('Lỗi khi tải dữ liệu:', error);
        $('#xemtour').html('<div class="col">Đã xảy ra lỗi khi tải thông tin tour.</div>');
    }
});
}


$(document).ready(function () {
    console.log("Trang xemtour.php đã load!"); // Kiểm tra xem script có chạy không
   
   
   
    let urlParams = new URLSearchParams(window.location.search);

if (urlParams.has('tour1')) {
  
    let name = urlParams.get('name') || '';
    let date = urlParams.get('date') || '';
    let budget = urlParams.get('budget') || '';
    
    let month = urlParams.get('month') || '';
    console.log("Tìm kiếm với:", name, date, budget.month);

    // Gán lại giá trị vào ô tìm kiếm
    $('.search-input').val(name);
    $('.date-input').val(date);
    $('.budget-select').val(budget);
    $('#month-select').val(month);

    // Gọi API tìm kiếm
    timKiemThongTintk(name, date, budget, month)
}
if (urlParams.has('mien')) {
    let selectedMien = urlParams.get('mien');
    console.log("Lọc theo miền:", selectedMien);
    xemtourtheomien(selectedMien);
} 

$('.submenu-right a').on('click', function (e) {
    let rawHref = $(this).attr('href'); 
    e.preventDefault();
    let url = new URL($(this).attr('href'), window.location.origin);
    let selectedMien = url.searchParams.get('mien');

    if (selectedMien) {
        history.pushState({}, '', `index.php?tour&mien=${selectedMien}`);
        xemtourtheomien(selectedMien);
    } else {
            // Nếu không có ?mien=, có thể điều hướng bình thường
            window.location.href = rawHref;
        }
    
});

    // Xử lý sự kiện khi chọn radio button lọc theo loại tour
    $('.sidebar input[type="radio"]').change(function () {
        var selectedType = $(this).val();
        console.log("Lọc theo loại tour:", selectedType);
        timKiemTourtype(selectedType);
    });

    // Xử lý sự kiện khi nhấn nút tìm kiếm
    $('.search-button').click(function () {
        event.preventDefault();  // 🚀 Chặn load lại trang
        var name = $('.search-input').val();
        var date = $('.date-input').val();
        var budget = $('.budget-select').val();
        var month = $('#month-select').val();
        var type = $('input[name="type"]:checked').val();

        console.log("Tìm kiếm với:", name, date, budget, month , type);
        timKiemThongTin(name, date, budget, month , type);
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    let tourData = []; // Lưu danh sách tour để lọc lại khi nhấn nút

    // Lấy danh sách tour từ API
    function xemtour() {
        $.ajax({
            url: './api/api.php?action=xemtour',
            type: 'GET',
            dataType: 'json',
            cache: false,
            success: function (response) {
                if (Array.isArray(response) && response.length > 0) {
                    tourData = response; // Lưu dữ liệu
                    renderTourList(tourData); // Hiển thị toàn bộ tour ban đầu
                } else {
                    $('#xemtour').html('<div class="col">Không có tour nào.</div>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Lỗi khi lấy dữ liệu:', error);
                $('#xemtour').html('<div class="col">Lỗi tải danh sách tour.</div>');
            }
        });
    }

    // Hàm hiển thị danh sách tour
    function renderTourList(data) {
        $('#xemtour').html(''); // Xóa nội dung cũ
        let eventHtml = '';

        data.forEach(function (tour,index) {
            let price = parseInt(tour.Price); // Chuyển giá thành số nguyên
            let discount = parseInt(tour.discount) || 0; // Lấy giá giảm

                if (index % 3 === 0) {
                        eventHtml += '<div class="tour-cards">';
                }
                    
                    let departureDates = tour.ngaykhoihanh ? tour.ngaykhoihanh.split(', ') : [];

                    eventHtml += `
                        <div class="tour-card">
                         <button class="wishlist-btn" data-id="${tour.tourid}" data-type="tour">🤍</button>
                            <a href="index.php?idtour=${tour.tourid}&xemdanhgiatour=${tour.tourid}&xemdanhgiarating=${tour.tourid}">
                                <img src="./assets/img/tour/${tour.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${tour.tourid}&xemdanhgiatour=${tour.tourid}&xemdanhgiarating=${tour.tourid}">
                                <h4 style=" margin-top: 10px">${tour.Name}</h4>
                                <p>
                                   
                                    Thời gian: ${tour.timetour} <br>
                                    Phương tiện: ${tour.vehicle}
                                </p>
                                <strong style="margin-left: 10px">Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
    let parts = date.split('-'); // Tách năm, tháng, ngày
    let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM

    // Chuyển đổi thành định dạng Date để so sánh
    let departureDate = new Date(parts[0], parts[1] - 1, parts[2]); 
    let today = new Date();
    today.setHours(0, 0, 0, 0); // Đặt giờ về 0 để so sánh chính xác

    let isPast = departureDate < today ? 'past-date' : ''; // Nếu ngày nhỏ hơn hôm nay, thêm class 'past-date'

    eventHtml += `<span class="departure-date ${isPast}">${formattedDate}</span>`;
});


                    eventHtml += `</div><br> 
                                
                        ${discount > 0 ? "<strong style='margin-left: 10px'>Giá từ:</strong> <del style='color:black'>" +price.toLocaleString('vi-VN') + " đ </del> <br><span style='color:red;margin-left: 10px;'>Còn lại : " + discount.toLocaleString('vi-VN') : "<strong style='margin-left: 10px'>Giá:</strong><span style='color:red; margin-left: 10px'>" + price.toLocaleString('vi-VN')} đ
                    </span>`;

                  

                    eventHtml += `</a>
                    <br>
                    <center><button class="add-to-compare" data-id="${tour.tourid}">So sánh</button></center><br></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === data.length) {
                        eventHtml += '</div>';
                    }
        });

        $('#xemtour').html(eventHtml);
        checkWishlist(); // Kiểm tra danh sách yêu thích sau khi tải tour
    }

    // Xử lý khi nhấn nút lọc
    $('.menu-tabs button').click(function () {
        let filterType = $(this).data('filter');
        let filteredTours = [];

        if (filterType === "caocap") {
            filteredTours = tourData.filter(tour => parseInt(tour.Price) >= 10000000);
        } else if (filterType === "tieuchuan") {
            filteredTours = tourData.filter(tour => parseInt(tour.Price) >= 5000000 && parseInt(tour.Price) < 10000000);
        } else if (filterType === "tietkiem") {
            filteredTours = tourData.filter(tour => parseInt(tour.Price) < 5000000);
        } else if (filterType === "khuyenmai") {
            filteredTours = tourData.filter(tour => parseInt(tour.discount) > 0);
        }

        renderTourList(filteredTours); // Cập nhật danh sách tour theo bộ lọc
    });

    xemtour(); // Gọi API khi tải trang
});

</script>



<div id="compareModal" style="display:none; position:fixed; top:10%; left:5%; right:5%; background:#fff; border:1px solid #ccc; padding:20px; z-index:1000; border-radius:12px; box-shadow:0 0 10px rgba(0,0,0,0.3);">
  <h3 style="color:black">🔍 So sánh Tour</h3>
  <div id="compareModalContent" class="scroll-horizontal" style="display: flex; gap: 20px; overflow-x: auto;"></div>
  <div style="text-align: right; margin-top: 15px;">
    <button onclick="document.getElementById('compareModal').style.display='none'">Đóng</button>
  </div>
</div>



<script>
// Khi nhấn nút "Thêm vào so sánh"
$(document).on('click', '.add-to-compare', function () {
    const id = $(this).data('id').toString(); // ép về string để tránh lỗi so sánh
    let compareList = JSON.parse(localStorage.getItem('compareTours')) || [];

    if (!compareList.includes(id)) {
        if (compareList.length >= 3) {
            openPopup('Chỉ có thể so sánh tối đa 3 tour','');
            return;
        }
        compareList.push(id);
        localStorage.setItem('compareTours', JSON.stringify(compareList));
        openPopup('✅ Đã thêm tour vào danh sách so sánh','');
    } else {
        openPopup('⚠️ Tour đã có trong danh sách','');
    }
});

// Hiển thị modal so sánh
function showCompareModal() {
    const ids = JSON.parse(localStorage.getItem('compareTours')) || [];
    if (ids.length < 2) {
        openPopup("❗ Hãy chọn ít nhất 2 tour để so sánh.",'');
        return;
    }

    fetch(`./api/phancong.php?action=getToursByIds&ids=${ids.join(',')}`)
        .then(res => res.json())
        .then(data => {
            let html = '<div class="compare-container">';
            data.forEach(tour => {
                html += `
                    <div class="tour-box" style="min-width:300px; border:1px solid #ccc; padding:10px; border-radius:8px;color:black">
                        <img src="./assets/img/tour/${tour.Image}" alt="" width="100%">
                        <h4 style="color:black">${tour.Name}</h4>
                        <p><strong>Giá:</strong> ${parseInt(tour.discount || tour.Price).toLocaleString()} đ</p>
                        <p><strong>Địa điểm:</strong> ${tour.DepartureLocation}</p>
                        <p><strong>Phương tiện:</strong> ${tour.vehicle}</p>
                        <p><strong>Phong cách:</strong> ${tour.Style}</p>
                        <p><strong>Thời gian:</strong> ${tour.timetour}</p>
                    </div>
                `;
            });
            html += '</div>';
            document.getElementById('compareModalContent').innerHTML = html;
            document.getElementById('compareModal').style.display = 'block';
        });
}

// Xóa danh sách so sánh
function clearCompare() {
    localStorage.removeItem('compareTours');
    openPopup("🗑️ Đã xóa danh sách so sánh.",'');
    document.getElementById('compareModal').style.display = 'none';
}
</script>
