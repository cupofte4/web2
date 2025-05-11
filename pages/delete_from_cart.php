<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        unset($_SESSION['cart'][$_POST['product_id']]);
    }
?>