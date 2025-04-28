
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

<?php $idtour = isset($_GET['idtour']) ? $_GET['idtour'] : null; ?>
<form id="reportForm" action="./api/phancong.php?action=submitReport" method="post" enctype="multipart/form-data">
    <input type="hidden" name="guide_id" value="<?php echo $user_id; ?>"> 
    <input type="hidden" name="admin_id" value="1"> 
    <input type="hidden" name="tour_id" value="<?php echo $idtour; ?>"> <!-- Thêm idtour vào form -->


    <label for="report_type">Loại báo cáo:</label>
    <select name="report_type" id="report_type">
        <option value="tour">Báo cáo tour</option>
        <option value="work">Báo cáo công việc</option>
    </select>

    <!-- Khi chọn Báo cáo tour, sẽ hiển thị danh sách tour -->
    <div id="tourSelectDiv" style="display:none;">
        <label for="tour_id">Chọn tour:</label>
        <select name="tour_id" id="tour_id">
            <!-- Các tour sẽ được thêm vào đây từ API -->
        </select>
    </div>

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
    // Khi thay đổi loại báo cáo
    $("#report_type").on("change", function() {
        let reportType = $(this).val();

        // Nếu chọn Báo cáo tour, hiển thị danh sách tour
        if (reportType === "tour") {
            $("#tourSelectDiv").show();

            // Gọi API để lấy danh sách các tour của nhân viên
            $.ajax({
                url: "./api/apia.php?action=xemdichvuhdv1", // API để lấy các tour
                type: "GET",
                success: function(response) {
                    let tours = JSON.parse(response); // Dữ liệu tour dưới dạng JSON
                    let tourSelect = $("#tour_id");
                    tourSelect.empty(); // Xóa các tour cũ

                    // Thêm các tour vào dropdown
                    tours.forEach(function(tour) {
                        tourSelect.append(new Option(tour.tourname, tour.id_tour));
                    });
                },
                error: function(xhr) {
                    console.log("Lỗi khi lấy tour: " + xhr.responseText);
                }
            });
        } else {
            $("#tourSelectDiv").hide(); // Nếu không chọn Báo cáo tour, ẩn dropdown
        }
    });

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
