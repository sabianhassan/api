<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "saby2030", "sacco");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Approve or Reject Booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status']; // Approved or Rejected

    $sql = "UPDATE bookings SET status = '$status' WHERE id = '$booking_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking has been updated!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch all bookings
$result = $conn->query("SELECT bookings.*, users.name, users.email FROM bookings JOIN users ON bookings.user_id = users.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Jambo Hotel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>Admin Panel - Booking Requests</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Room Type</th>
                    <th>Package</th>
                    <th>Meal</th>
                    <th>Duration</th>
                    <th>Pool</th>
                    <th>Bar</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['room_type']; ?></td>
                        <td><?= $row['package']; ?></td>
                        <td><?= $row['meal_package']; ?></td>
                        <td><?= $row['duration']; ?> days</td>
                        <td><?= $row['pool_access'] ? 'Yes' : 'No'; ?></td>
                        <td><?= $row['bar_access'] ? 'Yes' : 'No'; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="booking_id" value="<?= $row['id']; ?>">
                                <button type="submit" name="status" value="Approved" class="btn btn-success">Approve</button>
                                <button type="submit" name="status" value="Rejected" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
