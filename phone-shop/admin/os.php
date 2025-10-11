<?php include 'layouts/header.php';
include '../app/config.php';

if (isset($_SESSION['message'])) {
?>
  <div class="alert alert-<?php echo $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['message'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php unset($_SESSION['message'], $_SESSION['msg_type']);
}

$editOs = null;
if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $result = $conn->query("SELECT * FROM os WHERE id = $id LIMIT 1");
  $editOs = $result->fetch_assoc();
}
?>

<div class="container-fluid py-4">
  <div class="card mb-4">
    <div class="card-header">
      <h5><?php echo $editOs ? "Sửa Hệ Điều Hành" : "Thêm Hệ Điều Hành"; ?></h5>
    </div>
    <div class="card-body">
      <form method="post" action="./controller/os_controller.php">
        <?php if ($editOs): ?>
          <input type="hidden" name="id" value="<?= $editOs['id'] ?>">
        <?php endif; ?>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Tên hệ điều hành</label>
            <input type="text" class="form-control" name="name" value="<?php echo $editOs['name'] ?? '' ?>" placeholder="Nhập tên hệ điều hành">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tình trạng</label>
            <select class="form-select" name="status">
              <option value="1" <?php echo isset($editOs) && $editOs['status'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
              <option value="0" <?php echo isset($editOs) && $editOs['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
            </select>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-success" name="<?php echo $editOs ? 'update' : 'save' ?>"> <?= $editOs ? 'Cập nhật' : 'Lưu' ?></button>
          <?php if ($editOs) { ?>
            <a href="os.php" class="btn btn-secondary">Hủy</a>
          <?php } else { ?>
            <button type="reset" class="btn btn-secondary">Làm mới</button>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Danh sách hệ điều hành -->
  <div class="card">
    <div class="card-header">
      <h5>Danh sách hệ điều hành</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>STT</th>
            <th>Tên hệ điều hành</th>
            <th>Tình trạng</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM os ORDER BY id ASC");
          $stt = 1;
          while ($row = $result->fetch_assoc()) {
            echo "
              <tr>
                <td>{$stt}</td>
                <td>{$row['name']}</td>
                <td><span class='badge " . ($row['status'] ? "bg-success" : "bg-secondary") . "'>"
              . ($row['status'] ? "Hiển thị" : "Ẩn") . "</span></td>
                <td>
                  <a href='os.php?edit={$row['id']}' class='btn btn-sm btn-warning'>Sửa</a>
                  <a href='controller/os_controller.php?delete={$row['id']}'
                     class='btn btn-sm btn-danger'
                     onclick=\"return confirm('Bạn có chắc muốn xóa?')\">Xóa</a>
                </td>
              </tr>";
            $stt++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include 'layouts/footer.php'; ?>