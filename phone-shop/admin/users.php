<?php include 'layouts/header.php'; ?>

<div class="container-fluid py-4">

  <!-- Form thêm/sửa người dùng -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Thêm / Sửa Người dùng</h5>
    </div>
    <div class="card-body">
      <form>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Họ và tên</label>
            <input type="text" class="form-control" placeholder="Nhập họ và tên">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="Nhập email">
          </div>
          <div class="col-md-6">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" placeholder="Nhập số điện thoại">
          </div>
          <div class="col-md-6">
            <label class="form-label">Vai trò</label>
            <select class="form-select">
              <option value="customer">Khách hàng</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tình trạng</label>
            <select class="form-select">
              <option value="1" selected>Hoạt động</option>
              <option value="0">Khóa</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" placeholder="••••••••">
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-success">Lưu</button>
          <button type="reset" class="btn btn-secondary">Làm mới</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Danh sách người dùng -->
  <div class="card">
    <div class="card-header">
      <h5>Danh sách người dùng</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Vai trò</th>
            <th>Tình trạng</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <!-- Dữ liệu mẫu -->
          <tr>
            <td>1</td>
            <td>Nguyễn Văn A</td>
            <td>a@gmail.com</td>
            <td>0901234567</td>
            <td><span class="badge bg-primary">Admin</span></td>
            <td><span class="badge bg-success">Hoạt động</span></td>
            <td>2025-09-22</td>
            <td>
              <button class="btn btn-sm btn-warning">Sửa</button>
              <button class="btn btn-sm btn-danger">Xóa</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Trần Thị B</td>
            <td>b@gmail.com</td>
            <td>0987654321</td>
            <td><span class="badge bg-secondary">Khách hàng</span></td>
            <td><span class="badge bg-secondary">Khóa</span></td>
            <td>2025-09-20</td>
            <td>
              <button class="btn btn-sm btn-warning">Sửa</button>
              <button class="btn btn-sm btn-danger">Xóa</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include 'layouts/footer.php'; ?>
