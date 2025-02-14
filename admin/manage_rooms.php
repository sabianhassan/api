<?php
require_once __DIR__ . '/../classes/Database.php'; // Correct path

$pdo = connectDatabase();
$rooms = $pdo->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="../assets/admin_styles.css"> <!-- Keep styles separate -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f; /* Dark theme */
            color: #ffffff;
            margin: 20px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #2a2a3a;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #444;
            text-align: center;
        }
        th {
            background-color: #33334d;
        }
        tr:nth-child(even) {
            background-color: #3a3a5a;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .edit-btn {
            background-color: #4caf50;
            color: white;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
        .edit-btn:hover {
            background-color: #45a049;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h2>Manage Rooms</h2>
    <table>
        <thead>
            <tr>
                <th>Room Type</th>
                <th>Price</th>
                <th>Available Rooms</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
            <tr>
                <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                <td>$<?php echo htmlspecialchars($room['price']); ?></td>
                <td><?php echo htmlspecialchars($room['quantity']); ?></td>
                <td>
                    <a href="edit_room.php?id=<?php echo $room['id']; ?>" class="edit-btn">Edit</a>
                    <a href="delete_room.php?id=<?php echo $room['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
