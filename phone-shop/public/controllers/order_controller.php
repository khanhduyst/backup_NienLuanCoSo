<?php
include '../../app/config.php';
if (isset($_POST['cancel'])) {
    $id_order = $_POST['id_order'];
    if ($conn->query("UPDATE orders SET status = 'cancelled' WHERE id = $id_order")) {
        $_SESSION['modal_title'] = "Thông Báo!";
        $_SESSION['modal_message'] = "Bạn đã huỷ đơn hàng <b>#DH0{$id_order}</b> thành công 🎉";
        $_SESSION['modal_type'] = "success";
        header("Location: ../order_history.php");
        exit;
    } else {
        $_SESSION['modal_title'] = "Thông Báo!";
        $_SESSION['modal_message'] = "Bạn đã huỷ đơn hàng <b>#DH0{$id_order}</b> thất bại 🎉";
        $_SESSION['modal_type'] = "error";
        header("Location: ../order_history.php");
        exit;
    }
}
