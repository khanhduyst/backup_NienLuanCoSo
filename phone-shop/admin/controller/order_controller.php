<?php
session_start();
include '../../app/config.php';

if (isset($_POST['update'])) {
    $order_id = $_POST['orderID'];
    $status = $_POST['status'];
    $sqlOrder = "SELECT * FROM orders WHERE id = '$order_id'";
    $resultOrder = $conn->query($sqlOrder)->fetch_assoc();
    $checkstatus = $resultOrder['status'] ?? '';
    if ($checkstatus === 'completed') {
        $_SESSION['modal_title'] = "Cập nhật thất bại!";
        $_SESSION['modal_message'] = "Bạn không thể cập nhật trạng thái đơn hàng khi giao thành công!";
        $_SESSION['modal_type'] = "error";
    } elseif ($checkstatus === 'cancelled') {
        $_SESSION['modal_title'] = "Cập nhật thất bại!";
        $_SESSION['modal_message'] = "Bạn không thể cập nhật trạng thái đơn hàng khi đã huỷ!";
        $_SESSION['modal_type'] = "error";
    } else {
        $sqlOrder = "UPDATE orders SET status = '$status' WHERE id = $order_id";
        if ($conn->query($sqlOrder)) {
            $_SESSION['modal_title'] = "Cập nhật thành công!";
            $_SESSION['modal_message'] = "Bạn đã cập nhật trạng thái đơn hàng thành công🎉";
            $_SESSION['modal_type'] = "success";
        } else {
            $_SESSION['modal_title'] = "Cập nhật thất bại!";
            $_SESSION['modal_message'] = "Bạn đã cập nhật trạng thái đơn hàng thất bại!";
            $_SESSION['modal_type'] = "error";
        }
    }
    header("Location: ../order_detail.php?order_id=$order_id");
    exit;
}
