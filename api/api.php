<?php

session_start();

include_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "login") {
        $loginInput = $_POST['email']; // Có thể là email hoặc số điện thoại
        $password = $_POST['password'];

        // Truy vấn kiểm tra email hoặc số điện thoại và mật khẩu đã được mã hóa MD5
        $sql = "SELECT * FROM user_credit WHERE (Email = ? OR sdt = ?) AND Password = MD5(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $loginInput, $loginInput, $password); // Bind cả email và số điện thoại
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Lưu thông tin vào session
            $_SESSION['id'] = $user['id'];
            $_SESSION['Name'] = $user['Name']; // Lưu tên người dùng
            $_SESSION['Email'] = $user['Email']; // Lưu email
            $_SESSION['sdt'] = $user['sdt']; // Lưu số điện thoại
            $_SESSION['Address'] = $user['Address']; // Lưu địa chỉ
            $_SESSION['profile'] = $user['profile']; // Lưu đường dẫn ảnh đại diện (nếu có)
            $_SESSION['Datetime'] = $user['Datetime']; // Lưu ngày giờ tạo tài khoản

            echo 'success';
        } else {
            echo 'error';
        }
    } elseif ($action == "register") {
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
    } elseif ($action == "dattourfull") {
        // Lấy dữ liệu từ POST

        $user_id = $_SESSION['id'];
        $tour_id = $_POST['tour_id'];
        $departure_id = $_POST['depart_id'];
        $arrival = $_POST['arrival'];
        $booking_status = '1';
        $payment_status = '1';
        $refund = 0;
        $datetime = date("Y-m-d");
        $participants = $_POST['adults'] + $_POST['children'] + $_POST['babies'];

        $tour_name = $_POST['tour_name'];
        $price = $_POST['price1'];
        $total_pay = $_POST['total-price'];
        $user_name = $_POST['fullname'];
        $phone_num = $_POST['phone'];
        $address = $_POST['address'];


        // Kiểm tra nếu các trường bắt buộc rỗng
        if (empty($user_id) || empty($tour_id) || empty($tour_name) || empty($price)) {
            echo 'missing_data';
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
                // 3. Cập nhật orders trong bảng departure_time
                $update_departure_query = "UPDATE departure_time SET Orders = Orders + ? WHERE id_tour = ?";
                $stmt_departure = $conn->prepare($update_departure_query);

                if (!$stmt_departure) {
                    echo 'query_error';
                    exit;
                }

                $stmt_departure->bind_param("si", $participants, $tour_id);

                if ($stmt_departure->execute()) {
                    echo 'insert_success';
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
    } elseif ($action == "datksfull") {
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
    } elseif ($action == "guitinnhan") {
        $user_id = $_SESSION['id'];
        $username = $_SESSION['Name'];
        $message = $_POST['message'];

        // Chèn dữ liệu vào bảng feedback
        $sql = "INSERT INTO messages (UserId,UserName,message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $username, $message);

        if ($stmt->execute()) {
            echo "gửi thành công!";
        } else {
            echo "Có lỗi xảy ra:" . $conn->error;
        }
        $stmt->close();
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
        $query = "SELECT * FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour";

        $result = $conn->query($query);

        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    } elseif ($action == "xemlayout") {
        $query = "SELECT * FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour LIMIT 6";

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

        $query = "SELECT * FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour WHERE tour.type = '$type'";
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
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        // Tạo câu truy vấn động
        $query = "SELECT * FROM tour INNER JOIN tour_images ON tour.id = tour_images.id_tour WHERE 1=1";

        // Thêm điều kiện tìm kiếm
        if (!empty($name)) {
            $query .= " AND tour.Name LIKE '%$name%'";
        }
        if (!empty($date)) {
            $query .= " AND tour.Depart = '$date'";
        }
        if (!empty($budget)) {
            if ($budget == 'low') {
                $query .= " AND tour.price < 5000000";
            } elseif ($budget == 'medium') {
                $query .= " AND tour.price BETWEEN 5000000 AND 10000000";
            } elseif ($budget == 'high') {
                $query .= " AND tour.price > 10000000";
            }
        }
        if (!empty($type)) {
            $query .= " AND tour.type = '$type'";
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
    } elseif ($action == "timkiemtheothongtinks") {
        // Lấy dữ liệu từ form hoặc URL
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $area = isset($_GET['area']) ? $_GET['area'] : '';
        $price = isset($_GET['price']) ? $_GET['price'] : '';
        $adult = isset($_GET['adult']) ? $_GET['adult'] : '';
        $children = isset($_GET['children']) ? $_GET['children'] : '';

        // Xây dựng câu truy vấn SQL
        $query = "
    SELECT rooms.*, rooms_images.Image,rooms_images.Thumb
    FROM rooms
    INNER JOIN rooms_images ON rooms.id = rooms_images.Room_id
    WHERE 1=1";

        // Điều kiện tìm kiếm
        if (!empty($name)) {
            $query .= " AND rooms.Name LIKE '%$name%'";
        }
        if (!empty($adult)) {
            $query .= " AND rooms.Adult = '$adult'";
        }
        if (!empty($children)) {
            $query .= " AND rooms.Children = '$children'";
        }
        if (!empty($area)) {
            if ($area == 'Small') {
                $query .= " AND Area < 30"; // Diện tích nhỏ dưới 30m²
            } elseif ($area == 'Medium') {
                $query .= " AND Area BETWEEN 30 AND 50"; // Diện tích từ 30m² đến 50m²
            } elseif ($area == 'Large') {
                $query .= " AND Area > 50"; // Diện tích lớn trên 50m²
            }
        }

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

        // Thực hiện truy vấn
        $result = $conn->query($query);

        $res = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
            echo json_encode($res); // Trả về JSON
        } else {
            echo json_encode(['error' => 'Không tìm thấy phòng phù hợp.']);
        }
    } elseif ($action == "timkiemtheotypeks") {
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
    } elseif ($action == "xemtrangthai") {
        $user_id = $_SESSION['id'];
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
    } elseif ($action == "xemtrangthaiks") {
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

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa

        $insert_query = "UPDATE booking_ordertour  SET refund='$tt' Where Booking_id= '$id'";

        if ($conn->query($insert_query) === TRUE) {
            echo 'gui';
        } else {
            echo 'kotc';
        }



    } elseif ($action == "huydonks") {

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
        departure_time.*
    FROM 
        booking_ordertour 
    LEFT JOIN 
        booking_detail_tour ON booking_ordertour.Booking_id = booking_detail_tour.Booking_id
    LEFT JOIN
        departure_time ON booking_ordertour.Departure_id = departure_time.id
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
    } elseif ($action == "xemtinnhan") {

        $user_id = $_SESSION['id']; // Lấy id từ session
        $query = "
    SELECT * FROM messages
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
    } elseif ($action == "thanhtoan") {
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
    }


}
?>