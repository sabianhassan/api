<?php
header('Content-Type: application/json');
require '../classes/Database.php';

$pdo = connectDatabase();

// Group bookings by check_in date
$stmt = $pdo->query("
    SELECT DATE(check_in) AS date, COUNT(*) AS total
    FROM bookings
    GROUP BY DATE(check_in)
    ORDER BY date ASC
");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dates = [];
$bookings = [];

foreach ($results as $row) {
    $dates[] = $row['date'];
    $bookings[] = $row['total'];
}

// Return JSON for Chart.js
echo json_encode([
    'dates' => $dates,
    'bookings' => $bookings
]);
?>
