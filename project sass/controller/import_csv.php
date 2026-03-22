<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'auth.php';
include '../model/db.php';

if (isset($_POST['import_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['csv_file']['tmp_name'];
        $fileName = $_FILES['csv_file']['name'];

        $handle = fopen($fileTmp, "r");
        if ($handle !== FALSE) {
            $rowCount = 0;
            $successCount = 0;
            $skippedCount = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rowCount++;
                if ($rowCount == 1) continue; // skip header

                $device_name   = htmlspecialchars(trim($data[0]));
                $serial_number = htmlspecialchars(trim($data[1]));
                $price         = floatval(trim($data[2]));
                $status        = trim($data[3]);
                $category_id   = intval(trim($data[4]));

                if ($device_name && $serial_number && $price && $category_id) {
                    // Check if serial_number exists
                    $check = $conn->prepare("SELECT id FROM assets WHERE serial_number = :sn");
                    $check->execute(['sn' => $serial_number]);

                    if ($check->rowCount() == 0) {
                        $sql = "INSERT INTO assets (device_name, serial_number, price, status, category_id)
                                VALUES (:device_name, :serial_number, :price, :status, :category_id)";
                        $stmt = $conn->prepare($sql);
                        if ($stmt->execute([
                            'device_name' => $device_name,
                            'serial_number' => $serial_number,
                            'price' => $price,
                            'status' => $status,
                            'category_id' => $category_id
                        ])) {
                            $successCount++;
                        }
                    } else {
                        $skippedCount++;
                    }
                }
            }
            fclose($handle);

            $_SESSION['success'] = "$successCount products imported successfully.";
            if ($skippedCount > 0) {
                $_SESSION['error'] = "$skippedCount products skipped because serial number already exists.";
            }
        } else {
            $_SESSION['error'] = "Failed to open CSV file.";
        }
    } else {
        $_SESSION['error'] = "No file uploaded or invalid file.";
    }
    header("Location: ../view/products.php");
    exit;
}
?>