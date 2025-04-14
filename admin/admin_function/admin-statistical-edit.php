<?php
  require '../../connects/connect.php';

  $username = $_GET['username']; 

// Kiểm tra xem id_khachhang đã được gửi từ URL hay không
if(isset($_GET['username'])){
    $username = $_GET['username']; 
    
    // Truy vấn SQL để lấy tất cả các hóa đơn của người dùng cụ thể
    $query = "SELECT * FROM orders WHERE username = '$username'";
    $result = mysqli_query($conn, $query); 

    // Kiểm tra xem truy vấn có thành công không
    if($result) {
        // Kiểm tra xem có dữ liệu trong kết quả truy vấn không
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
            }
        } else {
            // Không có dữ liệu trong kết quả truy vấn
            $orders = null;
        }
    } else {
        // Truy vấn thất bại
        echo "Lỗi truy vấn: " . mysqli_error($conn);
    }
} else {
    // Không có id_khachhang được gửi từ URL
    echo "Không có id khách hàng được cung cấp.";
}
?>

<!DOCTYPE html>   
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css.map">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/statistical.css">
    <title>Thống kê hóa đơn</title>
    <title>Yêu cầu</title>
  </head>
  <body>
    <style>
      .detail-container {
        display: flex;
        justify-content: space-between;
        width: 800px; /* Điều chỉnh theo nhu cầu */
        margin-left: 50px; /* Điều chỉnh theo nhu cầu */
      }

      .user-info {
        flex: 0 0 60%; /* Điều chỉnh theo nhu cầu */
        padding: 20px;
        border: 1px solid black;
      }

      .product-info {
        flex: 0 0 35%; /* Điều chỉnh theo nhu cầu */
        padding: 20px;
        border: 1px solid black;
      }

      /* Thêm kiểu CSS cho ảnh sản phẩm, chỉ là ví dụ */
      .product-image {
        max-width: 50%;
        height: auto;
      }
    </style>
    <script type="text/javascript" src="./bootstrap/js/bootstrap.js"></script>
    <script src="./assets/js/order.js"></script>
    <script src="./main.js"></script>
    <script src="./assets/js/fix_delete.js"></script>
    <div class="sidebar">
        <div class="sidebar-menu bg-dark">
            <ul>
                <li>
                    <a href="./admin-istrator.php">
                        <i class="fas fa-id-card fs-3"></i><br>
                        Quản Trị Viên
                    </a>
                </li>
                <li>
                    <a href="./admin-user.php">
                        <i class="fas fa-user fs-3"></i><br>
                        Khách Hàng
                    </a>
                </li>
                <li>
                    <a href="./admin-product.php">
                        <i class="fas fa-clipboard-list fs-3"></i><br>
                        Sản Phẩm
                    </a>
                </li>
                <li>
                    <a href="./admin-order.php">
                        <i class="fas fa-cart-shopping fs-3"></i><br>
                        Đơn Hàng
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-chart-line fs-3"></i><br>
                        Thống Kê
                    </a>
                </li>
                <li>
                    <a href="../index.php" class="text-decoration-none text-white">
                        <i class="fas fa-right-from-bracket fs-3 mb-1"></i><br>
                        Thoát
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-section">

      

        <div class="container">
          <!-- Title -->
          <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="h5 mb-0" style="font-size: 36px;"><a href="#" class="text-muted"></a>Chi Tiết Đơn Hàng</h2>

          </div>
       
          <!-- Main content -->
          <div class="row">
            <div class="col-lg-8">
              <!-- Details -->
              <div class="card mb-4">
                
                <div class="card-body">
                <table class="table table-hover">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt hàng</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($orders)): ?>
            <?php foreach($orders as $key => $donhang): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $donhang['OrderID']; ?></td>
                    <td><?php echo $donhang['order_date']; ?></td>
                    <td>
                        <!-- Tạo liên kết để xem chi tiết từng hóa đơn -->
                        <a href="admin-statistical-orderdetails.php?OrderID=<?php echo $donhang['OrderID']; ?>&username=<?php echo $username; ?>">Xem chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Không có thông tin đơn hàng.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>





                 
                </div>
                
              </div>
              <div class="clearfix"></div>
      <a href="./admin-statistical.php" class="btn btn-success thong-ke">Quay về
      </a>
      <br />
      <br />
      <div class="container-fluid"></div>
              <!-- Payment -->
             
            </div>
            <div class="col-lg-4">
              <!-- Customer Notes -->
            
              <div class="card mb-4">
              <!-- Shipping information -->
              <div class="card-body" style="height: 491px;">
              <?php

        // Kiểm tra xem id_khachhang đã được gửi từ URL hay không
        if(isset($_GET['username'])){
          $username = $_GET['username']; 
          
          // Truy vấn SQL để lấy tất cả các hóa đơn của người dùng cụ thể
          $query = "SELECT * FROM orders WHERE username = '$username'";
          $result = mysqli_query($conn, $query); 

          // Kiểm tra xem truy vấn có thành công không
          if($result) {
              // Kiểm tra xem có dữ liệu trong kết quả truy vấn không
              if(mysqli_num_rows($result) > 0) {
                  // Lặp qua từng hóa đơn để lấy thông tin khách hàng
                  while($order = mysqli_fetch_assoc($result)) {
                      $OrderID = $order['OrderID'];
                      // Truy vấn SQL để lấy thông tin khách hàng của mỗi hóa đơn
                      $customer_query = "SELECT * FROM customer WHERE username = '$username' ";
                      $customer_result = mysqli_query($conn, $customer_query);
                      if($customer_result && mysqli_num_rows($customer_result) > 0) {
                          $customer = mysqli_fetch_assoc($customer_result);
                          
                          // Hiển thị thông tin của mỗi hóa đơn
                          echo '<div class="card-body" style="height: 491px;">';
                          echo '<h3 class="h6 mb-4" style="font-size: 20px;">Thông tin tài khoản</h3>';
                          echo '<hr>';
                          echo '<p>Tên khách hàng: ' . $customer['fullname'] . '</p>';
                          echo '<p>Địa chỉ: ' . $order['street'] . '</p>';
                          echo '<p>Số điện thoại: ' . $customer['phone'] . '</p>';
                          // Thêm thông tin khác của người dùng nếu cần
                          echo '</div>'; 
                          ?> <?php exit; 
                      } else {
                          // Không tìm thấy thông tin khách hàng
                          echo "Không tìm thấy thông tin khách hàng cho đơn hàng có ID: " . $OrderID;
                      }
                  }
              } else {
                  // Không có dữ liệu trong kết quả truy vấn
                  echo "Không có đơn hàng nào được tìm thấy.";
              }
          } else {
              // Truy vấn thất bại
              echo "Lỗi truy vấn: " . mysqli_error($conn);
          }
        } else {
          // Không có id_khachhang được gửi từ URL
          echo "Không có id khách hàng được cung cấp.";
        }
?>
  
</div>


</div>

                 
              
                </div>
              </div>
            </div>
          </div>
        </div>
          </div>
      </div>
      <br />
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(".nav").click(function () {
        $("#mySidenav").css("width", "70px");
        $("#main").css("margin-left", "70px");
        $(".logo").css("visibility", "hidden");
        $(".logo span").css("visibility", "visible");
        $(".logo span").css("margin-left", "-10px");
        $(".icon-a").css("visibility", "hidden");
        $(".icons").css("visibility", "visible");
        $(".icons").css("margin-left", "-8px");
        $(".nav").css("display", "none");
        $(".nav2").css("display", "block");
      });

      $(".nav2").click(function () {
        $("#mySidenav").css("width", "300px");
        $("#main").css("margin-left", "300px");
        $(".logo").css("visibility", "visible");
        $(".icon-a").css("visibility", "visible");
        $(".icons").css("visibility", "visible");
        $(".nav").css("display", "block");
        $(".nav2").css("display", "none");
      });
    </script>
  </body>
</html>
