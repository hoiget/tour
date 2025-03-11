<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân quyền nhân viên</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
  

.container {
    display: flex;
    width: 80%;
    margin: 30px auto;
    gap: 20px;
}

/* Danh sách nhân viên */
.list, .permissions {
    width: 50%;
    border: 1px solid #ccc;
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Cuộn danh sách nhân viên nếu quá nhiều */
.list ul {
    list-style: none;
    padding: 0;
    max-height: 400px; /* Giới hạn chiều cao */
    overflow-y: auto; /* Bật cuộn */
    border: 1px solid #ddd;
    border-radius: 5px;
}

/* Cải thiện hiển thị danh sách */
.list li {
    padding: 10px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: background 0.3s ease;
}

.list li:hover {
    background: #e3f2fd;
}

.selected {
    background: #90caf9 !important;
    color: white;
}

/* Cải thiện giao diện phần quyền */
.permissions {
    text-align: center;
    padding: 20px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Tiêu đề */
.permissions h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
}

/* Tên nhân viên */
#permission-section p {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
}

/* Nhóm radio button */
.permissions label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    cursor: pointer;
}

.permissions i {
    font-size: 18px;
    color: #007bff;
}

/* Nút Lưu */
button#save-permission {
    background: #007bff;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s;
    margin-top: 10px;
}

button#save-permission:hover {
    background: #0056b3;
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }
    .list, .permissions {
        width: 100%;
    }
}

    </style>
</head>
<body>

<div class="container">
    <!-- Danh sách nhân viên -->
    <div class="list">
        <h3>Danh sách nhân viên</h3>
        <ul id="employee-list"></ul>
    </div>

    <!-- Danh sách quyền -->
    <div class="permissions">
        <h3>Phân quyền</h3>
        <div id="permission-section">
            <p>Chọn nhân viên để thay đổi quyền</p>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadEmployees();

    function loadEmployees() {
        $.ajax({
            url: './api/apia.php?action=xemnhanvien',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '';
                response.forEach(emp => {
                    html += `<li data-id="${emp.id}" data-perm="${emp.Permissions}">${emp.Name} (${emp.Permissions})</li>`;
                });
                $('#employee-list').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi tải danh sách nhân viên:', error);
            }
        });
    }

    $(document).on('click', '#employee-list li', function() {
        $('#employee-list li').removeClass('selected');
        $(this).addClass('selected');

        let empId = $(this).data('id');
        let currentPerm = $(this).data('perm');

        let permissionsHtml = `
           <p>Nhân viên: <strong>${$(this).text()}</strong></p>
<label><input type="radio" name="permission" value="QL" ${currentPerm == 'QL' ? 'checked' : ''}>
    <i class="bi bi-person-gear"></i> Quản lý
</label><br>

<label><input type="radio" name="permission" value="CSKH" ${currentPerm == 'CSKH' ? 'checked' : ''}>
    <i class="bi bi-headset"></i> CSKH
</label><br>

<label><input type="radio" name="permission" value="HDV" ${currentPerm == 'HDV' ? 'checked' : ''}>
    <i class="bi bi-geo-alt"></i> Hướng dẫn viên
</label><br>

<button id="save-permission" data-id="${empId}">Cập nhật</button>

        `;
        $('#permission-section').html(permissionsHtml);
    });

    $(document).on('click', '#save-permission', function() {
        let empId = $(this).data('id');
        let newPermission = $('input[name="permission"]:checked').val();

        $.ajax({
            url: './api/apia.php?action=updatePermission',
            type: 'GET',
            data: { id: empId, permission: newPermission },
            success: function(response) {
                console.log(response);
                openPopup('Cập nhật thành công!','');
                loadEmployees();
                $('#permission-section').html('<p>Chọn nhân viên để thay đổi quyền</p>');
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi cập nhật quyền:', error);
            }
        });
    });
});
</script>

</body>
</html>
