<?php
require_once '../classes/Database.php'; // Ensure this path is correct for your project

// Connect using the function instead of a class
$conn = connectDatabase();

// Handle room addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_room"])) {
    $room_type = $_POST["room_type"];
    $price = $_POST["price"];

    // Assign room_id based on type
    $room_id_range = [
        "Single" => [100, 150],
        "Double" => [151, 176],
        "Suite"  => [177, 202]
    ];

    if (isset($room_id_range[$room_type])) {
        $range = $room_id_range[$room_type];
        $stmt = $conn->prepare("SELECT MAX(room_id) FROM rooms WHERE room_id BETWEEN ? AND ?");
        $stmt->execute([$range[0], $range[1]]);
        $max_id = $stmt->fetchColumn() ?? $range[0] - 1;
        $new_room_id = ($max_id < $range[1]) ? $max_id + 1 : null;
    } else {
        $new_room_id = null;
    }

    if ($new_room_id) {
        $stmt = $conn->prepare("INSERT INTO rooms (room_id, room_type, price, status) VALUES (?, ?, ?, 'Available')");
        $stmt->execute([$new_room_id, $room_type, $price]);
    }
}

// Handle room deletion
if (isset($_GET['delete'])) {
    $room_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
    $stmt->execute([$room_id]);
    header("Location: manage_rooms.php");
    exit;
}

// Fetch all rooms
$stmt = $conn->prepare("SELECT * FROM rooms ORDER BY room_id ASC");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Manage Rooms</h2>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <!-- Add Room Form -->
    <form method="post" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label>Room Type:</label>
                <select name="room_type" class="form-control" required>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Suite">Suite</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Price (USD):</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="col-md-4">
                <button type="submit" name="add_room" class="btn btn-primary mt-4">Add Room</button>
            </div>
        </div>
    </form>

    <!-- Room Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Type</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?= $room['room_id'] ?></td>
                    <td><?= $room['room_type'] ?></td>
                    <td>$<?= number_format($room['price'], 2) ?></td>
                    <td><?= $room['status'] ?></td>
                    <td>
                        <a href="?delete=<?= $room['room_id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this room?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
