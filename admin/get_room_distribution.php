<?php
header('Content-Type: application/json');
require '../classes/Database.php';

$pdo = connectDatabase();

// Count how many bookings each room type has
$stmt = $pdo->query("
    SELECT r.room_type, COUNT(*) AS total
    FROM bookings b
    JOIN rooms r ON b.room_id = r.room_id
    GROUP BY r.room_type
    ORDER BY total DESC
");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$roomTypes = [];
$totals = [];

foreach ($results as $row) {
    $roomTypes[] = $row['room_type'];
    $totals[] = $row['total'];
}

// Return JSON for Chart.js
echo json_encode([
    'roomTypes' => $roomTypes,
    'totals'    => $totals
]);
?>
