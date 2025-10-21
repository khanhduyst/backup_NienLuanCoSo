<?php
session_start();
include '../../app/config.php';
$user_sessoin = $_SESSION['username'];
$idUser_sesion = $_SESSION['user_id'];
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $status = $_POST['status'];
    $checkName = $conn->query("SELECT * FROM colors WHERE name = '$name' AND is_delete = 0 LIMIT 1");
    $checkCode = $conn->query("SELECT * FROM colors WHERE code = '$code' AND is_delete = 0 LIMIT 1");
    if ($checkName && $checkName->num_rows > 0) {
        $_SESSION['message'] = "Tên màu <b>'$name'</b> đã tồn tại";
        $_SESSION['msg_type'] = 'warning';
    } else if ($checkName && $checkCode->num_rows > 0) {
        $_SESSION['message'] = "Mã màu <b>'$code'</b> đã tồn tại";
        $_SESSION['msg_type'] = 'warning';
    } else {
        if ($conn->query("INSERT INTO colors(name, code, status) VALUE ('$name', '$code', '$status')")) {
            $_SESSION['message'] = 'Thêm màu thành công';
            $_SESSION['msg_type'] = 'success';

            $user_id = $idUser_sesion;
            $username = $user_sessoin;
            $desc = "Người dùng $username đã thêm màu: $name";
            $desc = $conn->real_escape_string($desc);

            $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
                        VALUES ('$user_id', 'INSERT', 'colors', '$desc')";
            $conn->query($sql_log);
        } else {
            $_SESSION['message'] = "Thêm màu thất bại!";
            $_SESSION['msg_type'] = "danger";
        }
    }
    header("Location: ../colors.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $status = $_POST['status'];
    if ($conn->query("UPDATE colors SET name='$name', code = '$code',status='$status' WHERE id=$id")) {
        $_SESSION['message'] = "Cập nhật màu thành công thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã cập nhật màu $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'UPDATE', 'colors', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Cập nhật màu thất bại!";
        $_SESSION['msg_type'] = "danger";
    }
    header("Location: ../colors.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("UPDATE colors SET is_delete = 1, status = 1 WHERE id = $id")) {
        $_SESSION['message'] = "Xoá màu thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã xoá màu $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'DELETE', 'colors', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Xoá màu thất bại!";
        $_SESSION['msg_type'] = "danger";
    }


    header("Location: ../colors.php");
}
