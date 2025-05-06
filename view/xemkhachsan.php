
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

.search-bar input,
.search-bar select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    flex: 1 1 150px;
    min-width: 120px;
}

.date-input-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    flex: 1 1 300px;
}

.date-input-wrapper {
    flex: 1 1 140px;
    position: relative;
}

.date-input {
    width: 100%;
    height: 40px;
    border-radius: 5px;
}

.search-input {
    flex: 2 1 250px;
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
    background-color: #0056b3;
    height: 150px;
   
}

#xemks {
    flex: 0 0 80%; /* Phần nội dung chiếm 70% */
    max-width: 80%; /* Đảm bảo tối đa 70% */
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    background-color: white;
}


.tour-cards {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
   

}

.tour-card {
    width: 100%; /* Đảm bảo 3 phần tử trên 1 hàng */
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    
  
   
}

.tour-card img {
    width: 60%;
    height: 220px;
    object-fit: cover;
    float: left;
}

.tour-card p {
    width: 40%;
    padding: 10px;
    text-align: center;
    font-size: 16px;
    color: #333;
    float: left;
 
}

a{
    text-decoration:none;
    color:black;
}
label{
 font-size:14px;
}
.input-container {
  display: flex;
  align-items: center;
}

.label-text {
  margin-right: 8px;
  font-weight: bold;
}
.date-input-container {
    position: relative;
    display: flex;
    gap: 10px;
}

.date-input-wrapper {
    position: relative;
    display: inline-block;
}
.date-input {
   height: 50px;
    
}
.date-input-wrapper::before {
    content: attr(data-label);
    position: absolute;
    top: -25px;
    left: 5px;
    font-size: 14px;
    color:black;
    opacity: 0;
    transition: opacity 0.3s;
}

.date-input-wrapper:hover::before {
    opacity: 1;
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
        height: 200px;
        
    }
    .menu-tabs button {
        padding: 5px 10px;
        font-size: 10px;
    }


  
}

@media (max-width: 600px) {


    .tour-card p,strong {
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
        height: 200px;
        
    }
    .menu-tabs button {
        padding: 5px 10px;
        font-size: 10px;
    }
 

  
    
}
</style>
    <div class="container2">
        <!-- Menu Tabs -->
    

        <div class="search-bar">
            
    <input type="text" name="name" placeholder="Nhập tên phòng/Địa điểm" class="search-input" id="hotel-main-search">

    <div class="date-input-container hidden-on-mobile">
        <div class="date-input-wrapper" data-label="Ngày nhận">
            <input type="date" id="ngay-nhan" class="date-input" name="checkin">
        </div>
        <div class="date-input-wrapper" data-label="Ngày trả">
            <input type="date" id="ngay-tra" class="date-input" name="checkout">
        </div>
    </div>

    <input type="number" id="adult" name="adult" placeholder="Số người lớn" class="hidden-on-mobile">
    <input type="number" name="children" id="children" placeholder="Số trẻ em" class="hidden-on-mobile">

    <select name="price" id="price" class="hidden-on-mobile">
        <option value="">Chọn giá</option>
        <option value="low">Dưới 1 triệu</option>
        <option value="medium">1 triệu - 2 triệu</option>
        <option value="mediumer">2 triệu - 3 triệu</option>
        <option value="high">3 triệu - 4 triệu</option>
        <option value="higher">Trên 4 triệu</option>
    </select>

    <button class="search-button hidden-on-mobile" style="background-color: white; border: 1px solid grey">🔍</button>
</div>

            
        <div class="container-layout">
    <!-- Sidebar -->
<div class="sidebar" style="background-color: #6495ED">
    <h5>Diện tích:<h5>
    <div>
        <input type="radio" id="area_small" name="area" value="Small">        
        <label for="area_small">Nhỏ (Dưới 30m²)</label>
    </div>
    <div>
        <input type="radio" id="area_medium" name="area" value="Medium">
        <label for="area_medium">Trung bình (30m² - 50m²)</label>
    </div>
    <div>
        <input type="radio" id="area_large" name="area" value="Large">
        <label for="area_large">Lớn (Trên 50m²)</label>
    </div>
   
 

</div>

    <!-- Content Section -->
    <div id="xemks">
        <!-- Nội dung tour sẽ được thêm vào đây -->
    </div>
