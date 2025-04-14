<?php
require '../../connects/connect.php';
session_start();
if (!isset($_SESSION['logined-username'])) {
    $_SESSION['error_message'] = "Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại!";
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/statistical.css">
    <title>Thống kê hóa đơn</title>
    <style>
        /* CSS cho bảng */
        /* CSS cho bảng */
        table {
            max-width: 1000px;
            /* Đặt chiều rộng tối đa */
            width: 100%;
            margin-left: 350px;
            /* Canh giữa bảng */
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 30px
        }

        th,
        td {
            padding: 8px;
            /* Giảm padding */
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #a39d9d;
        }

        /* CSS cho liên kết */
        a {
            color: #007bff;
            text-decoration: none;
        }

        .fit_but {
            margin-left: 30px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-menu bg-dark">
            <ul>
                <li>
                    <a href="./admin-istrator.php">
                        <i class="fas fa-id-card fs-3"></i><br>
                        Quản Trị Viên
                    </a>
                </li>
                <li>
                    <a href="./admin-customer.php">
                        <i class="fas fa-user fs-3"></i><br>
                        Khách Hàng
                    </a>
                </li>
                <li>
                    <a href="./admin-product.php">
                        <i class="fas fa-clipboard-list fs-3"></i><br>
                        Sản Phẩm
                    </a>
                </li>
                <li>
                    <a href="./admin-order.php">
                        <i class="fas fa-cart-shopping fs-3"></i><br>
                        Đơn Hàng
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-chart-line fs-3"></i><br>
                        Thống Kê
                    </a>
                </li>
                <li>
                    <a href="./admin-logout.php" class="text-decoration-none text-white">
                        <i class="fas fa-right-from-bracket fs-3 mb-1"></i><br>
                        Thoát
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-section">
        <div class="input-section">
            <div style="display: flex; justify-content: space-between;">
                <h1 class="mb-4 text-dark">Sản Phẩm</h1>
                <p style="font-size: 18px;;">
                    <?php
                    echo "Chào " . $_SESSION['logined-username'];
                    ?>
                </p>
            </div>
        </div>
        <form action="admin-statistical.php" method="post">
            <label for="start_date">Ngày bắt đầu:</label>
            <input type="date" id="start_date" name="start_date" class="form-control">
            <label for="end_date">Ngày kết thúc:</label>
            <input type="date" id="end_date" name="end_date" class="form-control"> <br>
            <input type="submit" value="Xem thống kê" class="btn btn-success fit_but">
            <br>
        </form>
    </div>

    <?php
    // Xử lý dữ liệu từ form khi được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ form và làm sạch chúng
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

        // Thực hiện truy vấn SQL sử dụng prepared statements để ngăn chặn SQL Injection
        $sql = "SELECT cus.username, cus.fullname, ors.OrderID, SUM(ord.price * ord.quantity) AS total_purchase, ors.status, ors.order_date
                FROM customer cus
                INNER JOIN orders ors ON cus.username = ors.username
                INNER JOIN oderdetail ord ON ors.OrderID = ord.OrderID
                WHERE ors.order_date BETWEEN ? AND ? AND ors.status = '1' AND ors.OrderID = ord.OrderID
                GROUP BY cus.username
                ORDER BY total_purchase DESC
                LIMIT 5";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
    ?>
            <table>
                <thead>
                    <tr>
                        <th>Tên tài khoản</th>
                        <th>Họ và tên</th>
                        <th>Tổng tiền mua hàng</th>
                        <th>Tình trạng đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td>" . htmlspecialchars($row["username"]) . "</td>
                        <td>" . htmlspecialchars($row["fullname"]) . "</td>
                        <td>" . number_format($row["total_purchase"], 0, ',', ',') . '₫' . "</td>

                        <td>";

                        // Lấy thông tin chi tiết các đơn hàng của khách hàng này trong cùng một truy vấn
                        echo "<a href='admin-statistical-edit.php?username=" . $row["username"] . "'>Xem chi tiết đơn hàng</a>";

                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
    <?php
        } else {
            echo "<script>alert('Không có dữ liệu phù hợp.');</script>";
        }
    }
    ?>
    <script src="../js/admin-statistical.js"></script>
</body>

</html>