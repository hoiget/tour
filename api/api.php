<?php

session_start();

include_once("connect.php");
require 'send_email.php';
require '../log/log_helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);

    $action = $_POST['action'];
    $action1 = isset($_POST['action']) ? $_POST['action'] : (isset($input['action']) ? $input['action'] : null);

    if ($action == "login") {
       

        $loginInput = $_POST['email']; // Email hoặc số điện thoạis
        $password = $_POST['password'];
        $login_type = $_POST['login_type'];

        $sql = "SELECT failed_attempts, is_locked FROM user_credit WHERE Email = ? OR sdt = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $loginInput, $loginInput);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
    
            // Kiểm tra nếu tài khoản bị khóa
            if ($user['is_locked']) {
              
                $failed_attempts = isset($user['failed_attempts']) ? $user['failed_attempts'] + 1 : 1;
                if ($failed_attempts >= 10) {
                // Khóa tài khoản, tạo token mở khóa
                $unlock_token = md5(uniqid());
                $conn->query("UPDATE user_credit SET is_locked = 1, unlock_token = '$unlock_token' WHERE (Email = '$loginInput' OR sdt = '$loginInput')");
            
                // Gửi email mở khóa (chỉ gửi nếu có email)
                ob_start();
                sendUnlockEmail($loginInput, $unlock_token);
                $emailError = ob_get_clean();

                // Trả về lỗi nếu có
                if (!empty($emailError)) {
                    echo "email_error: " . $emailError;
                } else {
                    echo "locked";
                }
                exit();
            } 
          
               
            }
    
            // Kiểm tra nếu số lần nhập sai quá giới hạn
            
        }
        // Kiểm tra trong bảng user_credit (Khách hàng)
        $sql = "SELECT * FROM user_credit WHERE (Email = ? OR sdt = ?) AND login_type = ? AND Password = MD5(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $loginInput, $loginInput,$login_type, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
    
            // Đăng nhập thành công, reset số lần nhập sai
            $conn->query("UPDATE user_credit SET failed_attempts = 0 WHERE id = " . $user['id']);
    
            $_SESSION['id'] = $user['id'];
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['sdt'] = $user['sdt'];
            $_SESSION['Address'] = $user['Address'];
            $_SESSION['profile'] = $user['profile'];
            $_SESSION['Datetime'] = $user['Datetime'];
            $_SESSION['login_type'] = $user['login_type'];
            log_action($conn, $user['id'], 'login', 'Đăng nhập vào hệ thống','user');
            $_SESSION['role'] = 'customer'; // Đánh dấu là khách hàng
    
            echo 'customer';
            exit();
        }else{
            $failed_attempts = isset($user['failed_attempts']) ? $user['failed_attempts'] + 1 : 1;
            if ($failed_attempts >= 10) {
                // Khóa tài khoản, tạo token mở khóa
                $unlock_token = md5(uniqid());
                $conn->query("UPDATE user_credit SET is_locked = 1, unlock_token = '$unlock_token' WHERE (Email = '$loginInput' OR sdt = '$loginInput')");
            
                // Gửi email mở khóa (chỉ gửi nếu có email)
                ob_start();
                sendUnlockEmail($loginInput, $unlock_token);
                $emailError = ob_get_clean();

                // Trả về lỗi nếu có
                if (!empty($emailError)) {
                    echo "email_error: " . $emailError;
                } else {
                    echo "locked";
                }
                exit();
            } else{
                $conn->query("UPDATE user_credit SET failed_attempts = $failed_attempts WHERE (Email = '$loginInput' OR sdt = '$loginInput')");
                
            }
           
          
        }
    
        

        
        
        
       
        $sql = "SELECT * FROM employees WHERE (Email = ? OR Phone_number = ?)  AND Password = MD5(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $loginInput, $loginInput, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $employee = $result->fetch_assoc();

            $_SESSION['id'] = $employee['id'];
            $_SESSION['Employee_code'] = $employee['Employee_code']; // Mã nhân viên
            $_SESSION['Name'] = $employee['Name']; // Tên người dùng
            $_SESSION['Username'] = $employee['Username']; // Tên đăng nhập
            $_SESSION['Email'] = $employee['Email']; // Email
            $_SESSION['Phone_number'] = $employee['Phone_number']; // Số điện thoại
            $_SESSION['Address'] = $employee['Address']; // Địa chỉ
            $_SESSION['Permissions'] = $employee['Permissions']; // Quyền hạn (QL, CSKH, HDV)
            $_SESSION['Created_at'] = $employee['Created_at']; // Ngày tạo tài khoản
            log_action($conn, $employee['id'], 'login', 'Đăng nhập vào hệ thống','employees');
            echo 'staff'; // Điều hướng đến indexa.php
            exit();
        }

        // Kiểm tra trong bảng admin (Quản trị viên)
        $sql = "SELECT * FROM admin WHERE Admin_name = ? AND Admin_password = MD5(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $loginInput, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();

            // Sửa lỗi: Dùng biến đúng ($admin thay vì $user)
            $_SESSION['Sr_no'] = $admin['Sr_no'];
            $_SESSION['Admin_name'] = $admin['Admin_name']; // Lưu tên admin

            echo 'admin'; // Điều hướng đến indexa.php
            exit();
        }

        // Nếu không tìm thấy tài khoản
        echo 'error';
        exit();
    }
    // Mở khóa tài khoản

    elseif ($action == "register") {
        $username   = $_POST['name'];
        $email      = $_POST['email'];
        $phone      = $_POST['sdt'];
        $address    = $_POST['dc'];
        $birthdate  = $_POST['ns'];
        $password   = $_POST['password'];
        $repassword = $_POST['Repassword'];
    
        $Diem       = 100; // Điểm khởi tạo
        $hang       = 'New';
    
        // Xử lý file ảnh nếu có
        $file = '';
        $name = '';
        $loai = '';
        $has_image = false;
    
        if (isset($_FILES['anh']) && $_FILES['anh']['error'] === 0) {
            $file = $_FILES['anh']['tmp_name'];
            $name = $_FILES['anh']['name'];
            $loai = $_FILES['anh']['type'];
    
            // Kiểm tra định dạng ảnh
            $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
            if (!in_array($loai, $allowed_types)) {
                echo 'invalid_image';
                exit;
            }
    
            $has_image = true;
        }
    
        // Kiểm tra mật khẩu
        if ($password !== $repassword) {
            echo 'password_mismatch';
            exit;
        }
    
        // Kiểm tra người dùng đã tồn tại
        $check_query = "SELECT * FROM user_credit WHERE Email = ? OR sdt = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            echo 'user_exists';
            exit;
        }
    
        // Nếu có ảnh, upload ảnh
        if ($has_image) {
            $upload_path = "../assets/img/user/" . basename($name);
            if (!move_uploaded_file($file, $upload_path)) {
                echo 'upload_error';
                exit;
            }
        }
    
        // Thêm người dùng vào DB
        if ($has_image) {
            $insert_query = "INSERT INTO user_credit (Name, Address, Email, sdt, profile, Password, Datetime) 
                             VALUES (?, ?, ?, ?, ?, MD5(?), ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sssssss", $username, $address, $email, $phone, $name, $password, $birthdate);
        } else {
            $insert_query = "INSERT INTO user_credit (Name, Address, Email, sdt, Password, Datetime) 
                             VALUES (?, ?, ?, ?, MD5(?), ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ssssss", $username, $address, $email, $phone, $password, $birthdate);
        }
        $stmt->execute();
        $customer_id = $conn->insert_id;
    
        // Gán CSKH ngẫu nhiên
        $cskh_query = "SELECT id FROM employees WHERE Permissions = 'CSKH' ORDER BY RAND() LIMIT 1";
        $result = $conn->query($cskh_query);
        $row = $result->fetch_assoc();
        $employee_id = $row['id'];
    
        $assign_query = "INSERT INTO customer_assignment (employee_id, customer_id) VALUES (?, ?)";
        $stmt = $conn->prepare($assign_query);
        $stmt->bind_param("ii", $employee_id, $customer_id);
        $stmt->execute();
    
        // Thêm vào bảng tích điểm
        $insert_query1 = "INSERT INTO tichdiem (idkh, hangTV, Diem) VALUES (?, ?, ?)";
        $stmt1 = $conn->prepare($insert_query1);
        $stmt1->bind_param("isi", $customer_id, $hang, $Diem);
        $stmt1->execute();
    
        echo 'registration_success';
    }
    
    
    elseif ($action == "updatettcn") {
        $username = $_POST['name']; // Tên tài khoản
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['sdt'];  // Lấy số điện thoại từ session
        $address = $_POST['dc'];    // Địa chỉ
        $birthdate = $_POST['ns'];  // Ngày sinh
        $phone1 = $_POST['phone']; 
        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($username) || empty($email) || empty($phone1)) {
            echo 'missing_data';
            exit;
        }

        // Cập nhật thông tin người dùng
        $update_query = "UPDATE user_credit SET Name = ?, Address = ?, Datetime = ?, sdt= ? WHERE Email = ? OR sdt = ?";
        $stmt = $conn->prepare($update_query);

        // Kiểm tra nếu không chuẩn bị được câu truy vấn
        if (!$stmt) {
            echo 'query_error';
            exit;
        }

        // Bind các tham số vào câu truy vấn
        $stmt->bind_param("ssssss", $username, $address, $birthdate,$phone1, $email, $phone);

        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            echo 'update_success'; // Thành công
        } else {
            echo 'update_error'; // Lỗi
        }
    } elseif ($action == "updateanh") {
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['sdt'];  // Lấy số điện thoại từ session
        $file = $_FILES['anh']['tmp_name'];
        $name = $_FILES['anh']['name'];
        $loai = $_FILES['anh']['type'];

        // Xử lý ảnh tải lên
        if ($loai != "image/jpg" && $loai != "image/jpeg" && $loai != "image/png") {
            echo 'invalid_image';
            exit;
        }
        // Kiểm tra file tải lên

        // Di chuyển file đến thư mục lưu trữ
        if (move_uploaded_file($file, "../assets/img/user/" . $name)) {
            // Cập nhật thông tin ảnh trong cơ sở dữ liệu
            $update_query = "UPDATE user_credit SET profile = ? WHERE Email = ? OR sdt = ?";
            $stmt = $conn->prepare($update_query);

            if (!$stmt) {
                echo 'query_error';
                exit;
            }

            // Bind các tham số
            $stmt->bind_param("sss", $name, $email, $phone);

            // Thực thi câu truy vấn
            if ($stmt->execute()) {
                echo 'update_success';
            } else {
                echo 'update_error';
            }
        } else {
            echo 'upload_error';
        }
    }elseif ($action == "dattourfull") {
        // Lấy dữ liệu từ POST
        $user_id = $_SESSION['id'];
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
        $phanloai = $_POST['phanloai']; 
    
        $diem = $_POST['diem'] ?? 0;
        $diemfull = $_POST['diemfull'] ?? 0;
        $diemfinal = max(0, $diemfull - $diem); // Đảm bảo điểm không âm
        $tenks=$_POST['ks'];
        $tienks=$_POST['tienks'];
        $method = $_POST['method'] ?? '';
    
        // Kiểm tra dữ liệu đầu vào
        if (empty($user_id) || empty($tour_id) || empty($tour_name) || empty($price)) {
            echo 'missing_data';
            exit;
        }
        if(empty($_POST['adults'])){
            echo 'missing_data2';
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
        $insert_order_query = "INSERT INTO booking_ordertour 
            (User_id, Tour_id, Departure_id, Arrival, Booking_status, Payment_status, refund, Datetime, participants) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
            $booking_id = $conn->insert_id;
    
            // 2. Thêm vào bảng booking_detail_tour
            $insert_detail_query = "INSERT INTO booking_detail_tour 
                (Booking_id, Tour_name, Price, Total_pay, User_name, Phone_num, Address,tenks,tienks) 
                VALUES (?, ?, ?, ?, ?, ?, ?,?,?)";
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
                $update_departure_query = "UPDATE departure_time 
                    SET Orders = Orders + ? WHERE id_tour = ? AND ngaykhoihanh = ?";
                $stmt_departure = $conn->prepare($update_departure_query);
    
                if (!$stmt_departure) {
                    echo 'query_error';
                    exit;
                }
    
                $stmt_departure->bind_param("iis", $participants, $tour_id, $datetime);
    
                if ($stmt_departure->execute()) {
                    // 4. Thêm danh sách hành khách
                    if (!empty($hoten) && !empty($ngaysinh) && !empty($gioitinhs) && !empty($phanloai)) {
                        $insert_participant_query = "INSERT INTO participant 
                            (idbook, hoten, ngaysinh, gioitinh, phanloai) 
                            VALUES (?, ?, ?, ?, ?)";
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
                            $stmt_participant->execute();
                        }
    
                        $stmt_participant->close();
    
                        // 5. Lưu phương thức thanh toán
                        if (!empty($method)) {
                            $stmt_method = $conn->prepare("INSERT INTO payments (user_id, idbook, method) VALUES (?, ?, ?)");
                            if ($stmt_method) {
                                $stmt_method->bind_param("iis", $user_id, $booking_id, $method);
                                if (!$stmt_method->execute()) {
                                    echo 'payment_insert_error';
                                }
                                $stmt_method->close();
                            } else {
                                echo 'query_payment_error';
                            }
                        } else {
                            echo 'Vui lòng chọn phương thức thanh toán.';
                            exit;
                        }
    
                        // 6. Cập nhật điểm tích lũy nếu có
                        if ($diem > 0 && $diemfull > 0) {
                            $stmt_diem = $conn->prepare("UPDATE tichdiem SET diem = ? WHERE idkh = ?");
                            if ($stmt_diem) {
                                $stmt_diem->bind_param("ii", $diemfinal, $user_id);
                                if (!$stmt_diem->execute()) {
                                    echo 'update_diem_error';
                                }
                                $stmt_diem->close();
                            } else {
                                echo 'query_diem_error';
                            }
                        }
    
                        echo 'insert_success';
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
    
    elseif ($action == "datksfull") {
        function generateRandomThreeDigits()
        {
            return rand(100, 999); // Tạo số ngẫu nhiên từ 100 đến 999
        }
        // Lấy dữ liệu từ POST
        $user_id = $_SESSION['id'];
        $ks_id = $_POST['ks_id'] ?? null;
        $ns = $_POST['ns'] ?? null;
        $ns1 = $_POST['ns1'] ?? null;
        $booking_status = '1';
        $payment_status = '1';
        $refund = '';
        $datetime = date("Y-m-d");

        $room_no = generateRandomThreeDigits();
        $ks_name = $_POST['ks_name'] ?? null;
        $price = $_POST['price1'] ?? null;
        $total_pay = $_POST['total-price'] ?? null;
        $user_name = $_POST['fullname'] ?? null;
        $phone_num = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;

        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($user_id) || empty($ks_id) || empty($ks_name) || empty($price) || empty($ns) || empty($ns1)) {
            echo 'missing_data';
            exit;
        }

        // Bắt đầu xử lý
        try {
            // 1. Thêm vào bảng `booking_orderks`
            $insert_order_query = "INSERT INTO booking_orderks (
                User_id, Room_id, Check_in, Check_out, Refund, Booking_status, Payment_status, Datetime
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_order = $conn->prepare($insert_order_query);

            if (!$stmt_order) {
                echo 'query_error: ' . $conn->error;
                exit;
            }

            $stmt_order->bind_param(
                "iissssss",
                $user_id,
                $ks_id,
                $ns,
                $ns1,
                $refund,
                $booking_status,
                $payment_status,
                $datetime
            );

            if ($stmt_order->execute()) {
                // Lấy Booking_id vừa tạo
                $booking_id = $conn->insert_id;

                // 2. Thêm vào bảng `booking_detail_ks`
                $insert_detail_query = "INSERT INTO booking_details_ks (
                    Booking_id, room_name, price, total_pay,room_no, user_name, phonenum, address
                ) VALUES (?, ?, ?, ?, ?, ?,?, ?)";
                $stmt_detail = $conn->prepare($insert_detail_query);

                if (!$stmt_detail) {
                    echo 'query_error: ' . $conn->error;
                    exit;
                }

                $stmt_detail->bind_param(
                    "isssssss",
                    $booking_id,
                    $ks_name,
                    $price,
                    $total_pay,
                    $room_no,
                    $user_name,
                    $phone_num,
                    $address
                );

                if ($stmt_detail->execute()) {
                    echo 'insert_success';
                } else {
                    echo 'insert_error: ' . $stmt_detail->error;
                }

                $stmt_detail->close();
            } else {
                echo 'insert_order_error: ' . $stmt_order->error;
            }

            $stmt_order->close();
        } catch (Exception $e) {
            echo 'exception_error: ' . $e->getMessage();
        }
    } elseif ($action == "guiykien") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            echo 'missing_data';
            exit;
        }
        // Chèn dữ liệu vào bảng feedback
        $sql = "INSERT INTO feedback (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo "Phản hồi của bạn đã được gửi thành công!";
        } else {
            echo "Có lỗi xảy ra:" . $conn->error;
        }
        $stmt->close();
    } 
    
     elseif ($action === 'danhgiatour') {
        // Nhận dữ liệu từ POST
        $tourId = isset($_POST['tour']) ? (int) $_POST['tour'] : 0;
        $rating = isset($_POST['star']) ? (int) $_POST['star'] : 0;
        $review = isset($_POST['review']) ? trim($_POST['review']) : '';
        $bookingId = isset($_POST['booking']) ? (int) $_POST['booking'] : 0;
        $seen = isset($_POST['username']) ? trim($_POST['username']) : '';
        ; // Mặc định chưa được xem
        $datetime = date('Y-m-d H:i:s'); // Thời gian hiện tại

        // Kiểm tra dữ liệu hợp lệ
        if (empty($tourId) || empty($rating) || empty($review)) {
            echo json_encode(['status' => 'error', 'message' => 'missing_data']);
            exit;
        }

        // Chèn dữ liệu vào bảng rating_reviewtour
        $sql = "INSERT INTO rating_reviewtour (Booking_id, Tour_id, Rating, Review, Username, Datetime) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisss", $bookingId, $tourId, $rating, $review, $seen, $datetime);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Đánh giá đã được gửi thành công!',
                'comment' => [
                    'booking_id' => $bookingId,
                    'rating' => $rating,
                    'review' => $review,
                    'username' => $seen,
                    'datetime' => $datetime,
                ],
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi lưu đánh giá: ' . $conn->error]);
        }
        $stmt->close();
    } elseif ($action === 'danhgiaks') {
        // Nhận dữ liệu từ POST
        $roomId = isset($_POST['room']) ? (int) $_POST['room'] : 0;
        $rating = isset($_POST['star']) ? (int) $_POST['star'] : 0;
        $review = isset($_POST['review']) ? trim($_POST['review']) : '';
        $bookingId = isset($_POST['booking']) ? (int) $_POST['booking'] : 0;
        $seen = isset($_POST['username']) ? trim($_POST['username']) : '';
        ; // Mặc định chưa được xem
        $datetime = date('Y-m-d H:i:s'); // Thời gian hiện tại

        // Kiểm tra dữ liệu hợp lệ
        if (empty($roomId) || empty($rating) || empty($review)) {
            echo json_encode(['status' => 'error', 'message' => 'missing_data']);
            exit;
        }

        // Chèn dữ liệu vào bảng rating_reviewtour
        $sql = "INSERT INTO rating_reviews_ks (Booking_id, Room_id, Rating, Review, Username, Datetime) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisss", $bookingId, $roomId, $rating, $review, $seen, $datetime);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Đánh giá đã được gửi thành công!',
                'comment' => [
                    'booking_id' => $bookingId,
                    'rating' => $rating,
                    'review' => $review,
                    'username' => $seen,
                    'datetime' => $datetime,
                ],
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi lưu đánh giá: ' . $conn->error]);
        }
        $stmt->close();
    }

    elseif ($action == "guitouryeucau") {
        $user_id = $_POST['user_id'];
        $customer_name = $_POST['customer_name'];
        $tour_name = $_POST['tour_name'];
        $departure_date = $_POST['departure_date'];
        $tour_price = $_POST['tour_price'];
        $itinerary = $_POST['itinerary'];
        $tour_duration = $_POST['tour_duration'];
       
        $phuongtien = $_POST['phuongtien'];
        $ks = $_POST['khachsan'];
        $taixe = $_POST['taixe'];

       if(empty($tour_name) || empty($departure_date) || empty($tour_price) || empty($itinerary) || empty($tour_duration)){
        echo "empty";
        exit;
       }
        // Chèn dữ liệu vào bảng feedback
        $sql = "INSERT INTO request_tour(user_id, customer_name, tour_name, departure_date, tour_price, itinerary, tour_duration,phuongtien,idks,idtx)
        VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?)";

       
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssisssii", $user_id, $customer_name, $tour_name, $departure_date, $tour_price, $itinerary, $tour_duration, $phuongtien,$ks,$taixe);

        if ($stmt->execute()) {
            echo "Phản hồi của bạn đã được gửi thành công!";
        } else {
            echo "Có lỗi xảy ra:" . $conn->error;
        }
        $stmt->close();
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
    }elseif($action == 'rent_car'){
        $customer_name = $_POST['customer_name'] ?? '';
        $customer_phone = $_POST['customer_phone'] ?? '';
        $customer_email = $_POST['customer_email'] ?? '';
        $vehicle_type = $_POST['vehicle_type'] ?? '';
        $driver_id = $_POST['driver_id'] ?? '';
        $pickup_time = $_POST['pickup_time'] ?? '';
        $pickup_location = $_POST['pickup_location'] ?? '';
        $dropoff_location = $_POST['dropoff_location'] ?? '';
        $notes = $_POST['notes'] ?? '';
        $user_id = $_SESSION['id']; 
        $gia=$_POST['total-price'] ?? '';
        if (empty($customer_name) || empty($customer_phone) || empty($pickup_time) || empty($pickup_location) || empty($dropoff_location)) {
            echo json_encode(["error" => "Vui lòng nhập đầy đủ thông tin!"]);
            exit;
        }
    if(empty($driver_id)){
        $driver_id = null;
        $stmt = $conn->prepare("INSERT INTO rentals (customer_name, customer_phone, customer_email, vehicle_type, driver_id, pickup_time, pickup_location, dropoff_location, notes,gia, created_at,user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?, NOW(),?)");
        $stmt->bind_param("ssssisssssi", $customer_name, $customer_phone, $customer_email, $vehicle_type, $driver_id, $pickup_time, $pickup_location, $dropoff_location, $notes,$gia,$user_id);
    
        if ($stmt->execute()) {
            echo json_encode(["success" => "Đặt xe thành công!"]);
        } else {
            echo json_encode(["error" => "Lỗi khi đặt xe: " . $conn->error]);
        }
        $stmt->close();
    }else{
        $stmt = $conn->prepare("INSERT INTO rentals (customer_name, customer_phone, customer_email, vehicle_type, driver_id, pickup_time, pickup_location, dropoff_location, notes,gia, created_at,user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?, NOW(),?)");
        $stmt->bind_param("ssssisssssi", $customer_name, $customer_phone, $customer_email, $vehicle_type, $driver_id, $pickup_time, $pickup_location, $dropoff_location, $notes,$gia,$user_id);
    
        if ($stmt->execute()) {
            echo json_encode(["success" => "Đặt xe thành công!"]);
        } else {
            echo json_encode(["error" => "Lỗi khi đặt xe: " . $conn->error]);
        }
        $stmt->close();
    }
        
    }
    
