<?php
include '../app/config.php';
include 'layouts/header.php';
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
  $order_id = (int) $_GET['order_id'];
  $sqlOrder = "SELECT * FROM orders WHERE id = '$order_id'";
  $resultOrder = $conn->query($sqlOrder)->fetch_assoc();
  $userID = $resultOrder['user_id'];
  $sqlUser = "SELECT * FROM users WHERE id = $userID LIMIT 1";
  $user = $conn->query($sqlUser)->fetch_assoc();
  $status = $resultOrder['status'] ?? 'pending';

  if (isset($_SESSION['modal_message'])) {
    $icon = $_SESSION['modal_type'] ?? 'success';
    $title = addslashes($_SESSION['modal_title'] ?? '');
    $message = addslashes($_SESSION['modal_message'] ?? '');
    $order_id_safe = isset($order_id) ? (int)$order_id : 0;

    echo "
    <script>
        Swal.fire({
            icon: '$icon',
            title: '$title',
            html: '$message',
            timer: 2500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'order_detail.php?order_id=$order_id_safe';
        });
    </script>";

    unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type']);
  }
?>

  <div class="container-fluid py-4">
    <form action="./controller/order_controller.php" method="post">
      <div class="card mb-4">
        <div class="card-header">
          <h5>Chi tiết đơn hàng <span class="text-primary">#DH0<?php echo $resultOrder['id'] ?></span></h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <input type="hidden" name="orderID" value="<?php echo $resultOrder['id'] ?>">
              <p><strong>Khách hàng:</strong> <?php echo $user['fullname'] ?></p>
              <p><strong>Email:</strong> <?php echo $user['email'] ?? 'Không có' ?></p>
              <p><strong>Số điện thoại:</strong> <?php echo $user['phone'] ?></p>
              <p><strong>Địa chỉ giao hàng:</strong> <?php echo $resultOrder['shipping_address'] . ", " . $resultOrder['shipping_city'] . ", " . $resultOrder['shipping_district'] . ", " . $resultOrder['shipping_city'] . ", " . $resultOrder['shipping_province'] ?></p>
            </div>
            <div class="col-md-6">
              <p><strong>Ngày đặt:</strong> <?php echo $resultOrder['created_at'] ?></p>
              <p><strong>Trạng thái:</strong>
                <select name="status" class="form-select form-select-sm w-auto d-inline-block">
                  <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                  <option class="text-warning" value="processing" <?= $status === 'processing' ? 'selected' : '' ?>>Đang giao</option>
                  <option class="text-success" value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Hoàn tất</option>
                  <option class="text-danger" value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                </select>
              </p>
              <p><strong>Giảm giá:</strong> <span class="text-danger fw-bold"> -<?php echo number_format($resultOrder['voucher_discount'], 0, ',', '.') ?>₫</span></p>
              <p><strong class="text-success">Tổng tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($resultOrder['total'], 0, ',', '.') ?>₫</span></p>
              <div class="text-end mt-3">
                <button type="submit" name="update" class="btn btn-warning">
                  <i class="fa-solid fa-pen-to-square"></i> Cập nhật đơn hàng
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Sản phẩm trong đơn</h5>
        <div style="width: 250px;">
          <input type="text" class="form-control form-control-sm" placeholder="Tìm sản phẩm trong đơn...">
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Sản phẩm</th>
              <th>Số lượng</th>
              <th>Giá</th>
              <th>Thành tiền</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sqlOrderItems = "SELECT * FROM order_items WHERE order_id = $order_id";
            $resultOrderItems = $conn->query($sqlOrderItems);
            $stt = 1;
            while ($rows = $resultOrderItems->fetch_assoc()) {
              $productID = $rows['product_id'];
              $sqlProduct = "SELECT * FROM products WHERE id = $productID";
              $resultProduct = $conn->query($sqlProduct)->fetch_assoc();
            ?>
              <tr>
                <td><?php echo $stt ?></td>
                <td><?php echo $resultProduct['name'] ?></td>
                <td><?php echo $rows['quantity'] ?></td>
                <td><?php echo number_format($rows['price'], 0, ',', '.') ?></td>
                <td><?php echo number_format($rows['subtotal'], 0, ',', '.') ?></td>
              </tr>
            <?php
              $stt++;
            } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

<?php } else {
  echo "OOPS!! ĐÃ BỊ LỔI TRANG RỒI:> <a href='./orders.php' style='color: red;'>Nhấp vào đây</a>";
}
include 'layouts/footer.php'; ?>