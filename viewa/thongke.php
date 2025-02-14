<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }
        #thongke,#thongke1,#thongkeks,#thongkeks1 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }
        .card p {
            font-size: 16px;
            margin: 0;
        }
        .card.green {
            border-left: 5px solid #4caf50;
        }
        .card.red {
            border-left: 5px solid #f44336;
        }
        .card.blue {
            border-left: 5px solid #2196f3;
        }
        .card.orange {
            border-left: 5px solid #ff9800;
        }
        .dropdown {
            margin: 20px 0;
            text-align: right;
        }
        select {
            padding: 5px;
            font-size: 16px;
        }
    </style>
<!-- Tour -->
    <div class="container">
        <div class="section-title">TOUR</div>
        <div class="grid">
          <div id="thongke"></div>
        </div>

        <div class="section-title">Dữ liệu đơn đặt Tour</div>
        <div class="dropdown">
    <label for="year">Chọn năm:</label>
    <select id="year">
        <option value="2025">2025</option>
        <option value="2024">2024</option>
    </select>

    <label for="month">Chọn tháng:</label>
    <select id="month">
        <option value="" disabled selected>Tất cả</option>
        <option value="1">Tháng 1</option>
        <option value="2">Tháng 2</option>
        <!-- Các tháng khác -->
    </select>
    <button onclick="applyFilter()">Tìm kiếm</button>
</div>



<script>
    function applyFilter() {
        const year = document.getElementById('year').value;
        const month = document.getElementById('month').value;
        getBookingStats(year, month);
    }
</script>
        <div class="grid">
           <div id="thongke1"></div>
        </div>
    </div>
    <div style="width: 50%; margin: auto;">
        <h2>Biểu đồ tỉ lệ đơn đặt tour</h2>
        <canvas id="bookingChart"></canvas>
    </div>

<!-- Room -->
    <div class="container">
        <div class="section-title">ROOM</div>
        <div class="grid">
          <div id="thongkeks"></div>
        </div>

      
        <div class="dropdown">
    <label for="year">Chọn năm:</label>
    <select id="year1">
        <option value="2025">2025</option>
        <option value="2024">2024</option>
    </select>

    <label for="month">Chọn tháng:</label>
    <select id="month1">
        <option value="" disabled selected>Tất cả</option>
        <option value="1">Tháng 1</option>
        <option value="2">Tháng 2</option>
        <!-- Các tháng khác -->
    </select>
    <button onclick="applyFilter1()">Tìm kiếm</button>
</div>
<script>
    function applyFilter1() {
        const year = document.getElementById('year1').value;
        const month = document.getElementById('month1').value;
        getBookingStatsks(year, month);
    }
</script>


