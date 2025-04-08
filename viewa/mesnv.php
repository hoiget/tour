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
@media (max-width: 480px) {
    #chat-box {
        width: 95%;
        right: 2.5%;
        bottom: 150px;
        padding: 10px;
    }

    #messages {
        height: 180px;
    }

    #chat-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }

    #send-btn,
    #create-room,
    #join-room {
        font-size: 14px;
        padding: 8px;
    }
}
</style>
<div id="chat-icon">
    <i class="fas fa-comment-dots"></i>
</div>

<div id="chat-box">
    <p>Chat với khách hàng</p>
    <form id="guitinnhan">
        <input type="hidden" name="action" value="guitinnhan">
        
        <!-- Danh sách mã phòng -->
        <select id="room-select">
            <option value="">Chọn mã phòng</option>
        </select>

        <div id="messages"></div>
        
        <input type="hidden" name="room_id" id="room_id">
      
        <input type="hidden" name="receiver_id" id="receiver_id" value="<?= $_SESSION['id'] ?? '' ?>">
        <input type="hidden" name="sender_id" id="customer_id">

        <input type="text" name="message" id="message-input" placeholder="Nhập tin nhắn...">
        <button type="submit" id="send-btn">Gửi</button>
    </form>
</div>


<script>
$(document).ready(function () {
    // Khi bấm vào icon chat, mở hoặc đóng hộp thoại
    $("#chat-icon").click(function () {
        $("#chat-box").toggle();
    });

    // Load danh sách phòng chat của nhân viên
    loadRoomList();



    // Load tin nhắn tự động nếu đã chọn mã phòng
    setInterval(function () {
        if ($("#room-select").val()) {
            loadMessages();
        }
    }, 1000);

    // Gửi tin nhắn khi submit form
    $("#guitinnhan").submit(function (e) {
        e.preventDefault();
        sendMessage();
    });

    // Khi chọn phòng, cập nhật input ẩn `customer_id`
    $('#room-select').on('change', function () {
    let selectedOption = $(this).find(':selected'); 
    let customerId = selectedOption.data('customer-id') || ''; 
    console.log("customerId:", customerId); // Kiểm tra dữ liệu
    $('#customer_id').val(customerId);

    let room_id = $(this).val();

    console.log("room_id selected:", room_id); // Kiểm tra giá trị
    if (room_id) {
        loadMessages();
    }
});
});

// ✅ Load danh sách mã phòng của nhân viên
function loadRoomList() {
    $.getJSON('./api/apia.php?action=danhsach_phong_chat', function (response) {
        let options = '<option value="">Chọn mã phòng</option>';
        response.forEach(room => {
            options += `<option value="${room.room_id}" data-customer-id="${room.id}">
                        Phòng ${room.room_id} (${room.customer_name})
                        
                        </option>`;
        });
        $('#room-select').html(options);
    });
}
function xong(id) {
       
       fetch('./api/apia.php?action=xong&id=' + id)
           .then(response => response.text())
          
           .then(data => {
               
               if (data === 'gui') {
                   // Chuyển hướng người dùng sau khi cập nhật thành công
                   openPopup('xong thành công', '');
                   setTimeout(function() {
                       window.location.href = 'indexa.php';
                   }, 1000);
               } else {
                   openPopup('Xóa không thành công','');
               }
           })
           .catch(error => console.error('Lỗi:', error));
}
// ✅ Load tin nhắn trong phòng chat
function loadMessages() {
    let room_id = $('#room-select').val();
    if (!room_id) return;

    $.getJSON('./api/apia.php?action=xemtinnhan&room_id=' + room_id, function (response) {
        console.log("Server Response:", response);
        if (Array.isArray(response)) {
            let chatHtml = '';
            response.forEach(msg => {
                let sender = msg.sender_type === "user" ? `Khách hàng ${msg.customer_name}` : "Bạn";
                chatHtml += `<p><b>${sender}:</b> ${msg.message}</p>`;
               
                
            });
          
            $('#messages').html(chatHtml);
            $('#room_id').val(room_id);
        } else {
            console.error("Lỗi JSON:", response);
        }
    });
}

// ✅ Gửi tin nhắn vào phòng chat
function sendMessage() {
  
    let message = $('#message-input').val().trim();
    let room_id = $('#room-select').val();
    let sender_id = $('#customer_id').val(); // ID của nhân viên
    let receiver_id = $('#receiver_id').val(); // ID khách hàng

    if (!message) {
        alert("Vui lòng nhập tin nhắn.");
        return;
    }
    if (!room_id) {
        alert("Vui lòng chọn mã phòng.");
        return;
    }
    if (!sender_id) {
        alert("Lỗi: Không tìm thấy ID người gửi.");
        return;
    }
    if (!receiver_id) {
        alert("Lỗi: Không tìm thấy ID người nhận.");
        return;
    }

    let formData = new FormData($('#guitinnhan')[0]);

    $.ajax({
        type: 'POST',
        url: './api/apia.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log("Server Response:", response);
            if (response.trim() === 'success') {
                $('#message-input').val('');
                loadMessages();
            } else {
                alert('Gửi tin nhắn thất bại! Lỗi: ' + response);
            }
        },
        error: function (xhr) {
            console.error("AJAX Error:", xhr.responseText);
            alert('Lỗi kết nối! Chi tiết: ' + xhr.responseText);
        }
    });
}


// ✅ Kiểm tra tin nhắn mới




</script>
