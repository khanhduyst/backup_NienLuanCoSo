<?php
$host = "localhost";   
$user = "root";       
$pass = "1234";           
$db   = "lkd_smart";   

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Set charset UTF-8 để tránh lỗi tiếng Việt
$conn->set_charset("utf8");
