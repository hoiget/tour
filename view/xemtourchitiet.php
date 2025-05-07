<style>
  
.main-content {
    background-color: #fff;
    padding: 20px;
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.main-content h2 {
    margin-bottom: 10px;
    font-size: 24px;
}

.rating {
    font-size: 14px;
    margin-bottom: 20px;
    color: #f39c12;
}
.tour-details {
    display: flex;
    gap: 20px;
    justify-content: space-between;
}




.image {
    width: 60%; /* Chiếm 50% chiều rộng của container */
}

.image img {
    width: 100%; /* Đảm bảo hình ảnh chiếm toàn bộ chiều rộng của .image */
    height: auto; /* Để hình ảnh giữ tỷ lệ gốc */
    border-radius: 8px;
}

.details {
    width: 40%; /* Chiếm 50% chiều rộng của container */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    height: 550px;
    padding-left:10px;
}

.details1 {
    background: black;
    color: red;
    text-align: center;
    height: 50px;
    line-height: 50px;
}

.details h3 {
    margin-bottom: 15px;
    font-size: 18px;
    color: #333;
}

.details ul {
    list-style: none;
    padding-left: 0;
}

.details ul li {
    margin-bottom: 10px;
    font-size: 20px;
    color: black;
}

.but {
    display: inline-block;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: grey; /* Màu xanh */
    border: none;
    border-radius: 5px; /* Góc bo tròn */
    cursor: pointer;
    transition: all 0.3s ease; /* Hiệu ứng mượt khi hover */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng */
   margin-top:20px;
}

.but:hover {
    background-color: black; /* Màu tối hơn khi hover */
    transform: translateY(-2px); /* Hiệu ứng nổi lên */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Đổ bóng lớn hơn */
}

.but:active {
    transform: translateY(1px); /* Nút ấn xuống */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Đổ bóng nhỏ hơn */
}

.but:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.25); /* Hiệu ứng focus */
}
.btn:hover{
    color:grey;
}
h3{
    color:black;
}
.ndo{
    color:black;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px;
    transition: box-shadow 0.3s ease-in-out; 
}
.ndo:hover {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3); /* Hiệu ứng khi hover, bóng đổ sâu hơn */
}

