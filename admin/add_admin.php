<?php
require_once __DIR__ . '/../classes/Database.php';
var_dump(file_exists(__DIR__ . '/../classes/Database.php')); // Debugging step

// Get database connection
$pdo = connectDatabase(); // Call the function to establish connection

$username = "admin"; // Set your admin username
$password = password_hash("admin123", PASSWORD_DEFAULT); // Hash the password

// Prepare and execute the query
$stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
if ($stmt->execute([$username, $password])) {
    echo "Admin created successfully!";
} else {
    echo "Error creating admin.";
}
?>
