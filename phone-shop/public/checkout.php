<?php
include('layouts/header.php');
?>


<div class="container my-5">
    <div class="row g-4">
        <!-- Cột trái: Form khách hàng -->
        <div class="col-lg-7">
            <div class="p-4 bg-white shadow-sm rounded-3 border">
                <h4 class="mb-4 text-primary fw-bold">Thông tin khách hàng</h4>

                <form id="checkout-form" action="#" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Họ tên *</label>
                        <input type="text" class="form-control" name="fullName" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại *</label>
                        <input type="number" class="form-control" name="phone" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (tuỳ chọn)</label>
                        <input type="email" class="form-control" name="email" />
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

                    <button class="btn btn-primary w-100">ĐẶT HÀNG NGAY</button>
                </form>
            </div>
        </div>

        <!-- Cột phải: Đơn hàng -->
        <div class="col-lg-5">
            <div class="p-4 bg-white shadow-sm rounded-3 border">
                <h4 class="mb-4 fw-bold">Đơn hàng của bạn</h4>

                <div class="d-flex justify-content-between">
                    <div>iPhone 13 Pro Max (x1)</div>
                    <div class="text-danger fw-bold">24,000,000đ</div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <div>Tạm tính:</div>
                    <div>24,000,000đ</div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>Giảm giá:</div>
                    <div class="text-success">-2,000,000đ</div>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <div>Tổng tiền:</div>
                    <div class="text-danger">22,000,000đ</div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Load Tỉnh/Thành
    fetch("https://provinces.open-api.vn/api/?depth=1")
        .then(res => res.json())
        .then(data => {
            let provinceSelect = document.getElementById("province");
            data.forEach(province => {
                let opt = document.createElement("option");
                opt.value = province.code;
                opt.textContent = province.name;
                provinceSelect.appendChild(opt);
            });
        });

    // Khi chọn Tỉnh -> load Quận/Huyện
    document.getElementById("province").addEventListener("change", function() {
        let provinceCode = this.value;
        let districtSelect = document.getElementById("district");
        districtSelect.innerHTML = "<option value=''>-- Chọn Quận/Huyện --</option>";

        let wardSelect = document.getElementById("ward");
        wardSelect.innerHTML = "<option value=''>-- Chọn Phường/Xã --</option>";

        if (provinceCode) {
            fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    data.districts.forEach(district => {
                        let opt = document.createElement("option");
                        opt.value = district.code;
                        opt.textContent = district.name;
                        districtSelect.appendChild(opt);
                    });
                });
        }
    });

    // Khi chọn Quận/Huyện -> load Xã
    document.getElementById("district").addEventListener("change", function() {
        let districtCode = this.value;
        let wardSelect = document.getElementById("ward");
        wardSelect.innerHTML = "<option value=''>-- Chọn Phường/Xã --</option>";

        if (districtCode) {
            fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    data.wards.forEach(ward => {
                        let opt = document.createElement("option");
                        opt.value = ward.code;
                        opt.textContent = ward.name;
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
                e.preventDefault(); // Ngăn form submit
                alert(errors.join("\n"));
            }
        });
    });
</script>


<?php
include('layouts/footer.php');
?>