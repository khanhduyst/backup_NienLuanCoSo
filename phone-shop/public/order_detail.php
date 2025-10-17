<?php
include '../app/config.php';

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header("Location: order_history.php");
    exit;
}

include('layouts/header.php');
?>

<style>
    body {
        background-color: #f8f9fa;
        font-family: "Mulish", sans-serif;
    }

    .order-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .order-header {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .order-header h5 {
        font-weight: 700;
    }

    .order-status {
        font-size: 0.9rem;
    }

    .badge {
        font-size: 0.9em;
        padding: 6px 10px;
        border-radius: 8px;
    }

    .product-item {
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-info img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .product-name {
        font-weight: 600;
    }

    .product-details {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .total-section {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        text-align: right;
        font-size: 1.05rem;
        font-weight: 600;
    }

    .btn-back {
        text-decoration: none;
        color: #0d6efd;
        font-size: 0.95rem;
    }

    .btn-back:hover {
        text-decoration: underline;
    }
</style>

<div class="container py-4 order-container">
    <?php
    $order_id = (int)$_GET['order_id'];
    $userID =  $_SESSION['user_id'];
    $sql = "SELECT * FROM orders WHERE id = '$order_id' AND user_id = '$userID'";
    $sqlOrder_item = "SELECT * 
                FROM orders o INNER JOIN order_items oi
                ON o.id = oi.order_id
                WHERE oi.order_id = $order_id";

    $order = $conn->query($sql)->fetch_assoc();
    $status = $order['status'] ?? 'pending';
    $statusText = '';
    $badgeClass = '';
    switch ($status) {
        case 'pending':
            $statusText = 'Chờ xử lý';
            $badgeClass = 'bg-warning text-dark';
            break;
        case 'processing':
            $statusText = 'Đang xử lý';
            $badgeClass = 'bg-info text-dark';
            break;
        case 'completed':
            $statusText = 'Hoàn tất';
            $badgeClass = 'bg-success text-white';
            break;
        case 'cancelled':
            $statusText = 'Đã huỷ';
            $badgeClass = 'bg-danger text-white';
            break;
        default:
            $statusText = 'Không xác định';
            $badgeClass = 'bg-secondary text-white';
    }

    ?>
    <!-- Thông tin đơn -->
    <div class="order-header d-flex justify-content-between align-items-start flex-wrap">
        <div>
            <h5>Đơn hàng #DH0<?php echo $order['id'] ?></h5>
            <p class="mb-1">Ngày đặt: <strong><?php echo $order['created_at'] ?></strong></p>
            <p class="mb-1">Địa chỉ giao hàng: <strong><?php echo $order['shipping_address'] ?>,<?php echo $order['shipping_city'] ?>, <?php echo $order['shipping_district'] ?>, <?php echo $order['shipping_province'] ?></strong></p>
        </div>
        <div class="text-end">
            <span class="badge <?php echo $badgeClass ?>"><?php echo $statusText ?></span>
            <p class="order-status mt-2 mb-0 text-muted">Phương thức thanh toán: COD</p>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <?php
    $resultItems = $conn->query($sqlOrder_item);
    if ($resultItems && $resultItems->num_rows > 0) {
        while ($order_item = $resultItems->fetch_assoc()) {
            $idProduct = $order_item['product_id'];
            $queryProduct = "SELECT * FROM products WHERE id = $idProduct";
            $item = $conn->query($queryProduct)->fetch_assoc();
    ?>
            <div class="product-item">
                <div class="product-info">
                    <img src="./assets/img/product/<?php echo $item['img_main'] ?>" alt="<?php echo $item['name'] ?>">
                    <div>
                        <div class="product-name"><?php echo $item['name'] ?></div>
                        <div class="product-details">Màu: <?php echo $order_item['color_name'] ?> | RAM: <?php echo $order_item['ram_name'] ?> | Dung lượng: <?php echo $order_item['storage_name'] ?></div>
                        <div class="text-muted small">Số lượng: <?php echo $order_item['quantity'] ?> | Giá: <?php echo number_format($order_item['price'], 0, ',', '.') ?>₫</div>
                    </div>
                </div>
                <div class="text-end">
                    <div>
                        <?php
                        echo number_format($order_item['price'] * $order_item['quantity'], 0, ',', '.') . "đ" ?>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- Tổng kết -->
    <div class="total-section mt-3">
        Tổng tiền: <span class="text-danger"><?php echo number_format($order['total'] + $order['voucher_discount'], 0, ',', '.') ?>₫</span>
        <br>
        Voucher giảm giá: <span class="text-danger"><?php echo number_format($order['voucher_discount'], 0, ',', '.') ?>₫</span>
        <br>
        Tổng tiền: <span class="text-danger"><?php echo number_format($order['total'], 0, ',', '.') ?>₫</span>
    </div>

    <div class="text-center mt-3">
        <a href="../public/order_history.php" class="btn-back">← Quay lại lịch sử đơn hàng</a>
    </div>
    <?php


    ?>
</div>


<?php
include('layouts/footer.php');
?>