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
    <i class="fas fa-comment-dots"></i>
</div>

<div id="chat-box">
    <p>Chọn nhân viên chăm sóc khách hàng</p>
    <select id="employee-select">
        <option value="">Chọn nhân viên...</option>
    </select>
    <button id="create-room">Tạo phòng chat</button>
    <p>Hoặc nhập mã phòng:</p>
    <input type="text" id="room-id-input" placeholder="Nhập mã phòng">
    <button id="join-room">Vào phòng</button>
    <div id="messages"></div>
    <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
    <button id="send-btn">Gửi</button>
</div>

<script>
$(document).ready(function () {
    let currentRoomId = localStorage.getItem('currentRoomId') || null;
   


    function fetchEmployees() {
        $.getJSON('./api/api.php?action=danhsachcskh', function (data) {
            let options = '<option value="">Chọn nhân viên...</option>';
            data.forEach(emp => {
                options += `<option value="${emp.id}">${emp.Name}</option>`;
            });
            $('#employee-select').html(options);
        });
    }

    function createRoom() {
    let employeeId = $('#employee-select').val();
    if (!employeeId) return alert('Vui lòng chọn nhân viên!');

    let requestData = { user_id: sessionId, employee_id: employeeId };
    console.log("Gửi yêu cầu tạo phòng:", requestData);

    $.post('./api/phancong.php?action=taophong', requestData)
        .done(function (response) {
            console.log("Phản hồi từ API taophong:", response);
            if (response.room_id) {
                currentRoomId = response.room_id;
                localStorage.setItem('currentRoomId', currentRoomId);
                alert('Mã phòng: ' + currentRoomId);
                loadMessages();
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Lỗi API taophong:", status, error);
        });
}


function joinRoom() {
    let roomId = $('#room-id-input').val();
    if (!roomId) return alert('Nhập mã phòng!');
    
    currentRoomId = roomId;
    localStorage.setItem('currentRoomId', currentRoomId);
    console.log("Tham gia phòng:", roomId);

    loadMessages();
}

function loadMessages() {
    if (!currentRoomId) return;
    
    console.log("Tải tin nhắn cho phòng:", currentRoomId);

    $.getJSON(`./api/api.php?action=xemtinnhan&room_id=${currentRoomId}`)
        .done(function (data) {
            console.log("Tin nhắn nhận được:", data);
            let messages = '';
            data.forEach(msg => {
                let sender = msg.sender_type === 'user' ? 'Bạn' : 'Nhân viên';
                messages += `<p><b>${sender}:</b> ${msg.message}</p>`;
            });
            $('#messages').html(messages);
        })
        .fail(function (xhr, status, error) {
            console.error("Lỗi API xemtinnhan:", status, error);
        });
}

function sendMessage() {
    let message = $('#message-input').val().trim();
    if (!currentRoomId || message === '') {
        alert("Vui lòng nhập tin nhắn!");
        return;
    }

    let requestData = {
        sender_id: sessionId,  // ID người gửi từ session
        room_id: currentRoomId,
        sender_type: 'user',
        message: message
    };

    console.log("🔄 Gửi tin nhắn:", requestData);

    $.post('./api/phancong.php?action=guitinnhan', requestData)
    .done(function (response) {
        try {
            let jsonResponse = JSON.parse(response); // Chắc chắn dữ liệu là JSON
            console.log("✅ Tin nhắn gửi thành công:", jsonResponse);

            if (jsonResponse.success) {
                $('#message-input').val('');
                loadMessages();
            } else {
                console.error("❌ Lỗi từ API:", jsonResponse.message);
            }
        } catch (error) {
            console.error("❌ Lỗi JSON parse:", error, response);
        }
    })
    .fail(function (xhr, status, error) {
        console.error("❌ Lỗi API guitinnhan:", status, error, xhr.responseText);
    });

}



    $('#create-room').click(createRoom);
    $('#join-room').click(joinRoom);
    $('#send-btn').click(sendMessage);
    fetchEmployees();
    if (currentRoomId) loadMessages();
    setInterval(loadMessages, 5000);
    $("#chat-icon").click(function () {
        $("#chat-box").toggle();
        
    });

});
</script>

