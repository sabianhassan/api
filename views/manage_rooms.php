<?php
require_once "../classes/Room.php";
$roomObj = new Room();

// Fetch all rooms
$rooms = $roomObj->getRooms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Room Management</h2>
    <button onclick="document.getElementById('addRoomModal').style.display='block'">Add Room</button>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Room Type</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($rooms as $room) : ?>
        <tr>
            <td><?= $room['id']; ?></td>
            <td><?= $room['room_type']; ?></td>
            <td><?= $room['price']; ?></td>
            <td><?= $room['status']; ?></td>
            <td>
                <a href="edit_room.php?id=<?= $room['id']; ?>">Edit</a>
                <a href="delete_room.php?id=<?= $room['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                <a href="book_room.php?id=<?= $room['id']; ?>">Book</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Add Room Modal -->
    <div id="addRoomModal" style="display:none;">
        <form action="add_room.php" method="POST">
            <label>Room Type:</label> <input type="text" name="room_type" required>
            <label>Price:</label> <input type="number" name="price" required>
            <label>Status:</label>
            <select name="status">
                <option value="Available">Available</option>
                <option value="Booked">Booked</option>
            </select>
            <button type="submit">Add Room</button>
        </form>
    </div>
</body>
</html>
