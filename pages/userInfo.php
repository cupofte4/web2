<?php
session_start();
require '../connection/connect.php';
require '../connection/connectDGHCVN.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['customer_id'])) {
    header("Location: ./login.php");
    exit();
}

$customer_id = $_SESSION['customer_id']; // Lấy ID từ session

// Lấy thông tin khách hàng từ database
$sql = "SELECT * FROM customer WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $street = $row['street'];
    $city = $row['city'];
    $district = $row['district'];
    $ward = $row['ward'];
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}

$empty_message = "";
$email_message = "";

// $tab_active = 0;

// Đổi mật khẩu
if (isset($_POST['capnhat_password'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $hashed_currentPassword = md5($currentPassword);

    $password_pattern = '/^(?=.*[A-Z])(?=.*\d).{8,}$/';

    if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
        if (!preg_match($password_pattern, $newPassword)) {
            $empty_message = "Mật khẩu phải có ít nhất 8 ký tự, một chữ viết hoa và một chữ số";
            $tab_active = 2;
        } else {
            // Kiểm tra mật khẩu cũ
            $sql_check = "SELECT * FROM customer WHERE customer_id = ? AND password = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("is", $customer_id, $hashed_currentPassword);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0 && $newPassword === $confirmPassword) {
                $hashed_newPassword = md5($newPassword);
                $sql_update = "UPDATE customer SET password = ? WHERE customer_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $hashed_newPassword, $customer_id);
                if ($stmt_update->execute()) {
                    header("Location: userInfo.php?tab=2&password_update=success");
                    exit();
                } else {
                    $empty_message = "Lỗi khi cập nhật mật khẩu: ". $conn->error;
                    $tab_active = 2;
                }
            } else {
                if ($result_check->num_rows <= 0) {
                    $empty_message = "Mật khẩu hiện tại không đúng.";
                } else {
                    $empty_message = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
                }
                $tab_active = 2;
            }
        }
    } else {
        $empty_message = "Vui lòng điền đầy đủ thông tin.";
        $tab_active = 2;
    }
}

// Đổi email
if (isset($_POST['capnhat_email'])) {
    $newEmail = trim($_POST['newEmail']);
    $currentPassword = trim($_POST['currentPasswordEmail']);

    if (empty($newEmail) || empty($currentPassword)) {
        $email_message = "Vui lòng nhập đầy đủ email mới và mật khẩu.";
        $tab_active = 3;
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $email_message = "Định dạng email mới không hợp lệ.";
        $tab_active = 3;
    } elseif ($newEmail == $email) {
        $email_message = "Email mới trùng với email hiện tại.";
        $tab_active = 3;
    } else {
        // Kiểm tra mật khẩu hiện tại
        $check_password = $conn->prepare("SELECT password FROM customer WHERE customer_id = ?");
        $check_password->bind_param("i", $customer_id);
        $check_password->execute();
        $result = $check_password->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            $hashed_password = $row['password'];
            $currentPasswordMd5 = md5($currentPassword);

            if ($currentPasswordMd5 === $hashed_password) {
                // Kiểm tra email mới đã có ai dùng chưa
                $check_email = $conn->prepare("SELECT customer_id FROM customer WHERE email = ? LIMIT 1");
                $check_email->bind_param("s", $newEmail);
                $check_email->execute();
                $email_result = $check_email->get_result();

                if ($email_result->num_rows > 0) {
                    $email_message = "Email này đã được sử dụng bởi người khác.";
                    $tab_active = 3;
                } else {
                    // Update email
                    $update_email = $conn->prepare("UPDATE customer SET email = ? WHERE customer_id = ?");
                    $update_email->bind_param("si", $newEmail, $customer_id);

                    if ($update_email->execute()) {
                        $email = $newEmail;
                        header("Location: userInfo.php?tab=3&email_update=success");
                        exit();
                    } else {
                        $email_message = "Có lỗi xảy ra khi cập nhật email: ". $conn->error;
                        $tab_active = 3;
                    }
                }
            } else {
                $email_message = "Mật khẩu hiện tại không đúng.";
                $tab_active = 3;
            }
        } else {
            $email_message = "Không tìm thấy tài khoản.";
            $tab_active = 3;
        }
    }
}


