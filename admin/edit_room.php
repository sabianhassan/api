<?php
require_once __DIR__ . '/../classes/Database.php';
$pdo = connectDatabase();

// Ensure that an ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No room ID provided.");
}

$room_id = intval($_GET['id']);

// Fetch the current room details
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$room_id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    die("Room not found.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the new quantity from the form
    $quantity = $_POST["quantity"] ?? null;
    if ($quantity !== null && is_numeric($quantity)) {
        $stmt = $pdo->prepare("UPDATE rooms SET quantity = ? WHERE id = ?");
        if ($stmt->execute([$quantity, $room_id])) {
            // Redirect back to manage_rooms.php after successful update
            header("Location: manage_rooms.php");
            exit();
        } else {
            $error = "Error updating room. Please try again.";
        }
    } else {
        $error = "Please enter a valid quantity.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room - <?php echo htmlspecialchars($room['room_type']); ?></title>
    <link rel="stylesheet" href="../assets/admin_styles.css">
    <style>
        body {
            background-color: #1e1e2f;
            color: #ffffff;
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }
        form {
            margin: 20px auto;
            max-width: 400px;
            background: #2a2a3a;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: none;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4caf50;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: #ff4d4d;
            margin-bottom: 20px;
        }
        a {
            color: #ffffff;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h2>Edit Room - <?php echo htmlspecialchars($room['room_type']); ?></h2>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="edit_room.php?id=<?php echo $room_id; ?>" method="POST">
        <label for="quantity">Available Rooms:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($room['quantity']); ?>" required>
        <button type="submit">Update Room</button>
    </form>

    <a href="manage_rooms.php">⬅ Back to Manage Rooms</a>
</body>
</html>
