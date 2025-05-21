<style>
  .container {
    display: flex;
    gap: 20px;
    padding: 20px;
  }
  
  .tour-list, .guide-list {
    flex: 1;
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-height: 600px;
    overflow-y: auto;
   
  }

  .tour-item {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: 0.3s;
  }

  .tour-item:hover {
    background: #f0f0f0;
  }

  .selected {
    background: #007bff;
    color: white;
  }

  .selected:hover {
    background: #007bff;
    color: white;
  }
  .form-container select {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .custom-multiselect {
  width: 100%;
  max-width: 100%;
  height: 120px;
  padding: 5px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #fff;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  overflow-y: auto;
  outline: none;
}

.custom-multiselect option {
  padding: 5px;
  cursor: pointer;
}

.custom-multiselect option:hover {
  background-color: #f0f0f0;
}

.custom-multiselect option:checked {
  background-color: #007bff;
  color: white;
}

  .submit-btn {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s;
  }

  .submit-btn:hover {
    background-color: #0056b3;
  }
  .filter-buttons {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 15px;
}

.filter-buttons button {
  padding: 10px 15px;
  font-size: 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: 0.3s;
}

.filter-buttons button:nth-child(1) { /* Tất cả */
  background-color: #6c757d;
  color: white;
}

.filter-buttons button:nth-child(2) { /* Có hướng dẫn viên */
  background-color: #28a745;
  color: white;
}

.filter-buttons button:nth-child(3) { /* Chưa có hướng dẫn viên */
  background-color: #ffc107;
  color: black;
}

.filter-buttons button:hover {
  opacity: 0.8;
}

.search-container {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 15px;
}

.search-container input {
    padding: 8px 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s;
}

.search-container input:focus {
    border-color: #007bff;
}

.search-container button {
    background-color: #007bff;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.search-container button:hover {
    background-color: #0056b3;
}

</style>

<h1>Phân lịch hướng dẫn viên</h1>

<div class="container">
  <!-- Cột trái: Danh sách tour -->
  
  <div class="tour-list">
    <div class="filter-buttons">
      <button onclick="filterTours('all')">Tất cả</button>
      <button onclick="filterTours('available')">Có hướng dẫn viên</button>
      <button onclick="filterTours('unavailable')">Chưa có hướng dẫn viên</button>
    </div>

    <h3>Danh sách tour</h3>

    <div id="tour-container"></div>
  </div>

  <!-- Cột phải: Danh sách hướng dẫn viên -->
  <div class="guide-list">
    <div class="search-container">
      <input type="text" id="search" name="MAT" placeholder="🔍 Mã tour/tên tour" onkeydown="searchtour(event)">
      <input type="date" name="date" id="date" onkeydown="searchtour(event)">
      <button style="height:40px;font-size:12px" onclick="searchtour()">Tìm kiếm</button>
    </div>
    <div class="form-hdv" >
      <h3>Chọn hướng dẫn viên</h3>
      <form id="capnhathdv" action="./api/apia.php" method="post">
        <input type="hidden" name="action" value="capnhathdv">
        <input type="hidden" name="id" id="selectedTourId">
        <input type="datetime" hidden name="date" id="selectedTourdate">

        
          
        <select id="hdv" name="hdv1[]" multiple style="height: 380px;" class="custom-multiselect">
    
        </select>

          <!-- <select name="hdv1" id="hdv">
            <option value="" selected>Chọn nhân viên</option>
          </select> -->
          <br>
        <span id="tenhdv"></span> <br>
        <div style="margin: auto; margin-left: 30px;margin-top: 5px; width: 90%; display: inline-block">
            <center><button style="width: 100px;" type="submit" class="submit-btn">Cập nhật</button></center>
        </div>
      
        </form>
    </div>
  </div>
  
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    xemlichtrinh();
    xemhdv();
    capnhathdv();
  });
  function filterTours(filter) {
  $.ajax({
    url: './api/apia.php?action=xemlichtrinh',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      console.log(response);

      if (Array.isArray(response) && response.length > 0) {
        var html = '';

        // 🔍 Lọc danh sách theo điều kiện filter
        const filteredTours = response.filter(function (tour) {
          if (filter === 'available') {
            return tour.guides && tour.guides.length > 0;
          } else if (filter === 'unavailable') {
            return !tour.guides || tour.guides.length === 0;
          }
          return true; // 'all'
        });

        if (filteredTours.length === 0) {
          $('#tour-container').html('Không có lịch trình phù hợp.');
          return;
        }

        // 🧱 Tạo HTML hiển thị
        filteredTours.forEach(function (tour) {
          let hdvStatus = 'Chưa có';
          if (tour.guides && tour.guides.length > 0) {
            const names = tour.guides.map(g => g.Name).join(', ');
            hdvStatus = `<span class="hdv-name" style="color: green;">${names}</span>`;
          } else {
            hdvStatus = `<span class="hdv-name" style="color: orange;">Chưa có</span>`;
          }

          html += `<div class="tour-item" data-id="${tour.idsh}" onclick="chonTour(${tour.idsh}, '${tour.Date}')">
              <b>${tour.Name}</b> <br> Ngày: ${tour.Date} <br> Khởi hành: ${tour.Locations}
              <br> Ngày ở: ${tour.Day_depart}
              <br> Lượt đặt: ${tour.Orders}
              <br> Hướng dẫn viên đảm nhiệm: ${hdvStatus}
              <br> Trạng thái: `;

          if (tour.Trangthai == 1) {
            html += `<span style="color:green">Hoạt động</span>`;
          } else if (tour.Trangthai == 2) {
            html += `<span style="color:purple">Sắp khởi hành</span>`;
          } else if (tour.Trangthai == 4) {
            html += `<span style="color:Violet">Lịch trình đã hoàn thành</span>`;
          } else {
            html += `<span style="color:red">Lịch trình bị hủy</span>`;
          }

          html += `<br><button style="background-color: #DC143C; color: white; border: 1px solid black; border-radius: 3px" class="delete-btn" onclick="event.stopPropagation(); xoalichtrinh(${tour.idsh})">🗑️ Xóa</button>
            </div>`;
        });

        $('#tour-container').html(html);
      } else {
        $('#tour-container').html('Không tìm thấy tour.');
      }
    },
    error: function () {
      $('#tour-container').html('Lỗi khi tải danh sách tour.');
    }
  });
}

 function xemlichtrinh() {
  $.ajax({
    url: './api/apia.php?action=xemlichtrinh',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      console.log(response);
      if (Array.isArray(response) && response.length > 0) {
        var html = '';
        response.forEach(function (tour) {
          let hdvStatus = 'Chưa có';
          if (tour.guides && tour.guides.length > 0) {
            const names = tour.guides.map(g => g.Name).join(', ');
            hdvStatus = `<span class="hdv-name" style="color: green;">${names}</span>`;
          } else {
            hdvStatus = `<span class="hdv-name" style="color: orange;">Chưa có</span>`;
          }

          html += `<div class="tour-item" data-id="${tour.idsh}" onclick="chonTour(${tour.idsh}, '${tour.Date}')">
              <b>${tour.Name}</b> <br> Ngày: ${tour.Date} <br> Khởi hành: ${tour.Locations}
              <br> Ngày ở: ${tour.Day_depart}
              <br> Lượt đặt: ${tour.Orders}
              <br> Hướng dẫn viên đảm nhiệm: ${hdvStatus} 
              <br> Trạng thái: 
              `;

          if (tour.Trangthai == 1) {
            html += `<span style="color:green">Hoạt động</span>`;
          } else if (tour.Trangthai == 2) {
            html += `<span style="color:purple">Sắp khởi hành</span>`;
          } else if (tour.Trangthai == 4) {
            html += `<span style="color:Violet">Lịch trình đã hoàn thành</span>`;
          } else {
            html += `<span style="color:red">Lịch trình bị hủy</span>`;
          }

          html += `<br><button style="background-color: #DC143C; color: white; border: 1px solid black; border-radius: 3px" class="delete-btn" onclick="xoalichtrinh(${tour.idsh})">🗑️ Xóa</button>
            </div>`;
        });
        $('#tour-container').html(html);
      } else {
        $('#tour-container').html('Không tìm thấy tour.');
      }
    },
    error: function () {
      $('#tour-container').html('Lỗi khi tải danh sách tour.');
    }
  });
}

 function searchtour(event) {
    // Kiểm tra nếu event có tồn tại và không phải phím Enter thì return
    if (event && event.key !== "Enter") return;

    var searchValue = $('#search').val().trim(); // Lấy giá trị nhập vào ô tìm kiếm
    var departureDate = $('#date').val(); // Lấy giá trị ngày khởi hành

    // Nếu cả hai ô đều trống, gọi hàm xem toàn bộ lịch trình
    if (searchValue === "" && departureDate === "") {
        xemlichtrinh();
        return;
    }

    $.ajax({
        url: './api/apia.php', // Gọi API tìm kiếm tour
        type: 'GET',
        data: { 
            action: 'timtour', 
            MAT: searchValue, 
            date: departureDate 
        },
        dataType: 'json',
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var eventHtml = '';
                response.forEach(function(event) {
                    // Xử lý danh sách HDV
                    let hdvStatus = 'Chưa có';
                    if (event.guides && event.guides.length > 0) {
                        const names = event.guides.map(g => g.Name).join(', ');
                        hdvStatus = `<span class="hdv-name" style="color: green;">${names}</span>`;
                    } else {
                        hdvStatus = `<span class="hdv-name" style="color: orange;">Chưa có</span>`;
                    }

                    eventHtml += `
                    <div class="tour-item" data-id="${event.idsh}" onclick="chonTour(${event.idsh}, '${event.Date}')">
                      <b>${event.Name}</b> <br> Ngày: ${event.Date} <br> Khởi hành: ${event.Locations}
                      <br> Ngày ở: ${event.Day_depart}
                      <br> Lượt đặt: ${event.Orders}
                      <br> Hướng dẫn viên đảm nhiệm: ${hdvStatus}
                      <br> Trạng thái: 
                    `;

                    if(event.Trangthai == 1){
                      eventHtml += `<span style="color:green">Hoạt động</span>`;
                    }else if(event.Trangthai == 2){
                      eventHtml += `<span style="color:purple">Sắp khởi hành</span>`;
                    }else if(event.Trangthai == 4){
                      eventHtml += `<span style="color:Violet">Lịch trình đã hoàn thành</span>`;
                    }else{
                      eventHtml += `<span style="color:red">Lịch trình bị hủy</span>`;
                    }

                    eventHtml += `
                      <br><button style="background-color: #007bff; color: #fff;" class="delete-btn" onclick="xoalichtrinh(${event.idsh})">🗑️ Xóa</button>
                    </div>`;
                });
                $('#tour-container').html(eventHtml);
            } else {
                $('#tour-container').html('Không tìm thấy tour nào.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#tour-container').html('Đã xảy ra lỗi khi tải thông tin.');
        }
    });
}