</div>

       
           
       
        

        <!-- Tour Cards -->
        
           
           
        
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
       function xemks() {
    $.ajax({
        url: './api/api.php?action=xemkhachsan',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event, index) {
                   
                        eventHtml += '<div class="tour-cards">';
                    
                    eventHtml += `
                            <div class="tour-card">
                            <a href="index.php?idks=${event.idroom}&xemdanhgiaks=${event.idroom}&xemdanhgiaratingks=${event.idroom}"><img src="./assets/img/ks/${event.Image}" alt=""> </a>
                            <a href="index.php?idroomks=${event.idroom}&xemdanhgiaks=${event.idroom}&xemdanhgiaratingks=${event.idroom}"><p>${event.Name}<br>${event.Thumb}<br><br>${event.Diadiem}<br><br>
                            <span style="color:red">Giá mỗi đêm: ${parseInt(event.Price).toLocaleString('vi-VN')} đ</span></p>
                            
                            `;
                           
                            
                           
                    eventHtml += `</div>`;
                  
                        eventHtml += '</div>';
                    
                });
                $('#xemks').html(eventHtml);
            } else {
                $('#xemks').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemks').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function timKiemKStype(type) {
    $.ajax({
        url: `./api/api.php?action=timkiemtheotypeks&area=${type}`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            
            if (Array.isArray(response) && response.length > 0) {
                var tours = response;
                var tourHtml = '';
                tours.forEach(function (tour, index) {
                   
                        tourHtml += '<div class="tour-cards">';
                    
                        tourHtml  += `
                            <div class="tour-card">
                            <a href="index.php?idks=${tour.id}&xemdanhgiaks=${tour.id}&xemdanhgiaratingks=${tour.id}"><img src="./assets/img/ks/${tour.Image}" alt=""> </a>
                            <a href="index.php?idks=${tour.id}&xemdanhgiaks=${tour.id}&xemdanhgiaratingks=${tour.id}"><p>${tour.Name}<br>${tour.Thumb}<br><br>${tour.Diadiem}<br><br>
                            <span style="color:red" >Giá mỗi đêm: ${parseInt(tour.Price).toLocaleString('vi-VN')} đ </span></p>
                            `;
                           
                           
                            
                           
                    tourHtml += `</div>`;
                  
                        tourHtml += '</div>';
                    
                });
                $('#xemks').html(tourHtml);
            } else {
                $('#xemks').html('<div class="col">Không tìm thấy khách sạn nào.</div>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi tải dữ liệu:', error);
            $('#xemtour').html('<div class="col">Đã xảy ra lỗi khi tải thông tin khách sạn.</div>');
        }
    });
}

function timKiemThongTinks(name, price, area, adult, children, checkin, checkout) {
    // Kiểm tra và thay thế giá trị rỗng thành chuỗi trống ''
    name = name ? encodeURIComponent(name) : '';
    price = price ? encodeURIComponent(price) : '';
    area = area ? encodeURIComponent(area) : '';
    adult = adult ? encodeURIComponent(adult) : '';
    children = children ? encodeURIComponent(children) : '';
    checkin = checkin ? encodeURIComponent(checkin) : '';
    checkout = checkout ? encodeURIComponent(checkout) : '';

    // Kiểm tra nếu ngày nhận >= ngày trả thì báo lỗi và không gửi request
    if (checkin && checkout && new Date(checkin) >= new Date(checkout)) {
        alert('Ngày nhận phải trước ngày trả!');
        return;
    }

    $.ajax({
        url: `./api/api.php?action=timkiemtheothongtinks&name=${name}&price=${price}&area=${area}&adult=${adult}&children=${children}&checkin=${checkin}&checkout=${checkout}`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (Array.isArray(response) && response.length > 0) {
                var tourHtml = response.map(tour => `
                    <div class="tour-cards">
                        <div class="tour-card">
                            <a href="index.php?idks=${tour.id}&xemdanhgiaks=${tour.id}&xemdanhgiaratingks=${tour.id}">
                                <img src="./assets/img/ks/${tour.Image}" alt="">
                            </a>
                            <a href="index.php?idks=${tour.id}&xemdanhgiaks=${tour.id}&xemdanhgiaratingks=${tour.id}">
                               <p>${tour.Name}<br>${tour.Thumb}<br><br>${tour.Diadiem}<br><br>  <span style="color:red">Giá mỗi đêm: ${parseInt(tour.Price).toLocaleString('vi-VN')} đ </span></p>
                              
                            </a>
                        </div>
                    </div>
                `).join('');

                $('#xemks').html(tourHtml);
            } else {
                $('#xemks').html('<div class="col">Không tìm thấy khách sạn nào.</div>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi tải dữ liệu:', error);
            $('#xemks').html('<div class="col">Đã xảy ra lỗi khi tải thông tin khách sạn.</div>');
        }
    });
}


$(document).ready(function() {
    console.log("Trang đã load!"); // Kiểm tra xem script có chạy không
    xemks();
    let urlParams = new URLSearchParams(window.location.search);

if (urlParams.has('ks')) {
    let name = urlParams.get('name') || '';
    let price = urlParams.get('price') || '';
    let area = urlParams.get('area') || '';
    let adult = urlParams.get('adult') || '';
    let children = urlParams.get('children') || '';
    let checkin = urlParams.get('checkin') || '';
    let checkout = urlParams.get('checkout') || '';

    console.log("Tìm kiếm với:", name, price, area, adult, children, checkin, checkout);

    // Gán lại giá trị vào ô tìm kiếm
    $('.search-input').val(name);
    $('#price').val(price);
    $('input[name="area"][value="' + area + '"]').prop('checked', true);
    $('#adult').val(adult);
    $('#children').val(children);
    $('#ngay-nhan').val(checkin);
    $('#ngay-tra').val(checkout);

    // Gọi API tìm kiếm khách sạn
    timKiemThongTinks(name, price, area, adult, children, checkin, checkout);
}else {
    xemks()
}
    $('.sidebar input[type="radio"]').change(function () {
        var selectedType = $(this).val(); // Lấy giá trị từ radio button
        timKiemKStype(selectedType); // Gọi hàm tìm kiếm tour theo type
    });
    $('.search-button').click(function () {
        var name = $('.search-input').val();  // Lấy giá trị tên
        var price = $('#price').val();  // Sửa 'budget' thành 'price'
        var area = $('input[name="area"]:checked').val();  // Lấy giá trị diện tích đã chọn
        var adult = $('#adult').val();  // Số người lớn
        var children = $('#children').val();  // Số trẻ em
        
        var checkin = $('#ngay-nhan').val();  // Ngày nhận
        var checkout = $('#ngay-tra').val();  // Ngày trả   

        timKiemThongTinks(name, price, area, adult, children,checkin,checkout);  // Gọi hàm tìm kiếm
    });
});

</script>
