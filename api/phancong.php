<?php
session_start();
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "tour");
$conn->set_charset("utf8mb4");
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
if($action == "thong"){
    $query = "SELECT Datetime, Address FROM user_credit";
    $result = mysqli_query($conn, $query);
    
    $total_customers = 0;
    $age_groups = [
        "1-18" => 0,
        "19-40" => 0,
        "41-50" => 0,
        "51+" => 0
    ];
    
    $location_data = [];
    $current_year = date("Y");
    
    while ($row = mysqli_fetch_assoc($result)) {
        $total_customers++; // Tính tổng khách hàng
    
        // Tính tuổi từ năm đăng ký
        $year_registered = date("Y", strtotime($row['Datetime']));
        $age = $current_year - $year_registered;
    
        // Nhóm tuổi
        if ($age >= 1 && $age <= 18) {
            $age_groups["1-18"]++;
        } elseif ($age >= 19 && $age <= 40) {
            $age_groups["19-40"]++;
        } elseif ($age >= 41 && $age <= 50) {
            $age_groups["41-50"]++;
        } else {
            $age_groups["51+"]++;
        }
    
        // Nhóm khu vực
        $location = trim($row['Address']);
        if (!empty($location)) {
            if (!isset($location_data[$location])) {
                $location_data[$location] = 0;
            }
            $location_data[$location]++;
        }
    }
    
    echo json_encode([
        "total_customers" => $total_customers,
        "age_groups" => $age_groups,
        "location_data" => $location_data
    ]);
}if($action == "thongnv"){

$current_date = date("Y-m-d");
$six_months_ago = date("Y-m-d", strtotime("-6 months"));

// Khởi tạo dữ liệu thống kê
$total_employees = 0;
$new_employees = 0;
$old_employees = 0;
$permission_count = ["QL" => 0, "CSKH" => 0, "HDV" => 0];
$yearly_hiring = [];

// Truy vấn danh sách nhân viên
$query = "SELECT Created_at, Permissions FROM employees";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $total_employees++;

    // Xác định nhân viên mới/cũ
    if ($row['Created_at'] >= $six_months_ago) {
        $new_employees++;
    } else {
        $old_employees++;
    }

    // Đếm theo quyền
    $permission = $row['Permissions'];
    if (isset($permission_count[$permission])) {
        $permission_count[$permission]++;
    }

    // Thống kê theo năm tuyển dụng
    $year = date("Y", strtotime($row['Created_at']));
    if (!isset($yearly_hiring[$year])) {
        $yearly_hiring[$year] = 0;
    }
    $yearly_hiring[$year]++;
}

// Xuất JSON
echo json_encode([
    "total_employees" => $total_employees,
    "new_employees" => $new_employees,
    "old_employees" => $old_employees,
    "permission_count" => $permission_count,
    "yearly_hiring" => $yearly_hiring
]);

}
if ($action === 'autoAssignShifts') {
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Lấy danh sách nhân viên
    $employees = $conn->query("SELECT id FROM employees")->fetch_all(MYSQLI_ASSOC);
    
    // Xác định số ngày trong tháng
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    
    // Các loại ca làm việc có thể chọn
    $shiftTypes = ['Ca 1', 'Ca 2', 'Ca 3', 'X']; // X là nghỉ

    foreach ($employees as $employee) {
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
            $randomShift = $shiftTypes[array_rand($shiftTypes)];

            // Chỉ thêm nếu chưa có ca làm việc
            $check = $conn->prepare("SELECT id FROM schedule WHERE employee_id = ? AND shift_date = ?");
            $check->bind_param("is", $employee['id'], $date);
            $check->execute();
            $result = $check->get_result();

            if ($result->num_rows === 0) {
                $stmt = $conn->prepare("INSERT INTO schedule (employee_id, shift_type, shift_date, status) VALUES (?, ?, ?, ?)");
                $status = ($randomShift === 'X') ? 'P' : 'V';
                $stmt->bind_param("isss", $employee['id'], $randomShift, $date, $status);
                $stmt->execute();
            }
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Đã tự động phân công ca!']);
}


if ($action === 'submitReport') {
    $guide_id = intval($_POST['guide_id']);
    $admin_id = intval($_POST['admin_id']);
    $report_type = $_POST['report_type'];
    $report_content = $_POST['report_content'];
    $tour=intval($_POST['tour_id']);

    $file_name = NULL; // Mặc định không có file

    // Xử lý file nếu có upload
    if (!empty($_FILES['report_file']['name'])) {
        $file_name = time() . "_" . basename($_FILES['report_file']['name']);
        $target_dir = "../uploads/reports/";
        $target_file = $target_dir . $file_name;

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("pdf", "doc", "docx");

        if (!in_array($file_type, $allowed_types)) {
            die("❌ Chỉ chấp nhận file PDF hoặc Word!");
        }

        if (!move_uploaded_file($_FILES["report_file"]["tmp_name"], $target_file)) {
            die("❌ Lỗi khi tải file lên server!");
        }
    }

    // Chèn vào database
    $stmt = $conn->prepare("INSERT INTO reports (guide_id, report_type,tour, report_content, report_file,approved_by) VALUES (?, ?,?, ?, ?,?)");
    $stmt->bind_param("isissi", $guide_id, $report_type,$tour, $report_content, $file_name,$admin_id);
    
    if ($stmt->execute()) {
        echo "✅ Báo cáo đã được gửi thành công!";
    } else {
        echo "❌ Lỗi khi gửi báo cáo!";
    }

    $stmt->close();
}

if ($_GET['action'] === 'getToursByIds' && isset($_GET['ids'])) {
    $ids = explode(',', $_GET['ids']);
    $ids = array_map('intval', $ids); // tránh SQL injection

    if (count($ids) > 0) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT t.*, ti.Image 
                FROM tour t 
                LEFT JOIN tour_images ti ON t.id = ti.id_tour 
                WHERE t.id IN ($placeholders)
                GROUP BY t.id";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(['error' => 'Lỗi prepare: ' . $conn->error]);
            exit;
        }

        // Bind các ID (dạng integer)
        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();

        $result = $stmt->get_result();
        $tours = [];
        while ($row = $result->fetch_assoc()) {
            $tours[] = $row;
        }

        echo json_encode($tours);
        exit;
    }
}

