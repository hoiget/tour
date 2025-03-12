<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Icon tin nhắn */
#chat-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background-color: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.3s ease-in-out;
    z-index: 1000;
}

#chat-icon:hover {
    background-color: #0056b3;
}

/* Chatbox ẩn mặc định */
#chat-box {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 400px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    padding: 15px;
    display: none;
    flex-direction: column;
    z-index: 100;
}
#chat-box p{
color:black;
}
/* Khu vực hiển thị tin nhắn */
#messages {
    height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    background: #f9f9f9;
}
#messages p,b{
    color:black;
}
/* Ô nhập tin nhắn */
#message-input {
    width: calc(100% - 60px);
    padding: 8px;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Nút gửi */
#send-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 5px;
}

#send-btn:hover {
    background: #0056b3;
}
#chat-icon.new-message::after {
    content: '';
    position: absolute;
    top: 5px;
    right: 5px;
    width: 10px;
    height: 10px;
    background-color: red;
    border-radius: 50%;
}

</style>
<div id="chat-icon">
    <i class="fas fa-comment-dots"></i> <!-- FontAwesome Icon -->
</div>

<div id="chat-box">
    <p>Chat với khách hàng</p>
    <form class="guitinnhan" id="guitinnhan" action="./api/apia.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="guitinnhan">
    <select id="customer-select" onchange="loadMessages()">
        <option value="">Chọn khách hàng</option>
    </select>
    <div id="messages"></div>
   
        <input type="hidden" name="sender_id" id="sender_id" >
      
        <input type="text" name="message" id="message-input" placeholder="Nhập tin nhắn...">
        <button type="submit" id="send-btn">Gửi</button>
    </form>
</div>



<script>
function loadCustomerList() {
    $.ajax({
        url: './api/apia.php?action=danhsach_khachhang',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var options = '<option value="">Chọn khách hàng</option>';
            response.forEach(function(customer) {
                options += `<option value="${customer.id}">${customer.Name}</option>`;
            });
            $('#customer-select').html(options);
        }
    });
}


function loadMessages() {
    var customer_id = $('#customer-select').val();
    if (!customer_id) return;

    $.ajax({
        url: './api/apia.php?action=xemtinnhan&customer_id=' + customer_id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var eventHtml = '';
            response.forEach(function(event) {
                if (event.sender_type === "user") {
                    eventHtml += `<p><b>Khách hàng ${event.Name}:</b> ${event.message}</p>`;
                } else {
                    eventHtml += `<p><b>Bạn:</b> ${event.message}</p>`;
                }
            });
            $('#messages').html(eventHtml);
            $('#sender_id').val(customer_id);
        }
    });
}





function guitinnhan() {
    $('#guitinnhan').submit(function (e) {
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
                console.log(response);
                if (response === 'success') {
                   
                    
                }  else  {
                    openPopup('Thông báo', 'lỗi');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                openPopup('Lỗi', 'Không thể kết nối với máy chủ');
            }
        });
    });
}
function markMessagesAsRead(customer_id) {
    $.ajax({
        url: './api/apia.php?action=mark_as_read',
        type: 'GET',
        data: { customer_id: customer_id },
        success: function(response) {
            $('#chat-icon').removeClass('new-message'); // Xóa chấm đỏ sau khi đọc
        }
    });
}

$('#customer-select').on('change', function() {
    var customer_id = $(this).val();
    if (customer_id) {
        markMessagesAsRead(customer_id);
        loadMessages(); // Hiển thị tin nhắn của khách hàng
    }
});


function checkNewMessages() {
    $.ajax({
        url: './api/apia.php?action=check_new_messages',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.new_messages > 0) {
                $('#chat-icon').addClass('new-message');
            } else {
                $('#chat-icon').removeClass('new-message');
            }
        }
    });
}
setInterval(checkNewMessages, 1000);

$(document).ready(function () {
    // Toggle hiển thị chatbox khi bấm icon
    $("#chat-icon").click(function () {
        $("#chat-box").toggle();
    });

    // Gọi các hàm chat
    guitinnhan();
    loadCustomerList();
    setInterval(loadMessages, 1000)

});
</script>
