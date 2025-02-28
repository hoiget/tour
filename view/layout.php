<link rel="stylesheet" href="./assets/css/layout.css">
<style>
    .editable {
      display: inline-block;
      padding: 5px;
      border: 1px dashed #ccc;
      background-color: #f9f9f9;
      cursor: text;
    }
    .containere {
            width: 100%;
            padding: 15px 15px;

           
            
        }
        h2 {
            color:rgb(68, 147, 230);
        }
        .slider1 {
            display: flex;
            align-items: center;
            overflow: hidden;
            position: relative;
            width: 100%;
        }
        .slides1 {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 300%; /* Ensure all slides fit */
        }
        .slide1 {
            min-width: calc(100% / 3);
            box-sizing: border-box;
            padding: 10px;
            position: relative;
            border-radius: 10px; /* Bo góc hình ảnh */
            overflow: hidden;
        }
      

.slide1 img {
    width: 100%;
    display: block;
    border-radius: 10px; /* Bo góc hình ảnh */
    height: 300px;
}

.tour-name {
    position: absolute;
    bottom: 10px;
    left: 10px;
   
    width: 96%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0)); /* Hiệu ứng nền mờ dần */
    color: white;
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    padding: 15px 10px;
    box-sizing: border-box;
}

        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }
        .prev1{
            left: 10px;
        }
        .next1{
            right: 10px;
        }
        #giam{
          width: 100%;
          height: 500px;
          background-color: #f9f9f9;
          color:black;
        }
        #yeuthich{
          width: 100%;
          height: auto;
          background-color: #f9f9f9;
          color:black;
        }
        .containere1 {
            width: 80%;
            margin: auto;
            
        }
        .prev12{
            left: 10px;
        }
        .next12{
            right: 10px;
        }
        .slider12 {
            display: flex;
            align-items: center;
            overflow: hidden;
            position: relative;
            width: 100%;
        }
        .slides12 {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 300%; /* Ensure all slides fit */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Bóng đậm hơn */
        }
        .slide12 {
            min-width: calc(100% / 3);
            box-sizing: border-box;
            padding: 10px;
            position: relative;
            border-radius: 10px; /* Bo góc hình ảnh */
            overflow: hidden;
            width: 200px;
           
        }

.slide12:hover {
    transform: translateY(-5px); /* Hiệu ứng nổi lên khi hover */
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3); /* Tạo hiệu ứng nổi rõ */
}

.slide12 img {
    width: 100%;
    display: block;
    border-radius: 10px; /* Bo góc hình ảnh */
    height: 300px;
}
.tour-info {
        padding: 10px;
    }
    .tour-name1 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .tour-meta {
        font-size: 14px;
        color: #555;
    }
    .price {
        font-size: 18px;
        font-weight: bold;
        color: red;
    }
    .btn-book {
        display: block;
        text-align: center;
        background: black;
        color: white;
        padding: 8px;
        border-radius: 5px;
        margin-top: 10px;
        text-decoration: none;
    }
      
.tim{
 
  width: 100%;
  height: 250px;
  background-color: #f9f9f9;
  color:black;
  background: url('./assets/img/thien.jpg') no-repeat center center fixed;
  background-size: cover;
}

  </style>
  <link rel="stylesheet" href="./assets/css/timkiem.css">
  <section id="hero" class="hero section">
