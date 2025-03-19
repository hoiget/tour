<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "tour");

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'getEmployees') {
    $result = $conn->query("SELECT id, Name FROM employees");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

if ($action === 'getShifts') {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $result = $conn->query("SELECT s.*, e.Name FROM schedule s JOIN employees e ON s.employee_id = e.id 
                            WHERE MONTH(s.shift_date) = $month AND YEAR(s.shift_date) = $year");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}


if ($action === 'addShift') {
    $employee_id = $_POST['employee_id'];
    $shift_type = $_POST['shift_type'];
    $shift_date = $_POST['shift_date'];
    $status = $_POST['status'];

    $conn->query("INSERT INTO schedule (employee_id, shift_type, shift_date, status) 
                  VALUES ($employee_id, '$shift_type', '$shift_date', '$status')");
    echo json_encode(['status' => 'success']);
}
if ($action === 'updateShift') {
    $shift_id = $_POST['shift_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE schedule SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $shift_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
}
if ($_GET['action'] == 'addShift1') {
    $employee_id = $_POST['employee_id'];
    $shift_type = $_POST['shift_type'];
    $shift_date = $_POST['shift_date'];
    $status = $_POST['status'];

    // Kiểm tra employee_id có tồn tại không
    $checkEmployee = $conn->prepare("SELECT id FROM employees WHERE id = ?");
    $checkEmployee->bind_param("i", $employee_id);
    $checkEmployee->execute();
    $result = $checkEmployee->get_result();

    if ($result->num_rows === 0) {
        die(json_encode(["status" => "error", "message" => "Employee ID không tồn tại"]));
    }

    // Nếu hợp lệ thì thêm ca làm việc
    $stmt = $conn->prepare("INSERT INTO schedule (employee_id, shift_type, shift_date, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $employee_id, $shift_type, $shift_date, $status);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "id" => $stmt->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi thêm dữ liệu"]);
    }
}   if ($action === 'taophong') {
    $user_id = $_POST['user_id'];
    $employee_id = $_POST['employee_id'];
    
    // Tạo mã phòng ngẫu nhiên
    $room_id = uniqid('room_');

    // Lưu vào database
    $stmt = $conn->prepare("INSERT INTO chat_rooms (room_id, user_id, employee_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $room_id, $user_id, $employee_id);
    
    if ($stmt->execute()) {
        echo json_encode(["room_id" => $room_id]);
    } else {
        echo json_encode(["error" => "Không thể tạo phòng"]);
    }
}

if ($action === 'thamgiaphong') {
$room_id = $_POST['room_id'];

// Kiểm tra phòng có tồn tại không
$stmt = $conn->prepare("SELECT * FROM chat_rooms WHERE room_id = ?");
$stmt->bind_param("s", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["error" => "Phòng không tồn tại"]);
}
}

elseif ($action == "guitinnhan") {
   

    $user_id = $_SESSION['id'];
    $room_id = $_POST['room_id'] ?? null;
    $message = trim($_POST['message'] ?? '');
    $sender_type = "user"; // Mặc định người gửi là user

    if (empty($room_id) || empty($message)) {
        echo json_encode(["success" => false, "message" => "Thiếu dữ liệu đầu vào"]);
        exit;
    }

    // Tìm receiver_id từ bảng chat_rooms
    $sqlReceiver = "SELECT user_id, employee_id FROM chat_rooms WHERE room_id = ?";
    $stmtReceiver = $conn->prepare($sqlReceiver);
    $stmtReceiver->bind_param("s", $room_id);
    $stmtReceiver->execute();
    $resultReceiver = $stmtReceiver->get_result();

    if ($row = $resultReceiver->fetch_assoc()) {
        // Xác định người nhận dựa trên sender_id
        $receiver_id = ($row['user_id'] == $user_id) ? $row['employee_id'] : $row['user_id'];
    } else {
        echo json_encode(["success" => false, "message" => "Phòng chat không tồn tại"]);
        exit;
    }

    // Chèn tin nhắn vào bảng messages
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, room_id, sender_type, message, created_at, is_read) 
                            VALUES (?, ?, ?, ?, ?, NOW(), 0)");
    $stmt->bind_param("iisss", $user_id, $receiver_id, $room_id, $sender_type, $message);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi SQL: " . $stmt->error]);
    }

    $stmt->close();
}



