<?php include 'layouts/header.php'; ?>
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

        <div class="col">
            <div class="product-card" data-name="iPhone 12 Pro Max" data-price="13750500">
                <span class="discount-badge">-11%</span>
                <img src="assets/img/product/iphone/iphone13.jpg" class="product-img" alt="">
                <div class="promo-tag">KHUYẾN MÃI ĐẶC BIỆT</div>
                <div class="product-info">
                    <h6 class="product-name">iPhone 12 Pro Max</h6>
                    <p class="product-color">+4 màu sắc</p>
                    <div class="price-box">
                        <span class="new-price">13,750,500đ</span>
                        <span class="old-price"><del>15,450,000đ</del></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <a href="detail.php" class="product-link">
                <div class="product-card" data-name="ne 12 Pro Max" data-price="137500">
                    <span class="discount-badge">-11%</span>
                    <img src="assets/img/product/iphone/iphone13.jpg" class="product-img" alt="iPhone 12 Pro Max">
                    <div class="promo-tag">KHUYẾN MÃI ĐẶC BIỆT</div>
                    <div class="product-info">
                        <h6 class="product-name">iPhone 12 Pro Max</h6>
                        <p class="product-color">+4 màu sắc</p>
                        <div class="price-box">
                            <span class="new-price">13,750,500đ</span>
                            <span class="old-price"><del>15,450,000đ</del></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="detail.php" class="product-link">
                <div class="product-card" data-name="one 12 Pro Max" data-price="1350500">
                    <span class="discount-badge">-11%</span>
                    <img src="assets/img/product/iphone/iphone15.jpg" class="product-img" alt="iPhone 12 Pro Max">
                    <div class="promo-tag">KHUYẾN MÃI ĐẶC BIỆT</div>
                    <div class="product-info">
                        <h6 class="product-name">iPhone 12 Pro Max</h6>
                        <p class="product-color">+4 màu sắc</p>
                        <div class="price-box">
                            <span class="new-price">13,750,500đ</span>
                            <span class="old-price"><del>15,450,000đ</del></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="detail.php" class="product-link">
                <div class="product-card" data-name="Phone 12 Pro Max" data-price="1375500">
                    <span class="discount-badge">-11%</span>
                    <img src="assets/img/product/iphone/iphone16.png" class="product-img" alt="iPhone 12 Pro Max">
                    <div class="promo-tag">KHUYẾN MÃI ĐẶC BIỆT</div>
                    <div class="product-info">
                        <h6 class="product-name">iPhone 12 Pro Max</h6>
                        <p class="product-color">+4 màu sắc</p>
                        <div class="price-box">
                            <span class="new-price">13,750,500đ</span>
                            <span class="old-price"><del>15,450,000đ</del></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="detail.php" class="product-link">
                <div class="product-card" data-name="iPhone 12 Pro Max" data-price="13750500">
                    <span class="discount-badge">-11%</span>
                    <img src="assets/img/product/iphone/iphone17.jpg" class="product-img" alt="iPhone 12 Pro Max">
                    <div class="promo-tag">KHUYẾN MÃI ĐẶC BIỆT</div>
                    <div class="product-info">
                        <h6 class="product-name">iPhone 12 Pro Max</h6>
                        <p class="product-color">+4 màu sắc</p>
                        <div class="price-box">
                            <span class="new-price">13,750,500đ</span>
                            <span class="old-price"><del>15,450,000đ</del></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
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