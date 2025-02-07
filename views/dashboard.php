<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "saby2030", "sacco");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_type = $_POST['room_type'];
    $package = $_POST['package'];
    $meal_package = $_POST['meal_package'];
    $duration = $_POST['duration'];
    $pool_access = isset($_POST['pool_access']) ? 1 : 0;
    $bar_access = isset($_POST['bar_access']) ? 1 : 0;
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO bookings (user_id, room_type, package, meal_package, duration, pool_access, bar_access, status) 
            VALUES ('$user_id', '$room_type', '$package', '$meal_package', '$duration', '$pool_access', '$bar_access', 'Pending')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking request submitted! Wait for admin approval.');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Jambo Hotel</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Linked to the common style.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <a href="logout.php" class="logout-btn">Logout</a>

    <div class="container">
        <h1>Welcome to Jambo Hotel Dashboard</h1>
        <p>Select your desired room package and submit for approval.</p>

        <form method="POST" action="dashboard.php">
            <label for="room_type">Choose Room Type:</label>
            <select name="room_type" id="room_type" required>
                <option value="Studio">Studio</option>
                <option value="Triple Room">Triple Room</option>
                <option value="Single Room">Single Room</option>
                <option value="Double Room">Double Room</option>
                <option value="Suite">Suite</option>
                <option value="Presidential Suite">Presidential Suite</option>
            </select>

            <label for="package">Choose a Package:</label>
            <select name="package" id="package" required>
                <option value="Romantic Package">Romantic Package</option>
                <option value="Family Fun Package">Family Fun Package</option>
                <option value="Business Package">Business Package</option>
                <option value="Golf Package">Golf Package</option>
            </select>

            <label for="meal_package">Choose a Meal Package:</label>
            <select name="meal_package" id="meal_package" required>
                <option value="Breakfast Only">Breakfast Only</option>
                <option value="Three Course Meal">Three Course Meal</option>
                <option value="Drinks">Drinks</option>
            </select>

            <label for="duration">Number of Days:</label>
            <input type="number" name="duration" id="duration" required>

            <label for="pool_access">Pool Access:</label>
            <input type="checkbox" name="pool_access" id="pool_access">

            <label for="bar_access">Bar Access:</label>
            <input type="checkbox" name="bar_access" id="bar_access">

            <button type="submit">Submit</button>
        </form>
    </div>

</body>
</html>
