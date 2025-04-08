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
        a{
            text-decoration: none;
            color: black;
            font-size: 20px;
            margin: 10px;
            text-align: center;
        }   #locationChart {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    margin: auto;      /* Căn giữa */
}
#permissionChart{
  
    margin:auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
   }
   .xuat {
    background-color: #007bff;
    color: white;
    font-size: 16px;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: background 0.3s, transform 0.2s;
}

.xuat:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.xuat:active {
    transform: scale(0.95);
}

/* Hiệu ứng sóng lan tỏa khi nhấp chuột */
.xuat::after {
    content: "";
    position: absolute;
    width: 300%;
    height: 300%;
    top: 50%;
    left: 50%;
    background: rgba(255, 255, 255, 0.3);
    transition: transform 0.6s, opacity 0.6s;
    transform: translate(-50%, -50%) scale(0);
    border-radius: 50%;
    opacity: 0;
}

.xuat:active::after {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
    transition: transform 0.3s, opacity 0.3s;
}

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <center><a href="#tour">Tour</a>
    <a href="#ks">Khách sạn</a>
<a href="#khachang">Khách hàng</a>
<a href="#nhanvien">Nhân viên</a>
<button class="xuat" onclick="exportToPDF()">Xuất PDF</button>



</center>
<!-- Tour -->
    <div class="container" id="tour">
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
        <option value="" selected>Tất cả</option>
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
        <!-- Các tháng khác -->
    </select>
    <label for="vung">Chọn vùng miền:</label>
    <select id="vung">
        <option value=""  selected>Tất cả</option>
        <option value="Nam">Miền Nam</option>
        <option value="Trung">Miền Trung</option>
        <option value="Bắc">Miền Bắc</option>
        <option value="Tây">Miền Tây</option>
        <option value="Ngoài nước">Nước ngoài</option>
        
        <!-- Các tháng khác -->
    </select>
    <button onclick="applyFilter()">Tìm kiếm</button>
</div>



<script>
   function applyFilter() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;
    const vung = document.getElementById('vung').value; // Lấy giá trị vùng miền

    getBookingStats(year, month, vung); // Gửi thêm tham số `vung`
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
<hr>
<!-- Room -->
    <div class="container" id="ks">
        <div class="section-title" >ROOM</div>
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

   <hr>
<!-- Khách hàng -->
<div class="container" id="khachang">
<div class="section-title" >Khách hàng</div>
<div class="card green">
              
<h2>Tổng số khách hàng: <span id="totalCustomers">0</span></h2>
            </div>

<canvas id="ageChart" width="400" height="200"></canvas>
<center><b>Biểu đồ cột thể hiện theo độ tuổi khách hàng</b></center> <br>
<canvas id="locationChart" width="400" height="200"></canvas>
<center><b>Biểu đồ tròn thống kê các khu vực của khách hàng</b></center> <br>

</div>

<hr>
<!-- Nhân viên -->
<div class="container" id="nhanvien">
<div class="section-title" >Nhân viên</div>
<div class="grid">
<div class="card green">
                <h3>Tổng số nhân viên</h3>
                <p><span id="totalEmployees">0</span></p>
            </div>
            <div class="card red">
                <h3>Nhân viên mới</h3>
                <p><span id="newEmployees">0</span></p>
            </div>
            <div class="card blue">
                <h3>Nhân viên cũ</h3>
                <p><span id="oldEmployees">0</span></p>
            </div>
</div>


           <div id="thongkenv1"></div>

