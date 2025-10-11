<?php
session_start();
include '../app/config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    $desc = "Người dùng '$username' đã đăng xuất hệ thống";
    $desc = $conn->real_escape_string($desc);

    $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
            VALUES ('$user_id', 'LOGOUT', 'users', '$desc')";
    $conn->query($sql_log);
}

session_destroy();
header("Location: login.php");
exit;
