<?php
include 'layouts/header.php';

include '../app/config.php';

if (isset($_SESSION['message'])) {
?>
  <div class="alert alert-<?php echo $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['message'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php unset($_SESSION['message'], $_SESSION['msg_type']);
}

$editStorages = null;
if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $result = $conn->query("SELECT * FROM storages WHERE id = $id LIMIT 1");
  $editStorages = $result->fetch_assoc();
}
?>

<div class="container-fluid py-4">

  <!-- Form thêm/sửa Dung lượng -->
  <div class="card mb-4">
    <div class="card-header">
      <h5><?php echo $editStorages ? "Sửa Dung Lượng Bộ Nhớ" : "Thêm Dung Lượng Bộ Nhớ"; ?></h5>
    </div>
    <div class="card-body">
      <form action="./controller/storages_controller.php" method="post">
         <?php if ($editStorages): ?>
          <input type="hidden" name="id" value="<?= $editStorages['id'] ?>">
        <?php endif; ?>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Dung lượng bộ nhớ</label>
             <input type="text" class="form-control" name="size" value="<?php echo $editStorages['size'] ?? '' ?>" placeholder="Ví dụ: 64GB, 128GB, 1TB">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tình trạng</label>
            <select class="form-select" name="status">
              <option value="1" <?php echo isset($editStorages) && $editStorages['status'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
              <option value="0" <?php echo isset($editStorages) && $editStorages['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
            </select>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-success" name="<?php echo $editStorages ? 'update' : 'save' ?>"> <?= $editStorages ? 'Cập nhật' : 'Lưu' ?></button>
          <?php if ($editStorages) { ?>
            <a href="rams.php" class="btn btn-secondary">Hủy</a>
          <?php } else { ?>
            <button type="reset" class="btn btn-secondary">Làm mới</button>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Danh sách Dung lượng -->
  <div class="card">
    <div class="card-header">
      <h5>Danh sách dung lượng</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>STT</th>
            <th>Dung lượng</th>
            <th>Tình trạng</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM storages ORDER BY id ASC");
          $stt = 1;
          while ($row = $result->fetch_assoc()) {
            echo "
              <tr>
            <td>$stt</td>
            <td>{$row['size']}</td>
            <td><span class='badge " . ($row['status'] ? "bg-success" : "bg-secondary") . " '>"
              . ($row['status'] ? "Hiển thị" : "Ẩn") . "</span></td>
            <td>
              <a href='storages.php?edit={$row['id']}' class='btn btn-sm btn-warning'>Sửa</a>
              <a href='controller/storages_controller.php?delete={$row['id']}'
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