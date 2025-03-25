
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
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 10px;
}

.search-input,
.date-input,
.budget-select {
    padding: 10px;
    width: 30%;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
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
    background-color: #007bff;
    height: 150px;
   
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
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    
   

}

.tour-card {
    width: 30%; /* Đảm bảo 3 phần tử trên 1 hàng */
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    
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

</style>
    <div class="container2">
        <!-- Menu Tabs -->
        <div class="menu-tabs">
    <button data-filter="caocap">Tour cao cấp</button>
    <button data-filter="tieuchuan">Tour tiêu chuẩn</button>
    <button data-filter="tietkiem">Tour tiết kiệm</button>
    <button data-filter="khuyenmai">Tour khuyến mãi</button>
</div>




        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Bạn muốn đi đâu?" class="search-input">
            <input type="date" class="date-input">
            <select class="budget-select">
                <option value="">Ngân sách</option>
                <option value="low">Dưới 5 triệu</option>
                <option value="medium">5 - 10 triệu</option>
                <option value="high">Trên 10 triệu</option>
            </select>
            <button class="search-button">🔍</button>
        </div>

      
            
        <div class="container-layout">
    <!-- Sidebar -->
<div class="sidebar">
    <h5>Loại tour bạn muốn đi?</h5>
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
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4>${event.Name}</h4>
                                <p>
                                    Mã tour: ${event.tourid} <br>
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong>Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
                        let parts = date.split('-'); // Tách năm, tháng, ngày
                        let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM
                        eventHtml += `<span class="departure-date">${formattedDate}</span>`;
                    });

                    eventHtml += `</div>
                                <strong>Giá từ:</strong> 
                                <br> <span style="color:red">`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml += parseInt(event.Price).toLocaleString('vi-VN') + ` đ`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ`;
                    }

                    eventHtml += `</span></a></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
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
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4>${event.Name}</h4>
                                <p>
                                    Mã tour: ${event.tourid} <br>
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong>Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
                        let parts = date.split('-'); // Tách năm, tháng, ngày
                        let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM
                        eventHtml += `<span class="departure-date">${formattedDate}</span>`;
                    });

                    eventHtml += `</div>
                                <strong>Giá từ:</strong> 
                                <br> <span style="color:red">`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml += parseInt(event.Price).toLocaleString('vi-VN') + ` đ`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ`;
                    }

                    eventHtml += `</span></a></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
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
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4>${event.Name}</h4>
                                <p>
                                    Mã tour: ${event.tourid} <br>
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong>Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
                        let parts = date.split('-'); // Tách năm, tháng, ngày
                        let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM
                        eventHtml += `<span class="departure-date">${formattedDate}</span>`;
                    });

                    eventHtml += `</div>
                                <strong>Giá từ:</strong> 
                                <br> <span style="color:red">`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml += parseInt(event.Price).toLocaleString('vi-VN') + ` đ`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ`;
                    }

                    eventHtml += `</span></a></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
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

function timKiemThongTin(name, date, budget) {


    $.ajax({
        url: `./api/api.php?action=timkiemtheothongtin&name=${name}&date=${date}&budget=${budget}`,
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
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4>${event.Name}</h4>
                                <p>
                                    Mã tour: ${event.tourid} <br>
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong>Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
                        let parts = date.split('-'); // Tách năm, tháng, ngày
                        let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM
                        eventHtml += `<span class="departure-date">${formattedDate}</span>`;
                    });

                    eventHtml += `</div>
                                <strong>Giá từ:</strong> 
                                <br> <span style="color:red">`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml += parseInt(event.Price).toLocaleString('vi-VN') + ` đ`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ`;
                    }

                    eventHtml += `</span></a></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
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

function timKiemThongTintk(name, date, budget) {


$.ajax({
    url: `./api/api.php?action=timkiemtheothongtin&name=${name}&date=${date}&budget=${budget}`,
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
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <img src="./assets/img/tour/${event.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${event.tourid}&xemdanhgiatour=${event.tourid}&xemdanhgiarating=${event.tourid}">
                                <h4>${event.Name}</h4>
                                <p>
                                    Mã tour: ${event.tourid} <br>
                                    Thời gian: ${event.timetour} <br>
                                    Phương tiện: ${event.vehicle}
                                </p>
                                <strong>Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
                        let parts = date.split('-'); // Tách năm, tháng, ngày
                        let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM
                        eventHtml += `<span class="departure-date">${formattedDate}</span>`;
                    });

                    eventHtml += `</div>
                                <strong>Giá từ:</strong> 
                                <br> <span style="color:red">`;

                    if (parseInt(event.discount) == 0) {
                        eventHtml += parseInt(event.Price).toLocaleString('vi-VN') + ` đ`;
                    } else if (parseInt(event.discount) > 0) {
                        eventHtml += parseInt(event.discount).toLocaleString('vi-VN') + ` đ`;
                    }

                    eventHtml += `</span></a></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === events.length) {
                        eventHtml += '</div>';
                    }
                });
                $('#xemtour').html(eventHtml);
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
   
   
    xemtour();
    let urlParams = new URLSearchParams(window.location.search);

if (urlParams.has('tour1')) {
  
    let name = urlParams.get('name') || '';
    let date = urlParams.get('date') || '';
    let budget = urlParams.get('budget') || '';
    

    console.log("Tìm kiếm với:", name, date, budget);

    // Gán lại giá trị vào ô tìm kiếm
    $('.search-input').val(name);
    $('.date-input').val(date);
    $('.budget-select').val(budget);
   

    // Gọi API tìm kiếm
    timKiemThongTintk(name, date, budget);
}

if(urlParams.has('mien')) {
   
        let selectedMien = urlParams.get('mien');
        console.log("Lọc theo miền:", selectedMien);
        xemtourtheomien(selectedMien);
}

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
        var type = $('input[name="type"]:checked').val();

        console.log("Tìm kiếm với:", name, date, budget, type);
        timKiemThongTin(name, date, budget, type);
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
                            <a href="index.php?idtour=${tour.tourid}&xemdanhgiatour=${tour.tourid}&xemdanhgiarating=${tour.tourid}">
                                <img src="./assets/img/tour/${tour.Image}" alt=""> 
                            </a>
                            <a href="index.php?idtour=${tour.tourid}&xemdanhgiatour=${tour.tourid}&xemdanhgiarating=${tour.tourid}">
                                <h4>${tour.Name}</h4>
                                <p>
                                    Mã tour: ${tour.tourid} <br>
                                    Thời gian: ${tour.timetour} <br>
                                    Phương tiện: ${tour.vehicle}
                                </p>
                                <strong>Khởi hành:</strong>
                                <div class="departure-box">`;

                    // Lặp danh sách ngày khởi hành và hiển thị trong box
                    departureDates.forEach(date => {
                        let parts = date.split('-'); // Tách năm, tháng, ngày
                        let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM
                        eventHtml += `<span class="departure-date">${formattedDate}</span>`;
                    });

                    eventHtml += `</div>
                                <strong>Giá từ:</strong> 
                                <br> <p>Giá: <span style="color:red">
                        ${discount > 0 ? discount.toLocaleString('vi-VN') : price.toLocaleString('vi-VN')} đ
                    </span></p>`;

                  

                    eventHtml += `</a></div>`;

                    if ((index + 1) % 3 === 0 || (index + 1) === data.length) {
                        eventHtml += '</div>';
                    }
        });

        $('#xemtour').html(eventHtml);
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