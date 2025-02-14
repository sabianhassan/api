<?php
require_once __DIR__ . '/../classes/Database.php'; // Correct path
$pdo = connectDatabase();

// Get total rooms
$total_rooms = $pdo->query("SELECT SUM(quantity) FROM rooms")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome Icons -->
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="header">Admin Panel</div>
        <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="manage_rooms.php"><i class="fas fa-bed"></i> Manage Rooms</a>
        <a href="manage_booking.php"><i class="fas fa-calendar-check"></i> Manage Bookings</a>
        <a href="manage_users.php"><i class="fas fa-user"></i> Manage Users</a>
        <a href="manage_packages.php"><i class="fas fa-box"></i> Packages & Meals</a>
        <a href="reports.php"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
        <a href="admin_logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Welcome to Admin Dashboard</h2>
        <p>Total Rooms Available: <strong><?php echo $total_rooms; ?></strong></p>
    </div>

</body>
</html>
