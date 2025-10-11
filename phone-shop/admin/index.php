
<?php 
include "layouts/header.php";

include '../app/config.php';
?>

<div class="p-4">
    <!-- Hàng thống kê -->
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-success text-white card-box">
                <div class="card-body">
                    <h6>Doanh thu</h6>
                    <h3>$12,000</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white card-box">
                <div class="card-body">
                    <h6>Đơn hàng</h6>
                    <h3>150</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark card-box">
                <div class="card-body">
                    <h6>Khách hàng</h6>
                    <h3>72</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white card-box">
                <div class="card-body">
                    <h6>Hết hàng</h6>
                    <h3>3</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Hàng dưới: Đơn hàng + Lịch sử -->
    <div class="row mt-4">
        <!-- Đơn hàng mới (to hơn) -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold">Đơn hàng mới</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped order-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#">#DH001</a></td>
                                <td>Nguyễn Văn A</td>
                                <td>3,200,000đ</td>
                                <td>2025-09-20</td>
                                <td><span class="badge bg-info">Chờ xử lý</span></td>
                            </tr>
                            <tr>
                                <td><a href="#">#DH002</a></td>
                                <td>Trần Thị B</td>
                                <td>5,000,000đ</td>
                                <td>2025-09-19</td>
                                <td><span class="badge bg-success">Đã giao</span></td>
                            </tr>
                            <tr>
                                <td><a href="#">#DH003</a></td>
                                <td>Lê Văn C</td>
                                <td>1,200,000đ</td>
                                <td>2025-09-18</td>
                                <td><span class="badge bg-danger">Đã huỷ</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Lịch sử (nhỏ hơn) -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold">Lịch sử</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php
                            $user_id =  $_SESSION['user_id'] ;
                            $result = $conn->query("SELECT * FROM activity_logs WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5");
                            while($row = $result->fetch_assoc()) {
                                  echo "
                                   <li class='list-group-item'>{$row['description']} <p class ='text-primary'> [{$row['created_at']}]</p></li>
                                  ";
                            }
                        
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include "layouts/footer.php" ?>