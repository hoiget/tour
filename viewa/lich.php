<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lịch làm việc</title>
  <style>
  .calendar-container {
    width: 100%;
    font-family: Arial, sans-serif;
  }

  .calendar-header {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 10px;
  }

  .calendar-header button,
  .calendar-header input {
    padding: 6px 12px;
    font-size: 16px;
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
    vertical-align: top;
  }

  .calendar-table .empty {
    color: #aaa;
  }

  .table-container {
    width: 100%;
    overflow-x: auto;
    overflow-y: auto;
    max-height: 500px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: white;
  }

  .shift-box {
    border: 2px solid #007bff;
    border-radius: 5px;
    padding: 5px;
    display: inline-block;
    background-color: #e7f1ff;
    font-size: 14px;
  }

  /* 👉 Responsive cho thiết bị nhỏ */
  @media (max-width: 768px) {
    .calendar-table {
      border: 0;
    }

    .calendar-table thead {
      display: none;
    }

    .calendar-table tr {
      display: block;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
    }

    .calendar-table td {
      display: flex;
      justify-content: space-between;
      padding: 8px 10px;
      border: none;
      border-bottom: 1px solid #eee;
    }

    .calendar-table td::before {
      content: attr(data-label);
      font-weight: bold;
      color: #555;
    }

    .calendar-table td:last-child {
      border-bottom: none;
    }

    .calendar-header {
      flex-direction: column;
      align-items: center;
    }

    .calendar-header button,
    .calendar-header input {
      width: 100%;
      font-size: 14px;
    }
  }
    /* Modal Container */
    #schedule-detail-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
    z-index: 1000;
    justify-content: center;
    align-items: center;
    transition: opacity 0.3s ease;
  }

  /* Modal Content */
  .modal-content {
    background-color: white;
    border-radius: 10px;
    width: 60%;
    max-width: 800px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    animation: slideIn 0.3s ease-in-out;
  }

  /* Close Button */
  #close-modal {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 30px;
    font-weight: bold;
    color: #aaa;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  #close-modal:hover {
    color: #333;
  }

  /* Header */
  h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
  }

  /* Content */
  #schedule-detail {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    text-align: left;
  }

  /* Slide-in animation */
  @keyframes slideIn {
    0% {
      opacity: 0;
      transform: translateY(-50px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

</style>

</head>
<body>
    <h1>Lịch làm việc</h1>
    
<div class="table-container">
<div class="calendar-container">
<div class="calendar-header" style="margin-top: 10px">
    <button id="prev-week" style="border-radius: 5%; border: 1px solid grey;">Trở về</button>
    <input type="date" id="calendar-date">
    <a href="indexa.php"><button style="border-radius: 5%; border: 1px solid grey;">Hiện tại</button></a>
    <button id="next-week" style="border-radius: 5%; border: 1px solid grey;">Tiếp</button>
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
<div id="schedule-detail-modal" style="display:none;">
        <div class="modal-content">
            <span id="close-modal">&times;</span>
            <h2>Chi tiết lịch trình</h2>
            <div id="schedule-detail"></div>
        </div>
    </div>
 <script>
  // Tự động thêm data-label cho từng <td>
const addDataLabels = () => {
    const headers = Array.from(document.querySelectorAll(".calendar-table thead th")).map(th => th.textContent.trim());
    document.querySelectorAll(".calendar-table tbody tr").forEach(row => {
        row.querySelectorAll("td").forEach((td, i) => {
            td.setAttribute("data-label", headers[i]);
        });
    });
};

// Gọi sau khi đổ dữ liệu
addDataLabels();

 </script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const dateInput = document.getElementById("calendar-date");
  const prevWeekButton = document.getElementById("prev-week");
  const nextWeekButton = document.getElementById("next-week");

  // Hàm tính thứ 2 của tuần hiện tại
  const getMonday = (date) => {
    const copiedDate = new Date(date);
    const day = copiedDate.getDay(); // Lấy thứ trong tuần
    const diff = day === 0 ? -6 : 1 - day; // Nếu là Chủ Nhật, lùi về Thứ Hai tuần trước
    copiedDate.setDate(copiedDate.getDate() + diff);
    return copiedDate;
  };

            const modal = document.getElementById("schedule-detail-modal");
            const closeModalButton = document.getElementById("close-modal");
            const scheduleDetail = document.getElementById("schedule-detail");

            // Hàm hiển thị chi tiết lịch trình
            const showScheduleDetail = (item) => {
    // Chỉnh sửa nội dung chi tiết lịch trình
              let scheduleContent = `
                  <p><strong>Ngày:</strong> ${item.Date}</p>
                  <p><strong>Tên tour:</strong> ${item.tourname}</p>
                  <p><strong>Thời gian:</strong> ${item.Schedule}</p>
                  <p><strong>Địa điểm:</strong> ${item.Locations}</p>
                  <p><strong>Nhân viên:</strong> ${item.EmployeeName}</p>
              `;

              // Kiểm tra trạng thái để thêm thông tin về trạng thái
              if (item.Trangthai == 2) {
                  scheduleContent += `
                      <p><strong>Trạng thái:</strong> Sắp khởi hành</p>
                  `;
              }else if(item.Trangthai == 3){
                scheduleContent += `
                      <p><strong>Trạng thái:</strong> Lịch trình bị hủy</p>
                  `;
              }
               else {
                  scheduleContent += `
                      <p><strong>Trạng thái:</strong> Hoạt động</p>
                  `;
              }
              scheduleContent += `
                      <p><strong>Lịch trình:</strong> ${item.Itinerary}</p>
                  `;
              // Đổ nội dung vào modal
              const scheduleDetail = document.getElementById('schedule-detail');
              scheduleDetail.innerHTML = scheduleContent;

              // Hiển thị modal
              const modal = document.getElementById('schedule-detail-modal');
              modal.style.display = "flex";  
          };

            // Đóng modal
            closeModalButton.addEventListener("click", () => {
                modal.style.display = "none"; // Ẩn modal
            });

  // Hàm fetch dữ liệu từ API
  const fetchSchedule = async (startDate) => {
    try {
      // Lấy ngày thứ 2 của tuần
      const weekStart = getMonday(new Date(startDate));
      const formattedStartDate = weekStart.toISOString().split("T")[0];

      // Gửi request đến API
      const response = await fetch(`./api/apia.php?action=lich&start_date=${formattedStartDate}`);
      if (!response.ok) {
        throw new Error("Lỗi khi gọi API");
      }

      const schedule = await response.json();

      // Xóa nội dung cũ
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

      // Đổ dữ liệu vào các ô
      schedule.forEach((item) => {
        const itemDate = new Date(item.Date);
        const dayIndex = (itemDate.getDay() === 0 ? 6 : itemDate.getDay() - 1);
        const hour = itemDate.getHours();

        // Xác định khoảng thời gian
        let period = "";
        if (hour >= 0 && hour < 12) period = "morning";
        else if (hour >= 12 && hour < 18) period = "afternoon";
        else period = "evening";

        const cellId = `${period}-${dayIds[dayIndex]}`;
        const cell = document.getElementById(cellId);

        if (cell) {
          const content = document.createElement("div");
          content.innerHTML = ` <div class="shift-box">
             <span>${item.Date}</span><br>
              <span>:${item.tourname}</span><br>
              <span>${item.Schedule}</span><br>
              <span>${item.Locations}</span><br>
              <span>(${item.EmployeeName})</span>
            </div>`;
            content.querySelector(".shift-box").addEventListener("click", () => showScheduleDetail(item));
            cell.appendChild(content);
        }
        
      });
    } catch (error) {
      console.error("Lỗi khi tải lịch:", error);
    }
  };

  // Hàm thay đổi tuần
  const adjustWeek = (direction) => {
    const currentDate = new Date(dateInput.value);
    const weekStart = getMonday(currentDate);
    weekStart.setDate(weekStart.getDate() + direction * 7);
    dateInput.value = weekStart.toISOString().split("T")[0];
    fetchSchedule(dateInput.value);
  };

  // Định dạng ngày
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

  // Sự kiện nút điều hướng tuần
  prevWeekButton.addEventListener("click", () => adjustWeek(-1));
  nextWeekButton.addEventListener("click", () => adjustWeek(1));

  // Sự kiện chọn ngày
  dateInput.addEventListener("change", () => fetchSchedule(dateInput.value));
});


</script>
</body>
</html>
