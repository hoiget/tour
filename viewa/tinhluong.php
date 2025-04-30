<style>
    <style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f8;
    padding: 20px;
}

#monthSelect, button {
    padding: 8px 12px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
}

button:hover {
    background-color: #45a049;
}

#salaryTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
}

#salaryTable thead {
    background-color: #2d89ef;
    color: white;
}

#salaryTable th, #salaryTable td {
    padding: 12px 16px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

#salaryTable input {
    width: 100px;
    padding: 6px;
    text-align: right;
    border: 1px solid #ccc;
    border-radius: 4px;
}

#salaryTable button {
    padding: 6px 10px;
    background-color: #2196F3;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    cursor: pointer;
}

#salaryTable button:hover {
    background-color: #0b7dda;
}
</style>

</style>
<select id="monthSelect">
    <!-- JavaScript sẽ sinh tự động các tháng -->
</select>
<button onclick="loadSalaries()">Xem lương</button>
<button onclick="autoAddSalaries()">Thêm lương cơ bản tháng này</button>
<table border="1" id="salaryTable">
    <thead>
        <tr>
            <th>Tên nhân viên</th>
            <th>Chức vụ</th>
            <th>Phụ cấp</th>
            <th>Lương cơ bản</th>
            <th>Tổng lương</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


<script>
function autoAddSalaries() {
    const month = document.getElementById("monthSelect").value;
    fetch(`./api/phancong.php?action=auto_add&month=${month}`)
        .then(res => res.text())
        .then(msg => {
            alert(msg);
            loadSalaries(); // reload lại bảng
        });
}
</script>

<script>
// Tạo danh sách tháng (12 tháng gần nhất)
const monthSelect = document.getElementById("monthSelect");
for (let i = 0; i < 12; i++) {
    const date = new Date();
    date.setMonth(date.getMonth() - i);
    const month = date.toISOString().slice(0, 7);
    monthSelect.innerHTML += `<option value="${month}">${month}</option>`;
}

// Load dữ liệu lương
function loadSalaries() {
    const month = document.getElementById("monthSelect").value;
    fetch(`./api/phancong.php?action=get&month=${month}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#salaryTable tbody");
            tbody.innerHTML = "";
            data.forEach(row => {
                tbody.innerHTML += `
                <tr>
                    <td>${row.name}</td>
                     <td>${row.Permissions === 'QL' ? 'Nhân viên quản lý dịch vụ' : row.Permissions === 'CSKH' ? 'Nhân viên chăm sóc khách hàng' : 'Hướng dẫn viên'}</td>
                     <td><input type="number" value="${row.allowance}" min="0" onchange="updateSalary(${row.id}, 'allowance', this)" /></td>
        <td><input type="number" value="${row.basic_salary}" min="0" onchange="updateSalary(${row.id}, 'basic_salary', this)" /></td>
                    <td>${parseInt(row.total_salary).toLocaleString('vi-VN')} đ
                    </td>
                    <td><button onclick="saveSalary(${row.id})">Lưu</button></td>
                </tr>`;
               
            });
        });
}

// Lưu giá trị sửa
function updateSalary(id, field, input) {
    const value = parseFloat(input.value);

    if (isNaN(value) || value < 0) {
        alert("Không được nhập số âm!");
        input.value = 0;
        return;
    }

    fetch("./api/phancong.php?action=update", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, field, value })
    })
    .then(res => res.text())
    .then(console.log);
}

// Lưu lại tổng lương
function saveSalary(id) {
    fetch(`./api/phancong.php?action=save_total&id=${id}`)
        .then(res => res.text())
        .then(msg => {
            alert("Đã lưu");
            loadSalaries();
        });
}

// Tự động tải khi trang load
window.onload = loadSalaries;
</script>
