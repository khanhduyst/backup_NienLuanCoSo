<?php include 'layouts/header.php'; ?>
<?php
include '../app/config.php';

if (isset($_SESSION['message'])) { ?>
  <div class="alert alert-<?php echo $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['message'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['message'], $_SESSION['msg_type']); ?>
<?php };

$editBrand = null;
if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $result = $conn->query("SELECT * FROM brands WHERE id = $id LIMIT 1");
  $editBrand = $result->fetch_assoc();
}
?>

<div class="container-fluid py-4">
  <div class="card mb-4">
    <div class="card-header">
      <h5><?php echo $editBrand ? "Sửa Thương hiệu" : "Thêm Thương hiệu" ?></h5>
    </div>
    <div class="card-body">
      <form method="post" action="./controller/brands_controller.php">
        <?php if ($editBrand): ?>
          <input type="hidden" name="id" value="<?= $editBrand['id'] ?>">
        <?php endif; ?>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Tên thương hiệu</label>
            <input type="text" class="form-control" name="name"
              value="<?php echo $editBrand['name'] ?? '' ?>" placeholder="Nhập tên thương hiệu" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Phân loại thương hiệu</label>
            <select class="form-select" name="type">
              <option value="1" <?= isset($editBrand) && $editBrand['type'] == 1 ? 'selected' : '' ?>>Thương hiệu điện thoại</option>
              <option value="0" <?= isset($editBrand) && $editBrand['type'] == 0 ? 'selected' : '' ?>>Thương Hiệu Chip</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Tình trạng</label>
            <select class="form-select" name="status">
              <option value="0" <?= isset($editBrand) && $editBrand['status'] == 0 ? 'selected' : '' ?>>Hiển thị</option>
              <option value="1" <?= isset($editBrand) && $editBrand['status'] == 1 ? 'selected' : '' ?>>Ẩn</option>
            </select>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-success"
            name="<?php echo $editBrand ? 'update' : 'save' ?>">
            <?php echo $editBrand ? 'Cập nhật' : 'Lưu' ?>
          </button>
          <?php if ($editBrand) { ?>
            <a href="brands.php" class="btn btn-secondary">Hủy</a>
          <?php } else { ?>
            <button type="reset" class="btn btn-secondary">Làm mới</button>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Danh sách thương hiệu -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Danh sách thương hiệu</h5>
      <form method="get" class="mb-0">
        <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">Tất cả</option>
          <option value="0" <?= (isset($_GET['type']) && $_GET['type'] == '0') ? 'selected' : '' ?>>Phần loại theo điện thoại</option>
          <option value="1" <?= (isset($_GET['type']) && $_GET['type'] == '1') ? 'selected' : '' ?>>Phân loại theo chip</option>
        </select>
      </form>
    </div>

    <div class="card-body">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th width="5%">STT</th>
            <th width="25%">Tên thương hiệu</th>
            <th width="20%">Loại thương hiệu</th>
            <th width="20%">Tình trạng</th>
            <th width="30%">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $type = $_GET['type'] ?? '';

          $sql = "SELECT * FROM brands WHERE is_delete =0";
          if ($type !== '') {
            $sql .= " WHERE type = $type";
          }
          $sql .= " ORDER BY id DESC";

          $result = $conn->query($sql);

          //$result = $conn->query("SELECT * FROM brands ORDER BY id DESC");
          $stt = 1;
          while ($row = $result->fetch_assoc()) {
            echo "
              <tr>
                <td>{$stt}</td>
                <td>{$row['name']}</td>
                <td><span class='badge " . ($row['type'] ? "bg-danger" : "bg-primary") . "'>"
              . ($row['type'] ? "Thương hiệu điện thoại" : "Thương hiệu chip") . "</span></td>
                <td><span class='badge " . ($row['status'] ? "bg-secondary" : "bg-success") . "'>"
              . ($row['status'] ? "Ẩn" : "Hiển thị") . "</span></td>
                <td>
                  <a href='brands.php?edit={$row['id']}' class='btn btn-sm btn-warning'>Sửa</a>
                  <a href='controller/brands_controller.php?delete={$row['id']}'
                     class='btn btn-sm btn-danger'
                     onclick=\"return confirm('Bạn có chắc muốn xóa?')\">Xóa</a>
                </td>
              </tr>";
            $stt++;
          } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include 'layouts/footer.php'; ?>