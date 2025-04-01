<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân công công việc theo ca</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.6.0/jspdf.plugin.autotable.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
        }

        .form-container {
            background-color: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-right: 10px;
            font-weight: bold;
        }

        select, input[type="date"], input[type="text"], button {
            margin-bottom: 10px;
            padding: 8px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        th {
            background-color: #f0f0f0;
        }

        .legend {
            margin-top: 15px;
            padding: 10px;
        }

        .legend span {
            margin-right: 20px;
        }
    </style>
</head>

<body>
    <h2>Phân công công việc theo ca</h2>

    <div class="legend">
        <h4>Chú thích:</h4>
        <span>V: Làm việc</span>
        <span>X: Nghỉ</span>
        <span>P: Phép</span>
        <span>Số giờ: Số giờ làm việc thực tế</span><br>
        <span>Ca 1: 8h -> 12h</span><br>
        <span>Ca 2: 1h -> 5h</span><br>
        <span>Ca 3: 6h -> 10h</span><br>
        
    </div>
    <button id="exportPDF">Xuất PDF</button>
    <button id="autoAssign">Tự động phân công</button>

    <!-- <div class="form-container">
        <h3>Thêm ca cho nhân viên</h3>
        <form id="addShiftForm">
            <label>Chọn nhân viên:</label>
            <select id="employeeSelect"></select>

            <label>Ca:</label>
            <select id="shiftType">
                <option value="Ca 1">Ca 1</option>
                <option value="Ca 2">Ca 2</option>
                <option value="Ca 3">Ca 3</option>
                <option value="TC">TC</option>
            </select>

            <input type="date" id="shiftDate">
            <input type="text" id="status" placeholder="X, P hoặc số giờ">
            <button type="submit">Thêm Ca</button>
        </form>
    </div> -->

    <label>Chọn tháng:</label>
    <select id="monthSelect">
        <option value="1">Tháng 1</option>
        <option value="2">Tháng 2</option>
        <option value="3" selected>Tháng 3</option>
        <option value="4">Tháng 4</option>
        <option value="5">Tháng 5</option>
        <option value="6">Tháng 6</option>
        <option value="7">Tháng 7</option>
        <option value="8">Tháng 8</option>
        <option value="9">Tháng 9</option>
        <option value="10">Tháng 10</option>
        <option value="11">Tháng 11</option>
        <option value="12">Tháng 12</option>
    </select>

    <table id="scheduleTable" border="1">
        <thead>
            <tr>
                <th>Mã NV</th>
                <th>Tên</th>
                <th>Ca làm</th>
                <th colspan="31">Ngày</th>
               <?php
               for ($i = 1; $i <= 30; $i++) {
                   echo "<th hidden></th>";
               }
               ?>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const monthSelect = document.getElementById("monthSelect");
            const scheduleTable = document.querySelector("#scheduleTable tbody");

            fetch(`./api/phancong.php?action=getEmployees`)
                .then(response => response.json())
                .then(data => {
                    const employeeSelect = document.getElementById("employeeSelect");
                    employeeSelect.innerHTML = data.map(emp => `<option value="${emp.id}">${emp.Name}</option>`).join('');
                });

            monthSelect.addEventListener("change", fetchSchedule);

    async function fetchSchedule() {
                const month = monthSelect.value;
                const response = await fetch(`./api/phancong.php?action=getShifts&month=${month}&year=2025`);
                const data = await response.json();
                renderSchedule(data);
            }
            async function fetchSchedule() {
    const month = monthSelect.value;
    const year = new Date().getFullYear();

    // 🔹 Lấy danh sách nhân viên
    const employeesRes = await fetch(`./api/phancong.php?action=getEmployees`);
    const employees = await employeesRes.json();

    // 🔹 Lấy danh sách ca làm việc
    const shiftsRes = await fetch(`./api/phancong.php?action=getShifts&month=${month}&year=${year}`);
    const shifts = await shiftsRes.json();

    renderSchedule(employees, shifts);
}

function renderSchedule(employees, shifts) {
    const selectedMonth = parseInt(monthSelect.value);
    const year = new Date().getFullYear();
    const daysInMonth = new Date(year, selectedMonth, 0).getDate();

    scheduleTable.innerHTML = ""; // Xóa dữ liệu cũ trước khi render mới

    // Tạo tiêu đề cột
    let headerRow = `<tr>
        <th>Mã NV</th>
        <th>Tên</th>
        <th>Ca làm</th>`;
    
    for (let day = 1; day <= daysInMonth; day++) {
        headerRow += `<th>${day}</th>`;
    }
    
    headerRow += `</tr>`;
    scheduleTable.innerHTML += headerRow;

    // Nhóm ca làm việc theo nhân viên
    const groupedShifts = shifts.reduce((acc, shift) => {
        const key = `${shift.employee_id}_${shift.shift_type}`;
        if (!acc[key]) acc[key] = [];
        acc[key].push(shift);
        return acc;
    }, {});

    // Duyệt qua danh sách nhân viên để tạo hàng
    employees.forEach(employee => {
        const shiftTypes = ["Ca 1", "Ca 2", "Ca 3"];
        let isFirstRow = true; // Cờ kiểm tra dòng đầu tiên

        shiftTypes.forEach(shiftType => {
            const key = `${employee.id}_${shiftType}`;
            const shiftsForEmployee = groupedShifts[key] || []; // Nếu chưa có dữ liệu, dùng mảng trống

            const row = document.createElement("tr");

           
                // 🔹 Gộp ô (rowspan) cho Mã NV và Họ tên (4 dòng - tương ứng 4 ca)
                row.innerHTML = `<td>${employee.id}</td>
                                 <td>${employee.Name}</td>`;
                

            // Thêm cột ca làm việc
            row.innerHTML += `<td>${shiftType}</td>`;

            for (let day = 1; day <= daysInMonth; day++) {
                const cell = document.createElement("td");
                const shift = shiftsForEmployee.find(s => new Date(s.shift_date).getDate() === day);

                if (shift) {
                    cell.textContent = shift.status || '';
                    cell.dataset.shiftId = shift.id;
                } else {
                    cell.textContent = "";
                    cell.dataset.shiftId = "";
                }

                cell.contentEditable = "true"; // Cho phép chỉnh sửa
                row.appendChild(cell);
            }

            scheduleTable.appendChild(row);
        });
        const emptyRow = document.createElement("tr");
    emptyRow.innerHTML = `<td colspan="${daysInMonth + 3}" style="height: 10px; background: #f9f9f9;"></td>`;
    scheduleTable.appendChild(emptyRow);
    });
}




scheduleTable.addEventListener("blur", function (e) {
    const cell = e.target;
    const shiftId = cell.dataset.shiftId; // ID ca làm việc (nếu có)
    const row = cell.closest("tr");
const employeeId = row.cells[0]?.textContent.trim(); // Lấy Mã NV
const shiftType = row.cells[2]?.textContent.trim(); // Lấy Ca làm việc
const day = cell.cellIndex - 3 + 1; // Lấy số ngày (trừ cột Mã NV, Họ tên, Ca làm)
const month = monthSelect.value.padStart(2, "0");
const year = new Date().getFullYear();
const shiftDate = `${year}-${month}-${day.toString().padStart(2, "0")}`;
const status = cell.innerText.trim();


    if (shiftId) {
        // 🔹 Nếu có shiftId, cập nhật trạng thái
        fetch("./api/phancong.php?action=updateShift", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ shift_id: shiftId, status: status })
        }).then(response => response.json())
          .then(data => console.log("Cập nhật thành công:", data))
          .catch(error => console.error("Lỗi cập nhật:", error));
    } else if (status) {
        // 🔹 Nếu chưa có shiftId, tạo mới ca làm việc
        fetch("./api/phancong.php?action=addShift1", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
        employee_id: employeeId,
        shift_type: shiftType,
        shift_date: shiftDate,
        status: status
    })
})
.then(response => response.text()) // 🟢 Đọc dạng text thay vì json
.then(data => {
    console.log("API Response:", data); // 🟢 Kiểm tra xem API trả về gì
    console.log("Employee ID gửi lên API:", employeeId);
console.log("Shift Type gửi lên API:", shiftType);
console.log("Shift Date gửi lên API:", shiftDate);
console.log("Status gửi lên API:", status);

    try {
        const jsonData = JSON.parse(data);
        console.log("Parsed JSON:", jsonData);
        if (jsonData.status === "success") {
            cell.dataset.shiftId = jsonData.id;
        } else {
            console.error("API Error:", jsonData.message);
        }
    } catch (error) {
        console.error("JSON Parse Error:", error, data);
    }
})
.catch(error => console.error("Fetch Error:", error));


    }
}, true);


            fetchSchedule();
        });
    </script>
