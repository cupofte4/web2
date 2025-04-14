<?php
session_start();
require '../connection/connect.php';
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Truy vấn để lấy category_name từ category_id
    $sql = "SELECT category_name FROM category WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_name = $row['category_name'];
    } else {
        // Xử lý khi không tìm thấy category_name
        $category_name = "Unknown Category";
    }
} else {
    // Xử lý khi không có category_id được truyền qua URL
    $category_name = "Unknown Category";
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
    <link rel="stylesheet" href="../css/category.css" type="text/css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="../css/side.css">
    <link rel="stylesheet" href="../css/user.css">
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
    </div>
    <!-- Begin sections: header-group -->
    <section class="header-group">
        <header class="sticky-header">
            <div class="announcement">
                <h5>FREE SHIPPING ON ORDERS OVER USD 150!</h5>
            </div>
            <div class="section-header">
                <div class="heading-logo">
                    <a href="../index.php">EAVES</a>
                </div>
                <div class="header-icons">
                    <!-- Toggle Button -->
                    <i class="fa-solid fa-bars" id="toggleButtonopen"
                        style="color: white; position: absolute; left: -100px;"></i>
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
                                        <option value="men">Men</option>
                                        <option value="women">Women</option>
                                        <option value="whatsnew">What's New</option>
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
                    <a href="#" class="icon"><i class="fas fa-user"></i></a>
                    <div class="user-menu" id="userMenu">
                        <a href="/log-cre/Login.html">Login</a>
                        <a href="#">Logout</a>
                        <a href="his.html">Purchase History</a>
                    </div>
                </div>
            </div>
            <nav class="header-navbar">
                <a href="category.php?category_id=whatsnew">WHAT'S NEW</a>
                <a href="category.php?category_id=men">MEN</a>
                <a href="category.php?category_id=women">WOMEN</a>
            </nav>
        </header>
    </section>
    <!-- End sections: header-group -->

    <section class="main">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <a href="../index.php" title="EAVES">HOME</a> >
            <span class="default-breadcrumb"><?php echo $category_name; ?></span>
        </div>

        <!-- Product Container -->
        <div class="products">
            <?php
                        $item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 8;
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($current_page - 1) * $item_per_page;
                        // Truy vấn sản phẩm từ cơ sở dữ liệu dựa trên category_id
                        $sql_products = "SELECT * FROM product
                                        JOIN category ON product.category_id = category.category_id
                                        WHERE product.category_id = '$category_id'
                                        AND NOT status = 2
                                        LIMIT $item_per_page OFFSET $offset";
                        $result_products = mysqli_query($conn, $sql_products);
                        $totalRecords = mysqli_query($conn, "SELECT * FROM `product` WHERE product.category_id = '$category_id' AND NOT status = 2");
                        $totalRecords = $totalRecords->num_rows;
                        $totalPages = ceil($totalRecords / $item_per_page);
                        // Kiểm tra xem có sản phẩm nào không
                        if (mysqli_num_rows($result_products) > 0) {
                            // Duyệt qua các sản phẩm và hiển thị
                            while ($row_product = mysqli_fetch_assoc($result_products)) {
                        ?>
            <div class="product" data-aos="zoom-in" data-aos-duration="1500">
                <a href="product-detail.php?id=<?= $row_product['ProductID'] ?>">
                    <img src="../images/products/<?php echo $row_product['image']; ?>" />
                </a>
                <i class="far fa-heart wishlist"></i>
                <?php if ($category_id == "whatsnew") : ?>
                <span class="new">NEW ARRIVAL</span>
                <?php endif; ?>
                <div class="card-info">
                    <h3>
                        <a href="product-detail.php?id=<?= $row_product['ProductID'] ?>">
                            <?= htmlspecialchars($row_product['name']) ?>
                        </a>
                    </h3>
                    <div class="price-cart">
                        <p>$
                            <?= number_format($row_product['price']) ?> USD
                        </p>
                        <a class="add-to-cart" href="#">ADD TO CART</a>
                    </div>
                </div>
            </div>
            <?php
                            }
            ?>
        </div>
     
        <div class="pagination-container">
            <?php
                            if ($totalPages > 1) {
                                include './pagination.php';
                            }
                        } else {
                           
                            echo "<p>Không có sản phẩm trong danh mục này.</p>";
                        }
            ?>
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
    <!-- End sections: footer-group -->
    <script src="/js/addproduct.js"></script>
    <script src="/js/whatsnew.js"></script>
    <script src="/js/User.js"></script>
    <script src="/js/search.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>