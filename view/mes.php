<style>
    /* Icon tin nhắn */
#chat-icon {
    position: fixed;
    bottom: 20px;
    left: 20px;
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
    z-index: 100;
}

#chat-icon:hover {
    background-color: #0056b3;
}

/* Chatbox ẩn mặc định */
#chat-box {
    position: fixed;
    bottom: 80px;
    left: 20px;
    width: 400px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    padding: 15px;
    display: none;
    flex-direction: column;
    z-index: 1000;
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
    <p>Chat với chăm sóc khách hàng</p>
    <form class="guitinnhan" id="guitinnhan" action="./api/api.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="guitinnhan">
        <div id="xemtt"></div>

        <div id="messages"></div>
        <input type="text" name="message" id="message-input" placeholder="Nhập tin nhắn...">
        <button id="send-btn">Gửi</button>
    </form>
</div>


<script>


function xemtt() {
    $.ajax({
        url: './api/api.php?action=xemthongnv',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        
            if (Array.isArray(response) && response.length > 0) {
                var event = response[0]; // Lấy tour đầu tiên
                global_tour_id = event.id_tour; // Lưu tour_id vào biến toàn cục
                
                var eventHtml = `
                 
                    <input type="hidden" name="receiver_id" id="receiver_id" value="${event.employee_id}">
                `;

                $('#xemtt').html(eventHtml);

                // Gọi callback sau khi có tour_id
               
            } else {
                $('#xemtt').html('<div class="col">Không tìm thấy thông tin.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#xemtt').html('<div class="col">Lỗi khi tải thông tin.</div>');
        }
    });
}

function loadMessages() {
   
    $.ajax({
        url: './api/api.php?action=xemtinnhan',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
         
            var eventHtml = '';
            if (Array.isArray(response) && response.length > 0) {
                response.forEach(function(event) {
                    if (event.sender_type === "guide") {
                        eventHtml += `<p><b>Nhân viên chăm sóc khách hàng :</b> ${event.message}</p>`;
                    } else if (event.sender_type === "user") {
                        eventHtml += `<p><b>Bạn :</b> ${event.message}</p>`;
                    }
                });
                $('#messages').html(eventHtml);
            } else {
                $('#messages').html('<div class="col">Không có tin nhắn.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy tin nhắn:', error);
            $('#messages').html('<div class="col">Lỗi khi tải tin nhắn.</div>');
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
            url: './api/api.php',
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

function markMessagesAsRead(guide_id) {
    $.ajax({
        url: './api/api.php?action=mark_as_read',
        type: 'GET',
        data: { guide_id: guide_id },
        success: function(response) {
            $('#chat-icon').removeClass('new-message'); // Xóa chấm đỏ sau khi đọc
        }
    });
}

function markMessagesAsRead() {
    var receiver_id = $('#receiver_id').val(); // Lấy giá trị của receiver_id
    if (!receiver_id) return;

    $.ajax({
        url: './api/api.php?action=mark_as_read',
        type: 'GET',
        data: { receiver_id: receiver_id }, // Gửi ID người nhận
        success: function(response) {
            console.log(response);
            $('#chat-icon').removeClass('new-message'); // Xóa chấm đỏ khi đọc
        },
        error: function(xhr, status, error) {
            console.error("Lỗi khi đánh dấu tin nhắn đã đọc:", error);
        }
    });
}


// Khi receiver_id thay đổi, thực hiện load tin nhắn
$('#receiver_id').on('change', function() {
    markMessagesAsRead(); // Gọi khi thay đổi người nhận
    loadMessages();
});



function checkNewMessages() {
    $.ajax({
        url: './api/api.php?action=check_new_messages',
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
        markMessagesAsRead();
    });

    // Gọi các hàm chat
    guitinnhan();
    xemtt();
    setInterval(loadMessages, 1000)

});
</script>
