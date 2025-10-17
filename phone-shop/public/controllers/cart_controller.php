<?php
session_start();
include '../../app/config.php';

if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $variant_id = (int)($_POST['variant_id'] ?? 0);
    $name = htmlspecialchars($_POST['product_name'], ENT_QUOTES, 'UTF-8');
    $price = (float)$_POST['price'];
    $color = $_POST['color'] ?? '';
    $ram = $_POST['ram'] ?? '';
    $rom = $_POST['rom'] ?? '';
    $image = $_POST['image'] ?? '';
    $quantity = 1;

    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $key = $product_id . '-' . $ram . '-' . $rom;

    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$key] = [
            'product_id' => $product_id,
            'variant_id' => $variant_id,
            'name' => $name,
            'price' => $price,
            'color' => $color,
            'ram' => $ram,
            'rom' => $rom,
            'image' => $image,
            'quantity' => $quantity
        ];
    }

    $_SESSION['modal_title'] = "Đã thêm vào giỏ hàng!";
    $_SESSION['modal_message'] = "Sản phẩm <b>{$name}</b> đã được thêm vào giỏ hàng 🎉";
    $_SESSION['modal_type'] = "success";

    header("Location: ../detail.php?product_id=$product_id");
    exit;
}


if (isset($_POST['checkout'])) {
    $_SESSION['order_note'] = trim($_POST['note'] ?? '');
    $_SESSION['voucher_code'] = trim($_POST['voucher'] ?? '');

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<script>alert('Giỏ hàng trống!'); window.location.href='../cart.php';</script>";
        exit;
    }

    header("Location: ../checkout.php");
    exit;
}


if (isset($_POST['action']) && $_POST['action'] == 'remove') {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: ../cart.php");
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'update_qty') {
    $id = $_POST['product_id'];
    $qty = (int)$_POST['quantity'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $qty;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'not_found']);
    }
    exit;
}
