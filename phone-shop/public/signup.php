<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
include '../app/config.php';

// Nếu đã đăng nhập thì chuyển về trang chủ
if (isset($_SESSION['user_id'])) {
    header("Location: ../public/index.php");
    exit;
}

// Xử lý đăng ký
if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $checkUsername = $conn->query("SELECT * FROM users WHERE username = '$username' LIMIT 1");

    if (empty($username) || empty($fullname) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['modal_title'] = "Thiếu thông tin tài khoản";
        $_SESSION['modal_message'] = "Vui lòng điền đầy đủ tất cả các trường dữ liệu!";
        $_SESSION['modal_type'] = "error";
    } else if ($checkUsername && $checkUsername->num_rows > 0) {
        $_SESSION['modal_title'] = "Tài khoản đã tồn tại";
        $_SESSION['modal_message'] = "Tên tài khoản <b>$username</b> đã được sử dụng. Vui lòng chọn tên khác.";
        $_SESSION['modal_type'] = "error";
    } else {
        $sql = "INSERT INTO users(username, fullname, email, phone, password, role)
                VALUES('$username', '$fullname', '$email', '$phone', '$password', 'customer')";
        if ($conn->query($sql)) {
            $user_id = $conn->insert_id;
            $username = $fullname;
            $desc = "Người dùng $username đã đăng ký tài khoản thành công";
            $desc = $conn->real_escape_string($desc);

            $sql_log = "INSERT INTO activity_logs (user_id, action, table_name, description)
                        VALUES ('$user_id', 'LOGIN', 'users', '$desc')";
            $conn->query($sql_log);
            $_SESSION['modal_title'] = "Tạo tài khoản thành công 🎉";
            $_SESSION['modal_message'] = "Bạn đã đăng ký tài khoản <b>$username</b> thành công!";
            $_SESSION['modal_type'] = "success";
        } else {
            $_SESSION['modal_title'] = "Lỗi hệ thống";
            $_SESSION['modal_message'] = "Đăng ký thất bại, vui lòng thử lại!";
            $_SESSION['modal_type'] = "error";
        }
    }

    header("Location: ./signup.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            color: #000;
            background-color: #B0BEC5;
            overflow-x: hidden;
        }

        .card0 {
            box-shadow: 0 4px 8px rgba(0, 0, 0, .2);
        }

        .btn-blue {
            background-color: #1A237E;
            color: #fff;
            width: 150px;
        }

        .btn-blue:hover {
            background-color: #000;
        }

        .bg-blue {
            color: #fff;
            background-color: #1A237E;
        }

        input {
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
        }

        input:focus {
            border-color: #304FFE;
            outline: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="https://i.imgur.com/uNGdWHi.png" class="img-fluid" style="max-width:350px;">
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <h2 class="text-center mb-4">ĐĂNG KÝ TÀI KHOẢN</h2>
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Tài khoản</label>
                                <input type="text" name="username" placeholder="Nhập tài khoản">
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="fullname" placeholder="Nhập họ tên">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" placeholder="Nhập email">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="signup" class="btn btn-blue">Đăng ký</button>
                            </div>
                            <div class="text-center mt-3">
                                <small>Đã có tài khoản? <a href="./login.php" class="text-danger">Đăng nhập</a></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-3 text-center mt-4">
                <small>© 2025 LKD SMART. All rights reserved.</small>
            </div>
        </div>
    </div>

    <!-- jQuery, Bootstrap & SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    if (isset($_SESSION['modal_message'])) {
        $icon = $_SESSION['modal_type'] ?? 'success';
        $title = addslashes($_SESSION['modal_title'] ?? '');
        $message = addslashes($_SESSION['modal_message'] ?? '');

        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '$icon',
                title: '$title',
                html: '$message',
                timer: 2500,
                showConfirmButton: false
            }).then(() => {
                if ('$icon' === 'success') {
                    window.location.href = 'login.php';
                }
            });
        });
        </script>";
        unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type']);
    }
    ?>
</body>

</html>