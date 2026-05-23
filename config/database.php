<?php
$db_host     = getenv('DB_HOST')     ?: 'bwjqtr9xnuzovbc3ngi7-mysql.services.clever-cloud.com';
$db_username = getenv('DB_USERNAME') ?: 'u8cc0a94adtizbep';
$db_password = getenv('DB_PASSWORD') ?: 'kNpoFAXCndDJOee8aWB5';
$db_database = getenv('DB_DATABASE') ?: 'bwjqtr9xnuzovbc3ngi7';
$db_port     = getenv('DB_PORT')     ?: '3306';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database, $db_port);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>