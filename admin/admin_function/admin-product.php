<?php
session_start();
require '../../connection/connect.php';
if (!isset($_SESSION['logined-username'])) {
    $_SESSION['error_message'] = "Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại!";
    header("Location: ../index.php");
}
if (isset($_POST['them']) && $_POST['them']) {
    $tmp_name = $_FILES["product-image-url"]["tmp_name"];
    $fldimageurl = "../../images/products/" . $_FILES["product-image-url"]["name"];
    move_uploaded_file($tmp_name, $fldimageurl);

    $sql = "INSERT INTO `product`(`ProductID`, `name`, `image`, `category_id`, `type_id`, `price`, `description`, `status`) VALUES(
        NULL, 
        '{$_POST["product-name"]}', 
        '{$_FILES["product-image-url"]["name"]}', 
        '{$_POST["product-category"]}', 
        '{$_POST["product-type"]}', 
        '{$_POST["product-price"]}', 
        '{$_POST["product-description"]}', 
        0)";

    $result = mysqli_query($conn, $sql);
    if ($result)
        header("Location: admin-product.php");
}

if (isset($_POST['xoa']) && $_POST['xoa']) {
    $remove_product_id = $_POST['remove-product-id'];
    $sql = "DELETE FROM `product` WHERE `ProductID` = {$remove_product_id}";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: admin-product.php");
    }
}

if (isset($_POST['an']) && $_POST['an']) {
    $hide_product_id = $_POST['hide-product-id'];
    $sql = "UPDATE `product` SET `status` = 2 WHERE `ProductID` = {$hide_product_id}";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: admin-product.php");
    }
}

if (isset($_POST['hien']) && $_POST['hien']) {
    $show_product_id = $_POST['show-product-id'];
    $sql = "UPDATE `product` SET `status` = 1 WHERE `ProductID` = {$show_product_id}";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: admin-product.php");
    }
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
    <title>Quản lý sản phẩm</title>
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
                    <a href="./admin-customer.php">
                        <i class="fas fa-user fs-3"></i><br>
                        Khách Hàng
                    </a>
                </li>
                <li>
                    <a href="#">
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
                    <a href="./admin-logout.php" class="text-decoration-none text-white">
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
                <h1 class="mb-4 text-dark">Sản Phẩm</h1>
                <p style="font-size: 18px;;">
                    <?php
                    echo "Chào " . $_SESSION['logined-username'];
                    ?>
                </p>
            </div>
            <form method="POST" onsubmit="return kiemTra()" enctype="multipart/form-data">
                <table id="product-input-table">
                    <tr>
                        <td>
                            <div>
                                <label for="product-name">Tên sản phẩm</label>
                                <input size="34" type="text" name="product-name" id="product-name">
                            </div>
                        </td>
                        <td>
                            <label for="product-category">Danh mục</label>
                            <select name="product-category" id="product-category" style="width: 288px;">
                                <option value="" disabled selected>Chọn danh mục -</option>
                                <option value="men">Đồ Nam</option>
                                <option value="women">Đồ Nữ</option>
                                <option value="whatsnew">Đồ mới</option>
                        </td>
                    </tr>
                    <tr>
                    <td>
                            <div>
                                <label for="product-img">Hình ảnh</label>
                                <input type="file" name="product-image-url" id="product-image-url"
                                    onchange="loadFile(event)" style="outline: none; border: none;">
                            </div>
                        </td>
                        <td>
                            <div>
                                <label for="product-type">Thể loại</label>
                                <select name="product-type" id="product-type" style="width: 288px;">
                                    <option value="" disabled selected>Chọn thể loại -</option>
                                    <option value="jacket">Jacket</option>
                                    <option value="jean">Jean</option>
                                    <option value="sweatshirt">Sweatshirt</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td rowspan="1">
                            <div class="img-display-container" style="display: flex;">
                                <p>Xem trước ảnh</p>
                                <img id="selected-img" height="80px" style="margin-right: 45%;">
                            </div>
                        </td>
                    </tr>

                    <tr>
                    <td>
                            <div>
                                <label for="product-price">Giá</label>
                                <input size="34" type="text" name="product-price" id="product-price">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="product-description" class="mb-1">Thông tin sản phẩm</label><br>
                            <textarea name="product-description" id="product-description" rows="5"
                                cols="125"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="d-flex justify-content-end">
                                <input type="reset" class="btn btn-outline-dark ms-3" value="Làm lại">
                                <input type="submit" class="btn btn-outline-dark ms-3" name="them" value="Thêm">
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>


        <div class="records-section-container">
            <div class="table-responsive">
                <table class="table table-bordered" id="product-table" width="100%">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Mã sản phẩm</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Thể loại</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Chỉnh sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM product";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td style="text-align: center;">' . $row["ProductID"] . '</td>';
                            echo '<td style="text-align: center;"><img src="../../images/products/' . $row["image"] . '"></td>';
                            echo '<td>' . $row["name"] . '</td>';
                            echo '<td>' . $row["category_id"] . '</td>';
                            echo '<td>' . $row["type_id"] . '</td>';
                            echo '<td>' . number_format($row["price"], 0, '.', ',') . '</td>';
                            if ($row["status"] == 0 || $row["status"] == 1) {
                                echo '<td style="text-align: center"><i class="fas fa-eye"></i></td>';
                            } else {
                                echo '<td style="text-align: center"><i class="fas fa-eye-slash"></i></td>';
                            };
                            echo '<td>';
                            echo '<form method="POST" action="admin-product-edit.php" style="display: inline-block; margin-right: 3px;">';
                            echo '<input type="hidden" name="edit_product_id" value="' . $row["ProductID"] . '">';
                            echo '<button type="submit" class="btn btn-sm btn-outline-dark"><i class="fas fa-pen-to-square fw-light small"></i></button>';
                            echo '</form>';
                            if ($row["status"] == 0) {
                                echo '<form method="POST" onsubmit="return xacnhan()" style="display: inline-block;">';
                                echo '<input type="hidden" value="' . $row["ProductID"] . '" name="remove-product-id">';
                                echo '<input type="submit" name="xoa" class="btn btn-sm btn-outline-dark" value="Xóa">';
                                echo '</form>';
                            } else if ($row["status"] == 1) {
                                echo '<form method="POST" onsubmit="return xacnhan()" style="display: inline-block;">';
                                echo '<input type="hidden" value="' . $row["ProductID"] . '" name="hide-product-id">';
                                echo '<input type="submit" name="an" class="btn btn-sm btn-outline-dark" value="Ẩn">';
                                echo '</form>';
                            } else {
                                echo '<form method="POST" onsubmit="return xacnhan()" style="display: inline-block;">';
                                echo '<input type="hidden" value="' . $row["ProductID"] . '" name="show-product-id">';
                                echo '<input type="submit" name="hien" class="btn btn-sm btn-outline-dark" value="Hiện">';
                                echo '</form>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/admin-product.js"></script>
</body>

</html>