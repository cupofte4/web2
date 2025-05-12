<?php
include '../connection/connect.php';
include '../connection/connectDGHCVN.php';
session_start();
$notification="";
if(isset($_SESSION['notification'])){
    $notification=$_SESSION['notification'];
    unset($_SESSION['notification']);
    echo "<script> alert('{$notification}';</script>";

}
else{
    $notification="";
}
$sql = "SELECT MAX(`OrderID`) AS max_id FROM `orders`";
$results = mysqli_query($conn, $sql);
$order_id = mysqli_fetch_assoc($results);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- jQuery (required for the spinner functionality) -->
    <script src="../vendor/jquery/ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.min.js"></script>
    <!-- font-awesome -->
    <link rel="stylesheet" href="../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/bill.css">

    <!-- JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Bill</title>
</head>
<body>
    <div class="main-section" style="height: 100vh;">
        <h1 class="mb-5">Order ID: <?php echo $order_id['max_id']; ?></h1>
        <div class="d-flex align-items-start justify-content-between">
            <div class="left">
                <h4>Bill</h4>
                <table class="table">
                    <thead class="border-black border-bottom">
                        <tr>
                        <td scope="col" style="text-align: left;">Product's Name</td>
                            <td scope="col">Quantity</td>
                            <td scope="col">Price</td>
                            <td scope="col">Total price</td>
                        </tr>
                    </thead>
                    <tbody >
                        <?php
                        $total=0;
                        $sql = "SELECT * FROM orderdetail JOIN product ON orderdetail.ProductID=product.ProductID WHERE `OrderID`=" . $order_id['max_id'];
                        $result_orderDetails= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result_orderDetails)>0){
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
                                        <?php echo ($row_product['quantity'] * $row_product['price']) ?>
                                    </td>
                                </tr>
                            <?php }

                        }
                        ?>
                    </tbody>
                    <tr>
                        <td scope="col" style="text-align: left; font-weight: bold;" colspan="3">Total</td>
                        <td scope="col">
                            <?php echo $total; ?>
                        </td>
                    </tr>
                </table>
                <div style="display: flex; justify-content: end;">
                    <a href="../index.php">
                        <button class="btn btn-info" style="color: white;">Back</button>
                    </a>
                </div>
            </div>
            <div class="right">
                <div>
                    <div class="user-detail">
                        <?php
                        $sql = "SELECT * FROM orders WHERE `OrderID` = " . $order_id['max_id'];
                        $result = mysqli_query($conn, $sql);
                        $row_product = mysqli_fetch_assoc($result);

                        $city = mysqli_query($connDGHCVN, "SELECT * FROM `city` WHERE `city_id` = {$row_product['city']}")->fetch_assoc();
                        $district = mysqli_query($connDGHCVN, "SELECT * FROM `district` WHERE `city_id` = {$row_product['city']} AND `district_id` = {$row_product['district']}")->fetch_assoc();
                        $ward = mysqli_query($connDGHCVN, "SELECT * FROM `wards` WHERE `district_id` = {$row_product['district']} AND `wards_id` = {$row_product['ward']}")->fetch_assoc();
                        ?>
                        <h4>User Receiver</h4>
                        <hr>
                        <p><b>Name: </b><?php echo $row_product['receiver']; ?></p>
                        <p><b>Email: </b><?php echo $row_product['email']; ?></p>
                        <p><b>Phone: </b><?php echo $row_product['phone']; ?></p>
                        <p><b>Address: </b>
                            <?php echo $row_product['street'] . " " . $district['name'] . " " . $ward['name'] . " " . $city['name']; ?>
                        </p>
                        <p><b>Order Time:</b> <?php echo $row_product['order_date']; ?></p>
                    </div>
                </div>
                
            </div>
            </div>
        </div>
    </div>
</body>
</html>