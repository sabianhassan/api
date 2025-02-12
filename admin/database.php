<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sacco');
define('DB_USER', 'root');
define('DB_PASSWORD', 'saby2030');
define('DB_PORT', '3309'); // Set port to 3309

function connectDatabase() {
    try {
        // Set up the DSN for the database connection, including the port
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT;
        
        // Create a new PDO instance
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        
        // Set PDO to throw exceptions for errors
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Test the connection by executing a query
        $pdo->query("SELECT 1"); // Basic query to test connection
        
        // Return the PDO connection
        return $pdo;
    } catch (PDOException $e) {
        // Notify the user if the connection fails
        die("Database connection failed: " . $e->getMessage());
    }
}

// Example usage to test the connection
//$pdo = connectDatabase();
?>
