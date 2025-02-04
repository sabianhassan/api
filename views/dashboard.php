<?php
session_start();

// Check if user is logged in (Add authentication check)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Jambo Hotel</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">JAMBO RESERVATIONS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_rooms.php">Rooms</a></li>
                    <li class="nav-item"><a class="nav-link" href="reservations.php">Reservations</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard -->
    <div class="container mt-5">
        <h2 class="text-center">Admin Dashboard</h2>

        <div class="row mt-4">
            <!-- Total Rooms -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Rooms</h5>
                        <p class="card-text" id="totalRooms">Loading...</p>
                    </div>
                </div>
            </div>

            <!-- Total Reservations -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Reservations</h5>
                        <p class="card-text" id="totalReservations">Loading...</p>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text" id="totalUsers">Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reservations -->
        <h3 class="mt-5">Recent Reservations</h3>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Guest Name</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="recentReservations">
                <tr><td colspan="6" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fetch stats using AJAX
        document.addEventListener("DOMContentLoaded", function() {
            fetch('fetch_dashboard_data.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalRooms').innerText = data.totalRooms;
                    document.getElementById('totalReservations').innerText = data.totalReservations;
                    document.getElementById('totalUsers').innerText = data.totalUsers;

                    let reservationTable = document.getElementById('recentReservations');
                    reservationTable.innerHTML = "";
                    data.recentReservations.forEach((res, index) => {
                        reservationTable.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${res.guest_name}</td>
                                <td>${res.room_number}</td>
                                <td>${res.check_in}</td>
                                <td>${res.check_out}</td>
                                <td>${res.status}</td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Error fetching dashboard data:', error));
        });
    </script>

</body>
</html>
