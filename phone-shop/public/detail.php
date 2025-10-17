<?php
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    header("Location: ../public/index.php");
    exit;
}
include '../app/config.php';
if (isset($_POST['ram']) && isset($_POST['rom']) && isset($_POST['product_id'])) {
    header('Content-Type: application/json; charset=utf-8');
    $product_id = (int)$_POST['product_id'];
    $ram = $_POST['ram'];
    $rom = $_POST['rom'];

    $sql = "SELECT pv.id AS variant_id, pv.price
            FROM product_variants pv
            INNER JOIN rams r ON pv.ram_id = r.id
            INNER JOIN storages s ON pv.storage_id = s.id
            WHERE pv.product_id = $product_id
            AND pv.is_deleted = 0
            AND r.size = '$ram'
            AND s.size = '$rom'
            LIMIT 1";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'status' => 'success',
            'price' => (int)$row['price'],
            'variant_id' => (int)$row['variant_id']
        ]);
    } else {
        $minPriceQuery = $conn->query("SELECT MIN(price) AS min_price FROM product_variants WHERE product_id = $product_id");
        $minRow = $minPriceQuery->fetch_assoc();
        echo json_encode([
            'status' => 'fallback',
            'price' => (int)$minRow['min_price']
        ]);
    }
    exit;
}
include('./layouts/header.php');
?>

<?php

if (isset($_SESSION['modal_message'])) {
    echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: '" . addslashes($_SESSION['modal_title']) . "',
            html: '" . addslashes($_SESSION['modal_message']) . "',
            timer: 2500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'cart.php';
        });
    </script>";
    unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type']);
}
?>


<style>
    .content-box {
        max-height: 250px;
        /* chiều cao mặc định khi thu gọn */
        overflow: hidden;
        position: relative;
        transition: max-height 0.4s ease;
    }

    /* Khi mở rộng */
    .content-box.expanded {
        max-height: 1000px;
        /* hoặc auto nếu muốn bung hết */
    }

    /* Hiệu ứng mờ cuối đoạn khi thu gọn */
    .content-box::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background: linear-gradient(transparent, white);
        pointer-events: none;
        transition: opacity 0.3s;
    }

    /* Khi expanded thì ẩn lớp phủ mờ */
    .content-box.expanded::after {
        opacity: 0;
    }
