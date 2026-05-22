<?php
$db_host = "bwjqtr9xnuzovbc3ngi7-mysql.services.clever-cloud.com";
$db_username = "u8cc0a94adtizbep";
$db_password = "kNpoFAXCndDJOee8aWB5";
$db_database = "bwjqtr9xnuzovbc3ngi7";
$db_port = "3306";


// Kết nối
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database, $db_port);

// Check lỗi
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Font Tiếng việt
mysqli_set_charset($conn, "utf8mb4");
?>