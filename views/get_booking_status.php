<?php
header('Content-Type: application/json');
require_once '../classes/Database.php';
$pdo = connectDatabase();

$booking_id = $_GET['booking_id'] ?? null;
if (!$booking_id) {
    echo json_encode(['status' => 'Unknown']);
    exit;
}

$stmt = $pdo->prepare("SELECT status FROM bookings WHERE booking_id = ?");
$stmt->execute([$booking_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'status' => $row ? $row['status'] : 'Unknown'
]);
?>
