<?php
session_start();
require '../../connects/connect.php';
if (!isset($_SESSION['logined-username'])) {
    $_SESSION['error_message'] = "Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại!";
    header("Location: ../index.php");
}
if (isset($_POST['them']) && $_POST['them']) {
    $tmp_name = $_FILES["product-image-url"]["tmp_name"];
    $fldimageurl = "../../assets/products/" . $_FILES["product-image-url"]["name"];
    move_uploaded_file($tmp_name, $fldimageurl);

    $sql = "INSERT INTO `product`(`ProductID`, `title`, `image`, `category_id`, `author`, `publisher`, `cover`, `price`, `stock`, `description`, `status`) VALUES(
        NULL, 
        '{$_POST["product-title"]}', 
        '{$_FILES["product-image-url"]["name"]}', 
        '{$_POST["product-category"]}', 
        '{$_POST["product-author"]}', 
        '{$_POST["product-publisher"]}', 
        '{$_POST["product-cover"]}',
        '{$_POST["product-price"]}', 
        '{$_POST["product-stock"]}', 
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
                                <label for="product-title">Tựa sách</label>
                                <input size="34" type="text" name="product-title" id="product-title">
                            </div>
                        </td>
                        <td>
                            <div>
                                <label for="product-authour">Tác giả</label>
                                <input size="34" type="text" name="product-author" id="product-author">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <label for="product-category">Thể loại</label>
                                <select name="product-category" id="product-category" style="width: 288px;">
                                    <option value="" disabled selected>Chọn thể loại -</option>
                                    <option value="ton-giao-tam-linh">Tôn giáo - tâm linh</option>
                                    <option value="triet-hoc-khoa-hoc">Triết học - khoa học</option>
                                    <option value="van-hoa-nghe-thuat">Văn hóa - nghệ thuật</option>
                                    <option value="tam-ly-ky-nang">Tâm lý - kỹ năng</option>
                                    <option value="kien-thuc-tong-hop">Kiến thức tổng hợp</option>
                                    <option value="lich-su">Lịch sử</option>
                                    <option value="van-hoc">Văn học</option>
                                    <option value="kinh-te-chinh-tri">Kinh tế - chính trị</option>
                                    <option value="thieu-nhi">Thiếu nhi</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label for="product-publisher">Nhà xuất bản</label>
                                <input size="34" type="text" name="product-publisher" id="product-publisher">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <label for="product-img">Hình ảnh</label>
                                <input type="file" name="product-image-url" id="product-image-url" onchange="loadFile(event)">
                            </div>
                        </td>
                        <td>
                            <div>
                                <label for="product-cover">Loại bìa</label>
                                <select name="product-cover" id="product-cover" style="width: 288px;">
                                    <option value="" disabled selected>Chọn loại bìa -</option>
                                    <option value="mem">Bìa mềm</option>
                                    <option value="cung">Bìa cứng</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            <div class="img-display-container" style="display: flex;">
                                <p>Xem trước ảnh</p>
                                <img id="selected-img" height="80px" style="margin-right: 45%;">
                            </div>
                        </td>
                        <td>
                            <div>
                                <label for="product-price">Giá</label>
                                <input size="34" type="text" name="product-price" id="product-price">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <label for="product-stock">Số lượng</label>
                                <input size="34" type="text" name="product-stock" id="product-stock">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <label for="product-description" class="mb-1">Thông tin sản phẩm</label><br>
                            <textarea name="product-description" id="product-description" rows="5" cols="125"></textarea>
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
            <!-- <div class="record-header">
                <div class="browse">
                    <input type="search" placeholder="Tìm kiếm" class="record-search">
                </div>
            </div> -->
            <div class="table-responsive">
                <table class="table table-bordered" id="product-table" width="100%">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Mã sách</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Thể loại</th>
                            <th scope="col">Tác giả</th>
                            <th scope="col">Nhà xuất bản</th>
                            <th scope="col">Loại bìa</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
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
                            echo '<td style="text-align: center;"><img src="../../assets/products/' . $row["image"] . '"></td>';
                            echo '<td>' . $row["title"] . '</td>';
                            echo '<td>' . $row["category_id"] . '</td>';
                            echo '<td>' . $row["author"] . '</td>';
                            echo '<td>' . $row["publisher"] . '</td>';
                            echo '<td>' . $row["cover"] . '</td>';
                            echo '<td>' . number_format($row["price"], 0, '.', ',') . '</td>';
                            echo '<td style="text-align: center">' . $row["stock"] . '</td>';
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