<?php
require_once __DIR__ . '/../classes/Database.php'; // Correct path
$pdo = connectDatabase();

// Get total rooms
$total_rooms = $pdo->query("SELECT SUM(quantity) FROM rooms")->fetchColumn();

// Get inventory stats
$total_inventory = $pdo->query("SELECT COUNT(*) FROM inventories")->fetchColumn();
$low_stock_items = $pdo->query("SELECT COUNT(*) FROM inventories WHERE quantity < 5")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome Icons -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for graphs -->
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
        <a href="manage_inventories.php"><i class="fas fa-warehouse"></i> Manage Inventories</a>
        <a href="reports.php"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
        <a href="admin_logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Welcome to Admin Dashboard</h2>

        <!-- Statistics Summary -->
        <div class="stats-container">
            <div class="stat-box">
                <h3>Total Rooms</h3>
                <p><?php echo $total_rooms; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Inventory Items</h3>
                <p><?php echo $total_inventory; ?></p>
            </div>
            <div class="stat-box low-stock">
                <h3>Low Stock Items</h3>
                <p><?php echo $low_stock_items; ?></p>
            </div>
        </div>

        <!-- Inventory Report -->
        <div class="inventory-report">
            <h3>Inventory Overview</h3>
            <canvas id="inventoryChart"></canvas>
            <button onclick="exportPDF()">Export to PDF</button>
            <button onclick="exportExcel()">Export to Excel</button>
        </div>
    </div>

    <script>
        // Fetch inventory data dynamically (example AJAX request)
        function loadInventoryData() {
            fetch("fetch_inventory_data.php")
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById("inventoryChart").getContext("2d");
                    new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: "Stock Quantity",
                                data: data.values,
                                backgroundColor: ["#3498db", "#e74c3c", "#2ecc71"],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                });
        }

        // Call function on page load
        document.addEventListener("DOMContentLoaded", loadInventoryData);

        // Export functions (Placeholder)
        function exportPDF() {
            alert("Exporting report to PDF...");
            // Implement PDF export logic
        }

        function exportExcel() {
            alert("Exporting report to Excel...");
            // Implement Excel export logic
        }
    </script>

</body>
</html>