<?php
session_start();
require '../connects/connect.php';
require '../connects/connectDGHCVN.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    // Nếu chưa, chuyển hướng người dùng đến trang đăng nhập
    header("Location: ./login.php");
    exit();
}

// Lấy username của người dùng từ session
$username = $_SESSION['username'];

// Truy vấn thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM customer WHERE username = '$username'";
$result = $conn->query($sql);

// Kiểm tra xem có kết quả từ truy vấn hay không
if ($result->num_rows > 0) {
    // Lấy thông tin người dùng từ kết quả truy vấn
    $row = $result->fetch_assoc();
    $fullname = $row['fullname'];
    $email = $row['email'];
    $phone = $row['phone'];
    $street = $row['street'];
    $city = $row['city'];
    $district = $row['district'];
    $ward = $row['ward'];
    // Các thông tin khác của người dùng (nếu có)

} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}

$empty_message = "";

// Đổi mật khẩu
if (isset($_POST['nhap'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $hashed_currentPassword = md5($currentPassword);

    $password_pattern = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';
    if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
        if (!preg_match($password_pattern, $newPassword)) {
            $empty_message = "Mật khẩu phải có ít nhất 8 ký tự, một chữ viết hoa và một chữ số";
        } else {
            // Truy vấn SQL để kiểm tra mật khẩu hiện tại
            $sql_check_currentPassword = "SELECT * FROM customer WHERE username = '$username' AND `password` = '$hashed_currentPassword'";
            $result_check_currentPassword = $conn->query($sql_check_currentPassword);

            // Kiểm tra xem mật khẩu hiện tại có đúng không
            if ($result_check_currentPassword->num_rows > 0 && $newPassword === $confirmPassword) {
                $hashed_newPassword = md5($newPassword);

                // Truy vấn SQL để cập nhật mật khẩu mới
                $sql_update_password = "UPDATE customer SET `password` = '$hashed_newPassword' WHERE username = '$username'";
                if ($conn->query($sql_update_password) === TRUE) {
                    $empty_message = "Đổi mật khẩu thành công";
                } else {
                    $empty_message = "Lỗi khi cập nhật mật khẩu: " . $conn->error;
                }
            } else {
                if ($result_check_currentPassword->num_rows <= 0) {
                    $empty_message = "Mật khẩu hiện tại không đúng.";
                } else {
                    $empty_message = "Mật khẩu mới không trùng khớp.";
                }
            }
        }
    } else {
        $empty_message = "Vui lòng điền đầy đủ thông tin.";
    }
}

// Đổi email
if (isset($_POST['changeEmail'])) {
    $newEmail = $_POST['newEmail'];
    $confirmEmail = $_POST['confirmEmail'];

    if (empty($newEmail) || empty($confirmEmail)) {
        $email_message = "Vui lòng điền đầy đủ email.";
    } elseif ($newEmail !== $confirmEmail) {
        $email_message = "Email xác nhận không khớp.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM user WHERE email = '$newEmail' AND id != $customer_id");
        if (mysqli_num_rows($check) > 0) {
            $email_message = "Email này đã được sử dụng.";
        } else {
            mysqli_query($conn, "UPDATE user SET email='$newEmail' WHERE id=$customer_id");
            $email_message = "Cập nhật email thành công!";
            $row['email'] = $newEmail;
        }
    }
}

