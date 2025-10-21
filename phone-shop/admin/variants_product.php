<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

include 'layouts/header.php';
include '../app/config.php';

$editVariants = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $result = $conn->query("SELECT * FROM product_variants WHERE id = $id");
    $editVariants = $result->fetch_assoc();
}

?>

<div class="container-fluid px-4">
    <h4 class="mt-4 mb-3">Thêm biến thể sản phẩm</h4>

    <!-- tìm kiếm -->
    <form action="./controller/variants_controller.php" method="post">
        <div class="input-group mb-4">
            <input type="text" class="form-control" name="search" placeholder="Nhập tên hoặc ID sản phẩm...">
            <button class="btn btn-primary" name="find_product" type="submit">Tìm kiếm</button>
        </div>
    </form>

    <!-- load thông tin sản phẩm -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex align-items-center">
            <?php
            if (isset($_GET['product_id'])  && is_numeric($_GET['product_id'])) {
                $product_id = (int)$_GET['product_id'];
                $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
                if ($result && $result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        echo "
                        <img src='../public/assets/img/product/{$product['img_main']}' alt='hinh san pham {$product['name']}' width='80' class='me-3 rounded'>
                        <div>
                            <h5 class='mb-1'>{$product['name']}</h5>
                            <small>Mã SP: {$product['id']}</small>
                        </div>";
                    }
                } else {
                    echo "<b style='color:red;'>Không tìm thấy sản phẩm với ID = $product_id</b>";
                }
            } else {
                echo "<b style ='color: red;'>CHƯA CÓ THÔNG TIN</b>";
            }
            ?>
        </div>
    </div>

    <!-- thêm biến thể -->
    <form action="./controller/variants_controller.php" method="POST">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Thông tin biến thể
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <?php
                        $product_iid = $_GET['product_id'] ?? '';
                        $variant_id = $_GET['edit'] ?? '';
                        ?>
                        <input type="hidden" name="getid" value="<?php echo "$product_iid"; ?>">
                        <input type="hidden" name="variantid" value="<?php echo "$variant_id"; ?>">
                        <label class="form-label">Màu sắc</label>
                        <select name="color" class="form-select">
                            <?php
                            if (isset($_GET['product_id'])) {
                                echo "<option value=''>-- Chọn màu --</option>";
                                if (isset($_GET['edit']) && $editVariants) {
                                    $colors = $conn->query("SELECT * FROM colors WHERE status = 0");
                                } else {
                                    $colors = $conn->query("SELECT * FROM colors WHERE status = 0 AND is_delete = 0");
                                }
                                if ($colors && $colors->num_rows > 0) {
                                    while ($row = $colors->fetch_assoc()) {
                                        $selected = ($editVariants && $editVariants['color_id'] == $row['id']) ? 'selected' : '';
                                        $label = $row['is_delete'] ? "{$row['name']} (Đã xóa)" : $row['name'];
                                        echo "<option value='{$row['id']}' $selected>$label</option>";
                                    }
                                } else {
                                    echo "<option disabled>Không có màu khả dụng</option>";
                                }
                            } else {
                                echo "<option value=''>-- Chọn màu --</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">RAM</label>
                        <select name="ram" class="form-select">
                            <?php
                            if (isset($_GET['product_id'])) {
                                echo "<option value=''>-- Chọn RAM --</option>";

                                if (isset($_GET['edit']) && $editVariants) {
                                    $ram = $conn->query("SELECT * FROM rams WHERE status = 0");
                                } else {
                                    $ram = $conn->query("SELECT * FROM rams WHERE status = 0 AND is_delete = 0");
                                }
                                if ($ram && $ram->num_rows > 0) {
                                    while ($row = $ram->fetch_assoc()) {
                                        $selected = ($editVariants && $editVariants['ram_id'] == $row['id']) ? 'selected' : '';
                                        $label = $row['is_delete'] ? "{$row['size']} (Đã xóa)" : $row['size'];

                                        echo "<option value='{$row['id']}' $selected>$label</option>";
                                    }
                                } else {
                                    echo "<option disabled>Không có RAM khả dụng</option>";
                                }
                            } else {
                                echo "<option value=''>-- Chọn RAM --</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bộ nhớ (ROM/Storage)</label>
                        <select name="storage" class="form-select">
                            <?php
                            if (isset($_GET['product_id'])) {
                                echo "<option value=''>-- Chọn Storage --</option>";
                                if (isset($_GET['edit']) && $editVariants) {
                                    $storage = $conn->query("SELECT * FROM storages WHERE status = 0");
                                } else {
                                    $storage = $conn->query("SELECT * FROM storages WHERE status = 0 AND is_delete = 0");
                                }
                                if ($storage && $storage->num_rows > 0) {
                                    while ($row = $storage->fetch_assoc()) {
                                        $selected = ($editVariants && $editVariants['storage_id'] == $row['id']) ? 'selected' : '';
                                        echo "<option value='{$row['id']}' $selected>{$row['size']}</option>";
                                    }
                                } else {
                                    echo "<option disabled>Không có dữ liệu</option>";
                                }
                            } else {
                                echo "<option value=''>-- Chọn Storage --</option>";
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" value="<?php echo (int)$editVariants['price']; ?>" placeholder="Nhập giá" step="1000" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" name="quantity" value="<?php echo $editVariants['quantity'] ?>" placeholder="Nhập số lượng">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="0" <?php echo isset($editVariants) && $editVariants['status'] == 0 ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="1" <?php echo isset($editVariants) && $editVariants['status'] == 1 ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn <?php echo $editVariants ? 'btn-warning' : 'btn-success' ?>" name="<?php echo $editVariants ? 'update' : 'save' ?>"> <?= $editVariants ? 'Cập nhật biên thể' : 'Lưu biên thể' ?></button>

            </div>
        </div>
    </form>


    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">

            <?php
            if (isset($_GET['product_id'])  && is_numeric($_GET['product_id'])) {
                $product_id = (int)$_GET['product_id'];
                $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
                if ($result && $result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        echo "Danh sách biến thể - <b>{$product['name']}</b>";
                    }
                } else {
                    echo "Danh sách biến thể";
                }
            } else {
                echo "Danh sách biến thể";
            }
            ?>


        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Màu sắc</th>
                        <th>RAM</th>
                        <th>ROM</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['product_id'])) {
                        $idProduct = $_GET['product_id'];
                        $result = $conn->query("SELECT products.id AS product_id, product_variants.id AS variants_id, colors.name AS color_name, rams.size AS ram_name, storages.size AS rom_name, product_variants.price AS price, product_variants.quantity AS qty, product_variants.status AS status
                                FROM products 
                                INNER JOIN product_variants ON products.id = product_variants.product_id 
                                INNER JOIN rams ON product_variants.ram_id = rams.id
                                INNER JOIN storages ON product_variants.storage_id = storages.id
                                INNER JOIN colors ON product_variants.color_id = colors.id
                                WHERE products.id = $idProduct AND product_variants.is_deleted = 0 OR product_variants.is_deleted IS NULL ORDER BY colors.name ASC");
                        $product_id_del = (int)$_GET['product_id'] ?? 0;
                        $stt = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "
                               <tr>
                                    <td>$stt</td>
                                    <td>{$row['color_name']}</td>
                                    <td>{$row['ram_name']}</td>
                                    <td>{$row['rom_name']}</td>
                                    <td>" . number_format($row['price'], 0, ',', '.') . " ₫</td>
                                    <td>{$row['qty']}</td>
                                    <td><span class='badge " . ($row['status'] ? "bg-secondary" : "bg-success") . "'>" . ($row['status'] ? 'Ẩn' : 'Hiển thị') . "</span></td>
                                    <td>
                                        <a href='variants_product.php?product_id={$row['product_id']}&edit={$row['variants_id']}' class='btn btn-sm btn-warning'>Sửa</a>
                                        <button type='button' class='btn btn-sm btn-danger'data-bs-toggle='modal' data-bs-target='#confirmDeleteModal' data-id='{$row['variants_id']}' data-product='$product_id_del'>Xoá</button>
                                    </td>
                                </tr>
                            ";
                            $stt++;
                        }
                    } else {
                        echo "<tr><td colspan='8' class ='text-center'><b style='color:red;'>Chưa có dữ liệu</b></td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal thông báo -->
<div class="modal fade" id="notifyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">
                <h5 class="modal-title" id="modalTitle"></h5>s
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalMessage"></div>
            <div class="modal-footer">
                <input type="hidden" id="btnVariant"></input>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal xoá thuộc tính-->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xoá</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xoá biến thể này không?<br>
                Hành động này không thể hoàn tác.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <form method="POST" action="./controller/variants_controller.php">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <input type="hidden" name="product_id" id="product_id">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">Xoá</button>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Modal hiển thị thông báo -->


<?php if (isset($_SESSION['modal_message'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.getElementById('notifyModal'));
            document.getElementById("modalTitle").innerHTML = "<?= $_SESSION['modal_title'] ?>";
            document.getElementById("modalMessage").innerHTML = "<?= $_SESSION['modal_message'] ?>";

            const modalHeader = document.getElementById("modalHeader");
            const btnVariant = document.getElementById("btnVariant");

            <?php if ($_SESSION['modal_type'] === "success"): ?>
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
    <?php unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type'], $_SESSION['product_id']); ?>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('confirmDeleteModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const variantId = button.getAttribute('data-id');
            const productId = button.getAttribute('data-product');

            modal.querySelector('#delete_id').value = variantId;
            modal.querySelector('#product_id').value = productId;
        });
    });
</script>



<?php include 'layouts/footer.php'; ?>