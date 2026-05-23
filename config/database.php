<?php
// Đọc từ biến môi trường Docker
// Các giá trị này được set qua GitHub Secrets → docker-compose.yml
$db_host     = getenv('DB_HOST')     ?: 'bwjqtr9xnuzovbc3ngi7-mysql.services.clever-cloud.com';
$db_username = getenv('DB_USERNAME') ?: '';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_database = getenv('DB_DATABASE') ?: '';
$db_port     = getenv('DB_PORT')     ?: '3306';

// Kết nối
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database, $db_port);

// Check lỗi
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Font Tiếng Việt
mysqli_set_charset($conn, "utf8mb4");
?>