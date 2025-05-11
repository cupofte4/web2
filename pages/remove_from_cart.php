<?php
session_start();

// Kiểm tra xem key sản phẩm có tồn tại không
if (isset($_GET['key'])) {
    $key = $_GET['key'];

    // Nếu sản phẩm tồn tại trong giỏ hàng thì xóa nó
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }
}

// Sau khi xóa, quay lại trang giỏ hàng
header('Location: cart.php');
exit;

