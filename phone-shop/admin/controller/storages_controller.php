<?php
session_start();
include '../../app/config.php';
$user_sessoin = $_SESSION['username'];
$idUser_sesion = $_SESSION['user_id'];
if (isset($_POST['save'])) {
    $size = $_POST['size'];
    $status = $_POST['status'];
    $checkSize = $conn->query("SELECT * FROM storages WHERE size = '$size' AND is_delete = 0 LIMIT 1");

    if ($checkSize && $checkSize->num_rows > 0) {
        $_SESSION['message'] = 'dung lượng bộ nhớ $size đã tồn tại';
        $_SESSION['msg_type'] = 'warning';
    } else {
        if ($conn->query("INSERT INTO storages(size, status) VALUE ('$size', '$status')")) {
            $_SESSION['message'] = 'Thêm bộ nhờ $size thành công';
            $_SESSION['msg_type'] = 'success';

            $user_id = $idUser_sesion;
            $username = $user_sessoin;
            $desc = "Người dùng $username đã thêm bộ nhớ: $size";
            $desc = $conn->real_escape_string($desc);

            $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
                        VALUES ('$user_id', 'INSERT', 'storages', '$desc')";
            $conn->query($sql_log);
        } else {
            $_SESSION['message'] = "Thêm bộ nhớ thất bại!";
            $_SESSION['msg_type'] = "danger";
        }
    }
    header("Location: ../storages.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];
    $status = $_POST['status'];

    if ($conn->query("UPDATE storages SET size='$size', status='$status' WHERE id=$id")) {
        $_SESSION['message'] = "Cập nhật bộ nhớ thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã cập nhật bộ nhớ $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'UPDATE', 'storages', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Cập nhật bộ nhớ thất bại!";
        $_SESSION['msg_type'] = "danger";
    }
    header("Location: ../storages.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("UPDATE storages SET is_delete = 1, status = 1 WHERE id = $id")) {
        $_SESSION['message'] = "Xoá bộ nhớ thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã xoá bộ nhớ: $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'DELETE', 'storages', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Xoá bộ nhớ thất bại!";
        $_SESSION['msg_type'] = "danger";
    }


    header("Location: ../storages.php");
}
