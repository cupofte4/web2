<?php
session_start();
require '../../connection/connect.php';
require '../../connection/connectDGHCVN.php';

if (!isset($_SESSION['logined-username'])) {
    $_SESSION['error_message'] = "Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại!";
    header("Location: ../");
    exit;
}

if (isset($_POST["themmoi"])) {
    $first_name = $_POST["customer-first-name"];
    $last_name = $_POST["customer-last-name"];
    $email = $_POST["customer-email"];
    $phone = $_POST["customer-phone"];
    $street = $_POST["customer-street"];
    $ward = $_POST["customer-ward"];
    $district = $_POST["customer-district"];
    $city = $_POST["customer-city"];
    $password = md5($_POST["customer-password1"]);

    $sql = "INSERT INTO `customer`(first_name, last_name, email, phone, street, ward, district, city, password, status)
            VALUES ('{$first_name}', '{$last_name}', '{$email}', '{$phone}', '{$street}', '{$ward}', '{$district}', '{$city}', '{$password}', 1)";
    mysqli_query($conn, $sql);
    header("location: admin-customer.php");
    exit;
}

if (isset($_POST["lock_customer_id"])) {
    $customer_id = $_POST["lock_customer_id"];
    $sql = "SELECT status FROM `customer` WHERE customer_id = $customer_id";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $new_status = ($row['status'] == 1) ? 0 : 1;
    mysqli_query($conn, "UPDATE `customer` SET status = $new_status WHERE customer_id = $customer_id");
    header("location: admin-customer.php");
    exit;
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
    <script src="../js/admin-customer.js"></script>
    <title>Quản lý khách hàng</title>
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
                    <a href="#">
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
                    <a href="./admin-statistical.php">
                        <i class="fas fa-chart-line fs-3"></i><br>
                        Thống Kê
                    </a>
                </li>
                <li>
                    <a href="./admin-logout.php">
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
                <h1 class="mb-4 text-dark">Khách Hàng</h1>
                <p style="font-size: 18px;">
                    <?php
                    echo "Chào " . $_SESSION['logined-username'];
                    ?>
                </p>
            </div>

            <form method="POST" onsubmit="return checkForm()">
                <table id="input-table">
                    <tr>
                        <td><label for="customer-first-name">Họ:</label></td>
                        <td><input size="45" type="text" name="customer-first-name" id="customer-first-name"></td>
                    </tr>

                    <tr>
                        <td><label for="customer-last-name">Tên:</label></td>
                        <td><input size="45" type="text" name="customer-last-name" id="customer-last-name"></td>
                    </tr>

                    <tr>
                        <td><label for="customer-email">Email:</label></td>
                        <td><input size="45" type="text" name="customer-email" id="customer-email"></td>
                    </tr>

                    <tr>
                        <td><label for="customer-phone">Số điện thoại:</label></td>
                        <td><input size="45" type="text" name="customer-phone" id="customer-phone"></td>
                    </tr>

                    <tr>
                        <td><label for="customer-street">Đường:</label></td>
                        <td><input size="45" type="text" name="customer-street" id="customer-street"></td>
                    </tr>

                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="customer-city">Thành phố:</label><br>
                                <select name="customer-city" id="customer-city">
                                    <option value="">Chọn thành phố</option>
                                    <?php
                                    $cities = mysqli_query($connDGHCVN, "SELECT * FROM city");
                                    while ($row = mysqli_fetch_assoc($cities)) {
                                        echo "<option value={$row['city_id']}>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="customer-district">Quận/Huyện:</label><br>
                                <select name="customer-district" id="customer-district">
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="customer-ward">Phường/Xã:</label><br>
                                <select name="customer-ward" id="customer-ward">
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="customer-password1">Mật khẩu:</label></td>
                        <td><input size="45" type="password" name="customer-password1" id="customer-password1"></td>
                    </tr>
                    <tr>
                        <td><label for="customer-password2">Nhập lại mật khẩu:</label></td>
                        <td><input size="45" type="password" name="customer-password2" id="customer-password2"></td>
                    </tr>
                    <tr style="display: flex; justify-content: end;">
                        <td>
                            <input type="reset" class="btn btn-outline-dark" value="Dọn">
                            <input type="submit" name="themmoi" class="btn btn-outline-dark ms-3" value="Thêm">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="records-section-container">
            <div class="table-responsive">
                <table class="table table-bordered" id="customer-table" width="100%">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Tên tài khoản</th>
                            <th scope="col">Họ và tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Thành phố</th>
                            <th scope="col">Khóa</th>
                            <th scope="col">Sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       $sql = "SELECT customer_id, first_name, last_name, email, phone, street, city, district, ward, status FROM `customer`";
                       $result = mysqli_query($conn, $sql);
                       
                       while ($row = $result->fetch_array()) {
                           $city = mysqli_query($connDGHCVN, "SELECT name FROM `city` WHERE `city_id` = {$row['city']}")->fetch_assoc();
                           $district = mysqli_query($connDGHCVN, "SELECT name FROM `district` WHERE `city_id` = {$row['city']} AND `district_id` = {$row['district']}")->fetch_assoc();
                           $ward = mysqli_query($connDGHCVN, "SELECT name FROM `wards` WHERE `district_id` = {$row['district']} AND `wards_id` = {$row['ward']}")->fetch_assoc();
                       
                           echo "<tr>";
                           echo "<td>" . $row['customer_id'] . "</td>";
                           echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                           echo "<td>" . $row['email'] . "</td>";
                           echo "<td>" . $row['phone'] . "</td>";
                           echo "<td>{$row['street']}, {$ward['name']}, {$district['name']} </td>";
                           echo "<td>{$city['name']}</td>";
                           echo '<td style="text-align: center"><form method="POST" onsubmit="return changeStatus()">';
                           echo '<input type="hidden" name="lock_customer_id" value="' . $row['customer_id'] . '">';
                           if ($row['status'] == 1) {
                               echo '<button type="submit" style="border: 0px; background-color: transparent;"><i class="fas fa-unlock fs-5"></i></button>';
                           } else {
                               echo '<button type="submit" style="border: 0px; background-color: transparent;"><i class="fas fa-lock fs-5"></i></button>';
                           }
                           echo '</form></td>';
                           echo '<td style="text-align: center;"><form method="POST" action="admin-customer-edit.php">';
                           echo '<input type="hidden" value="' . $row['customer_id'] . '" name="edit_customer_id">';
                           echo '<button type="submit" class="btn btn-sm btn-outline-dark"><i class="fas fa-pen-to-square fw-light small"></i></button>';
                           echo '</form></td>';
                           echo "</tr>";
                       }                       
                        ;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>