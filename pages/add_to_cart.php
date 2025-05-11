<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $size = $_POST['size'];

    // Giỏ hàng là mảng lưu trong session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra nếu sản phẩm đã có trong giỏ (cùng ID và size)
    $key = $product_id . '_' . $size;
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$key] = [
            'product_id' => $product_id,
            'size' => $size,
            'quantity' => 1
        ];
    }

    // Quay lại trang trước hoặc giỏ hàng
    header('Location: cart.php');
    exit;
}
?>
