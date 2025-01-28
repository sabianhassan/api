<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sacco');
define('DB_USER', 'root');
define('DB_PASSWORD', 'saby2030');

function connectDatabase() {
    try {
        // Set up the DSN for the database connection
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        
        // Create a new PDO instance
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        
        // Set PDO to throw exceptions for errors
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Return the PDO connection
        return $pdo;
    } catch (PDOException $e) {
        // Notify the user if the connection fails
        die("Database connection failed: " . $e->getMessage());
    }
}

// Example usage
$pdo = connectDatabase();
?>
