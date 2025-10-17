<?php
include '../app/config.php';
include('layouts/header.php');


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $loadUser = $conn->query($query)->fetch_assoc();
}

?>


<div class="container my-5">
    <form id="checkout-form" action="./controllers/checkout_controller.php" method="POST">
        <div class="row g-4">
            <!-- Cột trái: Form khách hàng -->
            <div class="col-lg-7">
                <div class="p-4 bg-white shadow-sm rounded-3 border">

                    <h4 class="mb-4 text-primary fw-bold">Thông tin khách hàng</h4>

                    <div class="mb-3">
                        <label class="form-label">Họ tên *</label>
                        <input type="text" class="form-control" name="fullName" value="<?php echo $loadUser['fullname'] ?? '' ?>" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại *</label>
                        <input type="number" class="form-control" name="phone" value="<?php echo $loadUser['phone'] ?? '' ?>" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $loadUser['email'] ?? '' ?>" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ giao hàng cụ thể</label>
                        <input type="text" class="form-control" name="shipping_address" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tỉnh/Thành phố *</label>
                        <select class="form-select" name="province" id="province" required></select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quận/Huyện *</label>
                        <select class="form-select" name="district" id="district" required></select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phường/Xã *</label>
                        <select class="form-select" name="ward" id="ward" required></select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán *</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment" value="cod" checked>
                            <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment" value="bank">
                            <label class="form-check-label">Chuyển khoản ngân hàng</label>
                        </div>
                    </div>

                    <button type="submit" name="checkout" class="btn btn-primary w-100">ĐẶT HÀNG NGAY</button>
                </div>
            </div>

            <!-- Cột phải: Đơn hàng -->
            <div class="col-lg-5">
                <div class="p-4 bg-white shadow-sm rounded-3 border">
                    <h4 class="mb-4 fw-bold">Đơn hàng của bạn</h4>
                    <?php
                    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                        echo '<div class="alert alert-info text-center">Giỏ hàng trống. <a href="index.php" class="alert-link">Tiếp tục mua sắm</a></div>';
                    } else {
                        $temp_price = 0;
                        $quantitys = 0;
                        foreach ($_SESSION['cart'] as $key => $item) {
                            $temp_price += ($item['price'] * $item['quantity']);
                            $quantitys = $item['quantity'];
                    ?>
                            <div class="d-flex justify-content-between">
                                <div><?php echo $item['name'] . " (x" . $item['quantity'] . ")" ?></div>
                                <div class="text-danger fw-bold"><?php echo number_format($item['price'], 0, ',', '.') ?>đ</div>
                                <input type="hidden" name="product_id[]" value="<?php echo $item['product_id'] ?>">
                                <input type="hidden" name="variant_id[]" value="<?php echo $item['variant_id'] ?>">
                                <input type="hidden" name="color[]" value="<?php echo $item['color'] ?>">
                                <input type="hidden" name="ram[]" value="<?php echo $item['ram'] ?>">
                                <input type="hidden" name="rom[]" value="<?php echo $item['rom'] ?>">
                                <!-- <input type="hidden" name="image[]" value="<?php echo $item['image'] ?>"> -->
                                <input type="hidden" name="quantity[]" value="<?php echo $item['quantity'] ?>">
                                <input type="hidden" name="price_items[]" value="<?php echo $item['price'] ?>">
                            </div>
                    <?php }
                    } ?>
                    <hr>
                    <input type="hidden" name="qty" value="<?php echo   $quantitys ?>">
                    <input type="hidden" name="order_note" value="<?php echo  $_SESSION['order_note'] ?>">
                    <input type="hidden" name="voucher_code" value="<?php echo  $_SESSION['voucher_code'] ?>">
                    <div class="d-flex justify-content-between">
                        <div>Tạm tính:</div>
                        <div><?php echo number_format($temp_price, 0, ',', '.') ?>đ</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>Giảm giá:</div>
                        <div class="text-success">
                            <?php
                            if (isset($_SESSION['voucher_code'])) {
                                $code_voucher = [
                                    [
                                        "code" => "chaothang7",
                                        "sale" => 200000
                                    ],
                                    [
                                        "code" => "chaobanmoi",
                                        "sale" => 2000000,
                                    ]
                                ];
                                $price_sale = 0;
                                $user_input = $_SESSION['voucher_code'];
                                foreach ($code_voucher as $check) {
                                    if (strcasecmp($check['code'], $user_input) === 0) { //strcasecmp so sánh chủi
                                        $price_voucher = $temp_price - $check['sale'];
                                        $price_sale = $check['sale'];
                                        break;
                                    } else {
                                        $price_voucher = $temp_price;
                                    }
                                }
                            }
                            ?>
                            <input type="hidden" name="voucher_discount" value="<?php echo $price_sale ?>">
                            -<?php echo number_format($price_sale, 0, ',', '.') ?>đ
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <div>Tổng tiền:</div>
                        <input type="hidden" name="price" value="<?php echo $price_voucher ?>">
                        <div class="text-danger"><?php echo number_format($price_voucher, 0, ',', '.') ?>đ</div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>