if ($action == "get") {
    $month = $_GET['month'];
    $sql = "SELECT s.id, e.name,e.Permissions, s.allowance, s.basic_salary, s.total_salary
            FROM salaries s
            JOIN employees e ON s.employee_id = e.id
            WHERE s.month_year = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $month);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($r = $result->fetch_assoc()) {
        $rows[] = $r;
    }
    echo json_encode($rows);
}

if ($action == "update") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $field = $data['field'];
    $value = $data['value'];
    if (!in_array($field, ['allowance', 'basic_salary'])) die("Invalid field");
    $stmt = $conn->prepare("UPDATE salaries SET $field = ? WHERE id = ?");
    $stmt->bind_param("di", $value, $id);
    $stmt->execute();
    echo "Updated";
}

if ($action == "save_total") {
    $id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE salaries SET total_salary = allowance + basic_salary WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Total updated";
}
if ($action == "auto_add") {
    $month = $_GET['month'] ?? date('Y-m');

    // Lương cơ bản theo vai trò
    $salaryByRole = [
        'QL' => 10000000,
        'CSKH' => 8000000,
        'HDV' => 7000000
    ];

    $added = 0;
    $now = new DateTime(); // ngày hiện tại

    $employees = $conn->query("SELECT id, name, Permissions, created_at FROM employees");

    while ($emp = $employees->fetch_assoc()) {
        $employee_id = $emp['id'];
        $permission = $emp['Permissions'];
        $created_at = $emp['created_at'];

        // Tính số ngày đã làm việc từ created_at đến hiện tại
        $createdDate = new DateTime($created_at);
        $daysBetween = $createdDate->diff($now)->days;

        // Nếu chưa đủ 30 ngày thì bỏ qua
        if ($daysBetween < 30) continue;

        // Kiểm tra đã có lương tháng này chưa
        $stmt = $conn->prepare("SELECT id FROM salaries WHERE employee_id = ? AND month_year = ?");
        $stmt->bind_param("is", $employee_id, $month);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Thêm bản ghi mới
            $basic = $salaryByRole[$permission] ?? 5000000;
            $allowance = 0;
            $total = $basic + $allowance;

            $insert = $conn->prepare("INSERT INTO salaries (employee_id, allowance, basic_salary, total_salary, month_year)
                                      VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("iiids", $employee_id, $allowance, $basic, $total, $month);
            $insert->execute();
            $added++;
        }
    }

    echo "✅ Đã thêm $added bản ghi lương mới cho tháng $month.";
}


if ($action == "get_mysalary") {
    $month = $_GET['month'] ?? date('Y-m');

    // Giả sử ID nhân viên đăng nhập được lưu trong session:

    $employee_id = $_SESSION['id'] ?? 0;

    if (!$employee_id) {
        echo json_encode(null);
        exit;
    }

    $stmt = $conn->prepare("SELECT s.*, e.name FROM salaries s 
                            JOIN employees e ON s.employee_id = e.id 
                            WHERE s.employee_id = ? AND s.month_year = ?");
    $stmt->bind_param("is", $employee_id, $month);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }
}

?>