function xoalichtrinh(id) {
    if (!confirm("Bạn có chắc chắn muốn xóa lịch trình này?")) return;

    $.ajax({
        url: './api/apia.php',
        type: 'GET',
        data: { action: 'xoalichtrinh', id: id },
        success: function (response) {
            if (response === 'delete_success') {
                openPopup('Thông báo', 'Xóa lịch trình thành công');
                xemlichtrinh(); // Cập nhật danh sách sau khi xóa
            } else {
                openPopup('Lỗi', 'Xóa không thành công');
            }
        },
        error: function () {
            openPopup('Lỗi', 'Không thể kết nối với máy chủ');
        }
    });
}

function xemhdv() {
  $.ajax({
    url: './api/apia.php?action=xemHDV',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      if (Array.isArray(response) && response.length > 0) {
        var html = '';
        response.forEach(function (hdv) {
          html += `<option value="${hdv.id}">${hdv.Name}</option>`;
          
        });
        $('#hdv').html(html);
      }
    },
    error: function () {
      $('#hdv').html('<option value="">Lỗi khi tải danh sách hướng dẫn viên.</option>');
    }
  });
}


function chonTour(id, date) {
  $('.tour-item').removeClass('selected');
  $(`[data-id="${id}"]`).addClass('selected');

  $('#selectedTourId').val(id);
  $('#selectedTourdate').val(date);

  // Lấy tên HDV từ phần tử span.hdv-name
  let selectedTour = $(`[data-id="${id}"]`);
  let hdvElement = selectedTour.find('.hdv-name');
  let tenHDV = hdvElement.length ? hdvElement.text().trim() : 'Chưa có';

  $('#tenhdv').text("Tên hướng dẫn viên: " + tenHDV);
}




function capnhathdv() {
  $('#capnhathdv').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
      type: 'POST',
      url: './api/apia.php',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        if (response === 'update_success' || response === 'insert_success') {
          openPopup('Thông báo', 'Cập nhật thành công');
          setTimeout(function () {
            window.location.href = 'indexa.php?hdv';
          }, 2000);
        } else if (response === 'already_assigned') {
          openPopup('Thông báo', 'Hướng dẫn viên đã có trong lịch trình này');
        }
        else if (response === 'duplicate_date') {
          openPopup('Thông báo', 'Hướng dẫn viên này đã có lịch');
        } else if (response.startsWith('schedule_conflict|')) {
          let messageParts = response.split('|');
          openPopup('Cảnh báo', messageParts[1] + '\nVui lòng chọn nhân viên khác');
        } else {
          openPopup('Thông báo', 'Lỗi');
        }
      },
      error: function (xhr, status, error) {
        console.log('AJAX error:', error);
        openPopup('Lỗi', 'Không thể kết nối với máy chủ');
      }
    });
  });
}


</script>
