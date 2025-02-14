<link rel="stylesheet" href="./assets/css/layout.css">
<style>
    .editable {
      display: inline-block;
      padding: 5px;
      border: 1px dashed #ccc;
      background-color: #f9f9f9;
      cursor: text;
    }
  </style>
  <section id="hero" class="hero section">
<div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center" data-aos="fade-up" data-aos-delay="100">
          <h2><span>Chào mừng đến với </span><span class="underlight">GoWander Travel</span>, cánh cửa dẫn lối đến<span> những hành trình khó quên</span></h2>
          <p>Khám phá những điểm đến tuyệt đẹp, hòa mình vào nền văn hóa đa dạng và tạo nên những kỷ niệm đáng nhớ. Hãy để chúng tôi đồng hành cùng bạn trong chuyến phiêu lưu sắp tới với các trải nghiệm độc đáo và ưu đãi hấp dẫn.</p>
          <a href="#" class="btn-get-started">Lên kế hoạch ngay<br></a>
         

          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <section id="hero" class="hero section">
    
  <ul class='slider' id="xemlayout">
 
  </ul>
  <nav class='nav'>
    <ion-icon class='btn prev' name="arrow-back-outline"></ion-icon>
    <ion-icon class='btn next' name="arrow-forward-outline"></ion-icon>
  </nav>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    // Slider navigation logic
    const slider = document.querySelector('.slider');

    function activate(e) {
      const items = document.querySelectorAll('.item');
      if (e.target.matches('.next')) {
        slider.append(items[0]);
      } else if (e.target.matches('.prev')) {
        slider.prepend(items[items.length - 1]);
      }
    }

    document.addEventListener('click', activate, false);

    // AJAX function to dynamically load slides
    function xemlayout() {
      $.ajax({
        url: './api/api.php?action=xemlayout',
        type: 'GET',
        dataType: 'json', // Automatically parses JSON string into an object/array
        success: function (response) {
          if (Array.isArray(response) && response.length > 0) {
            let eventHtml = '';
            response.forEach(function (tour) {
              eventHtml += `
                <li class='item' style="background-image: url('./assets/img/tour/${tour.Image}')">
                  <div class='content'>
                   <h1>Tour du lịch</h1>
                    <h2 class='title' style="color:white">${tour.Name}</h2>
                    <p class='description' style=" color: #FFFFFF;font-size:18px">${tour.Thumb}</p>
                     <a href="index.php?idtour=${tour.id}&xemdanhgiatour=${tour.id}&xemdanhgiarating=${tour.id}"><button>Read More</button></a>
                  </div>
                </li>`;
            });
            $('#xemlayout').html(eventHtml);
          } else {
            $('#xemlayout').html('<div class="col">No information found.</div>');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error fetching data:', error);
          $('#xemlayout').html('<div class="col">An error occurred while loading the data.</div>');
        }
      });
    }

    // Initialize on document ready
    $(document).ready(function () {
      xemlayout();
    });
  </script>
</section>


 <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-1.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-1.jpg" title="Gallery 1" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-2.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-2.jpg" title="Gallery 2" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-3.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-3.jpg" title="Gallery 3" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-4.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-4.jpg" title="Gallery 4" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-5.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-5.jpg" title="Gallery 5" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-6.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-6.jpg" title="Gallery 6" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-7.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-7.jpg" title="Gallery 7" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="assets/img/gallery/gallery-8-2.jpg" class="img-fluid" alt="">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="assets/img/gallery/gallery-8-2.jpg" title="Gallery 8" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div><!-- End Gallery Item -->

        </div>

      </div>


  

      </section><!-- /Gallery Section -->