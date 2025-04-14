<?php
require '../../connects/connect.php';

$productID = $_POST['edit_product_id'];
$sql = "SELECT * FROM `product` WHERE `ProductID` = '{$productID}'";
$result = mysqli_query($conn, $sql);
$edit_row = $result->fetch_assoc();

?>

<?php
if (
    isset($_POST["capnhat"]) && $_POST["capnhat"]
) {
    if (!empty($_FILES["product-image-url"]["tmp_name"])) {
        $tmp_name = $_FILES["product-image-url"]["tmp_name"];
        $fldimageurl = "../images/" . $_FILES["product-image-url"]["name"];
        if (!file_exists($fldimageurl)) {
            move_uploaded_file($tmp_name, $fldimageurl);
        }
        $image = $_FILES["product-image-url"]["name"];
    } else {
        $image = $_POST["image-url"];
    }
    $productID = $_POST["product-id"];
    $title = $_POST["product-title"];
    $category_id = $_POST["product-category"];
    $author = $_POST["product-author"];
    $publisher = $_POST["product-publisher"];
    $cover = $_POST["product-cover"];
    $price = $_POST["product-price"];
    $stock = $_POST["product-stock"];
    $description = $_POST["product-description"];

    $sql = "UPDATE `product` SET `ProductID` = '$productID', `title` = '$title', `image` = '$image', `category_id` = '$category_id', `author` = '$author', `publisher` = '$publisher', `cover` = '$cover', `price` = '$price', `stock` = '$stock', `description` = '$description'
    WHERE `ProductID` = '$productID'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: admin-product.php");
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
    <script src="../js/admin-product.js"></script>
    <title>Thay đổi thông tin</title>
</head>

<body class="d-flex justify-content-center mt-5">
    <form onsubmit="return checkForm()" method="POST" enctype="multipart/form-data">
        <table id="product-input-table">
            <tr>
                <td>
                    <div>
                        <label for="product-id">Mã sách:</label>
                        <?php
                        echo '<input size="34" type="text" name="product-id" id="product-id" value="' . $edit_row['ProductID'] . '" readonly>';
                        ?>
                    </div>
                </td>
                <td>
                    <div>
                        <label for="product-author">Tác giả:</label>
                        <?php
                        echo '<input size="34" type="text" name="product-author" id="product-author" value="' . $edit_row['author'] . '">';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div>
                        <label for="product-title">Tựa sách:</label>
                        <?php
                        echo '<input size="34" type="text" name="product-title" id="product-title" value="' . $edit_row['title'] . '">';
                        ?>
                    </div>
                </td>
                <td>
                    <div>
                        <label for="product-publisher">Nhà xuất bản:</label>
                        <?php
                        echo '<input size="34" type="text" name="product-publisher" id="product-publisher" value="' . $edit_row['publisher'] . '">';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div>
                        <label for="product-category">Thể loại</label>
                        <?php
                        echo '<select name="product-category" id="product-category" style="width: 288px;">';
                        echo '<option value="ton-giao-tam-linh">Tôn giáo - tâm linh</option>';
                        echo '<option value="triet-hoc-khoa-hoc">Triết học - khoa học</option>';
                        echo '<option value="van-hoa-nghe-thuat">Văn hóa - nghệ thuật</option>';
                        echo '<option value="tam-ly-ky-nang">Tâm lý - kỹ năng</option>';
                        echo '<option value="kien-thuc-tong-hop">Kiến thức tổng hợp</option>';
                        echo '<option value="lich-su">Lịch sử</option>';
                        echo '<option value="van-hoc">Văn học</option>';
                        echo '<option value="kinh-te-chinh-tri">Kinh tế - chính trị</option>';
                        echo '<option value="thieu-nhi">Thiếu nhi</option>';
                        echo '</select>';
                        ?>
                    </div>
                </td>
                <td>
                    <div>
                        <label for="product-cover">Loại bìa:</label>
                        <?php
                        echo '<select name="product-cover" id="product-cover" style="width: 288px;">';
                        echo '<option value="mem">Bìa mềm</option>';
                        echo '<option value="cung">Bìa cứng</option>';
                        echo '</select>';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div>
                        <label for="product-image">Hình ảnh:</label>
                        <?php
                        echo '<input type="file" name="product-image-url" id="product-image-url" onchange="loadFile(event)">';
                        ?>
                    </div>
                </td>
                <td>
                    <div>
                        <label for="product-price">Giá:</label>

                        <?php
                        echo '<input size="34" type="text" name="product-price" id="product-price" value="' . $edit_row['price'] . '">';
                        ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td rowspan="2">
                    <div>
                        <label for="product-image">Xem trước ảnh:</label>
                        <?php
                        echo '<div class="img-display-container" style="display: flex;">';
                        echo '<input type="hidden" name="image-url" id="image-url" value="' . $edit_row['image'] . '">';
                        echo '<img id="selected-img" height="80px" style="margin-right: 45%;" src="../../assets/products/' . $edit_row['image'] . '"></div>';
                        ?>
                    </div>
                </td>
                <td>
                    <div>
                        <label for="product-stock">Số lượng:</label>

                        <?php
                        echo '<input size="34" type="text" name="product-stock" id="product-stock" value="' . $edit_row['stock'] . '">';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div>
                        <label for="product-stock">Trạng thái:</label>
                        
                        <?php
                            if($edit_row["status"] == 1 || $edit_row["status"] == 0) {
                                echo '<input size="34" type="text" name="product-status" id="product-status" value="Đang bán" readonly>';
                            } else {
                                echo '<input size="34" type="text" name="product-status" id="product-status" value="Đã ẩn" readonly>';
                            }
                        ?>
                        
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="product-description">Thông tin sản phẩm:</label><br>
                    <?php
                    echo '<textarea name="product-description" id="product-description" rows="5" cols="125"></textarea>';
                    ?>
                </td>
            </tr>
            <tr style="display: flex; justify-content: end;">
                <td>
                    <a href="admin-product.php"><button type="button" class="btn btn-outline-dark ms-3">Quay
                            lại</button></a>
                    <input type="submit" name="capnhat" class="btn btn-outline-dark ms-3" value="Cập nhật">
                </td>
            </tr>
        </table>
    </form>
    <script>
        var category_select = document.getElementById('product-category');
        var cover_select = document.getElementById('product-cover');
        setTimeout(function () {
            category_select.value = "<?php echo $edit_row['category_id'] ?>";
            cover_select.value = "<?php echo $edit_row['cover'] ?>";
        }, 150);

        var description = document.getElementById('product-description');
        description.value = <?php echo json_encode($edit_row['description']) ?>;
    </script>
</body>

</html>