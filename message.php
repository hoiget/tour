
<style>
/* Nút mở chatbox */
.chat-toggle {
    position: fixed;
    bottom: 20px;
    left: 20px;
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
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, background-color 0.3s ease;
    z-index: 100;
}

.chat-toggle:hover {
    background-color: #0056b3;
    transform: scale(1.1);
}

/* Chatbox */
.chatbox {
    position: fixed;
    bottom: 90px;
    left: 20px;
    width: 400px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: none; /* Ẩn mặc định */
    flex-direction: column;
    overflow: hidden;
    z-index: 25;
    animation: slide-in 0.3s ease-out;
}

@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chatbox-header {
    background-color: #007bff;
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
}

.input-container {
    display: flex;
    padding: 10px;
    background-color: #f9f9f9;
    gap: 10px;
}

.input-container input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.input-container button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.input-container button:hover {
    background-color: #0056b3;
}

#buttop{
    width:100% ;
}
.popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #f9f9f9;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    max-width: 400px;
    width: 300px;
    text-align: center;
    z-index: 9999;
}

.popup h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

.popup p {
    color: #666;
    font-size: 16px;
    margin-bottom: 20px;
}

.popup button {
    padding: 8px 20px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}
/* Tin nhắn container */
/* Container tin nhắn */
.message-container {
    display: flex;
    max-width: 70%; /* Giới hạn độ rộng tin nhắn */
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    word-wrap: break-word;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

/* Tin nhắn bên trái */
.left-message {
    align-self: flex-start; /* Căn về bên trái */
    background-color: #fff8e6; /* Màu nền */
    border: 1px solid orange;
    text-align: left;
    margin-right: auto; /* Đẩy sang bên trái */
}

/* Tin nhắn bên phải */
.right-message {
    align-self: flex-end; /* Căn về bên phải */
    background-color: #e6f7ff; /* Màu nền */
    border: 1px solid blue;
    text-align: right;
    margin-left: auto; /* Đẩy sang bên phải */
}

/* Nội dung tin nhắn */
.message-content p {
    margin: 0;
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.message-content span {
    font-size: 12px;
    color: gray;
    margin-top: 5px;
    display: block;
}
.messages {
    display: flex;
    flex-direction: column;
    gap: 10px;
    height: 300px;
    overflow-y: auto;
    padding: 10px;
    background-color: #f9f9f9;
}


    </style>

    <!-- Nút mở Chatbox -->
    <div class="chat-toggle">💬</div>

    <!-- Khung Chatbox -->
    <div class="chatbox">
        <div class="chatbox-header">Chat</div>
        <div class="messages" id="messages"></div>
        <div class="input-container">
            <form id="guitinnhan" action="./api/api.php" method="post">
                <input type="hidden" name="action" value="guitinnhan">
                
                <input type="text" id="message-input" name="message" placeholder="Nhập tin nhắn...">
                <button type="button" id="send-button">Gửi</button>
        
            </form>
        </div>
    </div>

    <!-- Thêm jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- <script>
        // Định nghĩa biến sessionId
   

    

function xembox() {
    $.ajax({
        url: './api/api.php?action=xemtinnhan',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && response.length > 0) {
                let events = response;
                let eventHtml = '';

                events.forEach(function(event) {
                    const timeAgo = getTimeAgo(event.Timestamp); // Tính thời gian "time ago"

                    if (sessionId == event.UserId) {
                        eventHtml += `
                            <div style="margin-bottom: 10px; word-wrap: break-word;width:100%;border:1px solid blue;box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);">
                                <p style="font-size:14px; color:blue; margin: 0; font-weight: bold;padding-left:7px">
                                    
                                    ${event.message}
                               

                                </p>
                                
                                <span style="font-size:12px; color:gray;padding-left:7px">${timeAgo}</span>
                            </div>
                        `;
                    } else {
                        eventHtml += `
                            <div style="margin-bottom: 10px; word-wrap: break-word;border:1px solid blue;width:100%;box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);">
                                <p style="font-size:14px; color: orange; margin: 0; font-weight: bold;padding-left:7px">
                                    ${event.UserName}
                                </p>
                               <p style="font-size:14px; color:black; margin: 0; font-weight: bold;padding-left:7px">
                                    ${event.message}
                                </p>
                                <span style="font-size:12px; color:gray;padding-left:7px">${timeAgo}</span>
                            </div>
                        `;
                    }
                });

                $('#messages').html(eventHtml);
            } else {
                $('#messages').html('<div class="col">Không có tin nhắn nào.</div>');
            }
        },
        error: function() {
            console.error("Lỗi khi tải tin nhắn.");
        }
    });
}


        // Hàm xử lý gửi tin nhắn
        function guibox() {
    // Hàm chung để gửi tin nhắn
    function sendMessage() {
        const message = $('#message-input').val();
        if (!message.trim()) {
            alert("Vui lòng nhập tin nhắn!");
            return;
        }

        $.ajax({
            url: './api/api.php',
            type: 'POST',
            data: $('#guitinnhan').serialize(), // Lấy dữ liệu từ form
            success: function(response) {
                console.log(response)
                $('#message-input').val(''); // Xóa nội dung input sau khi gửi
                xembox(); // Tải lại danh sách tin nhắn
            },
            error: function() {
                alert("Gửi tin nhắn thất bại.");
            }
        });
    }

    // Lắng nghe sự kiện submit của form
    $('#guibox').on('submit', function(e) {
        e.preventDefault(); // Ngăn hành vi mặc định của form
        sendMessage(); // Gọi hàm gửi tin nhắn
    });

    // Lắng nghe sự kiện click của nút gửi
    $('#send-button').on('click', function(e) {
        e.preventDefault(); // Ngăn hành vi mặc định (phòng trường hợp nút trong form)
        sendMessage(); // Gọi hàm gửi tin nhắn
    });
}


        // Khi tài liệu đã sẵn sàng
        $(document).ready(function() {
            // Gọi hàm
           
            guibox();

            // Sự kiện bật/tắt chatbox
            $('.chat-toggle').on('click', function () {
                $('.chatbox').toggle();
            });

            // Tải tin nhắn mới mỗi 5 giây
            setInterval(xembox, 1000);
        });
       
    </script> -->
