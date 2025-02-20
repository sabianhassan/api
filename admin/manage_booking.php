<?php
require_once '../classes/Database.php'; // Adjust path if needed

$conn = connectDatabase();

// --- Handle Approve ---
if (isset($_GET['approve'])) {
    $booking_id = (int)$_GET['approve'];
    $stmt = $conn->prepare("UPDATE bookings SET status = 'Approved' WHERE booking_id = ?");
    $stmt->execute([$booking_id]);
    header("Location: manage_bookings.php");
    exit;
}

// --- Handle Reject ---
if (isset($_GET['reject'])) {
    $booking_id = (int)$_GET['reject'];
    $stmt = $conn->prepare("UPDATE bookings SET status = 'Rejected' WHERE booking_id = ?");
    $stmt->execute([$booking_id]);
    header("Location: manage_bookings.php");
    exit;
}

// --- Handle Delete ---
if (isset($_GET['delete'])) {
    $booking_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
    $stmt->execute([$booking_id]);
    header("Location: manage_bookings.php");
    exit;
}

// --- Fetch All Bookings with JOIN for user & room info ---
$sql = "
    SELECT b.booking_id, b.user_id, b.room_id, b.check_in, b.check_out, b.status,
           u.email AS user_email,     -- Using email from users table
           r.room_type
    FROM bookings b
    JOIN users u ON b.user_id = u.userid
    JOIN rooms r ON b.room_id = r.room_id
    ORDER BY b.booking_id DESC
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Manage Bookings</h2>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User (Email)</th>
                <th>Room</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($bookings) === 0): ?>
            <tr>
                <td colspan="7" class="text-center">No bookings found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['booking_id'] ?></td>
                    <td><?= htmlspecialchars($booking['user_email']) ?></td>
                    <td><?= htmlspecialchars($booking['room_type']) ?> (ID <?= $booking['room_id'] ?>)</td>
                    <td><?= $booking['check_in'] ?></td>
                    <td><?= $booking['check_out'] ?></td>
                    <td>
                        <?php
                            $status = $booking['status'];
                            $badgeClass = 'secondary';
                            if ($status === 'Approved') {
                                $badgeClass = 'success';
                            } elseif ($status === 'Rejected') {
                                $badgeClass = 'danger';
                            } elseif ($status === 'Pending') {
                                $badgeClass = 'warning';
                            }
                        ?>
                        <span class="badge bg-<?= $badgeClass ?>">
                            <?= $status ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($booking['status'] === 'Pending'): ?>
                            <a href="?approve=<?= $booking['booking_id'] ?>"
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Approve this booking?');">
                               Approve
                            </a>
                            <a href="?reject=<?= $booking['booking_id'] ?>"
                               class="btn btn-warning btn-sm"
                               onclick="return confirm('Reject this booking?');">
                               Reject
                            </a>
                        <?php endif; ?>
                        <a href="?delete=<?= $booking['booking_id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this booking permanently?');">
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
