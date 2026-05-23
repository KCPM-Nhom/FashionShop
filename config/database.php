<?php
$db_host     = getenv('DB_HOST')     ?: 'blvgoielntvoo6breis7-mysql.services.clever-cloud.com';
$db_username = getenv('DB_USERNAME') ?: 'uqnoc4ctgsxuznnf';
$db_password = getenv('DB_PASSWORD') ?: 'g62WBQ5zRBa1dXbHQGak';
$db_database = getenv('DB_DATABASE') ?: 'blvgoielntvoo6breis7';
$db_port     = getenv('DB_PORT')     ?: '3306';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database, $db_port);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>