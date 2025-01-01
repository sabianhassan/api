<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'assignment_db');
define('DB_USER', 'root'); // Use your MySQL username
define('DB_PASSWORD', ''); // Use your MySQL password

function connectDatabase() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
?>
