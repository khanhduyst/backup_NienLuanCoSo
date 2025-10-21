<?php include 'layouts/header.php';
include '../app/config.php';
$product = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
  $productID = (int) $_GET['edit'];
  $sqlProduct = "SELECT * FROM products WHERE id = '$productID' LIMIT 1";
  $resultProduct = $conn->query($sqlProduct);
  if ($resultProduct && $resultProduct->num_rows > 0) {
    $product = $resultProduct->fetch_assoc();
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
            window.location.href = 'add_product.php?edit=$productID';
        });
    </script>";

  unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type']);
}

?>



<form action="./controller/products_controller.php" method="POST" enctype="multipart/form-data">
  <div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
      <h4>Thêm / Cập nhật sản phẩm</h4>
      <div>
        <button type="submit" class="btn <?php echo $product ? 'btn-warning' : 'btn-primary' ?>" name="<?php echo $product ? 'update' : 'save' ?>"><?php echo $product ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm' ?></button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header">Thông tin sản phẩm</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Tên sản phẩm</label>
              <input type="hidden" name="productID" value="<?php echo $productID ?>">
              <input type="text" name="name" value="<?php echo $product['name'] ?? '' ?>" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="mb-3">
              <label class="form-label">Loại sản phẩm</label>
              <select name="categories" class="form-select">
                <option value="phone" <?php echo (isset($product['categories']) && $product['categories'] == 'phone') ? 'selected' : '' ?>>Điện Thoại</option>
                <option value="laptop" <?php echo (isset($product['categories']) && $product['categories'] == 'laptop') ? 'selected' : '' ?>>Laptop</option>
                <option value="tablet" <?php echo (isset($product['categories']) && $product['categories'] == 'tablet') ? 'selected' : '' ?>>Tablet</option>
              </select>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Công nghệ màn hình</label>
                <input type="text" name="screen_tech" value="<?php echo $product['screen_technology'] ?? '' ?>" class="form-control" placeholder="VD: Dynamic AMOLED 2X">
              </div>
              <div class="col">
                <label class="form-label">Kích thước màn hình</label>
                <input type="text" name="screen_size" value="<?php echo $product['screen_size'] ?? '' ?>" class="form-control" placeholder="VD: 6.9 inches">
              </div>
            </div>
            <div class="row mt-3">
              <div class="col">
                <label class="form-label">Camera trước</label>
                <textarea name="camera_front" class="form-control" rows="2" placeholder="VD: 12MP f/1.9"><?php echo htmlspecialchars($product['front_camera'] ?? '') ?></textarea>
              </div>
              <div class="col">
                <label class="form-label">Camera sau</label>
                <textarea name="camera_back" class="form-control" rows="2" placeholder="VD: 48MP + 12MP"><?php echo htmlspecialchars($product['rear_camera'] ?? '') ?></textarea>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col">
                <label class="form-label">Dung lượng pin</label>
                <input type="text" name="battery" value="<?php echo $product['battery_capacity'] ?? '' ?>" class="form-control" placeholder="VD: 5000mAh">
              </div>
              <div class="col">
                <label class="form-label">Thẻ SIM</label>
                <input type="text" name="sim" value="<?php echo $product['sim_card'] ?? '' ?>" class="form-control" placeholder="VD: 2 Nano-SIM + eSIM">
              </div>
            </div>
            <div class="mt-3">
              <label class="form-label">Mô tả sản phẩm</label>
              <textarea name="desc" id="editor" rows="6" class="form-control"><?php echo htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>
          </div>
        </div>
      </div>

      
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header">Thông tin khác</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Thương hiệu</label>

              <select name="brand" class="form-select">
                <?php
                $row = $conn->query("SELECT * FROM brands WHERE type = 1 AND status = 0 AND is_delete = 0");
                while ($brands = $row->fetch_assoc()) {
                  $selected = (isset($product) && $product['brand_id'] == $brands['id']) ? 'selected' : '';
                  echo "<option value='{$brands['id']}' $selected>{$brands['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Hệ điều hành</label>
              <select name="os" class="form-select">
                <?php
                $rowOs = $conn->query("SELECT * FROM os WHERE status = 0 AND is_delete = 0");
                while ($os = $rowOs->fetch_assoc()) {
                  $selected = (isset($product) && $product['os_id'] == $os['id']) ? 'selected' : '';
                  echo "<option value='{$os['id']}' $selected>{$os['name']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Trạng Thái</label>
              <select class="form-select" name="status">
                <option value="0" <?php echo isset($product) && $product['status'] == 0 ? 'selected' : '' ?>>Hiển thị</option>
                <option value="1" <?php echo isset($product) && $product['status'] == 1 ? 'selected' : '' ?>>Ẩn</option>
              </select>
            </div>

          </div>
        </div>

        <div class="card">
          <div class="card-header">Hình ảnh</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Ảnh đại diện</label>
              <input type="file" name="anh_chinh" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Ảnh phụ</label>
              <input type="file" name="anh_phu[]" id="anh_phu" class="form-control" multiple>
              <small class="text-muted">Chỉ được chọn tối đa 5 ảnh</small>
              <ul id="preview-list" class="mt-2"></ul>
            </div>
          </div>
        </div>
      </div>
    </div>

</form>
</div>


<div class="modal fade" id="notifyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div id="modalHeader" class="modal-header">
        <h5 class="modal-title" id="modalTitle">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body" id="modalMessage"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <a href="#" id="btnVariant" class="btn btn-success">Thêm biến thể</a>
      </div>
    </div>
  </div>
</div>



<script>
  document.getElementById('anh_phu').addEventListener('change', function() {
    const previewList = document.getElementById('preview-list');
    previewList.innerHTML = '';
    if (this.files.length > 5) {
      alert("Bạn chỉ được chọn tối đa 5 ảnh phụ!");
      this.value = "";
      return;
    }
    for (let i = 0; i < this.files.length; i++) {
      let li = document.createElement('li');
      li.textContent = this.files[i].name;
      previewList.appendChild(li);
    }
  });
</script>

<?php if (isset($_SESSION['modal_message'])): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var modal = new bootstrap.Modal(document.getElementById('notifyModal'));
      document.getElementById("modalTitle").innerHTML = "<?= $_SESSION['modal_title'] ?>";
      document.getElementById("modalMessage").innerHTML = "<?= $_SESSION['modal_message'] ?>";

      let modalHeader = document.getElementById("modalHeader");
      let btnVariant = document.getElementById("btnVariant");

      <?php if ($_SESSION['modal_type'] == "success"): ?>
        modalHeader.classList.add("bg-success", "text-white");
        btnVariant.style.display = "inline-block";
        btnVariant.href = "variants_product.php?product_id=<?= $_SESSION['product_id'] ?>";
      <?php else: ?>
        modalHeader.classList.add("bg-danger", "text-white");
        btnVariant.style.display = "none";
      <?php endif; ?>

      modal.show();
    });
  </script>
  <?php unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type'], $_SESSION['new_product_id']); ?>
<?php endif; ?>


<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace('editor');
</script>

<?php include 'layouts/footer.php'; ?>