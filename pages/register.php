<?php
require '../connection/connect.php';
session_start();
$empty_message = "";
$error_email = "";

if (isset($_POST['btn-reg'])) { 
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm-password'];

    $password_pattern = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';

    // Regular expression cho email
    $email_pattern = '/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/';

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password) && !empty($confirm)) {

        // Kiểm tra email hợp lệ
        if (!preg_match($email_pattern, $email)) {
            $empty_message = "Email không hợp lệ. Vui lòng nhập lail.";
        }

        // Kiểm tra mật khẩu trùng khớp
        if ($password !== $confirm) {
            $empty_message = "Mật khẩu nhập lại không khớp.";
        }

        if (!preg_match($password_pattern, $password)) {
            $empty_message = "Mật khẩu phải ít nhất 8 ký tự, bao gồm ít nhất một chữ viết hoa và một chữ số.";
        }

        // Kiểm tra email đã tồn tại trong cơ sở dữ liệu hay chưa
        $check_email_sql = "SELECT * FROM customer WHERE email = '$email'";
        $result = $conn->query($check_email_sql);
        if ($result->num_rows > 0) {
            $error_email = "Email này đã tồn tại. Vui lòng nhập email khác.";
        }

        // Nếu không có lỗi, tiếp tục thêm dữ liệu vào cơ sở dữ liệu
        if (empty($empty_message) && empty($error_email)) {
            $hashed_password = md5($password);
            $sql = "INSERT INTO customer(`first_name`, `last_name`, `email`, `password`, `status`) VALUES ('$first_name', '$last_name', '$email', '$hashed_password', 1)";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['error_message'] = "Đăng ký thành công!";
                header("Location: login.php");
            exit();
            } else {
                echo "Error: {$sql}" . $conn->error;
            }
        }
    } else {
        $empty_message = "Vui lòng điền đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account-EAVES</title>
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
                        <div class="dropdown-content">
                            <a href=" login.php">My Account</a>
                            <a href="#">Register</a>
                            <a href="login.php">Sign in</a>
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
        <div class="register-container">
            <h2>CREATE NEW CUSTOMER ACCOUNT</h2>
            <form class="register-form" action="register.php" method="post">
                <h3>Personal Information</h3>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="first-name">FIRST NAME*</label>
                        <input type="text" id="first-name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">LAST NAME*</label>
                        <input type="text" id="last-name" name="last_name" required>
                    </div>
                </div>

                <h3>Sign-In Information</h3>
                <div class="form-group">
                    <label for="email">EMAIL*</label>
                    <input type="email" id="email" name="email" required>
                    <?php if (!empty($error_email)): ?>
                        <div style="color: red;"><?php echo $error_email; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">PASSWORD*</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm-password">CONFIRM PASSWORD*</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                    <?php if (!empty($empty_message)): ?>
                        <div style="color: red;"><?php echo $empty_message; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="agree" required>
                    <label for="agree">
                        I HERE BY AGREE TO THE <a href="#">PRIVACY POLICY</a> AND <a href="#">TERMS AND CONDITIONS</a>
                        OF THE SITE *
                    </label>
                </div>

                <div class="form-action">
                    <button type="submit" class="register" name="btn-reg">REGISTER</button>
                    <a class="action back" href="login.php"><span>BACK</span></a>
                </div>
            </form>
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