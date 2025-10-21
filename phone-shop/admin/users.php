<?php
include '../app/config.php';
include 'layouts/header.php';

$users = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $usersID = (int) $_GET['edit'];
  $sqlusers = "SELECT * FROM users WHERE id = '$usersID' LIMIT 1";
  $resultusers = $conn->query($sqlusers);
  if ($resultusers && $resultusers->num_rows > 0) {
    $users = $resultusers->fetch_assoc();
  }
}

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
            window.location.href = 'users.php';
        });
    </script>";

  unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type']);
}
?>

<div class="container-fluid py-4">

  <!-- Form thêm/sửa người dùng -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Thêm / Sửa Người dùng</h5>
    </div>
    <div class="card-body">
      <form action="./controller/users_controller.php" method="POST">
        <input type="hidden" name="userID" value="<?php echo $users['id'] ?? '' ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="fullname" value="<?php echo $users['fullname'] ?? '' ?>" class="form-control" placeholder="Nhập họ và tên">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo $users['email'] ?? '' ?>" class="form-control" placeholder="Nhập email">
          </div>
          <div class="col-md-6">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" value="<?php echo $users['phone'] ?? '' ?>" class="form-control" placeholder="Nhập số điện thoại">
          </div>
          <div class="col-md-6">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-select">
              <option value="customer" <?php echo isset($users) && $users['role'] == 'customer' ? 'selected' : '' ?>>Khách hàng</option>
              <option value="admin" <?php echo isset($users) && $users['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tài khoản</label>
            <input type="text" name="username" value="<?php echo $users['username'] ?? '' ?>" class="form-control" placeholder="Nhập tài khoản">
          </div>
          <div class="col-md-6">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" value="<?php echo $users['password'] ?? '' ?>" class="form-control" placeholder="••••••••">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tình trạng</label>
            <select name="status" class="form-select">
              <option value="0" <?php echo isset($users) && $users['status'] == 0 ? 'selected' : '' ?>>Hoạt động</option>
              <option value="1" <?php echo isset($users) && $users['status'] == 1 ? 'selected' : '' ?>>Khóa</option>
            </select>
          </div>

        </div>
        <div class="mt-3">
          <button type="submit" class="btn <?php echo $users ? 'btn-warning' : 'btn-success' ?>" name="<?php echo $users ? 'update' : 'save' ?>"><?php echo $users ? 'Cập nhật' : 'Lưu' ?></button>
          <a href="users.php" class="btn btn-secondary">Làm mới</a>
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
      <table class="table table-bordered table-hover align-middle ">
        <thead class="table-light text-center">
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
          <?php
          $sqlUsers = "SELECT * FROM users WHERE is_delete = 0";
          $result = $conn->query($sqlUsers);
          $stt = 1;
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $id = $row['id'];
          ?>
              <tr>
                <td><?php echo $stt ?></td>
                <td><?php echo $row['fullname'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['phone'] ?></td>
                <td>
                  <?php
                  $role = $row['role'];
                  if ($role == 'admin') {
                    echo "<span class='badge bg-success'>Admin</span>";
                  } else {
                    echo "<span class='badge bg-warning text-dark'>User</span>";
                  }
                  ?>
                </td>
                <td><span class="badge <?php echo $row['status'] ? 'bg-danger' : 'bg-success' ?>"><?php echo $row['status'] ? 'Khoá' : 'Hoạt động' ?></span></td>
                <td><?php echo $row['created_at'] ?></td>
                <td class="text-center">
                  <div class="d-inline-flex gap-1">
                    <a href="users.php?edit=<?php echo $row['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="" method="post" class="d-inline">
                      <input type="hidden" name="userID" value="<?php echo $row['id'] ?>">
                      <!-- <button class="btn btn-sm btn-danger">Xóa</button> -->
                      <a href='#' class='btn btn-sm btn-danger' onclick='confirmDelete(<?php echo $id?>)'>Xoá</a>
                    </form>
                  </div>
                </td>

              </tr>
          <?php
              $stt++;
            }
          } else {
            echo "Không có dữ liệu.";
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Bạn có chắc muốn xóa?',
      text: "Hành động này không thể hoàn tác!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Xóa ngay',
      cancelButtonText: 'Hủy'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = './controller/users_controller.php?delete=' + id;
      }
    });
  }
</script>

<?php include 'layouts/footer.php'; ?>