<?php
session_start();
require_once '../classes/Database.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = connectDatabase();
$user_id = $_SESSION['user_id'];

// Fetch all bookings for the logged-in user, ordered by most recent first
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_id DESC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once '../templates/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center">My Bookings</h2>

    <?php if (empty($bookings)): ?>
        <p class="text-center">You have no bookings at the moment.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Room ID</th>
                    <th>Package</th>
                    <th>Meal Plan</th>
                    <th>Duration (days)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                        <td><?= htmlspecialchars($booking['room_id']) ?></td>
                        <td><?= htmlspecialchars($booking['package']) ?></td>
                        <td><?= htmlspecialchars($booking['meal']) ?></td>
                        <td><?= htmlspecialchars($booking['duration']) ?></td>
                        <td>
                            <?php 
                                $status = $booking['status'];
                                $badgeClass = 'bg-warning'; // Default for Pending
                                if ($status === 'Approved') {
                                    $badgeClass = 'bg-success';
                                } elseif ($status === 'Rejected') {
                                    $badgeClass = 'bg-danger';
                                }
                            ?>
                            <span class="badge <?= $badgeClass ?>">
                                <?= htmlspecialchars($status) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-primary">Return to Dashboard</a>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>
