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
</style>


    <!-- Services Section -->
    <section id="services" class="services section">

    <div class="container my-5">
    <h1 class="text-center mb-4" style="color:black">Tin Tức - GoWender</h1>
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
                  <img src="./assets/img/gallery/${item.Image}" alt="${item.Title}" class="card-img-top">
                  <div class="card-body">
                    <h5 class="card-title">${item.Title}</h5>
                    <a href="#" class="btn btn-primary view-details" data-id="${item.id}">Xem Chi Tiết</a>
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
            <div class="container">
            <center>
              <h2 style="color:black">${item.Title}</h2>
              <img src="./assets/img/gallery/${item.Image}" alt="${item.Title}" class="img-fluid">
              <p class="tt" style="text-align:justify;white-space:pre-line;font-size:25px;color:black">${item.dereption}</p>
              <a href="index.php?tintuc" class="btn btn-secondary">Trở Lại</a>
              </center>
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

  