<?php
session_start();
require '../connection/connect.php';

// Nhận các tham số tìm kiếm
$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : PHP_FLOAT_MAX;

// Xây dựng câu truy vấn SQL cơ bản
$sql = "SELECT p.*, c.category_name 
        FROM product p 
        LEFT JOIN category c ON p.category_id = c.category_id 
        WHERE p.status != 2";

// Thêm điều kiện tìm kiếm
if (!empty($search_query)) {
    $search_query = mysqli_real_escape_string($conn, $search_query);
    $sql .= " AND (p.name LIKE '%$search_query%' OR p.description LIKE '%$search_query%')";
}

if (!empty($category)) {
    $category = mysqli_real_escape_string($conn, $category);
    $sql .= " AND p.category_id = '$category'";
}

if ($min_price > 0) {
    $sql .= " AND p.price >= $min_price";
}

if ($max_price < PHP_FLOAT_MAX) {
    $sql .= " AND p.price <= $max_price";
}

// Thực hiện truy vấn
$result = mysqli_query($conn, $sql);

if (!$result) {
    // Xử lý lỗi truy vấn
    $response = array(
        'error' => true,
        'message' => 'Database query error: ' . mysqli_error($conn)
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Chuẩn bị kết quả trả về
$products = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = array(
            'id' => $row['ProductID'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image'],
            'category_id' => $row['category_id'],
            'category_name' => $row['category_name'],
            'description' => $row['description']
        );
    }
    $response = array(
        'error' => false,
        'products' => $products,
        'total' => count($products)
    );
} else {
    $response = array(
        'error' => false,
        'products' => array(),
        'total' => 0,
        'message' => 'Không tìm thấy sản phẩm nào.'
    );
}

// Trả về kết quả
header('Content-Type: application/json');
echo json_encode($response);
?> 