<div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center" data-aos="fade-up" data-aos-delay="100">
          <h2><span>Chào mừng đến với </span><span class="underlight">GoWander Travel</span>, cánh cửa dẫn lối đến<span> những hành trình khó quên</span></h2>
          <p>Khám phá những điểm đến tuyệt đẹp, hòa mình vào nền văn hóa đa dạng và tạo nên những kỷ niệm đáng nhớ. Hãy để chúng tôi đồng hành cùng bạn trong chuyến phiêu lưu sắp tới với các trải nghiệm độc đáo và ưu đãi hấp dẫn.</p>
          <a href="#" class="btn-get-started">Lên kế hoạch ngay</a>
         

          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->
    <section id="tim" class="tim">
  
    <div class="container2">
        <div class="tab-container">
            <div class="tab active" id="tour-tab">
                <i class="fas fa-bus"></i> Tour trọn gói
            </div>
            <div class="tab" id="hotel-tab">
                <i class="fas fa-hotel"></i> Khách sạn
            </div>
        </div>

        <!-- Form tìm kiếm Tour -->
        <div id="tour-search" class="search-form">
            <input type="text" name="name" placeholder="Bạn muốn đi đâu?" class="search-input">
            <input type="date" name="date" class="date-input1">
            <select name="budget" class="budget-select">
                <option value="">Ngân sách</option>
                <option value="low">Dưới 5 triệu</option>
                <option value="medium">5 - 10 triệu</option>
                <option value="high">Trên 10 triệu</option>
            </select>
            <button type="submit" class="search-button">🔍</button>
        </div>

        <!-- Form tìm kiếm Khách sạn -->
        <div id="hotel-search" class="search-form" style="display: none;">
            <input type="text" name="name" placeholder="Nhập tên phòng/Địa điểm" class="search-input1">
            
            <div class="date-input-container">
                <div class="date-input-wrapper" data-label="Ngày nhận">
                    <input type="date" id="ngay-nhan" class="date-input" name="checkin">
                </div>
                <div class="date-input-wrapper" data-label="Ngày trả">
                    <input type="date" id="ngay-tra" class="date-input" name="checkout">
                </div>
            </div>
            
            <input type="number" id="adult" name="adult" placeholder="Số người lớn">
            <input type="number" name="children" id="children"  placeholder="Số trẻ em">

            <select name="price" id="price">
                <option value="">Chọn giá</option>
                <option value="low">Dưới 1 triệu</option>
                <option value="medium">1 triệu - 2 triệu</option>
                <option value="mediumer">2 triệu - 3 triệu</option>
                <option value="high">3 triệu - 4 triệu</option>
                <option value="higher">Trên 4 triệu</option>
            </select>

            <button type="submit" class="hotel-search-button">🔍</button>
        </div>
    </div>


    <script>
  $(document).ready(function () {
    // Chuyển đổi tab
    $('.tab').click(function () {
        $('.tab').removeClass('active');
        $(this).addClass('active');

        if ($(this).attr('id') === 'tour-tab') {
            $('#tour-search').show();
            $('#hotel-search').hide();
        } else {
            $('#tour-search').hide();
            $('#hotel-search').show();
        }
    });

    // Xử lý tìm kiếm Tour
    $('.search-button').click(function () {
        var name = $('.search-input').val();
        var date = $('.date-input').val();
        var budget = $('.budget-select').val();

        window.location.href = `index.php?tour1&name=${encodeURIComponent(name)}&date=${date}&budget=${budget}`;
    });

    // Xử lý tìm kiếm Khách sạn
    $('.hotel-search-button').click(function () {
        var name = $('.search-input1').val();
        var checkin = $('#ngay-nhan').val();
        var checkout = $('#ngay-tra').val();
        var adult = $('#adult').val();
        var children = $('#children').val();
        var price = $('#price').val();

        window.location.href = `index.php?ks&name=${encodeURIComponent(name)}&checkin=${checkin}&checkout=${checkout}&adult=${adult}&children=${children}&price=${price}`;
    });
});


    </script>
</section>


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
<section id="giam" class="giam">
 
