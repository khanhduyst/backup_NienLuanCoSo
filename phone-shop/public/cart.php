<?php
include '../app/config.php';
include "layouts/header.php" ?>

<style>
    .quantity-box {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quantity-box .btn {
        height: 36px;
        width: 36px;
        line-height: 1;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .quantity-box .qty {
        width: 50px;
        height: 36px;
        text-align: center;
        font-weight: 600;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cart-item {
        align-items: center;
    }

    .cart-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<div class="container my-4">
    <!-- Giỏ hàng -->
    <!-- test -->
    <form class="row" action="./controllers/cart_controller.php" method="post">
        <div class="col-md-8">
            <?php
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo '<div class="alert alert-info text-center">Giỏ hàng trống. <a href="index.php" class="alert-link">Tiếp tục mua sắm</a></div>';
            } else {
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    $id = $item['product_id'];
                    $query = "SELECT img_main FROM products WHERE id = $id";
                    $query_products = $conn->query($query)->fetch_assoc();
            ?>
                    <div class="cart-item d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <input type="hidden" name="product_id" value="<?php echo $key; ?>">
                            <input type="hidden" name="action" value="remove">
                            <img src="./assets/img/product/<?php echo $query_products['img_main'] ?>" alt="<?php echo $query_products['img_main'] ?>" class="cart-img">
                            <div class="ms-3">
                                <h6><?php echo $item['name'] ?></h6>
                                <p class="text-muted">Màu: <?php echo $item['color'] ?> | Ram: <?php echo $item['ram'] ?> | Dung lượng: <?php echo $item['rom'] ?></p>
                                <div class="quantity-box d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm minus">-</button>
                                    <input type="text" class="form-control qty text-center mx-1" value="<?php echo $item['quantity'] ?>" readonly>
                                    <button type="button" class="btn btn-outline-secondary btn-sm plus">+</button>
                                </div>
                            </div>
                        </div>
                        <!-- Bên phải gói chung giá và nút xoá -->
                        <div class="text-end cart-right">
                            <div>
                                <span class="fw-bold text-danger price" data-price="<?php echo $item['price'] ?>"><?php echo $item['price'] ?></span><br>
                                <small class="text-muted"><del class="old-price" data-oldprice="<?php echo $item['price'] + 1000000 ?>">
                                        <?php echo $item['price'] + 1000000 ?>đ
                                    </del></small>

                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete">Xoá</button>
                        </div>
                    </div>
            <?php }
            } ?>

        </div>

        <!-- test -->
        <?php
        $subtotal = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
        }
        $discount = 0; // sau này có thể trừ theo mã khuyến mãi
        $total = $subtotal - $discount;
        ?>
        <!-- Thông tin đơn hàng -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold">Thông tin đơn hàng</div>
                <div class="card-body">
                    <p>Tạm tính: <span id="subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</span></p>
                    <p>Giảm giá: <span class="text-success"><?php echo number_format($discount, 0, ',', '.'); ?>đ</span></p>
                    <hr>
                    <h5>Tổng tiền: <span id="total" class="text-danger fw-bold"><?php echo number_format($total, 0, ',', '.'); ?>đ</span></h5>

                    <!-- <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" id="invoice">
                        <label for="invoice" class="form-check-label">Xuất hoá đơn</label>
                    </div> -->

                    <textarea class="form-control mb-2" placeholder="Ghi chú đơn hàng" name="note"></textarea>
                    <input type="text" class="form-control mb-2" placeholder="Nhập mã khuyến mãi (nếu có)" name="voucher">
                    <button type="submit" name="checkout" class="btn btn-danger w-100">THANH TOÁN NGAY</button>
                    <a href="products.php" class="d-block text-center mt-2">← Tiếp tục mua hàng</a>
                </div>
            </div>
        </div>
    </form>
</div>



<script>
    function updateTotal() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const qty = parseInt(item.querySelector('.qty').value);
            const unitPrice = parseInt(item.querySelector('.price').getAttribute('data-price'));

            const priceEl = item.querySelector('.price');
            const oldPriceEl = item.querySelector('.cart-right del');

            const newPrice = qty * unitPrice;
            const oldPrice = qty * (unitPrice + 1000000);

            priceEl.textContent = newPrice.toLocaleString('vi-VN') + 'đ';
            if (oldPriceEl) oldPriceEl.textContent = oldPrice.toLocaleString('vi-VN') + 'đ';

            subtotal += newPrice;
        });

        document.getElementById('subtotal').textContent = subtotal.toLocaleString('vi-VN') + 'đ';
        let discount = 0;
        let total = subtotal - discount;
        document.getElementById('total').textContent = total.toLocaleString('vi-VN') + 'đ';
    }


    // Event cho nút cộng/trừ
    document.querySelectorAll('.cart-item').forEach(item => {
        const minusBtn = item.querySelector('.minus');
        const plusBtn = item.querySelector('.plus');
        const qtyInput = item.querySelector('.qty');
        const productId = item.querySelector('input[name="product_id"]').value;

        // Nút trừ
        minusBtn.addEventListener('click', () => {
            let qty = parseInt(qtyInput.value);
            if (qty > 1) {
                qty--;
                qtyInput.value = qty;
                updateTotal();
                updateHeaderCartCount();
                fetch('./controllers/cart_controller.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `action=update_qty&product_id=${productId}&quantity=${qty}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status !== 'success') {
                            console.error('Cập nhật session thất bại khi trừ');
                        }
                    })
                    .catch(err => console.error('Lỗi kết nối khi trừ:', err));
            }
        });

        // Nút cộng
        plusBtn.addEventListener('click', () => {
            let qty = parseInt(qtyInput.value);
            qty++;
            qtyInput.value = qty;
            updateTotal();
            updateHeaderCartCount();
            fetch('./controllers/cart_controller.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=update_qty&product_id=${productId}&quantity=${qty}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status !== 'success') {
                        console.error('Cập nhật session thất bại khi cộng');
                    }
                })
                .catch(err => console.error('Lỗi kết nối khi cộng:', err));
        });
    });


    // Khởi tạo
    updateTotal();

    function updateHeaderCartCount() {
        let totalQty = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            totalQty += parseInt(item.querySelector('.qty').value);
        });
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            cartCount.textContent = totalQty;
        }
    }

    // Xoá sản phẩm
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Xác nhận xoá',
                    text: "Bạn có chắc chắn muốn xoá sản phẩm này khỏi giỏ hàng?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xoá',
                    cancelButtonText: 'Huỷ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>


<?php include "layouts/footer.php" ?>