<div class="section-title">Dữ liệu đơn đặt phòng</div>        
<div class="grid">
           <div id="thongkeks1"></div>
        </div>
    </div>
    <div style="width: 50%; margin: auto;">
        <h2>Biểu đồ tỉ lệ đơn đặt phòng</h2>
        <canvas id="bookingChartnew"></canvas>
    </div>

    <?php
     if(isset($_SESSION['Admin_name'])){
        echo""; }
    elseif($role == 'QL' || $role == 'CSKH'){
    
    
    ?>
      <div class="section-title">Tổng user</div>
    <div class="grid">
          <div id="thongkeuser"></div>
    </div>
    <?php }?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function thongke() {
    $.ajax({
        url: './api/apia.php?action=get_thongke',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                events.forEach(function(event) {
                    eventHtml += `
                     <div class="card green">
                <h3>Tổng tour</h3>
                <p>${event.total_tours}</p>
            </div>
            <div class="card red">
                <h3>Tour hoạt động</h3>
                <p>${event.total_active}</p>
            </div>
            <div class="card blue">
                <h3>Tour tạm ngừng</h3>
                <p>${event.total_inactive}</p>
            </div>
            <div class="card orange">
                <h3>Đánh giá</h3>
                <p>${event.total_reviews}</p>
            </div>
                  
`;
                });
                $('#thongke').html(eventHtml);
            } else {
                $('#thongke').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
    console.error('Lỗi khi lấy thông tin:', error);
    console.error('Chi tiết:', xhr.responseText);
    $('#thongke').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
}

    });
    }

    function thongkeks() {
    $.ajax({
        url: './api/apia.php?action=get_thongkeks',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                events.forEach(function(event) {
                    eventHtml += `
                     <div class="card green">
                <h3>Tổng tour</h3>
                <p>${event.total_rooms}</p>
            </div>
            <div class="card red">
                <h3>Tour hoạt động</h3>
                <p>${event.total_active}</p>
            </div>
            <div class="card blue">
                <h3>Tour tạm ngừng</h3>
                <p>${event.total_inactive}</p>
            </div>
            <div class="card orange">
                <h3>Đánh giá</h3>
                <p>${event.total_reviews}</p>
            </div>
                  
`;
                });
                $('#thongkeks').html(eventHtml);
            } else {
                $('#thongkeks').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
    console.error('Lỗi khi lấy thông tin:', error);
    console.error('Chi tiết:', xhr.responseText);
    $('#thongkeks').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
}

    });
}
function formatNumberWithDot(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function getBookingStats1() {
    $.ajax({
        url: './api/apia.php?action=get_booking_stats1',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                events.forEach(function(event) {
                    eventHtml += `
                <div class="card green">
                <h3>Tổng đơn</h3>
                <p>${event.total_orders}<br>${formatNumberWithDot(event.total_amount)} đ</p>
            </div>
            <div class="card orange">
                <h3>Đơn đặt mới</h3>
                <p>${event.new_orders_today}<br>${formatNumberWithDot(event.new_orders_amount)} đ</p>
            </div>
            <div class="card blue">
                <h3>Đơn đã duyệt</h3>
                <p>${event.approved_orders}<br>${formatNumberWithDot(event.approved_orders_amount)} đ</p>
            </div>
            <div class="card red">
                <h3>Đơn đã hủy</h3>
                <p>${event.cancelled_orders}<br>${formatNumberWithDot(event.cancelled_orders_amount)} đ</p>
            </div>
            `;
                });
                $('#thongke1').html(eventHtml);
            } else {
                $('#thongke1').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
    console.error('Lỗi khi lấy thông tin:', error);
    console.error('Chi tiết:', xhr.responseText);
    $('#thongke1').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
}

    });
}
function getBookingStats(year, month = null) {
    let url = `./api/apia.php?action=get_booking_stats&year=${year}`;
    if (month) {
        url += `&month=${month}`;
    }
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                events.forEach(function(event) {
                    eventHtml += `
                <div class="card green">
                <h3>Tổng đơn</h3>
                <p>${event.total_orders}<br>${formatNumberWithDot(event.total_amount)} đ</p>
            </div>
            <div class="card orange">
                <h3>Đơn đặt mới</h3>
                <p>${event.new_orders_today}<br>${formatNumberWithDot(event.new_orders_amount)} đ</p>
            </div>
            <div class="card blue">
                <h3>Đơn đã duyệt</h3>
                <p>${event.approved_orders}<br>${formatNumberWithDot(event.approved_orders_amount)} đ</p>
            </div>
            <div class="card red">
                <h3>Đơn đã hủy</h3>
                <p>${event.cancelled_orders}<br>${formatNumberWithDot(event.cancelled_orders_amount)} đ</p>
            </div>
            `;
                });
                $('#thongke1').html(eventHtml);
            } else {
                console.log('Không có dữ liệu thống kê');
            }
        },
        error: function(xhr, status, error) {
    console.error('Lỗi khi lấy thông tin:', error);
    console.error('Chi tiết:', xhr.responseText);
    $('#thongke1').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
}
    });
}

