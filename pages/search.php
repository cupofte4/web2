<?php
session_start();
require '../connection/connect.php';

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATEGORY-EAVES</title>

    <!-- css -->
    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/category.css" type="text/css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/product-display.css">

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

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
                    <a href="cart.html" class="icon"><i class="fas fa-shopping-cart"></i></a>
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
            <span class="default-breadcrumb">SEARCH RESULTS</span>
        </div>

        <!-- Product Container -->
        <div class="products">
            <?php
                $item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 8;
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($current_page - 1) * $item_per_page;
                $sql_searching = "SELECT * FROM product WHERE NOT status = 2";
                $check_proSearching = true;

                if (isset($_GET['timkiem'])) {
                    // Truy vấn lấy tổng số bản ghi
                    $sql_total_records = "SELECT * FROM `product` WHERE NOT status = 2";
                    $check_proSearching = false;
                    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                        $keyword = $_GET['keyword'];
                        $sql_total_records .= " AND name LIKE '%$keyword%'";
                    }
                    $totalRecords = mysqli_query($conn, $sql_total_records);
                    $totalRecords = $totalRecords->num_rows;

                    // Tính toán số trang
                    $totalPages = ceil($totalRecords / $item_per_page);

                    // Truy vấn lấy kết quả phân trang
                    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                        $keyword = $_GET['keyword'];
                        $sql_searching .= " AND name LIKE '%$keyword%'";
                    }
                    $sql_searching .= " LIMIT $item_per_page OFFSET $offset";
                    $result_searching = mysqli_query($conn, $sql_searching);
                    if (mysqli_num_rows($result_searching) > 0) {
                        while ($row_product = mysqli_fetch_assoc($result_searching)) {
                            ?>
            <div class="product" data-aos="zoom-in" data-aos-duration="1500">
                <a href="product-detail.php?id=<?= $row_product['ProductID'] ?>">
                    <img alt="" src="../images/products/<?php echo $row_product['image']; ?>" />
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
            <?php }
                        if ($totalPages > 1) {
                            echo '<div class="pagination-container">';
                            include 'pagination_search.php';
                            echo '</div>';
                        }
                    } else {
                        echo "Không tìm thấy sản phẩm";
                    }
                } ?>
            <!-- Tìm kiếm nâng cao -->
            <?php
                if (isset($_GET['advancedSearch'])) {
                    $sql_searching = "SELECT * FROM product WHERE 1=1 AND NOT status = 2";
                    $sql_total_records = "SELECT * FROM product WHERE 1=1 AND NOT status = 2";
                    if (!empty($_GET['keyword'])) {
                        $keyword = $_GET['keyword'];
                        $sql_searching .= " AND name LIKE '%$keyword%'";
                        $sql_total_records .= " AND name LIKE '%$keyword%'";
                    }
                    if (!empty($_GET['price_range'])) {
                        if ($_GET['price_range'] === 'below') {
                            $sql_searching .= " AND price < 250";
                            $sql_total_records .= " AND price < 250";
                        } elseif ($_GET['price_range'] === 'middle') {
                            $sql_searching .= " AND price >= 250 AND price <= 450";
                            $sql_total_records .= " AND price >= 250 AND price <= 450";
                        } elseif ($_GET['price_range'] === 'upper') {
                            $sql_searching .= " AND price >= 450";
                            $sql_total_records .= " AND price >= 450";
                        }
                    }
                    if (!empty($_GET['type_range']) && $_GET['type_range'] !== 'all') {
                        $type_id = mysqli_real_escape_string($conn, $_GET['type_range']);
                        $sql_searching .= " AND type_id = '$type_id'";
                        $sql_total_records .= " AND type_id = '$type_id'";
                    }

                    // Truy vấn lấy tổng số bản ghi
                    $totalRecords = mysqli_query($conn, $sql_total_records);
                    $totalRecords = $totalRecords->num_rows;

                    // Tính toán số trang
                    $totalPages = ceil($totalRecords / $item_per_page);

                    $sql_searching .= " LIMIT $item_per_page OFFSET $offset";
                    $result_searching = mysqli_query($conn, $sql_searching);

                    // Hiển thị kết quả tìm kiếm và phân trang
                    if (mysqli_num_rows($result_searching) > 0) {
                        while ($row_product = mysqli_fetch_assoc($result_searching)) {
                            ?>
            <div class="product" data-aos="zoom-in" data-aos-duration="1500">
                <a href="product-detail.php?id=<?= $row_product['ProductID'] ?>">
                    <img alt="" src="../images/products/<?php echo $row_product['image']; ?>" />
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
            <?php }
                        if ($totalPages > 1) {
                            echo '<div class="pagination-container">';
                            include 'pagination_proSearch.php';
                            echo '</div>';
                        }
                    } else {
                        echo "Không tìm thấy sản phẩm";
                    }
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
    <script>
    AOS.init();
    </script>
</body>

</html>