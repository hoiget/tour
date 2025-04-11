<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
     <style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2ecc71;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --info-color: #9b59b6;
        --dark-color: #34495e;
        --light-color: #ecf0f1;
        --text-color: #2c3e50;
        --border-radius: 12px;
        --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f7fa;
        color: var(--text-color);
        line-height: 1.6;
    }

    .container {
        width: 90%;
        max-width: 1400px;
        margin: 30px auto;
        padding: 25px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .section-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 25px;
        color: var(--dark-color);
        position: relative;
        padding-bottom: 10px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    .grid {
        display: grid;
       
        gap: 25px;
        margin-bottom: 30px;
        grid-template-columns: 1fr 1fr;
        
    }
   

    #thongke, #thongke1, #thongkeks, #thongkeks1,#thongkenvv {
        display: grid;
   
        gap: 25px;
        grid-template-columns: 1fr 1fr;
    }
    #locationChart,
    #permissionChart,#ageChart,#yearlyChart{
        display: grid;
        gap: 25px;
        grid-template-columns: 1fr 1fr;
   
    }
    #thongke,#thongkeks,#thongkenvv{
        border-right:2px solid black;
        padding-right:20px;
    }

    .card {
        background: white;
        padding: 25px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        text-align: center;
        transition: var(--transition);
        border-top: 4px solid transparent;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .card h3 {
        margin: 15px 0;
        font-size: 18px;
        color: var(--dark-color);
        font-weight: 600;
    }

    .card p {
        font-size: 24px;
        margin: 0;
        font-weight: 700;
    }

    .card.green {
        border-top-color: var(--secondary-color);
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.1), rgba(46, 204, 113, 0.05));
    }

    .card.red {
        border-top-color: var(--danger-color);
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.1), rgba(231, 76, 60, 0.05));
    }

    .card.blue {
        border-top-color: var(--primary-color);
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(52, 152, 219, 0.05));
    }

    .card.orange {
        border-top-color: var(--warning-color);
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(243, 156, 18, 0.05));
    }

    .card.purple {
        border-top-color: var(--info-color);
        background: linear-gradient(135deg, rgba(155, 89, 182, 0.1), rgba(155, 89, 182, 0.05));
    }

    .dropdown {
        margin: 30px 0;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }

    .dropdown label {
        font-weight: 600;
        color: var(--dark-color);
    }

    select {
        padding: 10px 15px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        background-color: white;
        transition: var(--transition);
    }

    select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    button {
        padding: 10px 20px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: var(--transition);
        color:black;
    }

    button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    a {
        text-decoration: none;
        color: var(--text-color);
        font-size: 18px;
        font-weight: 600;
        margin: 0 15px;
        padding: 10px 15px;
        border-radius: var(--border-radius);
        transition: var(--transition);
        position: relative;
    }

    a:hover {
        color: var(--primary-color);
    }

    a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: var(--primary-color);
        transition: var(--transition);
    }

    a:hover::after {
        width: 100%;
    }

   

    .xuat {
        background: linear-gradient(135deg, var(--primary-color), #1abc9c);
        color: white;
        font-size: 16px;
        font-weight: 600;
        padding: 12px 28px;
        border: none;
        border-radius: var(--border-radius);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        margin: 20px 0;
        color:black;
    }

    .xuat:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
    }

    .xuat:active {
        transform: translateY(1px);
    }

    .xuat::after {
        content: "";
        position: absolute;
        width: 300%;
        height: 300%;
        top: 50%;
        left: 50%;
        background: rgba(255, 255, 255, 0.2);
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

    hr {
        border: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #ddd, transparent);
        margin: 50px 0;
    }

    /* Chart containers */
    .chart-container {
        background: white;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin: 40px auto;
        max-width: 800px;
    }

    .chart-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: var(--dark-color);
        font-size: 22px;
    }
    @media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 15px;
    }

    .grid,
    #thongke,
    #thongke1,
    #thongkeks,
    #thongkeks1,
    #thongkenvv {
        grid-template-columns: 1fr !important;
        padding-right: 0;
        border-right: none;
    }

    .section-title {
        font-size: 22px;
        text-align: center;
    }

    .dropdown {
        flex-direction: column;
        align-items: flex-start;
    }

    button, .xuat {
        width: 100%;
        text-align: center;
    }

    a {
        display: inline-block;
        margin: 10px 0;
        padding: 8px 12px;
    }

    .chart-container {
        padding: 20px;
        margin: 20px auto;
        max-width: 100%;
    }

    #locationChart,
    #permissionChart,#ageChart,#yearlyChart {
        grid-template-columns: 1fr !important;
       
    }
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
    <div class="tour-header">
        <div class="tour-title">TOUR</div>
        
        <div class="tour-search">
            <div class="dropdown">
                <label for="year">Năm:</label>
                <select id="year">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>

                <label for="month">Tháng:</label>
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
                
                <label for="vung">Vùng:</label>
                <select id="vung">
                    <option value="" selected>Tất cả</option>
                    <option value="Nam">Miền Nam</option>
                    <option value="Bắc">Miền Bắc</option>
                    <option value="Trung">Miền Trung</option>
                    <option value="Tây">Miền Tây</option>
                    <option value="Ngoài nước">Ngoài nước</option>
                  
                    <!-- Các vùng khác -->
                </select>
                
                <button onclick="applyFilter()">Lọc</button>
            </div>
        </div>
        
    
    </div>

    <div class="grid">
        <div id="thongke"></div>
       
        <div id="thongke1"></div>
    </div>
   
    <div style="width: 50%; margin: auto;">
        <h2>Biểu đồ tỉ lệ đơn đặt tour</h2>
        <canvas id="bookingChart"></canvas>
    </div>