function getBookingStatsks1() {
    $.ajax({
        url: './api/apia.php?action=get_booking_statsks1',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                events.forEach(function(event) {
                    eventHtml += `
                <div class="card green">
                <h3>Tổng đơn</h3>
                <p>${event.total_orders}<br>${formatNumberWithDot(event.total_amount)} đ</p>
            </div>
            <div class="card orange">
                <h3>Đơn đặt mới</h3>
                <p>${event.new_orders_today}<br>${formatNumberWithDot(event.new_orders_amount)} đ</p>
            </div>
            <div class="card blue">
                <h3>Đơn đã duyệt</h3>
                <p>${event.approved_orders}<br>${formatNumberWithDot(event.approved_orders_amount)} đ</p>
            </div>
            <div class="card red">
                <h3>Đơn đã hủy</h3>
                <p>${event.cancelled_orders}<br>${formatNumberWithDot(event.cancelled_orders_amount)} đ</p>
            </div>
            `;
                });
                $('#thongkeks1').html(eventHtml);
            } else {
                $('#thongkeks1').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
    console.error('Lỗi khi lấy thông tin:', error);
    console.error('Chi tiết:', xhr.responseText);
    $('#thongkeks1').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
}

    });
}
function getBookingStatsks(year, month = null) {
    let url = `./api/apia.php?action=get_booking_statsks&year1=${year}`;
    if (month) {
        url += `&month1=${month}`;
    }
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                events.forEach(function(event) {
                    eventHtml += `
                <div class="card green">
                <h3>Tổng đơn</h3>
                <p>${event.total_orders}<br>${formatNumberWithDot(event.total_amount)} đ</p>
            </div>
            <div class="card orange">
                <h3>Đơn đặt mới</h3>
                <p>${event.new_orders_today}<br>${formatNumberWithDot(event.new_orders_amount)} đ</p>
            </div>
            <div class="card blue">
                <h3>Đơn đã duyệt</h3>
                <p>${event.approved_orders}<br>${formatNumberWithDot(event.approved_orders_amount)} đ</p>
            </div>
            <div class="card red">
                <h3>Đơn đã hủy</h3>
                <p>${event.cancelled_orders}<br>${formatNumberWithDot(event.cancelled_orders_amount)} đ</p>
            </div>
            `;
                });
                $('#thongkeks1').html(eventHtml);
            } else {
                console.log('Không có dữ liệu thống kê');
            }
        },
        error: function(xhr, status, error) {
    console.error('Lỗi khi lấy thông tin:', error);
    console.error('Chi tiết:', xhr.responseText);
    $('#thongkeks1').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
}
    });
}

    
        function getBookingStats2() {
            fetch('./api/apia.php?action=bieudo')
                .then(response => response.json())
                .then(data => {
                    // Chạy hàm vẽ biểu đồ
                    drawChart(data);
                })
                .catch(error => {
                    console.error('Lỗi khi lấy thống kê:', error);
                });
        }

        // Hàm vẽ biểu đồ
        function drawChart(data) {
    var ctx = document.getElementById('bookingChart').getContext('2d');
    var bookingChart = new Chart(ctx, {
        type: 'pie', // Chọn loại biểu đồ, ví dụ pie chart
        data: {
            labels: ['Đơn đặt mới', 'Đơn đã duyệt', 'Đơn đã hủy'],
            datasets: [{
                label: 'Tỉ lệ đơn đặt tour',
                data: [
                    data.new_orders,  // Đơn đặt mới
                    data.approved_orders,  // Đơn đã duyệt
                    data.cancelled_orders  // Đơn đã hủy
                ],
                backgroundColor: ['#4caf50', '#2196f3', '#f44336'],
                borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var dataset = tooltipItem.dataset;
                            // Tính tổng số đơn
                            var total = dataset.data.reduce((sum, value) => sum + value, 0);
                            // Tính phần trăm
                            var percentage = (tooltipItem.raw / total * 100).toFixed(2);
                            return tooltipItem.raw + ' đơn (' + percentage + '%)';
                            
                        }
                    }
                }
            }
        }
    });
}

function getBookingStatsks2() {
            fetch('./api/apia.php?action=bieudoks')
                .then(response => response.json())
                .then(data => {
                    // Chạy hàm vẽ biểu đồ
                    drawChart1(data);
                })
                .catch(error => {
                    console.error('Lỗi khi lấy thống kê:', error);
                });
        }

        // Hàm vẽ biểu đồ
        function drawChart1(data) {
    var ctx = document.getElementById('bookingChartnew').getContext('2d');
    var bookingChart = new Chart(ctx, {
        type: 'pie', // Chọn loại biểu đồ, ví dụ pie chart
        data: {
            labels: ['phòng đặt mới', 'phòng đã duyệt', 'phòng đã hủy'],
            datasets: [{
                label: 'Tỉ lệ đơn đặt phòng',
                data: [
                    data.new_orders,  // Đơn đặt mới
                    data.approved_orders,  // Đơn đã duyệt
                    data.cancelled_orders  // Đơn đã hủy
                ],
                backgroundColor: ['#4caf50', '#2196f3', '#f44336'],
                borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var dataset = tooltipItem.dataset;
                            // Tính tổng số đơn
                            var total = dataset.data.reduce((sum, value) => sum + value, 0);
                            // Tính phần trăm
                            var percentage = (tooltipItem.raw / total * 100).toFixed(2);
                            return tooltipItem.raw + ' phòng (' + percentage + '%)';
                            
                        }
                    }
                }
            }
        }
    });
        };

        function thongkeuser() {
    $.ajax({
        url: './api/apia.php?action=xemuser',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
          
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                events.forEach(function(event) {
                    eventHtml += `
                     <div class="card green">
                <h3>Tổng user</h3>
                <p>${event.total_user}</p>
            </div>
           
                  
`;
                });
                $('#thongkeuser').html(eventHtml);
            } else {
                $('#thongkeuser').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
    console.error('Lỗi khi lấy thông tin:', error);
    console.error('Chi tiết:', xhr.responseText);
    $('#thongkeuser').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
}

    });
    }
$(document).ready(function() {
       thongkeks();
      thongke();
      getBookingStats();
      getBookingStatsks();
      getBookingStats1();
      getBookingStatsks1();
      getBookingStats2();
      getBookingStatsks2();
      thongkeuser();
   });
</script>
