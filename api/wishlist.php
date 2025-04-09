<?php
session_start();
require 'connect.php'; // file chứa kết nối $conn

$action = $_GET['action'] ?? '';
$user_id = $_SESSION['id'];

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'Bạn chưa đăng nhập']);
    exit;
}

switch ($action) {
    case 'toggle':
        $item_id = intval($_POST['item_id']);
        $type = $_POST['type'];

        $check = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND item_id = ? AND type = ?");
        $check->bind_param("iis", $user_id, $item_id, $type);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            // Đã có → xóa
            $delete = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND item_id = ? AND type = ?");
            $delete->bind_param("iis", $user_id, $item_id, $type);
            $delete->execute();
            echo json_encode(['status' => 'removed']);
        } else {
            // Chưa có → thêm
            $insert = $conn->prepare("INSERT INTO wishlist (user_id, item_id, type) VALUES (?, ?, ?)");
            $insert->bind_param("iis", $user_id, $item_id, $type);
            $insert->execute();
            echo json_encode(['status' => 'added']);
        }
        break;

    case 'get':
        $type = $_GET['type'];
        $stmt = $conn->prepare("SELECT item_id FROM wishlist WHERE user_id = ? AND type = ?");
        $stmt->bind_param("is", $user_id, $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row['item_id'];
        }
        echo json_encode(['status' => 'success', 'items' => $items]);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
}
?>
