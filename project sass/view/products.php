<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../controller/auth.php';
include '../model/db.php';
include '../include/header.php';
include('../controller/add_asset.php');


if ($_SESSION['role'] !== 'admin') {
    die("you are not authorised here");
}

// Fetch all categories once
$sql_cat = "SELECT * FROM categories";
$stmt_cat = $conn->prepare($sql_cat);
$stmt_cat->execute();
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

// Fetch assets
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $sql = "SELECT a.*, c.name AS category_name
            FROM assets a
            INNER JOIN categories c ON a.category_id = c.id
            WHERE a.device_name LIKE :search OR a.serial_number LIKE :search
            ORDER BY a.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $sql = "SELECT a.*, c.name AS category_name
            FROM assets a
            INNER JOIN categories c ON a.category_id = c.id
            ORDER BY a.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<title>Devices</title>
</head>
<body>

<div class="container my-4">
    <h3 class="text-center mb-4">DEVICES</h3>

    <!-- Alerts -->
    <!-- <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?> -->

<!-- button form and search bar -->
        <div class="d-flex mb-3 gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-laptop"></i> Add Device
            </button>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                Add Bulk Devices
            </button>
        </div>
        <div class="">
          <div class="modal fade" id="addProductModal">
              <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Product</h5>
                  <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                  <div class="m-2 text-danger"><h6>* Attention. All fieldes must be entre or nothing will be saved</h6></div>
                <div class="modal-body">

                  <form action="" method="POST">

                    <div class="mb-3">
                      <label class="form-label">Device Name</label>
                      <input type="text" name="device_name" class="form-control">
                      <!-- <span class="text-danger"><?= $device_nameErr ?></span> -->
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Serial Number</label>
                      <input type="text" name="serial_number" class="form-control">
                      <!-- <span class="text-danger"><?= $serial_numberErr ?></span> -->
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Price</label>
                      <input type="number" step="0.01" name="price" class="form-control">
                      <!-- <span class="text-danger"><?= $priceErr ?></span> -->
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-control">
                        <option>In Stock</option>
                        <option>Deployed</option>
                        <option>Under Repair</option>
                      </select>
                      <label class="form-label">Category</label>
                      <select name="categories_id" class="form-control">
                        <?php foreach ($categories as $cat): ?>
                          <option value="<?php echo $cat['id']; ?>">
                              <?php echo htmlspecialchars($cat['name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <button class="btn btn-success w-100">Save Device</button>
                </form>
      </div>
    </div>
  </div>
</div>
        
<div class="">
        <!-- CSV Modal -->
        <div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="../controller/import_csv.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                <h5 class="modal-title" id="uploadCsvLabel">Upload CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="csvFile" class="form-label">Choose CSV file</label>
                    <input type="file" name="csv_file" id="csvFile" class="form-control" accept=".csv" required>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="import_csv" class="btn btn-success">Upload</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover table-striped border shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Device Name</th>
                    <th>Serial Number</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($assets as $asset): ?>
                <tr>
                    <td><?= $asset['id'] ?></td>
                    <td><?= htmlspecialchars($asset['device_name']) ?></td>
                    <td><?= htmlspecialchars($asset['serial_number']) ?></td>
                    <td><?= htmlspecialchars($asset['price']." DH") ?></td>
                    <td><?= htmlspecialchars($asset['category_name']) ?></td>
                    <td><?= htmlspecialchars($asset['status']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $asset['id'] ?>">Edit</button>
                        <a href="../controller/delete_asset.php?id=<?= $asset['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modals -->
<?php foreach($assets as $asset): ?>
<div class="modal fade" id="editModal<?= $asset['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../controller/edit_asset.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $asset['id'] ?>">
                    <div class="mb-3">
                        <label>Device Name</label>
                        <input type="text" name="device_name" class="form-control" value="<?= htmlspecialchars($asset['device_name']) ?>">
                    </div>
                    <div class="mb-3">
                        <label>Serial Number</label>
                        <input type="text" name="serial_number" class="form-control" value="<?= htmlspecialchars($asset['serial_number']) ?>">
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($asset['price']) ?>">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option <?= $asset['status']=='In Stock' ? 'selected' : '' ?>>In Stock</option>
                            <option <?= $asset['status']=='Deployed' ? 'selected' : '' ?>>Deployed</option>
                            <option <?= $asset['status']=='Under Repair' ? 'selected' : '' ?>>Under Repair</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category_id" class="form-control">
                            <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id']==$asset['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Auto-hide alerts
<script>
document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
});
</script> -->

</body>
</html>