<style>
   .leave-list table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', sans-serif;
    }

    .leave-list th, .leave-list td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    .leave-list th {
        background-color: #f8f8f8;
    }

    .leave-list tr:hover {
        background-color: #f0f0f0;
    }

.leave-list div {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
}
.leave-list div:hover {
    background: #f0f0f0;
}


.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow: auto;
}

.modal-content {
    background-color: #fff;
    margin: 40px auto;
    padding: 30px;
    border-radius: 12px;
    width: 80%; /* 👈 tăng kích thước modal */
    max-width: 900px; /* 👈 giới hạn chiều rộng tối đa */
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    font-family: "Segoe UI", sans-serif;
}

.close {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.modal-actions {
    text-align: center;
    margin-top: 24px;
}

.modal-actions button {
    background: #28a745;
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.modal-actions button:hover {
    background: #218838;
}

#approveBtn {
    margin-top: 20px;
    background: green;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

</style>


<div id="leaveList" class="leave-list"></div>

<!-- Modal xem chi tiết đơn -->
<div id="leaveModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="leaveDetailContent"></div>
      
    </div>
</div>

<div id="rejectPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="$('#rejectPopup').hide()">&times;</span>
        <h3>Lý do từ chối đơn</h3>
        <textarea id="rejectReason" rows="4" style="width: 100%; padding: 10px; margin-top: 10px;"></textarea>
        <div class="modal-actions">
            <button onclick="submitReject()">Xác nhận từ chối</button>
        </div>
    </div>
</div>

<script>
function loadLeaveRequests() {
    $.getJSON('./api/phancong.php?action=list', function(data) {
        let html = `
            <table>
                <thead>
                    <tr>
                        <th>Tên nhân viên</th>
                        <th>Lý do nghỉ</th>
                        <th>Thời gian nghỉ</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
        `;
        data.forEach(function(row) {
            html += `
                <tr onclick="showDetail(${row.id})">
                    <td>${row.name}</td>
                    <td>${row.reason}</td>
                    <td>${formatVietnamDate(row.from_date)} đến ${formatVietnamDate(row.to_date)}</td>
                    <td>${row.status}</td>
                    
                </tr>
            `;
        });
        html += `
                </tbody>
            </table>
        `;
        $('#leaveList').html(html);
    });
}

function showDetail(id) {
    $.getJSON('./api/phancong.php?action=getnhan&id=' + id, function(data) {
        let html = `
            <div style="max-width: 800px; margin: auto; font-family: 'Times New Roman', serif;">
                <h3 style="text-align: center; font-weight: bold; line-height: 1.5;">
                    CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>
                    <span style="text-decoration: underline;">Độc lập – Tự do – Hạnh phúc</span>
                </h3>
                <h2 style="text-align: center; text-transform: uppercase; margin-top: 20px;">Đơn xin nghỉ phép</h2>
                <p><b>Kính gửi:</b> Ban Giám Đốc Công Ty</p>
                <p style="margin-left: 20px;">– Trưởng Phòng Tổ chức – Hành chính</p>
                <p style="margin-left: 20px;">– Trưởng ${data.department || "....................."}</p>
                <p>Tên tôi là: <b>${data.employee_name || '.....................'}</b></p>
                <p>Chức vụ: ${data.position || '.....................'}</p>
                <p>Hiện công tác tại: ${data.workplace || '.....................'}</p>
                <p>Kính đề nghị cho tôi được nghỉ: ${data.reason || '.....................'}</p>
                <p>Thời gian nghỉ: từ ${data.from_date || '...'} đến ${data.to_date || '...'}</p>
                <p>Nơi nghỉ: ${data.place || '.....................'}</p>
                <p>Điện thoại liên hệ: ${data.phone || '.....................'}</p>
                <p>Rất mong Ban Giám Đốc xem xét và chấp thuận.</p>
                <p>Xin trân trọng cảm ơn!</p>
                <p style="text-align: right;">${formatVietnamDate(data.request_date)}</p>
                <p style="text-align: right;"><b>Người làm đơn</b><br>(Ký, ghi rõ họ tên)</p>
                <p style="text-align: right; margin-top: 40px;">${data.employee_name || '.....................'}</p>
                <input type="hidden" id="month" value="${data.from_date}">
            </div>
        `;
        if(data.status === 'pending') {
          
          html += `<div style="text-align: center; margin-top: 20px;">
                        <button style="width:40%" id="approveBtn" style="padding: 8px 16px;">Duyệt đơn</button>
                        <button id="rejectBtn" style="padding: 8px 16px; background: red; color: white;width:40%; border-radius: 6px;">Từ chối đơn</button>
                     </div>`;
        }
        $('#leaveDetailContent').html(html);
        $('#approveBtn').off().on('click', function() {
            approveLeave(data.request_id);
        });
        $('#rejectBtn').off().on('click', function () {
                currentRejectId = data.request_id;
                $('#rejectReason').val('');
                $('#rejectPopup').show();
        });

        $('#leaveModal').show();
    });
}

function formatVietnamDate(dateStr) {
    if (!dateStr) return "Ngày ... tháng ... năm ...";
    const d = new Date(dateStr);
    return `Ngày ${d.getDate()} tháng ${d.getMonth() + 1} năm ${d.getFullYear()}`;
}

function approveLeave(id) {
  
    $.post('./api/phancong.php?action=approve', { request_id: id }, function(res) {
        openPopup(res.message);
        closeModal();
        loadLeaveRequests();
    }, 'json'); // 👈 chỉ định trả về JSON
}

function closeModal() {
    $('#leaveModal').hide();
}
let currentRejectId = null;

function submitReject() {
    const reason = $('#rejectReason').val().trim();
    if (!reason) {
        alert("Vui lòng nhập lý do từ chối.");
        return;
    }

    $.post('./api/phancong.php?action=reject', {
        request_id: currentRejectId,
        reason: reason
    }, function (res) {
        openPopup(res.message,'');
        $('#rejectPopup').hide();
        $('#leaveModal').hide();
        loadLeaveRequests();
    }, 'json');
}

loadLeaveRequests();

</script>
