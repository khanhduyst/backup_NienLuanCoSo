<?php
session_start();
include '../app/config.php';

if (isset($_POST['add_to_cart'])) {
    $product_id  = (int)$_POST['product_id'];
    $variant_id  = (int)($_POST['variant_id'] ?? 0);
    $name        = htmlspecialchars($_POST['product_name'], ENT_QUOTES, 'UTF-8');
    $price       = (float)$_POST['price'];
    $ram         = $_POST['ram'] ?? '';
    $rom         = $_POST['rom'] ?? '';
    $image       = $_POST['image'] ?? '';
    $quantity    = 1;

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
