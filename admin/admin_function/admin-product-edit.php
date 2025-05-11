<?php
require '../../connection/connect.php';

$productID = $_POST['edit_product_id'];
$sql = "SELECT * FROM `product` WHERE `ProductID` = '{$productID}'";
$result = mysqli_query($conn, $sql);
$edit_row = $result->fetch_assoc();

if (isset($_POST["capnhat"]) && $_POST["capnhat"]) {
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
    $name = $_POST["product-name"];
    $category_id = $_POST["product-category"];
    $type = $_POST["product-type"];
    $price = $_POST["product-price"];
    $description = $_POST["product-description"];

    $sql = "UPDATE `product` 
            SET `name` = '$name', 
                `image` = '$image', 
                `category_id` = '$category_id', 
                `type_id` = '$type', 
                `price` = '$price', 
                `description` = '$description'
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
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thay đổi thông tin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <script src="../../vendor/jquery/jquery-3.6.4.js"></script>
</head>
<body class="d-flex justify-content-center mt-5">
    <form method="POST" enctype="multipart/form-data">
        <table id="product-input-table">
            <tr>
                <td>
                    <label for="product-id">Mã sản phẩm:</label>
                    <input size="34" type="text" name="product-id" id="product-id" value="<?= $edit_row['ProductID'] ?>" readonly>
                </td>
                <td>
                    <label for="product-name">Tên sản phẩm:</label>
                    <input size="34" type="text" name="product-name" id="product-name" value="<?= $edit_row['name'] ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="product-category">Danh mục:</label>
                    <select name="product-category" id="product-category" style="width: 288px;">
                        <option value="1">Đồ nam</option>
                        <option value="2">Đồ nữ</option>
                        <option value="3">Đồ mới</option>
                    </select>
                </td>
                <td>
                    <label for="product-type">Loại:</label>
                    <select name="product-type" id="product-type" style="width: 288px;">
                        <option value="1">Jacket</option>
                        <option value="2">Jean</option>
                        <option value="2">Sweatshirt</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="product-image-url">Hình ảnh:</label>
                    <input type="file" name="product-image-url" id="product-image-url" onchange="loadFile(event)" style="border: none; outline: none;">
                </td>
                <td>
                    <label for="product-price">Giá:</label>
                    <input size="34" type="text" name="product-price" id="product-price" value="<?= $edit_row['price'] ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="product-description">Mô tả:</label><br>
                    <textarea name="product-description" id="product-description" rows="5" cols="125"><?= htmlspecialchars($edit_row['description']) ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="image-url" value="<?= $edit_row['image'] ?>">
                    <label>Xem trước ảnh:</label><br>
                    <img id="selected-img" height="80px" src="../../assets/products/<?= $edit_row['image'] ?>">
                </td>
                <td style="text-align: right;">
                    <a href="admin-product.php" class="btn btn-outline-dark">Quay lại</a>
                    <input type="submit" name="capnhat" class="btn btn-outline-dark" value="Cập nhật">
                </td>
            </tr>
        </table>
    </form>

    <script>
        document.getElementById('product-category').value = "<?= $edit_row['category_id'] ?>";
        document.getElementById('product-type').value = "<?= $edit_row['type_id'] ?>";
        function loadFile(event) {
            const output = document.getElementById('selected-img');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</body>
</html>
