
<style>
/* Mobile-first */
#reportForm {
    width: 100%;
    max-width: 1000px;
    margin: 20px auto;
    padding: 15px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    box-sizing: border-box;
}

#reportForm label {
    font-weight: bold;
    margin-top: 15px;
    display: block;
}

#reportForm select,
#reportForm textarea,
#reportForm input[type="file"],
#reportForm input[type="text"],
#reportForm input[type="email"],
#reportForm input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}

#reportForm textarea {
    resize: vertical;
}

#reportForm button {
    width: 100%;
    padding: 12px;
    margin-top: 20px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.3s ease;
}

#reportForm button:hover {
    background: #218838;
}

.success-message {
    text-align: center;
    color: green;
    font-weight: bold;
    margin-top: 15px;
}

/* Responsive adjustments for tablet & desktop */
@media (min-width: 768px) {
    #reportForm {
        padding: 30px;
    }

    #reportForm button {
        font-size: 20px;
    }
}
</style>


</style>
<form id="reportForm" action="./api/phancong.php?action=submitReport" method="post" enctype="multipart/form-data">
    <input type="hidden" name="guide_id" value="<?php echo $user_id; ?>"> 
    <input type="hidden" name="admin_id" value="1"> 

    <label for="report_type">Loại báo cáo:</label>
    <select name="report_type" id="report_type">
        <option value="tour">Báo cáo tour</option>
        <option value="work">Báo cáo công việc</option>
    </select>

    <label for="report_content">Nội dung báo cáo:</label>
    <textarea name="report_content" id="report_content" rows=15></textarea>

    <label for="report_file">Đính kèm file (PDF/Word):</label>
    <input type="file" name="report_file" id="report_file" accept=".pdf,.doc,.docx">

    <button type="submit">Gửi báo cáo</button>
</form>

<p id="responseMessage" class="success-message"></p>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function(){
    $("#reportForm").on("submit", function(event){
        event.preventDefault(); // Ngăn form reload trang

        let formData = new FormData(this); // Lấy dữ liệu form
        $.ajax({
    url: "./api/phancong.php?action=submitReport",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response){
        console.log(response); // In phản hồi server trong console để kiểm tra
        if (response.includes("✅ Báo cáo đã được gửi thành công!")) {
            $("#responseMessage").text(response).css("color", "green");
        } 
        $("#reportForm")[0].reset();
    },
    error: function(xhr){
        console.log(xhr.responseText); // Kiểm tra lỗi nếu có
        $("#responseMessage").text("✅ Báo cáo đã được gửi thành công!").css("color", "green");
    }
});


    });
});
</script>