<script>
function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4'); // Landscape (Ngang)

    const selectedMonth = document.getElementById("monthSelect").value;
    const currentYear = new Date().getFullYear();
    const exportDate = new Date().toLocaleDateString();

    doc.setFont("times", "bold");

    doc.setFontSize(14);
    doc.text(`Phân Công  - Tháng ${selectedMonth}/${currentYear}`, 14, 15);
    doc.text(`Chú thích`, 14, 20);
    doc.setFontSize(9);
    doc.text(`V: Ngày Làm  | X: Không phép  | P: Phép`, 14, 25);
    doc.text(`Ca 1: 8h -> 12h`, 14, 30);
    doc.text(`Ca 2: 1h -> 5h`, 14, 35);
    doc.text(`Ca 3: 6h -> 10h`, 14, 40);
  
    doc.setFontSize(10);
    doc.text(`Ngày: ${exportDate}`, 270, 15, { align: "right" });

    let headers = [];
    let data = [];
    const table = document.getElementById("scheduleTable");
    const rows = table.querySelectorAll("tr");

    rows.forEach((row, rowIndex) => {
        let rowData = [];
        const cells = row.querySelectorAll("th, td");

        if (rowIndex === 0) {
            headers = Array.from(cells).map(cell => cell.innerText.trim());
        } else {
            rowData = Array.from(cells).map(cell => cell.innerText.trim());

            // Đảm bảo đủ 34 cột (Mã NV, Họ tên, Ca làm, 31 ngày)
            while (rowData.length < 34) {
                rowData.push(""); // Thêm ô trống nếu thiếu
            }
            data.push(rowData);
        }
    });

    console.log("Headers:", headers);
    console.log("Data:", data);

    if (headers.length < 34) {
        alert("Lỗi: Số cột trong bảng không đủ, kiểm tra lại HTML!");
        return;
    }

    // Thiết lập kích thước cột
    let columnStyles = {
        0: { cellWidth: 10 }, // Mã NV
        1: { cellWidth: 10 }, // Họ tên
        2: { cellWidth: 10 }, // Ca làm
    };

    for (let i = 3; i < headers.length; i++) {
        columnStyles[i] = { cellWidth: 7.5 }; // Cột ngày (1-31) nhỏ hơn
    }
    let finalY = doc.lastAutoTable.finalY + 10;



    // Xuất PDF với AutoTable
    doc.autoTable({
        head: [headers],
        body: data,
        startY: 45,
        styles: { fontSize: 8, cellPadding: 1.5, halign: "center" }, // Font dữ liệu lớn hơn
        headStyles: { fillColor: [0, 123, 255], textColor: 255, fontSize: 10 }, // Font tiêu đề lớn hơn
        columnStyles: columnStyles,
        margin: { left: 3, right: 3 }, 
        theme: "grid",
        horizontalPageBreak: true, // Tự động xuống dòng nếu bảng quá rộng
        willDrawCell: function (data) {
            if (data.column.index >= 3) {
                data.cell.styles.fontSize = 7; // Font nhỏ hơn cho cột ngày
                data.cell.styles.cellPadding = 1;
            }
        }
    });

    doc.save(`PhanCongCongViec_Thang${selectedMonth}_${currentYear}.pdf`);
}

document.getElementById("exportPDF").addEventListener("click", exportToPDF);

</script>
<script>
    document.getElementById("autoAssign").addEventListener("click", function () {
    const month = document.getElementById("monthSelect").value;
    const year = new Date().getFullYear();

    fetch("./api/phancong.php?action=autoAssignShifts", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ month, year })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        fetchSchedule(); // Cập nhật lại bảng sau khi tự động phân công
    })
    .catch(error => console.error("Lỗi tự động phân công:", error));
});

</script>
</body>

</html>
