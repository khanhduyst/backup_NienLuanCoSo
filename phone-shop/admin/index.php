<?php
include "layouts/header.php";
include '../app/config.php';


$currentMonth = date('Y-m');

$sqlRevenue = "
    SELECT SUM(total) AS revenue
    FROM orders
    WHERE DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'
    AND status = 'completed'
";
$resRevenue = $conn->query($sqlRevenue);
$totalRevenue = 0;
if ($resRevenue && $resRevenue->num_rows > 0) {
    $totalRevenue = $resRevenue->fetch_assoc()['revenue'] ?? 0;
}

$sqlOrders = "
    SELECT COUNT(*) AS total_orders
    FROM orders
    WHERE DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'
";
$totalOrders = $conn->query($sqlOrders)->fetch_assoc()['total_orders'] ?? 0;

$sqlCustomers = "SELECT COUNT(*) AS total_customers FROM users WHERE role = 'user'";
$totalCustomers = $conn->query($sqlCustomers)->fetch_assoc()['total_customers'] ?? 0;

$sqlCancelled = "
    SELECT COUNT(*) AS cancelled_orders
    FROM orders
    WHERE status = 'cancelled'
    AND DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth'
";
$totalCancelled = $conn->query($sqlCancelled)->fetch_assoc()['cancelled_orders'] ?? 0;
?>

<div class="p-4">
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-success text-white card-box shadow-sm">
                <div class="card-body">
                    <h6>Doanh thu (theo tháng)</h6>
                    <h3><?= number_format($totalRevenue, 0, ',', '.') ?>đ</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white card-box shadow-sm">
                <div class="card-body">
                    <h6>Đơn hàng (theo tháng)</h6>
                    <h3><?= $totalOrders ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark card-box shadow-sm">
                <div class="card-body">
                    <h6>Khách hàng</h6>
                    <h3><?= $totalCustomers ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white card-box shadow-sm">
                <div class="card-body">
                    <h6>Đơn hàng huỷ</h6>
                    <h3><?= $totalCancelled ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header fw-bold bg-white d-flex justify-content-between align-items-center">
                    <span>Đơn hàng mới</span>
                    <a href="orders.php" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlRecentOrders = "
                        SELECT o.id, o.total, o.created_at, o.status, u.fullname
                        FROM orders o
                        JOIN users u ON o.user_id = u.id
                        ORDER BY 
                            FIELD(o.status, 'pending', 'processing', 'completed', 'cancelled'),
                            o.created_at DESC
                        LIMIT 10
                    ";
                            $recentOrders = $conn->query($sqlRecentOrders);

                            if ($recentOrders && $recentOrders->num_rows > 0) {
                                while ($row = $recentOrders->fetch_assoc()) {
                                    $badgeClass = match ($row['status']) {
                                        'pending' => 'bg-info text-dark',
                                        'processing' => 'bg-warning text-dark',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };

                                    $statusText = match ($row['status']) {
                                        'pending' => 'Chờ xử lý',
                                        'processing' => 'Đang xử lý',
                                        'completed' => 'Hoàn tất',
                                        'cancelled' => 'Đã huỷ',
                                        default => 'Không xác định'
                                    };
                                    echo "
                            <tr>
                                <td>
                                    <a href='order_detail.php?order_id={$row['id']}' class='text-decoration-none text-primary fw-semibold'>
                                        #DH" . str_pad($row['id'], 3, '0', STR_PAD_LEFT) . "
                                    </a>
                                </td>
                                <td>{$row['fullname']}</td>
                                <td>" . number_format($row['total'], 0, ',', '.') . "đ</td>
                                <td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>
                                <td><span class='badge $badgeClass'>$statusText</span></td>
                            </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted'>Chưa có đơn hàng nào</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold bg-white">Lịch sử</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush small">
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $result = $conn->query("SELECT * FROM activity_logs WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <li class='list-group-item'>
                                    {$row['description']}
                                    <p class='text-primary m-0 small'>[{$row['created_at']}]</p>
                                </li>";
                            }
                        } else {
                            echo "<li class='list-group-item text-muted'>Chưa có hoạt động nào gần đây.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "layouts/footer.php"; ?>