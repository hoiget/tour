<!-- wishlist.php -->
<?php

$user_id = $_SESSION['id'] ?? 0;
if (!$user_id) {
    echo "Bạn cần đăng nhập để xem danh sách yêu thích.";
    exit;
}
$type = $_GET['type'] ?? 'tour';
require './api/connect.php';

$stmt = $conn->prepare("SELECT item_id FROM wishlist WHERE user_id = ? AND type = ?");
$stmt->bind_param("is", $user_id, $type);
$stmt->execute();
$result = $stmt->get_result();
$ids = [];
while ($row = $result->fetch_assoc()) {
    $ids[] = $row['item_id'];
}

if (count($ids) === 0) {
    echo "<p>Bạn chưa có mục yêu thích nào.</p>";
    exit;
}

$in = implode(",", array_map('intval', $ids));
$table = $type === 'tour' ? 'tour' : 'rooms'; // bảng tương ứng
$query = "SELECT * FROM $table INNER JOIN tour_images ON tour.id=tour_images.id_tour WHERE id IN ($in)";
$res = $conn->query($query);


?>
<!-- wishlist.php -->
<style>
    main{
        background: #f5f5f5;
    }
.wishlist-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px;
}

.wishlist-item {
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background: #fff;
}

.wishlist-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.wishlist-item img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 12px;
}

.wishlist-item h3 {
    font-size: 1.1rem;
    margin: 0 0 6px;
    color: #333;
}

.wishlist-item p {
    font-weight: bold;
    color: #e91e63;
}
h3{
    font-size: 1.5rem;
    margin: 0 0 12px;
    padding-top: 20px;
    color: #333;
    text-align: center;
}
</style>
<h3>Danh sách yêu thích</h3>
<div class="wishlist-container">
<?php
while ($row = $res->fetch_assoc()) {
    echo "<div class='wishlist-item'>";
    
    // Nếu có ảnh, hiển thị
    if (!empty($row['Image'])) {
        echo "
        <a href='index.php?idtour={$row['id']}&xemdanhgiatour={$row['id']}&xemdanhgiarating={$row['id']}'>
        <img src='./assets/img/tour/{$row['Image']}' alt='{$row['Name']}'>
        </a>";
    }

    echo "<h3>" . htmlspecialchars($row['Name']) . "</h3>";
    echo "<p>" . number_format($row['Price']) . " đ</p>";
    echo "</div>";
}
?>
</div>
