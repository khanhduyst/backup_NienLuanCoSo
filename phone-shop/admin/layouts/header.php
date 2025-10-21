<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            padding-top: 1rem;
        }

        .sidebar .nav-link {
            color: #333;
        }

        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .card-box {
            min-height: 100px;
            color: white;
        }

        .order-table td a {
            text-decoration: none;
            color: #0d6efd;
            font-weight: 500;
        }

        .dropdown-toggle::after {
            float: right;
            margin-top: 6px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4 class="text-center fw-bold">Admin</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-chart-line me-2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#submenuProduct" role="button">
                            <i class="fas fa-box me-2"></i>Sản phẩm
                        </a>
                        <div class="collapse ms-3" id="submenuProduct">
                            <a class="nav-link" href="add_product.php">Thêm sản phẩm</a>
                            <a class="nav-link" href="variants_product.php">Thêm biến thể sản phẩm</a>
                            <a class="nav-link" href="products.php">Tất cả sản phẩm</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#brands" role="button">
                            <i class="fas fa-box me-2"></i>Quản lý danh mục
                        </a>
                        <div class="collapse ms-3" id="brands">
                            <a class="nav-link" href="brands.php">Thương hiệu</a>
                            <a class="nav-link" href="os.php">Hệ điều hành</a>
                            <a class="nav-link" href="colors.php">Màu sắc</a>
                            <a class="nav-link" href="rams.php">Dung lượng ram</a>
                            <a class="nav-link" href="storages.php">Dung lượng bộ nhớ</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stock.php"><i class="fas fa-file-invoice me-2"></i>Quản lý kho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php"><i class="fas fa-file-invoice me-2"></i>Quản lý tài khoản</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#oder" data-bs-toggle="collapse" role="button">
                            <i class="fas fa-file-invoice me-2"></i>Đơn hàng
                        </a>
                        <div class="collapse ms-3" id="oder">
                            <a class="nav-link" href="orders.php">Đơn hàng</a>
                            <a class="nav-link" href="order_detail.php">Chi tiết đơn hàng</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center px-4 py-2 border-bottom bg-white shadow-sm">
                    <p class="d-flex align-items-center">

                    </p>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="./assets/image/avata/R.png" alt="user" width="40" height="40" class="rounded-circle me-2">
                            <strong><?php echo $_SESSION['fullname'] ?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="info.php"><i class="fa fa-user me-2"></i>Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-cog me-2"></i>Cài đặt</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-credit-card me-2"></i>Gói thanh toán</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>