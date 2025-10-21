<?php
include '../app/config.php';
include 'layouts/header.php';
?>

<div class="container-fluid py-4">

  <!-- Thanh tìm kiếm & lọc -->
  <div class="card mb-4">
    <div class="card-body">
      <form class="row g-3">
        <div class="col-md-4">
          <input type="text" class="form-control" placeholder="Tìm mã đơn, tên, email, SĐT...">
        </div>
        <div class="col-md-3">
          <select class="form-select">
            <option value="">-- Trạng thái --</option>
            <option value="pending">Chờ xử lý</option>
            <option value="processing">Đang xử lý</option>
            <option value="completed">Hoàn tất</option>
            <option value="cancelled">Đã hủy</option>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary w-100">Tìm kiếm</button>
        </div>
        <div class="col-md-2">
          <button class="btn btn-secondary w-100">Làm mới</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Danh sách đơn hàng -->
  <div class="card">
    <div class="card-header">
      <h5>Danh sách đơn hàng</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <!-- dữ liệu mẫu -->
          <?php
          $sqlOrder = "SELECT * FROM orders ORDER BY CASE 
                          WHEN status = 'pending' THEN 1 
                          WHEN status = 'processing' THEN 2
                          WHEN status = 'completed' THEN 3 
                          WHEN status = 'cancelled' THEN 4 
                          ELSE 5
                        END";
          $resultOrder = $conn->query($sqlOrder);
          while ($rows = $resultOrder->fetch_assoc()) {
            $userID = $rows['user_id'];
            $sqlUser = "SELECT * FROM users WHERE id = $userID LIMIT 1";
            $user = $conn->query($sqlUser)->fetch_assoc();

            $status = $rows['status'] ?? 'pending';
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
            <tr>
              <td>DH0<?php echo $rows['id'] ?></td>
              <td><?php echo $user['fullname'] ?></td>
              <td><?php echo number_format($rows['total'], 0, ',', '.') ?>₫</td>
              <td><span class="badge <?php echo $badgeClass ?>"><?php echo $statusText ?></span></td>
              <td><?php echo $rows['created_at'] ?></td>
              <td>
                <a href="order_detail.php?order_id=<?php echo $rows['id'] ?>" class="btn btn-sm btn-info">Xem</a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include 'layouts/footer.php'; ?>