<!-- Biểu đồ -->
<canvas id="permissionChart" ></canvas>
<center><b>Biểu đồ tròn thống kê các vai trò của nhân viên</b></center> <br>
<canvas id="yearlyChart" ></canvas>
<center><b>Biểu cột thống kê các nhân viên đã tuyển theo từng năm</b></center> <br>
</div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
      document.addEventListener("DOMContentLoaded", function () {
    fetch("./api/phancong.php?action=thong")
        .then(response => response.json())
        .then(data => {
            // Hiển thị tổng số khách hàng
            document.getElementById("totalCustomers").textContent = data.total_customers;

            // Biểu đồ cột - Độ tuổi
            const ctxAge = document.getElementById("ageChart").getContext("2d");
            new Chart(ctxAge, {
                type: "bar",
                data: {
                    labels: Object.keys(data.age_groups),
                    datasets: [{
                        label: "Số khách hàng",
                        data: Object.values(data.age_groups),
                        backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0"]
                    }]
                }
            });

            // Biểu đồ tròn - Khu vực
            const ctxLocation = document.getElementById("locationChart").getContext("2d");
            new Chart(ctxLocation, {
                type: "pie",
                data: {
                    labels: Object.keys(data.location_data),
                    datasets: [{
                        data: Object.values(data.location_data),
                        backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"]
                    }]
                }
            });
        })
        fetch("./api/phancong.php?action=thongnv")
        .then(response => response.json())
        .then(data => {
            // Hiển thị số lượng nhân viên
            document.getElementById("totalEmployees").textContent = data.total_employees;
            document.getElementById("newEmployees").textContent = data.new_employees;
            document.getElementById("oldEmployees").textContent = data.old_employees;

            // Biểu đồ tròn - Phân quyền
            const ctxPermission = document.getElementById("permissionChart").getContext("2d");
            new Chart(ctxPermission, {
                type: "pie",
                data: {
                    labels: Object.keys(data.permission_count),
                    datasets: [{
                        data: Object.values(data.permission_count),
                        backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
                    }]
                }
            });

            // Biểu đồ cột - Nhân viên tuyển theo năm
            const ctxYearly = document.getElementById("yearlyChart").getContext("2d");
            new Chart(ctxYearly, {
                type: "bar",
                data: {
                    labels: Object.keys(data.yearly_hiring),
                    datasets: [{
                        label: "Số nhân viên tuyển",
                        data: Object.values(data.yearly_hiring),
                        backgroundColor: "#36A2EB"
                    }]
                }
            });
        })
        .catch(error => console.error("Lỗi tải dữ liệu:", error));
});

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
    function thongkenv1() {
    $.ajax({
        url: './api/apia.php?action=thongkenv1',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("Dữ liệu API trả về:", response);

            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = ''; 
                eventHtml +='<div class="grid">';
                events.forEach(function(event) {
            if(event.status == 'V'){
                eventHtml += `

                        <div class="card green">
                            <h3>Nhân viên đang làm</h3>
                            <p>${event.total}</p>
                        </div> `
            }
            if(event.status == 'X'){
                eventHtml += `

                        <div class="card red">
                            <h3>Nhân viên nghỉ không phép</h3>
                            <p>${event.total}</p>
                        </div> `
            }
            if(event.status == 'P'){
                eventHtml += `

                        <div class="card blue">
                             <h3>Nhân viên nghỉ có phép</h3>
                            <p>${event.total}</p>
                        </div> `
            }
                   
                });
                eventHtml +='</div>';
                $('#thongkenv1').html(eventHtml);
            } else {
                $('#thongkenv1').html('<div class="col">Không có dữ liệu thống kê.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            console.error('Chi tiết:', xhr.responseText);
            $('#thongkenv1').html('<div class="col">Đã xảy ra lỗi khi tải dữ liệu.</div>');
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
                <h3>Tổng phòng</h3>
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
function getBookingStats(year, month = null,vung = null) {
    let url = `./api/apia.php?action=get_booking_stats&year=${year}`;
    if (month) {
        url += `&month=${month}`;
    }
    if (vung) {
        url += `&vung=${vung}`;
    }
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let eventHtml = ''; 

            if (Array.isArray(response) && response.length > 0) {
                let event = response[0]; // Chỉ lấy dữ liệu đầu tiên nếu có
                eventHtml = `
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
            } else {
                // Nếu không có dữ liệu, hiển thị 0
                eventHtml = `
                    <div class="card green">
                        <h3>Tổng đơn</h3>
                        <p>0<br>0 đ</p>
                    </div>
                    <div class="card orange">
                        <h3>Đơn đặt mới</h3>
                        <p>0<br>0 đ</p>
                    </div>
                    <div class="card blue">
                        <h3>Đơn đã duyệt</h3>
                        <p>0<br>0 đ</p>
                    </div>
                    <div class="card red">
                        <h3>Đơn đã hủy</h3>
                        <p>0<br>0 đ</p>
                    </div>
                `;
            }

            // Cập nhật nội dung trên giao diện
            $('#thongke1').html(eventHtml);
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            console.error('Chi tiết:', xhr.responseText);
            $('#thongke1').html('<div class="col">Đã xảy ra lỗi khi tải thông tin.</div>');
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
      thongkenv1();
   });
</script>
<script>
async function exportToPDF() {
    const { jsPDF } = window.jspdf;
    let doc = new jsPDF('p', 'mm', 'a4');

    // Chụp từng phần nội dung
    let elements = ['tour','bookingChart', 'ks','bookingChartnew', 'khachang', 'nhanvien'];
    let yOffset = 10; // Khoảng cách giữa các phần

    for (let id of elements) {
        let element = document.getElementById(id);
        if (!element) continue;

        let canvas = await html2canvas(element, { scale: 2 });
        let imgData = canvas.toDataURL('image/png');
        
        let imgWidth = 190; // Giới hạn theo chiều rộng A4
        let imgHeight = (canvas.height * imgWidth) / canvas.width; 

        if (yOffset + imgHeight > 290) { // Nếu trang không đủ chỗ, tạo trang mới
            doc.addPage();
            yOffset = 10;
        }
        doc.addImage(imgData, 'PNG', 10, yOffset, imgWidth, imgHeight);
        yOffset += imgHeight + 10; // Cách dòng giữa các phần
    }

    doc.save("ThongKe.pdf"); // Lưu file PDF
}
</script>
