<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "fashion";


// Kết nối
$conn = new mysqli($host, $username, $password, $database);

// Check lỗi
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Font Tiếng việt
$conn->set_charset("utf8");
?>