// Cập nhật thông tin người dùng
if (isset($_POST["capnhat_info"]) && $_POST["capnhat_info"]) {
    $first_name = $_POST["first-name"];
    $last_name = $_POST["last-name"];
    $phone = $_POST["customer-phone"];
    $street = $_POST["customer-street"];
    $ward = $_POST["customer-ward"];
    $district = $_POST["customer-district"];
    $city = $_POST["customer-city"];

    $sql = "UPDATE customer SET first_name = ?, last_name = ?, phone = ?, street = ?, ward = ?, district = ?, city = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $first_name, $last_name, $phone, $street, $ward, $district, $city, $customer_id);
    
    if ($stmt->execute()) {
        header("location: userInfo.php?tab=0&info_update=success");
        exit();
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin: " . $conn->error;
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
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- jQuery (required for the spinner functionality) -->
    <script src="../vendor/jquery/ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.min.js"></script>
    <!-- css -->
    <link rel="stylesheet" href="../vendor/font-awesome/fontawesome-free-6.5.2-web/css/all.min.css">

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/userInfo.css">
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
                            <a href=" #">My Account</a>
                            <a href="logout.php">Sign out</a>
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
        <div class="title">Account Navigation
            <hr>
        </div>

        <div class="container">
            <div class="side-bar-container">
                <ul class="list-inline">
                    <li onclick="tabs(0)">
                        <h3>My Account</h3>
                    </li>

                    <li onclick="tabs(1)">
                        <h3>My orders</h3>
                    </li>

                    <li onclick="tabs(2)">
                        <h3>Change Password</h3>
                    </li>

                    <li onclick="tabs(3)">
                        <h3>Change Email</h3>
                    </li>

                    <li>
                        <a href="logout.php">
                            <h3>Sign out</h3>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="infor-container">
                <!-- Tab 0: Thông tin tài khoản -->
                <div>
                    <div class="sub-title">Account information</div>
                    <form method="POST" class="profile tabShow" action="userInfo.php">
                        <div class="infor-row">
                            <div class="infor-boxes">
                                <label>First Name:</label>
                                <input type="text" name="first-name" value="<?php echo $first_name?>">
                            </div>

                            <div class="infor-boxes">
                                <label>Last Name:</label>
                                <input type="text" name="last-name" value="<?php echo $last_name?>">
                            </div>
                        </div>

                        <div class="infor-boxes">
                            <label>Email:</label>
                            <input type="email" value="<?php echo $email?>" disabled>
                        </div>

                        <div class="infor-boxes">
                            <label>Phone:</label>
                            <input type="text" name="customer-phone" value="<?php echo $phone?>">
                        </div>

                        <div class="infor-boxes">
                            <label>Street:</label>
                            <input type="text" name="customer-street" value="<?php echo $street?>">
                        </div>

                        <div class="infor-boxes">
                            <div class="city-select-container">
                                <label for="customer-city">City:</label>
                                <select name="customer-city" id="customer-city" class="form-control">
                                    <option value="">Select city</option>
                                    <?php
                                        $cities = mysqli_query($connDGHCVN, "SELECT * FROM city");
                                        while ($row_temp = mysqli_fetch_assoc($cities)) {
                                            echo "<option value={$row_temp['city_id']}" . ($city == $row_temp['city_id'] ? " selected" : "") . ">{$row_temp['name']}</option>";
                                        }
                                    ?>
                                </select>

                                <label for="customer-district">District:</label>
                                <select name="customer-district" id="customer-district" class="form-control">
                                    <?php
                                        if (!empty($city)) {
                                            $districts = mysqli_query($connDGHCVN, "SELECT * FROM district WHERE city_id = $city");
                                            while ($row_temp = mysqli_fetch_assoc($districts)) {
                                                echo "<option value={$row_temp['district_id']}" . ($district == $row_temp['district_id'] ? " selected" : "") . ">{$row_temp['name']}</option>";
                                            }
                                        }
                                    ?>
                                </select>

                                <label for="customer-ward">Ward:</label>
                                <select name="customer-ward" id="customer-ward" class="form-control">
                                    <?php
                                        if (!empty($city)) {
                                            $wards = mysqli_query($connDGHCVN, "SELECT * FROM wards WHERE district_id = $district");
                                            while ($row_temp = mysqli_fetch_assoc($wards)) {
                                                echo "<option value={$row_temp['wards_id']}" . ($ward == $row_temp['wards_id'] ? " selected" : "") . ">{$row_temp['name']}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="btn-save">
                            <input class="btn-primary" type="submit" value="Save" name="capnhat_info">
                        </div>
                    </form>
                </div>

                <!-- Tab 1: Lịch sử -->
                <div class="history tabShow">
                    <?php
                        include './orders.php';
                    ?>
                </div>


                <!-- Tab 2: Đổi mật khẩu -->
                <div class="changePassword tabShow">
                    <form method="POST" action="userInfo.php">

                        <div class="infor-boxes">Current Password:
                            <input type="password" name="currentPassword">
                        </div>

                        <div class="infor-boxes">New Password:
                            <input type="password" name="newPassword">
                        </div>

                        <div class="infor-boxes">Confirm New Password:
                            <input type="password" name="confirmPassword">
                        </div>

                        <?php if (!empty($empty_message)) : ?>
                        <div style="color: red;">
                            <?php echo $empty_message; ?>
                        </div>
                        <?php endif; ?>

                        <div class="btn-save">
                            <input class="btn-primary" type="submit" value="Save" name="capnhat_password">
                        </div>

                    </form>
                </div>

                <!-- Tab 3: Đổi email -->
                <div class="changeEmail tabShow">
                    <form method="POST" action="userInfo.php">

                        <div class="infor-boxes">
                            <label>Current Email:</label>
                            <input type="email" value="<?php echo $email?>" disabled>
                        </div>

                        <div class="infor-boxes">
                            <label>New Email:</label>
                            <input type="email" class="form-control" name="newEmail" required>
                        </div>

                        <div class="infor-boxes">
                            <label>Current Password:</label>
                            <input type="password" class="form-control" name="currentPasswordEmail" required>
                        </div>

                        <?php if (!empty($email_message)) : ?>
                        <div style="color: red;"><?php echo $email_message; ?></div>
                        <?php endif; ?>

                        <div class="btn-save">
                            <input class="btn-primary" type="submit" value="Save" name="capnhat_email">
                        </div>
                    </form>
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

    <!-- JS -->
    <script src="../js/index.js"></script>
    <script src="../js/global.js"></script>
    <script src="../js/pages.js"></script>

    <script>
    AOS.init();
    </script>

    <script>
    const tabBtn = document.querySelectorAll(".tab");
    const tab = document.querySelectorAll(".tabShow");

    function tabs(panelIndex) {
        tab.forEach(function(node) {
            node.style.display = "none";
        });
        tab[panelIndex].style.display = "block";
    }
    tabs(0);
    </script>

    <?php
    echo "<script>";
    echo "$(document).ready(function () {";
    echo "$('#city').val('{$row['city']}').trigger('change');";
    echo "setTimeout(function() {";
    echo "    $('#district').val('{$row['district']}').trigger('change');";
    echo "}, 100);";
    echo "setTimeout(function() {";
    echo "    $('#ward').val('{$row['ward']}');";
    echo "}, 200);";
    echo "});";
    echo "</script>";
    ?>

</body>

</html>