<?php
session_start();
require '../../connects/connect.php';
require '../../connects/connectDGHCVN.php';

if (!isset($_SESSION['logined-username'])) {
    $_SESSION['error_message'] = "Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại!";
    header("Location: ../index.php");
}

$empty_message = "";
$error_username = "";
$error_password = ""; 

if (isset($_POST["themmoi"])) {
    
    $username = $_POST["admin-username"];
    $fullname = $_POST["admin-fullname"];
    $email = $_POST["admin-email"];
    $phone = $_POST["admin-phone"];
    $street = $_POST["admin-street"];
    $ward = $_POST["admin-ward"];
    $district = $_POST["admin-district"];
    $city = $_POST["admin-city"];
    $password = md5($_POST["admin-password1"]);
    $repassword = md5($_POST["admin-password2"]);

    $email_pattern = '/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/';
    $phone_pattern = '/^0\d{9}$/';
    $password_pattern = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';

    if (!empty($fullname) && !empty($username) && !empty($phone) && !empty($street) && !empty($email) && !empty($repassword)) {
        if (preg_match('/\s/', $username)) {
            $error_username = "Tên đăng nhập không được chứa khoảng trắng.";
        }
        if (!preg_match($phone_pattern, $phone)) {
            $empty_message = "Số điện thoại không hợp lệ. Vui lòng nhập lai.";
        }
        if (!preg_match($email_pattern, $email)) {
            $empty_message = "Email không hợp lệ. Vui lòng nhập lại.";
        }
        if ($password !== $repassword) {
            $error_password = "Mật khẩu nhập lại không khớp.";
        }
        if (!preg_match($password_pattern, $password)) {
            $error_password = "Mật khẩu phải ít nhất 8 ký tự, bao gồm ít nhất một chữ viết hoa và một chữ số.";
        }
    
        $check_username_sql = "SELECT * FROM manager WHERE username = '$username'";
        $result = $conn->query($check_username_sql);
        if ($result->num_rows > 0) {
            $error_username = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.";
        }
        if (empty($empty_message) && empty($error_username)) {
            $sql = "INSERT INTO `Manager`(username, fullname, email, phone, street, ward, district, city, password, status)
                VALUES ('{$username}', '{$fullname}', '{$email}', '{$phone}', '{$street}', '{$ward}', '{$district}', '{$city}', '{$password}', 1)";
            // mysqli_query($conn, $sql);
            // header("location: admin-istrator.php");
            if ($conn->query($sql) === TRUE) {
                header("location: admin-istrator.php");
                exit();
            } else {
                echo "Error: {$sql}" . $conn->error;
            }
        }
    } else {
        $empty_message = "Vui lòng điền đầy đủ thông tin.";
    }
}


