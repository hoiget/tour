

<!-- Giao diện phân công -->
<style>

.container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    gap: 20px;
}
.column {
    width: 30%;
}
.search-input {
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.item {
    padding: 10px;
    margin-bottom: 8px;
    background-color: #f1f1f1;
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: background-color 0.3s ease-in-out;
}
.item.active {
    background-color: #4CAF50;
    color: white;
}
.scrollable {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 8px;
    background-color: #fff;
}
.assignment-item {
    margin-bottom: 10px;
    padding: 8px;
    background-color: #e7f3fe;
    border-radius: 5px;
    border: 1px solid #b6d4fe;
}
button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}
button:hover {
    background-color: #45a049;
}
#assignmentList{
    display: grid;
  grid-template-columns: 3fr 1fr; /* 2 cột bằng nhau */
  gap: 10px; /* Khoảng cách giữa các cột */
}
.btn.delete {
            background-color: #dc3545;
            color: white;
            width: 50px;
        }
</style>
<form class="Phancong" id="Phancong" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="action" value="Phancong">
<div class="container">

    <div class="column">
        <h3>Chọn Nhân viên:</h3>
        <input type="text" class="search-input" placeholder="Tìm kiếm nhân viên..." onkeyup="filterItems('employeeList', this)">
        <div id="employeeList" class="scrollable"></div>
        <input type="hidden" name="employee_id" id="selectedEmployeeInput">
    </div>

    <div class="column">
            <h3>Chọn Khách hàng:</h3>
            <input type="text" class="search-input" placeholder="Tìm kiếm khách hàng..." onkeyup="filterItems('customerList', this)">
            <div id="customerList" class="scrollable"></div>
            <input type="hidden" name="customer_id" id="selectedCustomerInput">
        </div>
       
    <div class="column">
        <h3><i class="bi bi-people-fill"></i>Danh sách phân công:</h3>
        <div id="assignmentList" class="scrollable">
           
        </div>
    </div>
</div>
<center><button type="submit" id="assignBtn">Phân công</button></center>

</form>


<script>
    



function xemnhanvienph() {
    $.ajax({
        url: './api/apia.php?action=xemnhanvienph',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var eventHtml = '';
                response.forEach(function(event) {
                    eventHtml += `<div class='item' data-id='${event.id}'>${event.Name}</div>`;
                });
                $('#employeeList').html(eventHtml);
                attachEventListeners();
            } else {
                $('#employeeList').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#employeeList').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function xemkhachhangph() {
    $.ajax({
        url: './api/apia.php?action=xemkhachhangph',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var eventHtml = '';
                response.forEach(function(event) {
                    eventHtml += `<div class='item' data-id='${event.id}'>${event.Name}</div>`;
                });
                $('#customerList').html(eventHtml);
                attachEventListeners();
            } else {
                $('#customerList').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#customerList').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}

function xemDanhSachPhanCong() {
    $.ajax({
        url: './api/apia.php?action=xemdanhsachphancong',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var html = '';
            html +=`<b>Danh sách</b><b>Thao tác</b>`;
            response.forEach(function(item) {
                html += `<div>${item.employee_name} -> ${item.customer_name}</div>
                  <button class="btn delete" onclick="xoa('${item.idcus}')">🗑</button>`;
            });
            $('#assignmentList').html(html);
        },
        error: function() {
            $('#assignmentList').html('<div>Không có dữ liệu phân công.</div>');
        }
    });
}
function xoa(id) {
       
       fetch('./api/apia.php?action=go&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('Xóa thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php?cskh';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
function phancong() {
 
    $('#Phancong').submit(function (e) {
        e.preventDefault();
 // Thu thập dữ liệu form
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: './api/apia.php',
            data: formData,
            contentType: false, // Bắt buộc khi sử dụng FormData
            processData: false, // Ngăn jQuery xử lý dữ liệu
            success: function (response) {
              
                if (response === 'Phân công thành công') {
                    openPopup('Thông báo', 'Phân công thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?cskh';
                    }, 1000);
                } else if (response === 'Khách hàng đã được phân cho nhân viên này') {
                    openPopup('Thông báo', 'Khách hàng đã được phân cho nhân viên này');
                } else if (response === 'Lỗi khi phân công') {
                    openPopup('Thông báo', 'Lỗi khi phân công');
                } 
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

$(document).ready(function() {
    xemnhanvienph();
    xemkhachhangph();
    xemDanhSachPhanCong();
    phancong();
    attachEventListeners();
  
});

let selectedEmployee = null;
let selectedCustomer = null;
function attachEventListeners() {
    $('#employeeList .item').off('click').on('click', function() {
        $('#employeeList .item').removeClass('active');
        $(this).addClass('active');
        const employeeId = $(this).data('id');
        $('#selectedEmployeeInput').val(employeeId);
    });

    $('#customerList .item').off('click').on('click', function() {
        $('#customerList .item').removeClass('active');
        $(this).addClass('active');
        const customerId = $(this).data('id');
        $('#selectedCustomerInput').val(customerId);
    });
}



function filterItems(listId, input) {
    const filter = input.value.toLowerCase();
    $(`#${listId} .item`).each(function() {
        const text = $(this).text().toLowerCase();
        $(this).toggle(text.includes(filter));
    });
}
</script>