<div class="containere">
        <h2>TOUR ĐANG GIẢM GIÁ</h2>
        <p>Hãy tận hưởng trải nghiệm du lịch chuyên nghiệp, mang lại cho bạn những khoảnh khắc tuyệt vời và nâng tầm cuộc sống.</p>
        
        <div class="slider1">
            <button class="nav-button prev1" onclick="prevSlide()">&#10094;</button>
            <div class="slides1" id="slide1"></div>
            <button class="nav-button next1" onclick="nextSlide()">&#10095;</button>
        </div>
    </div>
    
    <script>
        let index = 0;
        function showSlide(n) {
            const slides = document.querySelector('.slides1');
            const totalSlides = document.querySelectorAll('.slide1').length;
            if (totalSlides === 0) return;
            index = (n + totalSlides) % totalSlides;
            slides.style.transform = `translateX(${-index * (100 / 3)}%)`;
        }
        function prevSlide() {
            showSlide(index - 1);
        }
        function nextSlide() {
            showSlide(index + 1);
        }
        
        function xemhot() {
            $.ajax({
                url: './api/api.php?action=xemhot',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (Array.isArray(response) && response.length > 0) {
                        let eventHtml = '';
                        response.forEach(function (tour) {
                            eventHtml += `
                                <div class='slide1'>
                               
                                    <a href="index.php?idtour=${tour.id}&xemdanhgiatour=${tour.id}&xemdanhgiarating=${tour.id}">
                                        <img src="./assets/img/tour/${tour.Image}" alt="${tour.Name}">
                                        <div class="tour-name">${tour.Name}<br>Từ <del style="color:white">${parseInt(tour.Price).toLocaleString('vi-VN')} VNĐ</del> Chỉ còn  ${parseInt(tour.discount).toLocaleString('vi-VN')} VNĐ</div>
                                    </a>
                                </div> `;
                        });
                        $('#slide1').html(eventHtml);
                        showSlide(index);
                    } else {
                        $('#slide1').html('<div class="col">No information found.</div>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                    $('#slide1').html('<div class="col">An error occurred while loading the data.</div>');
                }
            });
        }
        
        $(document).ready(function() {
            xemhot();
        });
    </script>
   
  </section>


  <section id="yeuthich" class="yeuthich">
 
<div class="containere1">
        <h2 style="text-align: center;">Địa điểm được yêu thích</h2>
        <p style=" text-align: center;">Hãy chọn một điểm đến du lịch nổi tiếng dưới đây để khám phá các chuyến đi độc quyền của chúng tôi với mức giá vô cùng hợp lý.</p>
        
        <div class="slider12">
            <button class="nav-button prev12" onclick="prevSlide1()">&#10094;</button>
            <div class="slides12" id="slide12"></div>
            <button class="nav-button next12" onclick="nextSlide1()">&#10095;</button>
        </div>
    </div>
    
    <script>
        let index1 = 0;
        function showSlide1(n) {
            const slides = document.querySelector('.slides12');
            const totalSlides = document.querySelectorAll('.slide12').length;
            if (totalSlides === 0) return;
            index1 = (n + totalSlides) % totalSlides;
            slides.style.transform = `translateX(${-index1 * (100 / 3)}%)`;
        }
        function prevSlide1() {
            showSlide1(index1 - 1);
        }
        function nextSlide1() {
            showSlide1(index1 + 1);
        }
        
        function xemyeuthich() {
    $.ajax({
        url: './api/api.php?action=xemyeuthich',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (Array.isArray(response) && response.length > 0) {
                let eventHtml = '';
                response.forEach(function (tour) {
                    eventHtml += `
                        <div class='slide12'>
                            <a href="index.php?idtour=${tour.tourid}">
                                <img src="./assets/img/tour/${tour.Image}" alt="${tour.Name}">
                            </a>
                            <div class="tour-info">
                                <div class="tour-name1">${tour.Name}</div>
                                <div class="tour-meta">Khởi hành: <b>${tour.DepartureLocation}</b></div>
                                <div class="tour-meta">Ngày khởi hành: <b>${tour.Depart}</b></div>
                                <div class="tour-meta">Thời gian: <b>${tour.timetour}</b></div>
                                `
                                 if (parseInt(tour.discount) == 0) {
                                  eventHtml+= ` <span style="color:black">Chỉ với:</span>
                                  <div class="price">`+ parseInt(tour.Price).toLocaleString('vi-VN') + ` VNĐ </div>
                                  
                                  `
                                }else if(parseInt(tour.discount) > 0){
                                eventHtml+=`
                                    <del style="color:black">Gía từ: `+ parseInt(tour.Price).toLocaleString('vi-VN') + ` VNĐ</del>
                                    <div class="price">`+ parseInt(tour.discount).toLocaleString('vi-VN') + ` VNĐ </div>
                                  
                                `}
                            eventHtml+= `<a href="index.php?idtour=${tour.tourid}" class="btn-book">Đặt ngay</a>
                            </div>
                        </div> `
                                ;
                });
                $('#slide12').html(eventHtml);
                showSlide1(index1);
            } else {
                $('#slide12').html('<div class="col">No information found.</div>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
            $('#slide12').html('<div class="col">An error occurred while loading the data.</div>');
        }
    });
}

        $(document).ready(function() {
          xemyeuthich();
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