<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../../app/config.php';

$user_session = $_SESSION['username'] ?? null;
$idUser_session = $_SESSION['user_id'] ?? null;

if (isset($_POST['save'])) {
    $getid = $_POST['getid'] ?? ($_GET['product_id'] ?? 0);
    $getid = (int)$getid;

    $color = $_POST['color'] ?? '';
    $ram = $_POST['ram'] ?? '';
    $storage = $_POST['storage'] ?? '';
    $price = trim($_POST['price'] ?? '');
    $qty = trim($_POST['quantity'] ?? '');
    $status = $_POST['status'] ?? '';
    $checkResult = $conn->query("SELECT id FROM products WHERE id = $getid");
    if (!$checkResult || $checkResult->num_rows === 0) {
        $_SESSION['modal_title'] = "Lỗi nghiêm trọng!";
        $_SESSION['modal_message'] = "Không tìm thấy thông tin sản phẩm (ID = $getid)";
        $_SESSION['modal_type'] = "error";
        header("Location: ../variants_product.php");
        exit;
    } else if (empty($color) || empty($ram) || empty($storage) || empty($price) || empty($qty) || $status === '') {
        $_SESSION['modal_title'] = "Thiếu thông tin!";
        $_SESSION['modal_message'] = "Vui lòng điền đầy đủ các trường trước khi lưu.";
        $_SESSION['modal_type'] = "error";
        header("Location: ../variants_product.php?product_id=$getid");
        exit;
    } else {

        $result = $conn->query("INSERT INTO product_variants(product_id, ram_id, storage_id, color_id, price, quantity, status, is_deleted) 
        VALUES($getid, $ram, $storage, $color, $price, $qty, $status, 0)");

        if ($result) {
            $_SESSION['modal_title'] = "Thành công!";
            $_SESSION['modal_message'] = "Đã lưu biến thể sản phẩm.";
            $_SESSION['modal_type'] = "success";
            $_SESSION['product_id'] = $getid;
        } else {
            $_SESSION['modal_title'] = "Không thành công!";
            $_SESSION['modal_message'] = "Thêm biến thể thất bại";
            $_SESSION['modal_type'] = "error";
            header("Location: ../variants_product.php");
        }
        header("Location: ../variants_product.php?product_id=$getid");
        exit;
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['variantid'];
    $getid = $_POST['getid'];
    $color = $_POST['color'] ?? '';
    $ram = $_POST['ram'] ?? '';
    $storage = $_POST['storage'] ?? '';
    $price = trim($_POST['price'] ?? '');
    $qty = trim($_POST['quantity'] ?? '');
    $status = $_POST['status'] ?? '';

    if (empty($color) || empty($ram) || empty($storage) || empty($price) || empty($qty) || $status === '') {
        $_SESSION['modal_title'] = "Thiếu thông tin!";
        $_SESSION['modal_message'] = "Vui lòng điền đầy đủ các trường trước khi lưu.";
        $_SESSION['modal_type'] = "error";
        header("Location: ../variants_product.php?product_id=$getid&edit=$id");
        exit;
    } else {
        if ($conn->query("UPDATE product_variants SET ram_id = '$ram', storage_id = '$storage', color_id = '$color',price = '$price', quantity = '$qty', status = '$status' WHERE id = $id")) {
            $_SESSION['modal_title'] = "Thành công!";
            $_SESSION['modal_message'] = "Đã cập nhật biến thể sản phẩm.";
            $_SESSION['modal_type'] = "success";
            $_SESSION['modal_check_edit'] = "edit";
            $_SESSION['product_id'] = $getid;
        } else {
            $_SESSION['modal_title'] = "Không thành công!";
            $_SESSION['modal_message'] = "Thêm biến thể thất bại";
            $_SESSION['modal_type'] = "error";
            header("Location: ../variants_product.php?product_id=$getid&edit=$id");
        }
        header("Location: ../variants_product.php?product_id=$getid");
        exit;
    }
}

if (isset($_POST['confirm_delete'])) {
    $id = (int)$_POST['delete_id'];
    $getid = (int)$_POST['product_id'];
    $conn->query("UPDATE product_variants SET is_deleted = 1, deleted_at = NOW() WHERE id = $id");
    $_SESSION['modal_title'] = "Xoá thành công!";
    $_SESSION['modal_message'] = "Biến thể ID $id đã được xoá.";
    $_SESSION['modal_type'] = "success";
    header("Location: ../variants_product.php?product_id=$getid");
    exit;
}

if (isset($_POST['find_product'])) {
    $search = $_POST['search'];
    if ($search === '') {
           $_SESSION['modal_title'] = "Không thành công!";
            $_SESSION['modal_message'] = "Chưa nhập ID hoặc tên sản phẩm";
            $_SESSION['modal_type'] = "error";
        header("Location: ../variants_product.php");
        exit;
    }
    $result = $conn->query("SELECT id FROM lkd_smart.products WHERE name = '$search%' OR id = '$search'");
    if ($result->num_rows <= 0) {
        $_SESSION['modal_title'] = "Không thấy!";
        $_SESSION['modal_message'] = "Không tìm thấy id hoặc sản phẩm";
        $_SESSION['modal_type'] = "error";
        header("Location: ../variants_product.php");
        exit;
    } else {
        $row = $result->fetch_assoc();
        $getid = $row['id'];
        header("Location: ../variants_product.php?product_id=$getid");
        exit;
    }
    // SELECT * FROM lkd_smart.products WHERE name = '' OR id = '26';
}
