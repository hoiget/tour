


    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Liên hệ</h1>
            </div>
          </div>
        </div>
      </div>
      
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="info-wrap" data-aos="fade-up" data-aos-delay="200">
          <div class="row gy-5">

            <div class="col-lg-4">
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Địa điểm</h3>
                  <p>Q,Gò Vấp,Đường 11, TP.HCM,</p>
                </div>
              </div>
            </div><!-- End Info Item -->

            <div class="col-lg-4">
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Điện thoại</h3>
                  <p>0965773899</p>
                </div>
              </div>
            </div><!-- End Info Item -->

            <div class="col-lg-4">
              <div class="info-item d-flex align-items-center">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email</h3>
                  <p>GoWander@gmail.com</p>
                </div>
              </div>
            </div><!-- End Info Item -->

          </div>
        </div>
        <h1>Gửi ý kiến phản hồi</h1>
       
        <form class="php-email-form" id="guiykien" action="./api/api.php" method="get"> 
        <input type="hidden" name="action" value="guiykien">
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
            </div>

            <div class="col-md-6 ">
              <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
            </div>

            <div class="col-md-12 text-center">
              

              <button type="submit" onclick="guiykien()">Send Message</button>
            </div>

          </div>
        </form><!-- End Contact Form -->

      </div>

    </section><!-- /Contact Section -->
<script>
  let loginForm = document.querySelector(".php-email-form"); 
loginForm.addEventListener("submit", (e) => { 
    e.preventDefault(); 
   
});
   function guiykien() {
    // Lấy giá trị từ input type="date"
   
    $(document).ready(function() {
        $('#guiykien').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của form
            $.ajax({
                type: 'POST',
                url: './api/api.php',
                data: $(this).serialize(),
                success: function(response) {
                  
                    if (response === 'Phản hồi của bạn đã được gửi thành công!') {
                        openPopup('Thông báo', 'Phản hồi của bạn đã được gửi thành công!');
                        setTimeout(function() {
                            window.location.href = 'index.php?contact'; // Chuyển hướng sau 2 giây
                        }, 2000);
                    }else if (response === 'missing_data') {
                        openPopup('Thông báo', 'Dữ liệu còn thiếu. Vui lòng kiểm tra lại!');
                    }else{
                        openPopup('Lỗi', 'Có lỗi xảy ra');
                    }   
                    
                },
                error: function(xhr, status, error) {
                    // In lỗi chi tiết ra console
                    console.error('Lỗi AJAX:', status, error); // In thông tin lỗi
                    console.error('Chi tiết lỗi:', xhr.responseText); // In chi tiết thông báo lỗi từ server
                    openPopup('Lỗi', 'Không thể gửi yêu cầu. Vui lòng thử lại!');
                }
            });
        });
    });
}
</script>
 