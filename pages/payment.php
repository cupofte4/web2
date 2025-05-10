<?php
include '../connection/connect.php';
include '../connection/connectDGHCVN.php';
session_start();

// Kiểm tra đăng nhập
// if (!isset($_SESSION['customer_id'])) {
//     header("Location: login.php");
//     exit(); // nên có để dừng chương trình sau redirect
// }

if (isset($_POST['submit-bill']) && $_POST['submit-bill']) {
    $customer_id = $_SESSION['customer_id'];
    $IsDefaultDeliveryInfo = $_POST['isDefaultInfo'];

    if ($IsDefaultDeliveryInfo == 1) {
        $sql = "SELECT * FROM `customer` WHERE `customer_id` = {$customer_id}";
        $result = mysqli_query($conn, $sql);
        $row_customer = mysqli_fetch_assoc($result);
        $receiver = $row_customer['first_name'] . ' ' . $row_customer['last_name'];
        $email = $row_customer['email'];
        $phone = $row_customer['phone'];
        $city = $row_customer['city'];
        $district = $row_customer['district'];
        $ward = $row_customer['ward'];
        $street = $row_customer['street'];
    } else {
        // Dùng thông tin được nhập tay
        $first_name = $_POST['receiver-first-name'] ?? '';
        $last_name = $_POST['receiver-last-name'] ?? '';
        $receiver = trim($first_name . ' ' . $last_name);
        $email = $_POST['receiver-email'];
        $phone = $_POST['receiver-phone'];
        $city = $_POST['receiver-city'];
        $district = $_POST['receiver-district'];
        $ward = $_POST['receiver-ward'];
        $street = $_POST['receiver-street'];
    }

    // Thêm đơn hàng mới
    $sql = "INSERT INTO `orders`(`OrderID`, `customer_id`, `receiver`, `email`, `phone`, `street`, `ward`, `district`, `city`, `status`, `order_date`) VALUES(
        NULL,
        {$customer_id},
        '{$receiver}',
        '{$email}',
        '{$phone}',
        '{$street}',
        '{$ward}',
        '{$district}',
        '{$city}',
        0,
        NOW())";
    $result1 = mysqli_query($conn, $sql);

    // Lấy ID của đơn hàng vừa thêm
    $sql = "SELECT MAX(`OrderID`) AS max_id FROM `orders`";
    $result2 = mysqli_query($conn, $sql);
    $order_id = mysqli_fetch_assoc($result2);

    // Thêm chi tiết từng sản phẩm
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT * FROM `product` WHERE `ProductID` = " . $product_id;
        $result3 = mysqli_query($conn, $sql);
        $row_product = mysqli_fetch_assoc($result3);

        $sql = "INSERT INTO `orderdetail`(`OrderID`, `ProductID`, `price`, `quantity`) VALUES(
            {$order_id['max_id']},
            {$product_id},
            {$row_product['price']},
            {$quantity})";
        $result4 = mysqli_query($conn, $sql);

        // Nếu sản phẩm đã bán thì cập nhật trạng thái
        if ($row_product['status'] == 0) {
            $sql = "UPDATE `product` SET `status` = 1 WHERE `ProductID` = " . $product_id;
            mysqli_query($conn, $sql);
        }
    }

    // Nếu đơn hàng thành công
    if ($result1) {
        unset($_SESSION['cart']);
        $_SESSION['notification'] = "Thanh toán thành công!";
        header("Location: ./bill.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/payment.css">
</head>

<body>
    <main class="checkout-container">
        <form class="container" method="POST" id="sahur" onsubmit="return kiemTra()">
            <div class="checkout-layout" style="display: flex; gap: 30px; align-items: flex-start;">

                <!-- BÊN TRÁI -->
                <div class="payment-section" style="flex: 1;">
                    <div class="card billing-info">
                        <span class="h2">RECIPIENT INFORMATION</span>
                        <hr>
                        <h2>SHIPPING ADDRESS</h2>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <button type="button" onclick="defaultDeliveryInfo(true)">Default</button>
                            <button type="button" onclick="defaultDeliveryInfo(false)">Change</button>
                        </div>

                        <?php
                        // Use prepared statements for queries to prevent SQL injection
                        $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
                        $stmt->bind_param("i", $customer_id); // 'i' for integer
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row_customer = $result->fetch_assoc();
                        ?>

                        <div class="form-group">
                            <div class="name-group" style="display: flex; gap: 20px;">
                                <div style="flex: 1;">
                                    <label for="receiver-first-name">First name</label>
                                    <input type="text" class="form-control" id="receiver-first-name"
                                        name="receiver-first-name" value="<?php echo $row_customer['first_name']; ?>"
                                        disabled>
                                </div>

                                <div style="flex: 1;">
                                    <label for="receiver-last-name">Last name</label>
                                    <input type="text" class="form-control" id="receiver-last-name"
                                        name="receiver-last-name" value="<?php echo $row_customer['last_name']; ?>"
                                        disabled>
                                </div>
                            </div>

                            <div class="name-group" style="display: flex; gap: 20px;">
                                <div style="flex: 2;">
                                    <label for="receiver-email">Email</label>
                                    <input type="email" class="form-control" id="receiver-email" name="receiver-email"
                                        value="<?php echo $row_customer['email']; ?>" disabled>
                                </div>

                                <div style="flex: 1;">
                                    <label for="receiver-phone">Phone number</label>
                                    <input type="text" class="form-control" name="receiver-phone" id="receiver-phone"
                                        value="<?php echo $row_customer['phone'] ?>" disabled>
                                </div>
                            </div>

                            <div class="location-group" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <div style="flex: 1;">
                                    <label for="receiver-city">City</label>
                                    <select name="receiver-city" id="receiver-city" class="form-control" disabled>
                                        <option value="">Choose a city</option>
                                        <?php
                                        $cities = mysqli_query($connDGHCVN, "SELECT * FROM city");
                                        while ($row = mysqli_fetch_assoc($cities)) {
                                            echo "<option value={$row['city_id']}>{$row['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div style="flex: 1;">
                                    <label for="receiver-district">District</label>
                                    <select name="receiver-district" id="receiver-district" class="form-control"
                                        disabled>
                                    </select>
                                </div>

                                <div style="flex: 1;">
                                    <label for="receiver-ward">Ward</label>
                                    <select name="receiver-ward" id="receiver-ward" class="form-control" disabled>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="receiver-street">Address</label>
                                <input type="text" class="form-control" id="receiver-street" name="receiver-street"
                                    value="<?php echo $row_customer['street'] ?>" disabled>
                            </div>
                        </div>

                        <div class="payment-method">
                            <h3>Payment method</h3>
                            <div class="form-check" onclick="showBankPayment(false)">
                                <label class="payment-box">
                                    <input type="radio" name="paymentMethod" value="cod" id="radioCheck1">
                                    Cash on Delivery (COD)
                                </label>
                            </div>

                            <div class="form-check" onclick="showBankPayment(true)">
                                <label class="payment-box">
                                    <input type="radio" name="paymentMethod" value="bank" id="radioCheck2">
                                    Transfer by bank card
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="isDefaultInfo" id="isDefaultInfo" value="1">

                    </div>
                </div>

                <!-- BÊN PHẢI -->
                <div class="order-summary" style="width: 35%;">
                    <div class="d-none" id="bank-payment-input">
                        <div class="form-group">
                            <label for="bank-number">Card Number</label>
                            <input type="text" id="bank-number" class="form-control" placeholder="1234 5678 9101 1234">
                        </div>

                        <div class="form-group">
                            <label for="bank-name">Cardholder Name</label>
                            <input type="text" id="bank-name" class="form-control" placeholder="NGUYEN VAN A">
                        </div>

                        <div style="display: flex;">
                            <div class="form-group" style="flex: 1;">
                                <label for="bank-expired">Expiry Date</label>
                                <input type="text" id="bank-expired" class="form-control" placeholder="MM/YY">
                            </div>

                            <div class="form-group" style="flex: 1; margin-left: 10px;">
                                <label for="bank-cvc">CVC</label>
                                <input type="text" id="bank-cvc" class="form-control" placeholder="123">
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card summary-card">
                        <span class="h2">ORDERS LIST</span>
                        <div style="display: flex; justify-content: space-between;">
                            <div style="width: 50%; text-align: justify;">Name</div>
                            <div style="width: 15%; text-align: justify;">Price</div>
                            <div style="width: 5%; text-align: justify;">Qty</div>
                            <div style="width: 15%; text-align: end;">Total</div>
                        </div>
                        <div style="display: flex; flex-direction: column; max-height: 150px; overflow-y: auto;">
                            <?php
                            $total = 0;
                            $count = 1;
                            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                $sql = "SELECT * FROM `product` WHERE `ProductID` = " . $product_id;
                                $result = mysqli_query($conn, $sql);
                                $row_product = mysqli_fetch_assoc($result);
                                echo '<div style="display: flex; justify-content: space-between;">';
                                echo '<div style="width: 50%; text-align: justify;">' . $count . ") " . $row_product['name'] . '</div>';
                                echo '<div style="width: 15%; text-align: justify;">' . number_format($row_product['price'], 0, '.', ',') . '₫</div>';
                                echo '<div style="width: 5%; text-align: justify;">' . $quantity . '</div>';
                                echo '<div style="width: 15%; text-align: end;">' . number_format($row_product['price'] * $quantity, 0, '.', ',') . '₫</div>';
                                echo '</div>';
                                $total += ($row_product['price'] * $quantity);
                                $count++;
                            }
                            ?>
                        </div>
                        <hr>
                        <div class="summary-section">
                            <div class="d-flex justify-content-between">
                                <div><b>Total</b></div>
                                <div style="font-weight: bold">
                                    <span>
                                        <?php
                                        echo number_format($total, 0, '.', ',');
                                        ?>
                                    </span>₫
                                </div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <a href="./cart.php" class="button-wrapper">
                                <input type="button" class="btn back" value="Back">
                            </a>
                            <div class="button-wrapper">
                                <input type="submit" name="submit-bill" class="btn purchase"
                                    value="Confirm your purchase">
                            </div>
                        </div>

                        <p class="secure-text">Secure and encrypted payments</p>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        var bankPayment = false;
        var IsDefaultDeliveryInfo = document.getElementById('isDefaultInfo');
        IsDefaultDeliveryInfo.value = "1";

        function defaultDeliveryInfo(choice) {
            var firstName = document.getElementById('receiver-first-name'),
                lastName = document.getElementById('receiver-last-name'),
                email = document.getElementById('receiver-email'),
                phone = document.getElementById('receiver-phone'),
                city = document.getElementById('receiver-city'),
                ward = document.getElementById('receiver-ward'),
                district = document.getElementById('receiver-district'),
                street = document.getElementById('receiver-street');

            if (choice) {
                firstName.disabled = true;
                lastName.disabled = true;
                email.disabled = true;
                phone.disabled = true;
                city.disabled = true;
                district.disabled = true;
                ward.disabled = true;
                street.disabled = true;

                firstName.value = "<?php echo $row_customer['first_name'] ?>";
                lastName.value = "<?php echo $row_customer['last_name'] ?>";
                email.value = "<?php echo $row_customer['email'] ?>";
                phone.value = "<?php echo $row_customer['phone'] ?>";
                city.value = "<?php echo $row_customer['city'] ?>";
                city.dispatchEvent(new Event('change'));

                setTimeout(function() {
                    district.value = "<?php echo $row_customer['district'] ?>";
                    district.dispatchEvent(new Event('change'));
                }, 150);

                setTimeout(function() {
                    ward.value = "<?php echo $row_customer['ward'] ?>";
                }, 300);

                street.value = "<?php echo $row_customer['street'] ?>";
                IsDefaultDeliveryInfo.value = "1";
            } else {
                firstName.disabled = false;
                lastName.disabled = false;
                email.disabled = false;
                phone.disabled = false;
                city.disabled = false;
                district.disabled = false;
                ward.disabled = false;
                street.disabled = false;

                firstName.value = "";
                lastName.value = "";
                email.value = "";
                phone.value = "";
                city.value = "";
                city.dispatchEvent(new Event('change'));
                street.value = "";
                IsDefaultDeliveryInfo.value = "0";
            }
        }

        function showBankPayment(choice) {
            var bank_payment_input = document.getElementById('bank-payment-input');
            if (choice) {
                bank_payment_input.classList.remove('d-none');
                bankPayment = true;
            } else {
                bank_payment_input.classList.add('d-none');
                document.getElementById('bank-number').setAttribute('value', "");
                document.getElementById('bank-name').setAttribute('value', "");
                document.getElementById('bank-expired').setAttribute('value', "");
                document.getElementById('bank-cvc').setAttribute('value', "");
                bankPayment = false;
            }
        }

        function kiemTra() {
            var firstName = document.getElementById('receiver-first-name'),
                lastName = document.getElementById('receiver-last-name'),
                email = document.getElementById('receiver-email'),
                phone = document.getElementById('receiver-phone'),
                city = document.getElementById('receiver-city'),
                ward = document.getElementById('receiver-ward'),
                district = document.getElementById('receiver-district'),
                street = document.getElementById('receiver-street');

            if (IsDefaultDeliveryInfo.value == "0" && (firstName.value === "" || lastName.value === "" || email.value === "" || phone.value === "" || city.value === "" || ward.value === "" || district.value === "" || street.value === "")) {
                alert("Please fill in all the delivery information.");
                return false;
            }

            var radioButtonChecked = false;
            var radioButtons = document.getElementsByName('paymentMethod');
            for (var i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    radioButtonChecked = true;
                    break;
                }
            }
            if (!radioButtonChecked) {
                alert("Please select a payment method.");
                return false;
            }

            if (bankPayment) {
                var bankNumber = document.getElementById('bank-number'),
                    bankName = document.getElementById('bank-name'),
                    bankExpired = document.getElementById('bank-expired'),
                    bankCVC = document.getElementById('bank-cvc');

                if (bankNumber.value === "" || bankName.value === "" || bankExpired.value === "" || bankCVC.value === "") {
                    alert("Please enter full card information.");
                    return false;
                }
            }
            return true;
        }
    </script>

    <?php
    echo "<script>";
    echo "$(document).ready(function () {";
    echo "$('#receiver-city').val('{$row_customer['city']}').trigger('change');";
    echo "setTimeout(function() {";
    echo "    $('#receiver-district').val('{$row_customer['district']}').trigger('change');";
    echo "}, 150);";
    echo "setTimeout(function() {";
    echo "    $('#receiver-ward').val('{$row_customer['ward']}');";
    echo "}, 300);";
    echo "});";
    echo "</script>";
    ?>

</body>

</html>