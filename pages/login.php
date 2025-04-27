<?php
session_start();
require '../connection/connect.php';

$error_message = "";

// Nếu đã đăng nhập thì chuyển hướng luôn (optional)
if (isset($_SESSION['email'])) {
    header("Location: ./userInfo.php");
    exit();
}

// Thông báo lỗi từ session (nếu có)
if (isset($_SESSION['error_message'])) {
    echo "<script>alert('{$_SESSION['error_message']}')</script>";
    unset($_SESSION['error_message']);
}

// Xử lý khi nhấn nút đăng nhập
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = md5($password); // Có thể dùng password_hash sau này

    // Sử dụng prepared statement để tránh SQL injection
    $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] == 0) {
            $_SESSION['error_message'] = "Tài khoản đã bị khóa, không thể đăng nhập.";
            header("Location: ./login.php");
            exit();
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['customer_id'] = $row['customer_id'];
            header("Location: ./userInfo.php");
            exit();
        }
    } else {
        $error_message = "Email hoặc mật khẩu sai. Vui lòng nhập lại !";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account-EAVES</title>
    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/auth.css" type="text/css">
    <link rel="stylesheet" href="../css/global.css">
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
                    <div class="dropdown">
                        <a href="#" class="icon"><i class="fas fa-user"></i></a>
                        <div class="dropdown-content"">
                            <a href="login.php">My Account</a>
                            <a href="register.php">Register</a>
                            <a href="#">Sign in</a>
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

    <section class="main">
        <div class="container">
            <div class="login-container">
                <div class="login-left">
                    <div class="login-left-container">
                        <h2>SIGN IN</h2>
                        <p>If you have an account, sign in with your email address.</p>
                        <form method="post" action="login.php">
                            <label for="email">EMAIL ADDRESS*</label>
                            <input type="email" id="email" name="email" placeholder="Enter email address" required>

                            <label for="password">ENTER YOUR PASSWORD*</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>

                            <div class="forgot">
                                <a href="#">Forgot Password?</a>
                            </div>

                            <button type="submit" name="login">SIGN IN</button>
                            <?php if ($error_message): ?>
                            <div style="color: red;">
                                <?php echo $error_message; ?>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div class="login-right">
                    <div class="login-right-container">
                        <h2>NEW CUSTOMERS</h2>
                        <p>
                            By creating an account with our store, you will be able to move through the checkout process
                            faster,
                            store multiple shipping addresses, view and track your orders in your account and more.
                        </p>
                        <button class="btn-register">
                            <a href="register.php">REGISTER</a>
                        </button>
                    </div>
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