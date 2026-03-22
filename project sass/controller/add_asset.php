<?php

if (session_status() === PHP_SESSION_NONE) session_start();

include '../model/db.php';

$device_name = $serial_number = $price = $status = "";
$device_nameErr = $serial_numberErr = $priceErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['device_name'])) {
        $device_nameErr = "* Device name is required";
    } else {
        $device_name = htmlspecialchars(stripslashes(trim($_POST['device_name'])));
    }

    if (empty($_POST['serial_number'])) {
        $serial_numberErr = "* Serial number is required";
    } else {
        $serial_number = htmlspecialchars(stripslashes(trim($_POST['serial_number'])));
    }

    if (empty($_POST['price'])) {
        $priceErr = "* Price is required";
    } else {
        $price = htmlspecialchars(stripslashes(trim($_POST['price'])));
    }

    $status = $_POST['status'] ?? 'stock';
    $category_id = $_POST['categories_id'] ?? 1;

    if (!$device_nameErr && !$serial_numberErr && !$priceErr) {

        $check = $conn->prepare("SELECT id FROM assets WHERE serial_number = :serial");
        $check->execute(['serial' => $serial_number]);
        if ($check->rowCount() > 0) {
            $_SESSION['error'] = "Product \"$device_name\" with serial \"$serial_number\" already exists.";
            header("Location: ../view/index.php");
            exit;
        }

        $stmt = $conn->prepare("
            INSERT INTO assets (device_name, serial_number, price, status, category_id)
            VALUES (:device_name, :serial_number, :price, :status, :category_id)
        ");

        if ($stmt->execute([
            'device_name'   => $device_name,
            'serial_number' => $serial_number,
            'price'         => $price,
            'status'        => $status,
            'category_id'   => $category_id
        ])) {
            $_SESSION['success'] = "Product \"$device_name\" added successfully.";
        } else {
            $_SESSION['error'] = "Failed to add product \"$device_name\".";
        }

        header("Location: ../view/products.php");
        exit;
    } else {
        $errorMsg = implode(" | ", array_filter([$device_nameErr, $serial_numberErr, $priceErr]));
        $_SESSION['error'] = $errorMsg;
        header("Location: ../view/index.php");
        exit;
    }
}