<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_SESSION['cart'][$_POST['product_id']])) {
            $_SESSION['cart'][$_POST['product_id']]++;      
        } else {
            $_SESSION['cart'][$_POST['product_id']] = 1;
        }
    }
?>