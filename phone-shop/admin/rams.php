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

$editRams = null;
if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $result = $conn->query("SELECT * FROM rams WHERE id = $id LIMIT 1");
  $editRams = $result->fetch_assoc();
}

?>
<div class="container-fluid py-4">

  <!-- Form thêm/sửa RAM -->
  <div class="card mb-4">
    <div class="card-header">
      <h5><?php echo $editRams ? "Sửa Ram" : "Thêm Ram"; ?></h5>
    </div>
    <div class="card-body">
      <form action="./controller/rams_controller.php" method="post">
        <?php if ($editRams): ?>
          <input type="hidden" name="id" value="<?= $editRams['id'] ?>">
        <?php endif; ?>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Dung lượng RAM</label>
            <input type="text" class="form-control" name="size" value="<?php echo $editRams['size'] ?? '' ?>" placeholder="Ví dụ: 4GB, 6GB, 8GB">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tình trạng</label>
             <select class="form-select" name="status">
              <option value="1" <?php echo isset($editRams) && $editRams['status'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
              <option value="0" <?php echo isset($editRams) && $editRams['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
            </select>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-success" name="<?php echo $editRams ? 'update' : 'save' ?>"> <?= $editRams ? 'Cập nhật' : 'Lưu' ?></button>
          <?php if ($editRams) { ?>
            <a href="rams.php" class="btn btn-secondary">Hủy</a>
          <?php } else { ?>
            <button type="reset" class="btn btn-secondary">Làm mới</button>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Danh sách RAM -->
  <div class="card">
    <div class="card-header">
      <h5>Danh sách RAM</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>STT</th>
            <th>Dung lượng RAM</th>
            <th>Tình trạng</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM rams ORDER BY id ASC");
          $stt = 1;
          while ($row = $result->fetch_assoc()) {
            echo "
              <tr>
            <td>$stt</td>
            <td>{$row['size']}</td>
            <td><span class='badge " . ($row['status'] ? "bg-success" : "bg-secondary") . " '>"
              . ($row['status'] ? "Hiển thị" : "Ẩn") . "</span></td>
            <td>
              <a href='rams.php?edit={$row['id']}' class='btn btn-sm btn-warning'>Sửa</a>
              <a href='controller/rams_controller.php?delete={$row['id']}'
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