<?php
include '../../connection/connect.php';
include '../../connection/connectDGHCVN.php';

$order_id = $_POST['edit_order_id'];

if(isset($_POST['thaydoi']) && $_POST['thaydoi']) {
    $sql = "UPDATE `orders` SET `status` = " . $_POST['changed-status'] . " WHERE `OrderID` = " . $_POST['edit-order-id'];
    $result = mysqli_query($conn, $sql);
    if($result) {
        header("Location: ./admin-order.php")   ;
    }
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
    <link rel="stylesheet" href="../css/order-detail.css">
    <link rel="stylesheet" href="../css/global.css">
    <title>Đơn hàng</title>
</head>

<body>
    <form method="POST">
        <div class="main-section" style="height: 100vh">
            <h1 class="mb-5">Mã đơn hàng:
                <?php echo $order_id; ?>
            </h1>
            <div class="d-flex align-items-start justify-content-between">
                <div class="left">
                    <h4>Hóa đơn</h4>
                    <table class="table">
                        <thead class="border-black border-bottom">
                            <tr>
                                <td scope="col" style="text-align: left">Tên sản phẩm</td>
                                <td scope="col">Số lượng</td>
                                <td scope="col">Giá </td>
                                <td scope="col">Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $sql = "SELECT * FROM oderdetail JOIN product ON oderdetail.ProductID = product.ProductID WHERE `OrderID` = " . $order_id;
                            $result_orderDetails = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result_orderDetails) > 0) {
                                while ($row_product = mysqli_fetch_assoc($result_orderDetails)) {
                                    $total += $row_product['quantity'] * $row_product['price'];
                                    ?>
                                    <tr style="text-align: center;">
                                        <td style="text-align: left">
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
                        <input type="submit" class="btn btn-info" style="color: white;" name="thaydoi" value="Xác nhận">
                    </div>
                </div>
                <div class="right">
                    <div>
                        <div class="user-detail">
                            <?php
                            $sql = "SELECT * FROM orders WHERE `OrderID` = " . $order_id;
                            $result = mysqli_query($conn, $sql);
                            $row_order = mysqli_fetch_assoc($result);

                            $city = mysqli_query($connDGHCVN, "SELECT * FROM `city` WHERE `city_id` = {$row_order['city']}")->fetch_assoc();
                            $district = mysqli_query($connDGHCVN, "SELECT * FROM `district` WHERE `city_id` = {$row_order['city']} AND `district_id` = {$row_order['district']}")->fetch_assoc();
                            $ward = mysqli_query($connDGHCVN, "SELECT * FROM `wards` WHERE `district_id` = {$row_order['district']} AND `wards_id` = {$row_order['ward']}")->fetch_assoc();
                            ?>
                            <h4>Thông tin người nhận hàng</h4>
                            <hr>
                            <p><b>Họ tên: </b><?php echo $row_order['receiver']; ?>
                            </p>
                            <p><b>Email: </b><?php echo $row_order['email']; ?>
                            </p>
                            <p><b>SĐT: </b><?php echo $row_order['phone']; ?>
                            </p>
                            <p><b>Địa chỉ: </b>
                                <?php echo $row_order['street'] . " " . $district['name'] . " " . $ward['name'] . " " . $city['name'] ?>
                            </p>
                            <p><b>Thời gian đặt hàng:</b> <?php echo $row_order['order_date']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="order-detail">
                        <h4>Thông tin đơn hàng</h4>
                        <hr>
                        <label for="order-status">Tình trạng đơn hàng:</label>
                        <select name="order-status" id="order-status" onchange="a()">
                            <option value="0">Đã xác nhận</option>
                            <option value="1">Đã hoàn thành</option>
                            <option value="2">Đã hủy</option>
                        </select>
                        <input type="hidden" value="<?php echo $row_order['status'] ?>" name="changed-status" id="changed-status">
                        </p>
                        <p><b>Thời gian đặt hàng:</b> <?php echo $row_order['order_date']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="edit-order-id" value="<?php echo $order_id ?>">
    </form>
</body>
<?php
echo "<script>
        if({$row_order["status"]} == 1) {
            document.getElementById('order-status').disabled = true;
            document.getElementById('changed-status').value = 1;
        }
        document.getElementById('order-status').value = '{$row_order["status"]}';
        function a() {
            document.getElementById('changed-status').value = document.getElementById('order-status').value;
        }
    </script>";
?>

</html>