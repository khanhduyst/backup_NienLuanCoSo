<?php include "layouts/header.php" ?>

<div class="container my-4">
    <div class="row">
        <!-- Giỏ hàng -->
        <div class="col-md-8">
            <div class="cart-item d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center">
                    <img src="assets/img/product/iphone/iphone13.jpg" alt="iPhone" class="cart-img">
                    <div class="ms-3">
                        <h6>iPhone 13 Pro Max</h6>
                        <p class="text-muted">Màu: Xanh | Dung lượng: 128GB</p>
                        <div class="quantity-box d-flex align-items-center">
                            <button class="btn btn-outline-secondary btn-sm minus">-</button>
                            <input type="text" class="form-control qty text-center mx-1" value="1" readonly>
                            <button class="btn btn-outline-secondary btn-sm plus">+</button>
                        </div>
                    </div>
                </div>

                <!-- Bên phải gói chung giá và nút xoá -->
                <div class="text-end cart-right">
                    <div>
                        <span class="fw-bold text-danger price" data-price="24000000">24,000,000đ</span><br>
                        <small class="text-muted"><del>26,000,000đ</del></small>
                    </div>
                    <button class="btn btn-sm btn-outline-danger remove-item">Xoá</button>
                </div>
            </div>

        </div>

        <!-- Thông tin đơn hàng -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold">Thông tin đơn hàng</div>
                <div class="card-body">
                    <p>Tạm tính: <span id="subtotal">24,000,000đ</span></p>
                    <p>Giảm giá: <span class="text-success">-2,000,000đ</span></p>
                    <hr>
                    <h5>Tổng tiền: <span id="total" class="text-danger fw-bold">22,000,000đ</span></h5>

                    <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" id="invoice">
                        <label for="invoice" class="form-check-label">Xuất hoá đơn</label>
                    </div>

                    <textarea class="form-control mb-2" placeholder="Ghi chú đơn hàng"></textarea>
                    <input type="text" class="form-control mb-2" placeholder="Nhập mã khuyến mãi (nếu có)">
                    <a href="checkout.php" class="btn btn-danger w-100">THANH TOÁN NGAY</a>
                    <a href="products.php" class="d-block text-center mt-2">← Tiếp tục mua hàng</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function updateTotal() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const qty = parseInt(item.querySelector('.qty').value);
            const unitPrice = parseInt(item.querySelector('.price').getAttribute('data-price'));
            subtotal += qty * unitPrice;
            item.querySelector('.price').textContent = (qty * unitPrice).toLocaleString('vi-VN') + 'đ';
        });
        document.getElementById('subtotal').textContent = subtotal.toLocaleString('vi-VN') + 'đ';

        // Giảm giá ví dụ -2 triệu
        let discount = 2000000;
        let total = subtotal - discount;
        document.getElementById('total').textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    // Event cho nút cộng/trừ
    document.querySelectorAll('.cart-item').forEach(item => {
        const minusBtn = item.querySelector('.minus');
        const plusBtn = item.querySelector('.plus');
        const qtyInput = item.querySelector('.qty');

        minusBtn.addEventListener('click', () => {
            let qty = parseInt(qtyInput.value);
            if (qty > 1) {
                qty--;
                qtyInput.value = qty;
                updateTotal();
            }
        });

        plusBtn.addEventListener('click', () => {
            let qty = parseInt(qtyInput.value);
            qty++;
            qtyInput.value = qty;
            updateTotal();
        });
    });

    // Khởi tạo
    updateTotal();

    // Xoá sản phẩm
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
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
                    cartItem.remove();
                    updateCartSummary();
                    Swal.fire('Đã xoá!', 'Sản phẩm đã được xoá khỏi giỏ hàng.', 'success');
                }
            });
        });
    });
</script>


<?php include "layouts/footer.php" ?>