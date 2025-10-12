<?php
session_start();
include '../app/config.php';

?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>LKD SMART</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- File CSS riêng -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">

</head>

<body>

    <!-- Thanh trên -->
    <div class="top-bar py-2">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a href="index.php" class="d-flex align-items-center text-white text-decoration-none">
                <i class="bi bi-phone-flip fs-3 me-2"></i>
                <span class="fw-bold fs-5">LKD SMART</span>
            </a>

            <!-- Search -->
            <form class="d-none d-md-flex mx-3 flex-grow-1" style="max-width:500px;">
                <input class="form-control rounded-0 rounded-start" type="search" placeholder="Thay pin iphone">
                <button class="btn btn-light rounded-0 rounded-end"><i class="bi bi-search"></i></button>
            </form>

            <!-- Right -->
            <div class="d-flex align-items-center gap-3">
                <div><i class="bi bi-telephone"></i> <span class="small">0385942049</span></div>
                <div><i class="bi bi-geo-alt"></i> <span class="small">Cửa hàng</span></div>
                <div><i class="bi bi-person"></i> <a href="#" class="small text-white text-decoration-none">Đăng nhập / Đăng ký</a></div>
                <a href="cart.php" class="btn btn-outline-light position-relative">
                    <i class="bi bi-cart"></i> Giỏ hàng
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Thanh menu ngang -->
    <div class="nav-bar">
        <div class="container d-flex align-items-center">
            <!-- Nút danh mục -->
            <div class="category-wrapper">
                <div class="category-btn">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i> DANH MỤC SẢN PHẨM
                </div>

                <!-- Mega Menu -->
                <div class="mega-wrapper">
                    <div class="main-menu">
                        <ul>
                            <li>
                                <i class="bi bi-phone"></i>
                                <a href="products.php">Điện thoại</a>
                                <div class="mega-menu">
                                    <div class="column">
                                        <h4>iPhone</h4>
                                        <a href="#">iPhone 14 Series</a>
                                        <a href="#">iPhone 13 Series</a>
                                        <a href="#">iPhone 12 Series</a>
                                        <a href="#">iPhone 11 Series</a>
                                        <a href="#">iPhone XS/XS MAX</a>
                                        <a href="#">iPhone X Series</a>
                                        <a href="#">iPhone 8 Series</a>
                                        <a href="#">iPhone 7/7 Plus</a>
                                        <a href="#">OPPO</a>
                                        <a href="#">Hãng khác</a>
                                    </div>
                                    <div class="column">
                                        <h4>Samsung</h4>
                                        <a href="#">S23 Series</a>
                                        <a href="#">S22 Series</a>
                                        <a href="#">S21 Series</a>
                                        <a href="#">S20 Series</a>
                                        <a href="#">Galaxy Note</a>
                                        <a href="#">Galaxy S</a>
                                        <a href="#">Galaxy A</a>
                                        <a href="#">Google Pixel</a>
                                    </div>
                                    <div class="column">
                                        <h4>Xiaomi</h4>
                                        <a href="#">Xiaomi Mi</a>
                                        <a href="#">Xiaomi Redmi</a>
                                        <a href="#">POCO Phone</a>
                                        <a href="#">Xiaomi Redmi Note</a>
                                        <a href="#">Blackshark</a>
                                        <a href="#">Nokia</a>
                                    </div>
                                </div>
                            </li>
                            <li><i class="bi bi-apple"></i><a href="#">Apple Chính hãng</a></li>
                            <li><i class="bi bi-tablet"></i><a href="#">Máy tính bảng</a></li>
                            <li><i class="bi bi-laptop"></i><a href="#">Laptop</a></li>
                            <li><i class="bi bi-earbuds"></i><a href="#">Âm thanh</a></li>
                            <li><i class="bi bi-camera"></i><a href="#">Đồng hồ, máy ảnh</a></li>
                            <li><i class="bi bi-usb-symbol"></i><a href="#">Phụ kiện</a></li>
                            <li><i class="bi bi-box-seam"></i><a href="#">Kho hàng cũ</a></li>
                            <li><i class="bi bi-tools"></i><a href="#">Sửa chữa - Thay pin</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Các menu bên phải -->
            <div class="flex-grow-1 d-flex">
                <div class="px-3"><i class="bi bi-shield-check"></i> Chính sách bảo hành</div>
                <div class="px-3"><i class="bi bi-piggy-bank"></i> Tra cứu bảo hành</div>
                <div class="px-3"><i class="bi bi-truck"></i> Trả góp online</div>
                <div class="px-3"><i class="bi bi-exclamation-triangle"></i> Hướng dẫn thiết lập</div>
                <div class="px-3"><i class="bi bi-gear"></i> Tính năng</div>
            </div>
        </div>
    </div>