</div>
<script>
   function applyFilter() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;
    const vung = document.getElementById('vung').value; // Lấy giá trị vùng miền

    getBookingStats(year, month, vung); // Gửi thêm tham số `vung`
}

</script>
      
    
<hr>
<!-- Room -->
    <div class="container" id="ks">
        <div class="section-title" >ROOM</div>
        

      
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

<div class="grid">
          <div id="thongkeks"></div>
          <div id="thongkeks1"></div>
</div>
<div style="width: 50%; margin: auto;">
        <h2>Biểu đồ tỉ lệ đơn đặt phòng</h2>
        <canvas id="bookingChartnew"></canvas>
</div>
</div>
   

   <hr>
<!-- Khách hàng -->
<div class="container" id="khachang">
<div class="section-title" >Khách hàng</div>
<div class="card green">
              
<h2>Tổng số khách hàng: <span id="totalCustomers">0</span></h2>
            </div>

<div class="grid" style="width: 60%; margin: auto;">
    <div id="cot">
    <canvas id="ageChart" height=300></canvas>
    <center><b>Biểu đồ cột thể hiện theo độ tuổi khách hàng</b></center> <br>
    </div>
    <div id="tron">
    <canvas id="locationChart"></canvas>
    <center><b>Biểu đồ tròn thống kê các khu vực của khách hàng</b></center> <br>

    </div>
</div>

</div>

<hr>
<!-- Nhân viên -->
<div class="container" id="nhanvien">
<div class="section-title" >Nhân viên</div>
<div class="grid">
    <div id="thongkenvv">
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
</div>


         

<!-- Biểu đồ -->
<div class="grid" style="width: 60%; margin: auto;">
<div id="cot"><canvas id="yearlyChart" height=300></canvas>
<center><b>Biểu cột thống kê các nhân viên đã tuyển theo từng năm</b></center> <br></div>
    <div id="tron">
        
    <canvas id="permissionChart" ></canvas>
    <center><b>Biểu đồ tròn thống kê các vai trò của nhân viên</b></center> <br>
    </div>
   


</div>


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
    const doc = new jsPDF('p', 'mm', 'a4');

    const elements = ['tour', 'cot','tron', 'ks', 'khachang', 'nhanvien'];
    const pageHeight = 297;
    const margin = 10;
    const pdfWidth = 160;
    let yOffset = margin;

    for (let id of elements) {
        const element = document.getElementById(id);
        if (!element) continue;

        // Fix: thu nhỏ element trước khi chụp
        const originalWidth = element.style.width;
        element.style.width = "700px"; // ép width nhỏ lại trước khi chụp

        const canvas = await html2canvas(element, { scale: 2 });

        element.style.width = originalWidth; // khôi phục lại sau khi chụp

        const imgData = canvas.toDataURL('image/png');

        const imgProps = {
            width: canvas.width,
            height: canvas.height
        };

        const imgHeightInPDF = (imgProps.height * pdfWidth) / imgProps.width;
        const imgX = (210 - pdfWidth) / 2;

        let position = 0;
        let remainingHeight = imgProps.height;

        while (remainingHeight > 0) {
            const sliceHeight = Math.min(remainingHeight, (pageHeight - yOffset - margin) * (imgProps.width / pdfWidth));

            const pageCanvas = document.createElement('canvas');
            pageCanvas.width = imgProps.width;
            pageCanvas.height = sliceHeight;
            const ctx = pageCanvas.getContext('2d');
            ctx.drawImage(canvas, 0, position, imgProps.width, sliceHeight, 0, 0, imgProps.width, sliceHeight);

            const pageImgData = pageCanvas.toDataURL('image/png');
            const sliceHeightMm = (sliceHeight * pdfWidth) / imgProps.width;

            if (yOffset + sliceHeightMm > pageHeight - margin) {
                doc.addPage();
                yOffset = margin;
            }

            doc.addImage(pageImgData, 'PNG', imgX, yOffset, pdfWidth, sliceHeightMm);
            yOffset += sliceHeightMm + 5;

            position += sliceHeight;
            remainingHeight -= sliceHeight;

            if (remainingHeight > 0) {
                doc.addPage();
                yOffset = margin;
            }
        }

        yOffset += 10;
        if (yOffset > pageHeight - 30) {
            doc.addPage();
            yOffset = margin;
        }
    }

    doc.save("ThongKe.pdf");
}

</script>

