<?php
session_start();
include '../classes/Database.php'; // Correct path

// Initialize Database connection
$database = new Database();
$conn = $database->getConnection(); // Get PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $user_id = $_SESSION['user_id']; // Assuming user is logged in

    // Validate input
    if (empty($room_id) || empty($check_in) || empty($check_out)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: dashboard.php");
        exit();
    }

    // Check if the room is still available
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ? AND status = 'available'");
    $stmt->execute([$room_id]);
    $roomResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$roomResult) {
        $_SESSION['error'] = "Sorry, this room is no longer available!";
        header("Location: dashboard.php");
        exit();
    }

    // Insert booking into the database
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, check_in, check_out, status) VALUES (?, ?, ?, ?, 'pending')");
    if ($stmt->execute([$user_id, $room_id, $check_in, $check_out])) {
        // Update room status to "booked"
        $updateRoom = $conn->prepare("UPDATE rooms SET status = 'booked' WHERE id = ?");
        $updateRoom->execute([$room_id]);

        $_SESSION['success'] = "Room booked successfully! Pending admin approval.";
    } else {
        $_SESSION['error'] = "Something went wrong. Try again!";
    }

    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>
