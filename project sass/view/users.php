<?php
require_once '../controller/auth.php';
require_once '../model/db.php';
require_once('../include/header.php');



if ($_SESSION['role'] !== 'admin') {
    die("you are not authorised here");
}

// ADD EMPLOYEE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $title = $_POST['title'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check duplicate username
    $check = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $check->execute(['username' => $username]);

    if ($check->fetch()) {
        die("Username already exists");
    }

    $stmt = $conn->prepare("
        INSERT INTO users (username, email, password, role, title)
        VALUES (:username, :email, :password, 'employee', :title)
    ");

    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'title' => $title
    ]);

    header("Location: users.php");
    exit();
}
  

// delete
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id AND role = 'employee'");
    $stmt->execute(['id' => $id]);

    header("Location: users.php");
    exit();
}

// edit user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {

    $id = (int) $_POST['update_id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $title = $_POST['title'];

    if (!empty($username) && !empty($email)) {

        $stmt = $conn->prepare("
            UPDATE users 
            SET username = :username, email = :email, title = :title 
            WHERE id = :id AND role = 'employee'
        ");

        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'title' => $title,
            'id' => $id
        ]);
    }

    header("Location: users.php");
    exit();
}

// FETCH USERS
$stmt = $conn->prepare("SELECT id, username, email, title FROM users WHERE role = 'employee'");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<title>Manage Employees</title>
</head>

<body class="bg-light">

<div class="container mt-5">

    <h3 class="mb-4 text-center">Manage Employees</h3>

    <!-- ADD BUTTON -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        Add Employee
    </button>

    <!-- ADD MODAL -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST">
                    <div class="modal-header">
                        <h5>Add Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

                        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                        <select name="title" class="form-control">
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
                            <option value="intern">Intern</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="add_user" class="btn btn-primary">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- TABLE -->
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Title</th>
                <th width="200">Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>

                <!-- Username -->
                <td>
                    <form method="POST" class="d-flex gap-2 align-items-center">
                        <input type="hidden" name="update_id" value="<?= $user['id'] ?>">

                        <input type="text" name="username"
                            value="<?= htmlspecialchars($user['username']) ?>"
                            class="form-control form-control-sm">

                </td>

                <!-- Email -->
                <td>
                        <input type="email" name="email"
                            value="<?= htmlspecialchars($user['email']) ?>"
                            class="form-control form-control-sm">
                </td>

                <!-- Title -->
                <td>
                        <select name="title" class="form-control form-control-sm">
                            <option value="manager" <?= $user['title']=='manager'?'selected':'' ?>>Manager</option>
                            <option value="staff" <?= $user['title']=='staff'?'selected':'' ?>>Staff</option>
                            <option value="intern" <?= $user['title']=='intern'?'selected':'' ?>>Intern</option>
                        </select>
                </td>

                <!-- Actions -->
                <td class="d-flex gap-2">
                        <button class="btn btn-success btn-sm">Update</button>
                    </form>

                    <a href="?delete=<?= $user['id'] ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this employee?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

</body>
</html>