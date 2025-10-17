<?php
session_start();
include '../../app/config.php';

if (isset($_POST['checkout'])) {

    $user_id = $_SESSION['user_id'] ?? 0;
    $fullname = trim($_POST['fullName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['shipping_address']);
    $province = trim($_POST['province']);
    $district = trim($_POST['district']);
    $ward = trim($_POST['ward']);
    $payment = $_POST['payment'];
    $note = $_POST['order_note'] ?? '';
    $voucher_discount = $_POST['voucher_discount'] ?? 0;
    $total = $_POST['price'] ?? 0;

    $product_ids = $_POST['product_id'] ?? [];
    $colors = $_POST['color'] ?? [];
    $rams = $_POST['ram'] ?? [];
    $roms = $_POST['rom'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $prices = $_POST['price_items'] ?? [];

    $insertOrder = $conn->query("
        INSERT INTO orders (
            user_id, total, shipping_address, shipping_city, shipping_district, 
            shipping_province, status, voucher_discount
        ) VALUES (
            '$user_id', '$total', '$address', '$ward', '$district', '$province', 'pending', '$voucher_discount'
        )
    ");

    if ($insertOrder) {
        $order_id = $conn->insert_id; 

        for ($i = 0; $i < count($product_ids); $i++) {
            $pid = $product_ids[$i];
            $color = $colors[$i];
            $ram = $rams[$i];
            $rom = $roms[$i];
            $qty = $quantities[$i];
            $price = $prices[$i];
            $subtotal = $price * $qty;

            $conn->query("
                INSERT INTO order_items (
                    order_id, product_id, subtotal, color_name, ram_name, storage_name, quantity, price
                ) VALUES (
                    '$order_id', '$pid', '$subtotal', '$color', '$ram', '$rom', '$qty', '$price'
                )
            ");
        }

        unset($_SESSION['cart']);

        echo "
        <script>
            alert('🎉 Đặt hàng thành công! Cảm ơn bạn đã mua sắm tại LKD SMART ❤️');
            window.location.href = '../index.php';
        </script>";
        exit;
    } else {
        echo "
        <script>
            alert('❌ Có lỗi khi lưu đơn hàng, vui lòng thử lại!');
            window.location.href = '../checkout.php';
        </script>";
    }
}
