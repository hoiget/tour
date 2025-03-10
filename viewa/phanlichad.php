<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<style>
/* Bố cục 2 cột */
.container {
    display: flex;
    justify-content: center;
    gap: 20px;
    max-width: 90%;
    margin: 20px auto;
}

/* Cột bên trái: Form phân công (40%) */
.assign_shift {
    flex: 0 0 40%;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Cột bên phải: Danh sách ca làm việc (60%) */
.shift_list {
    flex: 0 0 60%;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-height: 500px; /* Giới hạn chiều cao */
    overflow-y: auto; /* Thêm thanh cuộn khi có nhiều dữ liệu */
}

/* Các điều chỉnh khác giữ nguyên */
.assign_shift label,
.shift_list h3 {
    font-weight: bold;
    margin-top: 10px;
    display: block;
}

.assign_shift select,
.assign_shift input,
#dateFilter {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.assign_shift button {
    display: block;
    width: 100%;
    padding: 10px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    margin-top: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.assign_shift button:hover {
    background: #0056b3;
}

/* Danh sách ca làm việc */
#shiftList {
    list-style: none;
    padding: 0;
    max-height: 400px; /* Giới hạn chiều cao của danh sách */
    overflow-y: auto; /* Cuộn dọc khi quá nhiều dữ liệu */
}

#shiftList li {
    background: #e9ecef;
    padding: 12px;
    margin: 8px 0;
    border-left: 5px solid #007bff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}


</style>
<div class="container">
    <!-- Form Phân Công -->
    <form class="assign_shift" id="assign_shift" action="./api/apia.php" method="post" enctype="multipart/form-data"> 
        <input type="hidden" name="action" value="assign_shift">

     <!-- Chỉnh sửa Select2 để cho phép chọn nhiều nhân viên -->
<label for="employee">Chọn nhân viên:</label>
<select id="employee" name="employee_id[]" class="select2" multiple="multiple" style="width: 100%;">
    <option value="">-- Chọn nhân viên --</option>
</select>


        <label for="shift">Chọn ca:</label>
        <select id="shift" name="shift">
            <option value="Sáng">Sáng</option>
            <option value="Chiều">Chiều</option>
            <option value="Tối">Tối</option>
        </select>

        <label for="shift_date">Ngày:</label>
        <input type="date" id="shift_date" name="shift_date">

        <button onclick="assignShift()">Phân công</button>
    </form>

    <!-- Danh sách ca làm việc -->
    <div class="shift_list">
        <h3>Danh sách ca làm việc</h3>
        <input type="date" id="dateFilter" onchange="getShifts()">
        <ul id="shiftList"></ul>
    </div>
</div>


<script>
 $(document).ready(function() {
    nhanvien(); // Load danh sách nhân viên
    getShifts(); // Load danh sách ca làm việc
});

// Hàm phân công ca làm việc
function assignShift() {
    $('#assign_shift').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var selectedEmployees = $('#employee').val(); // Lấy danh sách nhân viên đã chọn

        if (!selectedEmployees || selectedEmployees.length === 0) {
            openPopup('Lỗi', 'Vui lòng chọn ít nhất một nhân viên!');
            return;
        }

        $.ajax({
            type: 'POST',
            url: './api/apia.php?action=assign_shift',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                console.log(response);

                if (response.success) {
                    openPopup('Thông báo', response.success);
                    setTimeout(function () {
                        window.location.href = 'indexa.php?PL';
                    }, 2000);
                } 
                if (response.warnings) {
                    response.warnings.forEach(msg => openPopup('Cảnh báo', msg));
                }
                if (response.error) {
                    openPopup('Lỗi', response.error);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}

// Hàm lấy danh sách ca làm việc
function getShifts() {
    let date = $('#dateFilter').val();

    let url = `./api/apia.php?action=get_shifts`;
    if (date) {
        url += `&date=${date}`;
    }

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let list = response.map(shift => 
                `<li>${shift.Name} - ${shift.shift} (${shift.shift_date})</li>`
            ).join('');

            $('#shiftList').html(list || '<li>Không có ca làm việc</li>');
        }
    });
}

// Hàm lấy danh sách nhân viên (Select2)
function nhanvien() {
    $('#employee').select2({
        placeholder: "Chọn nhân viên...",
        allowClear: true,
        multiple: true, // Cho phép chọn nhiều nhân viên
        ajax: {
            url: "./api/apia.php?action=get_employees",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(emp => ({
                        id: emp.id,
                        text: `${emp.Name}`
                    }))
                };
            }
        }
    });
}

</script>