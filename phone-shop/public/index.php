<?php
include '../app/config.php';
?>
<?php include "layouts/header.php" ?>
<div class="container slide_ads">
    <!-- Slide quảng cáo -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner rounded">
            <div class="carousel-item active">
                <img src="./assets/img/banner/banner_ads/ads1.jpg" class="d-block w-100" alt="ddddd">
            </div>
            <div class="carousel-item">
                <img src="./assets/img/banner/banner_ads/ads2.jpg" class="d-block w-100" alt="ssss">
            </div>
        </div>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1"></button>
        </div>

        </button>
    </div>

</div>
<!-- Slide quảng cáo dưới -->
<div class="container slide_ads-bottom my-4 rounded">
    <div class="row">
        <div class="col">
            <a href="">
                <img src="./assets/img/banner/banner_ads/ads1.jpg" class="ads_bottom-img my-3 rounded" alt="" srcset="">
            </a>
        </div>
        <div class="col">
            <a href="">
                <img src="./assets/img/banner/banner_ads/ads2.jpg" class="ads_bottom-img my-3 rounded" alt="" srcset="">
            </a>
        </div>
        <div class="col">
            <a href="">
                <img src="./assets/img/banner/banner_ads/ads3.jpg" class="ads_bottom-img my-3 rounded" alt="" srcset="">
            </a>
        </div>
    </div>
</div>

