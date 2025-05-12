<?php
require('../connection/connect.php');
require('../connection/connectDGHCVN.php');
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART-EAVES</title>
    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- jQuery (required for the spinner functionality) -->
    <script src="../vendor/jquery/ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.min.js"></script>
    <!-- font-awesome -->
    <link rel="stylesheet" href="../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../css/cart.css">
    <!-- JS -->
    <script src="../js/trac.js"></script>
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
                    <a href="#" class="icon"><i class="fas fa-shopping-cart"></i></a>
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
            <a href="../index.php" title="EAVES">HOME</a>
            > <span>CART</span>
        </div>

        <div class="container cart-information-container">
            <div class="your-cart rounded">
                <h2 class="fw-bold">Your shopping cart</h2>
                <div class="cart-items" style="min-height: 200px; max-height: 500px; overflow-y: auto;">
                    <?php
                    if (count($_SESSION['cart']) > 0) {
                        foreach ($_SESSION['cart'] as $product_id => $quantity) {
                            $sql = "SELECT * FROM `product` WHERE `ProductID` = '{$product_id}'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $row_product = mysqli_fetch_assoc($result);
                                echo '<div class="item my-1" data-product-id="' . $product_id . '" style="border: 2px solid rgb(235, 235, 235); border-radius: 5px; padding: 10px;">';
                                echo '<div class="item-img">';
                                echo '<img src="../images/products/' . $row_product['image'] . '" width="70px" height="auto">';
                                echo '<div class="item-rm">';
                                echo '<button type="button" name="delete-from-cart" class="delete-from-cart" style="background: none; color: white; border: none;">X</button>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="item-info">';
                                echo '<div style="display: flex; flex-direction: column; justify-content: space-between;">';
                                echo '<div class="item-name">' . $row_product["name"] . '</div>';
                                echo '<div class="item-price">' . number_format($row_product["price"], 0, ".", ",") . '$</div>';
                                echo '</div>';
                                echo '<div class="pt-5">';
                                echo '<div class="input-group spinner">';
                                echo '<button class="spinner-prev" type="button"><i class="fas fa-minus"></i></button>';
                                echo '<input type="number" class="form-control text-center spinner-number" data-product-id="' . $product_id . '" value="' . $quantity . '" min="1" max="99" style="padding: 0; font-size: 14px;" readonly>';
                                echo '<button class="spinner-next" type="button"><i class="fas fa-plus"></i></button>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div></div>';
                            }
                        }
                    } else {
                        echo '<div class="empty-cart">Your cart is empty... Continue shopping <a href="../index.php"> right here!</a></div>';
                    }

                    ?>
                </div>
                <div style="display: flex; justify-content: end; align-items: flex-end; margin-top: 55px;">
                    <?php 
                        if(count($_SESSION['cart']) > 0) {
                            echo '<a href="payment.php"><button type="button" name="payment" class="btn btn-primary btn-danger text-white fw-bold" >CONTINUE TO PAY</button></a>';
                        } else {
                            echo '<button type="button" name="payment" class="btn btn-primary btn-danger text-white fw-bold" disabled>CONTINUE TO PAY</button>';
                        }
                    ?>
                </div>
            </div>
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
    <script src="../js/index.js"></script>
</body>

</html>