</style>
<!--chi tiết sản phẩm -->
<?php
$product_id = $_GET['product_id'];
$sql = "SELECT p.categories AS categori, b.name AS brandName, p.name AS productName FROM products p INNER JOIN brands b ON b.id = p.brand_id INNER JOIN os o ON o.id = p.os_id INNER JOIN product_variants pv ON pv.product_id = p.id WHERE p.id = $product_id";
$crumb = $conn->query($sql);
if ($crumb->num_rows > 0) {
    $crumb = $crumb->fetch_assoc();
?>

    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#"><?php echo "{$crumb['categori']}" ?></a></li>
                <li class="breadcrumb-item"><a href="#"><?php echo "{$crumb['brandName']}" ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo "{$crumb['productName']}" ?></li>
            </ol>
        </nav>
    </div>
<?php } else {
    echo "<script></script>";
} ?>
<?php
$sql = "";
?>
<div class="container my-4">
    <form action="./controllers/cart_controller.php" id="addToCartForm" method="post">
        <div class="row g-3">
            <!-- Khung trái -->
            <div class="col-md-8">
                <div class="p-3 bg-white rounded shadow-sm">
                    <div class="row">
                        <!-- Ảnh sản phẩm -->
                        <?php
                        $idProduct = $_GET['product_id'];
                        $queryProduct = "SELECT p.id AS product_id, p.name AS product_name, p.img_main AS img_main, pi.image_url
                    FROM products p  INNER JOIN product_images pi ON pi.product_id = p.id WHERE product_id = $idProduct";
                        $productImg = $conn->query($queryProduct)->fetch_assoc();
                        ?>
                        <div class="col-md-6">
                            <div id="mainImage" class="mb-3">
                                <img src="assets/img/product/<?php echo $productImg['img_main'] ?>" class="img-fluid rounded main-img" alt="Sản phẩm <?php echo $productImg['product_name'] ?>">
                            </div>
                            <!-- Thumbnail -->
                            <div class="d-flex flex-wrap gap-2">
                                <?php
                                $queryProduct_img = $conn->query($queryProduct);
                                while ($productImgs = $queryProduct_img->fetch_assoc()) {
                                    echo "<img src='assets/img/product/{$productImgs['image_url']}' class='thumb rounded' alt='Sản phẩm {$productImgs['product_name']}'>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Thông tin sản phẩm -->
                        <div class="col-md-6">
                            <?php
                            $idProduct = $_GET['product_id'];
                            $queryProduct = "SELECT p.id AS product_id, p.name AS product_name, b.name AS brand_name, p.categories AS product_cate, MIN(pv.price) AS price
                                FROM products p  
                                INNER JOIN product_variants pv ON pv.product_id = p.id
                                INNER JOIN brands b ON b.id = p.brand_id 
                                WHERE p.id = $idProduct 
                                GROUP BY p.id";

                            $product = $conn->query($queryProduct)->fetch_assoc();
                            ?>
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id'] ?>">
                            <h4><?php echo $product['product_name'] ?> <span class="badge bg-success">Còn Hàng</span></h4>
                            <p>Thương hiệu: <a href="#" class="fw-bold text-primary"><?php echo $product['brand_name'] ?></a> | Loại: <a href="#" class="fw-bold text-primary"><?php echo $product['product_cate'] ?></a></p>
                            <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">

                            <!-- Giá -->
                            <div class="price-box mb-3">
                                <span class="new-price text-danger fw-bold fs-4"><?php echo number_format($product['price'], 0, ',', '.') ?>đ</span>
                                <span class="old-price text-muted"><del><?php echo number_format($product['price'] + 10000000, 0, ',', '.') ?>đ</del></span>
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                            </div>

                            <!-- Màu sắc -->
                            <div class="mb-3">
                                <?php
                                $idProduct = $_GET['product_id'];
                                $queryProduct = "SELECT DISTINCT p.id AS product_id, p.name AS product_name, c.name AS colorName
                                FROM products p  INNER JOIN product_variants pv ON pv.product_id = p.id
                                INNER JOIN colors c ON c.id = pv.color_id WHERE product_id = $idProduct";
                                $product = $conn->query($queryProduct);
                                ?>
                                <label class="fw-bold">Màu sắc: <span id="selectedColor">Chưa chọn</span></label>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php while ($items = $product->fetch_assoc()) { ?>
                                        <button type='button' class='btn btn-outline-secondary option-btn color-btn' data-color='<?php echo $items['colorName']; ?>'>
                                            <?php echo $items['colorName']; ?>
                                        </button>
                                    <?php } ?>
                                    <input type="hidden" name="color" id="colorInput" value="">
                                </div>

                            </div>
                            <!-- ram -->
                            <div class="mb-3">
                                <?php
                                $idProduct = $_GET['product_id'];
                                $queryRam = "SELECT DISTINCT p.id AS product_id, p.name AS product_name, r.size AS ramName
                                    FROM products p  INNER JOIN product_variants pv ON pv.product_id = p.id
                                    INNER JOIN rams r ON r.id = pv.ram_id WHERE product_id = $idProduct AND pv.is_deleted = 0";
                                $productRam = $conn->query($queryRam);
                                ?>
                                <label class="fw-bold">Kích thước(ram): <span id="selectedSize">Chưa chọn</span></label>
                                </br>
                                <div class="d-flex gap-2">
                                    <?php
                                    while ($productRams = $productRam->fetch_assoc()) {
                                        echo " <button type='button' class='btn btn-outline-secondary option-btn size-btn' data-size='{$productRams['ramName']}'>{$productRams['ramName']}</button>";
                                    }
                                    ?>
                                    <input type="hidden" name="ram" id="ramInput">
                                </div>
                            </div>
                            <!-- rom -->
                            <div class="mb-3">
                                <?php
                                $idProduct = $_GET['product_id'];
                                $queryRom = "SELECT DISTINCT p.id AS product_id, p.name AS product_name, s.size AS romName
                                FROM products p  INNER JOIN product_variants pv ON pv.product_id = p.id
                                INNER JOIN storages s ON s.id = pv.storage_id WHERE product_id = $idProduct AND pv.is_deleted = 0";
                                $productRom = $conn->query($queryRom);
                                ?>
                                <label class="fw-bold">Kích thước(ram): <span id="selectedRom">Chưa chọn</span></label>
                                <div class="d-flex gap-2">
                                    <?php
                                    while ($productRoms = $productRom->fetch_assoc()) {
                                        echo " <button type='button' class='btn btn-outline-secondary option-btn rom-btn' data-rom='{$productRoms['romName']}'>{$productRoms['romName']}</button>";
                                    }
                                    ?>
                                    <input type="hidden" name="rom" id="romInput">
                                </div>
                            </div>

                            <!-- Số lượng -->
                            <!-- <div class="mb-3">
                            <label class="fw-bold">Số lượng: <span id="selectedQty">1</span></label>
                            <div class="quantity-box d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-secondary" id="minusBtn">-</button>
                                <input type="text" id="qtyInput" class="form-control text-center mx-1" value="1" readonly>
                                <button class="btn btn-sm btn-outline-secondary" id="plusBtn">+</button>
                            </div>
                        </div> -->

                            <!-- Nút thêm giỏ -->
                            <button type="submit" class="btn btn-danger btn-lg w-100 mt-3" name="add_to_cart">THÊM VÀO GIỎ</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Khung phải -->
            <div class="col-md-4">
                <div class="p-3 bg-white rounded shadow-sm">
                    <!-- Cam kết bán hàng -->
                    <div class="card mb-3 border-success">
                        <div class="card-header bg-success text-white fw-bold">Cam kết bán hàng</div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Hàng chính hãng. Nguồn gốc rõ ràng</li>
                                <li class="mb-2"><i class="bi bi-gift-fill text-success me-2"></i> Tặng máy nếu phát hiện máy sửa chữa</li>
                                <li class="mb-2"><i class="bi bi-truck text-success me-2"></i> Giao hàng ngay (nội thành TPHCM)</li>
                                <li><i class="bi bi-shield-check text-success me-2"></i> Dùng thử 7 ngày miễn phí</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Ưu đãi -->
                    <div class="card border-success">
                        <div class="card-header bg-success text-white fw-bold">Ưu đãi</div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Giảm thêm tới 1% cho thành viên Smember</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Bảo vệ sản phẩm toàn diện với dịch vụ bảo hành mở rộng</li>
                                <li class="mb-2"><i class="bi bi-credit-card-2-front text-danger me-2"></i> Ưu đãi đến 800k khi mở thẻ VP Bank</li>
                                <li class="mb-2"><i class="bi bi-percent text-danger me-2"></i> Giảm thêm 5% tối đa 500.000đ khi thanh toán qua Kredivo</li>
                                <li class="mb-2"><i class="bi bi-gift text-primary me-2"></i> Mở thẻ tín dụng VIB - Nhận voucher 200.000đ</li>
                                <li><i class="bi bi-cash-stack text-success me-2"></i> Thu cũ đổi mới: Giá thu cao - Thủ tục nhanh chóng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container my-4">
    <div class="row g-3">
        <!-- Mô tả sản phẩm -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold bg-white">
                    MÔ TẢ SẢN PHẨM
                </div>
                <div class="card-body">
                    <div class="content-box" id="descBox">
                        <?php
                        $idProduct = $_GET['product_id'];
                        $queryProduct_des = "SELECT description FROM products WHERE id = $idProduct";
                        $product_des = $conn->query($queryProduct_des)->fetch_assoc();
                        echo $product_des['description'];
                        ?>
                    </div>
                    <button class="btn btn-light w-100 toggle-btn" data-target="descBox">
                        <i class="bi bi-plus-circle"></i> Xem thêm
                    </button>
                </div>
            </div>
        </div>

        <!-- Thông số kỹ thuật -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold bg-white">
                    THÔNG SỐ KỸ THUẬT
                </div>
                <div class="card-body p-0">
                    <div class="content-box" id="specBox">
                        <table class="table mb-0">
                            <tbody>
                                <?php
                                $idProduct = (int)$_GET['product_id'];
                                $query_rom = "SELECT DISTINCT s.size AS rom FROM product_variants pv INNER JOIN storages s ON s.id = pv.storage_id WHERE pv.product_id = $idProduct ";
                                $query_product_rom = $conn->query($query_rom);
                                $roms = [];
                                while ($itemRoms = $query_product_rom->fetch_assoc()) {
                                    $roms[] = $itemRoms['rom'];
                                }
                                $rom_list = implode(' / ', $roms);
                                ?>
                                <tr>
                                    <th>Bộ nhớ trong</th>
                                    <td><?php echo $rom_list ?></td>
                                </tr>
                                <?php
                                $query_product_varian = "SELECT DISTINCT p.id AS product_id, p.front_camera AS front_camera, p.rear_camera AS rear_camera, o.name AS os, p.sim_card AS sim, p.screen_size AS screen_size, p.battery_capacity AS battery_capacity
                                FROM products p  INNER JOIN product_variants pv ON pv.product_id = p.id
                                INNER JOIN brands b ON b.id = p.brand_id
                                INNER JOIN colors c ON c.id = pv.color_id
                                INNER JOIN os o ON o.id = p.os_id;";
                                $product_varians = $conn->query($query_product_varian)->fetch_assoc();
                                ?>
                                <tr>
                                    <th>Camera trước</th>
                                    <td><?php echo $product_varians['front_camera'] ?></td>
                                </tr>
                                <tr>
                                    <th>Camera sau</th>
                                    <td><?php echo $product_varians['rear_camera'] ?></td>
                                </tr>
                                <!-- <tr>
                                    <th>CPU</th>
                                    <td>Apple A14 Bionic (5nm)</td>
                                </tr> -->
                                <tr>
                                    <th>Hệ điều hành</th>
                                    <td><?php echo $product_varians['os'] ?></td>
                                </tr>
                                <tr>
                                    <?php
                                    $idProduct = (int)$_GET['product_id'];
                                    $query_ram = "SELECT DISTINCT r.size AS ram FROM product_variants pv INNER JOIN rams r ON r.id = pv.ram_id WHERE pv.product_id = $idProduct ";
                                    $query_product_ram = $conn->query($query_ram);
                                    $Rams = [];
                                    while ($itemRams = $query_product_ram->fetch_assoc()) {
                                        $Rams[] = $itemRams['ram'];
                                    }
                                    $rom_list = implode(' / ', $Rams);
                                    ?>
                                    <th>RAM</th>
                                    <td><?php echo $rom_list ?></td>
                                </tr>
                                <tr>
                                    <th>Kết nối</th>
                                    <td><?php echo $product_varians['sim'] ?></td>
                                </tr>
                                <tr>
                                    <th>Màn hình</th>
                                    <td><?php echo $product_varians['screen_size'] ?></td>
                                </tr>
                                <tr>
                                    <th>Dung lượng pin</th>
                                    <td><?php echo $product_varians['battery_capacity'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <button class="btn btn-light w-100 toggle-btn" data-target="specBox">
                            <i class="bi bi-plus-circle"></i> Xem thêm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.querySelectorAll('.thumb').forEach(img => {
        img.addEventListener('click', function() {
            let mainImg = document.querySelector('.main-img');
            mainImg.style.opacity = 0;
            setTimeout(() => {
                mainImg.src = this.src;
                mainImg.style.opacity = 1;
            }, 200);
        });
    });

    function updatePrice() {
        const productId = <?php echo $idProduct; ?>;
        const ram = document.getElementById('ramInput').value;
        const rom = document.getElementById('romInput').value;

        if (!ram || !rom) return;

        fetch('detail.php?product_id=<?php echo $idProduct; ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `product_id=${productId}&ram=${ram}&rom=${rom}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.querySelector('.new-price').textContent =
                        new Intl.NumberFormat('vi-VN').format(data.price) + 'đ';
                    document.querySelector('.old-price del').textContent =
                        new Intl.NumberFormat('vi-VN').format(data.price + 1000000) + 'đ';
                    const priceInput = document.querySelector('input[name="price"]');

                    if (priceInput) {
                        priceInput.value = data.price;
                    }
                    if (document.getElementById('variantId')) {
                        document.getElementById('variantId').value = data.variant_id;
                    }
                }
            })
            .catch(err => console.error('Lỗi khi lấy giá:', err));
    }



    // Chọn màu
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedColor').textContent = this.dataset.color;
            document.getElementById('colorInput').value = this.dataset.color;
        });
    });

    // Chọn kích thước
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedSize').textContent = this.dataset.size;
            document.getElementById('ramInput').value = this.dataset.size;
            updatePrice();
        });
    });

    // Chọn dung lượng
    document.querySelectorAll('.rom-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.rom-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedRom').textContent = this.dataset.rom;
            document.getElementById('romInput').value = this.dataset.rom;
            updatePrice();
        });
    });
    // document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    //     if (!document.getElementById('ramInput').value || !document.getElementById('romInput').value) {
    //         e.preventDefault();
    //         alert('Vui lòng chọn RAM và ROM trước khi thêm vào giỏ hàng!');
    //     }
    // });

    // Số lượng
    // let qtyInput = document.getElementById('qtyInput');
    // let selectedQty = document.getElementById('selectedQty');

    // document.getElementById('plusBtn').addEventListener('click', () => {
    //     qtyInput.value = parseInt(qtyInput.value) + 1;
    //     selectedQty.textContent = qtyInput.value;
    // });

    // document.getElementById('minusBtn').addEventListener('click', () => {
    //     if (parseInt(qtyInput.value) > 1) {
    //         qtyInput.value = parseInt(qtyInput.value) - 1;
    //         selectedQty.textContent = qtyInput.value;
    //     }
    // });

    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        const color = document.getElementById('colorInput').value;
        const ram = document.getElementById('ramInput').value;
        const rom = document.getElementById('romInput').value;

        if (!color || !ram || !rom) {
            e.preventDefault();
            let missing = [];
            if (!color) missing.push("Màu sắc");
            if (!ram) missing.push("RAM");
            if (!rom) missing.push("ROM");

            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin sản phẩm!',
                html: 'Vui lòng chọn: <b>' + missing.join(', ') + '</b> trước khi thêm vào giỏ hàng.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Đã hiểu'
            });
        }
    });

    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const box = document.getElementById(targetId);

            box.classList.toggle('expanded');

            if (box.classList.contains('expanded')) {
                this.innerHTML = '<i class="bi bi-dash-circle"></i> Thu gọn';
            } else {
                this.innerHTML = '<i class="bi bi-plus-circle"></i> Xem thêm';
            }
        });
    });
</script>

<?php include('./layouts/footer.php') ?>