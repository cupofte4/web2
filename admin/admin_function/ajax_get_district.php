<?php 
    require '../../connects/connectDGHCVN.php';

    $city_id = $_GET['city_id'];
    
    $sql = "SELECT * FROM `district` WHERE `city_id` = {$city_id}";
    $result = mysqli_query($connDGHCVN, $sql);

    $data[0] = [
        'id' => null,
        'name' => 'Chọn một Quận/huyện'
    ];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['district_id'],
            'name'=> $row['name']
        ];
    }
    echo json_encode($data);
?>