<script>

$(document).ready(function () {
    // Biến toàn cục
   
   
      // Hàm xembox: lấy tin nhắn từ API
      function getTimeAgo(sentAt) {
    const sentTime = new Date(sentAt).getTime(); // Chuyển thời gian gửi thành timestamp
    const currentTime = Date.now(); // Lấy timestamp hiện tại
    const timeDiff = Math.abs(currentTime - sentTime) / 1000; // Khoảng cách thời gian tính bằng giây

    let timeAgo = "";

    if (timeDiff < 60) {
        timeAgo = Math.floor(timeDiff) + " giây trước";
    } else if (timeDiff < 3600) {
        const minutesAgo = Math.floor(timeDiff / 60);
        timeAgo = minutesAgo + " phút trước";
    } else if (timeDiff < 86400) {
        const hoursAgo = Math.floor(timeDiff / 3600);
        timeAgo = hoursAgo + " giờ trước";
    } else {
        const daysAgo = Math.floor(timeDiff / 86400);
        timeAgo = daysAgo + " ngày trước";
    }

    return timeAgo;
}
    // Hàm tải tin nhắn
    function xembox() {
    $.ajax({
        url: './api/api.php?action=xemtinnhan',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("Session ID inside xembox:", sessionId); // Kiểm tra giá trị của sessionId

            if (response && response.length > 0) {
                let events = response;
                let eventHtml = '';
            
                events.forEach(function(event) {
                    const timeAgo = getTimeAgo(event.Timestamp); // Tính thời gian "time ago"

                    if (sessionId == event.UserId) {
                        // Tin nhắn người dùng (bên phải)
                        eventHtml += `
                            <div class="message-container right-message">
                                <div class="message-content">
                                    <p>${event.message}</p>
                                    <span>${timeAgo}</span>
                                </div>
                            </div>`;
                    } else {
                        // Tin nhắn nhân viên (bên trái)
                        eventHtml += `
                            <div class="message-container left-message">
                                <div class="message-content">
                                    <p><strong>${event.UserName}:</strong> ${event.message}</p>
                                    <span>${timeAgo}</span>
                                </div>
                            </div>`;
                    }
                });

                $('#messages').html(eventHtml);
            } else {
                $('#messages').html('<div class="col">Không có tin nhắn nào.</div>');
            }
        },
        error: function() {
            console.error("Lỗi khi tải tin nhắn.");
        }
    });
}

    // Hàm gửi tin nhắn
    function guibox() {
        const message = $('#message-input').val().trim();
        if (!message) {
            alert("Vui lòng nhập tin nhắn!");
            return;
        }

        $.ajax({
            url: './api/api.php',
            type: 'POST',
            data: $('#guitinnhan').serialize(),
            success: function () {
                $('#message-input').val('');
                xembox();
            },
            error: function () {
                alert("Gửi tin nhắn thất bại.");
            }
        });
    }

    // Gọi hàm gửi tin nhắn khi nhấn nút gửi
    $('#send-button').on('click', function (e) {
        e.preventDefault();
        guibox();
    });

    // Bật/tắt chatbox
    $('.chat-toggle').on('click', function () {
        $('.chatbox').slideToggle();
    });

    // Tự động tải tin nhắn mỗi giây
    setInterval(xembox, 1000);
});
</script>
