<style>
    /* Icon tin nhắn */
#chat-icon {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 60px;
    height: 60px;
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
    bottom: 160px;
    
    right: 20px;
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
   /* Nút micro cố định góc phải dưới */
   #micButton {
      position: fixed;
      bottom: 160px;
      right: 20px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 28px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      z-index: 100;
    }

    #micButton:hover {
      background: #0056b3;
    }

    /* Hiệu ứng khi ghi âm */
    #micButton.recording {
      background: red;
      animation: pulse 1s infinite;
    }

    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(255,0,0,0.7); }
      70% { box-shadow: 0 0 0 15px rgba(255,0,0,0); }
      100% { box-shadow: 0 0 0 0 rgba(255,0,0,0); }
    }

    /* Input bên trái mic */
    #floatingInput {
      position: fixed;
      bottom: 170px;
      right: 90px;
      width: 250px;
      padding: 10px;
      font-size: 16px;
      display: none;
      z-index: 998;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

</style>
  <!-- Input nổi bên trái icon mic -->
  <input type="text" id="floatingInput" placeholder="Nói hoặc nhập lệnh..." />
 
  <!-- Nút micro nổi góc dưới phải -->
  <button id="micButton" onclick="startVoice('ui')">🎙️</button>

<div id="chat-icon">
    <i class="fas fa-comment-dots"></i>
</div>

<div id="chat-box">
    <p>Chọn nhân viên chăm sóc khách hàng:</p>
    <select id="employee-select" style="height: 30px;">
        <option value="">Chọn nhân viên</option>
    </select>
    <button id="create-room" style="border: 1px solid grey; border-radius: 5px;">Tạo phòng chat</button>
    <p style="margin-top: 5px">Hoặc nhập mã phòng:</p>
    <input type="text" id="room-id-input" placeholder="Nhập mã phòng">
    <button id="join-room" style="border: 1px solid grey; border-radius: 5px; height: 30px;">Vào phòng chat</button>
    <div id="messages" style="margin-top: 10px"></div>
    <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
    <button id="send-btn">Gửi</button>
</div>
<script>
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'vi-VN';
    recognition.continuous = false;
    recognition.interimResults = false;

    let currentMode = ''; // 'search' hoặc 'ui'

    function startVoice(mode) {
      currentMode = mode;
      recognition.start();
      document.getElementById('micButton').classList.add('recording');

      if (mode === 'ui') {
        const floatingInput = document.getElementById('floatingInput');
        floatingInput.style.display = 'block';
        floatingInput.focus();

        
      }
    }

    recognition.onresult = function(event) {
      const text = event.results[0][0].transcript.trim();

      if (currentMode === 'search') {
        const input = document.getElementById('searchInput');
        input.value += (input.value ? ' ' : '') + text;
        input.focus();
      } else if (currentMode === 'ui') {
        const floatingInput = document.getElementById('floatingInput');
        floatingInput.value += (floatingInput.value ? ' ' : '') + text;
        floatingInput.focus();
        processCommand(floatingInput.value);
      }
    };

    recognition.onend = function() {
      document.getElementById('micButton').classList.remove('recording');
    };

    recognition.onerror = function(event) {
      alert("Lỗi giọng nói: " + event.error);
      document.getElementById('micButton').classList.remove('recording');
    };

    // Nhấn Enter trong input nổi để xử lý
    document.getElementById('floatingInput').addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        processCommand(this.value);
      }
    });

    function processCommand(commandRaw) {
      const command = commandRaw.toLowerCase().trim();
     

      if (command.includes("giới thiệu")) {
       
        window.location.href = "index.php?about";
      } else if (command.includes("liên hệ")) {
        window.location.href = "index.php?contact";
      }else if (command.includes("tin tức")) {
        window.location.href = "index.php?tintuc";
      } else if (command.includes("cá nhân")) {
        window.location.href = "index.php?ttcnkh";
      } else if (command.includes("xem tour")) {
        window.location.href = "index.php?tour";
      } else if (command.includes("xem sản phẩm")) {
        window.location.href = "index.php?tour";
      } else if (command.includes("đặt tour")) {
        window.location.href = "index.php?tour";
      } else if (command.includes("đặt phòng")) {
        window.location.href = "index.php?ks";
      } else if (command.includes("xem khách sạn")) {
        window.location.href = "index.php?ks";
      } else if (command.includes("khách sạn")) {
        window.location.href = "index.php?ks";
      } else if (command.includes("xem phòng")) {
        window.location.href = "index.php?ks";
      }else if (command.includes("thuê xe")) {
        window.location.href = "index.php?thuexe";
      } else if (command.includes("theo yêu cầu")) {
        window.location.href = "index.php?custom_tour";
      }else if (command.includes("nam")) {
        window.location.href = "index.php?tour&mien=Nam";
      }else if (command.includes("bắc")) {
        window.location.href = "index.php?tour&mien=Bắc";
      }else if (command.includes("trung")) {
        window.location.href = "index.php?tour&mien=Trung";
      }else if (command.includes("tây")) {
        window.location.href = "index.php?tour&mien=Tây";
      }else if (command.includes("nước ngoài")) {
        window.location.href = "index.php?tour&mien=Ngoài nước";
      }else if (command.includes("xem đơn")) {
        window.location.href = "index.php?xemdattour";
      }else if (command.includes("xem đơn khách sạn")) {
        window.location.href = "index.php?xemdatks";
      }else if (command.includes("xem đơn thuê xe")) {
        window.location.href = "index.php?xemxe";
      }else if (command.includes("yêu thích")) {
        window.location.href = "index.php?yeuthich";
      }else if (command.includes("trang chủ")) {
        window.location.href = "index.php";
      }
      else if (command.includes("tìm kiếm")) {
        const searchInput = document.getElementById('tour');
        searchInput.focus();
      }
      else if (command.includes("liên hệ")) {
        window.location.href = "index.php?contact";
      } 
      else if (command.includes("đăng xuất")) {
        window.location.href = "./logout.php";
      } 
       else if(command.includes("cuộn xuống")) {
       
        window.scrollBy(0, 1000);
      } 
    }
  </script>

<script>
$(document).ready(function () {
    let currentRoomId = localStorage.getItem('currentRoomId') || null;
   


    function fetchEmployees() {
        $.getJSON('./api/api.php?action=danhsachcskh', function (data) {
            let options = '<option value="">Chọn nhân viên</option>';
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
    
   

    $.getJSON(`./api/api.php?action=xemtinnhan&room_id=${currentRoomId}`)
        .done(function (data) {
            
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
    setInterval(loadMessages, 1000);
    $("#chat-icon").click(function () {
        $("#chat-box").toggle();
        
    });

});
</script>

