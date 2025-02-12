<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

require_once '../database.php'; // Ensure the database connection

// Handle Booking Status Updates
if (isset($_POST['action']) && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['action']; // 'Approved' or 'Rejected'

    // Update booking status
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $booking_id])) {
        echo "Booking status updated successfully!";
    } else {
        echo "Failed to update booking status.";
    }
}

// Fetch All Bookings
$stmt = $pdo->query("SELECT b.id, u.name AS user_name, b.room, b.package, b.meal, b.additional, b.status, b.created_at 
                     FROM bookings b 
                     JOIN users u ON b.user_id = u.userid 
                     ORDER BY b.created_at DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Ensure styling -->
</head>
<body>
    <h2>Manage Bookings</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Room</th>
            <th>Package</th>
            <th>Meal</th>
            <th>Additional</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?= $booking['id'] ?></td>
                <td><?= htmlspecialchars($booking['user_name']) ?></td>
                <td><?= htmlspecialchars($booking['room']) ?></td>
                <td><?= htmlspecialchars($booking['package']) ?></td>
                <td><?= htmlspecialchars($booking['meal']) ?></td>
                <td><?= htmlspecialchars($booking['additional']) ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>
                <td>
                    <?php if ($booking['status'] == 'Pending'): ?>
                        <form method="POST">
                            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                            <button type="submit" name="action" value="Approved">Approve</button>
                            <button type="submit" name="action" value="Rejected">Reject</button>
                        </form>
                    <?php else: ?>
                        <?= $booking['status'] ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
