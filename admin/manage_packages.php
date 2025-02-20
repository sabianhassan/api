<?php
require_once '../classes/Database.php'; // Adjust path if needed
$conn = connectDatabase();

// -------------------- Handle Adding a New Package --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_package'])) {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;

    if (!empty($name) && !empty($price)) {
        $stmt = $conn->prepare("INSERT INTO packages (name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
        header("Location: manage_packages.php");
        exit;
    }
}

// -------------------- Handle Deleting a Package --------------------
if (isset($_GET['delete'])) {
    $package_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM packages WHERE package_id = ?");
    $stmt->execute([$package_id]);
    header("Location: manage_packages.php");
    exit;
}

// -------------------- Handle Editing a Package (Step 1: Show Form) --------------------
$edit_package = null;
if (isset($_GET['edit'])) {
    $package_id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM packages WHERE package_id = ?");
    $stmt->execute([$package_id]);
    $edit_package = $stmt->fetch(PDO::FETCH_ASSOC);
}

// -------------------- Handle Updating a Package (Step 2: Process Form) --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_package'])) {
    $package_id = (int)$_POST['package_id'];
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;

    if (!empty($package_id) && !empty($name) && !empty($price)) {
        $stmt = $conn->prepare("UPDATE packages SET name = ?, price = ? WHERE package_id = ?");
        $stmt->execute([$name, $price, $package_id]);
    }
    header("Location: manage_packages.php");
    exit;
}

// -------------------- Fetch All Packages for Display --------------------
$stmt = $conn->prepare("SELECT * FROM packages ORDER BY package_id ASC");
$stmt->execute();
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Packages</title>
    <link rel="stylesheet" href="../../assets/style.css"><!-- Adjust path -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Manage Packages</h2>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <!-- Add or Edit Package Form -->
    <?php if ($edit_package): ?>
        <!-- Editing Existing Package -->
        <h4>Edit Package (ID: <?= $edit_package['package_id'] ?>)</h4>
        <form method="POST" class="mb-4">
            <input type="hidden" name="package_id" value="<?= $edit_package['package_id'] ?>">
            <div class="row">
                <div class="col-md-4">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?= htmlspecialchars($edit_package['name']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label>Price (USD):</label>
                    <input type="number" name="price" class="form-control" step="0.01"
                           value="<?= htmlspecialchars($edit_package['price']) ?>" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="update_package" class="btn btn-primary mt-4">Update Package</button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <!-- Adding New Package -->
        <h4>Add New Package</h4>
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Price (USD):</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="add_package" class="btn btn-primary mt-4">Add Package</button>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <!-- Packages Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Package ID</th>
                <th>Name</th>
                <th>Price (USD)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($packages)): ?>
                <tr>
                    <td colspan="4" class="text-center">No packages found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($packages as $pkg): ?>
                    <tr>
                        <td><?= $pkg['package_id'] ?></td>
                        <td><?= htmlspecialchars($pkg['name']) ?></td>
                        <td>$<?= number_format($pkg['price'], 2) ?></td>
                        <td>
                            <a href="?edit=<?= $pkg['package_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?= $pkg['package_id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this package?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
