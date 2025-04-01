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

        .list, .permissions {
            width: 50%;
            border: 1px solid #ccc;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .list ul {
            list-style: none;
            padding: 0;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

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

        .permissions {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .permissions h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        #permission-section p {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .permissions label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            cursor: pointer;
        }

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

        .filter-buttons {
            margin-bottom: 10px;
            text-align: center;
        }

        .filter-buttons button {
            margin: 5px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            background: #ddd;
        }

        .filter-buttons button.active {
            background: #007bff;
            color: white;
        }

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
    <div class="list">
        <h3>Danh sách nhân viên</h3>
        <div class="filter-buttons">
            <button class="filter-btn active" data-role="all">Tất cả</button>
            <button class="filter-btn" data-role="QL">Quản lý</button>
            <button class="filter-btn" data-role="CSKH">Chăm sóc khách hàng</button>
            <button class="filter-btn" data-role="HDV">Hướng dẫn viên</button>
        </div>
        <ul id="employee-list"></ul>
    </div>

    <div class="permissions">
        <h3>Phân quyền</h3>
        <div id="permission-section">
            <p>Chọn nhân viên để thay đổi quyền</p>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let employees = []; // Lưu danh sách nhân viên để lọc

    function loadEmployees() {
        $.ajax({
            url: './api/apia.php?action=xemnhanvien',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                employees = response; // Lưu danh sách nhân viên
                renderEmployees('all'); // Hiển thị tất cả nhân viên
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi tải danh sách nhân viên:', error);
            }
        });
    }

    function renderEmployees(role) {
        let filteredEmployees = role === 'all' ? employees : employees.filter(emp => emp.Permissions === role);
        let html = '';
        filteredEmployees.forEach(emp => {
            html += `<li data-id="${emp.id}" data-perm="${emp.Permissions}">${emp.Name} (${emp.Permissions})</li>`;
        });
        $('#employee-list').html(html);
    }

    $(document).on('click', '.filter-btn', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        let role = $(this).data('role');
        renderEmployees(role);
    });

   
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

    loadEmployees();
});
</script>

</body>
</html>
