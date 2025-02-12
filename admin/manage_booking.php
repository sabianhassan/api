<?php
include '../config/database.php';
$pdo = connectDatabase();

if (isset($_GET['approve'])) {
    $booking_id = $_GET['approve'];
    $stmt = $pdo->prepare("UPDATE bookings SET status='Approved' WHERE id=?");
    $stmt->execute([$booking_id]);
}

if (isset($_GET['cancel'])) {
    $booking_id = $_GET['cancel'];
    $stmt = $pdo->prepare("UPDATE bookings SET status='Cancelled' WHERE id=?");
    $stmt->execute([$booking_id]);
}

// Fetch all bookings
$stmt = $pdo->query("SELECT * FROM bookings");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../templates/admin_header.php'; ?>

<h2>Manage Bookings</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Room</th>
        <th>Package</th>
        <th>Meal</th>
        <th>Additional</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($bookings as $booking): ?>
    <tr>
        <td><?= $booking['id'] ?></td>
        <td><?= $booking['room'] ?></td>
        <td><?= $booking['package'] ?></td>
        <td><?= $booking['meal'] ?></td>
        <td><?= $booking['additional'] ?></td>
        <td><?= $booking['status'] ?></td>
        <td>
            <a href="manage_bookings.php?approve=<?= $booking['id'] ?>">Approve</a>
            <a href="manage_bookings.php?cancel=<?= $booking['id'] ?>">Cancel</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../templates/admin_footer.php'; ?>
