<?php
include '../app/config.php';
include('layouts/header.php');
?>

<?php

if (isset($_SESSION['modal_message'])) {
    echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: '" . addslashes($_SESSION['modal_title']) . "',
            html: '" . addslashes($_SESSION['modal_message']) . "',
            timer: 2500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = 'cart.php';
        });
    </script>";
    unset($_SESSION['modal_message'], $_SESSION['modal_title'], $_SESSION['modal_type']);
}
?>

<style>
    body {
        background-color: #f8f9fa;
        font-family: "Mulish", sans-serif;
    }

    .card {
        border-radius: 12px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table th:first-child,
    .table td:first-child {
        width: 5%;
        text-align: center;
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
        width: 20%;
    }

    .table th:nth-child(3),
    .table td:nth-child(3),
    .table th:nth-child(4),
    .table td:nth-child(4),
    .table th:nth-child(5),
    .table td:nth-child(5),
    .table th:nth-child(6),
    .table td:nth-child(6) {
        width: 18%;
    }

    .badge {
        font-size: 0.85em;
        padding: 6px 10px;
        border-radius: 8px;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f3f5;
        transition: 0.2s;
    }
</style>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Lịch sử đơn hàng của bạn</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Mã đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $userID =  $_SESSION['user_id'];
                    $sql = "SELECT * FROM orders WHERE user_id = '$userID'";
                    $query = $conn->query($sql);
                    $total = 1;
                    while ($rows = $query->fetch_assoc()) {
                        $status = $rows['status'] ?? 'pending';
                        $statusText = '';
                        $badgeClass = '';

                        switch ($status) {
                            case 'pending':
                                $statusText = 'Chờ xử lý';
                                $badgeClass = 'bg-warning text-dark';
                                break;
                            case 'processing':
                                $statusText = 'Đang xử lý';
                                $badgeClass = 'bg-info text-dark';
                                break;
                            case 'completed':
                                $statusText = 'Hoàn tất';
                                $badgeClass = 'bg-success text-white';
                                break;
                            case 'cancelled':
                                $statusText = 'Đã huỷ';
                                $badgeClass = 'bg-danger text-white';
                                break;
                            default:
                                $statusText = 'Không xác định';
                                $badgeClass = 'bg-secondary text-white';
                        }
                    ?>
                        <tr>
                            <td><?php echo $total ?></td>
                            <td>#DH0<?php echo $rows['id'] ?></td>
                            <td><span class="badge <?php echo $badgeClass ?>"><?php echo $statusText ?></span></td>
                            <td><?php echo number_format($rows['total'], 0, ',', '.') ?>₫</td>
                            <td><?php echo $rows['created_at'] ?></td>
                            <td>
                                <a href="../public/order_detail.php?order_id=<?php echo $rows['id'] ?>" class="btn btn-sm btn-outline-primary">Xem</a>
                                <form action="./controllers/order_controller.php" method="post" class="d-inline">
                                    <input type="hidden" name="id_order" value="<?php echo $rows['id'] ?>">
                                    <?php
                                    if ($status === 'pending' || $status === 'processing') {
                                        echo "<button type='submit' name='cancel' class='btn btn-outline-danger btn-sm'>Huỷ đơn hàng</button>";
                                    }
                                    ?>
                                </form>
                            </td>

                        </tr>
                    <?php
                        $total++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('layouts/footer.php');
?>