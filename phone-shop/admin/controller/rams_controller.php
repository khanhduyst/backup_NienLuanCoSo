<?php
session_start();
include '../../app/config.php';
$user_sessoin = $_SESSION['username'];
$idUser_sesion = $_SESSION['user_id'];
if (isset($_POST['save'])) {
    $size = $_POST['size'];
    $status = $_POST['status'];
    $checkSize = $conn->query("SELECT * FROM rams WHERE size = '$size' LIMIT 1");

    if ($checkSize->num_rows > 0) {
        $_SESSION['message'] = 'Tên Ram "$size" đã tồn tại';
        $_SESSION['msg_type'] = 'warning';
    } else {
        if ($conn->query("INSERT INTO rams(size, status) VALUE ('$size', '$status')")) {
            $_SESSION['message'] = 'Thêm Ram thành công';
            $_SESSION['msg_type'] = 'success';

            $user_id = $idUser_sesion;
            $username = $user_sessoin;
            $desc = "Người dùng $username đã thêm Ram: $size";
            $desc = $conn->real_escape_string($desc);

            $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
                        VALUES ('$user_id', 'INSERT', 'rams', '$desc')";
            $conn->query($sql_log);
        } else {
            $_SESSION['message'] = "Thêm Ram thất bại!";
            $_SESSION['msg_type'] = "danger";
        }
    }
    header("Location: ../rams.php");
}

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $size = $_POST['size'];
    $status = $_POST['status'];

    if ($conn->query("UPDATE rams SET size='$size', status='$status' WHERE id=$id")) {
        $_SESSION['message'] = "Cập nhật Ram thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã cập nhật Ram $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'UPDATE', 'rams', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Cập nhật Ram thất bại!";
        $_SESSION['msg_type'] = "danger";
    }
    header("Location: ../rams.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM rams WHERE id=$id")) {
        $_SESSION['message'] = "Xoá Rams thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã xoá Rams: $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'DELETE', 'rams', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Xoá Rams thất bại!";
        $_SESSION['msg_type'] = "danger";
    }


    header("Location: ../rams.php");
}
