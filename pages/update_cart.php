<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $_SESSION['cart'][$_POST['product_id']] = $_POST['quantity'];
    }
?>