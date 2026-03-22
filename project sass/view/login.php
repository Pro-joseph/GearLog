<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../model/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../view/index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4" style="width: 350px;">
        
        <div class="text-center mb-3">
            <img src="logos.png" class="img-fluid mb-2" width="120">
            <h4 class="fw-bold">Login</h4>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center p-2">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Username</label><br>
                <label class="">admin</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="username" 
                    placeholder="Enter your username" 
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label><br>
                <label class="">Admin123!</label>
                <input 
                    type="password" 
                    class="form-control" 
                    name="password" 
                    placeholder="Enter your password" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>