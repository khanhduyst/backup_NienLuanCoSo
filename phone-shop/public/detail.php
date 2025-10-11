<?php include('./layouts/header.php');
include '../app/config.php';
?>

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
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
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
    
?>
<div class="container my-4">
    <div class="row g-3">
        <!-- Khung trái -->
        <div class="col-md-8">
            <div class="p-3 bg-white rounded shadow-sm">
                <div class="row">
                    <!-- Ảnh sản phẩm -->
                    <div class="col-md-6">
                        <div id="mainImage" class="mb-3">
                            <img src="assets/img/product/iphone/iphone13.jpg" class="img-fluid border rounded main-img" alt="Sản phẩm chính">
                        </div>
                        <!-- Thumbnail -->
                        <div class="d-flex flex-wrap gap-2">
                            <img src="assets/img/product/iphone/iphone15.jpg" class="thumb border rounded" alt="thumb1">
                            <img src="assets/img/product/iphone/iphone16.png" class="thumb border rounded" alt="thumb2">
                            <img src="assets/img/product/iphone/iphone17.jpg" class="thumb border rounded" alt="thumb3">
                            <img src="assets/img/product/iphone/iphoneAir.jpg" class="thumb border rounded" alt="thumb4">
                        </div>
                    </div>

                    <!-- Thông tin sản phẩm -->
                    <div class="col-md-6">
                        <h4>IPhone 11 Chính Hãng VNA <span class="badge bg-success">Còn Hàng</span></h4>
                        <p>Thương hiệu: <a href="#" class="fw-bold text-primary">Apple</a> | Loại: <a href="#" class="fw-bold text-primary">Apple</a></p>

                        <!-- Giá -->
                        <div class="price-box mb-3">
                            <span class="new-price text-danger fw-bold fs-4">9,745,500đ</span>
                            <span class="old-price text-muted"><del>10,950,000đ</del></span>
                        </div>

                        <!-- Màu sắc -->
                        <div class="mb-3">
                            <label class="fw-bold">Màu sắc: <span id="selectedColor">Chưa chọn</span></label>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-outline-secondary option-btn color-btn" data-color="Đỏ">Đỏ</button>
                                <button class="btn btn-outline-secondary option-btn color-btn" data-color="Vàng">Vàng</button>
                                <button class="btn btn-outline-secondary option-btn color-btn" data-color="Đen">Đen</button>
                                <button class="btn btn-outline-secondary option-btn color-btn" data-color="Trắng">Trắng</button>
                                <button class="btn btn-outline-secondary option-btn color-btn" data-color="Tím">Tím</button>
                                <button class="btn btn-outline-secondary option-btn color-btn" data-color="Xanh">Xanh</button>
                            </div>
                        </div>

                        <!-- Kích thước -->
                        <div class="mb-3">
                            <label class="fw-bold">Kích thước: <span id="selectedSize">Chưa chọn</span></label>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary option-btn size-btn" data-size="64GB">64GB</button>
                                <button class="btn btn-outline-secondary option-btn size-btn" data-size="128GB">128GB</button>
                            </div>
                        </div>

                        <!-- Xuất xứ -->
                        <div class="mb-3">
                            <label class="fw-bold">Xuất xứ:</label>
                            <button class="btn btn-outline-secondary active">VN/A</button>
                        </div>

                        <!-- Số lượng -->
                        <div class="mb-3">
                            <label class="fw-bold">Số lượng: <span id="selectedQty">1</span></label>
                            <div class="quantity-box d-flex align-items-center">
                                <button class="btn btn-sm btn-outline-secondary" id="minusBtn">-</button>
                                <input type="text" id="qtyInput" class="form-control text-center mx-1" value="1" readonly>
                                <button class="btn btn-sm btn-outline-secondary" id="plusBtn">+</button>
                            </div>
                        </div>

                        <!-- Nút thêm giỏ -->
                        <button class="btn btn-danger btn-lg w-100 mt-3">THÊM VÀO GIỎ</button>
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
                        <p>
                            Đây là mô tả demo dành cho tất cả sản phẩm tại riêng website
                            <a href="https://wd-smart.myharavan.com/" target="_blank">https://wd-smart.myharavan.com/</a>
                            / không áp dụng cho theme khách hàng sử dụng
                        </p>

                        <h6 class="fw-bold">Điện thoại iPhone 12 Pro Max giá rẻ tại WD Smart</h6>
                        <p>
                            Như cái tên gọi thì chắc hẳn các bạn cũng biết được
                            <b>iPhone 12 Pro Max</b> chính là mẫu iPhone 12 đắt giá nhất cũng như cao cấp nhất của Apple.
                            Điều này đồng nghĩa với việc chiếc máy này sẽ sở hữu màn hình lớn nhất, công nghệ đỉnh cao nhất,
                            hiện đại nhất mà <b>Apple</b> có thể đưa ra.
                        </p>

                        <img src="assets/img/product/iphone/iphone13.jpg" class="img-fluid rounded mb-3" alt="Mô tả sản phẩm">
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
                                <tr>
                                    <th>Bộ nhớ trong</th>
                                    <td>64/128/256 GB</td>
                                </tr>
                                <tr>
                                    <th>Camera chính</th>
                                    <td>Cảm biến LiDAR, Triple 12Mp + 12Mp + 12Mp</td>
                                </tr>
                                <tr>
                                    <th>Camera phụ</th>
                                    <td>12 MP</td>
                                </tr>
                                <tr>
                                    <th>CPU</th>
                                    <td>Apple A14 Bionic (5nm)</td>
                                </tr>
                                <tr>
                                    <th>Hệ điều hành</th>
                                    <td>iOS 14</td>
                                </tr>
                                <tr>
                                    <th>RAM</th>
                                    <td>6 GB</td>
                                </tr>
                                <tr>
                                    <th>Kết nối</th>
                                    <td>1 eSIM & 1 Nano SIM, Hỗ trợ 5G</td>
                                </tr>
                                <tr>
                                    <th>Màn hình</th>
                                    <td>IPS LCD, Liquid Retina</td>
                                </tr>
                                <tr>
                                    <th>Dung lượng pin</th>
                                    <td>Li-Ion 3687 mAh</td>
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
            mainImg.style.opacity = 0; // mờ đi
            setTimeout(() => {
                mainImg.src = this.src; // đổi hình
                mainImg.style.opacity = 1; // hiện lại
            }, 200);
        });
    });

    // Chọn màu
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedColor').textContent = this.dataset.color;
        });
    });

    // Chọn kích thước
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('selectedSize').textContent = this.dataset.size;
        });
    });

    // Số lượng
    let qtyInput = document.getElementById('qtyInput');
    let selectedQty = document.getElementById('selectedQty');

    document.getElementById('plusBtn').addEventListener('click', () => {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        selectedQty.textContent = qtyInput.value;
    });

    document.getElementById('minusBtn').addEventListener('click', () => {
        if (parseInt(qtyInput.value) > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
            selectedQty.textContent = qtyInput.value;
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