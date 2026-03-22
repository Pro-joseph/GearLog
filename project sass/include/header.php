<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<title>Gear Log</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
        <img src="logos.png" class="img-fluid" width="80" height="50" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active link-opacity-50-hove" aria-current="page" href="index.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active link-opacity-50-hove" href="products.php">Devices</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active link-opacity-50-hove" href="users.php">Employers</a>
        </li>
      </ul>

      <!-- Search form -->
      <form class="d-flex mb-2 mb-lg-0 me-2" role="search" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Search" value="">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>

      <!-- Logout button -->
      <form method="POST" class="d-flex">
        <button type="submit" name="logout" class="btn btn-danger">Log Out</button>
      </form>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-MmFvZhwzPkuLkYv8XtL8l6VtUQ+gJz0y5m1/v4b3vJpZ+v+ZCkQx0K5pXzQk0Jm0" crossorigin="anonymous"></script>
</body>
</html>