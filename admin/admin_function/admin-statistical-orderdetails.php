<?php
session_start();
require '../../connection/connect.php';
require '../../connection/connectDGHCVN.php';
$OrderID = $_GET['OrderID'];
$username = $_GET['username'];
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
    <!-- jQuery (required for the spinner functionality) -->
    <script src="../vendor/jquery/ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.min.js"></script>
    <!-- fontawesome -->
    <link rel="stylesheet" href="../../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/idk.css">
    <link rel="stylesheet" href="../css/global.css">
    <title>Hóa đơn chi tiết</title>
</head>

<body>
    <div class="main-section" style="height: 100vh">
        <h1 class="mb-5">Mã đơn hàng:
            <?php echo $OrderID; ?>
        </h1>
        <div class="d-flex align-items-start justify-content-between">
            <div class="left">
                <h4>Hóa đơn</h4>
                <table class="table">
                    <thead class="border-black border-bottom">
                        <tr>
                            <td scope="col" style="text-align: left;">Tên sản phẩm</td>
                            <td scope="col">Số lượng</td>
                            <td scope="col">Giá </td>
                            <td scope="col">Tổng</td>
                        </tr>
                    </thead>
                    <tbody style="max-height: 400px; overflow-y: auto;">
                        <?php
                        $total = 0;
                        $sql = "SELECT * FROM oderdetail JOIN product ON oderdetail.ProductID = product.ProductID WHERE `OrderID` = " . $OrderID ;
                        $result_orderDetails = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result_orderDetails) > 0) {
                            while ($row_product = mysqli_fetch_assoc($result_orderDetails)) {
                                $total += $row_product['quantity'] * $row_product['price'];
                                ?>
                                <tr>
                                    <td style="text-align: left;">
                                        <?php echo $row_product['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_product['quantity']; ?>
                                    </td>
                                    <td>
                                        <?php echo ($row_product['price']); ?>$
                                    </td>
                                    <td>
                                        <?php echo ($row_product['quantity'] * $row_product['price']) ?>$
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                    <tr>
                        <td scope="col" style="text-align: left; font-weight: bold;" colspan="3">Tổng tiền</td>
                        <td scope="col">
                            <?php echo ($total) ?>$
                        </td>
                    </tr>
                </table>
                <div style="display: flex; justify-content: end;">
                    <a href="./admin-statistical-edit.php?username=<?php echo $username; ?>">
                        <button class="btn btn-info" style="color: white;">Quay lại</button>
                    </a>
                </div>
            </div>
            <div class="right">
                <div>
                    <div class="user-detail">
                        <?php
                        $sql = "SELECT * FROM orders WHERE `OrderID` = " . $OrderID;
                        $result = mysqli_query($conn, $sql);
                        $row_product = mysqli_fetch_assoc($result);

                        $city = mysqli_query($connDGHCVN, "SELECT * FROM `city` WHERE `city_id` = {$row_product['city']}")->fetch_assoc();
                        $district = mysqli_query($connDGHCVN, "SELECT * FROM `district` WHERE `city_id` = {$row_product['city']} AND `district_id` = {$row_product['district']}")->fetch_assoc();
                        $ward = mysqli_query($connDGHCVN, "SELECT * FROM `wards` WHERE `district_id` = {$row_product['district']} AND `wards_id` = {$row_product['ward']}")->fetch_assoc();
                        ?>
                        <h4>Thông tin người nhận hàng</h4>
                        <hr>
                        <p><b>Họ tên: </b><?php echo $row_product['receiver']; ?>
                        </p>
                        <p><b>Email: </b><?php echo $row_product['email']; ?>
                        </p>
                        <p><b>SĐT: </b><?php echo $row_product['phone']; ?>
                        </p>
                        <p><b>Địa chỉ: </b>
                            <?php echo $row_product['street'] . " " . $district['name'] . " " . $ward['name'] . " " . $city['name'] ?>
                        </p>

                    </div>
                </div>
                <div class="order-detail">
                    <h4>Thông tin đơn hàng</h4>
                    <hr>
                    <?php
                    $message = "";
                    if ($row_product['status'] == 1) {
                        $message = "Đã hoàn thành đơn hàng";
                    } elseif ($row_product['status'] == 2) {
                        $message = "Đã hủy đơn hàng";
                    } else {
                        $message = "Đã xác nhận đơn hàng";
                    }
                    ?>
                    <p><b>Tình trạng đơn hàng: </b><?php echo $message; ?>
                    </p>
                    <p><b>Thời gian đặt hàng:</b> <?php echo $row_product['order_date']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>