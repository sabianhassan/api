<?php include 'admin_dashboard_header.php'; ?>

<div class="container-fluid">
    <h2 class="mt-3">Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?> 👋</h2>
    <p class="text-muted">Here is a quick overview of the hotel management system.</p>

    <?php
    // Include your function-based Database file
    require '../classes/Database.php';
    // Call the function to get the PDO connection
    $pdo = connectDatabase();
    ?>

    <!-- Dashboard Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">Manage registered users.</p>
                    <h2 class="text-center">
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
                        echo $stmt->fetchColumn();
                        ?>
                    </h2>
                    <a href="manage_users.php" class="btn btn-light btn-sm">View Users</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Rooms</h5>
                    <p class="card-text">Monitor and manage hotel rooms.</p>
                    <h2 class="text-center">
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) FROM rooms");
                        echo $stmt->fetchColumn();
                        ?>
                    </h2>
                    <a href="manage_rooms.php" class="btn btn-light btn-sm">Manage Rooms</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Bookings</h5>
                    <p class="card-text">Approve or reject booking requests.</p>
                    <h2 class="text-center">
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'Pending'");
                        echo $stmt->fetchColumn();
                        ?>
                    </h2>
                    <a href="manage_booking.php" class="btn btn-light btn-sm">Manage Bookings</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Packages</h5>
                    <p class="card-text">Add or edit packages & meals.</p>
                    <h2 class="text-center">
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) FROM packages");
                        echo $stmt->fetchColumn();
                        ?>
                    </h2>
                    <a href="manage_packages.php" class="btn btn-light btn-sm">Manage Packages</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <a href="manage_users.php" class="btn btn-outline-primary btn-sm">Manage Users</a>
                    <a href="manage_rooms.php" class="btn btn-outline-success btn-sm">Manage Rooms</a>
                    <a href="manage_booking.php" class="btn btn-outline-warning btn-sm">Manage Bookings</a>
                    <a href="manage_packages.php" class="btn btn-outline-danger btn-sm">Manage Packages</a>
                    <li><a href="analytics.php"><i class="fas fa-chart-line"></i> Analytics</a></li>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title">Admin Settings</h5>
                    <a href="admin_logout.php" class="btn btn-dark btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'admin_dashboard_footer.php'; ?>
