<?php
include '../model/db.php';

$stmt = $conn->prepare("SELECT device_name FROM assets WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$device_name = $product['device_name'];

$stmt = $conn->prepare("DELETE FROM assets WHERE id = :id");

if ($stmt->execute(['id' => $_GET['id']])) {
    $_SESSION['success'] = "Product  $device_name  deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete product.";
}

header("Location: ../view/products.php");
exit;
?>