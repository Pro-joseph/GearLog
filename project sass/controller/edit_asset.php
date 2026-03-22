<?php

include '../model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = intval($_POST['id']); 
    $device_name   = htmlspecialchars(trim($_POST['device_name']));
    $serial_number = htmlspecialchars(trim($_POST['serial_number']));
    $price         = floatval($_POST['price']);
    $status        = htmlspecialchars(trim($_POST['status']));
    $category_id   = intval($_POST['category_id']);


    $sql = "UPDATE assets 
            SET device_name = :device_name,
                serial_number = :serial_number,
                price = :price,
                status = :status,
                category_id = :category_id
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        'device_name'   => $device_name,
        'serial_number' => $serial_number,
        'price'         => $price,
        'status'        => $status,
        'category_id'   => $category_id,
        'id'            => $id
    ]);

    header('Location: ../view/products.php');
    exit;
}
?>