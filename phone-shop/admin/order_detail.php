<?php include 'layouts/header.php'; ?>

<div class="container-fluid py-4">

  <!-- Thông tin đơn hàng & khách hàng -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Chi tiết đơn hàng #1001</h5>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <p><strong>Khách hàng:</strong> Nguyễn Văn A</p>
          <p><strong>Email:</strong> a@gmail.com</p>
          <p><strong>Số điện thoại:</strong> 0901234567</p>
          <p><strong>Địa chỉ giao hàng:</strong> 123 Lê Lợi, Quận 1, TP. Hồ Chí Minh</p>
        </div>
        <div class="col-md-6">
          <p><strong>Ngày đặt:</strong> 2025-09-22</p>
          <p><strong>Trạng thái:</strong> 
            <select class="form-select form-select-sm w-auto d-inline-block">
              <option selected>Chờ xử lý</option>
              <option>Đang giao</option>
              <option>Hoàn tất</option>
              <option>Đã hủy</option>
            </select>
          </p>
          <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">26,000,000₫</span></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Danh sách sản phẩm trong đơn -->
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
          <!-- Dữ liệu mẫu -->
          <tr>
            <td>1</td>
            <td>iPhone 14 Pro Max</td>
            <td>1</td>
            <td>25,000,000₫</td>
            <td>25,000,000₫</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Ốp lưng iPhone</td>
            <td>2</td>
            <td>500,000₫</td>
            <td>1,000,000₫</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include 'layouts/footer.php'; ?>
