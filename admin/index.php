<?php
session_start();
require '../connects/connect.php';

$error_message = "";

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Xóa thông báo lỗi sau khi hiển thị
    echo "<script>alert('{$error_message}');</script>";
} else {
    $error_message = "";
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = md5($password);

    $sql = "SELECT * FROM `manager` WHERE `username` = '{$username}' AND password = '{$hashed_password}'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] == 0) {
            $_SESSION['error_message'] = "Tài khoản đã bị khóa, không thể đăng nhập.";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['logined-username'] = $username;
            header("Location: ./admin_function/admin-istrator.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Tên đăng nhập hoặc mật khẩu sai. Vui lòng nhập lại !";
        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap v5.2.3 -->
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css.map">
    <link rel="stylesheet" href="../vendor/bootstrap/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Đăng Nhập</title>
</head>

<body>
    <main>
        <section>
            <div class="container m-auto p-5">
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                                    class="bi bi-person-circle mx-auto d-flex" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                                <br>
                                <h2 style="text-align: center;">Tài Khoản Quản Trị Viên</h2>
                                <form action="#" method="POST">
                                    <input type="text" name="username" id="username" class="form-control my-3 py-2"
                                        placeholder="Tên đăng nhập" required>
                                    <input type="password" name="password" id="password" class="form-control my-3 py-2"
                                        placeholder="Mật Khẩu" required>
                                    <input type="submit" name="login" value="Đăng nhập" style="width: 100%;"
                                        class="btn btn-success d-block mx-auto mt-3">
                                    </input>
                                </form>
                            </div>
                        </div>
                        <div class="text-center mt-1">
                            <a href="../">Trở lại trang đăng nhập dành cho khách hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>