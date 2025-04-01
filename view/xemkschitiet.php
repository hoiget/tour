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
    gap: 50px;
}

.image img {
    width: 100%;
    height: 500px;
    border-radius: 8px;
}

.details {
    width: 40%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    height: 100%;
}
.details1 {
    background:black;
    color:red;
    text-align: center;
    height:50px;
    line-height: 50px;

}
.details h3 {
    margin-bottom: 15px;
    font-size: 18px;
    color: #333;
}

.details ul {
    list-style: none;
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


</style>
<main class="main-content">
    <a href="index.php?ks">Quay lại</a>
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
            <div id="xemchitietks12"></div>
            </div>
        </div>
    </div>
</div> <div id="xemchitietks123"></div>
           <div id="xemchitietks"></div>
        </main>
        <script>
function xemdanhgiaratingks() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour1 = urlParams.get('xemdanhgiaratingks'); // Lấy ID từ URL
    $.ajax({
        url: './api/api.php?action=xemdanhgiaratingks&xemdanhgiaratingks=' + idtour1,
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
                $('#xemchitietks123').html(eventHtml);
            } else {
                $('#xemchitietks123').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemchitietks123').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
};
  function xemkschitiet() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour = urlParams.get('idks'); // Lấy ID từ URL

    $.ajax({
      url: './api/api.php?action=xemkschitiet&idks=' + idtour,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        
        if (Array.isArray(response) && response.length > 0) {
          const event = response[0]; // Lấy phần tử đầu tiên
          let eventHtml = `
            <h2 style="color:black">${event.room_name || 'Tên phòng không có'}</h2>
           
            <div class="tour-details">
              <div class="image">
                <img src="./assets/img/ks/${event.Image || 'default.jpg'}" alt="" />
                <br><br><h2 style="color:black">Thông tin tiện ích phòng</h2>
                <p style="color:black;font-size:20px">${event.Description || 'Mô tả chưa có'}</p>
              </div>
              
              <div class="details">
                
                  <h3 style="color:black;font-size:20px">Chi tiết phòng</h3>
                  <ul>
                    <li><strong>Mã ks:</strong> ${event.idroom}</li>
                    <li><strong>Diện tích:</strong> ${event.Area}</li>
                    <li><strong>Người lớn:</strong> ${event.Adult} người</li>
                    <li><strong>Trẻ em:</strong> ${event.Children} người</li>
                    <li><strong>Địa điểm:</strong> ${event.Diadiem}</li>
                     <li><strong>Ngày nhận:</strong> ${event.Ngaynhan}</li>
                      <li><strong>Ngày trả:</strong> ${event.Ngaytra}</li>
                    <li><strong>Đặc điểm phòng:</strong> ${event.feature_name || 'Chưa có tính năng'}</li>
                    <li><strong>Tiện ích phòng:</strong> ${event.facility_name || 'Chưa có tiện nghi'}</li>
                  </ul>
                  <div class="details1">
                    <strong>Giá phòng:</strong> ${parseInt(event.Price).toLocaleString('vi-VN')} VNĐ
                  </div>
                  <center>`
                  if(event.Status == 'Hoạt động'){
                     eventHtml += `<a href="index.php?datks=${event.idroom}">
                        <button class="but" type="submit">Đặt phòng</button>
                    </a>`
                  }else{
                     eventHtml += ` `
                  }
                    
                 eventHtml += ` </center>
               
              </div>
            </div>`;
          $('#xemchitietks').html(eventHtml);
        } else {
          $('#xemchitietks').html('Không tìm thấy tour với ID ' + idtour);
        }
      },
      error: function (xhr, status, error) {
        console.error('Lỗi khi lấy tour:', error);
        $('#xemchitietks').html('Đã xảy ra lỗi khi tải thông tin tour.');
      }
    });
  }
  function xemdanhgiaks() {
    const urlParams = new URLSearchParams(window.location.search);
    const idtour1 = urlParams.get('xemdanhgiaks'); // Lấy ID từ URL
    $.ajax({
        url: './api/api.php?action=xemdanhgiaks&xemdanhgiaks=' + idtour1,
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
                $('#xemchitietks12').html(eventHtml);
            } else {
                $('#xemchitietks12').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemchitietks12').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
};

  $(document).ready(function() {
    xemkschitiet();
    xemdanhgiaks();
    xemdanhgiaratingks();
  });
</script>
