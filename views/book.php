<?php
session_start(); // Start the session so we can access $_SESSION['user_id']

require_once __DIR__ . '/../classes/Database.php'; // Adjust path as needed

$pdo = connectDatabase(); // Connect to your MySQL database via PDO

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If you have a user login system, ensure $_SESSION['user_id'] is set.
    // For testing, fallback to 1 if it's not set, but make sure user with userid=1 exists in `users`.
    $user_id    = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

    // Retrieve other booking details from POST
    $room       = $_POST["room"]       ?? '';
    $package    = $_POST["package"]    ?? '';
    $meal       = $_POST["meal"]       ?? '';
    $additional = $_POST["additional"] ?? '';

    try {
        // (Optional) Verify that user_id actually exists in the `users` table.
        // This ensures we don't violate the foreign key constraint.
        $checkUser = $pdo->prepare("SELECT userid FROM users WHERE userid = :user_id");
        $checkUser->execute([':user_id' => $user_id]);
        if ($checkUser->rowCount() == 0) {
            die("Error: User with userid=$user_id does not exist. Booking failed.");
        }

        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO bookings (user_id, room, package, meal, additional) 
                VALUES (:user_id, :room, :package, :meal, :additional)";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':user_id',    $user_id,    PDO::PARAM_INT);
        $stmt->bindParam(':room',       $room,       PDO::PARAM_STR);
        $stmt->bindParam(':package',    $package,    PDO::PARAM_STR);
        $stmt->bindParam(':meal',       $meal,       PDO::PARAM_STR);
        $stmt->bindParam(':additional', $additional, PDO::PARAM_STR);

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