if (isset($_POST["lock_username"])) {
    $sql = "SELECT status FROM Manager WHERE username ='" . $_POST["lock_username"] . "'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    if ($row['status'] == 1) {
        $sql = "UPDATE Manager SET status = 0 WHERE username ='" . $_POST["lock_username"] . "'";
        $result = mysqli_query($conn, $sql);
    } else {
        $sql = "UPDATE Manager SET status = 1 WHERE username ='" . $_POST["lock_username"] . "'";
        $result = mysqli_query($conn, $sql);
    }
    header("Location: admin-istrator.php");
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
    <script src="../js/admin-istrator.js"></script>
    <title>Quản trị viên</title>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-menu bg-dark">
            <ul>
                <li>
                    <a href="#">
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
                <h1 class="mb-4 text-dark">Quản trị viên</h1>
                <p style="font-size: 18px;;">
                    <?php
                    echo "Chào " . $_SESSION['logined-username'];
                    ?>
                </p>
            </div>
            <form method="POST" onsubmit="return checkForm()">
                <table id="input-table">
                    <tr>
                        <td><label for="admin-username">Tên tài khoản:</label></td>
                        <td><input size="45" type="text" name="admin-username" id="admin-username"></td>
                        <?php if(!empty($error_username)): ?>
                                        <div style="color: red;"><?php echo $error_username; ?></div>
                                    <?php endif; ?>
                    </tr>
                    <tr>
                        <td><label for="admin-fullname">Họ và tên:</label></td>
                        <td><input size="45" type="text" name="admin-fullname" id="admin-fullname"></td>
                    </tr>
                    <tr>
                        <td><label for="admin-email">Email:</label></td>
                        <td><input size="45" type="text" name="admin-email" id="admin-email"></td>
                    </tr>
                    <tr>
                        <td><label for="admin-phone">Số điện thoại:</label></td>
                        <td><input size="45" type="text" name="admin-phone" id="admin-phone"></td>
                    </tr>
                    <tr>
                        <td><label for="admin-street">Đường:</label></td>
                        <td><input size="45" type="text" name="admin-street" id="admin-street"></td>
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
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="admin-ward">Phường/Xã:</label><br>
                                <select name="admin-ward" id="admin-ward">
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="admin-password1">Mật khẩu:</label></td>
                        <td><input size="45" type="password" name="admin-password1" id="admin-password1"></td>
                        <?php if(!empty($error_password)): ?>
                                            <div style="color: red;"><?php echo $error_password; ?></div>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td><label for="admin-password2">Nhập lại mật khẩu:</label></td>
                        <td><input size="45" type="password" name="admin-password2" id="admin-password2"></td>
                        
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
            <!-- <div class="record-header">
                <div class="browse">
                    <input type="search" placeholder="Tìm kiếm" class="record-search">
                </div>
            </div> -->
            <div class="table-responsive">
                <table class="table table-bordered" id="user-table" width="100%">
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
                        $sql = "SELECT username, fullname, email, phone, street, city, district, ward, status FROM Manager";
                        $result = mysqli_query($conn, $sql);

                        while ($row = $result->fetch_array()) {
                            $city = mysqli_query($connDGHCVN, "SELECT * FROM `city` WHERE `city_id` = {$row['city']}")->fetch_assoc();
                            $district = mysqli_query($connDGHCVN, "SELECT * FROM `district` WHERE `city_id` = {$row['city']} AND `district_id` = {$row['district']}")->fetch_assoc();
                            $ward = mysqli_query($connDGHCVN, "SELECT * FROM `wards` WHERE `district_id` = {$row['district']} AND `wards_id` = {$row['ward']}")->fetch_assoc();
                            echo "<tr>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['fullname'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>{$row['street']} {$district['name']} {$ward['name']}</td>";
                            echo "<td>{$city['name']}</td>";
                            echo '<td>';
                            if(!($row['username'] == $_SESSION['logined-username'])) {
                                echo '<form method="POST" onsubmit="return changeStatus()">';
                                echo '<input type="hidden" name="lock_username" value="' . $row['username'] . '">';
                                if ($row['status'] == 1) {
                                    echo '<button type="submit" style="border: 0px; background-color: transparent;"><i class="fas fa-unlock fs-5"></i></button>';
                                } else {
                                    echo '<button type="submit" style="border: 0px; background-color: transparent;"><i class="fas fa-lock fs-5"></i></button>';
                                }
                                echo '</form>';
                            }
                            echo '</td>';
                            echo '<td><form method="POST" action="admin-istrator-edit.php">';
                            echo '<button type="submit" class="btn btn-sm btn-outline-dark"><i class="fas fa-pen-to-square fw-light small"></i></button>';
                            echo '<input type="hidden" value="' . $row['username'] . '" name="edit_username">';
                            echo '</form></td>';
                            echo "</tr>";
                        }
                        ;
                        ?>

                        <!-- <tr>
                            <td>nguyenquangvinh</td>
                            <td>Nguyễn Quang Vinh</td>
                            <td>quangvinhbeo@gmail.com</td>
                            <td>0987654321</td>
                            <td>273 An Dương Vương Phường 3 Quận 5</td>
                            <td>Thành phố Hồ Chí Minh</td>

                            <form action="admin-istrator.php" methor="post" onsubmit="return changeStatus()">
                                <input type="hidden" name="lock_username" value="nguyenquangvinh">
                                <td><button type="submit"><i class="fas fa-unlock fs-5"></i></button></td>
                            </form>
                            <td>
                                <button onclick="selectRowToEdit(this)" class="btn btn-sm btn-outline-dark"><i
                                        class="fas fa-pen-to-square fw-light small"></i></button>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>