<?php

session_start();

include_once("connect.php");
require '../log/log_helper.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $action = $_POST['action'];
    if (!$action) {
        $inputJSON = file_get_contents("php://input");
        $input = json_decode($inputJSON, true);
        $action = isset($input['action']) ? $input['action'] : null;
    }
    
    // Nếu vẫn không có action, báo lỗi
    if (!$action) {
        echo json_encode(["error" => "Thiếu tham số action"]);
        exit();
    }
    if ($action == "updatettcnnv") {
        $username = $_POST['name']; // Tên tài khoản
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['Phone_number'];  // Lấy số điện thoại từ session
        $address = $_POST['dc'];    // Địa chỉ


        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($username) || empty($email) || empty($phone)) {
            echo 'missing_data';
            exit;
        }

        // Cập nhật thông tin người dùng
        $update_query = "UPDATE employees SET Username = ?, Address = ? WHERE Email = ? OR Phone_number = ?";
        $stmt = $conn->prepare($update_query);

        // Kiểm tra nếu không chuẩn bị được câu truy vấn
        if (!$stmt) {
            echo 'query_error';
            exit;
        }

        // Bind các tham số vào câu truy vấn
        $stmt->bind_param("ssss", $username, $address, $email, $phone);

        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            echo 'update_success'; // Thành công
        } else {
            echo 'update_error'; // Lỗi
        }
    } elseif ($action == "taonhanvien") {
        $ma = $_POST['employee-id'];
        $username = $_POST['employee-name']; // Tên tài khoản
        $password = $_POST['password'];
        $email = $_POST['email']; // Lấy email từ session
        $phone = $_POST['phone'];  // Lấy số điện thoại từ session
        $address = $_POST['address'];
        
        $date = date("Y-m-d");


        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($username) || empty($email) || empty($phone) || empty($address)) {
            echo 'missing_data';
            exit;
        }
        $check_query = "SELECT * FROM employees WHERE Employee_code = ? OR Email = ? OR Phone_number = ?";
        $stmt1 = $conn->prepare($check_query);
        $stmt1->bind_param("sss", $ma,$email, $phone);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
    
        if ($result1->num_rows > 0) {
            echo 'user_exists';
            exit;
        }
    
        // Cập nhật thông tin người dùng
        $prefix = substr($ma, 0, 2); // Lấy 2 ký tự đầu
        switch ($prefix) {
            case 'QL':
                $permissions = 'QL';
                break;
            case 'CS':
                $permissions = 'CSKH';
                break;
            case 'HD':
                $permissions = 'HDV';
                break;
            default:
                echo 'invalid_code'; // Nếu không khớp với mẫu nào, báo lỗi
                exit;
        }
    
        // Cập nhật thông tin người dùng
        $insert_query = "INSERT INTO employees (Employee_code, Name, Username, Password, Email, Phone_number, Address, Created_at, Permissions) 
                         VALUES (?, ?, ?, MD5(?), ?, ?, ?, ?, ?)";
    
        // Sử dụng prepared statements để tránh SQL injection
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssssssss", $ma, $username, $username, $password, $email, $phone, $address, $date, $permissions);
    


        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            echo 'insert_success'; // Thành công
        } else {
            echo 'update_error'; // Lỗi
        }
    } elseif ($action == "capnhatnv") {
        $id = $_POST['id'];
        $ma = $_POST['employee-id'];           // Mã nhân viên
        $username = $_POST['employee-name'];   // Tên tài khoản
        $password = $_POST['password'];        // Mật khẩu mới
        $email = $_POST['email'];              // Email
        $phone = $_POST['phone'];              // Số điện thoại
        $address = $_POST['address'];          // Địa chỉ
       
        $date = date("Y-m-d");             // Vai trò


        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($username) || empty($email) || empty($phone) || empty($address)) {
            echo 'missing_data';
            exit;
        }
       
        $prefix = substr($ma, 0, 2); // Lấy 2 ký tự đầu
        switch ($prefix) {
            case 'QL':
                $permissions = 'QL';
                break;
            case 'CS':
                $permissions = 'CSKH';
                break;
            case 'HD':
                $permissions = 'HDV';
                break;
            default:
                echo 'invalid_code'; // Nếu không khớp với mẫu nào, báo lỗi
                exit;
        }
        // Nếu mật khẩu mới không được cung cấp, không thay đổi mật khẩu
        if (empty($password)) {
            // Cập nhật mà không thay đổi mật khẩu
            $update_query = "UPDATE employees SET 
                Employee_code = ?,
                Name = ?, 
                Username = ?, 
                Email = ?, 
                Phone_number = ?, 
                Address = ?, 
                Created_at=?
                WHERE id = ?";

            $stmt = $conn->prepare($update_query);
            if ($stmt === false) {
                echo 'prepare_error: ' . $conn->error;
                exit;
            }
            $stmt->bind_param("sssssssi", $ma, $username, $username, $email, $phone, $address,$date, $id);
        } else {
            // Nếu mật khẩu mới được cung cấp, mã hóa mật khẩu và cập nhật
            $update_query = "UPDATE employees SET 
                Employee_code = ?,
                Name = ?, 
                Username = ?, 
                Password = MD5(?),  -- Mã hóa mật khẩu mới
                Email = ?, 
                Phone_number = ?, 
                Address = ?, 
                Created_at=?
                WHERE id = ?";

            $stmt = $conn->prepare($update_query);
            if ($stmt === false) {
                echo 'prepare_error: ' . $conn->error;
                exit;
            }
            $stmt->bind_param("ssssssssi", $ma, $username, $username, $password, $email, $phone, $address, $date, $id);
        }

        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            echo 'update_success'; // Thành công
        } else {
            echo 'update_error: ' . $stmt->error; // Ghi lại lỗi nếu có
        }
    } elseif ($action == "themtintuc") {
        $tieude = $_POST['Title']; // Tên tài khoản
        $noidung = $_POST['dereption'];
        $content = $_POST['Content'];
        $ngtao = $_POST['emid'];
        $date = date("Y-m-d");
        
        // Xử lý ảnh tải lên
        $file = $_FILES['anh']['tmp_name'];
        $name = $_FILES['anh']['name'];
        $loai = $_FILES['anh']['type'];
    
        // Xử lý video tải lên
       $videoName = $_POST['video'];
        // Kiểm tra định dạng ảnh
        if ($loai != "image/jpg" && $loai != "image/jpeg" && $loai != "image/png") {
            echo 'invalid_image';
            exit;
        }
    
        // Kiểm tra định dạng video
    
        // Xử lý tải ảnh lên
        if (move_uploaded_file($file, "../assets/img/gallery/" . $name)) {
            // Xử lý tải video lên
          
                // Thêm tin tức vào cơ sở dữ liệu
                $insert_query = "INSERT INTO news (Title, dereption, Image, Content, Video, Published_at, employeesId) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("sssssss", $tieude, $noidung, $name, $content, $videoName, $date, $ngtao);
    
                if ($stmt->execute()) {
                    log_action($conn, $ngtao, 'Insert', 'Thêm tin tức','employees');
                    echo 'insert_success';
                } else {
                    echo 'error_points';
                }
           
        } else {
            echo 'upload_image_error';
        }
    } elseif ($action == "capnhattintuc") {
        $ma = $_POST['id'];
        $tieude = $_POST['Title']; // Tiêu đề
        $noidung = $_POST['dereption']; // Nội dung
        $content = $_POST['Content']; // Content
        $ngtao = $_POST['emid']; // Người tạo
        $date = date("Y-m-d");
        $videoName = $_POST['video']; // Video name
        // Kiểm tra xem có file ảnh được gửi lên không
        if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
            $file = $_FILES['anh']['tmp_name'];
            $name = $_FILES['anh']['name'];
            $loai = $_FILES['anh']['type'];
    
            // Kiểm tra định dạng ảnh
            if ($loai != "image/jpg" && $loai != "image/jpeg" && $loai != "image/png") {
                echo 'invalid_image';
                exit;
            }
    
            // Xử lý tải ảnh lên thư mục
            if (move_uploaded_file($file, "../assets/img/gallery/" . $name)) {
                // Cập nhật tin tức với ảnh
                $update_query = "UPDATE news SET Title = ?, dereption = ?, Image = ?, Content = ?, Published_at = ?, employeesId = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("ssssssi", $tieude, $noidung, $name, $content, $date, $ngtao, $ma);
    
                if ($stmt->execute()) {
                    log_action($conn, $ngtao, 'update', 'Cập nhật tin tức '.'ID:'.$ma.' '.$tieude  ,'employees');
                    echo 'update_success';
                } else {
                    echo 'error_points';
                }
            } else {
                echo 'upload_image_error';
            }
        }
    
        // Kiểm tra video nếu có
        if (!empty($videoName)) {
          
    
            // Xử lý tải video lên thư mục
           
                // Cập nhật tin tức với video
                $update_query = "UPDATE news SET Title = ?, dereption = ?, Content = ?, Video = ?, Published_at = ?, employeesId = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("ssssssi", $tieude, $noidung, $content, $videoName, $date, $ngtao, $ma);
    
                if ($stmt->execute()) {
                    log_action($conn, $ngtao, 'update', 'Cập nhật tin tức '.'ID:'.$ma.' '.$tieude,'employees');
                    echo 'update_success';
                } else {
                    echo 'error_points';
                }
           
        }else{
            $update_query = "UPDATE news SET Title = ?, dereption = ?, Content = ?, Published_at = ?, employeesId = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("sssssi", $tieude, $noidung, $content, $date, $ngtao, $ma);
    
                if ($stmt->execute()) {
                    log_action($conn, $ngtao, 'update',  'Cập nhật tin tức '.'ID:'.$ma.' '.$tieude,'employees');
                    echo 'update_success';
                } else {
                    echo 'error_points';
                }
        }
    }
     elseif ($action == "capnhatuser") {
        $ma = $_POST['id']; // ID người dùng
        $name = $_POST['name']; // Tên
        $address = $_POST['address']; // Địa chỉ
        $email = $_POST['email']; // Email
        $sdt = $_POST['sdt']; // Số điện thoại
        $datetime = $_POST['ns']; // Ngày sinh
        $user_id = $_SESSION['id'];

        // Kiểm tra xem có file ảnh mới được gửi lên không
        if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
            $file = $_FILES['anh']['tmp_name'];
            $name_image = $_FILES['anh']['name'];
            $type = $_FILES['anh']['type'];

            // Kiểm tra định dạng ảnh
            if ($type != "image/jpg" && $type != "image/jpeg" && $type != "image/png") {
                echo 'invalid_image';
                exit;
            }

            // Xử lý tải ảnh lên thư mục
            if (move_uploaded_file($file, "../assets/img/user/" . $name_image)) {
                $password = $_POST['pass'];
                if (!empty($password)) {
                    // Nếu có ảnh mới, cập nhật tất cả các thông tin bao gồm ảnh
                    $update_query = "UPDATE user_credit SET Name = ?, Address = ?, Email = ?, sdt = ?, profile = ?, Password = MD5(?), Datetime = ? WHERE id = ?";
                    $stmt = $conn->prepare($update_query);
                    $stmt->bind_param("sssssssi", $name, $address, $email, $sdt, $name_image, $password, $datetime, $ma);
                } else {
                    // Nếu có ảnh mới, cập nhật tất cả các thông tin bao gồm ảnh
                    $update_query = "UPDATE user_credit SET Name = ?, Address = ?, Email = ?, sdt = ?, profile = ?, Datetime = ? WHERE id = ?";
                    $stmt = $conn->prepare($update_query);
                    $stmt->bind_param("ssssssi", $name, $address, $email, $sdt, $name_image, $datetime, $ma);
                }

                if ($stmt->execute()) {
                    log_action($conn, $user_id, 'Update', 'Cập nhật thông tin user '.'ID:'.$ma.' '.$name,'employees');
                    echo 'update_success';
                } else {
                    echo 'error_points';
                }
            } else {
                echo 'upload_error';
            }
        } else {
            // Nếu không có ảnh mới, kiểm tra mật khẩu
            $password = $_POST['pass'];

            // Nếu mật khẩu không được cập nhật, giữ nguyên mật khẩu cũ
            if (!empty($password)) {
                $update_query = "UPDATE user_credit SET Name = ?, Address = ?, Email = ?, sdt = ?, Password = MD5(?), Datetime = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("ssssssi", $name, $address, $email, $sdt, $password, $datetime, $ma);
            } else {
                // Nếu không có mật khẩu mới, không cập nhật mật khẩu
                $update_query = "UPDATE user_credit SET Name = ?, Address = ?, Email = ?, sdt = ?, Datetime = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("sssssi", $name, $address, $email, $sdt, $datetime, $ma);
            }

            if ($stmt->execute()) {
                log_action($conn, $user_id, 'Update', 'Cập nhật thông tin user '.'ID:'.$ma.' '.$name,'employees');
                echo 'update_success';
            } else {
                echo 'error_points';
            }
        }
    } elseif ($action == "themtienich") {

        $tieude = $_POST['ten']; // Tên tài khoản
        $noidung = $_POST['dereption'];

        $user_id = $_SESSION['id'];
        $insert_query = "INSERT INTO facilities (Name,Description) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ss", $tieude, $noidung);


        if ($stmt->execute()) {
            log_action($conn, $user_id, 'Insert', 'Thêm tiện ích '.'Tiêu đề: '.$tieude,'employees');
            echo 'insert_success';
        } else {
            echo 'error_points';
        }


    } elseif ($action == "suatienich") {
        $ma = $_POST['id']; // ID người dùng
        $tieude = $_POST['ten']; // Tên tài khoản
        $noidung = $_POST['dereption'];
        $user_id = $_SESSION['id'];

        $update_query = "UPDATE facilities SET Name = ?, Description = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $tieude, $noidung, $ma);


        if ($stmt->execute()) {
            log_action($conn, $user_id, 'Update', 'Cập nhật tiện ích '.'ID:'.$ma.' '.$tieude,'employees');
            echo 'update_success';
        } else {
            echo 'error_points';
        }


    } elseif ($action == "themdacdiem") {

        $tieude = $_POST['ten']; // Tên tài khoản
        $user_id = $_SESSION['id'];


        $insert_query = "INSERT INTO features (Name) VALUES (?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("s", $tieude);


        if ($stmt->execute()) {
            log_action($conn, $user_id, 'Insert', 'Thêm đặc điểm '.'Tiêu đề: '.$tieude,'employees');
            echo 'insert_success';
        } else {
            echo 'error_points';
        }


    } elseif ($action == "capnhatour") {
        $id = $_POST['id'];
        $name = $_POST['ten'];
        $style = $_POST['pc'];
        $price = $_POST['price'];
        $child_price_percen = $_POST['te'];
        $max_participant = $_POST['td'];
        $min_participant = $_POST['tt'];
        $description = $_POST['dereption'];
        $status = $_POST['status'];
        $depart = $_POST['nkh'];
        $departure_location = $_POST['ddkh'];
        $itinerary = $_POST['cd'];
        $employee_id = $_POST['emid'];
        $type = $_POST['kt'];
        $timetour = $_POST['no'];
        $discount = $_POST['gg'];
        $vehicle = $_POST['PT'];
        $vung = $_POST['vung'];
        $order = 0;
        $user_id = $_SESSION['id'];
        $departure_dates = json_decode($_POST["departure_dates"], true);
        $conn->begin_transaction();

        try {
            // Cập nhật thông tin bảng tour
            $update_tour_query = "
                UPDATE tour 
                SET Name = ?, Style = ?, Price = ?, Child_price_percen = ?, Max_participant = ?, Min_participant = ?, 
                    Description = ?, Status = ?, Depart = ?, DepartureLocation = ?, Itinerary = ?, employeesId = ?, 
                    type = ?, timetour = ?, discount = ?, vehicle = ?,vung = ?
                WHERE id = ?";
            $stmt_tour = $conn->prepare($update_tour_query);
            $stmt_tour->bind_param(
                "ssissssssssississi",
                $name,
                $style,
                $price,
                $child_price_percen,
                $max_participant,
                $min_participant,
                $description,
                $status,
                $depart,
                $departure_location,
                $itinerary,
                $employee_id,
                $type,
                $timetour,
                $discount,
                $vehicle,
                $vung,
                $id
            );
            $stmt_tour->execute();

            // Cập nhật thông tin thời gian khởi hành
            $update_depart_query = "UPDATE departure_time SET Day_depart = ? WHERE id_tour = ?";
            $stmt_depart = $conn->prepare($update_depart_query);
            $stmt_depart->bind_param("si", $timetour, $id);
            $stmt_depart->execute();

            // Cập nhật thông tin lịch trình
            $update_schedule_query = "UPDATE tour_schedule SET Name = ?, Date = ?, Schedule = ?, Locations = ? WHERE id_tour = ?";
            $stmt_schedule = $conn->prepare($update_schedule_query);
            $stmt_schedule->bind_param("ssssi", $name, $depart, $timetour, $departure_location, $id);
            $stmt_schedule->execute();
            if($departure_dates){
                $update_date = "INSERT INTO departure_dates (tour_id, departure_date) VALUES (?, ?)";
                $stmt_date = $conn->prepare($update_date);
            
                $insert_schedule_query = "INSERT INTO tour_schedule (id_tour, Name, Date, Schedule, Locations) VALUES (?,?,?,?,?)";
                $stmt_schedule = $conn->prepare($insert_schedule_query);
                
                $insert_depart_query = "INSERT INTO departure_time (id_tour, Orders,Day_depart,ngaykhoihanh) VALUES (?, ?,?,?)";
                $stmt_depart = $conn->prepare($insert_depart_query);
                // Duyệt mảng ngày khởi hành và thêm vào database
                foreach ($departure_dates as $date) {
                    // Thêm vào departure_dates
                    $stmt_date->bind_param("is", $id, $date);
                    $stmt_date->execute();
            
                    // Thêm vào tour_schedule
                    $stmt_schedule->bind_param("issss", $id, $name, $date, $timetour, $departure_location);
                    $stmt_schedule->execute();

                    $stmt_depart->bind_param("iiss", $id, $order, $timetour,$date);
                    $stmt_depart->execute();
                  
                }
            }
           
            // Xử lý ảnh nếu có
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $file = $_FILES['anh']['tmp_name'];
                $name_image = $_FILES['anh']['name'];
                $file_type = $_FILES['anh']['type'];

                // Kiểm tra định dạng file ảnh
                if (!in_array($file_type, ["image/jpg", "image/jpeg", "image/png"])) {
                    echo 'invalid_image';
                    exit;
                }

                // Tải lên ảnh mới
                if (move_uploaded_file($file, "../assets/img/tour/" . $name_image)) {
                    $update_image_query = "UPDATE tour_images SET Image = ? WHERE id_tour = ?";
                    $stmt_image = $conn->prepare($update_image_query);
                    $stmt_image->bind_param("si", $name_image, $id);
                    $stmt_image->execute();
                } else {
                    echo 'upload_error';
                    exit;
                }
            }

            // Commit giao dịch nếu không có lỗi
            $conn->commit();
            log_action($conn, $user_id, 'Update', 'Cập nhật tour '.'ID:'.$id.' '.$name,'employees');
            echo 'update_success';

        } catch (Exception $e) {
            // Rollback giao dịch nếu có lỗi
            $conn->rollback();
            echo 'update_error';
        }
    } elseif ($action == "themtour") {
        $name = $_POST['ten']; // Tên tour
        $style = $_POST['pc']; // Phong cách
        $price = $_POST['price']; // Giá tour
        $child_price_percen = $_POST['te']; // Phần trăm giá trẻ em
        $max_participant = $_POST['td']; // Số lượng tối đa
        $min_participant = $_POST['tt']; // Số lượng tối thiểu
        $description = $_POST['dereption']; // Nội dung
        $status = $_POST['status']; // Trạng thái
        $depart = $_POST['nkh']; // Ngày khởi hành
        $departure_location = $_POST['ddkh']; // Địa điểm khởi hành
        $itinerary = $_POST['cd']; // Chuyến đi
        $employee_id = $_POST['emid']; // Người tạo
        $type = $_POST['kt']; // Kiểu tour
        $timetour = $_POST['no']; // Ngày ở
        $discount = $_POST['gg']; // Giảm giá
        $vehicle = $_POST['PT']; // Phương tiện
        $ks = $_POST['khachsan']; // Phương tiện
        $vung = $_POST['vung']; // Phương tiện
        $user_id = $_SESSION['id'];
        $departure_dates = json_decode($_POST["departure_dates"], true);
        $order = 0;
        // Bắt đầu kiểm tra và xử lý ảnh
        if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
            $file = $_FILES['anh']['tmp_name'];
            $name_image = $_FILES['anh']['name'];
            $file_type = $_FILES['anh']['type'];

            // Kiểm tra định dạng file ảnh
            if ($file_type != "image/jpg" && $file_type != "image/jpeg" && $file_type != "image/png") {
                echo 'invalid_image';
                exit;
            }

            // Xử lý tải file ảnh lên thư mục
            if (move_uploaded_file($file, "../assets/img/tour/" . $name_image)) {
                // Sử dụng giao dịch để đảm bảo thêm vào cả hai bảng
                $conn->begin_transaction();

                try {
                    // Thêm dữ liệu vào bảng tour
                    $insert_tour_query = "
                        INSERT INTO tour (Name, Style, Price, Child_price_percen, Max_participant, Min_participant, 
                        Description, Status, Depart, DepartureLocation, Itinerary, employeesId, type, timetour, discount, vehicle,vung,idks) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
                    $stmt_tour = $conn->prepare($insert_tour_query);
                    $stmt_tour->bind_param(
                        "ssissssssssississi",
                        $name,
                        $style,
                        $price,
                        $child_price_percen,
                        $max_participant,
                        $min_participant,
                        $description,
                        $status,
                        $depart,
                        $departure_location,
                        $itinerary,
                        $employee_id,
                        $type,
                        $timetour,
                        $discount,
                        $vehicle,
                        $vung,
                        $ks
                    );
                    $stmt_tour->execute();

                    // Lấy ID của tour vừa thêm
                    $new_tour_id = $conn->insert_id;

                    // Thêm dữ liệu vào bảng tour_images
                    $insert_image_query = "INSERT INTO tour_images (id_tour, Image) VALUES (?, ?)";
                    $stmt_image = $conn->prepare($insert_image_query);
                    $stmt_image->bind_param("is", $new_tour_id, $name_image);
                    $stmt_image->execute();

                    $insert_depart_query = "INSERT INTO departure_time (id_tour, Orders,Day_depart) VALUES (?, ?,?)";
                    $stmt_depart = $conn->prepare($insert_depart_query);
                    $stmt_depart->bind_param("iis", $new_tour_id, $order, $timetour);
                    $stmt_depart->execute();

                    $insert_schedule_query = "INSERT INTO tour_schedule (id_tour, Name,Date,Schedule,Locations) VALUES (?,?,?,?,?)";
                    $stmt_schedule = $conn->prepare($insert_schedule_query);

                    $stmt_schedule->bind_param("issss", $new_tour_id, $name, $depart, $timetour, $departure_location);
                    $stmt_schedule->execute();

                    if($departure_dates){
                        $update_date = "INSERT INTO departure_dates (tour_id, departure_date) VALUES (?, ?)";
                        $stmt_date = $conn->prepare($update_date);
                    
                        $insert_schedule_query = "INSERT INTO tour_schedule (id_tour, Name, Date, Schedule, Locations) VALUES (?,?,?,?,?)";
                        $stmt_schedule = $conn->prepare($insert_schedule_query);
                        
                        $insert_depart_query = "INSERT INTO departure_time (id_tour, Orders,Day_depart,ngaykhoihanh) VALUES (?, ?,?,?)";
                        $stmt_depart = $conn->prepare($insert_depart_query);
                        // Duyệt mảng ngày khởi hành và thêm vào database
                        foreach ($departure_dates as $date) {
                            // Thêm vào departure_dates
                            $stmt_date->bind_param("is", $new_tour_id, $date);
                            $stmt_date->execute();
                    
                            // Thêm vào tour_schedule
                            $stmt_schedule->bind_param("issss", $new_tour_id, $name, $date, $timetour, $departure_location);
                            $stmt_schedule->execute();

                            $stmt_depart->bind_param("iiss", $new_tour_id, $order, $timetour,$date);
                            $stmt_depart->execute();
                        }
                    }
                    // Commit giao dịch nếu không có lỗi
                    $conn->commit();
                    log_action($conn, $user_id, 'Insert', 'Thêm tour '.'Tiêu đề: '.$name,'employees');
                    echo 'insert_success';
                } catch (Exception $e) {
                    // Rollback giao dịch nếu có lỗi
                    $conn->rollback();
                    echo 'insert_error';
                }
            } else {
                echo 'upload_error';
            }
        } else {
            // Xử lý khi không có ảnh
            echo 'missing_image';
        }
    } elseif ($action == "capnhatroom") {
        // Nhận dữ liệu từ form
        $id = $_POST['id'];
        $name = $_POST['ten'];
        $diadiem = $_POST['ddd'];
        $area = $_POST['dt'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $adult = $_POST['td'];
        $children = $_POST['tt'];
        $ngaynhan= $_POST['ngaynhan'];   
        $ngaytra = $_POST['ngaytra'];
        $description = $_POST['dereption'];
        $feature_id = $_POST['dd'];
        $facility_id = $_POST['ti'];
        $employee_id = $_POST['emid'];

        $remove = 'no';

        try {
            // Bắt đầu giao dịch
            $conn->begin_transaction();

            // Kiểm tra và xử lý ảnh
            $name_image = null;
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $file = $_FILES['anh']['tmp_name'];
                $name_image = $_FILES['anh']['name'];
                $file_type = $_FILES['anh']['type'];
                $upload_dir = "../assets/img/KS/";

                // Kiểm tra định dạng file ảnh
                $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!in_array($file_type, $allowed_types)) {
                    echo 'invalid_image';
                    exit;
                }

                // Upload file ảnh
                if (!move_uploaded_file($file, $upload_dir . $name_image)) {
                    echo 'upload_error';
                    exit;
                }
            }
            if ($ngaynhan >= $ngaytra) {
                echo 'error day';
                exit;
            }

            // Cập nhật bảng `room`
            $update_room_query = "
                UPDATE rooms 
                SET Name = ?,Diadiem = ?,Ngaynhan = ?,Ngaytra = ?, Area = ?, Price = ?, Adult = ?, Children = ?,noidung = ?, Status = ?, 
                    Removed = ?, employeesId = ?
                WHERE id = ?";
            $stmt_room = $conn->prepare($update_room_query);
            $stmt_room->bind_param(
                "sssssisssssii",
                $name,
                $diadiem,
                $ngaynhan,
                $ngaytra,
                $area,
                $price,
                $adult,
                $children,
                $description,
                $status,
                $remove,
                $employee_id,
                $id
            );
            $stmt_room->execute();

            // Cập nhật bảng `room_images` nếu có ảnh mới
            if ($name_image) {
                $update_image_query = "UPDATE rooms_images SET Image = ? WHERE Room_id = ?";
                $stmt_image = $conn->prepare($update_image_query);
                $stmt_image->bind_param("si", $name_image, $id);
                $stmt_image->execute();
            }

            // Cập nhật bảng `rooms_features`
            $update_features_query = "UPDATE rooms_features SET Features_id = ? WHERE Room_id = ?";
            $stmt_features = $conn->prepare($update_features_query);
            $stmt_features->bind_param("ii", $feature_id, $id);
            $stmt_features->execute();

            // Cập nhật bảng `rooms_facilities`
            $update_facilities_query = "UPDATE rooms_facilities SET Facilities_id = ? WHERE Room_id = ?";
            $stmt_facilities = $conn->prepare($update_facilities_query);
            $stmt_facilities->bind_param("ii", $facility_id, $id);
            $stmt_facilities->execute();

            // Commit giao dịch
            $conn->commit();
            log_action($conn, $employee_id, 'Update', 'Cập nhật phòng','employees');

            echo 'update_success';
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $conn->rollback();
            echo 'update_error: ' . $e->getMessage();
        }
    } elseif ($action == "themroom") {
        // Nhận dữ liệu từ form
        $name = $_POST['ten'];
        $diadiem = $_POST['ddd'];
        $ngaytra = $_POST['ngaytra'];   
        $ngaynhan = $_POST['ngaynhan']; 
        $area = $_POST['dt'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $adult = $_POST['td'];
        $children = $_POST['tt'];
        $description = $_POST['dereption'];
        $feature_id = $_POST['dd'];
        $facility_id = $_POST['ti'];
        $employee_id = $_POST['emid'];
        $remove = 'no';

        try {
            // Bắt đầu giao dịch
            $conn->begin_transaction();

            // Xử lý ảnh
            $name_image = null;
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $file = $_FILES['anh']['tmp_name'];
                $name_image = $_FILES['anh']['name'];
                $file_type = $_FILES['anh']['type'];
                $upload_dir = "../assets/img/KS/";

                // Kiểm tra định dạng file ảnh
                $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!in_array($file_type, $allowed_types)) {
                    echo 'invalid_image';
                    exit;
                }

                // Upload file ảnh
                if (!move_uploaded_file($file, $upload_dir . $name_image)) {
                    echo 'upload_error';
                    exit;
                }
            }
            if ($ngaynhan >= $ngaytra) {
                echo 'error day';
                exit;
            }

            // Thêm mới vào bảng `rooms`
            $insert_room_query = "
                INSERT INTO rooms (Name,Diadiem,Ngaynhan,Ngaytra, Area, Price, Adult, Children,noidung, Status, Removed, employeesId)
                VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)";
            $stmt_room = $conn->prepare($insert_room_query);
            $stmt_room->bind_param(
                "sssssisssssi",
                $name,
                $diadiem,
                $ngaynhan,  
                $ngaytra,
                $area,
                $price,
                $adult,
                $children,
                $description,
                $status,
                $remove,
                $employee_id
            );
            $stmt_room->execute();

            // Lấy ID phòng vừa chèn
            $room_id = $conn->insert_id;

            // Thêm mới vào bảng `room_images` nếu có ảnh
            if ($name_image) {
                $insert_image_query = "INSERT INTO rooms_images (Room_id, Image) VALUES (?, ?)";
                $stmt_image = $conn->prepare($insert_image_query);
                $stmt_image->bind_param("is", $room_id, $name_image);
                $stmt_image->execute();
            }

            // Thêm mới vào bảng `rooms_features`
            $insert_features_query = "INSERT INTO rooms_features (Room_id, Features_id) VALUES (?, ?)";
            $stmt_features = $conn->prepare($insert_features_query);
            $stmt_features->bind_param("ii", $room_id, $feature_id);
            $stmt_features->execute();

            // Thêm mới vào bảng `rooms_facilities`
            $insert_facilities_query = "INSERT INTO rooms_facilities (Room_id, Facilities_id) VALUES (?, ?)";
            $stmt_facilities = $conn->prepare($insert_facilities_query);
            $stmt_facilities->bind_param("ii", $room_id, $facility_id);
            $stmt_facilities->execute();

            // Commit giao dịch
            $conn->commit();
            log_action($conn, $employee_id, 'Insert', 'Thêm phòng','employees');
            echo 'insert_success';
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $conn->rollback();
            echo 'insert_error: ' . $e->getMessage();
        }
    }elseif ($action == "capnhathdv") {
    $ma = $_POST['id']; // ID lịch trình
    $hdv_list = $_POST['hdv1']; // Danh sách HDV, có thể là mảng
    $date = new DateTime($_POST['date']); // Ngày mới chọn
    $formatted_date = $date->format('Y-m-d');

    if (!is_array($hdv_list)) {
        $hdv_list = [$hdv_list]; // nếu chỉ 1 HDV thì gói lại thành mảng
    }

    foreach ($hdv_list as $hdv) {
        // Convert hdv sang int để đảm bảo an toàn
        $hdv = (int)$hdv;

        // -- Tìm lịch trình gần nhất trước ngày chọn
        $check_schedule_query = "SELECT tour_schedule.Date, tour_schedule.Schedule 
                                 FROM assignment_tour 
                                 INNER JOIN tour_schedule ON tour_schedule.id = assignment_tour.id_toursche 
                                 WHERE assignment_tour.employid = ? AND tour_schedule.Date < ? 
                                 ORDER BY tour_schedule.Date DESC LIMIT 1";
        $stmt = $conn->prepare($check_schedule_query);
        $stmt->bind_param("is", $hdv, $formatted_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $last_schedule_date = new DateTime($row['Date']);
            preg_match('/(\d+) ngày/', $row['Schedule'], $match);
            $last_schedule_days = isset($match[1]) ? (int)$match[1] : 1;
            $last_schedule_end_date = clone $last_schedule_date;
            $last_schedule_end_date->modify("+{$last_schedule_days} days");

            if ($date <= $last_schedule_end_date) {
                echo "schedule_conflict|Nhân viên đang có lịch từ " . $last_schedule_date->format('d/m/Y') .
                    " đến " . $last_schedule_end_date->format('d/m/Y');
                exit;
            }
        }

        // -- Kiểm tra trùng ngày cho cùng HDV
        $check_duplicate_query = "SELECT * FROM assignment_tour 
                                  INNER JOIN tour_schedule ON tour_schedule.id = assignment_tour.id_toursche 
                                  WHERE DATE(tour_schedule.Date) = DATE(?) 
                                  AND assignment_tour.employid = ? 
                                  AND assignment_tour.id_toursche != ?";
        $stmt = $conn->prepare($check_duplicate_query);
        $stmt->bind_param("sii", $formatted_date, $hdv, $ma);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo 'duplicate_date';
            exit;
        }

        // -- Kiểm tra nếu HDV đã có trong assignment_tour của lịch trình
        $check_exist_query = "SELECT * FROM assignment_tour WHERE id_toursche = ? AND employid = ?";
        $stmt = $conn->prepare($check_exist_query);
        $stmt->bind_param("ii", $ma, $hdv);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo 'already_assigned';
            exit;
        } else {
            // Thêm mới
            $insert_query = "INSERT INTO assignment_tour (id_toursche, employid) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ii", $ma, $hdv);
            if (!$stmt->execute()) {
                echo 'error_insert';
                exit;
            }
        }
    }

    echo 'insert_success';
    exit;
}

