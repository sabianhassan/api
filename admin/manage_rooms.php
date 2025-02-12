<?php
include '../config/database.php';

$pdo = connectDatabase();
$rooms = $pdo->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
?>

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
            <td><?php echo $room['room_type']; ?></td>
            <td>$<?php echo $room['price']; ?></td>
            <td><?php echo $room['quantity']; ?></td>
            <td>
                <a href="edit_room.php?id=<?php echo $room['id']; ?>">Edit</a>
                <a href="delete_room.php?id=<?php echo $room['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
