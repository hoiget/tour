<style>
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        .search-bar {
            margin-bottom: 10px;
            display: flex;
            justify-content: flex-end;
        }
        .search-bar input {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table thead {
            background-color: #333;
            color: white;
        }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            font-size: 14px;
            text-transform: uppercase;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tbody tr:hover {
            background-color: #f1f1f1;
        }.table-container,.form-container {
    width: 100%; /* Chiều rộng đầy đủ */
    overflow-x: auto; /* Cuộn ngang nếu nội dung vượt quá chiều rộng */
    overflow-y: auto; /* Cuộn dọc nếu cần */
    max-height: 500px; /* Giới hạn chiều cao tối đa */
    border: 1px solid #ddd; /* Đường viền để dễ nhận diện */
    border-radius: 8px;
    background-color: white; /* Đảm bảo nền trắng cho vùng cuộn */
}
</style>



<div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Tiêu đề</th>
                    <th>Tin nhắn</th>
                    <th>Ngày nhắn</th>
                   
                </tr>
            </thead>
           
            <tbody id="employee-table">
                
            </tbody>
                <!-- Add more rows as needed -->
           
        </table>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
      function xemfeedback() {
    $.ajax({
        url: './api/apia.php?action=xemfeedback',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     
                      <tr>
                    <td>${event.id}</td>
                    <td>${event.name}</td>
                    <td>${event.email}</td>
                    <td>${event.subject}</td>
                    <td>${event.message}</td>
                    <td>${event.created_at}</td>
                  
                </tr>`;
                });
                $('#employee-table').html(eventHtml);
            } else {
                $('#employee-table').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#employee-table').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}

$(document).ready(function() {
       
      xemfeedback();
   });
</script>
