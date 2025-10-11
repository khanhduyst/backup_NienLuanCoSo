<?php include "layouts/header.php";
include '../app/config.php'; ?>

<div class="p-4">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-3">
                    <select class="form-select" id="sortSelect">
                        <option value="">-- Sắp xếp theo --</option>
                        <option>A - Z</option>
                        <option>Z - A</option>
                        <option>Giá tăng dần</option>
                        <option>Giá giảm dần</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="searchInput">
                        <button class="btn btn-primary" id="btnSearch"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <a href="add_product.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm sản phẩm
                    </a>
                </div>
            </div>

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Hình</th>
                        <th>Tên sản phẩm</th>
                        <th>Thương hiệu</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sản phẩm 1 -->
                    <?php
                    $result = $conn->query("SELECT products.id AS product_id, products.img_main, products.name AS product_name, brands.name AS brands_name, products.status FROM products INNER JOIN brands ON products.brand_id = brands.id");
                    $stt = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                        <td><img src='../public/assets/img/product/{$row['img_main']}' alt='{$row['product_name']}' width='50' class='rounded'></td>
                        <td>{$row['product_name']}</td>
                        <td>{$row['brands_name']}</td>
                        <td>
                        <span class='badge " . ($row['status'] ? "bg-success" : "bg-secondary") . "'>" . ($row['status'] ? "Hiển thị" : "Ẩn") . "</span>
                        </td>
                        <td class='text-center'>
                            <a href='add_product.php?edit={$row['product_id']}' class='btn btn-sm btn-warning' title='Sửa sản phẩm'><i class='fas fa-edit'></i></a>
                            <a href='variants_product.php?product_id={$row['product_id']}' class='btn btn-sm btn-success' title='Thêm/Sửa biến thể'><i class='fa-solid fa-sliders'></i></a>
                            <a href='#' class='btn btn-sm btn-danger'><i class='fas fa-trash-alt'></i></a>
                        </td>
                    </tr>
                        ";
                    }
                    ?>
                   
                </tbody>
            </table>

            <!-- Phân trang -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Tiếp</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll("tbody tr");
        const searchInput = document.getElementById("searchInput");
        const btnSearch = document.getElementById("btnSearch");
        const sortSelect = document.querySelector("select");

        btnSearch.addEventListener("click", function() {
            const keyword = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? "" : "none";
            });
        });

        sortSelect.addEventListener("change", function() {
            const tbody = document.querySelector("tbody");
            const sortValue = this.value;
            const sorted = Array.from(rows).sort((a, b) => {
                const nameA = a.children[1].innerText.trim().toLowerCase();
                const nameB = b.children[1].innerText.trim().toLowerCase();
                const priceA = parseFloat(a.children[3].innerText.replace(/[^\d]/g, ''));
                const priceB = parseFloat(b.children[3].innerText.replace(/[^\d]/g, ''));

                if (sortValue === "A - Z") return nameA.localeCompare(nameB);
                if (sortValue === "Z - A") return nameB.localeCompare(nameA);
                if (sortValue === "Giá tăng dần") return priceA - priceB;
                if (sortValue === "Giá giảm dần") return priceB - priceA;
                return 0;
            });

            // clear and re-append
            tbody.innerHTML = "";
            sorted.forEach(row => tbody.appendChild(row));
        });
    });
</script>


<?php include "layouts/footer.php" ?>