<?php 
    require '../connection/connect.php';
    session_start();
    $product_id = $_GET['product_id'];
    $sql = "SELECT * 
    FROM product 
    NATURAL JOIN category 
    WHERE ProductID = $product_id";
    $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $category_id = $row['category_id'];
        $category_name = $row['category_name'];
        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAVES</title>
    <link href='https://fonts.googleapis.com/css?family=Afacad' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="css/product-detail.css" type="text/css">
    <link rel="stylesheet" href="css/side.css">
    <link rel="stylesheet" href="css/user.css">
</head>

<body>
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
                        style="color: white; position: absolute; left: -120px;"></i>
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

    <!-- Begin sections: main -->
    <section class="main">
        <?php 
            $sql_info_products = "SELECT * FROM product
                            JOIN category ON product.category_id = category.category_id
                            WHERE product.ProductID = '$product_id'
                            ";
            $result_infoProduct = mysqli_query($conn,  $sql_info_products);
            while ($row_product = mysqli_fetch_assoc($result_infoProduct)) {
        ?>
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <a href="../index.php" title="EAVES">HOME</a>
            <a href="./category.php?category_id=<?php echo $category_id ?>"><?php echo $category_name ?></a></li>
            <?php 
                // Truy vấn để lấy tiêu đề của sách từ cơ sở dữ liệu
                $sql_title = "SELECT title FROM product WHERE product.ProductID = '$product_id'";
                $result_title = mysqli_query($conn, $sql_title);
                if (mysqli_num_rows($result_title) > 0) {
                    $row_title = mysqli_fetch_assoc($result_title);
                    $book_title = $row_title['title'];
                    echo "<li>$book_title</li>";
                } else {
                    exit;
                }
            ?>
        </div>

        <!-- Product details -->
        <div class="product-detail-container">
            <div class="single-pro-img">
                <img id="product-img" src="../images/products/<?php echo $row_product['image']; ?>alt="" />
            </div>
            <div class=" product-info">
                <h1 id="product-name"><?php echo $row_product['name']; ?></h1>
                <hr>
                <p id="product-price">$<?php echo number_format($row_product['price']); ?></p>
                <div class="size-row">
                    <p class="product-size">SIZE</p>
                    <a href="#" id="size-guide-link" class="size-guide-link">View Size Guide</a>
                </div>
                <select>
                    <option hidden>CHOOSE SIZE</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                </select>

                <div class="buttons">
                    <button class="add-to-cart"><i class="fas fa-shopping-cart"></i>ADD TO CART</button>
                    <button class="add-to-wishlist"><i class="fas fa-heart"></i>ADD TO WISHLIST</button>
                </div>
                <div class="container">
                    <a href="#" class="contact-us"><i class="fas fa-envelope"></i>CONTACT US</a>
                </div>

                <div class="product-introduce">
                    <h3>PRODUCT DETAILS</h3>
                    <hr>
                    <p id="product-description"><?php echo $row_product['description']; ?></p>
                    <h3>CARE</h3>
                    <hr>
                    <ul class="care-list">
                        <li>HAND WASH COLD INSIDE OUT</li>
                        <li>DO NOT BLEACH</li>
                        <li>HANG DRY ONLY</li>
                        <li>COOL IRON ON REVERSE SIDE IF NEEDED</li>
                        <li>STEAM IRONING MAY CAUSE IRREVERSIBLE DAMAGE</li>
                        <li>DO NOT DRY CLEAN</li>
                        <li>DO NOT IRON ON PRINT</li>
                    </ul>

                    <h3>RETURN POLICY</h3>
                    <hr>
                    <ul> of delivery for a
                        refund or exchange.
                        <li>
                            - You can simply return any item within 14 calendar days from the date
                        </li>
                        <li>
                            - Customer needs to bear the return shipping fee and any cost incurred.
                        </li>
                        <li>
                            - Online Orders cannot be returned to any of Eaves' boutiques.
                        </li>
                        <li>
                            - Read here (/pages/delivery-and-returns) for more details.
                        </li>
                    </ul>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
    <!-- End sections: main -->

    <!-- Size Guide Modal -->
    <div id="size-guide-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Size Guide</h2>
            <p>Use the table below to select the correct size:</p>
            <table class="size-guide-table">
                <tr>
                    <th>Size</th>
                    <th>Chest (inches)</th>
                    <th>Waist (inches)</th>
                    <th>Hips (inches)</th>
                </tr>
                <tr>
                    <td>S</td>
                    <td>34-36</td>
                    <td>28-30</td>
                    <td>34-36</td>
                </tr>
                <tr>
                    <td>M</td>
                    <td>38-40</td>
                    <td>32-34</td>
                    <td>38-40</td>
                </tr>
                <tr>
                    <td>L</td>
                    <td>42-44</td>
                    <td>36-38</td>
                    <td>42-44</td>
                </tr>
                <tr>
                    <td>XL</td>
                    <td>46-48</td>
                    <td>40-42</td>
                    <td>46-48</td>
                </tr>
            </table>
        </div>
    </div>

    <script>
    const sizeGuideLink = document.getElementById("size-guide-link");
    const modal = document.getElementById("size-guide-modal");
    const closeModal = document.querySelector(".close");

    sizeGuideLink.onclick = function(event) {
        event.preventDefault();
        modal.style.display = "block";
    }

    closeModal.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

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
    <script src="/js/User.js"></script>
    <script src="/js/side.js"></script>
    <script src="/js/addproduct-v2.js"></script>
</body>

</html>