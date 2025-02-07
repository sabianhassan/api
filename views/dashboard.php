<?php include_once '../templates/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">Hotel Management Dashboard</h2>
    <p class="text-center">Manage rooms, reservations, users, and reports.</p>

    <div class="row">
        <!-- Rooms Section -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>Total Rooms</h3>
                    <p><strong>50</strong></p>
                    <a href="manage_rooms.php" class="btn btn-primary">Manage Rooms</a>
                </div>
            </div>
        </div>

        <!-- Reservations Section -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>Reservations</h3>
                    <p><strong>120</strong></p>
                    <a href="reservations.php" class="btn btn-success">View Reservations</a>
                </div>
            </div>
        </div>

        <!-- Users Section -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>Users</h3>
                    <p><strong>30</strong></p>
                    <a href="users.php" class="btn btn-warning">Manage Users</a>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>Reports</h3>
                    <p>Analytics & Charts</p>
                    <a href="reports.php" class="btn btn-danger">View Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../templates/footer.php'; ?>