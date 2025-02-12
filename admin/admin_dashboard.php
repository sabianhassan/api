<?php
require_once __DIR__ . '/../classes/Database.php'; // Correct path

$pdo = connectDatabase(); 

// Get total rooms
$total_rooms = $pdo->query("SELECT SUM(quantity) FROM rooms")->fetchColumn();
?>

<div class="dashboard-section">
    <h3>Total Rooms Available: <?php echo $total_rooms; ?></h3>
</div>
