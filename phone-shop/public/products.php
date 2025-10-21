<?php
include '../app/config.php';
include 'layouts/header.php';

$brand_name = $_GET['brand'] ?? null;

if ($brand_name) {
    $brand_name = strtoupper(trim($brand_name));

    $sql = "SELECT p.id AS product_id, 
                   p.name AS product_name, 
                   b.name AS brand_name, 
                   p.img_main AS img_main, 
                   p.screen_technology AS screen_technology, 
                   p.categories AS product_cate, 
                   MIN(pv.price) AS price
            FROM products p  
            INNER JOIN product_variants pv ON pv.product_id = p.id
            INNER JOIN brands b ON b.id = p.brand_id 
            WHERE UPPER(b.name) LIKE '%$brand_name%'
              AND p.status = 0 
              AND p.is_delete = 0
            GROUP BY p.id";
} else {
    $sql = "SELECT p.id AS product_id, 
                   p.name AS product_name, 
                   b.name AS brand_name, 
                   p.img_main AS img_main, 
                   p.screen_technology AS screen_technology, 
                   p.categories AS product_cate, 
                   MIN(pv.price) AS price
            FROM products p  
            INNER JOIN product_variants pv ON pv.product_id = p.id
            INNER JOIN brands b ON b.id = p.brand_id 
            WHERE p.status = 0 
              AND p.is_delete = 0
            GROUP BY p.id";
}

$resultProduct = $conn->query($sql);
?>
<style>
    .product-spec {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 14px;
        color: #555;
    }
</style>
<div class="container my-4">

    <!-- Nút sắp xếp -->
    <div class="mb-3">
        <button class="btn btn-outline-primary sort-btn active" data-sort="default">Nổi bật</button>
        <button class="btn btn-outline-primary sort-btn" data-sort="price-asc">Giá: Tăng dần</button>
        <button class="btn btn-outline-primary sort-btn" data-sort="price-desc">Giá: Giảm dần</button>
        <button class="btn btn-outline-primary sort-btn" data-sort="az">A-Z</button>
        <button class="btn btn-outline-primary sort-btn" data-sort="za">Z-A</button>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="row row-cols-2 row-cols-md-5 g-3" id="productList">
        <?php
        if ($resultProduct && $resultProduct->num_rows > 0) {
            $qtyColor = 0;
            $percent = 0;
            while ($product = $resultProduct->fetch_assoc()) {
                $giacu = $product['price'] + 2000000;
                $giagiam = $product['price'];
                $percent = (2000000 / $giacu) * 100;
        ?>
                <div class="col">
                    <a href='detail.php?product_id=<?php echo $product['product_id'] ?>'>
                        <div class="product-card" data-name="<?php echo $product['product_name'] ?>" data-price="<?php echo $product['price'] ?>">
                            <span class="discount-badge">-<?php echo round($percent) ?>%</span>
                            <img src="assets/img/product/<?php echo $product['img_main'] ?>" class="product-img" alt="<?php echo $product['product_name'] ?>">
                            <div class="promo-tag">KHUYẾN MÃI ĐẶC BIỆT</div>
                            <div class="product-info">
                                <h6 class="product-name product-spec"><?php echo $product['product_name'] ?></h6>
                                <p class="product-color product-spec">Màn hình: <?php echo $product['screen_technology'] ?></p>
                                <div class="price-box">
                                    <span class="new-price"><?php echo number_format($product['price'], 0, ',', '.') ?>đ</span>
                                    <span class="old-price"><del><?php echo number_format($product['price'] + 2000000, 0, ',', '.') ?>đ</del></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php
            }
        } else {
            echo "<div class='alert alert-info text-center'>Không tìm thấy sản phẩm nào.</div>";
        }
        ?>
    </div>
</div>



<script>
    // Toggle chọn nút sắp xếp
    document.querySelectorAll('.btn-sort').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-sort').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const sortButtons = document.querySelectorAll(".sort-btn");
    const productList = document.getElementById("productList");

    sortButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            // remove active cũ
            sortButtons.forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            const sortType = this.getAttribute("data-sort");
            let products = Array.from(productList.querySelectorAll(".col"));

            products.sort((a, b) => {
                let priceA = parseInt(a.querySelector(".product-card").dataset.price);
                let priceB = parseInt(b.querySelector(".product-card").dataset.price);
                let nameA = a.querySelector(".product-card").dataset.name.toLowerCase();
                let nameB = b.querySelector(".product-card").dataset.name.toLowerCase();

                if (sortType === "price-asc") return priceA - priceB;
                if (sortType === "price-desc") return priceB - priceA;
                if (sortType === "az") return nameA.localeCompare(nameB);
                if (sortType === "za") return nameB.localeCompare(nameA);
                return 0; // mặc định
            });

            // render lại
            products.forEach(p => productList.appendChild(p));
        });
    });
</script>


<?php include 'layouts/footer.php'; ?>