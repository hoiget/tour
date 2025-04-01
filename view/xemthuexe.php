  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container45{
height: auto;
        }
        ul li a {
    text-decoration: none !important;
}
a{
    text-decoration: none !important;
}
ul li a:hover {
    text-decoration: none !important;
}

    </style>
    <div class="container45 mt-4">
        <center><h2>Danh sách Thuê Xe</h2></center>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>SĐT</th>
                    <th>Loại xe</th>
                    <th>Tài xế</th>
                    <th>Thời gian đón</th>
                    <th>Điểm đón</th>
                    <th>Điểm trả</th>
                    <th>Gía tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody id="rentalsTable">
                <!-- Dữ liệu sẽ được AJAX tải vào đây -->
            </tbody>
        </table>
    </div>
    <script>
           function loadRentals(){
    $.ajax({
        url: './api/api.php?action=xemxethue',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                     <tr>
                                <td>${event.rental_id}</td>
                                <td>${event.customer_name}</td>
                                <td>${event.customer_phone}</td>
                                <td>Xe khách ${event.typeren}</td>
                                <td>${event.name || 'Tự lái'}</td>
                                <td>${event.pickup_time}</td>
                                <td>${event.pickup_location}</td>
                                <td>${event.dropoff_location}</td>
                                <td>${event.gia}</td>
                               
                               
                           
                  
                    `;
                if(event.Trangthai == 0)
                {
                    eventHtml +=`<td style="color:red">Chưa xác nhận</td> </tr>`;
                }else if(event.Trangthai == 1){
                    eventHtml +=`<td style="color:green">Đã xác nhận</td> </tr>
                    `;
                }                   
                    
                });
                $('#rentalsTable').html(eventHtml);
            } else {
                $('#rentalsTable').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#rentalsTable').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
    $(document).ready(function() {
      
        loadRentals();
    });
    </script>