elseif($action == 'upload_payment'){
    if (isset($_FILES['payment'])) {
        $file = $_FILES['payment'];
        $fileName = time() . '_' . basename($file['name']);
        $uploadDir = '../uploads/payment/';
        $uploadPath = $uploadDir . $fileName;

        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Upload thành công',
                'image_url' => $uploadPath
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không thể lưu ảnh'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Không có file nào được gửi lên'
        ]);
    }
}
    
    
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = $_GET['action'];
    if ($action == "get_user_info") {
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['sdt'];
        $logintype= $_SESSION['login_type']; // Lấy loại đăng nhập từ session
        $query = "SELECT Email,Name,Address,sdt,Datetime FROM user_credit where (Email='$email' OR sdt='$phone') AND login_type='$logintype'";
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
    if ($action == "get_anh") {
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['sdt'];
        $logintype= $_SESSION['login_type']; 
        $query = "SELECT profile,login_type FROM user_credit where (Email='$email' OR sdt='$phone') AND login_type='$logintype'";
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
    if ($action == "tintuc") {

        $query = "SELECT * FROM news";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "tintucchitiet") {
        $id = $_GET['id'];
        $query = "SELECT * FROM news where id='$id'";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "xemtour") {
        $query = "SELECT 
                    tour.id AS tourid, 
                    tour.Name, 
                    tour.Price, 
                    tour.discount, 
                    tour.vehicle, 
                    tour.timetour, 
                    tour_images.Image, 
                    GROUP_CONCAT(DISTINCT departure_time.ngaykhoihanh ORDER BY departure_time.ngaykhoihanh ASC SEPARATOR ', ') AS ngaykhoihanh
                FROM tour 
                INNER JOIN tour_images ON tour.id = tour_images.id_tour 
                LEFT JOIN departure_time ON tour.id = departure_time.id_tour  
                WHERE Orders < Max_participant AND  departure_time.ngaykhoihanh >= NOW()
                GROUP BY tour.id
                ORDER BY MIN(departure_time.ngaykhoihanh) ASC";  
    
        $result = $conn->query($query);
        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
        }
    
        echo json_encode($res);
        exit;
    }
    elseif ($action == "xemtourtheomien") {

        $mien = $_GET['mien'];
        $query = "SELECT 
                    tour.id AS tourid, 
                    tour.Name, 
                    tour.Price, 
                    tour.discount, 
                    tour.vehicle, 
                    tour.timetour, 
                    tour_images.Image, 
                    GROUP_CONCAT(DISTINCT departure_time.ngaykhoihanh ORDER BY departure_time.ngaykhoihanh ASC SEPARATOR ', ') AS ngaykhoihanh
                FROM tour 
                INNER JOIN tour_images ON tour.id = tour_images.id_tour 
                LEFT JOIN departure_time ON tour.id = departure_time.id_tour  
                 WHERE Orders < Max_participant AND vung = '$mien'
                GROUP BY tour.id
                ORDER BY MIN(departure_time.ngaykhoihanh) ASC";

       

        $result = $conn->query($query);

        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    }  
    elseif ($action == "xemlayout") {
        $query = "SELECT departure_time.*,tour_images.*,tour.*,tour.id AS tourid FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour LEFT JOIN departure_time ON tour.id = departure_time.id_tour  WHERE Orders < Max_participant  GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC LIMIT 6";

       

        $result = $conn->query($query);

        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    } elseif ($action == "xemtourchitiet") {
        $id = $_GET['idtour'];
        $query = "
        SELECT 
            tour.*,
            tour.id AS idtour, 
            tour_images.*,
            departure_time.*,
            GROUP_CONCAT(DISTINCT departure_time.ngaykhoihanh ORDER BY departure_time.ngaykhoihanh ASC SEPARATOR ', ') AS ngaykhoihanh,
            GROUP_CONCAT(DISTINCT CONCAT(departure_time.ngaykhoihanh, ':', departure_time.Orders) ORDER BY departure_time.ngaykhoihanh ASC SEPARATOR ', ') AS orders_info
        FROM 
            tour 
        LEFT JOIN 
            tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN 
            departure_time ON tour.id = departure_time.id_tour
        WHERE 
            tour.id = '$id'
        GROUP BY 
            tour.id
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
    } elseif ($action == "timkiemtheotype") {
        $type = $_GET['type'];
        // Kiểm tra nếu giá trị type hợp lệ
        if (!in_array($type, ['Gia đình', 'Theo đoàn', 'Theo nhóm nhỏ'])) {
            echo json_encode(["error" => "Invalid type"]);
            exit;
        }
        $query = "SELECT 
                    tour.id AS tourid, 
                    tour.Name, 
                    tour.Price, 
                    tour.discount, 
                    tour.vehicle, 
                    tour.timetour, 
                    tour_images.Image, 
                    GROUP_CONCAT(DISTINCT departure_time.ngaykhoihanh ORDER BY departure_time.ngaykhoihanh ASC SEPARATOR ', ') AS ngaykhoihanh
                FROM tour 
                INNER JOIN tour_images ON tour.id = tour_images.id_tour 
                LEFT JOIN departure_time ON tour.id = departure_time.id_tour  
               WHERE Orders < Max_participant AND tour.type = '$type' AND  departure_time.ngaykhoihanh >= NOW()
                GROUP BY tour.id
                ORDER BY MIN(departure_time.ngaykhoihanh) ASC";

       
        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    } elseif ($action == "timkiemtheothongtin") {
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $date = isset($_GET['date']) ? $_GET['date'] : '';
        $budget = isset($_GET['budget']) ? $_GET['budget'] : '';
        $month = isset($_GET['month']) ? $_GET['month'] : '';
        // Tạo câu truy vấn động
        $query = "SELECT 
                    tour.id AS tourid, 
                    tour.Name, 
                    tour.Price, 
                    tour.discount, 
                    tour.vehicle, 
                    tour.timetour, 
                    tour_images.Image, 
                    GROUP_CONCAT(DISTINCT departure_time.ngaykhoihanh ORDER BY departure_time.ngaykhoihanh ASC SEPARATOR ', ') AS ngaykhoihanh
                FROM tour 
                INNER JOIN tour_images ON tour.id = tour_images.id_tour 
                LEFT JOIN departure_time ON tour.id = departure_time.id_tour  
                
                WHERE Orders < Max_participant AND  departure_time.ngaykhoihanh >= NOW() AND 1=1 
        ";
        // Thêm điều kiện tìm kiếm
        if (!empty($name)) {
            $query .= " AND tour.Name LIKE '%$name%' ";
        }
        if (!empty($date)) {
            $query .= " AND departure_time.ngaykhoihanh = '$date' ";
        }
        if (!empty($month)) {
            $query .= " AND MONTH(departure_time.ngaykhoihanh) = '$month'";
        }
        
        if (!empty($budget)) {
            if ($budget == 'low') {
                $query .= " AND tour.price < 5000000 ";
            } elseif ($budget == 'medium') {
                $query .= " AND tour.price BETWEEN 5000000 AND 10000000 ";
            } elseif ($budget == 'high') {
                $query .= " AND tour.price > 10000000 ";
            }
        }
        $query .= "GROUP BY tour.id ORDER BY MIN(departure_time.ngaykhoihanh) ASC";
        $result = $conn->query($query);
        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    }  elseif ($action == "xemlayout1") {
        $query = " SELECT * FROM rooms r JOIN rooms_features rf ON r.id = rf.Room_id JOIN rooms_facilities rfa ON r.id = rfa.Room_id JOIN rooms_images ri ON r.id = ri.Room_id LIMIT 6";

        $result = $conn->query($query);

        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    } elseif ($action == "xemkschitiet") {
        $id = $_GET['idks'];
        $query = "SELECT 
            r.*, r.Name as room_name,r.id AS idroom,
            f.*, 
            f.Name AS feature_name, 
            fa.*,
            fa.Name AS facility_name,
            rfa.*, ri.*, rf.*
          FROM rooms r
          JOIN rooms_features rf ON r.id = rf.Room_id
          JOIN rooms_facilities rfa ON r.id = rfa.Room_id
          JOIN rooms_images ri ON r.id = ri.Room_id
          JOIN features f ON rf.Features_id = f.id
          JOIN facilities fa ON rfa.Facilities_id = fa.id
          WHERE r.id='$id'";

        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['features'] = $row['feature_name']; // Thêm tên feature vào response
                $row['facilities'] = $row['facility_name']; // Thêm tên facility vào response
                $row['rooms'] = $row['room_name']; // Thêm tên phòng vào response
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
            echo json_encode($res); // Trả về JSON
        } else {
            echo json_encode(['error' => 'Không tìm thấy dữ liệu.']);
        }
        exit;
    }elseif ($action == "timkiemtheothongtinks") {
        // Lấy dữ liệu từ form hoặc URL
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $area = isset($_GET['area']) ? $_GET['area'] : '';
        $price = isset($_GET['price']) ? $_GET['price'] : '';
        $adult = isset($_GET['adult']) ? $_GET['adult'] : '';
        $children = isset($_GET['children']) ? $_GET['children'] : '';
        $checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
        $checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
    
        // Kiểm tra ngày nhận phải trước ngày trả
       
        // Xây dựng câu truy vấn SQL
        $query = "
            SELECT rooms.*, rooms_images.Image, rooms_images.Thumb
            FROM rooms
            INNER JOIN rooms_images ON rooms.id = rooms_images.Room_id
            WHERE 1=1";
    
        // Điều kiện tìm kiếm theo tên hoặc địa điểm
        if (!empty($name)) {
            $query .= " AND (rooms.Name LIKE '%$name%' OR rooms.Diadiem LIKE '%$name%')";
        }
    
        // Lọc theo ngày nhận và ngày trả (không kiểm tra phòng đã đặt trước)
    
        // Điều kiện số người lớn
        if (!empty($adult)) {
            $query .= " AND rooms.Adult = '$adult'";
        }
        if (!empty($checkin) && !empty($checkout)) {
            if (strtotime($checkin) >= strtotime($checkout)) {
                echo json_encode(['error' => 'Ngày nhận phải trước ngày trả!']);
                exit;
            }
        
            // Sửa điều kiện lọc ngày nhận và ngày trả
            $query .= " AND ('$checkin' BETWEEN rooms.Ngaynhan AND rooms.Ngaytra 
                            OR '$checkout' BETWEEN rooms.Ngaynhan AND rooms.Ngaytra 
                            OR (rooms.Ngaynhan <= '$checkin' AND rooms.Ngaytra >= '$checkout'))";
        }
      
      
    
        // Điều kiện số trẻ em
        if (!empty($children)) {
            $query .= " AND rooms.Children = '$children'";
        }
    
        // Điều kiện diện tích
        if (!empty($area)) {
            if ($area == 'Small') {
                $query .= " AND rooms.Area < 30";
            } elseif ($area == 'Medium') {
                $query .= " AND rooms.Area BETWEEN 30 AND 50";
            } elseif ($area == 'Large') {
                $query .= " AND rooms.Area > 50";
            }
        }
    
        // Điều kiện giá
        if (!empty($price)) {
            if ($price == 'low') {
                $query .= " AND rooms.Price < 1000000";
            } elseif ($price == 'medium') {
                $query .= " AND rooms.Price BETWEEN 1000000 AND 2000000";
            } elseif ($price == 'mediumer') {
                $query .= " AND rooms.Price BETWEEN 2000000 AND 3000000";
            } elseif ($price == 'high') {
                $query .= " AND rooms.Price BETWEEN 3000000 AND 4000000";
            } elseif ($price == 'higher') {
                $query .= " AND rooms.Price > 4000000";
            }
        }
    
        // Sắp xếp theo giá tăng dần
        $query .= " ORDER BY rooms.Price ASC";
    
        // Thực hiện truy vấn
        $result = $conn->query($query);
    
        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['Checkin'] = $checkin;
                $row['Checkout'] = $checkout;
                $res[] = $row;
            }
            echo json_encode($res); // Trả về JSON
        } else {
            echo json_encode(['error' => 'Không tìm thấy phòng phù hợp.']);
        }
    }
    
    
    elseif ($action == "timkiemtheotypeks") {
        $type = $_GET['area'];
        // Kiểm tra nếu giá trị type hợp lệ


        $query = "
    SELECT rooms.*, rooms_images.Image,rooms_images.Thumb
    FROM rooms
    INNER JOIN rooms_images ON rooms.id = rooms_images.Room_id
    WHERE 1=1";
        if (!empty($type)) {
            if ($type == 'Small') {
                $query .= " AND Area < 30"; // Diện tích nhỏ dưới 30m²
            } elseif ($type == 'Medium') {
                $query .= " AND Area BETWEEN 30 AND 50"; // Diện tích từ 30m² đến 50m²
            } elseif ($type == 'Large') {
                $query .= " AND Area > 50"; // Diện tích lớn trên 50m²
            }
        }
        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    }  elseif ($action == "xemkhachsan") {
     

        $query = "
    SELECT rooms.*,rooms.id AS idroom,rooms_images.Image,rooms_images.Thumb
    FROM rooms
    INNER JOIN rooms_images ON rooms.id = rooms_images.Room_id
    ";
    
        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }
     
        echo json_encode($res); // Trả về JSON
        exit;
    }
     elseif ($action == "xemks") {
        $id = $_GET['datks'];
        $query = "SELECT 
        r.*, r.Name as room_name,r.id AS idroom,
        f.*, 
        f.Name AS feature_name, 
        fa.*,
        fa.Name AS facility_name,
        rfa.*, ri.*, rf.*
      FROM rooms r
      JOIN rooms_features rf ON r.id = rf.Room_id
      JOIN rooms_facilities rfa ON r.id = rfa.Room_id
      JOIN rooms_images ri ON r.id = ri.Room_id
      JOIN features f ON rf.Features_id = f.id
      JOIN facilities fa ON rfa.Facilities_id = fa.id
      WHERE r.id='$id'";

        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['features'] = $row['feature_name']; // Thêm tên feature vào response
                $row['facilities'] = $row['facility_name']; // Thêm tên facility vào response
                $row['rooms'] = $row['room_name']; // Thêm tên phòng vào response
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
            echo json_encode($res); // Trả về JSON
        } else {
            echo json_encode(['error' => 'Không tìm thấy dữ liệu.']);
        }
        exit;
    } elseif ($action == "xemdattour") {
        $id = $_GET['dattour'];
        $query = "
    SELECT 
        tour.*,
        tour.id AS idtour, 
        tour_images.*,
        departure_time.id AS iddeparture,
        departure_time.*,
        MIN(tour.Price) AS Price,
        departure_dates.*,
        rooms.id AS idroom,
        rooms.Name AS roomname
    FROM 
        tour 
    LEFT JOIN 
        tour_images ON tour.id = tour_images.id_tour 
    LEFT JOIN 
        departure_time ON tour.id = departure_time.id_tour 
    LEFT JOIN 
        departure_dates ON tour.id = departure_dates.tour_id
    LEFT JOIN 
        rooms ON tour.idks = rooms.id
    WHERE 
        tour.id = '$id'
   GROUP BY 
    departure_dates.departure_date
ORDER BY 
    departure_dates.departure_date ASC;
    
    
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
    } elseif ($action == "xemtrangthai") {
        $user_id = $_SESSION['id'];
        $query = "
     SELECT 
        booking_ordertour.*,
        booking_detail_tour.*,
        departure_time.*,
        booking_ordertour.created_at AS booking_time,
        payments.*,
        payments.id AS idpayment
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
    LEFT JOIN
        user_credit ON booking_ordertour.User_id = user_credit.id 
    LEFT JOIN
        payments ON booking_ordertour.Booking_id =  payments.idbook
    WHERE 
        user_credit.id ='$user_id'
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
    } elseif ($action == "xemtoursua") {
        $user_id = $_SESSION['id'];
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
        User_id = '$user_id' AND (booking_ordertour.Booking_id = '$id' OR departure_time.id = '$id')
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
    elseif ($action == "xemtrangthaiks") {
        $user_id = $_SESSION['id'];
        $query = "
    SELECT 
        booking_orderks.*,
        booking_details_ks.*
      
    FROM 
        booking_orderks 
    LEFT JOIN 
        booking_details_ks ON booking_orderks.Booking_id  = booking_details_ks.Booking_id 
    WHERE 
        User_id = '$user_id'
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
    } elseif ($action == "huydontour") {

        $id = $_GET['id'];
        $tt = 1;
        $participants=$_GET['participants'];
        $idtour=$_GET['idtour'];    
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE booking_ordertour  SET refund='$tt' Where Booking_id= '$id'";
        $order_query = "UPDATE departure_time SET Orders = Orders - $participants WHERE id_tour = '$idtour'";
        if ($conn->query($insert_query) === TRUE && $conn->query($order_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    }elseif ($action == "xoapar") {
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
    
    
    elseif ($action == "huydonks") {

        $id = $_GET['id'];
        $tt = 1;

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE booking_orderks  SET Refund='$tt' Where Booking_id= '$id'";
      
        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "xemtrangthaichitiet") {
        $user_id = $_SESSION['id'];
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
        User_id = '$user_id' AND (booking_ordertour.Booking_id = '$id' OR departure_time.id = '$id')
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
    } elseif ($action == "xemtrangthaikschitiet") {
        $user_id = $_SESSION['id'];
        $id = $_GET['id'];
        $query = "
    SELECT 
        booking_orderks.*,
        booking_details_ks.*
      
    FROM 
        booking_orderks 
    LEFT JOIN 
        booking_details_ks ON booking_orderks.Booking_id  = booking_details_ks.Booking_id 
    WHERE 
        User_id = '$user_id' AND booking_orderks.Booking_id = '$id'
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
    }  elseif ($action == "xemtinnhan") {
        $room_id = $_GET['room_id'];
        $user_id = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT sender_id, sender_type, message FROM messages WHERE room_id = ? AND sender_id='$user_id'  ORDER BY created_at ASC");
    $stmt->bind_param("s", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
    } 
    elseif ($action == "xemthongtiner") {
        $user_id = $_SESSION['id'];
        $query = "
        SELECT 
        booking_ordertour.*,
        tour_schedule.*,
        assignment_tour.*
      
    FROM 
        booking_ordertour 
    INNER JOIN 
        tour_schedule ON booking_ordertour.Tour_id  = tour_schedule.id_tour
    INNER JOIN
        assignment_tour ON tour_schedule.id = assignment_tour.id_toursche
    Where
        booking_ordertour.User_id = '$user_id'
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
       
    elseif ($action == "xemthongnv") {
        $user_id = $_SESSION['id'];
        $query = "
        SELECT 
        customer_assignment.*
      
    FROM 
        customer_assignment 
   
    Where
        customer_assignment.customer_id = '$user_id'
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
       
     
       

    
     elseif ($action == "thanhtoan") {
        // Lấy ID từ request
        $user_id = $_SESSION['id'];
        $id = $_GET['idtt'];
        $sql = "
    SELECT 
        booking_ordertour.*,
        booking_detail_tour.*,
        departure_time.*,
        user_credit.Email,user_credit.id
      
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id  = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
    LEFT JOIN
        user_credit ON booking_ordertour.User_id=user_credit.id
    WHERE 
        User_id = '$user_id' AND booking_ordertour.Booking_id='$id'
";
        $result = $conn->query($sql);

        // Chuyển kết quả thành mảng dữ liệu JSON và trả về
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($rows);

    }// Lọc sự kiện
    elseif ($action == "thanhtoanmomo") {
        // Lấy ID từ request
        $user_id = $_SESSION['id'];
        $id = $_GET['momo'];
        $sql = "
    SELECT 
        booking_ordertour.*,
        booking_detail_tour.*,
        departure_time.*,
        user_credit.Email,user_credit.id
      
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id  = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
    LEFT JOIN
        user_credit ON booking_ordertour.User_id=user_credit.id
    WHERE 
        User_id = '$user_id' AND booking_ordertour.Booking_id='$id'
";
        $result = $conn->query($sql);

        // Chuyển kết quả thành mảng dữ liệu JSON và trả về
        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($rows);

    }// Lọc sự kiện
    elseif ($action == "thanhtoanks") {
        $user_id = $_SESSION['id'];
        $id = $_GET['idttks'];
        $query = "
            SELECT 
                booking_orderks.*, 
                booking_details_ks.*, 
                user_credit.Email, user_credit.id
            FROM 
                booking_orderks 
            LEFT JOIN 
                booking_details_ks ON booking_orderks.Booking_id = booking_details_ks.Booking_id 
            LEFT JOIN
                user_credit ON booking_orderks.User_id = user_credit.id
            WHERE 
                User_id = '$user_id' AND booking_orderks.Booking_id = '$id';

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
    } elseif ($action == "capnhattrangthai") {

        $id = $_GET['id'];
        $tt = 2;

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE booking_ordertour  SET Payment_status='$tt' Where Booking_id= '$id'";

        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "laythongtindanhgia") {
        $user_id = $_SESSION['id'];
        $id = $_GET['danhgia'];
        $query = "
            SELECT 
                booking_ordertour.*,
                booking_detail_tour.*,
                departure_time.*
              
            FROM 
                booking_ordertour 
            LEFT JOIN 
                booking_detail_tour ON booking_ordertour.Booking_id  = booking_detail_tour.Booking_id
            LEFT JOIN
                departure_time ON booking_ordertour.Departure_id = departure_time.id
            WHERE 
                User_id = '$user_id' AND booking_ordertour.Booking_id ='$id'
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
    } elseif ($action == "laythongtindanhgiaks") {
        $user_id = $_SESSION['id'];
        $id = $_GET['danhgiaks'];
        $query = "
            SELECT 
                booking_orderks.*, 
                booking_details_ks.*, 
                user_credit.Email, user_credit.id
            FROM 
                booking_orderks 
            LEFT JOIN 
                booking_details_ks ON booking_orderks.Booking_id = booking_details_ks.Booking_id 
            LEFT JOIN
                user_credit ON booking_orderks.User_id = user_credit.id
            WHERE 
                User_id = '$user_id' AND booking_orderks.Booking_id = '$id';

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
    } elseif ($action == "xemdanhgia") {

        $id = $_GET['xemdanhgiatour'];
        $query = "
            SELECT *
            FROM 
                rating_reviewtour
            WHERE 
                rating_reviewtour.Tour_id = '$id'
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
    } elseif ($action == "xemdanhgiarating") {

        $id = $_GET['xemdanhgiarating'];
        $query = "
            SELECT rating_reviewtour.*,
                COUNT(rating_reviewtour.Rating) AS total_ratings,
                ROUND(AVG(rating_reviewtour.Rating), 1) AS average_rating
            FROM 
                rating_reviewtour
            WHERE 
                rating_reviewtour.Tour_id = '$id'
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
    } elseif ($action == "xemdanhgiaks") {

        $id = $_GET['xemdanhgiaks'];
        $query = "
            SELECT *
            FROM 
                rating_reviews_ks
            WHERE 
                rating_reviews_ks.Room_id = '$id'
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
    } elseif ($action == "xemdanhgiaratingks") {

        $id = $_GET['xemdanhgiaratingks'];
        $query = "
            SELECT rating_reviews_ks.*,
                COUNT(rating_reviews_ks.Rating) AS total_ratings,
                ROUND(AVG(rating_reviews_ks.Rating), 1) AS average_rating
            FROM 
                rating_reviews_ks
            WHERE 
                rating_reviews_ks.Room_id = '$id'
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
    } if ($action == "xemhot") {
        $query = "SELECT departure_time.*,tour_images.*,tour.*,tour.id AS tourid FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour LEFT JOIN departure_time ON tour.id = departure_time.id_tour  WHERE Orders < Max_participant AND discount > 0
        GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";

      
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
    
    if ($action == "xemyeuthich") {

        $query = "SELECT departure_time.*,tour_images.*,tour.*,tour.id AS tourid,COUNT(wishlist.item_id) AS total_wishlist
        FROM tour LEFT JOIN tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN departure_time ON tour.id = departure_time.id_tour 
        LEFT JOIN wishlist ON wishlist.item_id = tour.id 
        WHERE  wishlist.type = 'tour'
        GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC LIMIT 10";
        $result = $conn->query($query);

        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($users); // Trả về JSON
        exit;
    } elseif ($action == "check_new_messages") {
        $user_id = $_SESSION['id'];
        $query = "SELECT COUNT(*) as new_messages FROM messages WHERE is_read = 0 AND sender_id = '$user_id' AND sender_type = 'guide'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        echo json_encode(['new_messages' => $row['total']]);
        exit;
    }elseif ($action == "mark_as_read") {
        $user_id = $_SESSION['id'];
        if ($user_id > 0) {
            $query = "UPDATE messages SET is_read = 1 WHERE sender_id = '$user_id' AND is_read = 0 AND sender_type = 'guide'";
            $conn->query($query);
        }
        echo json_encode(['success' => true]);
        exit;
    }if ($action == 'danhsachcskh') {
        $sql = "SELECT id, Name 
                FROM employees 
                WHERE Permissions = 'CSKH' 
                ";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $drivers = [];
    
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
    
        echo json_encode($drivers);
        exit;
    }
    
    if ($action == 'xemtaixe') {
        $phuongtien = isset($_GET['phuongtien']) ? $_GET['phuongtien'] : '';
    
        $sql = "SELECT * FROM drivers";
        if (!empty($phuongtien)) {
            $sql .= " WHERE vehicle_type = ?";
        }
    
        $stmt = $conn->prepare($sql);
        
        if (!empty($phuongtien)) {
            $stmt->bind_param("s", $phuongtien);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $drivers = [];
    
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
    
        echo json_encode($drivers);
        exit;
    }
    if ($action == 'get_upcoming_tours') {
        $sql = "SELECT 
                t.id AS tour_id,
                t.Name AS tour_name,
                t.Style,
                t.Price,
                t.DepartureLocation,
                t.timetour,
                t.vehicle,
                ti.Image,  -- Cột ảnh của tour
                d.departure_date
            FROM tour t
            JOIN departure_dates d ON t.id = d.tour_id
            JOIN tour_images ti ON t.id = ti.id_tour
            WHERE d.departure_date >= CURDATE() + 1
            AND d.is_available = 1
            ORDER BY d.departure_date ASC
            LIMIT 8";
    
        $result = $conn->query($sql);
        $tours = [];
    
        while ($row = $result->fetch_assoc()) {
            $tours[] = $row;
        }
    
        echo json_encode($tours);
        exit();
    }
    if ($action == 'xemkss') {
        $diadiem = isset($_GET['diadiem']) ? trim($_GET['diadiem']) : '';

    try {
        $sql = "SELECT id, Name, Diadiem FROM rooms";
        
        if (!empty($diadiem)) {
            $sql .= " WHERE Diadiem LIKE ?";
            $stmt = $conn->prepare($sql);
            $search = "%$diadiem%";
            $stmt->bind_param("s", $search);
        } else {
            $stmt = $conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $hotels = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($hotels);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Lỗi truy vấn SQL: " . $e->getMessage()]);
    }
    exit;
    }
    if($action == 'get_drivers'){
        $sql = "SELECT driver_id, name, phone, email, vehicle_type, vehicle_plate, status FROM drivers WHERE vehicle_type = 'Xe khách'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $drivers = [];
            while ($row = $result->fetch_assoc()) {
                $drivers[] = $row;
            }
            echo json_encode($drivers);
        } else {
            echo json_encode(["message" => "Không có tài xế nào"]);
        }
    }  if ($action == "xemxethue") {
        $user_id = $_SESSION['id']; 
        $query = "SELECT rentals.*,drivers.*,rentals.vehicle_type AS typeren,drivers.vehicle_type AS typedrive FROM rentals LEFT JOIN drivers ON rentals.driver_id = drivers.driver_id WHERE user_id='$user_id'";

      
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
    if ($action == "xemdiem") {
        $user_id = $_SESSION['id']; 
        $query = "SELECT * FROM tichdiem WHERE idkh='$user_id'";

      
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
    if ($action == "unlock") {
        if (!isset($_GET['email']) || !isset($_GET['token'])) {
            die("Thiếu email hoặc token!");
        }
    
        $email = $_GET['email'];
        $token = $_GET['token'];
    
        $sql = "SELECT * FROM user_credit WHERE Email = ? AND unlock_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows == 1) {
            $conn->query("UPDATE user_credit SET is_locked = 0, failed_attempts = 0, unlock_token = NULL WHERE Email = '$email'");
            echo "Tài khoản đã được mở khóa!";
            header('Location: /tour/dangnhap.php');

        } else {
            echo "Token không hợp lệ hoặc email sai!";
            header('Location: /tour/dangnhap.php');

        }
        exit();
    }

    elseif ($action == "xemtourgoiy") {
        $tourId = isset($_GET['idtour']) ? intval($_GET['idtour']) : 0;
    
        if ($tourId > 0) {
            // Lấy tên tour và vùng miền
            $query = "SELECT Name, vung FROM tour WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $tourId);
            $stmt->execute();
            $result = $stmt->get_result();
            $tour = $result->fetch_assoc();
    
            if ($tour) {
                $tourName = $tour['Name'];
                $region = $tour['vung'];
    
                // Tách tên tour thành từ khóa
                $keywords = preg_split('/[-:,]/', $tourName);
                $likeConditions = [];
                $params = [];
                $types = '';
    
                foreach ($keywords as $keyword) {
                    $keyword = trim($keyword);
                    if (!empty($keyword)) {
                        $likeConditions[] = "tour.Name LIKE ?";
                        $params[] = "%" . $keyword . "%";
                        $types .= 's';
                    }
                }
    
                $res = [];
    
                // Nếu có keyword để tìm
                if (!empty($likeConditions)) {
                    $query2 = "SELECT 
                                    tour.id AS tourid, 
                                    tour.Name, 
                                    tour.Price, 
                                    tour.discount, 
                                    tour.vehicle, 
                                    tour.timetour, 
                                    tour_images.Image, 
                                    departure_time.*
                                FROM tour 
                                INNER JOIN tour_images ON tour.id = tour_images.id_tour
                                INNER JOIN departure_time ON tour.id = departure_time.id_tour
                                WHERE (" . implode(" OR ", $likeConditions) . ")
                                    AND tour.id != ? 
                                    AND departure_time.ngaykhoihanh >= NOW()
                                GROUP BY tour.id
                                ORDER BY MIN(departure_time.ngaykhoihanh) ASC
                                LIMIT 3";
                    $params[] = $tourId;
                    $types .= 'i';
    
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bind_param($types, ...$params);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
    
                    while ($row = $result2->fetch_assoc()) {
                        $res[] = $row;
                    }
                }
    
                // Nếu không có gợi ý theo tên, tìm theo vùng miền
                if (empty($res) && !empty($region)) {
                    $query3 = "SELECT 
                                    tour.id AS tourid, 
                                    tour.Name, 
                                    tour.Price, 
                                    tour.discount, 
                                    tour.vehicle, 
                                    tour.timetour, 
                                    tour_images.Image, 
                                    departure_time.*
                                FROM tour 
                                INNER JOIN tour_images ON tour.id = tour_images.id_tour
                                INNER JOIN departure_time ON tour.id = departure_time.id_tour
                                WHERE tour.vung = ? AND tour.id != ? 
                                    AND departure_time.ngaykhoihanh >= NOW()
                                GROUP BY tour.id
                                ORDER BY MIN(departure_time.ngaykhoihanh) ASC
                                LIMIT 3";
                    $stmt3 = $conn->prepare($query3);
                    $stmt3->bind_param("si", $region, $tourId);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
    
                    while ($row = $result3->fetch_assoc()) {
                        $res[] = $row;
                    }
                }
    
                // Nếu vẫn không có, chọn tour ngẫu nhiên
                if (empty($res)) {
                    $query4 = "SELECT * FROM (
                                    SELECT 
                                        tour.id AS tourid, 
                                        tour.Name, 
                                        tour.Price, 
                                        tour.discount, 
                                        tour.vehicle, 
                                        tour.timetour, 
                                        tour_images.Image,
                                        MIN(departure_time.ngaykhoihanh) AS first_departure
                                    FROM tour 
                                    INNER JOIN tour_images ON tour.id = tour_images.id_tour
                                    INNER JOIN departure_time ON tour.id = departure_time.id_tour
                                    WHERE tour.id != ? AND departure_time.ngaykhoihanh >= NOW()
                                    GROUP BY tour.id
                                    ORDER BY first_departure ASC
                                    LIMIT 10
                                ) AS sorted_tours
                                ORDER BY RAND()
                                LIMIT 3";
                    $stmt4 = $conn->prepare($query4);
                    $stmt4->bind_param("i", $tourId);
                    $stmt4->execute();
                    $result4 = $stmt4->get_result();
    
                    while ($row = $result4->fetch_assoc()) {
                        $res[] = $row;
                    }
                }
    
                echo json_encode($res);
            } else {
                echo json_encode([]);
            }
        } else {
            echo json_encode([]);
        }
        exit;
    }
    
    elseif ($action == "xemthanhtoanvietqr") {
        $user_id = $_SESSION['id'];
        $id = $_GET['vietqr'];
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
        User_id = '$user_id' AND (booking_ordertour.Booking_id = '$id' OR departure_time.id = '$id')
";


        // Thực hiện truy vấn
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            // ---- THÔNG TIN THANH TOÁN ----
            $orderCode = $row['Booking_id'].rand(1,10000);
            $amount = $row['Total_pay'];
            $description = $row['Tour_name'];
            $cancelUrl = 'http://localhost/tour/index.php?cancel';
            $returnUrl = 'http://localhost/tour/index.php?success';
            $expiredAt = time() + 3600;
    
            // ---- BÍ MẬT (cần bảo mật) ----
            $clientId ='8b91497c-50d6-491f-b601-6c0c2ccabc07';
            $apiKey ='2c2ce71d-7d4f-4520-83bb-3b9fd5127975';
            $checksumKey ='3dc1b6f3815230d7b5c14d97ec81e565324f2092595cf1af93c31c69caf8f45c';
            
            // Tạo chữ ký
          
    
            // Dữ liệu gửi PayOS
            $payload = [
                'orderCode' => (int)$orderCode,
                'amount' => (int)$amount,
                'description' => $description,
                'buyerName' => $row['User_name'] ?? '',
                'buyerEmail' => 'buyer@gmail.com',
                'buyerPhone' => $row['Phone_num'] ?? '',
                'buyerAddress' => $row['Address'] ?? '',
                'cancelUrl' => $cancelUrl,
                'returnUrl' => $returnUrl,
                'expiredAt' => $expiredAt
            ];
            
            // ✅ Bổ sung chữ ký HMAC-SHA256 vào payload
            $signData = "amount=$amount&cancelUrl=$cancelUrl&description=$description&orderCode=$orderCode&returnUrl=$returnUrl";
            $signature = hash_hmac('sha256', $signData, $checksumKey);
            $payload['signature'] = $signature;
            
            // Gửi đến PayOS
            $ch = curl_init('https://api-merchant.payos.vn/v2/payment-requests');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'Content-Type: application/json',
              'x-client-id: ' . $clientId,
              'x-api-key: ' . $apiKey,
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            // Parse kết quả từ PayOS
            $payosResult = json_decode($response, true);
            
            // Nếu gọi thành công và có `checkoutUrl`
            if ($http_code == 200 && isset($payosResult['code']) && $payosResult['code'] == '00' && isset($payosResult['data']['checkoutUrl'])) {
                echo json_encode([
                    'code' => '00',
                    'data' => $payosResult['data']
                ]);
            } else {
               
            
                echo json_encode([
                    'code' => '01',
                    'message' => 'Không tạo được thanh toán',
                    'error' => $payosResult
                ]);
            }
            
        } else {
            echo json_encode(['code' => '404', 'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền']);
        }
        exit;
    }
    
    
   
    

    
    


}
?>