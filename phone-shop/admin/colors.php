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

$editColor = null;
if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $result = $conn->query("SELECT * FROM colors WHERE id = $id LIMIT 1");
  $editColor = $result->fetch_assoc();
}

?>

<div class="container-fluid py-4">

  <!-- Form thêm/sửa màu sắc -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Thêm / Sửa Màu sắc</h5>
    </div>
    <div class="card-body">
      <form action="./controller/colors_controller.php" method="post">
        <?php if ($editColor): ?>
          <input type="hidden" name="id" value="<?= $editColor['id'] ?>">
        <?php endif; ?>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Tên màu</label>
            <input type="text" class="form-control" name="name" value="<?php echo $editColor['name'] ?? '' ?>" placeholder="Ví dụ: Đỏ, Xanh, Trắng">
          </div>
          <div class="col-md-4">
            <label class="form-label">Chọn màu</label>
            <input type="color" class="form-control form-control-color" name="code" value="<?php echo $editColor['code'] ?? '#ff0000' ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label">Tình trạng</label>
            <select class="form-select" name="status">
              <option value="0" <?php echo isset($editColor) && $editColor['status'] == 0 ? 'selected' : '' ?>>Hiển thị</option>
              <option value="1" <?php echo isset($editColor) && $editColor['status'] == 1 ? 'selected' : '' ?>>Ẩn</option>
            </select>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-success" name="<?php echo $editColor ? 'update' : 'save' ?>"> <?= $editColor ? 'Cập nhật' : 'Lưu' ?></button>
          <?php if ($editColor) { ?>
            <a href="collors.php" class="btn btn-secondary">Hủy</a>
          <?php } else { ?>
            <button type="reset" class="btn btn-secondary">Làm mới</button>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Danh sách màu sắc -->
  <div class="card">
    <div class="card-header">
      <h5>Danh sách màu sắc</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>STT</th>
            <th>Tên màu</th>
            <th>Mã màu</th>
            <th>Tình trạng</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <!-- Dữ liệu mẫu -->
          <?php
          $result = $conn->query("SELECT * FROM colors WHERE is_delete =0 ORDER BY id ASC");
          $stt = 1;
          while ($row = $result->fetch_assoc()) {
            echo "
              <tr>
            <td>$stt</td>
            <td>{$row['name']}</td>
             <td>
              <div style='display:flex; align-items:center; gap:8px;'>
                <span style='width:20px; height:20px; background:{$row['code']}; display:inline-block; border:1px solid #ccc;'></span>
                {$row['code']}
              </div>
            </td>
            <td><span class='badge " . ($row['status'] ? "bg-secondary" : "bg-success") . " '>"
              . ($row['status'] ? "Ẩn" : "Hiển thị") . "</span></td>
            <td>
              <a href='colors.php?edit={$row['id']}' class='btn btn-sm btn-warning'>Sửa</a>
              <a href='controller/colors_controller.php?delete={$row['id']}'
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