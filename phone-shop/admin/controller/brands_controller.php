
<?php
session_start();
include '../../app/config.php';

$user_sessoin = $_SESSION['username'];
$idUser_sesion = $_SESSION['user_id'];
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $checkName = $conn->query("SELECT * FROM brands WHERE name = '$name' AND is_delete = 0 LIMIT 1");
    if ($checkName && $checkName->num_rows > 0) {
        $_SESSION['message'] = "Thương hiệu '$name' đã tồn tại!";
        $_SESSION['msg_type'] = "warning";
    } else {
        if ($conn->query("INSERT INTO brands(name, type, status) VALUE ('$name', '$type', '$status')")) {
            $_SESSION['message'] = "Thêm thương hiệu thành công!";
            $_SESSION['msg_type'] = "success";

            $user_id = $idUser_sesion;
            $username = $user_sessoin;
            $desc = "Người dùng $username đã thêm thương hiệu $name";
            $desc = $conn->real_escape_string($desc);

            $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
                        VALUES ('$user_id', 'INSERT', 'brands', '$desc')";
            $conn->query($sql_log);
        } else {
            $_SESSION['message'] = "Thêm thương hiệu thất bại!";
            $_SESSION['msg_type'] = "danger";
        }
    }
    header("Location: ../brands.php");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    if ($conn->query("UPDATE brands SET name='$name', type = '$type', status='$status' WHERE id=$id")) {
        $_SESSION['message'] = "Cập nhật thương hiệu thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã cập nhật thương hiệu $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'UPDATE', 'brands', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Cập nhật thương hiệu thất bại!";
        $_SESSION['msg_type'] = "danger";
    }
    header("Location: ../brands.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("UPDATE brands SET is_delete = 1, status = 1 WHERE id = $id")) {
        $_SESSION['message'] = "Xoá thương hiệu thành công!";
        $_SESSION['msg_type'] = "success";

        $user_id = $idUser_sesion;
        $username = $user_sessoin;
        $desc = "Người dùng $username đã xoá thương hiệu $name";
        $desc = $conn->real_escape_string($desc);

        $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, record_id,description)
                        VALUES ('$user_id', 'DELETE', 'brands', '$id', '$desc')";
        $conn->query($sql_log);
    } else {
        $_SESSION['message'] = "Xoá thương hiệu thất bại!";
        $_SESSION['msg_type'] = "danger";
    }


    header("Location: ../brands.php");
}
