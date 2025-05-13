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
    <title>CATEGORY-EAVES</title>

    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <!-- Bootstrap -->
      <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- jQuery (required for the spinner functionality) -->
    <script src="../vendor/jquery/ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.min.js"></script>
    <!-- css -->
    <link rel="stylesheet" href="../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/category.css" type="text/css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/product-display.css">

    <!-- js -->
    <script scr ="../js/pages.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
                    <a href="../index.php">EAVES</a>
                </div>
                <div class="header-icons">
                    <!-- Tìm kiếm sản phẩm -->
                    <form action="search.php" method="GET">
                        <div class="search-box">
                            <input type="text" name="keyword" placeholder="Search" id="searchInput">
                            <button class="basicSearch" name="timkiem" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="advanced-search-toggle" id="advancedSearchToggle" type="button">
                                <i class="fas fa-sliders-h"></i>
                            </button>
                            <a href="#" class="close-btn" id="closeSearch">&times;</a>

                            <!-- Advanced Search Panel -->
                            <div class="advanced-search" id="advancedSearch">
                                <div class="search-filters">
                                    <div class="filter-group">
                                        <label>Type:</label>
                                        <select name="type_range">
                                            <!-- Change name attribute to "type_range" -->
                                            <option value="all" selected>All</option>
                                            <?php
                                                // Truy vấn danh sách các danh mục từ cơ sở dữ liệu
                                                $sql_type = "SELECT * FROM type";
                                                $result_type = mysqli_query($conn, $sql_type);

                                                // Lặp qua kết quả và tạo ra các tùy chọn cho dropdown menu
                                                while ($row_type = mysqli_fetch_assoc($result_type)) {
                                                    echo '<option value="' . $row_type['type_id'] . '">' . $row_type['type_name'] . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <label>Price Range:</label>
                                        <select name="price_range">
                                            <!-- Add name attribute to the select element -->
                                            <option value="all">All</option>
                                            <option value="below">Below 250$</option>
                                            <option value="middle">Between 250$ - 450$</option>
                                            <option value="upper">Above 450$</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="search-buttons">
                                    <button class="search-btn" id="applySearch" name="advancedSearch"
                                        type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="#" class="icon search-icon"><i class="fas fa-search"></i></a>
                    <a href="#" class="icon"><i class="fas fa-heart"></i></a>
                    <div class="rounded d-none cart-dropdown js-cart-dropdown">
                        <p class="fs-4">CART</p>
                        <span class="line"></span>
                        <div class="cart-dropdown-items" style="display: flex; flex-direction: column;">
                        <?php
                        if (count($_SESSION['cart']) > 0) {
                            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                $sql = "SELECT * FROM `product` WHERE `ProductID` = '{$product_id}'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                echo '<div class="cart-dropdown-item" data-product-id="' . $product_id . '" style="display: flex; padding: 12px 0 12px 0; width: 100%;">';
                                echo '<img src="../images/products/' . $row['image'] . ' " alt="picture" style="width: 70px; height: auto;">';
                                echo '<form method="POST" style="display: flex; flex-direction: column; width: 100%; justify-content: space-between; margin-left: 10px;">';
                                echo '<div style="display: flex; justify-content: space-between;">';
                                echo '<span style="font-size: 14px; text-align: start;">' . $row['name'] . '</span>';
                                echo '<button type="button" class="delete-from-cart" style="margin-left: 13px; border: none; background: none; display: flex; align-item: start;">X</button>';
                                echo '</div>';
                                echo '<div style="display: flex; justify-content: space-between;">';
                                echo '<div class="input-group spinner" style="width: 80px;">';
                                echo '<button class="spinner-prev" type="button" name="minus-quantity"><i class="fas fa-minus"></i></button>';
                                echo '<input type="number" class="form-control text-center spinner-number" name="product-quantity" value="' . $quantity . '" data-product-id="' . $product_id . '" min="1" max="99" style="padding: 0; font-size: 14px;" readonly>';
                                echo '<button class="spinner-next" type="button" name="plus-quantity"><i class="fas fa-plus"></i></button>';
                                echo '</div>';
                                echo '<span style="font-size: 14px;">' . number_format($row["price"], 0, ".", ",") . '$</span>';
                                echo '</div>';
                                echo '</form>';
                                echo '</div>';
                            }
                                }else {
                                    echo '<div class="my-4" style="display: flex; flex-direction: column;">';
                                    echo '<i class="fas fa-cart-shopping text-warning fs-1 mb-3" style="text-align: center"></i>';
                                    echo '<span style="text-align: center;">Hiện chưa có sản phẩm</span>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                        <span class="line"></span>
                        <a href="cart.php" class="w-100">
                            <button type="submit" class="btn btn-danger text-white w-100">CHECK YOUR CART</button>
                        </a>
                    </div>
                    <a href="javascript:void(0);" class="icon js-toggle-cart"><i class="fas fa-shopping-cart"></i></a>
                    <div class="dropdown">
                        <a href="#" class="icon"><i class="fas fa-user"></i></a>
                        <div class="dropdown-content">
                            <a href="<?php echo isset($_SESSION['email']) ? 'userInfo.php' : 'login.php'; ?>">My
                                Account</a>
                            <?php if (isset($_SESSION['email'])): ?>
                            <a href="logout.php">Sign out</a>
                            <?php else: ?>
                            <a href="register.php">Register</a>
                            <a href="login.php">Sign in</a>
                            <?php endif; ?>
                        </div>
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

    <!-- Begin sections: main -->
    <section class="main">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <a href="../index.php" title="EAVES">HOME</a> >
            <span><?php echo $category_name; ?></span>
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
                        <?php if (isset($_SESSION['customer_id'])): ?>
                        <button class="add-to-cart" type="button"
                            data-product-id="<?php echo $row_product['ProductID']; ?>"> ADD TO CART
                        </button>
                        <?php else: ?>
                        <a class="add-to-cart" href="login.php">
                            ADD TO CART
                        </a>
                        <?php endif; ?>
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
    <!-- End sections: main -->

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
                            ORDER OVER 350
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
                    <a href="../index.php">EAVES</a>
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
    <script src="../js/index.js"></script>
    <script src="../js/pages.js"></script>
    <script>
    AOS.init();
    </script>
</body>

</html>