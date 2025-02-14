

  <!-- ======= Header ======= -->
 
  
    
    

  

    <div class="pagetitle">
      <h1>Thông tin cá nhân<h1>
      
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              
              <h2><?php 
               if(isset($_SESSION['Admin_name'])){
                echo $username; 
              }elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
                echo $username1; 
              }
              ?></h2>
              <h3><?php 
            if(isset($_SESSION['Admin_name'])){
              echo "Quản trị viên"; 
            }elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
              if($role == 'QL'){
                echo "Nhân viên dịch vụ"; 
              }elseif($role == 'CSKH'){
                echo "Nhân viên chăm sóc khách hàng";
              }elseif($role == 'HDV'){
                echo "Hướng dẫn viên";
              }
              
            }
           ?></h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Thông tin</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Cập nhật thông tin</button>
                </li>

            

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Thông tin chi tiết</h5>
                <?php 
            if(isset($_SESSION['Admin_name'])){
             ?>
            <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Tên</div>
                    <div class="col-lg-9 col-md-8"><?php echo $username?></div>
                  </div>
                  </div>
               
                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

<!-- Profile Edit Form -->
<form>
 

  <div class="row mb-3">
    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tên</label>
    <div class="col-md-8 col-lg-9">
      <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $username?>" >
    </div>
  </div>

  

  <div class="row mb-3">
    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
    <div class="col-md-8 col-lg-9">
      <input name="job" type="text" class="form-control" id="Job" value="Quản trị viên">
    </div>
  </div>


 

  <div class="text-center">
    <button type="submit" class="btn btn-primary">Save Changes</button>
  </div>
</form><!-- End Profile Edit Form -->

</div>




             <?php
            }elseif(isset($_SESSION['Email']) && isset($_SESSION['Phone_number'])){
              
              ?>
              
                
                <div id="ttcnnv"></div>
                 
                </div>
               
                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form class="updatettcnnv" id="updatettcnnv" action="./api/api.php" method="post"> 
                  <input type="hidden" name="action" value="updatettcnnv">
    

                  <div id="ttcnnv1"></div>
              
      

                   

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

              

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->
              <?php
            }
           ?>

            </div>
          </div>

        </div>
      </div>
    </section>


  <!-- ======= Footer ======= -->
 
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
     function get_nv() {
    $.ajax({
        url: './api/apia.php?action=get_nv',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                     <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Tên</div>
                    <div class="col-lg-9 col-md-8">${event.Username}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">code</div>
                    <div class="col-lg-9 col-md-8">${event.Employee_code}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Chức vị</div>
                    <div class="col-lg-9 col-md-8">${event.Permissions}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">email</div>
                    <div class="col-lg-9 col-md-8">${event.Email}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Địa chỉ</div>
                    <div class="col-lg-9 col-md-8">${event.Address}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Số điện thoại</div>
                    <div class="col-lg-9 col-md-8">${event.Phone_number}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Ngày tạo</div>
                    <div class="col-lg-9 col-md-8">${event.Created_at}</div>
                  </div>
                  
`;
                });
                $('#ttcnnv').html(eventHtml);
            } else {
                $('#ttcnnv').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#ttcnnv').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function get_nv1() {
    $.ajax({
        url: './api/apia.php?action=get_nv',
        type: 'GET',
        dataType: 'json', // Tự động phân tích chuỗi JSON thành object/mảng
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                var events = response;
                var eventHtml = '';
                events.forEach(function(event) {
                    eventHtml += `
                      <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tên</label>
                      <div class="col-md-8 col-lg-9">
                        <input  type="text" class="form-control" id="name" name="name" value="${event.Username}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Địa chỉ</label>
                      <div class="col-md-8 col-lg-9">
                        <input  type="text" class="form-control" id="dc" name="dc" value="${event.Address}">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Số điện thoại</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="sdt" name="sdt" value="${event.Phone_number}" readonly>
                      </div>
                    </div>
                  
`;
                });
                $('#ttcnnv1').html(eventHtml);
            } else {
                $('#ttcnnv1').html('<div class="col">Không tìm thấy thông tin người dùng.</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi khi lấy thông tin:', error);
            $('#ttcnnv1').html('<div class="col">Đã xảy ra lỗi khi tải thông tin người dùng.</div>');
        }
    });
}
function updatettcnnv() {
        $('#updatettcnnv').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: './api/apia.php',
                data: $(this).serialize(),
                success: function(response) {
                  console.log(response)
                    if(response === 'update_success'){
                        openPopup('Thông báo','cập nhật thành công')
                        setTimeout(function() {
                            window.location.href = 'indexa.php?ttcna';
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
       
        get_nv();
        get_nv1();
        updatettcnnv();
    });
</script>
