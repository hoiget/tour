<style>
   .news-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }
    .news-card:hover {
      transform: translateY(-5px);
    }
    .news-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .news-card .card-body {
      padding: 1rem;
    }
   #services{
    background: white;
   }
   .img-fluid{
      width: 1000px;
      height: 500px;
   }
   /* Cải thiện giao diện trang chi tiết tin tức */
   #tintuc-detail {
  background-color: #f4f7fa;
  padding: 2rem;
  margin-top: 20px;
}

#tintuc-detail h2 {
  color: #333;
  font-size: 2.5rem;
  margin-bottom: 1.5rem;
}

#tintuc-detail .img-fluid {
  max-width: 70%;
  height: auto;
  margin:auto;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#tintuc-detail .tt {
  font-size: 18px;
  line-height: 1.6;
  color: #444;
  text-align: justify;
  white-space: pre-line;
  margin-top: 20px;
}

#tintuc-detail .btn {
  font-size: 1rem;
  padding: 0.75rem 1.5rem;
  border-radius: 25px;
  transition: all 0.3s ease-in-out;
}

#tintuc-detail .btn-secondary {
  background-color: #6c757d;
  color: #fff;
  border: none;
}

#tintuc-detail .btn-secondary:hover {
  background-color: #5a6368;
  transform: translateY(-3px);
}
.carousel-item iframe {
  max-width: 70%;
  
}
@media (max-width: 767px) {
  #tintuc-detail h2 {
    font-size: 2rem;
  }

  #tintuc-detail .tt {
    font-size: 16px;
  }
  .carousel-item iframe {
    max-width: 70%;
    height: auto;
  
}
}

</style>


    <!-- Services Section -->
    <section id="services" class="services section">

    <div class="container my-5">
    <h1 class="text-center mb-4" style="color:black" data-i18n="newss">Tin Tức - GoWander</h1>
    <div class="row" id="tintuc">
      <!-- News cards will be rendered here -->
    </div>
  </div>

   
    <script>
  function get_news() {
    $.ajax({
      url: './api/api.php?action=tintuc',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (Array.isArray(response) && response.length > 0) {
          var news = response;
          var newsHtml = '';
          news.forEach(function(item) {
            newsHtml += `
              <div class="col-md-4 mb-4">
                <div class="card news-card">
                  <a href="#" class="view-details" data-id="${item.id}"><img src="./assets/img/gallery/${item.Image}" alt="${item.Title}" class="card-img-top"></a>
                  <div class="card-body">
                    <h5 class="card-title">${item.Title}</h5>
                    <center><a href="#" class="btn btn-primary view-details" data-id="${item.id}">Xem Chi Tiết</a></center>
                  </div>
                </div>
              </div>`;
          });
          $('#tintuc').html(newsHtml);
          
          // Bind click event to view details buttons
          $('.view-details').on('click', function(e) {
            e.preventDefault();
            var newsId = $(this).data('id');
            view_news_details(newsId);
          });
        } else {
          $('#tintuc').html('<div class="col">Không tìm thấy bài viết nào.</div>');
        }
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi lấy thông tin:', error);
        $('#tintuc').html('<div class="col">Đã xảy ra lỗi khi tải tin tức.</div>');
      }
    });
  }

  function view_news_details(id) {
    $.ajax({
      url: './api/api.php?action=tintucchitiet&id=' + id,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response && response.length > 0) {
          var item = response[0];
          var detailsHtml = `
          <div id="tintuc-detail" class="container">
            <div class="text-center">
              <h2 style="color:black">${item.Title}</h2>

              <!-- Carousel for images and video -->
              <div id="carouselExample" class="carousel slide" data-bs-ride="false">
                <div class="carousel-inner">
                  <!-- Show images in the carousel -->
                  <div class="carousel-item active">
                    <img src="./assets/img/gallery/${item.Image}" alt="${item.Title}" class="img-fluid d-block w-100">
                  </div>
                  ${item.video ? `
                  <!-- Show video in the carousel -->
                  <div class="carousel-item">
                     <iframe width="900" height="600" 
                    src="https://www.youtube.com/embed/${item.video}?autoplay=1&rel=0" 
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
                  </div>
                  ` : ''}
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

              <!-- Description Text -->
              <p class="tt">${item.dereption}</p>

              <!-- Return button -->
              <a href="index.php?tintuc" class="btn btn-secondary">Trở Lại</a>
            </div>
          </div>`;
          $('#tintuc').html(detailsHtml); // Replace the news section with the detailed view
        } else {
          $('#tintuc').html('<div class="col">Không tìm thấy bài viết chi tiết.</div>');
        }
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi lấy chi tiết:', error);
        $('#tintuc').html('<div class="col">Đã xảy ra lỗi khi tải chi tiết bài viết.</div>');
      }
    });
}


  // Call the function to load news on page load
  $(document).ready(function() {
    get_news();
  });
</script>

  