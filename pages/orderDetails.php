<?php
session_start();
require '../connection/connect.php';
require '../connection/connectDGHCVN.php';
$OrderID=$_GET['OrderID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAVES-OrderDetails</title>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css.map">
    <script src="../vendor/jquery/ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.min.js"></script>
    <link rel="stylesheet" href="../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/myInfo.css">
    <link rel="stylesheet" href="../assets/css/global.css">
</head>
<body>
    <div class="main-section" style="height: 100vh;">
        <div class="breadcrumb-container">
            <ul class="breadcrumb">
                <li><a href="./userInfo.php">Back</a></li>
                <li>Order of 
                    <?php echo $_SESSION['last_name'];
                    ?>
                </li>
            </ul>
        </div>
        <h1 class="mb-5">
            Order ID:
            <?php echo $OrderID; ?>
            
        </h1>
        <div class="d-flex align-items-start justify-content-between">
            <div class="left">
                <h4>Order</h4>
                <table class="table">
                    <thead class="border-black border-bottom">
                        <tr>
                            <td scope="col" style="text-align: left;">Product's Name</td>
                            <td scope="col">Quantity</td>
                            <td scope="col">Price</td>
                            <td scope="col">Total price</td>
                        </tr>
                    </thead>
                    <tbody style="max-height: 400px; overflow-y: auto;">
                        <?php
                        $total=0;
                        $sql = "SELECT * FROM orderdetail JOIN product ON orderdetail.ProductID=product.ProductID WHERE `OrderID`=$OrderID";
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
                                        <?php echo number_format($row_product['price']); ?>₫
                                    </td>
                                    <td>
                                        <?php echo number_format($row_product['quantity'] * $row_product['price']) ?>
                                    </td>
                                </tr>
                            <?php }

                        }
                        ?>
                    </tbody>
                </table>
                <div style="display: flex; justify-content: end;">
                    <a href="./userInfo.php">
                        <button class="btn btn-info" style="color: white;">Back</button>
                    </a>
                </div>
            </div>
            <div class="right">
                <div>
                    <div class="user-detail">
                        <?php
                        $sql = "SELECT * FROM orders WHERE `OrderID` = " . $_SESSION['OrderID'];
                        $result = mysqli_query($conn, $sql);
                        $row_product = mysqli_fetch_assoc($result);

                        $city = mysqli_query($connDGHCVN, "SELECT * FROM `city` WHERE `city_id` = {$row_product['city']}")->fetch_assoc();
                        $district = mysqli_query($connDGHCVN, "SELECT * FROM `district` WHERE `city_id` = {$row_product['city']} AND `district_id` = {$row_product['district']}")->fetch_assoc();
                        $ward = mysqli_query($connDGHCVN, "SELECT * FROM `wards` WHERE `district_id` = {$row_product['district']} AND `wards_id` = {$row_product['ward']}")->fetch_assoc();
                        ?>
                        <h4>User Info</h4>
                        <hr>
                        <p><b>Name: </b><?php echo $row_product['receiver']; ?>
                        </p>
                        <p><b>Email: </b><?php echo $row_product['email']; ?>
                        </p>
                        <p><b>Phone: </b><?php echo $row_product['phone']; ?>
                        </p>
                        <p><b>Address: </b>
                            <?php echo $row_product['street'] . " " . $district['name'] . " " . $ward['name'] . " " . $city['name'] ?>
                        </p>

                    </div>
                </div>
                <div class="order-detail">
                    <h4>Order Detail</h4>
                    <hr>
                    <?php
                    $message = "";
                    if ($row_product['status'] == 1) {
                        $message = "Order completed successfully";
                    } elseif ($row_product['status'] == 2) {
                        $message = "Order canceled";
                    } else {
                        $message = "Order confirmed";
                    }
                    ?>
                    <p><b>Order Status: </b><?php echo $message; ?>
                    </p>
                    <p><b>Order Time:</b> <?php echo $row_product['order_date']; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>