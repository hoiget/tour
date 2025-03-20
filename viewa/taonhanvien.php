
    <style>
  
        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 800px;
          
            
           
            align-items: center;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }
        .form-group {
           
            display: flex;
            justify-content: space-around;
            margin-bottom: 15px;
        }
        .form-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }
        .form-group input, .form-group select {
            width: 120%;
            padding: 8px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group select {
            width: 100%;
        }
        .form-group.full-width select {
            width: 100%;
            height: 40px;
        }
        .submit-btn {
            display: block;
            width: 20%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .form-container {
    width: 100%; /* Chiều rộng đầy đủ */
    overflow-x: auto; /* Cuộn ngang nếu nội dung vượt quá chiều rộng */
    overflow-y: auto; /* Cuộn dọc nếu cần */
    max-height: 500px; /* Giới hạn chiều cao tối đa */
    border: 1px solid #ddd; /* Đường viền để dễ nhận diện */
    border-radius: 8px;
    background-color: white; /* Đảm bảo nền trắng cho vùng cuộn */
}
.legend {
            margin-top: 15px;
            padding: 10px;
        }

        .legend span {
            margin-right: 20px;
        }
    </style>
<center>
<div class="legend">
        <h4>Chú thích:</h4>
        <span>Quản lý:QL + mã </span>
        <span>Chăm sóc khách hàng: CS + mã</span>
        <span>Hướng dẫn viên: HD + mã</span> <br>
        
</div>
    <div class="form-container">
        <h2>TẠO TÀI KHOẢN NHÂN VIÊN</h2>
       
                <form class="taonhanvien" id="taonhanvien" action="./api/apia.php" method="post"> 
                <input type="hidden" name="action" value="taonhanvien">
            <div class="form-group">
                <div>
                    <label for="employee-id">Mã Nhân Viên:</label>
                    <input type="text" id="employee-id" name="employee-id" placeholder="Nhập mã nhân viên">
                </div>
                <div>
                    <label for="employee-name">Tên Nhân Viên:</label>
                    <input type="text" id="employee-name" name="employee-name" placeholder="Nhập tên nhân viên">
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email">
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại">
                </div>
                <div>
                    <label for="address">Địa chỉ:</label>
                    <input type="text" id="address" name="address" placeholder="Nhập địa chỉ">
                </div>
                
            </div>
            <button type="submit" class="submit-btn">Tạo tài khoản</button>
        </form>
    </div>

    </center>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function taonhanvien() {
        $('#taonhanvien').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: './api/apia.php',
                data: $(this).serialize(),
                success: function(response) {
                  console.log(response)
                    if(response === 'insert_success'){
                        openPopup('Thông báo','Thêm thành công')
                        setTimeout(function() {
                            window.location.href = 'indexa.php?taonhanvien';
                        }, 2000);
                    }
                    else if(response === 'missing_data'){
                        openPopup('thông báo','Rỗng');
                    }else{
                        openPopup('Lỗi','Lỗi');
                    }
                    
                    
                }
            });
        });
        
      }; 
      $(document).ready(function() {
       
       taonhanvien();
   });
    </script>