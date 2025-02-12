<?php
include '../config/database.php'; // Make sure this path is correct

// Connect to the database
$pdo = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room = $_POST["room"];
    $package = $_POST["package"];
    $meal = $_POST["meal"];
    $additional = $_POST["additional"];

    try {
        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO bookings (room, package, meal, additional) VALUES (:room, :package, :meal, :additional)";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':room', $room);
        $stmt->bindParam(':package', $package);
        $stmt->bindParam(':meal', $meal);
        $stmt->bindParam(':additional', $additional);

        // Execute the query
        if ($stmt->execute()) {
            echo "Booking Confirmed!";
        } else {
            echo "Booking failed. Please try again.";
        }
    } catch (PDOException $e) {
        // Display any errors
        echo "Error: " . $e->getMessage();
    }
}
?>
