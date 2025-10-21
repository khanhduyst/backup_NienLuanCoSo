<?php
session_start();
include '../../app/config.php';

if (isset($_POST['save'])) {
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $status = $_POST['status'] ?? '';
    $checkUsername = $conn->query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
    if (empty($username) || empty($fullname) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['modal_title'] = "Thiếu thông tin tài khoản";
        $_SESSION['modal_message'] = "Vui lòng xem lại các trường dữ liệu!";
        $_SESSION['modal_type'] = "error";
    } else if ($checkUsername->num_rows > 0) {
        $_SESSION['modal_title'] = "Tài khoản tồn tại";
        $_SESSION['modal_message'] = "Tài khoản đã tồn tại, vui lòng chọn tài khoản khác!";
        $_SESSION['modal_type'] = "error";
    } else {
        if ($conn->query("INSERT INTO users(username, fullname, email, phone, password, role, status) VALUES('$username', '$fullname', '$email', '$phone', '$password', '$role', '$status')")) {
            $_SESSION['modal_title'] = "Tạo tài khoản thành công";
            $_SESSION['modal_message'] = "Bạn đã tạo tài khoản <b>$username</b> thành công";
            $_SESSION['modal_type'] = "success";
        } else {
            $_SESSION['modal_title'] = "Lổi";
            $_SESSION['modal_message'] = "Vui lòng tạo lại tài khoản!";
            $_SESSION['modal_type'] = "error";
        }
    }
    header("Location: ../users.php");
    exit;
}

if (isset($_POST['update'])) {
    $userID = $_POST['userID'] ?? '';
    $username = $_POST['username'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $status = $_POST['status'] ?? '';
    if (empty($username) || empty($fullname) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['modal_title'] = "Thiếu thông tin tài khoản";
        $_SESSION['modal_message'] = "Vui lòng xem lại các trường dữ liệu!";
        $_SESSION['modal_type'] = "error";
    } {
        $queryUserUpdate = "UPDATE users 
                            SET 
                                username = '$username',
                                fullname = '$fullname',
                                email = '$email',
                                phone = '$phone',
                                password = '$password',
                                role = '$role',
                                status = $status
                            WHERE id = '$userID'";
        if ($conn->query($queryUserUpdate)) {
            $_SESSION['modal_title'] = "Cập nhật tài khoản thành công";
            $_SESSION['modal_message'] = "Bạn đã cập nhật tài khoản <b>$username</b> thành công";
            $_SESSION['modal_type'] = "success";
        } else {
            $_SESSION['modal_title'] = "Lổi";
            $_SESSION['modal_message'] = "Vui lòng tạo lại tài khoản!";
            $_SESSION['modal_type'] = "error";
        }
    }
    header("Location: ../users.php?edit=$userID");
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $queryUserDel = "UPDATE users SET status = 1, is_delete = 1 WHERE id = $id";

    if ($conn->query($queryUserDel)) {
        $_SESSION['modal_title'] = "Đã xóa sản phẩm!";
        $_SESSION['modal_message'] = "Bạn đã xoá thành công tài khoản !";
        $_SESSION['modal_type'] = "success";
    } else {
        $_SESSION['modal_title'] = "Lổi";
        $_SESSION['modal_message'] = "Xoá tài khoản không thành công!";
        $_SESSION['modal_type'] = "error";
    }
    header("Location: ../users.php");
    exit;
}
