<?php
require '../../connection/connect.php';
require '../../connection/connectDGHCVN.php';

$customer_id = $_POST['edit_customer_id'];
$sql = "SELECT * FROM `customer` WHERE `customer_id` = '{$customer_id}'";
$result = mysqli_query($conn, $sql);
$edit_row = $result->fetch_assoc();

if (isset($_POST["update"]) && $_POST["update"]) {
    $customer_id = $_POST["customer-id"];
    $first_name = $_POST["customer-firstname"];
    $last_name = $_POST["customer-lastname"];
    $email = $_POST["customer-email"];
    $phone = $_POST["customer-phone"];
    $street = $_POST["customer-street"];
    $ward = $_POST["customer-ward"];
    $district = $_POST["customer-district"];
    $city = $_POST["customer-city"];    

    $sql = "UPDATE `customer` 
            SET `first_name` = '$first_name', `last_name` = '$last_name', `email` = '$email', 
                `phone` = '$phone', `street` = '$street', `city` = '$city', 
                `district` = '$district', `ward` = '$ward'
            WHERE `customer_id` = '$customer_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: admin-customer.php");
    } else {
        echo "Error updating customer: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/admin-customer.js"></script>
</head>

<body class="d-flex justify-content-center mt-5">
    <form onsubmit="return checkForm()" method="POST" action="admin-customer-edit.php">
        <table id="input-table">
            <tr>
                <td><label for="customer-id">Customer ID:</label></td>
                <td>
                    <input size="45" type="text" name="customer-id" id="customer-id"
                        value="<?php echo $edit_row['customer_id']; ?>" readonly>
                </td>
            </tr>
            <tr>
                <td><label for="customer-firstname">First Name:</label></td>
                <td>
                    <input size="45" type="text" name="customer-firstname" id="customer-firstname"
                        value="<?php echo $edit_row['first_name']; ?>">
                </td>
            </tr>
            <tr>
                <td><label for="customer-lastname">Last Name:</label></td>
                <td>
                    <input size="45" type="text" name="customer-lastname" id="customer-lastname"
                        value="<?php echo $edit_row['last_name']; ?>">
                </td>
            </tr>
            <tr>
                <td><label for="customer-email">Email:</label></td>
                <td>
                    <input size="45" type="email" name="customer-email" id="customer-email"
                        value="<?php echo $edit_row['email']; ?>">
                </td>
            </tr>
            <tr>
                <td><label for="customer-phone">Phone:</label></td>
                <td>
                    <input size="45" type="text" name="customer-phone" id="customer-phone"
                        value="<?php echo $edit_row['phone']; ?>">
                </td>
            </tr>
            <tr>
                <td><label for="customer-street">Street:</label></td>
                <td>
                    <input size="45" type="text" name="customer-street" id="customer-street"
                        value="<?php echo $edit_row['street']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="customer-city">City:</label><br>
                        <select name="customer-city" id="customer-city">
                            <option value="">Select city</option>
                            <?php
                            $cities = mysqli_query($connDGHCVN, "SELECT * FROM city");
                            while ($row = mysqli_fetch_assoc($cities)) {
                                echo "<option value='{$row['city_id']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="customer-district">District:</label><br>
                        <select name="customer-district" id="customer-district">
                            <option value="">Select district</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="customer-ward">Ward:</label><br>
                        <select name="customer-ward" id="customer-ward">
                            <option value="">Select ward</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr style="display: flex; justify-content: end;">
                <td>
                    <a href="admin-customer.php">
                        <button type="button" class="btn btn-outline-dark ms-3">Back</button>
                    </a>
                    <input type="submit" name="update" class="btn btn-outline-dark ms-3" value="Update">
                </td>
            </tr>
        </table>
    </form>

    <script>
    $(document).ready(function() {
        $('#customer-city').val('<?php echo $edit_row['city']; ?>').trigger('change');
        setTimeout(function() {
            $('#customer-district').val('<?php echo $edit_row['district']; ?>').trigger('change');
        }, 100);
        setTimeout(function() {
            $('#customer-ward').val('<?php echo $edit_row['ward']; ?>');
        }, 200);
    });
    </script>
</body>

</html>