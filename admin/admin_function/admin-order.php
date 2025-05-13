<?php
session_start();
require '../../connection/connectDGHCVN.php';
require '../../connection/connect.php';
if (!isset($_SESSION['logined-username'])) {
    $_SESSION['error_message'] = "Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại!";
    header("Location: ../index.php");
}
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']); // Xóa thông báo lỗi sau khi hiển thị
    echo "<script>alert('{$notification}');</script>";
} else {
    $notification = "";
}
$sql = "SELECT * FROM `orders`";
$result = mysqli_query($conn, $sql);

if (isset($_POST['find-submit-btn'])) {
    $findType = $_POST['find-by'];
    if ($findType == 'tinh-trang') {
        $status = $_POST['find-by-status'];
        $sql = "SELECT * FROM `orders` WHERE status = '{$status}'";
        $result = mysqli_query($conn, $sql);
    } else if ($findType == 'thoi-gian-dat-hang') {
        $date_from = $_POST['date-from'];
        $date_to = $_POST['date-to'];
        if ($date_from > $date_to) {
            $_SESSION['notification'] = "Ngày bắt đầu không thể lớn hơn ngày kết thúc!";
            header("Location: admin-order.php");
        }
        $sql = "SELECT * FROM `orders` WHERE `order_date` >= '$date_from' AND `order_date` <= '$date_to'";
        $result = mysqli_query($conn, $sql);
    } else if ($findType == 'dia-diem') {
        if (isset($_POST['order-city']) && isset($_POST['order-district']) && isset($_POST['order-ward'])) {
            $city = $_POST['order-city'];
            $district = $_POST['order-district'];
            $ward = $_POST['order-ward'];

            $sql = "SELECT * FROM `orders` WHERE `city` = '{$city}' AND `district` = '{$district}' AND  `ward` = '{$ward}'";
            $result = mysqli_query($conn, $sql);
        }
    } else {
        $sql = "SELECT * FROM `orders`";
        $result = mysqli_query($conn, $sql);
    }
}
if (!isset($findType)) {
    $findType = "0";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">
    <!-- Jquery -->
    <script src="../../vendor/jquery/jquery-3.6.4.js"></script>
    <script src="../js/admin-order.js"></script>
    <title>Quản lý đơn hàng</title>
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
                    <a href="#">
                        <i class="fas fa-cart-shopping fs-3"></i><br>
                        Đơn Hàng
                    </a>
                </li>
                <li>
                    <a href="./admin-statistical.php">
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
                <h1 class="mb-4 text-dark">Đơn hàng</h1>
                <p style="font-size: 18px;;">
                    <?php
                    echo "Chào " . $_SESSION['logined-username'];
                    ?>
                </p>
            </div>
        </div>
        <div class="records-section-container">
            <form method="POST" class="record-header d-flex">
                <select name="find-by" id="find-by" style="padding: 5px; margin-right: 20px;">
                    <option value="" disabled selected>Tìm kiếm theo</option>
                    <option value="0">Tất cả đơn hàng</option>
                    <option value="tinh-trang">Tình trạng đơn hàng</option>
                    <option value="thoi-gian-dat-hang">Thời gian đặt hàng</option>
                    <option value="dia-diem">Địa điểm giao</option>
                </select>
                <div style="text-align: left; display: flex;">
                    <select name="find-by-status" id="find-by-status" style="display: none;">
                        <option value="">Chọn tình trạng</option>
                        <option value="0">Đã xác nhận</option>
                        <option value="1">Đã hoàn thành</option>
                        <option value="2">Đã hủy</option>
                    </select>
                    <div id="find-by-date" style="display: none;">
                        <label for="date-from">Từ: </label>
                        <input type="date" name="date-from">
                        <label for="date-to">Đến: </label>
                        <input type="date" name="date-to">
                    </div>
                    <div id="find-by-address" style="display: none;">
                        <label for="order-city">Thành phố:</label>
                        <select name="order-city" id="order-city">
                            <option value="">Chọn thành phố</option>
                            <?php
                            $cities = mysqli_query($connDGHCVN, "SELECT * FROM city");
                            while ($row = mysqli_fetch_assoc($cities)) {
                                echo "<option value={$row['city_id']}>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                        <label for="order-district">Quận/Huyện:</label>
                        <select name="order-district" id="order-district">
                        </select>
                        <label for="order-ward">Phường/Xã:</label>
                        <select name="order-ward" id="order-ward">
                        </select>
                    </div>
                    <input type="submit" class="btn btn-outline-success ms-3" style="display: none;" name="find-submit-btn" id="find-submit-btn" value="Tìm kiếm">
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="orders-table" width="100%">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">Mã đơn</th>
                        <th scope="col">Mã khách hàng</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Thành phố</th>
                        <th scope="col">Thời gian đặt hàng</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            $city = mysqli_query($connDGHCVN, "SELECT * FROM `city` WHERE `city_id` = {$row['city']}")->fetch_assoc();
                            $district = mysqli_query($connDGHCVN, "SELECT * FROM `district` WHERE `city_id` = {$row['city']} AND `district_id` = {$row['district']}")->fetch_assoc();
                            $ward = mysqli_query($connDGHCVN, "SELECT * FROM `wards` WHERE `district_id` = {$row['district']} AND `wards_id` = {$row['ward']}")->fetch_assoc();
                            echo "<td>" . $row['OrderID'] . "</td>";
                            echo "<td>" . $row['customer_id'] . "</td>";
                            echo "<td>" . $row['street'] . ", " . $ward['name'] . ", " . $district['name'] . "</td>";
                            echo "<td>" . $city['name'] . "</td>";
                            echo "<td>" . $row['order_date'] . "</td>";
                            if ($row['status'] == 0) {
                                echo "<td>Đã xác nhận</td>";
                            } else if ($row['status'] == 1) {
                                echo "<td>Đã hoàn thành</td>";
                            } else {
                                echo "<td>Đã hủy</td>";
                            }
                            echo '<td style="text-align: center;"><form method="POST" action="order-detail.php">';
                            echo '<button type="submit" class="btn btn-sm btn-outline-dark"><i class="fas fa-pen-to-square fw-light small"></i></button>';
                            echo '<input type="hidden" value="' . $row['OrderID'] . '" name="edit_order_id"></form></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td style='text-align: center' colspan='7'>Không có kết quả tìm kiếm</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>