elseif ($action == "thaytglv") {
        $ma = $_POST['id'];

        $date = $_POST['dat']; // Nội dung


        // Cập nhật tin tức với ảnh
        $update_query = "UPDATE schedule SET work_date = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $date, $ma);

        if ($stmt->execute()) {
            echo 'update_success';
        } else {
            echo 'error_points';
        }


    }elseif ($action == "assign_shift") {
        header('Content-Type: application/json'); // Đảm bảo API trả về JSON
    
        $employees = $_POST['employee_id'] ?? []; // Lấy danh sách nhân viên (mảng)
        $shift = $_POST['shift'] ?? null;
        $shift_date = $_POST['shift_date'] ?? null;
    
        if (empty($employees) || !$shift || !$shift_date) {
            echo json_encode(["error1" => "Thiếu dữ liệu"]);
            exit;
        }
    
        $success_count = 0;
        $errors = [];
    
        foreach ($employees as $employee_id) {
            // Kiểm tra xem nhân viên đã có lịch cho ngày đó chưa
            $check_query = "SELECT id FROM schedule WHERE employee_id = ? AND shift_date = ? AND shift = ?";
            $check_stmt = $conn->prepare($check_query);
    
            if (!$check_stmt) {
                echo json_encode(["error" => "Lỗi chuẩn bị SQL: " . $conn->error]);
                exit;
            }
    
            $check_stmt->bind_param("iss", $employee_id, $shift_date, $shift);
            $check_stmt->execute();
            $check_stmt->store_result();
    
            if ($check_stmt->num_rows > 0) {
                $errors[] = "Nhân viên ID $employee_id đã có lịch làm vào ngày $shift_date, ca $shift";
                continue; // Bỏ qua nhân viên này nếu trùng lịch
            }
    
            $check_stmt->close();
    
            // Chèn dữ liệu mới nếu không bị trùng lịch
            $query = "INSERT INTO schedule (employee_id, shift, shift_date) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
    
            if (!$stmt) {
                echo json_encode(["error" => "Lỗi chuẩn bị SQL: " . $conn->error]);
                exit;
            }
    
            $stmt->bind_param("iss", $employee_id, $shift, $shift_date);
    
            if ($stmt->execute()) {
                $success_count++;
            } else {
                $errors[] = "Lỗi khi phân công nhân viên ID $employee_id: " . $stmt->error;
            }
    
            $stmt->close();
        }
    
        if ($success_count > 0) {
            $response = ["success" => "Đã phân công $success_count nhân viên thành công"];
            if (!empty($errors)) {
                $response["warnings"] = $errors; // Thêm cảnh báo nếu có nhân viên bị trùng lịch
            }
            echo json_encode($response);
        } else {
            echo json_encode(["error" => "Không thể phân công ca làm việc", "details" => $errors]);
        }
    }
    
    
    
    
     elseif ($action == "phanlich") {
        $manv = $_POST['emi'];
        $date = $_POST['dat']; // Dữ liệu từ form, có thể ở dạng 'YYYY-MM-DD'

        // Kiểm tra xem có bản ghi nào trong cùng ngày và cùng nhân viên không



        // Kiểm tra xem có bản ghi nào trong cùng ngày và cùng nhân viên không
        $check_query = "SELECT * FROM schedule WHERE DATE(work_date) = DATE(?) AND employid = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("si", $date, $manv);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo 'duplicate_date'; // Ngày đã tồn tại
        } else {
            // Nếu không trùng thì thêm mới
            $insert_query = "INSERT INTO schedule (work_date, employid) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("si", $date, $manv);

            if ($stmt->execute()) {
                echo 'insert_success';
            } else {
                echo 'error_insert';
            }
        }
    }
    elseif ($action == "capnhathoadon") {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['participants']) || !is_array($data['participants'])) {
            echo json_encode(["error" => "Dữ liệu không hợp lệ!"]);
            exit();
        }
    
        // Cập nhật bảng participant
        $stmt_participant = $conn->prepare("UPDATE participant SET hoten = ?, Ngaysinh = ?, gioitinh = ? WHERE idpar = ?");
        
        foreach ($data['participants'] as $participant) {
            $hoten = $participant['hoten'];
            $ngaysinh = $participant['ngaysinh'];
            $gioitinh = $participant['gioitinh'];
            $idpar = $participant['idpar']; // Sửa lại để khớp với JS
    
            $stmt_participant->bind_param("sssi", $hoten, $ngaysinh, $gioitinh, $idpar);
            $stmt_participant->execute();
        }
    
        // Cập nhật booking_ordertour
        if (!empty($data['booking_id']) && !empty($data['arrival'])) {
            $stmt_order = $conn->prepare("UPDATE booking_ordertour SET Arrival = ? WHERE Booking_id = ?");
            $stmt_order->bind_param("si", $data['arrival'], $data['booking_id']);
            $stmt_order->execute();
            $stmt_order->close();
        }
    
        // Cập nhật booking_detail_tour
        if (!empty($data['user_name']) && !empty($data['phone_num']) && !empty($data['address'])) {
            $stmt_detail = $conn->prepare("UPDATE booking_detail_tour SET User_name = ?, Phone_num = ?, Address = ? WHERE Booking_id = ?");
            $stmt_detail->bind_param("sssi", $data['user_name'], $data['phone_num'], $data['address'], $data['booking_id']);
            $stmt_detail->execute();
            $stmt_detail->close();
        }
    
        $stmt_participant->close();
        
        echo json_encode(["message" => "Cập nhật thành công!"]);
    }
    
    
    elseif ($action == "dattourfulll") {
        // Lấy dữ liệu từ POST
        $user_id = null;
        $tour_id = $_POST['tour_id'];
        $departure_id = $_POST['depart_id'];
        $arrival = $_POST['arrival'];
        $booking_status = '2';
        $payment_status = '1';
        $refund = 0;
        $datetime = $_POST['ns'];
        $participants = $_POST['adults'] + $_POST['children'] + $_POST['babies'];
    
        $tour_name = $_POST['tour_name'];
        $price = $_POST['price1'];
        $total_pay = $_POST['total-price'];
        $user_name = $_POST['fullname'];
        $phone_num = $_POST['phone'];
        $address = $_POST['address'];
        $max = (int)$_POST['max']; 
        $order = (int)$_POST['order']; 
        $soluong = $max - $order;
    
        $hoten = $_POST['hot']; // Mảng họ tên
        $ngaysinh = $_POST['ngaysi']; // Mảng ngày sinh
        $gioitinhs = $_POST['gioit']; // Mảng giới tính
        $phanloai=$_POST['phanloai']; 
        $tenks=$_POST['ks'];
        $tienks=$_POST['tienks'];

      
            $method = $_POST['method'] ?? '';
    
          
    
    
    
        
        // Kiểm tra dữ liệu
        if (empty($tour_id) || empty($tour_name) || empty($price)) {
            echo 'missing_data';
            exit;
        }
        if (empty($datetime)) {
            echo 'missing_data1';
            exit;
        }
        if ($participants > $max) {
            echo 'quaso|quá số lượng chỉ còn ' . $soluong . ' người';
            exit;
        }
    
        // 1. Thêm vào bảng booking_ordertour
        $insert_order_query = "INSERT INTO booking_ordertour (
            User_id, Tour_id, Departure_id, Arrival, Booking_status, Payment_status, refund, Datetime, participants
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_order = $conn->prepare($insert_order_query);
    
        if (!$stmt_order) {
            echo 'query_error';
            exit;
        }
    
        $stmt_order->bind_param(
            "iiisssiss",
            $user_id,
            $tour_id,
            $departure_id,
            $arrival,
            $booking_status,
            $payment_status,
            $refund,
            $datetime,
            $participants
        );
    
        if ($stmt_order->execute()) {
            // Lấy Booking_id vừa tạo
            $booking_id = $conn->insert_id;
    
            // 2. Thêm vào bảng booking_detail_tour
            $insert_detail_query = "INSERT INTO booking_detail_tour (
                Booking_id, Tour_name, Price, Total_pay, User_name, Phone_num, Address,tenks,tienks
            ) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)";
            $stmt_detail = $conn->prepare($insert_detail_query);
    
            if (!$stmt_detail) {
                echo 'query_error';
                exit;
            }
    
            $stmt_detail->bind_param(
                "issssssss",
                $booking_id,
                $tour_name,
                $price,
                $total_pay,
                $user_name,
                $phone_num,
                $address,
                $tenks,
                $tienks
            );
    
            if ($stmt_detail->execute()) {
                // 3. Cập nhật số lượng đặt chỗ trong departure_time
                $update_departure_query = "UPDATE departure_time SET Orders = Orders + ? WHERE id_tour = ?";
                $stmt_departure = $conn->prepare($update_departure_query);
    
                if (!$stmt_departure) {
                    echo 'query_error';
                    exit;
                }
    
                $stmt_departure->bind_param("ii", $participants, $tour_id);
    
                if ($stmt_departure->execute()) {
                    // 4. Thêm dữ liệu vào bảng participant
                    if (!empty($hoten) && !empty($ngaysinh) && !empty($gioitinhs) && !empty($phanloai)) {
                        $insert_participant_query = "INSERT INTO participant (idbook, hoten, ngaysinh, gioitinh, phanloai) VALUES (?, ?, ?, ?, ?)";
                        $stmt_participant = $conn->prepare($insert_participant_query);

                        if (!$stmt_participant) {
                            echo 'query_error';
                            exit;
                        }

                        foreach ($hoten as $key => $name) {
                            $dob = $ngaysinh[$key] ?? '';
                            $gender = $gioitinhs[$key] ?? '';
                            $phan = $phanloai[$key] ?? '';

                            $stmt_participant->bind_param("issss", $booking_id, $name, $dob, $gender, $phan);
                            $stmt_participant->execute(); // Chỉ gọi 1 lần trong vòng lặp
                        }

                        $stmt_participant->close(); // Đóng statement sau khi lặp xong

                        // 5. Lưu phương thức thanh toán
                        if (!empty($method)) {
                            $stmt_method = $conn->prepare("INSERT INTO payments (user_id, idbook, method) VALUES (?, ?, ?)");
                            $stmt_method->bind_param("iis", $user_id, $booking_id, $method);

                            if ($stmt_method->execute()) {
                                echo 'insert_success';
                            } else {
                                echo "Lỗi khi lưu dữ liệu.";
                            }

                            $stmt_method->close();
                        } else {
                            echo "Vui lòng chọn phương thức thanh toán.";
                        }
                    } else {
                        echo 'update_participant_error';
                    }

                    
                } else {
                    echo 'update_departure_error';
                }
                $stmt_departure->close();
            } else {
                echo 'insert_detail_error';
            }
            $stmt_detail->close();
        } else {
            echo 'insert_order_error';
        }
        $stmt_order->close();
    } elseif ($action == "guitinnhan") {
        $user_id = $_SESSION['id'];
        $room_id = $_POST['room_id'];
        $message = trim($_POST['message'] ?? '');
        $sender_id = $_POST['sender_id'] ?? 0; 
        $sender_type = "guide";
    
        // Kiểm tra nếu thiếu dữ liệu
        if (empty($room_id) || empty($message) || empty($user_id)) {
            die("Lỗi: Thiếu thông tin (room_id, message hoặc sender_id).");
        }
    
        // Chèn tin nhắn vào database
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id,room_id, sender_type, message, created_at) 
                                VALUES (?, ?, ?, ?, ?, NOW())");
    
        if (!$stmt) {
            die("Lỗi MySQL: " . $conn->error);
        }
    
        $stmt->bind_param("iisss", $sender_id, $user_id,$room_id, $sender_type, $message);
    
        if ($stmt->execute()) {
            echo 'success';
        } else {
            die("Lỗi MySQL khi thực thi: " . $stmt->error);
        }
    
        $stmt->close();

          
} elseif($action=="Phancong"){
    $customer_id = $_POST['customer_id'];
    $employee_id = $_POST['employee_id'];

    if (empty($customer_id) || empty($employee_id)) {
        echo  'Thiếu dữ liệu đầu vào';
        exit;
    }

    // Kiểm tra trùng lặp
    $checkStmt = $conn->prepare("SELECT * FROM customer_assignment WHERE customer_id = ?");
    $checkStmt->bind_param("i", $customer_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo 'Khách hàng đã được phân cho nhân viên này';
        exit;
    }
    if (!empty($customer_id) || !empty($employee_id)) {
    $stmt = $conn->prepare("INSERT INTO customer_assignment (customer_id, employee_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $customer_id, $employee_id);

    if ($stmt->execute()) {
        echo 'Phân công thành công';
    } else {
        echo 'Lỗi khi phân công';
    }

    $stmt->close();
}
}elseif ($action == "suataixe") {
    $ma = $_POST['id']; // ID người dùng
    $hoten=$_POST['ten'];
    $sdt=$_POST['sdt'];
    $email=$_POST['em'];
    $loai=$_POST['loai'];
  
    $status=$_POST['status'];
    $user_id = $_SESSION['id'];
    if (empty($hoten) || empty($sdt) || empty($email) || empty($loai)) {
        echo  'Thiếu dữ liệu đầu vào';
        exit;
    }
   


    $update_query = "UPDATE drivers SET name = ?, phone = ?,email = ?,	vehicle_type = ?,status = ? WHERE driver_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $hoten, $sdt,$email,$loai,$status, $ma);


    if ($stmt->execute()) {
        log_action($conn, $user_id, 'Update', 'Cập nhật tài xế '.'ID:'.$ma.' Tên: '.$hoten,'employees');
        echo 'update_success';
    } else {
        echo 'error_points';
    }


} elseif ($action == "themtaixe") {


    $hoten=$_POST['ten'];
    $sdt=$_POST['sdt'];
    $email=$_POST['em'];
    $loai=$_POST['loai'];
   
    $status=$_POST['status'];
    $user_id = $_SESSION['id'];
    if (empty($hoten) || empty($sdt) || empty($email) || empty($loai)) {
        echo  'Thiếu dữ liệu đầu vào';
        exit;
    }

    

    $insert_query = "INSERT INTO drivers (name,phone,email,vehicle_type,status) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssss",$hoten, $sdt,$email,$loai,$status);


    if ($stmt->execute()) {
        log_action($conn, $user_id, 'Insert', 'Thêm tài xế '.'Tên: '.$hoten,'employees');
        echo 'insert_success';
    } else {
        echo 'error_points';
    }


} 
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = $_GET['action'];
    if ($action == "get_nv") {
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['Phone_number'];
        $query = "SELECT * FROM employees where Email='$email' OR Phone_number='$phone'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    }elseif ($action == "get_shifts") {
        $date = $_GET['date'] ?? '';
    
        // Nếu không có ngày được chọn, lấy toàn bộ lịch làm việc
        if (empty($date)) {
            $query = "SELECT ws.*, e.Name FROM schedule ws 
                      JOIN employees e ON ws.employee_id = e.id 
                      ORDER BY ws.shift_date ASC";
            $stmt = $conn->prepare($query);
        } else {
            $query = "SELECT ws.*, e.Name FROM schedule ws 
                      JOIN employees e ON ws.employee_id = e.id 
                      WHERE ws.shift_date = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $date);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $shifts = [];
        while ($row = $result->fetch_assoc()) {
            $shifts[] = $row;
        }
    
        echo json_encode($shifts);
    }
   
    elseif ($action == "get_employees") {
        $query = "SELECT id, Employee_code, Name FROM employees ORDER BY Name ASC";
        $result = $conn->query($query);
    
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
    
        echo json_encode($employees);
    }
    
    
     elseif ($action == "get_thongke") {
        $query = "SELECT 
            COUNT(t.id) AS total_tours, 
            SUM(CASE WHEN t.Status = 'Hoạt động' THEN 1 ELSE 0 END) AS total_active,
            SUM(CASE WHEN t.Status = 'Inactive' THEN 1 ELSE 0 END) AS total_inactive,
            COUNT(r.Sr_no) AS total_reviews
        FROM
            tour t
        LEFT JOIN
            rating_reviewtour r ON t.id = r.Tour_id";

        // Kiểm tra kết nối
        if (!$conn) {
            echo json_encode(['error' => 'Không thể kết nối cơ sở dữ liệu.']);
            exit;
        }

        $result = $conn->query($query);

        if ($result) {
            $statistics = [];
            while ($row = $result->fetch_assoc()) {
                $statistics[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "get_booking_stats") {
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        $month = isset($_GET['month']) ? intval($_GET['month']) : null;
        $vung = isset($_GET['vung']) ? $_GET['vung'] : null;
        $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
        $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;
    
        // Truy vấn tổng hợp
        $query = "
           SELECT
            COUNT(bo.Booking_id) AS total_orders,
            SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
            SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
            SUM(CASE WHEN bo.refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
            
            IFNULL(SUM(bd.Total_pay), 0) AS total_amount,
            IFNULL(SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN bd.Total_pay ELSE 0 END), 0) AS new_orders_amount,
            IFNULL(SUM(CASE WHEN bo.Booking_status = 2 THEN bd.Total_pay ELSE 0 END), 0) AS approved_orders_amount,
            IFNULL(SUM(CASE WHEN bo.refund = 1 THEN bd.Total_pay ELSE 0 END), 0) AS cancelled_orders_amount,
    
            IFNULL(MONTH(bo.created_at), 0) AS order_month,
            IFNULL(YEAR(bo.created_at), 0) AS order_year,
            IFNULL(t.vung, '') AS vung,
            bo.*,
            bd.*
        FROM
            booking_ordertour bo
        LEFT JOIN
            booking_detail_tour bd ON bo.Booking_id = bd.Booking_id
        LEFT JOIN
            tour t ON bo.Tour_id = t.id
        WHERE
            YEAR(bo.created_at) = $year
        ";
    
        if (!empty($month)) {
            $query .= " AND MONTH(bo.created_at) = $month";
        }
        if (!empty($from_date) && !empty($to_date)) {
            $query .= " AND DATE(bo.created_at) BETWEEN '$from_date' AND '$to_date'";
        }
        if (!empty($vung)) {
            $query .= " AND t.vung = '$vung'";
        }
    
        // Truy vấn chi tiết
        $queryDetail = "
        SELECT
            bo.*,
            bd.*,
            t.vung
        FROM
            booking_ordertour bo
        LEFT JOIN
            booking_detail_tour bd ON bo.Booking_id = bd.Booking_id
        LEFT JOIN
            tour t ON bo.Tour_id = t.id
        WHERE
            YEAR(bo.created_at) = $year
        ";
    
        if (!empty($month)) {
            $queryDetail .= " AND MONTH(bo.created_at) = $month";
        }
        if (!empty($from_date) && !empty($to_date)) {
            $queryDetail .= " AND DATE(bo.created_at) BETWEEN '$from_date' AND '$to_date'";
        }
        if (!empty($vung)) {
            $queryDetail .= " AND t.vung = '$vung'";
        }
    
        $result = $conn->query($query);
        $summary = $result ? $result->fetch_assoc() : [];
        
        $resultDetail = $conn->query($queryDetail);
        $details = [];
        while ($row = $resultDetail->fetch_assoc()) {
            $details[] = $row;
        }
        
        echo json_encode([
            'summary' => $summary,
            'details' => $details
        ]);
        exit;
    }
    
     elseif ($action == "get_booking_stats1") {
        $query = "
            SELECT
                COUNT(bo.Booking_id) AS total_orders,
                SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
                SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                SUM(CASE WHEN bo.refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
                SUM(bd.Total_pay) AS total_amount,
                SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN bd.Total_pay ELSE 0 END) AS new_orders_amount,
                SUM(CASE WHEN bo.Booking_status = 2 THEN bd.Total_pay ELSE 0 END) AS approved_orders_amount,
                SUM(CASE WHEN bo.refund = 1 THEN bd.Total_pay ELSE 0 END) AS cancelled_orders_amount
            FROM
                booking_ordertour bo
            INNER JOIN
                booking_detail_tour bd ON bo.Booking_id = bd.Booking_id
        ";

        $result = $conn->query($query);

        $statistics = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {

                $statistics[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "bieudo") {
        $query = "
            SELECT
                  SUM(CASE WHEN Booking_status = 1 THEN 1 ELSE 0 END) AS new_orders,
                  SUM(CASE WHEN Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                  SUM(CASE WHEN refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders
              FROM
                  booking_ordertour
        ";

        $result = $conn->query($query);

        $statistics = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {

                $statistics = [
                    'new_orders' => $row['new_orders'],
                    'approved_orders' => $row['approved_orders'],
                    'cancelled_orders' => $row['cancelled_orders']
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "xemnhanvien") {

        $query = "SELECT * FROM employees";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "timma") {
        // Lấy giá trị 'MANV' từ tham số GET
        $code = $_GET['MANV'];

        // Kiểm tra nếu mã nhân viên không rỗng
        if (!empty($code)) {
            // Truy vấn cơ sở dữ liệu để tìm kiếm nhân viên có mã nhân viên tương tự
            $query = "SELECT * FROM employees WHERE Employee_code LIKE '%$code%' OR Name LIKE '%$code%'";
            $result = $conn->query($query);

            $users = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row; // Lưu từng bản ghi vào mảng
                }
            }

            // Trả về mảng nhân viên dưới dạng JSON
            echo json_encode($users);
        } else {
            // Trả về mảng rỗng nếu không có mã nhân viên
            echo json_encode([]);
        }
        exit;
    } elseif ($action == "timkh") {
        // Lấy giá trị 'MANV' từ tham số GET
        $code = $_GET['MAKH'];

        // Kiểm tra nếu mã nhân viên không rỗng
        if (!empty($code)) {
            // Truy vấn cơ sở dữ liệu để tìm kiếm nhân viên có mã nhân viên tương tự
            $query = "SELECT * FROM user_credit WHERE email LIKE '%$code%' OR sdt LIKE '%$code%'";
            $result = $conn->query($query);

            $users = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row; // Lưu từng bản ghi vào mảng
                }
            }

            // Trả về mảng nhân viên dưới dạng JSON
            echo json_encode($users);
        } else {
            // Trả về mảng rỗng nếu không có mã nhân viên
            echo json_encode([]);
        }
        exit;
    } elseif ($action == "timmatour") {
        // Lấy giá trị 'MANV' từ tham số GET
        $code = $_GET['MAT'];

        // Kiểm tra nếu mã nhân viên không rỗng
        if (!empty($code)) {
            // Truy vấn cơ sở dữ liệu để tìm kiếm nhân viên có mã nhân viên tương tự
            $query = "SELECT 
            tour.*, 
            tour.id AS idtour, 
            tour.Name AS tourname, 
             tour.Price AS tourprice,
            rooms.*,
            rooms.id AS idroom,
            rooms.Name AS roomname,
               rooms.Price AS roomprice,
            tour_images.*, 
            departure_time.*, 
            departure_time.id AS iddepart, 
            employees.Name AS tennhanvien, 
            employees.id, 
            GROUP_CONCAT(DISTINCT departure_dates.departure_date ORDER BY departure_dates.departure_date ASC) AS departure_dates
        FROM tour 
        LEFT JOIN tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN departure_time ON tour.id = departure_time.id_tour 
        LEFT JOIN employees ON tour.employeesId = employees.id 
        LEFT JOIN departure_dates ON tour.id = departure_dates.tour_id
        LEFT JOIN rooms ON tour.idks = rooms.id
         WHERE tour.id='$code' OR tour.Name LIKE '%$code%' 
        GROUP BY tour.id 
       ";
           
    $result = $conn->query($query);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['departure_dates'] = $row['departure_dates'] ? explode(",", $row['departure_dates']) : [];
            $users[] = $row; // Lưu từng bản ghi vào mảng
        }
    }

    echo json_encode($users);
        } else {
            
            echo json_encode([]);
        }
        exit;
    } elseif ($action == "xoanhanvien") {

        $id = $_GET['idnv'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM employees WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemnhanvien1") {
        $id = $_GET['idsua'];
        $query = "SELECT * FROM employees WHERE id = '$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemfeedback") {

        $query = "SELECT * FROM feedback";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "get_thongkeks") {
        $query = "SELECT 
            COUNT(t.id) AS total_rooms, 
            SUM(CASE WHEN t.Status = 'Hoạt động' THEN 1 ELSE 0 END) AS total_active,
            SUM(CASE WHEN t.Status = 'ko Hoạt động' THEN 1 ELSE 0 END) AS total_inactive,
            COUNT(r.Sr_no) AS total_reviews
        FROM
            rooms t
        LEFT JOIN
            rating_reviews_ks r ON t.id = r.Room_id";

        // Kiểm tra kết nối
        if (!$conn) {
            echo json_encode(['error' => 'Không thể kết nối cơ sở dữ liệu.']);
            exit;
        }

        $result = $conn->query($query);

        if ($result) {
            $statistics = [];
            while ($row = $result->fetch_assoc()) {
                $statistics[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "get_booking_statsks") {
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y'); // Lấy năm từ yêu cầu hoặc mặc định là năm hiện tại
        $month = isset($_GET['month']) ? intval($_GET['month']) : null; // Lấy tháng từ yêu cầu (nếu có)

        // Truy vấn SQL
        $query = "
            SELECT
                COUNT(bo.Booking_id) AS total_orders,
                SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
                SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                SUM(CASE WHEN bo.Refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
                SUM(bd.total_pay) AS total_amount,
                SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN bd.total_pay ELSE 0 END) AS new_orders_amount,
                SUM(CASE WHEN bo.Booking_status = 2 THEN bd.total_pay ELSE 0 END) AS approved_orders_amount,
                SUM(CASE WHEN bo.Refund = 1 THEN bd.total_pay ELSE 0 END) AS cancelled_orders_amount,
                MONTH(bo.created_at) AS order_month,
                YEAR(bo.created_at) AS order_year
            FROM
                booking_orderks bo
            INNER JOIN
                booking_details_ks bd ON bo.Booking_id = bd.Booking_id
            WHERE
                YEAR(bo.created_at) = $year
        ";

        // Thêm điều kiện tháng nếu có
        if ($month) {
            $query .= " AND MONTH(bo.created_at) = $month";
        }

        // Thêm nhóm theo tháng và năm
        $query .= " GROUP BY MONTH(bo.created_at), YEAR(bo.created_at)";

        // Thực thi truy vấn
        $result = $conn->query($query);

        $statistics = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $statistics[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            // Trả về lỗi nếu truy vấn thất bại
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "get_booking_statsks1") {
        $query = "
            SELECT
                COUNT(bo.Booking_id) AS total_orders,
                SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
                SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                SUM(CASE WHEN bo.refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
                SUM(bd.Total_pay) AS total_amount,
                SUM(CASE WHEN DATE(bo.created_at) = CURDATE() THEN bd.Total_pay ELSE 0 END) AS new_orders_amount,
                SUM(CASE WHEN bo.Booking_status = 2 THEN bd.Total_pay ELSE 0 END) AS approved_orders_amount,
                SUM(CASE WHEN bo.refund = 1 THEN bd.Total_pay ELSE 0 END) AS cancelled_orders_amount
             FROM
                booking_orderks bo
            INNER JOIN
                booking_details_ks bd ON bo.Booking_id = bd.Booking_id
        ";

        $result = $conn->query($query);

        $statistics = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {

                $statistics[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "bieudoks") {
        $query = "
            SELECT
                  SUM(CASE WHEN Booking_status = 1 THEN 1 ELSE 0 END) AS new_orders,
                  SUM(CASE WHEN Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                  SUM(CASE WHEN Refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders
              FROM
                  booking_orderks
        ";

        $result = $conn->query($query);

        $statistics1 = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {

                $statistics1 = [
                    'new_orders' => $row['new_orders'],
                    'approved_orders' => $row['approved_orders'],
                    'cancelled_orders' => $row['cancelled_orders']
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($statistics1);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "xemuser") {

        $query = "SELECT COUNT(user_credit.id) AS total_user FROM user_credit";
        $result = $conn->query($query);

        if (!$conn) {
            echo json_encode(['error' => 'Không thể kết nối cơ sở dữ liệu.']);
            exit;
        }

        $result = $conn->query($query);

        if ($result) {
            $statistics = [];
            while ($row = $result->fetch_assoc()) {
                $statistics[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
        exit;
    } elseif ($action == "xemtintuc") {

        $query = "SELECT news.*,employees.Name FROM news INNER JOIN employees ON news.employeesId= employees.id";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemtintuc1") {
        $id = $_GET['id'];
        $query = "SELECT news.*,employees.Name FROM news INNER JOIN employees ON news.employeesId= employees.id WHERE news.id='$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xoatintuc") {
        $user_id=$_SESSION['id'] ;
        $id = $_GET['idtt'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM news WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            log_action($conn, $user_id, 'Delete', 'Xóa tin tức','employees');
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemkh") {

        $query = "SELECT * FROM user_credit";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemkh1") {
        $id = $_GET['id'];
        $query = "SELECT * FROM user_credit where id='$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xoakh") {

        $id = $_GET['idkh'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM user_credit WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemtienich") {

        $query = "SELECT * FROM facilities";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemtienich1") {
        $id = $_GET['id'];
        $query = "SELECT * FROM facilities WHERE id = '$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xoatienich") {

        $id = $_GET['id'];
        $user_id = $_SESSION['id'];
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM facilities WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            log_action($conn, $user_id, 'Delete', 'Xóa tiện ích '.'ID:'.$id,'employees');
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemdacdiem") {

        $query = "SELECT * FROM features";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemdacdiem1") {
        $id = $_GET['id'];
        $query = "SELECT * FROM features WHERE id = '$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xoadacdiem") {

        $id = $_GET['id'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM features WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemtour") {

        $query = "SELECT 
            tour.*, 
            tour.id AS idtour, 
            tour.Name AS tourname, 
            tour.Price AS tourprice,
            tour_images.*, 
            departure_time.*, 
            departure_time.id AS iddepart, 
            employees.Name AS tennhanvien, 
            employees.id, 
            rooms.*,
            rooms.id AS idroom,
            rooms.Name AS roomname,
            rooms.Price AS roomprice,

            GROUP_CONCAT(DISTINCT departure_dates.departure_date ORDER BY departure_dates.departure_date ASC) AS departure_dates
        FROM tour 
        LEFT JOIN tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN departure_time ON tour.id = departure_time.id_tour 
        LEFT JOIN employees ON tour.employeesId = employees.id 
        LEFT JOIN departure_dates ON tour.id = departure_dates.tour_id
         LEFT JOIN rooms ON tour.idks = rooms.id
        GROUP BY tour.id 
       
        
        ";
    
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['departure_dates'] = $row['departure_dates'] ? explode(",", $row['departure_dates']) : [];
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemtour1") {
        $id = $_GET['id'];
    
        $query = "
            SELECT 
                tour.*, 
                tour.id AS idtour, 
                tour.Name AS tourname,
                tour_images.*, 
                 tour.id AS idtour, 
            tour.Name AS tourname, 
             tour.Price AS tourprice,
            rooms.*,
            rooms.id AS idroom,
            rooms.Name AS roomname,
               rooms.Price AS roomprice,
                departure_time.*, 
                departure_time.id AS iddepart, 
                employees.Name AS tennhanvien, 
                employees.id, 
              
                GROUP_CONCAT(DISTINCT departure_dates.departure_date ORDER BY departure_dates.departure_date ASC) AS departure_dates
            FROM tour 
            LEFT JOIN tour_images ON tour.id = tour_images.id_tour 
            LEFT JOIN departure_time ON tour.id = departure_time.id_tour 
            LEFT JOIN employees ON tour.employeesId = employees.id 
            LEFT JOIN departure_dates ON tour.id = departure_dates.tour_id
             LEFT JOIN rooms ON tour.idks = rooms.id
            WHERE tour.id = '$id'  
            GROUP BY tour.id
        ";
    
        $result = $conn->query($query);
    
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Chuyển danh sách ngày từ chuỗi thành mảng
                $row['departure_dates'] = $row['departure_dates'] ? explode(",", $row['departure_dates']) : [];
                
                $users[] = $row;
            }
        }
    
        echo json_encode($users); // Trả về JSON
        exit;
    }
     elseif ($action == "xoatour") {

        $id = $_GET['id'];
        $user_id = $_SESSION['id'];
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM tour WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            log_action($conn, $user_id, 'Delete', 'Xóa tour '.'ID: '.$id,'employees');
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemks") {

        $query = "SELECT 
            r.*, r.Name as room_name,
             r.id AS idroom,
            f.*, 
            f.Name AS feature_name, 
            fa.*,
            fa.Name AS facility_name,
            rfa.*, ri.*, rf.*,e.Name AS tennhanvien
          FROM rooms r
          JOIN rooms_features rf ON r.id = rf.Room_id
          JOIN rooms_facilities rfa ON r.id = rfa.Room_id
          JOIN rooms_images ri ON r.id = ri.Room_id
          JOIN features f ON rf.Features_id = f.id
          JOIN facilities fa ON rfa.Facilities_id = fa.id
          JOIN employees e ON r.employeesId = e.id
        
        ";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemks1") {
        $id = $_GET['id'];
        $query = "SELECT 
            r.*, r.Name as room_name,
            r.id AS idroom,
            f.*, 
            f.Name AS feature_name, 
            fa.*,f.id AS idfeature,
            fa.Name AS facility_name,fa.id AS idfacility,
            rfa.*, ri.*, rf.*,e.Name AS tennhanvien
          FROM rooms r
          JOIN rooms_features rf ON r.id = rf.Room_id
          JOIN rooms_facilities rfa ON r.id = rfa.Room_id
          JOIN rooms_images ri ON r.id = ri.Room_id
          JOIN features f ON rf.Features_id = f.id
          JOIN facilities fa ON rfa.Facilities_id = fa.id
          JOIN employees e ON r.employeesId = e.id
          WHERE r.id='$id'
        ";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xoatour") {

        $id = $_GET['id'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM tour WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xoaphong") {

        $id = $_GET['id'];
        $user_id = $_SESSION['id'];
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM rooms WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            log_action($conn, $user_id, 'Delete', 'Xóa phòng '.'ID:'.$id,'employees');
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "timmaroom") {
        $id = $_GET['MAR'];
        $query = "SELECT 
             r.*, r.Name as room_name,
             r.id AS idroom,
             f.*, 
             f.Name AS feature_name, 
             fa.*,f.id AS idfeature,
             fa.Name AS facility_name,fa.id AS idfacility,
             rfa.*, ri.*, rf.*,e.Name AS tennhanvien
           FROM rooms r
           JOIN rooms_features rf ON r.id = rf.Room_id
           JOIN rooms_facilities rfa ON r.id = rfa.Room_id
           JOIN rooms_images ri ON r.id = ri.Room_id
           JOIN features f ON rf.Features_id = f.id
           JOIN facilities fa ON rfa.Facilities_id = fa.id
           JOIN employees e ON r.employeesId = e.id
           WHERE r.id='$id'
         ";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemHDV") {

        $query = "SELECT * FROM employees WHERE Permissions='HDV'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemlichtrinh") {
    // 1. Lấy danh sách tour sắp tới
 $query = "SELECT 
            tour_schedule.*, 
            tour_schedule.id AS idsh, 
            assignment_tour.*, 
            employees.Name AS emna, 
            employees.id AS idem, 
            departure_time.*, 
            departure_time.id AS iddp
        FROM tour_schedule
        LEFT JOIN assignment_tour ON tour_schedule.id = assignment_tour.id_toursche
        LEFT JOIN employees ON assignment_tour.employid = employees.id
        LEFT JOIN departure_time ON tour_schedule.Date = departure_time.ngaykhoihanh
        WHERE departure_time.ngaykhoihanh > NOW()
        GROUP BY tour_schedule.id 
        ORDER BY departure_time.ngaykhoihanh ASC";

    $result = $conn->query($query);
    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tour_id = $row['idsh'];

            // 2. Kiểm tra trạng thái theo ngày và số người đặt
            $tourDate = new DateTime($row['ngaykhoihanh']);
            $now = new DateTime();
            $now->setTime(0, 0, 0);
            $diff = $now->diff($tourDate)->days;

            if ($diff == 1) {
                if ($row['Orders'] < 10) {
                    $update = "UPDATE tour_schedule SET Trangthai = 3 WHERE id = $tour_id";
                    $conn->query($update);
                    $row['Trangthai'] = 3;
                } else {
                    $update = "UPDATE tour_schedule SET Trangthai = 2 WHERE id = $tour_id";
                    $conn->query($update);
                    $row['Trangthai'] = 2;
                }
            }

            // 3. Lấy danh sách HDV gán vào lịch trình
            $hdv_query = "SELECT e.id, e.Name 
                          FROM assignment_tour at
                          INNER JOIN employees e ON at.employid = e.id
                          WHERE at.id_toursche = $tour_id";
            $hdv_result = $conn->query($hdv_query);
            $guides = [];
            while ($hdv = $hdv_result->fetch_assoc()) {
                $guides[] = $hdv;
            }

            $row['guides'] = $guides;

            $users[] = $row;
        }
    }

    echo json_encode($users);
    exit;
}

     elseif ($action == "xemlichtrinh1") {
        $id = $_GET['id'];
        $query = "SELECT tour_schedule.*,assignment_tour.*,employees.Name AS emna,employees.id AS idem FROM tour_schedule LEFT JOIN assignment_tour ON tour_schedule.id=assignment_tour.id_toursche 
        LEFT JOIN employees ON assignment_tour.employid=employees.id where tour_schedule.id='$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemdichvuks") {

        $query = "SELECT * FROM booking_orderks INNER JOIN booking_details_ks ON booking_orderks.Booking_id=booking_details_ks.Booking_id";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xacnhanks") {

        $id = $_GET['id'];
        $trangthai = "2";
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE booking_orderks SET Booking_status ='$trangthai' WHERE Booking_id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "huydonks") {

        $id = $_GET['id'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM booking_orderks WHERE Booking_id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemdichvu") {

        $query = "
         SELECT 
        booking_ordertour.*,
        booking_detail_tour.*,
        departure_time.*,
        participant.*,
        tour.id AS tourid,
        tour.Child_price_percen
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
    LEFT JOIN
        participant ON booking_ordertour.Booking_id = participant.idbook
    LEFT JOIN
        tour ON booking_ordertour.Tour_id = tour.id
    GROUP BY booking_ordertour.Booking_id
        ";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    }elseif ($action == "xemtoursua") {
        
        $id = $_GET['idt'];
        $query = "
    SELECT 
        booking_ordertour.*,
        booking_detail_tour.*,
        departure_time.*,
        participant.*,
        tour.id AS tourid,
        tour.Child_price_percen
        
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
    LEFT JOIN
        participant ON booking_ordertour.Booking_id = participant.idbook
    LEFT JOIN
        tour ON booking_ordertour.Tour_id = tour.id
        
    WHERE 
        booking_ordertour.Booking_id = '$id' OR departure_time.id = '$id'
";


        // Thực hiện truy vấn
        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            // Lấy từng dòng dữ liệu
            while ($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
        }

        if (empty($res)) {
            echo json_encode(["message" => "No tour found for the given ID"]);
        } else {
            echo json_encode($res); // Trả về dữ liệu dạng JSON
        }
        exit;
    } 
    elseif ($action == "xoapar") {
        $id = $_GET['id']; // ID thành viên bị xóa
        $idtour = $_GET['idtour']; // ID tour
        $booking_id = $_GET['booking_id']; // ID booking
        $adult_price = $_GET['adult_price']; // Giá người lớn
        $child_rate = $_GET['child_rate'] / 100; // Tỷ lệ giá trẻ em (5-11 tuổi)
    
        // Lấy thông tin của thành viên bị xóa
        $query = "SELECT phanloai FROM participant WHERE idpar = '$id'";
        $result = $conn->query($query);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $phanloai = $row['phanloai']; // Lấy loại thành viên (Người lớn/Trẻ em)
    
            // Xác định số tiền bị trừ dựa trên loại thành viên
            if ($phanloai == 'Người lớn') {
                $deduct_price = $adult_price;
            } elseif ($phanloai == 'Trẻ em (từ 2 -> 11 tuổi)') {
                $deduct_price = $adult_price * $child_rate;
            } else {
                $deduct_price = 0; // Em bé miễn phí
            }
    
            // Xóa thành viên khỏi bảng participant
            $delete_query = "DELETE FROM participant WHERE idpar = '$id'";
    
            // Giảm số lượng người tham gia và tổng tiền
            $update_booking_query = "UPDATE booking_ordertour 
                                     SET participants = participants - 1
                                     WHERE Booking_id = '$booking_id'";
            $update_booking_detail_query = "UPDATE booking_detail_tour 
            SET Total_pay = Total_pay - $deduct_price
            WHERE Booking_id = '$booking_id'";
    
            // Giảm số lượng Orders trong departure_time
            $update_departure_query = "UPDATE departure_time 
                                       SET Orders = Orders - 1 
                                       WHERE id_tour = '$idtour'";
    
            if (
                $conn->query($delete_query) === TRUE &&
                $conn->query($update_booking_query) === TRUE &&
                $conn->query($update_departure_query) === TRUE &&
                $conn->query($update_booking_detail_query) === TRUE
            ) {
                echo 'gui';
            } else {
                echo 'kotc';
            }
        } else {
            echo 'kotc';
        }
    }
    
    elseif ($action == "xacnhantour") {

        $id = $_GET['id'];
        $trangthai = "3";
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE booking_ordertour SET Payment_status ='$trangthai' WHERE Booking_id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "huydon") {

        $id = $_GET['id'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM booking_ordertour WHERE Booking_id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    }elseif ($action == "xemdichvuhdv") {
        $user_id = $_SESSION['id'];
        $current_date = date('Y-m-d'); // Lấy ngày hiện tại theo định dạng 'YYYY-MM-DD'
    
        $query = "
            SELECT 
                ts.Date,
                ts.Schedule,
                ts.Locations,
                ts.Trangthai,
                ts.Name AS tourname,
                ts.id AS idtourshe,
                ts.id_tour,
                e.Name AS EmployeeName,
                t.Itinerary
            FROM 
                tour_schedule ts
            LEFT JOIN 
                assignment_tour at ON ts.id = at.id_toursche
            LEFT JOIN 
                employees e ON at.employid = e.id
            LEFT JOIN 
                tour t ON ts.id_tour = t.id
            WHERE e.id = '$user_id'
            ORDER BY 
                ts.Date, ts.Schedule;
        ";
    
        $result = $conn->query($query);
    
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Lấy số ngày từ Schedule, ví dụ: "4 ngày 3 đêm" => lấy số 4
                preg_match('/(\d+)\s+ngày/', $row['Schedule'], $matches);
                $days_in_tour = isset($matches[1]) ? (int)$matches[1] : 0; // Lấy số ngày (4 ngày)
    
                // Lấy ngày bắt đầu của tour, loại bỏ phần giờ, phút, giây (chỉ lấy ngày)
                $start_date = date('Y-m-d', strtotime($row['Date']));
    
                // Tính ngày kết thúc của tour bằng cách cộng số ngày vào ngày bắt đầu
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $days_in_tour . ' days'));
    
                // So sánh nếu ngày hiện tại vượt qua ngày kết thúc, thì cập nhật trạng thái
                if ($current_date > $end_date) {
                    // Cập nhật trạng thái tour thành 4 (đã kết thúc) trong cơ sở dữ liệu
                    $update_query = "
                        UPDATE tour_schedule
                        SET Trangthai = 4
                        WHERE id = " . $row['idtourshe'] . "
                    ";
                    $conn->query($update_query); // Thực thi câu lệnh UPDATE
                    $row['Trangthai'] = 4; // Cập nhật trạng thái trong kết quả trả về
                }
    
                $users[] = $row; // Lưu thông tin vào mảng
            }
        }
    
        echo json_encode($users); // Trả về kết quả dưới dạng JSON
        exit;
    }
    
     elseif ($action == "lich") {
        $start_date = $_GET['start_date'] ?? date('Y-m-d');
        $start_date1 = date('Y-m-d', strtotime('monday this week', strtotime($start_date)));
        $end_date = date('Y-m-d', strtotime($start_date1 . ' + 6 days')); // Kết thúc tuần là Chủ nhật
        $user_id = $_SESSION['id'];

        $query = "
            SELECT 
                ts.Date,
                ts.Schedule,
                ts.Locations,
                ts.Trangthai,
                ts.Name AS tourname,
                e.Name AS EmployeeName,
                t.Itinerary
            FROM 
                tour_schedule ts
            LEFT JOIN 
                assignment_tour at ON ts.id = at.id_toursche
            LEFT JOIN 
                employees e ON at.employid = e.id
            LEFT JOIN 
                tour t ON ts.id_tour = t.id
            WHERE 
                ts.Date BETWEEN ? AND ? AND e.id = ?
            ORDER BY 
                ts.Date, ts.Schedule;
        ";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Lỗi chuẩn bị query: " . $conn->error);
        }

        $stmt->bind_param('ssi', $start_date1, $end_date, $user_id);
        if (!$stmt->execute()) {
            die("Lỗi thực thi query: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($data);
    } elseif ($action == "phanlichadmin") {

        $query = "SELECT schedule.*,schedule.id AS idschedule,employees.*,employees.id AS idem FROM schedule INNER JOIN employees ON schedule.employid=employees.id";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "plsua") {
        $id = $_GET['id'];
        $query = "SELECT schedule.*,schedule.id AS idschedule,employees.*,employees.id AS idem FROM schedule INNER JOIN employees ON schedule.employid=employees.id
        WHERE schedule.id='$id' AND (employees.Permissions='QL' OR employees.Permissions='CSKH')
        ";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemem") {

        $query = "SELECT employees.id,employees.Permissions,employees.Name FROM employees
                WHERE employees.Permissions='QL' OR employees.Permissions='CSKH'
                ";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;

    } elseif ($action == "lichcskh") {

        $start_date = $_GET['start_date'] ?? date('Y-m-d');
        $start_date1 = date('Y-m-d', strtotime('monday this week', strtotime($start_date)));
        $end_date = date('Y-m-d', strtotime($start_date . ' + 6 days'));
        $user_id = $_SESSION['id'];

        $query = "
        SELECT 
            schedule.shift_date, 
            GROUP_CONCAT(DISTINCT employees.id ORDER BY employees.id SEPARATOR ', ') AS employee_ids,
            GROUP_CONCAT(DISTINCT employees.Name ORDER BY employees.id SEPARATOR ', ') AS employee_names,
            schedule.shift_type
        FROM 
            schedule 
        LEFT JOIN 
            employees ON schedule.employee_id = employees.id
        WHERE 
            schedule.shift_date BETWEEN ? AND ? AND employees.id = ? AND schedule.status='V'
        GROUP BY 
            schedule.shift_date, schedule.shift_type
        ORDER BY 
            schedule.shift_date;
    ";
    

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Lỗi chuẩn bị query: " . $conn->error);
        }

        $stmt->bind_param('ssi', $start_date1, $end_date, $user_id);
        if (!$stmt->execute()) {
            die("Lỗi thực thi query: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($data);
    } elseif ($action == "xoalich") {

        $id = $_GET['id'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM schedule WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemtouryeucau") {

        $query = "SELECT * FROM request_tour INNER JOIN rooms ON request_tour.idks=rooms.id INNER JOIN drivers ON request_tour.idtx=drivers.driver_id";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    }  elseif ($action == "xemtouryeucau1") {
        $id = $_GET['id'];
        $query = "SELECT * FROM request_tour INNER JOIN rooms ON request_tour.idks=rooms.id INNER JOIN drivers ON request_tour.idtx=drivers.driver_id where id_request='$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    }  elseif ($action == "xoatu") {

        $id = $_GET['id'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM request_tour where id_request = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    }  elseif ($action == "duyet") {

        $id = $_GET['id'];
        $user_id = $_SESSION['id'];
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE request_tour SET Trangthai=1 where id_request = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            log_action($conn, $user_id, 'Update', 'Duyệt tour '.'ID:'.$id,'employees');
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } 
    elseif ($action == "xemtrangthai") {
      
        $query = "
    SELECT 
        booking_ordertour.*,
        booking_detail_tour.*,
        departure_time.*,
        booking_ordertour.created_at AS booking_time
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id  = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
   
";

        // Thực hiện truy vấn
        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            // Lấy từng dòng dữ liệu
            while ($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
        }

        if (empty($res)) {
            echo json_encode(["message" => "No tour found for the given ID"]);
        } else {
            echo json_encode($res); // Trả về dữ liệu dạng JSON
        }
        exit;
    } elseif ($action == "xemtrangthaichitiet") {
        
        $id = $_GET['id'];
        $query = "
    SELECT 
        booking_ordertour.*,
        booking_detail_tour.*,
        departure_time.*,
        participant.*
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
    LEFT JOIN
        participant ON booking_ordertour.Booking_id = participant.idbook
    WHERE 
       booking_ordertour.Booking_id = '$id' OR departure_time.id = '$id'
";


        // Thực hiện truy vấn
        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            // Lấy từng dòng dữ liệu
            while ($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
        }

        if (empty($res)) {
            echo json_encode(["message" => "No tour found for the given ID"]);
        } else {
            echo json_encode($res); // Trả về dữ liệu dạng JSON
        }
        exit;
    }elseif ($action == "timtour") {
    $code = $_GET['MAT'];
    $date = isset($_GET['date']) ? $_GET['date'] : '';

    // Dùng prepared statements để bảo mật
    $params = [];
    $types = '';
    $where = "(tour_schedule.id_tour = ? OR tour_schedule.Name LIKE ?)";
    $params[] = $code;
    $params[] = "%$code%";
    $types .= "ss";

    if (!empty($date)) {
        $where .= " AND tour_schedule.Date = ?";
        $params[] = $date;
        $types .= "s";
    }

    $query = "SELECT 
                tour_schedule.*, 
                tour_schedule.id AS idsh, 
                departure_time.*, 
                departure_time.id AS iddp
              FROM tour_schedule
              LEFT JOIN departure_time ON tour_schedule.Date = departure_time.ngaykhoihanh
              WHERE $where
              GROUP BY tour_schedule.id 
              ORDER BY tour_schedule.Date ASC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $tours = [];

    while ($row = $result->fetch_assoc()) {
        $tourId = $row['idsh'];
        // Lấy danh sách HDV theo lịch trình này
        $guideQuery = "SELECT e.id, e.Name 
                       FROM assignment_tour a 
                       INNER JOIN employees e ON a.employid = e.id 
                       WHERE a.id_toursche = ?";
        $guideStmt = $conn->prepare($guideQuery);
        $guideStmt->bind_param("i", $tourId);
        $guideStmt->execute();
        $guideResult = $guideStmt->get_result();

        $guides = [];
        while ($g = $guideResult->fetch_assoc()) {
            $guides[] = $g;
        }

        $row['guides'] = $guides;
        $tours[] = $row;
    }

    echo json_encode($tours);
    exit;
}

    
    elseif ($action == "xoalichtrinh") {
        $id = $_GET['id'];

        // Xóa lịch trình theo ID
        $query = "DELETE FROM tour_schedule WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo 'delete_success';
        } else {
            echo 'delete_failed';
        }
    }
    elseif ($action == "timkhMT") {
        // Lấy giá trị 'MANV' từ tham số GET
        $code = $_GET['KH'];
      
        // Kiểm tra nếu mã nhân viên không rỗng
        if (!empty($code)) {
            $query = "SELECT * FROM booking_ordertour INNER JOIN booking_detail_tour ON booking_ordertour.Booking_id=booking_detail_tour.Booking_id 
            WHERE (booking_ordertour.Booking_id = '$code' OR  booking_detail_tour.User_name LIKE '%$code%')
        ";
            $result = $conn->query($query);

            $users = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row; // Lưu từng bản ghi vào mảng
                }
            }

            // Trả về mảng nhân viên dưới dạng JSON
            echo json_encode($users);
        } else {
            // Trả về mảng rỗng nếu không có mã nhân viên
            echo json_encode([]);
        }
        exit;
    }elseif ($action == 'updatePermission') {
       
    
        $id = $_GET['id'];
        $permission = $_GET['permission'];
    
        $sql = "UPDATE employees SET Permissions = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $permission, $id);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }
    elseif ($action == "check_new_messages") {
        $user_id = $_SESSION['id'];
        $query = "SELECT COUNT(*) AS total FROM messages WHERE is_read = 0 AND receiver_id = '$user_id' AND sender_type = 'user'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        echo json_encode(['new_messages' => $row['total']]);
        exit;
    }elseif ($action == "mark_as_read") {
        $customer_id = $_GET['customer_id'] ?? 0;
        $user_id = $_SESSION['id'];
        $query = "UPDATE messages SET is_read = 1 WHERE receiver_id = ' $user_id' AND sender_id = '$customer_id' AND sender_type = 'user'";
        $conn->query($query);
        echo json_encode(['status' => 'success']);
        exit;
    }elseif ($action == "xemnhanvienph") {
        $query = "SELECT id, Name FROM employees WHERE Permissions = 'CSKH'";
            $result = $conn->query($query);

            $customers = [];
            while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
            }
            echo json_encode($customers);
        exit;
    }elseif ($action == "xemkhachhangph") {
            $query = "SELECT id, Name FROM user_credit";
            $result = $conn->query($query);

            $customers = [];
            while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
            }
            echo json_encode($customers);
    }elseif ($action == "xemdanhsachphancong") {
        $query = " SELECT e.Name as employee_name, c.Name as customer_name,ca.id as idcus
FROM customer_assignment ca
JOIN employees e ON ca.employee_id = e.id
JOIN user_credit c ON ca.customer_id = c.id";
        $result = $conn->query($query);

        $customers = [];
        while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
        }
        echo json_encode($customers);
}elseif ($action == "go") {

    $id = $_GET['id'];

    // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

    $insert_query = "DELETE FROM customer_assignment WHERE id = '$id'";


    if ($conn->query($insert_query) === TRUE) {
        echo 'gui';
    } else {
        echo 'kotc';
    }



} // API lấy danh sách mã phòng chat của nhân viên hiện tại
if ($action == "danhsach_phong_chat") {
    $user_id = $_SESSION['id']; // Giả sử nhân viên đã đăng nhập
   
    $stmt = $conn->prepare("SELECT c.room_id, u.Name as customer_name,u.id
                            FROM chat_rooms c
                            JOIN user_credit u ON c.user_id = u.id
                            WHERE c.employee_id = ? AND c.Action = 0");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

// API lấy tin nhắn theo mã phòng
elseif ($action == "xemtinnhan") {
    $room_id = $_GET['room_id'] ?? 0;

    $stmt = $conn->prepare("SELECT m.*, u.Name as customer_name
                            FROM messages m
                            JOIN user_credit u ON m.sender_id = u.id
                            WHERE m.room_id = ?
                            ORDER BY m.created_at ASC");
    $stmt->bind_param("s", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}elseif ($action == "xemtaixe") {

    $query = "SELECT * FROM drivers ";
    $result = $conn->query($query);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row; // Lưu từng bản ghi vào mảng
        }
    }

    echo json_encode($users); // Trả về JSON
    
} elseif ($action == "xemtaixe1") {
$id=$_GET['idtx'];
    $query = "SELECT * FROM drivers WHERE driver_id='$id'";
    $result = $conn->query($query);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row; // Lưu từng bản ghi vào mảng
        }
    }

    echo json_encode($users); // Trả về JSON
    
} elseif ($action == "xoataixe") {

    $id = $_GET['idt'];
    $user_id = $_SESSION['id'];
    // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

    $insert_query = "DELETE FROM drivers WHERE driver_id = '$id'";


    if ($conn->query($insert_query) === TRUE) {
       log_action( $conn,$user_id, 'Xóa tài xế ', 'Tài xế ID: '.$id.' đã bị xóa','employees');
        echo 'gui';
    } else {
        echo 'kotc';
    }



} elseif ($action == "timtaixe") {
    $id = $_GET['TX'];
    $query = "SELECT * FROM drivers
       WHERE driver_id='$id' OR name LIKE '%$id%'
     ";
    $result = $conn->query($query);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row; // Lưu từng bản ghi vào mảng
        }
    }

    echo json_encode($users); // Trả về JSON
    exit;
}elseif ($action == "thongkenv1") {
   
    $query = "SELECT 
    status, 
    COUNT(*) AS total
FROM schedule
WHERE shift_date = CURDATE()
GROUP BY status;
";
    $result = $conn->query($query);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $users[] = $row; // Lưu từng bản ghi vào mảng
        }
    }

    echo json_encode($users); // Trả về JSON
    exit;
}

// API gửi tin nhắn vào phòng chat



elseif ($action == "xong") {
    
    $id=$_GET['id'];
        $query = "UPDATE chat_rooms SET Action = 1 WHERE id='$id'";

    
        if ($conn->query($query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }
        
    } if ($action == 'approveReport') {
        $id = $_GET['id'];
        $admin_id =$_SESSION['Sr_no'];; // ID admin hiện tại (lấy từ session)
    
        $stmt = $conn->prepare("UPDATE reports SET status = 'approved', approved_by = ?, approved_at = NOW() WHERE id = ?");
        $stmt->execute([$admin_id, $id]);
    
        echo json_encode(['status' => 'success', 'message' => 'Báo cáo đã được duyệt!']);
    }
    
    if ($action == 'rejectReport') {
        $id = $_GET['id'];
    
        $stmt = $conn->prepare("UPDATE reports SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$id]);
    
        echo json_encode(['status' => 'success', 'message' => 'Báo cáo đã bị từ chối!']);
    }
    if ($action == "xemxethuenv") {
     
        $query = "SELECT * FROM rentals INNER JOIN drivers ON rentals.driver_id = drivers.driver_id";

      
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } 
    elseif ($action == "xacnhanxe") {

        $id = $_GET['id'];
        $trangthai = "1";
        $user_id = $_SESSION['id'];
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE rentals SET Trangthai ='$trangthai' WHERE rental_id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            log_action($conn, $user_id, 'Update', 'Xác nhận thuê xe '.'ID:'.$id,'employees');
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemtkkhoa") {
       
        $query = "SELECT * FROM user_credit where is_locked = 1";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    }
    elseif ($action == "mokhoa") {

        $id = $_GET['id'];
       
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE user_credit SET failed_attempts = 0,is_locked=0,unlock_token=null WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    }
    elseif ($action == "xemlog") {
        $query = "
            SELECT 
                activity_logs.*, 
                employees.Username, 
                user_credit.Name 
            FROM activity_logs
            LEFT JOIN employees ON activity_logs.user_id = employees.id AND activity_logs.user_type = 'employees'
            LEFT JOIN user_credit ON activity_logs.user_id = user_credit.id AND activity_logs.user_type = 'user'
            ORDER BY created_at DESC
        ";
    
        $result = $conn->query($query);
        $users = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
    
        echo json_encode($users);
        exit;
    }elseif ($action == "get_top_tour_revenue") {
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        $month = isset($_GET['month']) ? intval($_GET['month']) : 0; // 0 = tất cả các tháng
    
        $query = "
            SELECT 
                t.id AS tour_id,
                t.name AS tour_name,
                SUM(bd.total_pay) AS total_revenue
            FROM 
                booking_ordertour bo
            LEFT JOIN 
                booking_detail_tour bd ON bo.Booking_id = bd.Booking_id
            LEFT JOIN 
                tour t ON bo.Tour_id = t.id
            WHERE 
                bo.Payment_status = 2
                AND YEAR(bo.created_at) = $year
        ";
    
        if ($month > 0 && $month <= 12) {
            $query .= " AND MONTH(bo.created_at) = $month";
        }
    
        $query .= "
            GROUP BY 
                bo.Tour_id
            ORDER BY 
                total_revenue DESC
            LIMIT 5
        ";
    
        $result = $conn->query($query);
        $topTours = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $topTours[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($topTours);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
    }
    
        elseif ($action == "get_revenue_by_period") {
            $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
            $period = isset($_GET['period']) ? $_GET['period'] : 'month'; // month, quarter, year
        
            if ($period == 'month') {
                $groupBy = "MONTH(bo.created_at)";
            } elseif ($period == 'quarter') {
                $groupBy = "QUARTER(bo.created_at)";
            } elseif ($period == 'year') {
                $groupBy = "YEAR(bo.created_at)";
            } else {
                $groupBy = "MONTH(bo.created_at)";
            }
        
            // Nếu period là năm, thì bỏ điều kiện lọc theo năm
            $whereYear = ($period != 'year') ? "AND YEAR(bo.created_at) = $year" : "";
        
            $query = "
                SELECT 
                    $groupBy AS period,
                    SUM(bd.total_pay) AS total_revenue
                FROM 
                    booking_ordertour bo
                LEFT JOIN 
                    booking_detail_tour bd ON bo.Booking_id = bd.Booking_id
                WHERE 
                    bo.Payment_status = 2
                    $whereYear
                GROUP BY 
                    $groupBy
                ORDER BY 
                    period ASC
            ";
        
            $result = $conn->query($query);
            $revenues = [];
        
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $revenues[] = $row;
                }
                header('Content-Type: application/json');
                echo json_encode($revenues);
            } else {
                echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
            }
        }
        
    
    elseif ($action == "get_monthly_comparison") {
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    
        $query = "
            SELECT 
                MONTH(bo.created_at) AS month,
                SUM(bd.total_pay) AS total_revenue
            FROM 
                booking_ordertour bo
            LEFT JOIN 
                booking_detail_tour bd ON bo.Booking_id = bd.Booking_id
            WHERE 
                bo.Payment_status = 2
                AND YEAR(bo.created_at) = $year
            GROUP BY 
                MONTH(bo.created_at)
            ORDER BY 
                month ASC
        ";
    
        $result = $conn->query($query);
        $monthlyComparison = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $monthlyComparison[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($monthlyComparison);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
    }
    
    
    elseif ($action == "locdanhsach") {
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        $month = isset($_GET['month']) ? intval($_GET['month']) : null;
        $vung = isset($_GET['vung']) ? $_GET['vung'] : null; // Sửa lỗi gán biến
        $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
        $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;
        $refund = isset($_GET['huy']) ? $_GET['huy'] : null; // Sửa lỗi gán biến
        $thanh = isset($_GET['thanh']) ? $_GET['thanh'] : null; // Sửa lỗi gán biến
        // Truy vấn SQL
        $query = "
    SELECT 
       booking_ordertour.*,
       booking_detail_tour.*,
       departure_time.*,
       participant.*,
       tour.id AS tourid,
       tour.Child_price_percen
   FROM 
       booking_ordertour 
   LEFT JOIN 
       booking_detail_tour ON booking_ordertour.Booking_id = booking_detail_tour.Booking_id
   LEFT JOIN
       departure_time ON booking_ordertour.Departure_id = departure_time.id
   LEFT JOIN
       participant ON booking_ordertour.Booking_id = participant.idbook
   LEFT JOIN
       tour ON booking_ordertour.Tour_id = tour.id
   WHERE
        YEAR(booking_ordertour.created_at) = $year
   
       ";
       
    
        // Thêm điều kiện tháng nếu có
        if (!empty($month)) {
            $query .= " AND MONTH(booking_ordertour.created_at) = " . intval($month);
        }
        if (!empty($from_date) && !empty($to_date)) {
            $query .= " AND DATE(booking_ordertour.created_at) BETWEEN '$from_date' AND '$to_date'";
        }
    
        // Thêm điều kiện vùng miền nếu có
        if (!empty($vung)) {
            $query .= " AND tour.vung = '$vung'";
        }
        if (!empty($refund)) {
            $query .= " AND booking_ordertour.refund = '$refund'";
        }
        if (!empty($thanh)) {
            $query .= " AND booking_ordertour.Payment_status = '$thanh'";
        }
    
        // Nhóm theo tháng và năm
       
       
        // Thực thi truy vấn
        $result = $conn->query($query);
    
        $statistics = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $statistics[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($statistics);
        } else {
            echo json_encode(['error' => 'Lỗi truy vấn SQL: ' . $conn->error]);
        }
    }
    elseif ($action == "xemdichvuhdv1") {
        $user_id = $_SESSION['id'];
        $current_date = date('Y-m-d'); // Lấy ngày hiện tại theo định dạng 'YYYY-MM-DD'
    
        $query = "
            SELECT 
                ts.Date,
                ts.Schedule,
                ts.Locations,
                ts.Trangthai,
                ts.Name AS tourname,
                ts.id AS idtourshe,
                ts.id_tour,
                e.Name AS EmployeeName,
                t.Itinerary
            FROM 
                tour_schedule ts
            LEFT JOIN 
                assignment_tour at ON ts.id = at.id_toursche
            LEFT JOIN 
                employees e ON at.employid = e.id
            LEFT JOIN 
                tour t ON ts.id_tour = t.id
            WHERE e.id = '$user_id' AND ts.Trangthai = 4
            ORDER BY 
                ts.Date, ts.Schedule;
        ";
    
        $result = $conn->query($query);
    
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Lấy số ngày từ Schedule, ví dụ: "4 ngày 3 đêm" => lấy số 4
                preg_match('/(\d+)\s+ngày/', $row['Schedule'], $matches);
                $days_in_tour = isset($matches[1]) ? (int)$matches[1] : 0; // Lấy số ngày (4 ngày)
    
                // Lấy ngày bắt đầu của tour, loại bỏ phần giờ, phút, giây (chỉ lấy ngày)
                $start_date = date('Y-m-d', strtotime($row['Date']));
    
                // Tính ngày kết thúc của tour bằng cách cộng số ngày vào ngày bắt đầu
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $days_in_tour . ' days'));
    
                // So sánh nếu ngày hiện tại vượt qua ngày kết thúc, thì cập nhật trạng thái
                if ($current_date > $end_date) {
                    // Cập nhật trạng thái tour thành 4 (đã kết thúc) trong cơ sở dữ liệu
                    $update_query = "
                        UPDATE tour_schedule
                        SET Trangthai = 4
                        WHERE id = " . $row['idtourshe'] . "
                    ";
                    $conn->query($update_query); // Thực thi câu lệnh UPDATE
                    $row['Trangthai'] = 4; // Cập nhật trạng thái trong kết quả trả về
                }
    
                $users[] = $row; // Lưu thông tin vào mảng
            }
        }
    
        echo json_encode($users); // Trả về kết quả dưới dạng JSON
        exit;
    }
       

}




?>