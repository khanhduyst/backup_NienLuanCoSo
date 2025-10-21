<?php
include '../app/config.php';
include "layouts/header.php";
$sqlwhere = '';
$from = '*';
$userID  = $_SESSION['user_id'];
$sqlUser = "SELECT * FROM users WHERE id = $userID";
$sqlLog = "SELECT $from FROM activity_logs WHERE user_id = $userID " . $sqlwhere;
$queryUser = $conn->query($sqlUser);
$username = '';
$fullname = '';
$email = '';
$phone = '';
$password = '';
$role = '';
$roles = '';
$status = '';
$created_at = '';
if ($queryUser->num_rows > 0) {
    $result = $queryUser->fetch_assoc();
    $username = $result['username'];
    $fullname = $result['fullname'];
    $email = $result['email'];
    $phone = $result['phone'];
    $ip_address = '';
    if ($result['role'] == 'admin') {
        $role = 'Quản trị viên';
        $roles = 'Toàn quyền';
    } else {
        $role = 'Người dùng';
        $roles = 'Khách hàng (Xem sản phẩm, mua hàng, quản lý đơn)';
    }
    if (!empty($result['created_at']) && $result['created_at'] != '0000-00-00 00:00:00') {
        $created_at = date('d/m/Y', strtotime($result['created_at']));
    } else {
        $created_at = 'Chưa cập nhật';
    }
    # $created_at = date('d/m/Y', strtotime($result['status']));

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    if ($ip_address == '::1') {
        $ip_address = '127.0.0.1';
    }
    $from = "created_at";
    $sqlwhere = "AND action = 'LOGIN' AND DATE(created_at) = CURDATE() LIMIT 1";
    $resultLogLogin = $conn->query($sqlLog)->fetch_assoc();
}

?>

<style>
    .card {
        border-radius: 12px;
    }

    .nav-tabs .nav-link.active {
        background-color: #f43f5e;
        color: #fff !important;
        border: none;
        border-radius: 6px;
    }

    .nav-tabs .nav-link {
        border: none;
        border-radius: 6px;
        transition: 0.2s;
    }

    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid #f1f1f1;
    }
</style>
<div class="container my-4">
    <!-- Profile Header -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center position-relative"
                style="background: linear-gradient(90deg, #60a5fa, #fb7185); border-radius: 10px;">
                <img src="./assets/img/avata/R.png"
                    class="mb-1"
                    width="100" height="100" alt="Avatar">
                <h4 class="fw-bold text-white mb-0"><?php echo $fullname ?></h4>
                <p class="text-white-50 mb-2">
                    <i class="bi bi-person-badge"></i> <?php echo $role ?>
                    <span class="mx-2">•</span>
                    <i class="bi bi-geo-alt"></i> Sóc Trăng, Việt Nam
                </p>
                <p class="text-white-50 mb-0">
                    <i class="bi bi-calendar"></i> Tham gia từ tháng <?php echo $created_at ?>
                </p>
                <button class="btn btn-success btn-sm mt-3">
                    <i class="bi bi-check-circle"></i> Đang hoạt động
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold bg-white">Thông tin cá nhân</div>
                <div class="card-body">
                    <p><i class="bi bi-person"></i> <strong>Họ tên:</strong> <?php echo $fullname ?></p>
                    <p><i class="bi bi-person-circle"></i> <strong>Tên đăng nhập:</strong> <?php echo $username ?></p>
                    <p><i class="bi bi-shield-check"></i> <strong>Vai trò:</strong> <?php echo $role ?></p>
                    <p><i class="bi bi-envelope"></i> <strong>Email:</strong> <?php echo $email ?></p>
                    <p><i class="bi bi-telephone"></i> <strong>Điện thoại:</strong> <?php echo $phone ?></p>
                    <p><i class="bi bi-geo-alt"></i> <strong>Địa chỉ:</strong> Thành phố Sóc Trăng</p>
                    <p><i class="bi bi-calendar"></i> <strong>Ngày tham gia:</strong> <?php echo $created_at ?></p>
                    <p><i class="bi bi-lock"></i> <strong>Trạng thái tài khoản:</strong> Hoạt động</p>
                    <p><i class="bi bi-laptop"></i> <strong>Lần đăng nhập gần nhất:</strong> <?php echo $resultLogLogin['created_at']??'' ?></p>
                    <p><i class="bi bi-wifi"></i> <strong>Địa chỉ IP:</strong> <?php echo $ip_address ?></p>
                    <p><i class="bi bi-key"></i> <strong>Quyền hạn:</strong> <?php echo $roles ?></p>
                </div>
            </div>

        </div>

        <!-- Right: Đơn hàng gần đây -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header fw-bold bg-white">Đơn hàng gần đây</div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="../admin/order_detail.php?order_id=1" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-semibold text-primary">#DH001</h6>
                                <small>Đơn hàng 3,200,000đ - Ngày 20/09/2025</small>
                            </div>
                            <span class="badge bg-info text-dark">Chờ xử lý</span>
                        </a>

                        <a href="../admin/order_detail.php?order_id=2" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-semibold text-primary">#DH002</h6>
                                <small>Đơn hàng 5,000,000đ - Ngày 19/09/2025</small>
                            </div>
                            <span class="badge bg-success">Hoàn tất</span>
                        </a>

                        <a href="../admin/order_detail.php?order_id=3" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 fw-semibold text-primary">#DH003</h6>
                                <small>Đơn hàng 1,200,000đ - Ngày 18/09/2025</small>
                            </div>
                            <span class="badge bg-danger">Đã huỷ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "layouts/footer.php" ?>