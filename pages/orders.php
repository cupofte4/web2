<?php


?>
<table class="table"
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Time</th>
            <th>Receiver</th>
            <th>Address</th>
            <th>City</th>
            <th>Submit Order</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql="SELECT * FROM `orders` WHERE `customer_id` ='{$_SESSION['customer_id']}'";
        $result=mysqli_query($conn,$sql);
        if (mysqli_num_rows($result)>0){
            while($row_product=mysqli_fetch_assoc($result)){
                $city=mysqli_query($connDGHCVN,"SELECT * FROM `city` WHERE `city_id`={$row_product['city']}")->fetch_assoc();
                $district=mysqli_query($connDGHCVN,"SELECT * FROM `district` WHERE `city_id`={$row_product['city']} AND `district_id`={$row_product['district']}")->fetch_assoc();
                $ward=mysqli_query($connDGHCVN,"SELECT * FROM `wards` WHERE `district_id` = {$row_product['district']} AND `wards_id` = {$row_product['ward']} ")-> fetch_assoc();
                $_SESSION['OrderID']=$row_product['OrderID'];
        ?>
                <tr>
                    <td><?php echo $row_product['OrderId'];?></td>
                    <td><?php echo $row_product['order_date'];?></td>
                    <td><?php echo $row_product['receiver'];?></td>
                    <td><?php echo $row_product['street']." ". $district['name'] ." ". $ward['name'] ?></td>
                    <td><?php echo $city['name'];?></td>
                </tr>
                <?php
                $message="";
                if($row_product['status']==1){
                    $message="Completed Order";
                }
                elseif($row_product['status']==2){
                    $message="Canceled Order";
                }
                else{
                    $message="Confirmed Order";
                }
                ?>
                <td style="color: red;">
                    <?php
                    echo $message;
                    ?>
                    <P><a style="color: blue;" href="./orderDetails.php?OrderID= <?php echo $row_product['OrderID'];?>">
                        (Click here to see the detail)
                    </a></P>


                </td>


        <?php    }
        }else{
            echo "You dont have bill";
        }
       ?>

    </tbody>