<h2>Xem lương theo tháng</h2>

<select id="monthSelect"></select>
<button onclick="loadMySalary()">Xem lương</button>

<table border="1" id="mySalaryTable">
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Phụ cấp</th>
            <th>Lương cơ bản</th>
            <th>Tổng lương</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f7f9fb;
    padding: 30px;
}
select, button {
    padding: 8px 12px;
    margin: 10px 0;
    border-radius: 6px;
}
button {
    background: #2d89ef;
    color: #fff;
    border: none;
}
#mySalaryTable {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 6px;
    overflow: hidden;
}
#mySalaryTable th {
    background: #2d89ef;
    color: white;
}
#mySalaryTable th, #mySalaryTable td {
    padding: 12px 16px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}
</style>

<script>
// Tạo danh sách tháng (12 tháng gần nhất)
const monthSelect = document.getElementById("monthSelect");
for (let i = 0; i < 12; i++) {
    const date = new Date();
    date.setMonth(date.getMonth() - i);
    const month = date.toISOString().slice(0, 7);
    monthSelect.innerHTML += `<option value="${month}">${month}</option>`;
}

// Tải lương cá nhân
function loadMySalary() {
    const month = document.getElementById("monthSelect").value;

    fetch(`./api/phancong.php?action=get_mysalary&month=${month}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#mySalaryTable tbody");
            tbody.innerHTML = "";

            if (!data || !data.month_year) {
                tbody.innerHTML = "<tr><td colspan='4'>Không có dữ liệu</td></tr>";
                return;
            }

            tbody.innerHTML = `
                <tr>
                    <td>${data.month_year}</td>
                    <td>${parseInt(data.allowance).toLocaleString('vi-VN')} đ</td>
                    <td>${parseInt(data.basic_salary).toLocaleString('vi-VN')} đ</td>
                    <td><strong>${parseInt(data.total_salary).toLocaleString('vi-VN')} đ</strong></td>
                </tr>`;
        });
}

// Tự động tải khi trang mở
window.onload = loadMySalary;
</script>