.review p{
    color:black;
}
.departure-box {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 5px;
}
.item{
    display: flex;
    flex-wrap: wrap;
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
.goiy{
    color:blue;
    
}
.card-img-top{
    width: 100%;
    height: 300px;
}
/* Điều chỉnh cho tablet và điện thoại */
@media (max-width: 768px) {
    .tour-details {
        flex-direction: column; /* Chuyển sang dạng dọc */
    }

    .image, .details {
        width: 100%; /* Chiếm toàn bộ chiều rộng */
        height: auto;
    }

    .details1 {
        font-size: 14px;
    }

    .details h3 {
        font-size: 16px;
    }

    .details ul li {
        font-size: 14px;
    }

    .departure-box span {
        font-size: 12px;
    }

    .but {
        font-size: 14px;
        padding: 10px 16px;
    }

    .ndo {
        font-size: 16px;
    }

    .review p {
        font-size: 14px;
    }
}

/* Thêm media nhỏ hơn nếu cần */
@media (max-width: 480px) {
    .details h3 {
        font-size: 14px;
    }

    .details ul li,
    .ndo,
    .review p {
        font-size: 12px;
    }

    .but {
        font-size: 12px;
        padding: 8px 12px;
    }

    .departure-box span {
        font-size: 10px;
    }

    .details1 {
        font-size: 12px;
    }
}
.wishlist-btn {
    font-size: 22px;
    border: none;
    background: none;
    cursor: pointer;
    transition: transform 0.2s ease;
    color: gray;
   padding-left:10px;
    top: 10px;
    right: 10px;
    z-index: 10;
}

.wishlist-btn:hover {
    transform: scale(1.2);
}

.wishlist-btn.liked {
    color: red;
}


</style>
<main class="main-content">

    <a href="index.php?tour">Quay lại</a>
<button type="button" class="btn review" data-bs-toggle="modal" data-bs-target="#ratingModal">
    Xem đánh giá
</button>

<div class="modal fade" id="ratingModal" tabindex="" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg ở đây -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Đánh giá Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="xemchitiet12"></div>
            </div>
        </div>
    </div>
</div> <div id="xemchitiet123"></div>
           <div id="xemchitiet"></div>
            <center><h3 class="goiy">Các chương trình khác</h3></center>
           <div id="goiYTour"></div>

        </main>
        
        <script>
document.addEventListener("DOMContentLoaded", function () {
    const userLoggedIn = true; // kiểm tra người dùng đã đăng nhập hay chưa (có thể sửa lại)

    // Lấy danh sách item đã yêu thích từ server
    let wishlist = [];
    if (userLoggedIn) {
        fetch("./api/wishlist.php?action=get&type=tour") // hoặc type=room
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    wishlist = data.items.map(String); // Chuyển về dạng chuỗi để so sánh
                    document.querySelectorAll(".wishlist-btn").forEach(btn => {
                        if (wishlist.includes(btn.dataset.id)) {
                            btn.textContent = "❤️";
                        }
                    });
                }
            });
    }

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
                btn.textContent = "❤️ Yêu thích";
            } else if (data.status === "removed") {
                btn.textContent = "🤍 Yêu thích";
            } else {
                alert(data.message || "Lỗi xảy ra");
            }
        });
    });
});
function checkWishlist() {
    const userLoggedIn = true;
    if (userLoggedIn) {
        fetch("./api/wishlist_api.php?action=get&type=tour")
            .then(res => res.json())
            .then(data => {
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

function xemdanhgiarating() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour1 = urlParams.get('xemdanhgiarating'); // Lấy ID từ URL
    $.ajax({
        url: './api/api.php?action=xemdanhgiarating&xemdanhgiarating=' + idtour1,
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '<h3>Đánh giá</h3>';
                events.forEach(function(event, index) {
                    eventHtml += `
                        <div class="rating">
                            <span>★ ${event.average_rating || '0'}/5 trong ${event.total_ratings} đánh giá</span>
                        </div>
                    
                    `;
                });
                $('#xemchitiet123').html(eventHtml);
            } else {
                $('#xemchitiet123').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemchitiet123').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
};

 function xemtourchitiet() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour = urlParams.get('idtour'); // Lấy ID từ URL

    $.ajax({
        url: './api/api.php?action=xemtourchitiet&idtour=' + idtour,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
    if (Array.isArray(response) && response.length > 0) {
        const event = response[0]; // Lấy phần tử đầu tiên
        let departureDates = event.ngaykhoihanh ? event.ngaykhoihanh.split(', ') : [];
        let ordersInfo = event.orders_info ? event.orders_info.split(', ') : [];

        // Chuyển ordersInfo thành object { "YYYY-MM-DD": số lượt đặt }
        let ordersMap = {};
        ordersInfo.forEach(info => {
            let [date, orders] = info.split(':');
            ordersMap[date] = orders;
        });

        let eventHtml = `

            <div class="item" data-id="${event.idtour}" data-type="tour">
                <h2 style="color:black">${event.Name}</h2>
                <button class="wishlist-btn" data-id="${event.idtour}" data-type="tour">🤍 Yêu thích</button>
            </div>
            <div class="tour-details">
                <div class="image">
                    <img src="./assets/img/tour/${event.Image}" alt="Tour du lịch" />
                   
                </div>
                <div class="details">
                    <h3 style="color:black;font-size:20px">Chi tiết Tour</h3>
                    <ul>
                        <li><strong>Mã tour:</strong> ${event.idtour}</li>
                        <li><strong>Kiểu tour:</strong> ${event.Style}</li>
                        <li><strong>Số người tham gia:</strong> ${event.Max_participant} (tối thiểu: ${event.Min_participant} người)</li>
                        <li><strong>Thời gian:</strong> ${event.timetour}</li>
                        <li><strong>Khởi hành:</strong>
                            <div class="departure-box">`;

        // Lặp danh sách ngày khởi hành và hiển thị với số lượt đặt
        departureDates.forEach(date => {
            let parts = date.split('-'); // Tách năm, tháng, ngày
            let formattedDate = `${parts[2]}/${parts[1]}`; // Định dạng lại thành DD/MM

            // Chuyển đổi thành định dạng Date để so sánh với ngày hiện tại
            let departureDate = new Date(parts[0], parts[1] - 1, parts[2]);
            let today = new Date();
            today.setHours(0, 0, 0, 0); // Đặt giờ về 0 để so sánh chính xác

            let isPast = departureDate < today ? 'past-date' : ''; // Nếu ngày nhỏ hơn hôm nay, thêm class 'past-date'

            let ordersCount = ordersMap[date] || 0; // Lấy số lượt đặt từ object `ordersMap`

            eventHtml += `<span class="departure-date ${isPast}">${formattedDate} (${ordersCount} lượt đặt)</span>`;
        });

        eventHtml += `</div></li>
                        <li><strong>Phương tiện:</strong> ${event.vehicle}</li>
                        <li><strong>Xuất phát:</strong> ${event.DepartureLocation}</li>
                    </ul>
                    <div class="details1">`;

        if (parseInt(event.discount) === 0) {
            eventHtml += `<strong>Giá tour:</strong> ` + parseInt(event.Price).toLocaleString('vi-VN') + ` VNĐ `;
        } else if (parseInt(event.discount) > 0) {
            eventHtml += `<strong>Giá tour:</strong> ` + parseInt(event.discount).toLocaleString('vi-VN') + ` VNĐ - 
                          <del style="color:white">` + parseInt(event.Price).toLocaleString('vi-VN') + ` VNĐ</del>`;
        }

        eventHtml += `</div>
                    <center>`;

        if (parseInt(event.Orders) >= parseInt(event.Max_participant)) {
            eventHtml += '<span style="color:red">Lượt đặt đã hết</span>';
        } else {
            eventHtml += `<a href="index.php?dattour=${event.idtour}">
                            <button class="but" type="submit">Đặt tour</button>
                          </a>`;
        }

        eventHtml += `</center>
                </div>
            </div>
             
            <p class="ndo" style="color:black; font-size:20px;">
            <b>Thông tin tour</b><br><br>
                <b>Nội dung:</b>
                ${event.Description}<br>

                <b>Lịch trình:</b> <br>
                <span style="white-space:pre-line">${event.Itinerary}</span> 
               
            </p>`;

        $('#xemchitiet').html(eventHtml);
        checkWishlist(); // sau khi render xong mới gọi

    } else {
        $('#xemchitiet').html('Không tìm thấy tour với ID ' + idtour);
    }
}
,
        error: function (xhr, status, error) {
            console.error('Lỗi khi lấy tour:', error);
            $('#xemchitiet').html('Đã xảy ra lỗi khi tải thông tin tour.');
        }
    });
};


function xemdanhgia() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour1 = urlParams.get('xemdanhgiatour'); // Lấy ID từ URL
    $.ajax({
        url: './api/api.php?action=xemdanhgia&xemdanhgiatour=' + idtour1,
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '<h3>Đánh giá</h3>';
                events.forEach(function(event, index) {
                    eventHtml += `
                    
                        <div class="review" style="display: flex; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 10px; padding: 10px;">
                            <div style="flex: 1; border-right: 1px solid #ddd; padding-right: 10px;">
                                <p><strong>Tên:</strong> ${event.Username}</p>
                            </div>
                            <div class="danh" style="flex: 2; padding-left: 10px;">
                                <p><strong>Nội dung:</strong> ${event.Review}</p>
                                <p style="color:orange"><strong style="color:black">Đánh giá:</strong> ${'★'.repeat(event.Rating)}</p>
                                <p><strong>Ngày:</strong> ${event.Datetime || 'Không có thông tin ngày'}</p>
                            </div>
                        </div>
                    `;
                });
                $('#xemchitiet12').html(eventHtml);
            } else {
                $('#xemchitiet12').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemchitiet12').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
};

function goiYTours() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour = urlParams.get('idtour'); // Lấy ID từ URL

    $.ajax({
        url: './api/api.php?action=xemtourgoiy&idtour=' + idtour,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            let tourHtml = "";
            if (Array.isArray(response) && response.length > 0) {
                tourHtml += `<div class="row">`;
                response.forEach(function (tour) {
                    tourHtml += `
                        <div class="col-md-4">
                            <div class="card">
                                <img src="./assets/img/tour/${tour.Image}" class="card-img-top" alt="${tour.Name}">
                                <div class="card-body">
                                    <h5 class="card-title">${tour.Name}</h5>
                                    <p class="card-text">
                                        Giá: ${parseInt(tour.discount > 0 ? tour.discount : tour.Price).toLocaleString('vi-VN')} VNĐ<br>
                                        Phương tiện: ${tour.vehicle}<br>
                                        Thời gian: ${tour.timetour}
                                    </p>
                                    <center><a href="index.php?idtour=${tour.tourid}&xemdanhgiatour=${tour.tourid}&xemdanhgiarating=${tour.tourid}" class="btn btn-primary">
                                    Xem chi tiết</a></center>
                                </div>
                            </div>
                        </div>
                    `;
                });
                tourHtml += `</div>`;
            } else {
                tourHtml = "<p>Không có tour nào cùng tên.</p>";
            }
            $('#goiYTour').html(tourHtml);
        },
        error: function () {
            $('#goiYTour').html("<p>Lỗi khi tải danh sách tour gợi ý.</p>");
        }
    });
}

$(document).ready(function() {
    goiYTours();
    xemtourchitiet();
    xemdanhgia();
    xemdanhgiarating();
});

</script>