<!-- Sản phẩm -->
<?php
$result = $conn->query("SELECT products.id AS idProduct, products.name AS name, products.img_main AS img, products.status AS status, MAX(product_variants.price) AS maxPrice, MIN(product_variants.price) AS minPrice FROM products INNER JOIN product_variants ON product_variants.product_id = products.id WHERE (brand_id = 17 or name LIKE '%iPhone%') AND products.status = 0 AND products.is_delete =0 GROUP BY 
        products.id, products.name, products.img_main LIMIT 5");
if ($result && $result->num_rows > 0) {
?>
    <div class="container product py-4 rounded">
        <div class="my-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <!-- Bên trái tên-->
                <h5 class="mb-0 fw-bold border-start border-3 ps-2 me-4">IPHONE</h5>

                <!-- Bên phải Tag-->
                <div class="d-flex gap-2 flex-wrap">
                    <a href="#" class="btn btn-sm btn-light">iPhone 14 Series</a>
                    <a href="#" class="btn btn-sm btn-light">iPhone 13 Series</a>
                    <a href="#" class="btn btn-sm btn-light">iPhone 12 Series</a>
                    <a href="#" class="btn btn-sm btn-light">iPhone 11 Series</a>
                    <a href="#" class="btn btn-sm btn-light">iPhone XS/XS MAX</a>
                    <a href="#" class="btn btn-sm btn-light">iPhone X Series</a>
                    <a href="#" class="btn btn-sm btn-light">iPhone 8 Series</a>
                </div>
            </div>
        </div>


    <?php echo "<div class='row row-cols-2 row-cols-md-5 g-4'>";
    while ($items = $result->fetch_assoc()) {
        echo "
                <div class='col'>
                        <div class='card h-100'>
                            <a href='detail.php?product_id={$items['idProduct']}'>
                                <img src='assets/img/product/{$items['img']}' class='card-img-top' alt='{$items['name']}'>
                                <div class='card-body'>
                                    <h5 class='card-title title'>{$items['name']}</h5>
                                    <div class='price-box'>
                                        <span class='new-price'>" . number_format($items['maxPrice'], 0, ',', '.') . " ₫</span>                                
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>";
    }
    echo "</div>
            <div class='d-flex justify-content-center my-4'>
                <a href='./products.php?brand=iphone' class='btn btn-primary'>Xem tất cả >></a>
            </div>
        
</div>
            ";
} else {
}
    ?>

    <?php
    $result = $conn->query("SELECT products.id AS idProduct, products.name AS name, products.img_main AS img, products.status AS status, MAX(product_variants.price) AS maxPrice, MIN(product_variants.price) AS minPrice FROM products INNER JOIN product_variants ON product_variants.product_id = products.id WHERE (brand_id = 15 or name LIKE '%samsung%') AND products.status =0  AND products.is_delete =0 GROUP BY 
        products.id, products.name, products.img_main LIMIT 5");
    if ($result && $result->num_rows > 0) {
    ?>

        <div class="container product py-4 rounded">

            <div class="my-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <!-- Bên trái tên-->
                    <h5 class="mb-0 fw-bold border-start border-3 ps-2 me-4">SAMSUNG</h5>

                    <!-- Bên phải Tag-->
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="#" class="btn btn-sm btn-light">Galaxy AI</a>
                        <a href="#" class="btn btn-sm btn-light">Galaxy S25 series</a>
                        <a href="#" class="btn btn-sm btn-light">Galaxy Z (Màn hình gập)</a>
                        <a href="#" class="btn btn-sm btn-light">Galaxy S</a>
                        <a href="#" class="btn btn-sm btn-light">Galaxy A</a>
                    </div>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-md-5 g-4">
                <?php
                while ($items = $result->fetch_assoc()) {
                    echo "
                        <div class='col'>
                                <div class='card h-100'>
                                    <a href='detail.php?product_id={$items['idProduct']}'>
                                        <img src='assets/img/product/{$items['img']}' class='card-img-top' alt='{$items['name']}'>
                                        <div class='card-body'>
                                            <h5 class='card-title title'>{$items['name']}</h5>
                                            <div class='price-box'>
                                                <span class='new-price'>" . number_format($items['maxPrice'], 0, ',', '.') . " ₫</span>                                
                                            </div>
                                        </div>
                                    </a>
                                </div>
                         </div>";
                }
                ?>
            </div>
            <div class="d-flex justify-content-center my-4">
                <a href="./products.php?brand=samsung" class="btn btn-primary">Xem tất cả >></a>
            </div>

        </div>
    <?php } ?>
    <!--  -->

    <!-- Tin tức -->

    <div class="container py-4" style="padding-left: 0px; padding-right: 0px;">
        <div class="row g-4">
            <!-- Tin tức mới -->
            <div class="col-lg-8">
                <div class="p-3 border bg-white h-100 rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 border-start border-3 ps-2 fw-bold">TIN TỨC MỚI</h5>
                        <a href="#" class="text-muted small">Xem tất cả »</a>
                    </div>

                    <div class="row g-3">
                        <!-- Bài to bên trái -->
                        <div class="col-md-6">
                            <img src="assets/img/news/5g-lien-quan-12 (1)638930227493056818.jpg" class="img-fluid rounded mb-2" alt="">
                            <h6 class="fw-bold">Bật mí các gói cước 5G chơi Liên Quân lựa chọn tốt nhất?</h6>
                            <p class="text-muted small">Bật mí các gói cước 5G chơi Liên Quân giúp bạn chiến game mượt mà không lo giật lag....</p>
                            <small class="text-muted"><i class="bi bi-calendar"></i> 19/85/2025</small>
                        </div>

                        <!-- Danh sách nhỏ bên phải -->
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <img src="assets/img/news/iphone-17-pro-iphone-iphone-17-pro-max-1.jpg" class="me-2 rounded" style="width:100px; height:70px; object-fit:cover;" alt="">
                                <div>
                                    <p class="mb-1 fw-semibold small">Nên mua iPhone 17 Pro hay iPhone 17 Pro Max? Phiên bản nào tốt hơn</p>
                                    <small class="text-muted"><i class="bi bi-calendar"></i> 19/85/2025</small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <img src="assets/img/news/TZO75638938719654808271.jpg" class="me-2 rounded" style="width:100px; height:70px; object-fit:cover;" alt="">
                                <div>
                                    <p class="mb-1 fw-semibold small">Trực tiếp sự kiện giao iPhone 17 series và iPhone Air: Đêm ca nhạc ...</p>
                                    <small class="text-muted"><i class="bi bi-calendar"></i> 19/85/2025</small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <img src="assets/img/news/de-sac-khong-day-ugreen-magflow.jpg" class="me-2 rounded" style="width:100px; height:70px; object-fit:cover;" alt="">
                                <div>
                                    <p class="mb-1 fw-semibold small">Tìm hiểu đế sạc không dây Ugreen Magflow Qi2.2 25W chi tiết</p>
                                    <small class="text-muted"><i class="bi bi-calendar"></i> 19/85/2025</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tin tức công nghệ -->
            <div class="col-lg-4">
                <div class="p-3 border bg-white h-100 rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 border-start border-3 ps-2 fw-bold">TIN TỨC CÔNG NGHỆ</h5>
                        <a href="#" class="text-muted small">Xem tất cả »</a>
                    </div>

                    <!-- Danh sách tin nhỏ -->
                    <div class="d-flex mb-3">
                        <img src="assets/img/news/iphone-17-pro-iphone-iphone-17-pro-max-1.jpg" class="me-2 rounded" style="width:100px; height:70px; object-fit:cover;" alt="">
                        <div>
                            <p class="mb-1 fw-semibold small">Nên mua iPhone 17 Pro hay iPhone 17 Pro Max? Phiên bản nào tốt hơn</p>
                            <small class="text-muted"><i class="bi bi-calendar"></i> 19/85/2025</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <img src="assets/img/news/TZO75638938719654808271.jpg" class="me-2 rounded" style="width:100px; height:70px; object-fit:cover;" alt="">
                        <div>
                            <p class="mb-1 fw-semibold small">Trực tiếp sự kiện giao iPhone 17 series và iPhone Air: Đêm ca nhạc ...</p>
                            <small class="text-muted"><i class="bi bi-calendar"></i> 19/85/2025</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <img src="assets/img/news/de-sac-khong-day-ugreen-magflow.jpg" class="me-2 rounded" style="width:100px; height:70px; object-fit:cover;" alt="">
                        <div>
                            <p class="mb-1 fw-semibold small">Tìm hiểu đế sạc không dây Ugreen Magflow Qi2.2 25W chi tiết</p>
                            <small class="text-muted"><i class="bi bi-calendar"></i> 19/85/2025</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php include "layouts/footer.php" ?>