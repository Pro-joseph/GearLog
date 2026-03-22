<?php
require '../model/db.php';

$username = 'admin';
$password = password_hash('Admin123!', PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'username' => $username,
    'password' => $password
]);