// Cập nhật thông tin người dùng
if (
    isset($_POST["capnhat"]) && $_POST["capnhat"]
) {
    $username = $_SESSION["username"];
    $fullname = $_POST["customer-fullname"];
    $email = $_POST["customer-email"];
    $phone = $_POST["customer-phone"];
    $street = $_POST["customer-street"];
    $ward = $_POST["customer-ward"];
    $district = $_POST["customer-district"];
    $city = $_POST["customer-city"];

    $sql = "UPDATE `customer` SET `fullname` = '$fullname', `email` = '$email', `phone` = '$phone', `street` = '$street', `city` = '$city', `district` = '$district', `ward` = '$ward'
    WHERE `username` = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: myInfo.php");
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information-EAVES</title>
    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/userInfo.css">
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
                            <a href=" #">My Account</a>
                            <a href="/pages/logout.php">Sign out</a>
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
        <h1>Customer's Account</h1>
        <main class="container-fluid d-flex gap-4" style="background-color:#EBF3E8">
            <div class="d-flex flex-column align-items-center bg-white side-bar-container">
                <div class="d-flex align-items-center side-bar-title menu">
                    <span class="fw-bold fs-4">
                        <i class="fas fa-bars"></i>
                    </span>
                    <span class="fw-bold ms-2">Thông tin tài khoản</span>
                </div>
        
                <div class="side-bar-items">
                    <ul class="fw-bold list-inline mt-2">
                        <li onclick="tabs(0)"><h3>Tài khoản của tôi</h3></li>
                        <li onclick="tabs(1)"><h3>Lịch sử mua hàng</h3></li>
                        <li onclick="tabs(2)"><h3>Đổi mật khẩu</h3></li>
                        <li onclick="tabs(3)"><h3>Đổi email</h3></li>
                    </ul>
                </div>
            </div>
        
            <div class="infor-container">
                <!-- Tab 0: Thông tin tài khoản -->
                <div class="fs-2 fw-normal bg-green2 p-3 tabShow">Tài khoản của bạn</div>
                <form method="POST" class="profile tabShow" action="updateUser.php">
                    <div class="infor-boxes"><label>Họ:</label>
                        <input type="text" name="first-name" value="<?= $row['first_name'] ?>" disabled>
                    </div>
                    <div class="infor-boxes"><label>Tên:</label>
                        <input type="text" name="last-name" value="<?= $row['last_name'] ?>" disabled>
                    </div>
                    <div class="infor-boxes"><label>Email:</label>
                        <input type="email" name="email" value="<?= $row['email'] ?>" disabled>
                    </div>
                    <div class="infor-boxes"><label>Số điện thoại:</label>
                        <input type="text" name="phone" value="<?= $row['phone'] ?>">
                    </div>
                    <div class="infor-boxes"><label>Đường:</label>
                        <input type="text" name="street" value="<?= $row['street'] ?>">
                    </div>
                    <div class="infor-boxes">
                        <div style="display: flex; height: 40px; align-items: center;">
                            <label for="city">Thành phố:</label>
                            <select name="city" id="customer-city" class="form-control mx-2" style="width:15%">
                                <option value="">Chọn thành phố</option>
                                <?php
                                $cities = mysqli_query($connDGHCVN, "SELECT * FROM city");
                                while ($city = mysqli_fetch_assoc($cities)) {
                                    $selected = $city['city_id'] == $row['city'] ? 'selected' : '';
                                    echo "<option value='{$city['city_id']}' $selected>{$city['name']}</option>";
                                }
                                ?>
                            </select>
        
                            <label for="district">Quận/Huyện:</label>
                            <select name="district" id="customer-district" class="form-control mx-2" style="width:15%"></select>
        
                            <label for="ward">Phường/Xã:</label>
                            <select name="ward" id="customer-ward" class="form-control mx-2" style="width:15%"></select>
                        </div>
                    </div>
        
                    <div class="d-flex justify-content-end">
                        <input class="btn btn-primary" type="submit" value="Lưu thay đổi" name="capnhat">
                    </div>
                </form>
                <!-- Tab 1: Lịch sử mua hàng -->
                <div class="history tabShow">
                    <?php include './orders.php'; ?>
                </div>
        
                <!-- Tab 2: Đổi mật khẩu -->
                <form method="POST" action="changePassword.php" class="changePassword tabShow">
                    <div class="infor-boxes">Mật khẩu hiện tại:
                        <input type="password" name="currentPassword">
                    </div>
                    <div class="infor-boxes">Mật khẩu mới:
                        <input type="password" name="newPassword">
                    </div>
                    <div class="infor-boxes">Nhập lại mật khẩu:
                        <input type="password" name="confirmPassword">
                    </div>
                    <?php if (!empty($message)) echo "<div style='color:red;'>$message</div>"; ?>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit" name="changePassword">Lưu</button>
                    </div>
                </form>
        
                <!-- Tab 3: Đổi email -->
                <form method="POST" action="changeEmail.php" class="tabShow">
                    <div class="infor-boxes">Email mới:
                        <input type="email" name="newEmail">
                    </div>
                    <div class="infor-boxes">Xác nhận email mới:
                        <input type="email" name="confirmEmail">
                    </div>
                    <?php if (!empty($email_message)) echo "<div style='color:red;'>$email_message</div>"; ?>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit" name="changeEmail">Lưu</button>
                    </div>
                </form>
            </div>
        </main>
        
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
    <script src="/js/index.js"></script>
    <script src="/js/User.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>