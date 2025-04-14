<?php
require '../../connects/connect.php';
require '../../connects/connectDGHCVN.php';

$username = $_POST['edit_username'];
$sql = "SELECT * FROM `customer` WHERE `username` = '{$username}'";
$result = mysqli_query($conn, $sql);
$edit_row = $result->fetch_assoc();

if (
    isset($_POST["capnhat"]) && $_POST["capnhat"]
) {
    $username = $_POST["customer-username"];
    $fullname = $_POST["customer-fullname"];
    $email = $_POST["customer-email"];
    $phone = $_POST["customer-phone"];
    $street = $_POST["customer-street"];
    $ward = $_POST["customer-ward"];
    $district = $_POST["customer-district"];
    $city = $_POST["customer-city"];

    $sql = "UPDATE `customer` SET `fullname` = '$fullname', `email` = '$email', `phone` = '$phone', `street` = '$street', `city` = '$city', `district` = '$district', `ward` = '$ward'
    WHERE `username` = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: admin-customer.php");
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- Jquery -->
    <script src="../../vendor/jquery/jquery-3.6.4.js"></script>
    <script src="../js/admin-customer.js"></script>
    <title>Thay đổi thông tin</title>
</head>

<body class="d-flex justify-content-center mt-5">
    <form onsubmit="return checkForm()" method="POST" action="admin-customer-edit.php">
        <table id="input-table">
            <tr>
                <td><label for="customer-username">Tên tài khoản:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="customer-username" id="customer-username" value="' . $edit_row['username'] . '" readonly>';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="customer-fullname">Họ và tên:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="customer-fullname" id="customer-fullname" value="' . $edit_row['fullname'] . '">';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="customer-email">Email:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="customer-email" id="customer-email" value="' . $edit_row['email'] . '">';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="customer-phone">Số điện thoại:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="customer-phone" id="customer-phone" value="' . $edit_row['phone'] . '">';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="customer-street">Đường:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="customer-street" id="customer-street" value="' . $edit_row['street'] . '">';
                    ?>
                </td>
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
                            <option value="">Chọn quận huyện</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="customer-ward">Phường/Xã:</label><br>
                        <select name="customer-ward" id="customer-ward">
                            <option value="">Chọn phường xã</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr style="display: flex; justify-content: end;">
                <td>
                    <a href="admin-customer.php"><button type="button" class="btn btn-outline-dark ms-3">Quay
                            lại</button></a>
                    <input type="submit" name="capnhat" class="btn btn-outline-dark ms-3" value="Cập nhật">
                </td>
            </tr>
        </table>
    </form>
</body>

<?php
echo "<script>";
echo "$(document).ready(function () {";
echo "$('#customer-city').val('{$edit_row['city']}').trigger('change');";
echo "setTimeout(function() {";
echo "    $('#customer-district').val('{$edit_row['district']}').trigger('change');";
echo "}, 100);";
echo "setTimeout(function() {";
echo "    $('#customer-ward').val('{$edit_row['ward']}');";
echo "}, 200);";
echo "});";
echo "</script>";
?>


</html>