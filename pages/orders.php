<?php
// Đảm bảo đã có kết nối $conn và $connDGHCVN và $_SESSION['customer_id']
?>

<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Time</th>
            <th>Receiver</th>
            <th>Address</th>
            <th>City</th>
            <th>Submit Order</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM `orders` WHERE `customer_id` = '{$_SESSION['customer_id']}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row_product = mysqli_fetch_assoc($result)) {
                $city = mysqli_query($connDGHCVN, "SELECT name FROM `city` WHERE `city_id` = {$row_product['city']}")->fetch_assoc();
                $district = mysqli_query($connDGHCVN, "SELECT name FROM `district` WHERE `city_id` = {$row_product['city']} AND `district_id` = {$row_product['district']}")->fetch_assoc();
                $ward = mysqli_query($connDGHCVN, "SELECT name FROM `wards` WHERE `district_id` = {$row_product['district']} AND `wards_id` = {$row_product['ward']}")->fetch_assoc();

                // Xác định thông báo trạng thái đơn hàng
                $message = match ((int)$row_product['status']) {
                    1 => "Completed Order",
                    2 => "Canceled Order",
                    default => "Confirmed Order"
                };
        ?>
                <tr>
                    <td><?php echo htmlspecialchars($row_product['OrderID']); ?></td>
                    <td><?php echo htmlspecialchars($row_product['order_date']); ?></td>
                    <td><?php echo htmlspecialchars($row_product['receiver']); ?></td>
                    <td>
                        <?php
                        echo htmlspecialchars($row_product['street']) . " " .
                            htmlspecialchars($district['name']) . " " .
                            htmlspecialchars($ward['name']);
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($city['name']); ?></td>
                    <td style="color: red;">
                        <?php echo $message; ?>
                        <p>
                            <a style="color: blue;" href="./orderDetails.php?OrderID=<?php echo $row_product['OrderID']; ?>">
                                (Click here to see the detail)
                            </a>
                        </p>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="6">You don\'t have any orders.</td></tr>';
        }
        ?>
    </tbody>
</table>