<script>
    const provinceSelect = document.getElementById("province");
    const districtSelect = document.getElementById("district");
    const wardSelect = document.getElementById("ward");

    fetch("https://provinces.open-api.vn/api/p/")
        .then(res => res.json())
        .then(data => {
            data.forEach(p => {
                const opt = document.createElement("option");
                opt.value = p.name;
                opt.textContent = p.name;
                opt.dataset.code = p.code;
                provinceSelect.appendChild(opt);
            });
        });

    provinceSelect.addEventListener("change", function() {
        const selectedCode = this.options[this.selectedIndex].dataset.code;
        const selectedName = this.value;
        districtSelect.innerHTML = "<option value=''>-- Chọn Quận/Huyện --</option>";
        wardSelect.innerHTML = "<option value=''>-- Chọn Phường/Xã --</option>";

        if (selectedCode) {
            fetch(`https://provinces.open-api.vn/api/p/${selectedCode}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    data.districts.forEach(d => {
                        const opt = document.createElement("option");
                        opt.value = d.name;
                        opt.textContent = d.name;
                        opt.dataset.code = d.code;
                        districtSelect.appendChild(opt);
                    });
                });
        }
    });

    districtSelect.addEventListener("change", function() {
        const selectedCode = this.options[this.selectedIndex].dataset.code;
        const selectedName = this.value;
        wardSelect.innerHTML = "<option value=''>-- Chọn Phường/Xã --</option>";

        if (selectedCode) {
            fetch(`https://provinces.open-api.vn/api/d/${selectedCode}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    data.wards.forEach(w => {
                        const opt = document.createElement("option");
                        opt.value = w.name;
                        opt.textContent = w.name;
                        wardSelect.appendChild(opt);
                    });
                });
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        loadProvince(); // Load Tỉnh/Huyện/Xã bằng API

        const form = document.getElementById("checkout-form");

        form.addEventListener("submit", function(e) {
            const fullName = form.fullName.value.trim();
            const phone = form.phone.value.trim();
            const province = form.province.value;
            const district = form.district.value;
            const ward = form.ward.value;

            let errors = [];

            if (fullName === "") {
                errors.push("Vui lòng nhập họ tên");
            }

            if (phone === "") {
                errors.push("Vui lòng nhập số điện thoại");
            } else if (!/^(0\d{9})$/.test(phone)) {
                errors.push("Số điện thoại không hợp lệ");
            }

            if (!province) {
                errors.push("Vui lòng chọn Tỉnh/Thành phố");
            }

            if (!district) {
                errors.push("Vui lòng chọn Quận/Huyện");
            }

            if (!ward) {
                errors.push("Vui lòng chọn Phường/Xã");
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join("\n"));
            }
        });
    });
</script>

<?php
include('layouts/footer.php');
?>