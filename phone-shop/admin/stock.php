<?php include 'layouts/header.php'; ?>

<div class="container-fluid py-4">

    <!-- Form nhập / xuất kho -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Nhập / Xuất kho</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Sản phẩm</label>
                        <select class="form-select">
                            <option>iPhone 14 Pro Max</option>
                            <option>Samsung Galaxy S23</option>
                            <option>Xiaomi Redmi Note 13</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Loại</label>
                        <select class="form-select">
                            <option value="import">Nhập kho</option>
                            <option value="export">Xuất kho</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Số lượng</label>
                        <input type="number" class="form-control" min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ghi chú</label>
                        <input type="text" class="form-control" placeholder="Ví dụ: nhập mới / bán hàng">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                    <button type="reset" class="btn btn-secondary">Làm mới</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lịch sử tồn kho -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Lịch sử tồn kho</h5>
            <div style="width: 250px;">
                <input type="text" class="form-control form-control-sm" placeholder="Tìm sản phẩm...">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Loại</th>
                        <th>Số lượng</th>
                        <th>Ghi chú</th>
                        <th>Ngày</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu mẫu -->
                    <tr>
                        <td>1</td>
                        <td>iPhone 14 Pro Max</td>
                        <td><span class="badge bg-success">Nhập</span></td>
                        <td>50</td>
                        <td>Nhập hàng mới</td>
                        <td>2025-09-22</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Samsung Galaxy S23</td>
                        <td><span class="badge bg-danger">Xuất</span></td>
                        <td>5</td>
                        <td>Bán hàng</td>
                        <td>2025-09-22</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include 'layouts/footer.php'; ?>