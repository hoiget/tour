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
    width: 300px;
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
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 5px;
}

#send-btn:hover {
    background: #0056b3;
}

</style>
<div id="chat-icon">
    <i class="fas fa-comment-dots"></i> <!-- FontAwesome Icon -->
</div>

<div id="chat-box">
    <p>Chat với hướng dẫn viên</p>
    <form class="guitinnhan" id="guitinnhan" action="./api/api.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="guitinnhan">
        <div id="xemtt"></div>

        <div id="messages"></div>
        <input type="text" name="message" id="message-input" placeholder="Nhập tin nhắn...">
        <button id="send-btn">Gửi</button>
    </form>
</div>


<script>
var global_tour_id = null; // Biến lưu tour_id
var messageInterval = null; // Lưu setInterval để tránh tạo nhiều lần

function xemtt(callback) {
    $.ajax({
        url: './api/api.php?action=xemthongtiner',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("Dữ liệu từ API xemthongtiner:", response);
            if (Array.isArray(response) && response.length > 0) {
                var event = response[0]; // Lấy tour đầu tiên
                global_tour_id = event.id_tour; // Lưu tour_id vào biến toàn cục
                
                var eventHtml = `
                    <input type="hidden" name="tour_id" id="tour_id" value="${event.id_tour}">
                    <input type="hidden" name="receiver_id" id="receiver_id" value="${event.employid}">
                `;

                $('#xemtt').html(eventHtml);

                // Gọi callback sau khi có tour_id
                if (typeof callback === "function") {
                    callback(global_tour_id);
                }
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

function loadMessages(id) {
    if (!id) {
        console.warn("Không có tour_id, không thể tải tin nhắn.");
        return;
    }
    
    $.ajax({
        url: './api/api.php?action=xemtinnhan&idt=' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("Tin nhắn nhận được:", response);
            var eventHtml = '';
            if (Array.isArray(response) && response.length > 0) {
                response.forEach(function(event) {
                    if (event.sender_type === "guide") {
                        eventHtml += `<p><b>Hướng dẫn viên :</b> ${event.message}</p>`;
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

// 🟢 Gọi xemtt() trước, sau đó setInterval để cập nhật tin nhắn
xemtt(function(tour_id) {
    loadMessages(tour_id); // Tải lần đầu ngay lập tức

    // Xóa interval cũ nếu có (tránh lặp nhiều lần)
    if (messageInterval) clearInterval(messageInterval);

    // Cập nhật tin nhắn mỗi 1 giây
    messageInterval = setInterval(function() {
        loadMessages(global_tour_id);
    }, 1000);
});


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

$(document).ready(function () {
    // Toggle hiển thị chatbox khi bấm icon
    $("#chat-icon").click(function () {
        $("#chat-box").toggle();
    });

    // Gọi các hàm chat
    guitinnhan();
    xemtt(function(tour_id) {
        loadMessages(tour_id);

        if (messageInterval) clearInterval(messageInterval);
        messageInterval = setInterval(function() {
            loadMessages(global_tour_id);
        }, 1000);
    });
});
   


</script>
