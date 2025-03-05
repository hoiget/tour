<?php

session_start();

include_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);
    $action = $_POST['action'];
    $action1 = isset($_POST['action']) ? $_POST['action'] : (isset($input['action']) ? $input['action'] : null);
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
        $role = $_POST['role'];
        $date = date("Y-m-d");


        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($username) || empty($email) || empty($phone)) {
            echo 'missing_data';
            exit;
        }

        // Cập nhật thông tin người dùng
        $insert_query = "INSERT INTO employees (Employee_code, Name,Username, Password, Email, Phone_number, Address, Permissions, Created_at) 
        VALUES (?, ?, ?, MD5(?), ?, ?, ?, ? , ?)";

        // Sử dụng prepared statements để tránh SQL injection
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssssssss", $ma, $username, $username, $password, $email, $phone, $address, $role, $date);



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
        $role = $_POST['role'];
        $date = date("Y-m-d");             // Vai trò


        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($username) || empty($email) || empty($phone)) {
            echo 'missing_data';
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
                Permissions = ?,
                Created_at=?
                WHERE id = ?";

            $stmt = $conn->prepare($update_query);
            if ($stmt === false) {
                echo 'prepare_error: ' . $conn->error;
                exit;
            }
            $stmt->bind_param("ssssssssi", $ma, $username, $username, $email, $phone, $address, $role, $date, $id);
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
                Permissions = ?,
                Created_at=?
                WHERE id = ?";

            $stmt = $conn->prepare($update_query);
            if ($stmt === false) {
                echo 'prepare_error: ' . $conn->error;
                exit;
            }
            $stmt->bind_param("sssssssssi", $ma, $username, $username, $password, $email, $phone, $address, $role, $date, $id);
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
        $file = $_FILES['anh']['tmp_name'];
        $name = $_FILES['anh']['name'];
        $loai = $_FILES['anh']['type'];

        // Xử lý ảnh tải lên
        if ($loai != "image/jpg" && $loai != "image/jpeg" && $loai != "image/png") {
            echo 'invalid_image';
            exit;
        }



        if (move_uploaded_file($file, "../assets/img/gallery/" . $name)) {  // Thêm người dùng mới vào cơ sở dữ liệu
            $insert_query = "INSERT INTO news (Title,dereption,Image,Content,Published_at,employeesId) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ssssss", $tieude, $noidung, $name, $content, $date, $ngtao);


            if ($stmt->execute()) {
                echo 'insert_success';
            } else {
                echo 'error_points';
            }

        } else {
            echo 'upload_error';
        }
    } elseif ($action == "capnhattintuc") {
        $ma = $_POST['id'];
        $tieude = $_POST['Title']; // Tiêu đề
        $noidung = $_POST['dereption']; // Nội dung
        $content = $_POST['Content']; // Content
        $ngtao = $_POST['emid']; // Người tạo
        $date = date("Y-m-d");

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
                $stmt->bind_param("sssssii", $tieude, $noidung, $name, $content, $date, $ngtao, $ma);

                if ($stmt->execute()) {
                    echo 'update_success';
                } else {
                    echo 'error_points';
                }
            } else {
                echo 'upload_error';
            }
        } else {
            // Cập nhật tin tức mà không có ảnh
            $update_query = "UPDATE news SET Title = ?, dereption = ?, Content = ?, Published_at = ?, employeesId = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssssii", $tieude, $noidung, $content, $date, $ngtao, $ma);

            if ($stmt->execute()) {
                echo 'update_success';
            } else {
                echo 'error_points';
            }
        }
    } elseif ($action == "capnhatuser") {
        $ma = $_POST['id']; // ID người dùng
        $name = $_POST['name']; // Tên
        $address = $_POST['address']; // Địa chỉ
        $email = $_POST['email']; // Email
        $sdt = $_POST['sdt']; // Số điện thoại
        $datetime = $_POST['ns']; // Ngày sinh


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
                echo 'update_success';
            } else {
                echo 'error_points';
            }
        }
    } elseif ($action == "themtienich") {

        $tieude = $_POST['ten']; // Tên tài khoản
        $noidung = $_POST['dereption'];


        $insert_query = "INSERT INTO facilities (Name,Description) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ss", $tieude, $noidung);


        if ($stmt->execute()) {
            echo 'insert_success';
        } else {
            echo 'error_points';
        }


    } elseif ($action == "suatienich") {
        $ma = $_POST['id']; // ID người dùng
        $tieude = $_POST['ten']; // Tên tài khoản
        $noidung = $_POST['dereption'];


        $update_query = "UPDATE facilities SET Name = ?, Description = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $tieude, $noidung, $ma);


        if ($stmt->execute()) {
            echo 'update_success';
        } else {
            echo 'error_points';
        }


    } elseif ($action == "themdacdiem") {

        $tieude = $_POST['ten']; // Tên tài khoản



        $insert_query = "INSERT INTO features (Name) VALUES (?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("s", $tieude);


        if ($stmt->execute()) {
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
            
            // Duyệt mảng ngày khởi hành và thêm vào database
            foreach ($departure_dates as $date) {
                $stmt_date->bind_param("is", $id, $date);
                $stmt_date->execute();
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
        $vung = $_POST['vung']; // Phương tiện
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
                        Description, Status, Depart, DepartureLocation, Itinerary, employeesId, type, timetour, discount, vehicle,vung) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
                    $stmt_tour = $conn->prepare($insert_tour_query);
                    $stmt_tour->bind_param(
                        "ssissssssssississ",
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
                        $vung
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
                    $stmt_depart->bind_param("iis", $new_tour_id, $order, $depart);
                    $stmt_depart->execute();

                    $insert_schedule_query = "INSERT INTO tour_schedule (id_tour, Name,Date,Schedule,Locations) VALUES (?,?,?,?,?)";
                    $stmt_schedule = $conn->prepare($insert_schedule_query);

                    $stmt_schedule->bind_param("issss", $new_tour_id, $name, $depart, $timetour, $departure_location);
                    $stmt_schedule->execute();

                    if($departure_dates){
                        $update_date = "INSERT INTO departure_dates (tour_id, departure_date) VALUES (?, ?)";
                        $stmt_date = $conn->prepare($update_date);
                        
                        // Duyệt mảng ngày khởi hành và thêm vào database
                        foreach ($departure_dates as $date) {
                            $stmt_date->bind_param("is", $new_tour_id, $date);
                            $stmt_date->execute();
                        }
                    }
                    // Commit giao dịch nếu không có lỗi
                    $conn->commit();
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
                SET Name = ?,Diadiem = ?,Ngaynhan = ?,Ngaytra = ?, Area = ?, Price = ?, Adult = ?, Children = ?, Status = ?, 
                    Removed = ?, employeesId = ?
                WHERE id = ?";
            $stmt_room = $conn->prepare($update_room_query);
            $stmt_room->bind_param(
                "sssssissssii",
                $name,
                $diadiem,
                $ngaynhan,
                $ngaytra,
                $area,
                $price,
                $adult,
                $children,
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
                INSERT INTO rooms (Name,Diadiem,Ngaynhan,Ngaytra, Area, Price, Adult, Children, Status, Removed, employeesId)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_room = $conn->prepare($insert_room_query);
            $stmt_room->bind_param(
                "sssssissssi",
                $name,
                $diadiem,
                $ngaynhan,  
                $ngaytra,
                $area,
                $price,
                $adult,
                $children,
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
            echo 'insert_success';
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $conn->rollback();
            echo 'insert_error: ' . $e->getMessage();
        }
    } elseif ($action == "capnhathdv") {
        $ma = $_POST['id']; // ID lịch trình
        $hdv = $_POST['hdv1']; // ID hướng dẫn viên
        $date = new DateTime($_POST['date']); // Ngày mới chọn

        // 📌 Tìm lịch trình gần nhất TRƯỚC ngày chọn
        $check_schedule_query = "SELECT tour_schedule.Date, tour_schedule.Schedule 
                                 FROM assignment_tour 
                                 INNER JOIN tour_schedule ON tour_schedule.id = assignment_tour.id_toursche 
                                 WHERE assignment_tour.employid = ? AND tour_schedule.Date < ? 
                                 ORDER BY tour_schedule.Date DESC LIMIT 1";

        $stmt = $conn->prepare($check_schedule_query);
        $formatted_date = $date->format('Y-m-d'); // Chuyển ngày thành định dạng SQL
        $stmt->bind_param("is", $hdv, $formatted_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $last_schedule_date = new DateTime($row['Date']); // Ngày bắt đầu lịch trình trước đó

            // 🔍 Tính số ngày của lịch trình trước đó
            preg_match('/(\d+) ngày/', $row['Schedule'], $match);
            $last_schedule_days = isset($match[1]) ? (int) $match[1] : 1; // Mặc định 1 ngày nếu không tìm thấy

            // 📆 Tính ngày kết thúc của lịch trình trước đó
            $last_schedule_end_date = clone $last_schedule_date;
            $last_schedule_end_date->modify("+{$last_schedule_days} days");

            // ❌ Nếu ngày mới chọn nằm trong khoảng làm việc trước đó => Báo lỗi
            if ($date <= $last_schedule_end_date) {
                echo "schedule_conflict|Nhân viên đang có lịch hẹn từ ngày " . $last_schedule_date->format('d/m/Y') .
                    " đến ngày " . $last_schedule_end_date->format('d/m/Y');
                exit;
            }
        }

        // ✅ Kiểm tra trùng lịch
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
            echo 'duplicate_date'; // 🚨 Nhân viên đã có lịch vào ngày này
            exit;
        }

        // ✅ Kiểm tra nếu đã có lịch trình này trong `assignment_tour`
        $check_query = "SELECT idass FROM assignment_tour WHERE id_toursche = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("i", $ma);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // 🔄 Nếu đã tồn tại, cập nhật employid
            $update_query = "UPDATE assignment_tour SET employid = ? WHERE id_toursche = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ii", $hdv, $ma);
            if ($stmt->execute()) {
                echo 'update_success';
            } else {
                echo 'error_update';
            }
        } else {
            // ➕ Nếu chưa có, thêm mới
            $insert_query = "INSERT INTO assignment_tour (id_toursche, employid) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ii", $ma, $hdv);
            if ($stmt->execute()) {
                echo 'insert_success';
            } else {
                echo 'error_insert';
            }
        }
    } elseif ($action == "thaytglv") {
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


    } elseif ($action == "phanlich") {
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
    elseif ($action1 == "capnhathoadon") {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['participants']) || !is_array($data['participants'])) {
            echo "Dữ liệu không hợp lệ!";
            exit();
        }
    
        $stmt = $conn->prepare("UPDATE participant SET hoten = ?, Ngaysinh = ?, gioitinh = ? WHERE idpar = ?");
    
        foreach ($data['participants'] as $participant) {
            $hoten = $participant['hoten'];
            $ngaysinh = $participant['ngaysinh'];
            $gioitinh = $participant['gioitinh'];
            $id = $participant['id'];
    
            $stmt->bind_param("sssi", $hoten, $ngaysinh, $gioitinh, $id);
            $stmt->execute();
        }
    
        $stmt->close();
        echo "cập nhật thành công!";
    }elseif ($action == "dattourfulll") {
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
                Booking_id, Tour_name, Price, Total_pay, User_name, Phone_num, Address
            ) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_detail = $conn->prepare($insert_detail_query);
    
            if (!$stmt_detail) {
                echo 'query_error';
                exit;
            }
    
            $stmt_detail->bind_param(
                "issssss",
                $booking_id,
                $tour_name,
                $price,
                $total_pay,
                $user_name,
                $phone_num,
                $address
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
    } elseif ($action == "get_thongke") {
        $query = "SELECT 
            COUNT(t.id) AS total_tours, 
            SUM(CASE WHEN t.Status = 'Active' THEN 1 ELSE 0 END) AS total_active,
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
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y'); // Lấy năm từ yêu cầu hoặc mặc định là năm hiện tại
        $month = isset($_GET['month']) ? intval($_GET['month']) : null; // Lấy tháng từ yêu cầu (nếu có)

        // Truy vấn SQL
        $query = "
            SELECT
                COUNT(bo.Booking_id) AS total_orders,
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
                SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                SUM(CASE WHEN bo.refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
                SUM(bd.Total_pay) AS total_amount,
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN bd.Total_pay ELSE 0 END) AS new_orders_amount,
                SUM(CASE WHEN bo.Booking_status = 2 THEN bd.Total_pay ELSE 0 END) AS approved_orders_amount,
                SUM(CASE WHEN bo.refund = 1 THEN bd.Total_pay ELSE 0 END) AS cancelled_orders_amount,
                MONTH(bo.Datetime) AS order_month,
                YEAR(bo.Datetime) AS order_year
            FROM
                booking_ordertour bo
            INNER JOIN
                booking_detail_tour bd ON bo.Booking_id = bd.Booking_id
            WHERE
                YEAR(bo.Datetime) = $year
        ";

        // Thêm điều kiện tháng nếu có
        if ($month) {
            $query .= " AND MONTH(bo.Datetime) = $month";
        }

        // Thêm nhóm theo tháng và năm
        $query .= " GROUP BY MONTH(bo.Datetime), YEAR(bo.Datetime)";

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
    } elseif ($action == "get_booking_stats1") {
        $query = "
            SELECT
                COUNT(bo.Booking_id) AS total_orders,
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
                SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                SUM(CASE WHEN bo.refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
                SUM(bd.Total_pay) AS total_amount,
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN bd.Total_pay ELSE 0 END) AS new_orders_amount,
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
            $query = "SELECT * FROM employees WHERE Employee_code LIKE '%$code%'";
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
            $query = "SELECT tour.*,tour.id AS idtour,tour_images.*,departure_time.*,departure_time.id AS iddepart,employees.Name AS tennhanvien,employees.id FROM tour 
        LEFT JOIN tour_images ON tour.id = tour_images.id_tour
        LEFT JOIN departure_time ON tour.id = departure_time.id_tour
        LEFT JOIN employees ON tour.employeesId = employees.id
        WHERE tour.id='$code'";
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
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
                SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                SUM(CASE WHEN bo.Refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
                SUM(bd.total_pay) AS total_amount,
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN bd.total_pay ELSE 0 END) AS new_orders_amount,
                SUM(CASE WHEN bo.Booking_status = 2 THEN bd.total_pay ELSE 0 END) AS approved_orders_amount,
                SUM(CASE WHEN bo.Refund = 1 THEN bd.total_pay ELSE 0 END) AS cancelled_orders_amount,
                MONTH(bo.Datetime) AS order_month,
                YEAR(bo.Datetime) AS order_year
            FROM
                booking_orderks bo
            INNER JOIN
                booking_details_ks bd ON bo.Booking_id = bd.Booking_id
            WHERE
                YEAR(bo.Datetime) = $year
        ";

        // Thêm điều kiện tháng nếu có
        if ($month) {
            $query .= " AND MONTH(bo.Datetime) = $month";
        }

        // Thêm nhóm theo tháng và năm
        $query .= " GROUP BY MONTH(bo.Datetime), YEAR(bo.Datetime)";

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
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN 1 ELSE 0 END) AS new_orders_today,
                SUM(CASE WHEN bo.Booking_status = 2 THEN 1 ELSE 0 END) AS approved_orders,
                SUM(CASE WHEN bo.refund = 1 THEN 1 ELSE 0 END) AS cancelled_orders,
                SUM(bd.Total_pay) AS total_amount,
                SUM(CASE WHEN DATE(bo.Datetime) = CURDATE() THEN bd.Total_pay ELSE 0 END) AS new_orders_amount,
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

        $id = $_GET['idtt'];

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM news WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
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

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM facilities WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
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
            tour_images.*, 
            departure_time.*, 
            departure_time.id AS iddepart, 
            employees.Name AS tennhanvien, 
            employees.id, 
            GROUP_CONCAT(departure_dates.departure_date ORDER BY departure_dates.departure_date ASC) AS departure_dates
        FROM tour 
        LEFT JOIN tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN departure_time ON tour.id = departure_time.id_tour 
        LEFT JOIN employees ON tour.employeesId = employees.id 
        LEFT JOIN departure_dates ON tour.id = departure_dates.tour_id
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
                tour_images.*, 
                departure_time.*, 
                departure_time.id AS iddepart, 
                employees.Name AS tennhanvien, 
                employees.id, 
              
                GROUP_CONCAT(departure_dates.departure_date ORDER BY departure_dates.departure_date ASC) AS departure_dates
            FROM tour 
            LEFT JOIN tour_images ON tour.id = tour_images.id_tour 
            LEFT JOIN departure_time ON tour.id = departure_time.id_tour 
            LEFT JOIN employees ON tour.employeesId = employees.id 
            LEFT JOIN departure_dates ON tour.id = departure_dates.tour_id
            WHERE tour.id = '$id'  -- ✅ Đưa WHERE lên trước GROUP BY
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

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM tour WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
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

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "DELETE FROM rooms WHERE id = '$id'";


        if ($conn->query($insert_query) === TRUE) {
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

        $query = "SELECT tour_schedule.*,assignment_tour.*,employees.Name AS emna,employees.id AS idem FROM tour_schedule LEFT JOIN assignment_tour ON tour_schedule.id=assignment_tour.id_toursche 
        LEFT JOIN employees ON assignment_tour.employid=employees.id
        
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
    } elseif ($action == "xemlichtrinh1") {
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

        $query = "SELECT * FROM booking_orderks INNER JOIN booking_details_ks ON booking_orderks.Booking_id=booking_details_ks.Booking_id WHERE booking_orderks.Booking_status = '1' OR booking_orderks.refund = '1'";
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
        $trangthai = "2";
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE booking_ordertour SET Booking_status ='$trangthai' WHERE Booking_id = '$id'";


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



    } elseif ($action == "xemdichvuhdv") {

        $query = "SELECT * FROM booking_ordertour INNER JOIN booking_detail_tour ON booking_ordertour.Booking_id=booking_detail_tour.Booking_id WHERE booking_ordertour.Booking_status = '2'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "lich") {
        $start_date = $_GET['start_date'] ?? date('Y-m-d');
        $start_date1 = date('Y-m-d', strtotime('monday this week', strtotime($start_date)));
        $end_date = date('Y-m-d', strtotime($start_date1 . ' + 6 days')); // Kết thúc tuần là Chủ nhật
        $user_id = $_SESSION['id'];

        $query = "
            SELECT 
                ts.Date,
                ts.Schedule,
                ts.Locations,
                ts.Name AS tourname,
                e.Name AS EmployeeName
            FROM 
                tour_schedule ts
            LEFT JOIN 
                assignment_tour at ON ts.id = at.id_toursche
            LEFT JOIN 
                employees e ON at.employid = e.id
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
                        schedule.*, schedule.id AS idschedule, employees.id AS idem, employees.Name
                    FROM 
                        schedule 
                    LEFT JOIN 
                        employees ON schedule.employid = employees.id
                    WHERE 
                        schedule.work_date BETWEEN ? AND ? AND employees.id = ?
                    ORDER BY 
                        schedule.work_date;
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

        $query = "SELECT * FROM request_tour";
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
        $query = "SELECT * FROM request_tour where id_request='$id'";
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



    } elseif ($action == "xemtrangthai") {
      
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
    }


}
?>