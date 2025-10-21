<?php
session_start();
include '../../app/config.php';

$user_sessoin = $_SESSION['username'];
$idUser_sesion = $_SESSION['user_id'];

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $status = $_POST['status'];
    $checkName = $conn->query("SELECT * FROM os WHERE name = '$name' AND is_delete = 0 LIMIT 1");
    if ($checkName && $checkName->num_rows > 0) {
        $_SESSION['message'] = "Thương hiệu '$name' đã tồn tại!";
        $_SESSION['msg_type'] = "warning";
    } else {
        if ($conn->query("INSERT INTO os(name, status) VALUE ('$name', '$status')")) {
            $_SESSION['message'] = "Đã thêm hệ điều hành $name thành công!";
            $_SESSION['msg_type'] = "success";

            $user_id = $idUser_sesion;
            $username = $user_sessoin;
            $desc = "Người dùng $username đã thêm thương hiệu $name";
            $desc = $conn->real_escape_string($desc);

            $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
                        VALUES ('$user_id', 'INSERT', 'brands', '$desc')";
            $conn->query($sql_log);
        } else {
            $_SESSION['message'] = "Thêm hệ điều hành thất bại!";
            $_SESSION['msg_type'] = "danger";
        }
    }
    header("Location: ../os.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    if ($conn->query("UPDATE os SET name='$name', status='$status' WHERE id=$id")) {
        $_SESSION['message'] = "Cập nhật hệ điều hành thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã cập nhật hệ điều hành $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'UPDATE', 'os', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Cập nhật hệ điều hành thất bại!";
        $_SESSION['msg_type'] = "danger";
    }
    header("Location: ../os.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("UPDATE os SET is_delete = 1, status = 1 WHERE id = $id")) {
        $_SESSION['message'] = "Xoá hệ điều hành thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã xoá hệ điều hành $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'DELETE', 'os', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Xoá hệ điều hành thất bại!";
        $_SESSION['msg_type'] = "danger";
    }


    header("Location: ../os.php");
}
