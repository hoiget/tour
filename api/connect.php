<?php
$servername = "localhost";
$username = "root";

$password = "";
$dbname = "tour";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
} // Đường dẫn file kết nối của bạn // Đường dẫn file kết nối của bạn


?>