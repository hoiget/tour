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
    gap: 20px; /* Giảm khoảng cách giữa ảnh và bảng chi tiết */
    justify-content: space-between; /* Cân chỉnh các phần tử bên trong */
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
h3,p{
    color:black;
}
.goiy{
    color:blue;
    
}
.card-img-top{
    width: 100%;
    height: 300px;
}
</style>
<main class="main-content">

    <a href="indexa.php?tour">Quay lại</a>
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
                let eventHtml = `
                    <h2 style="color:black">${event.Name}</h2>
                    
                    <div class="tour-details">
                        <div class="image">
                            <img src="./assets/img/tour/${event.Image}" alt="Tour du lịch" />
                            <br><br><h2 style="color:black">Thông tin tour</h2>
                       
                        </div>
                        <div class="details">
                            <h3 style="color:black;font-size:20px">Chi tiết Tour</h3>
                            <ul>
                                <li><strong>Mã tour:</strong> ${event.idtour}</li>
                                <li><strong>Kiểu tour:</strong> ${event.Style}</li>
                                <li><strong>Số người tham gia:</strong> ${event.Max_participant} (tối thiểu: ${event.Min_participant} người)</li>
                                <li><strong>Thời gian:</strong> ${event.timetour}</li>
                                <li><strong>Khởi hành:</strong> ${event.Depart} (${event.Orders || '0'} lượt đặt)</li>
                                <li><strong>Phương tiện:</strong> ${event.vehicle}</li>
                                <li><strong>Xuất phát:</strong> ${event.DepartureLocation}</li>
                                <li><strong>Lịch trình:</strong> ${event.Itinerary}</li>
                            </ul>
                            <div class="details1">`
                            if (parseInt(event.discount)==0) {
                                eventHtml+= `<strong>Giá tour:</strong> `+ parseInt(event.Price).toLocaleString('vi-VN') + ` VNĐ `
                            }else if(parseInt(event.discount) > 0){
                             eventHtml+=`
                                <strong>Giá tour:</strong> `+ parseInt(event.discount).toLocaleString('vi-VN') + ` VNĐ - 
                                <del style="color:white">`+ parseInt(event.Price).toLocaleString('vi-VN') + ` VNĐ</del>
                            `}
                            eventHtml+=`
                            </div>
                            <center>
                            `
                            
                                if (parseInt(event.Orders) >= parseInt(event.Max_participant)) {
                               
                               eventHtml +='<span style="color:red">Lượt đặt đã hết</span>'
                           }else{
                               eventHtml += ` <a href="indexa.php?dattour=${event.idtour}">
                                   <button class="but" type="submit">Đặt tour</button>
                               </a>`
                           }
                         
                              eventHtml += `
                            </center>
                        
                        </div>
                    </div>
                    <p style="color:black; font-size:20px; white-space: pre-line;">
                        ${event.Itinerary}
                        ${event.Description}
                        </p>`;

                // Load đánh giá của tour
             
                $('#xemchitiet').html(eventHtml);
            } else {
                $('#xemchitiet').html('Không tìm thấy tour với ID ' + idtour);
            }
        },
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
                            <div style="flex: 2; padding-left: 10px;">
                                <p><strong>Nội dung:</strong> ${event.Review}</p>
                                <p><strong>Đánh giá:</strong> ${'★'.repeat(event.Rating)}</p>
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
                                    Xem cho tiết</a></center>
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
    xemtourchitiet();
    xemdanhgia();
    xemdanhgiarating();
    goiYTours();
});

</script>