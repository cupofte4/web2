<?php
require '../../connects/connect.php';
require '../../connects/connectDGHCVN.php';

$username = $_POST['edit_username'];
$sql = "SELECT * FROM `manager` WHERE `username` = '{$username}'";
$result = mysqli_query($conn, $sql);
$edit_row = $result->fetch_assoc();

if (
    isset($_POST["capnhat"]) && $_POST["capnhat"]
) {
    $username = $_POST["admin-username"];
    $fullname = $_POST["admin-fullname"];
    $email = $_POST["admin-email"];
    $phone = $_POST["admin-phone"];
    $street = $_POST["admin-street"];
    $ward = $_POST["admin-ward"];
    $district = $_POST["admin-district"];
    $city = $_POST["admin-city"];

    $sql = "UPDATE `manager` SET `fullname` = '$fullname', `email` = '$email', `phone` = '$phone', `street` = '$street', `city` = '$city', `district` = '$district', `ward` = '$ward'
    WHERE `username` = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: admin-istrator.php");
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
    <script src="../js/admin-istrator.js"></script>
    <title>Thay đổi thông tin</title>
</head>

<body class="d-flex justify-content-center mt-5">
    <form onsubmit="return checkForm()" method="POST">
        <table id="input-table">
            <tr>
                <td><label for="admin-username">Tên tài khoản:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="admin-username" id="admin-username" value="' . $edit_row['username'] . '" readonly>';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="admin-fullname">Họ và tên:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="admin-fullname" id="admin-fullname" value="' . $edit_row['fullname'] . '">';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="admin-email">Email:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="admin-email" id="admin-email" value="' . $edit_row['email'] . '">';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="admin-phone">Số điện thoại:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="admin-phone" id="admin-phone" value="' . $edit_row['phone'] . '">';
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="admin-street">Đường:</label></td>
                <td>
                    <?php
                    echo '<input size="45" type="text" name="admin-street" id="admin-street" value="' . $edit_row['street'] . '">';
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="admin-city">Thành phố:</label><br>
                        <select name="admin-city" id="admin-city">
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
                        <label for="admin-district">Quận/Huyện:</label><br>
                        <select name="admin-district" id="admin-district">
                            <option value="">Chọn quận huyện</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="admin-ward">Phường/Xã:</label><br>
                        <select name="admin-ward" id="admin-ward">
                            <option value="">Chọn phường xã</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr style="display: flex; justify-content: end;">
                <td>
                    <a href="admin-istrator.php"><button type="button" class="btn btn-outline-dark ms-3">Quay
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
echo "$('#admin-city').val('{$edit_row['city']}').trigger('change');";
echo "setTimeout(function() {";
echo "    $('#admin-district').val('{$edit_row['district']}').trigger('change');";
echo "}, 100);";
echo "setTimeout(function() {";
echo "    $('#admin-ward').val('{$edit_row['ward']}');";
echo "}, 200);";
echo "});";
echo "</script>";
?>


</html>