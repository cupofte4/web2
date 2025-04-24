<?php
session_start();
require './connection/connect.php';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$notification = "";

if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']); // Xóa thông báo lỗi sau khi hiển thị
    echo "<script>alert('{$notification}');</script>";
} else {
    $notification = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAVES</title>

    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/index.css" type="text/css">
    <link rel="stylesheet" href="css/product-display.css">
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
    <!-- Begin sections: header-group -->
    <section class="header-group">
        <header class="sticky-header">
            <div class="announcement">
                <h5>FREE SHIPPING ON ORDERS OVER USD 350, 2pcs Extra 10% OFF, 3pcs+ Extra 15% OFF!</h5>
            </div>
            <div class="section-header">
                <div class="heading-logo">
                    <a href="index.php">EAVES</a>
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
                    <a href="cart.html" class="icon"><i class="fas fa-shopping-cart"></i></a>
                    <div class="dropdown">
                        <a href="#" class="icon"><i class="fas fa-user"></i></a>
                        <div class="dropdown-content">
                            <a href="<?php echo isset($_SESSION['email']) ? 'pages/userInfo.php' : 'pages/login.php'; ?>">My Account</a>
                            <?php if (isset($_SESSION['email'])): ?>
                                <a href="pages/logout.php">Sign out</a>
                            <?php else: ?>
                                <a href="pages/register.php">Register</a>
                                <a href="pages/login.php">Sign in</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="header-navbar">
                <a href="./pages/category.php?category_id=whatsnew">WHAT'S NEW</a>
                <a href="./pages/category.php?category_id=men">MEN</a>
                <a href="./pages/category.php?category_id=women">WOMEN</a>
            </nav>
        </header>
        <div class="hero">
            <div class="hero_content">
                <h1>Redefines Streetwear with Wang Yibo</h1>
                <p>Fall Collection 2024</p>
                <a href="#" class="btn-discover">Discover</a>
            </div>
        </div>
    </section>
    <!-- End sections: header-group -->

    <!-- Begin sections: main -->
    <section class="main">
        <div class="main-heading">
            <h1>NEW ARRIVAL - MEN</h1>
            <div class="view-all">
                <a href="./pages/category.php?category_id=men" class="btn-more">MORE</a>
            </div>
        </div>
        <!-- Sản phẩm -->
        <div class="products">
            <?php
            $sql = "SELECT * FROM product WHERE status = 1 AND category_id = 'men' ORDER BY ProductID DESC LIMIT 4"; // Giới hạn 8 sản phẩm mới nhất
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()):
            ?>
                <div class="product" data-aos="zoom-in" data-aos-duration="1500">
                    <a href="pages/product-detail.php?id=<?= $row['ProductID'] ?>">
                        <img src="./images/products/<?php echo $row['image']; ?>" />
                    </a>
                    <i class="far fa-heart wishlist"></i>
                    <div class="card-info">
                        <h3>
                            <a href="product-detail.php?id=<?= $row['ProductID'] ?>">
                                <?= htmlspecialchars($row['name']) ?>
                            </a>
                        </h3>
                        <div class="price-cart">
                            <p>$
                                <?= number_format($row['price']) ?> USD
                            </p>
                            <a class="add-to-cart" href="#">ADD TO CART</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="main-heading">
            <h1>NEW ARRIVAL - WOMEN</h1>
            <div class="view-all">
                <a href="./pages/category.php?category_id=women" class="btn-more">MORE</a>
            </div>
        </div>
        <!-- Sản phẩm -->
        <div class="products">
            <?php
            $sql = "SELECT * FROM product WHERE status = 1 AND category_id = 'women' ORDER BY ProductID DESC LIMIT 4"; // Giới hạn 8 sản phẩm mới nhất
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()):
            ?>
                <div class="product" data-aos="zoom-in" data-aos-duration="1500">
                    <a href="pages/product-detail.php?id=<?= $row['ProductID'] ?>">
                        <img src="./images/products/<?php echo $row['image']; ?>" />
                    </a>
                    <i class="far fa-heart wishlist"></i>
                    <div class="card-info">
                        <h3>
                            <a href="product-detail.php?id=<?= $row['ProductID'] ?>">
                                <?= htmlspecialchars($row['name']) ?>
                            </a>
                        </h3>
                        <div class="price-cart">
                            <p>$
                                <?= number_format($row['price']) ?> USD
                            </p>
                            <a class="add-to-cart" href="#">ADD TO CART</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="container">
            <div class="item" id="item1">
                <img alt="Person wearing Evisukuro collection clothing" src="./images/IMG001.webp" />
                <h1>EAVESKURO</h1>
                <div class="links">
                    <a href="./pages/category.php?category_id=men" class="btn-links">SHOP MEN</a>
                    <a href="./pages/category.php?category_id=women" class="btn-links">SHOP WOMEN</a>
                </div>
            </div>
            <div class="item" id="item2">
                <img alt="Denim bag from Japanese Raw Collection" src="./images/IMG002.jpg" />
                <h1>JAPANESE RAW COLLECTION</h1>
                <div class="links">
                    <a href="#" class="btn-links">SHOP All</a>
                </div>
            </div>
            <div class="item" id="item3">
                <img alt="Clothing items from 2024 Spring Collection" src="./images/IMG003.jpg" />
                <h1>2024 SPRING COLLECTION</h1>
                <div class="links">
                    <a href="#" class="btn-links">SHOP All</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Begin sections: footer-group -->
    <section class="footer-group">
        <div class="top-bar">
            <ul>
                <li>
                    <div class="top-bar-card">
                        <i class="fas fa-shipping-fast"></i>
                        <p>
                            COMPLIMENTARY <br>
                            SHIPPING FOR ANY <br>
                            ORDER OVER USD 350
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
    <!-- End sections: footer-group -->

    <script src="js/index.js"></script>
    <!-- <script src="/js/User.js"></script> -->
    <script>
        AOS.init();
    </script>
</body>

</html>