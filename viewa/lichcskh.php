<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lịch Học</title>
  <style>
    .calendar-container {
      width: 100%;
      font-family: Arial, sans-serif;
    }

    .calendar-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .calendar-table {
      width: 100%;
      border-collapse: collapse;
    }

    .calendar-table th,
    .calendar-table td {
      border: 1px solid #ddd;
      text-align: center;
      padding: 10px;
    }

    .calendar-table thead {
      background-color: #f4f4f4;
    }

    .calendar-table td {
      min-height: 100px;
      vertical-align: top;
    }

    .calendar-table .empty {
      color: #aaa;
    }
    .table-container{
    width: 100%; /* Chiều rộng đầy đủ */
    overflow-x: auto; /* Cuộn ngang nếu nội dung vượt quá chiều rộng */
    overflow-y: auto; /* Cuộn dọc nếu cần */
    max-height: 500px; /* Giới hạn chiều cao tối đa */
    border: 1px solid #ddd; /* Đường viền để dễ nhận diện */
    border-radius: 8px;
    background-color: white; /* Đảm bảo nền trắng cho vùng cuộn */
}
.shift-box {
    border: 2px solid #007bff; /* Viền xanh */
    border-radius: 5px; /* Bo góc */
    padding: 5px;
    display: inline-block;
    background-color: #e7f1ff; /* Nền xanh nhạt */
}

  </style>
</head>
<body>
    <h1>Lịch làm việc</h1>

    <div class="table-container">
<div class="calendar-container">
  <div class="calendar-header">
    <button id="prev-week">Trở về</button>
    <input type="date" id="calendar-date">
    <a href="indexa.php?lichql"><button>Hiện tại</button></a>
    <button id="next-week">Tiếp</button>
  </div>
  <table class="calendar-table">
    <thead>
      <tr>
        <th>Lịch làm việc</th>
        <th id="header-mon">Thứ 2</th>
        <th id="header-tue">Thứ 3</th>
        <th id="header-wed">Thứ 4</th>
        <th id="header-thu">Thứ 5</th>
        <th id="header-fri">Thứ 6</th>
        <th id="header-sat">Thứ 7</th>
        <th id="header-sun">Chủ nhật</th>
      </tr>
      
    </thead>
    <tbody>
      <tr>
        <td>Sáng</td>
        <td id="morning-mon"></td>
        <td id="morning-tue"></td>
        <td id="morning-wed"></td>
        <td id="morning-thu"></td>
        <td id="morning-fri"></td>
        <td id="morning-sat"></td>
        <td id="morning-sun"></td>
      </tr>
      <tr>
        <td>Chiều</td>
        <td id="afternoon-mon"></td>
        <td id="afternoon-tue"></td>
        <td id="afternoon-wed"></td>
        <td id="afternoon-thu"></td>
        <td id="afternoon-fri"></td>
        <td id="afternoon-sat"></td>
        <td id="afternoon-sun"></td>
      </tr>
      <tr>
        <td>Tối</td>
        <td id="evening-mon"></td>
        <td id="evening-tue"></td>
        <td id="evening-wed"></td>
        <td id="evening-thu"></td>
        <td id="evening-fri"></td>
        <td id="evening-sat"></td>
        <td id="evening-sun"></td>
      </tr>
    </tbody>
  </table>
</div>

</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const dateInput = document.getElementById("calendar-date");
    const prevWeekButton = document.getElementById("prev-week");
    const nextWeekButton = document.getElementById("next-week");

    // Lấy ngày thứ 2 của tuần
    const getMonday = (date) => {
        const copiedDate = new Date(date);
        const day = copiedDate.getDay();
        const diff = day === 0 ? -6 : 1 - day;
        copiedDate.setDate(copiedDate.getDate() + diff);
        return copiedDate;
    };

    // Fetch dữ liệu lịch làm việc
    const fetchSchedule = async (startDate) => {
        try {
            const weekStart = getMonday(new Date(startDate));
            const formattedStartDate = weekStart.toISOString().split("T")[0];

            // Gọi API lấy dữ liệu lịch làm việc
            const response = await fetch(`./api/apia.php?action=lichcskh&start_date=${formattedStartDate}`);
            if (!response.ok) {
                throw new Error("Lỗi khi gọi API");
            }

            const schedule = await response.json();

            // Xóa nội dung cũ trong bảng lịch
            document.querySelectorAll("tbody td[id]").forEach((cell) => {
                cell.innerHTML = "";
            });

            // Cập nhật ngày trong tiêu đề
            const dayIds = ["mon", "tue", "wed", "thu", "fri", "sat", "sun"];
            dayIds.forEach((dayId, index) => {
                const headerCell = document.getElementById(`header-${dayId}`);
                const dayDate = new Date(weekStart);
                dayDate.setDate(weekStart.getDate() + index);
                const formattedDate = formatDate(dayDate);

                if (headerCell) {
                    headerCell.innerHTML = `Thứ ${index + 2}<br><strong>${formattedDate}</strong>`;
                }
            });

            // Đổ dữ liệu vào bảng lịch
          // Đổ dữ liệu vào bảng lịch
          schedule.forEach((item) => {
    const itemDate = new Date(item.shift_date);
    const dayIndex = (itemDate.getDay() === 0 ? 6 : itemDate.getDay() - 1); // 0: Chủ Nhật → 6

    let period = "";
    if (item.shift_type === "Ca 1") period = "morning";
    else if (item.shift_type === "Ca 2") period = "afternoon";
    else if (item.shift_type === "Ca 3") period = "evening";

    const cellId = `${period}-${dayIds[dayIndex]}`;
    const cell = document.getElementById(cellId);

    if (cell) {
        cell.innerHTML = `<div class="shift-box"><strong>${item.employee_names}</strong></div>`;
    }
});


        } catch (error) {
            console.error("Lỗi khi tải lịch:", error);
        }
    };

    // Điều chỉnh tuần
    const adjustWeek = (direction) => {
        const currentDate = new Date(dateInput.value);
        const weekStart = getMonday(currentDate);
        weekStart.setDate(weekStart.getDate() + direction * 7);
        dateInput.value = weekStart.toISOString().split("T")[0];
        fetchSchedule(dateInput.value);
    };

    // Format ngày
    const formatDate = (date) => {
        const day = String(date.getDate()).padStart(2, "0");
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    };

    // Khởi tạo
    const today = new Date();
    dateInput.value = today.toISOString().split("T")[0];
    fetchSchedule(dateInput.value);

    // Sự kiện điều hướng tuần
    prevWeekButton.addEventListener("click", () => adjustWeek(-1));
    nextWeekButton.addEventListener("click", () => adjustWeek(1));

    // Sự kiện chọn ngày
    dateInput.addEventListener("change", () => fetchSchedule(dateInput.value));
});



</script>
</body>
</html>
