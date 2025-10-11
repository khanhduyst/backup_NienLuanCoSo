<?php include 'layouts/header.php'; ?>

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
          <tr>
            <td>1001</td>
            <td>Nguyễn Văn A</td>
            <td>12,500,000₫</td>
            <td><span class="badge bg-warning">Chờ xử lý</span></td>
            <td>2025-09-22</td>
            <td>
              <a href="order_detail.php?id=1001" class="btn btn-sm btn-info">Xem</a>
            </td>
          </tr>
          <tr>
            <td>1002</td>
            <td>Trần Thị B</td>
            <td>25,000,000₫</td>
            <td><span class="badge bg-success">Hoàn tất</span></td>
            <td>2025-09-21</td>
            <td>
              <a href="order_detail.php?id=1002" class="btn btn-sm btn-info">Xem</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include 'layouts/footer.php'; ?>
