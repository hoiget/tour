<style>
#leaveForm {
    max-width: 600px;
    margin: 40px auto;
    padding: 24px;
    background: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', sans-serif;
}

#leaveForm label {
    font-weight: bold;
    display: block;
    margin-top: 12px;
}

#leaveForm input, #leaveForm textarea, #leaveForm select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    font-family: inherit;
}

#leaveForm button {
    background: #007bff;
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
}

#leaveForm button:hover {
    background: #0056b3;
}
</style>

<form id="leaveForm">
    <input type="hidden" name="employee_id" value="<?php echo $user_id; ?>">

    <label>Lý do nghỉ:</label>
    <textarea name="reason" placeholder="Ví dụ: Nghỉ cưới, nghỉ ốm..." required></textarea>

    <label>Ngày bắt đầu:</label>
    <input type="date" name="from_date" required>

    <label>Ngày kết thúc:</label>
    <input type="date" name="to_date" required>

    <label>Nơi nghỉ:</label>
    <input type="text" name="place" placeholder="Nhập địa điểm nghỉ" required>

    <label>Điện thoại liên hệ:</label>
    <input type="text" name="phone" required>

    <label>Chức vụ:</label>
    <input type="text" name="position" required>

    <label>Nơi công tác:</label>
    <input type="text" name="workplace" required>

    <label>Phòng ban:</label>
    <input type="text" name="department" required>

    <button type="submit">Gửi đơn</button>
</form>

<script>
$('#leaveForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: './api/phancong.php?action=request',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
            openPopup(res.message,'');
            $('#leaveForm')[0].reset();
        },
        error: function(xhr) {
            console.error("Lỗi:", xhr.responseText);
            openPopup("Có lỗi xảy ra. Vui lòng thử lại.",'');
        }
    });
});
</script>

