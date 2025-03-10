<?php

session_start();

include_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);

    $action = $_POST['action'];
    $action1 = isset($_POST['action']) ? $_POST['action'] : (isset($input['action']) ? $input['action'] : null);

    if ($action == "login") {
        $loginInput = $_POST['email']; // Email hoặc số điện thoại
        $password = $_POST['password'];

        // Kiểm tra trong bảng user_credit (Khách hàng)
        $sql = "SELECT * FROM user_credit WHERE (Email = ? OR sdt = ?) AND Password = MD5(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $loginInput, $loginInput, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Lưu thông tin vào session
            $_SESSION['id'] = $user['id'];
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['sdt'] = $user['sdt'];
            $_SESSION['Address'] = $user['Address'];
            $_SESSION['profile'] = $user['profile'];
            $_SESSION['Datetime'] = $user['Datetime'];
            $_SESSION['role'] = 'customer'; // Đánh dấu là khách hàng

            echo 'customer'; // Điều hướng đến index.php
            exit();
        }

        // Kiểm tra trong bảng employees (Nhân viên)
        $sql = "SELECT * FROM employees WHERE (Email = ? OR Phone_number = ?) AND Password = MD5(?)";
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
     elseif ($action == "register") {
        $username = $_POST['name']; // Tên tài khoản
        $email = $_POST['email'];
        $phone = $_POST['sdt'];
        $address = $_POST['dc'];
        $birthdate = $_POST['ns'];
        $password = $_POST['password'];
        $repassword = $_POST['Repassword'];
        $file = $_FILES['anh']['tmp_name'];
        $name = $_FILES['anh']['name'];
        $loai = $_FILES['anh']['type'];

        // Xử lý ảnh tải lên
        if ($loai != "image/jpg" && $loai != "image/jpeg" && $loai != "image/png") {
            echo 'invalid_image';
            exit;
        }

        // Kiểm tra mật khẩu
        if ($password !== $repassword) {
            echo 'password_mismatch';
            exit;
        }

        // Kiểm tra người dùng đã tồn tại trong cơ sở dữ liệu
        $check_query = "SELECT * FROM user_credit WHERE Email = ? OR sdt = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo 'user_exists';
        } else {
            if (move_uploaded_file($file, "../assets/img/user/" . $name)) {  // Thêm người dùng mới vào cơ sở dữ liệu
                $insert_query = "INSERT INTO user_credit (Name, Address, Email, sdt, profile, Password, Datetime) VALUES (?, ?, ?, ?, ?, MD5(?), ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("sssssss", $username, $address, $email, $phone, $name, $password, $birthdate);


                if ($stmt->execute()) {
                    echo 'registration_success';
                } else {
                    echo 'error_points';
                }

            } else {
                echo 'upload_error';
            }
        }
    } elseif ($action == "updatettcn") {
        $username = $_POST['name']; // Tên tài khoản
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['sdt'];  // Lấy số điện thoại từ session
        $address = $_POST['dc'];    // Địa chỉ
        $birthdate = $_POST['ns'];  // Ngày sinh

        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($username) || empty($email) || empty($phone)) {
            echo 'missing_data';
            exit;
        }

        // Cập nhật thông tin người dùng
        $update_query = "UPDATE user_credit SET Name = ?, Address = ?, Datetime = ? WHERE Email = ? OR sdt = ?";
        $stmt = $conn->prepare($update_query);

        // Kiểm tra nếu không chuẩn bị được câu truy vấn
        if (!$stmt) {
            echo 'query_error';
            exit;
        }

        // Bind các tham số vào câu truy vấn
        $stmt->bind_param("sssss", $username, $address, $birthdate, $email, $phone);

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
        $phanloai=$_POST['phanloai']; 


      
            $method = $_POST['method'] ?? '';
    
          
    
    
    
        
        // Kiểm tra dữ liệu
        if (empty($user_id) || empty($tour_id) || empty($tour_name) || empty($price)) {
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
                $update_departure_query = "UPDATE departure_time SET Orders = Orders + ? WHERE id_tour = ? AND ngaykhoihanh = ?";
                $stmt_departure = $conn->prepare($update_departure_query);
    
                if (!$stmt_departure) {
                    echo 'query_error';
                    exit;
                }
    
                $stmt_departure->bind_param("iis", $participants, $tour_id,$datetime);
    
                if ($stmt_departure->execute()) {

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
    elseif ($action == "guitinnhan") {
        $user_id = $_SESSION['id'];
        $sender_type = "user"; // Xác định người gửi là user
        $tour_id = $_POST['tour_id'];
        $receiver_id = $_POST['receiver_id']; // Hướng dẫn viên (employees.id)
        $message = trim($_POST['message']);
    
        if (!empty($message)) {
            $stmt = $conn->prepare("INSERT INTO messages (tour_id, sender_id, receiver_id, sender_type, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiss", $tour_id,$user_id, $receiver_id , $sender_type, $message);
            
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Có lỗi xảy ra:" . $conn->error;
            }
            $stmt->close();
        } 
    
    } elseif ($action === 'danhgiatour') {
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

       
        // Chèn dữ liệu vào bảng feedback
        $sql = "INSERT INTO request_tour(user_id, customer_name, tour_name, departure_date, tour_price, itinerary, tour_duration,phuongtien)
        VALUES (?, ?, ?, ?, ?, ?, ?,?)";

       
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssisss", $user_id, $customer_name, $tour_name, $departure_date, $tour_price, $itinerary, $tour_duration, $phuongtien);

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
    }
    
    
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = $_GET['action'];
    if ($action == "get_user_info") {
        $email = $_SESSION['Email']; // Lấy email từ session
        $phone = $_SESSION['sdt'];
        $query = "SELECT Email,Name,Address,sdt,Datetime FROM user_credit where Email='$email' OR sdt='$phone'";
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
        $query = "SELECT profile FROM user_credit where Email='$email' OR sdt='$phone'";
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
        $query = "SELECT departure_time.*, tour_images.*, tour.*, tour.id AS tourid 
        FROM tour 
        INNER JOIN tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN departure_time ON tour.id = departure_time.id_tour  
        WHERE Orders < Max_participant 
        GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";  // Lấy ngày sớm nhất
  

        $result = $conn->query($query);

        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    }elseif ($action == "xemtourtheomien") {

        $mien = $_GET['mien'];
        $query = "SELECT departure_time.*, tour_images.*, tour.*, tour.id AS tourid 
        FROM tour 
        INNER JOIN tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN departure_time ON tour.id = departure_time.id_tour  
        WHERE Orders < Max_participant AND vung = '$mien'
        GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC ";

       

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
            departure_time.*
        FROM 
            tour 
        LEFT JOIN 
            tour_images ON tour.id = tour_images.id_tour 
        LEFT JOIN 
            departure_time ON tour.id = departure_time.id_tour
        WHERE 
            tour.id = '$id'
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
        $query = "SELECT departure_time.*,tour_images.*,tour.*,tour.id AS tourid FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour LEFT JOIN departure_time ON tour.id = departure_time.id_tour  WHERE Orders < Max_participant AND tour.type = '$type' GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";

       
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
    
        // Tạo câu truy vấn động
        $query = "SELECT departure_time.*,tour_images.*,tour.*,tour.id AS tourid FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour LEFT JOIN departure_time ON tour.id = departure_time.id_tour WHERE Orders < Max_participant AND 1=1 
        ";
        // Thêm điều kiện tìm kiếm
        if (!empty($name)) {
            $query .= " AND tour.Name LIKE '%$name%' GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";
        }
        if (!empty($date)) {
            $query .= " AND tour.Depart = '$date' GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";
        }
        if (!empty($budget)) {
            if ($budget == 'low') {
                $query .= " AND tour.price < 5000000 GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";
            } elseif ($budget == 'medium') {
                $query .= " AND tour.price BETWEEN 5000000 AND 10000000 GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";
            } elseif ($budget == 'high') {
                $query .= " AND tour.price > 10000000 GROUP BY tour.id 
        ORDER BY departure_time.ngaykhoihanh ASC";
            }
        }
       
        $result = $conn->query($query);
        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    } elseif ($action == "xemks") {
        $query = " SELECT * FROM rooms r JOIN rooms_features rf ON r.id = rf.Room_id JOIN rooms_facilities rfa ON r.id = rfa.Room_id JOIN rooms_images ri ON r.id = ri.Room_id";

        $result = $conn->query($query);

        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    } elseif ($action == "xemlayout1") {
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
            r.*, r.Name as room_name,
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
    } elseif ($action == "xemks") {
        $id = $_GET['datks'];
        $query = "SELECT 
        r.*, r.Name as room_name,
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
        departure_dates.*
    FROM 
        tour 
    LEFT JOIN 
        tour_images ON tour.id = tour_images.id_tour 
    LEFT JOIN 
        departure_time ON tour.id = departure_time.id_tour 
    LEFT JOIN 
        departure_dates ON tour.id = departure_dates.tour_id
    WHERE 
        tour.id = '$id'
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
        $user_id = $_SESSION['id'];
        $id=$_GET['idt'];
        $query = "
        SELECT * FROM messages 
        WHERE sender_id='$user_id' AND tour_id='$id'
        ORDER BY created_at ASC";
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
        $query = "SELECT departure_time.*,tour_images.*,tour.*,tour.id AS tourid FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour LEFT JOIN departure_time ON tour.id = departure_time.id_tour  WHERE Orders < Max_participant AND discount > 0";

      
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

        $query = "SELECT departure_time.*,tour_images.*,tour.*,tour.id AS tourid FROM tour LEFT JOIN tour_images ON tour.id = tour_images.id_tour LEFT JOIN departure_time ON tour.id = departure_time.id_tour  WHERE Orders < Max_participant AND Orders > 1 LIMIT 10";
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


}
?>