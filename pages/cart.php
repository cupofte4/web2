<?php
session_start();

// Lấy dữ liệu giỏ hàng từ session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

// Xử lý cập nhật số lượng nếu gửi form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['quantity'] as $key => $quantity) {
        if (isset($cart[$key]) && $quantity > 0) {
            $cart[$key]['quantity'] = (int)$quantity;
        }
    }
    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAVES</title>
    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="/css/global.css" type="text/css">
    <link rel="stylesheet" href="/css/cart.css">
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        .quantity-input { width: 60px; text-align: center; }
        .btn-update, .btn-checkout {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-checkout { background-color: black; text-decoration: none; display: inline-block; }
        .btn-delete { color: black; text-decoration: none; margin-top: 5px; display: inline-block; }
    </style>
</head>

<body>
    <section class="header-group">
        <header class="sticky-header">
            <div class="announcement">
                <h5>FREE SHIPPING ON ORDERS OVER USD 150!</h5>
            </div>
            <div class="section-header">
                <div class="heading-logo">
                    <a href="home.html">EAVES</a>
                </div>
                <div class="header-icons">
                    <!-- Toggle Button -->
                    <div class="search-box">
                        <input type="text" placeholder="Search" id="searchInput">
                        <button class="advanced-search-toggle" id="advancedSearchToggle">
                            <i class="fas fa-sliders-h"></i>
                        </button>
                        <a href="#" class="close-btn" id="closeSearch">&times;</a>

                        <!-- Advanced Search Panel -->
                        <div class="advanced-search" id="advancedSearch">
                            <div class="search-filters">
                                <div class="filter-group">
                                    <label>Category:</label>
                                    <select id="categoryFilter">
                                        <option value="">All Categories</option>
                                        <option value="jacket">Jackets</option>
                                        <option value="jeans">Jeans</option>
                                        <option value="sweatshirt">Sweatshirts</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Price Range:</label>
                                    <div class="price-range">
                                        <input type="number" id="minPrice" placeholder="Min">
                                        <span>-</span>
                                        <input type="number" id="maxPrice" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                            <div class="search-buttons">
                                <button class="search-btn" id="applySearch">Search</button>
                                <button class="reset-btn" id="resetSearch">Reset</button>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="icon search-icon"><i class="fas fa-search"></i></a>
                    <a href="#" class="icon"><i class="fas fa-heart"></i></a>
                    <a href="#" class="icon"><i class="fas fa-shopping-cart"></i></a>
                    <div class="dropdown">
                        <a href="#" class="icon"><i class="fas fa-user"></i></a>
                        <div class="dropdown-content">
                            <a href=" /pages/userInfo.html">My Account</a>
                            <a href="/pages/register.html">Register</a>
                            <a href="/pages/login.html">Sign in</a>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="header-navbar">
                <a href="whatsnew.html">WHAT'S NEW</a>
                <a href="men.html">MEN</a>
                <a href="women.html">WOMEN</a>
                <a href="KID.html">KIZZU</a>
                <a href="SALE.HTML" style="color: red;">SALE</a>
            </nav>
        </header>
    </section>

    <section class="body-group">
        <section class="cart-container container">
            <!-- Bên trái: danh sách sản phẩm -->
            <div class="cart-left">
                <div class="selected-products" id="selectedProductsBox">
                    <h4>Your Items</h4>

                    <?php if (empty($cart)): ?>
                    <p>Giỏ hàng của bạn đang trống. <a href="index.php">Tiếp tục mua sắm</a></p>
                    <?php else: ?>
                    <form method="POST" action="cart.php">
                        <ul id="selectedProductsList">
                        <?php foreach ($cart as $key => $item):
                            $name = htmlspecialchars($item['name']);
                            $price = $item['price'];
                            $quantity = $item['quantity'];
                            $size = $item['size'];
                            $image = htmlspecialchars($item['image']);
                            $subtotal = $price * $quantity;
                            $total += $subtotal;
                        ?>
                            <li class="cart-item">
                                <img src="<?= $image ?>" alt="<?= $name ?>">
                                <div class="cart-details">
                                    <h3><?= $name ?></h3>
                                    <p>Kích cỡ: <?= $size ?></p>
                                    <p>Đơn giá: <?= number_format($price, 0, ',', '.') ?> đ</p>
                                    <p>Số lượng: <input type="number" name="quantity[<?= $key ?>]" value="<?= $quantity ?>" class="quantity-input" min="1"></p>
                                    <p>Thành tiền: <?= number_format($subtotal, 0, ',', '.') ?> đ</p>
                                    <a href="remove_from_cart.php?key=<?= urlencode($key) ?>" class="btn-delete" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>

                        <?php
                            $vat = 0.1 * $total;
                            $grandTotal = $total + $vat;
                        ?>
       
                        <div class="summary">
                            <ul>
                                <li class="subtotal">Tạm tính<span><?= number_format($total, 0, ',', '.') ?> đ</span></li>
                                <li class="vat">VAT (10%)<span><?= number_format($vat, 0, ',', '.') ?> đ</span></li>
                                <li class="total">Tổng cộng<span><?= number_format($grandTotal, 0, ',', '.') ?> đ</span></li>
                            </ul>
                            <button type="submit" name="update" class="btn-update">Cập nhật giỏ hàng</button>
                        </div>
        
                        <div class="checkout-button">
                            <a href="payment.php" class="btn-checkout">CHECK OUT</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </section>

       

    <section class="footer-group">
        <div class="top-bar">
            <ul>
                <li>
                    <div class="top-bar-card">
                        <i class="fas fa-shipping-fast"></i>
                        <p>
                            COMPLIMENTARY <br>
                            SHIPPING FOR ANY <br>
                            ORDER OVER USD 150
                        </p>
                    </div>
                </li>
                <li>
                    <div class="top-bar-card">
                        <i class="fas fa-truck"></i>
                        <p>
                            FREE SHIPPING <br>
                            WITH ALL JEANS
                        </p>
                    </div>
                </li>
                <li>
                    <div class="top-bar-card">
                        <i class="fas fa-box"></i>
                        <p>
                            EAVES SIGNATURE <br>
                            PACKAGING
                        </p>
                    </div>
                </li>
                <li>
                    <div class="top-bar-card">
                        <i class="fas fa-undo"></i>
                        <p>
                            14 DAYS RETURN <br>
                            OR EXCHANGE
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="footer">
        <div class="footer-container">
            <!-- Footer Section (left) -->
            <div class="footer-section">
                <div class="footer-heading">
                    <a href="home.html">EAVES</a>
                </div>
                <div class="footer-news">
                    <div class="sign-up-info">
                        <h2>SIGN UP FOR EAVES UPDATE</h2>
                        <p>Subscribe for special offers and news</p>
                    </div>
                    <div class="sign-up-field">
                        <input type="email" placeholder="Input e-mail address here" class="filed-input">
                    </div>
                    <div class="actions">
                        <button type="submit" title="Subscribe" class="btn-subscribe"> Subscribe</button>
                    </div>
                </div>
                <!-- Social Icons -->
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <!-- Footer Columns (right) -->
            <div class="footer-columns">
                <div class="footer-column">
                    <h3>ABOUT EAVES</h3>
                    <ul>
                        <li><a href="#">History</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Store Locator</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>SHOPPING ONLINE</h3>
                    <ul>
                        <li><a href="#">Delivery & Returns</a></li>
                        <li><a href="#">F.A.Q</a></li>
                        <li><a href="#">Fit Guide</a></li>
                        <li><a href="#">Find Your Order</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>LEGAL</h3>
                    <ul>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Counterfeiting</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Owned by eaves.com</p>
        </div>
    </section>
    <script src="/js/cart.js"></script>
    <script src="/js/side.js"></script>
    <script src="/js/user.js"></script>
</body>
</html>