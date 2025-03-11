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

  .form-container select {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
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

</style>

<h1>Phân lịch hướng dẫn viên</h1>

<div class="container">
  <!-- Cột trái: Danh sách tour -->
  
  <div class="tour-list">
    <h3>Danh sách tour</h3>

    <div id="tour-container"></div>
  </div>

  <!-- Cột phải: Danh sách hướng dẫn viên -->
  <div class="guide-list">
  Tìm kiếm: <input type="text" id="search" name="MAT" placeholder="Mã tour/tên tour" onkeydown="searchtour(event)"> <br><br><br>
    <h3>Chọn hướng dẫn viên</h3>
    <form id="capnhathdv" action="./api/apia.php" method="post">
    <input type="hidden" name="action" value="capnhathdv">
      <input type="hidden" name="id" id="selectedTourId">
      <input type="datetime" hidden name="date" id="selectedTourdate">

      <div class="form-group">
        <label for="hdv">Tên nhân viên:</label>
        <select name="hdv1" id="hdv">
          <option value="" selected>Chọn nhân viên</option>
        </select>
      </div>
<br>
      <button type="submit" class="submit-btn">Cập nhật</button>
      </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    xemlichtrinh();
    xemhdv();
    capnhathdv();
  });

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
            if(tour.ngaykhoihanh == null){  
                html += ``;
            }else{
                html += `<div class="tour-item" data-id="${tour.idsh}" onclick="chonTour(${tour.idsh}, '${tour.Date}')">
                      <b>${tour.Name}</b> <br> Ngày: ${tour.Date} <br> Khởi hành: ${tour.Locations}
                    
                      <br> Ngày ở: ${tour.Day_depart}
                      <br> Lượt đặt: ${tour.Orders}
                
                     <br> Hướng dẫn viên đảm nhiệm: ${tour.emna || "Chưa có"}
                    </div>`;
            }
           
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
    if (event && event.key === "Enter") {  // Kiểm tra nếu event và phím bấm là Enter
        var searchValue = $('#search').val(); // Lấy giá trị từ ô input với id "search"

        // Nếu không có gì để tìm kiếm, không làm gì
        if (searchValue.trim() === "") {
            $('#tour-container').html(""); // Xóa kết quả tìm kiếm
            return;
        }

        $.ajax({
            url: './api/apia.php', // API tìm kiếm nhân viên
            type: 'GET', // Sử dụng phương thức GET
            data: { action: 'timtour', MAT: searchValue }, // Gửi mã nhân viên tìm kiếm qua GET
            dataType: 'json', // Kết quả trả về là JSON
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    var events = response;
                    var eventHtml = '';
                    events.forEach(function(event) {
                        eventHtml += `
                     
                    <div class="tour-item" data-id="${event.idsh}" onclick="chonTour(${event.idsh}, '${event.Date}')">
                      <b>${event.Name}</b> <br> Ngày: ${event.Date} <br> Khởi hành: ${event.Locations}
                 
                      <br> Ngày ở: ${event.Day_depart}
                      <br> Lượt đặt: ${event.Orders}
                      <br> Hướng dẫn viên đảm nhiệm: ${event.emna || "Chưa có"}
                    </div>`;
               
                    });
                    $('#tour-container').html(eventHtml);
                } else {
                    $('#tour-container').html('<tr><td colspan="8">Không tìm thấy tour nào.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi lấy thông tin:', error);
                $('#tour-container').html('<tr><td colspan="8">Đã xảy ra lỗi khi tải thông tin.</td></tr>');
            }
        });
    }
}
  function xemhdv() {
    $.ajax({
      url: './api/apia.php?action=xemHDV',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (Array.isArray(response) && response.length > 0) {
          var html = '<option value="" selected>Chọn nhân viên</option>';
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
    console.log("Selected Tour ID:", id, "Date:", date); // Debug
    $('.tour-item').removeClass('selected');
    $(`[data-id="${id}"]`).addClass('selected');

    $('#selectedTourId').val(id);
    $('#selectedTourdate').val(date);
}


  function capnhathdv() {
    $('#capnhathdv').submit(function (e) {
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
                console.log(response); // Để kiểm tra chính xác dữ liệu phản hồi
                if (response === 'update_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?hdv';
                    }, 2000);
                }else if (response === 'insert_success') {
                    openPopup('Thông báo', 'Cập nhật thành công');
                    setTimeout(function () {
                        window.location.href = 'indexa.php?hdv';
                    }, 2000);
                }
                else if (response === 'duplicate_date') {
                    openPopup('Thông báo', 'Hướng dẫn viên này đã có lịch');
                }
                else if (response.startsWith('schedule_conflict|')) {
                    let messageParts = response.split('|');
                    openPopup('Cảnh báo',messageParts[1]+'\nVui lòng chọn nhân viên khác');
                } 
                 else{
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
