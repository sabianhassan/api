<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'assignment_db');
define('DB_USER', 'root'); // Use your MySQL username
define('DB_PASSWORD', ''); // Use your MySQL password

function connectDatabase() {
    try {
        // Connect to MySQL without specifying a database
        $dsn = "mysql:host=" . DB_HOST;
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the database exists
        $result = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'");
        if ($result->rowCount() == 0) {
            // If the database doesn't exist, create it
            $pdo->exec("CREATE DATABASE " . DB_NAME);
            echo "Database " . DB_NAME . " created successfully.<br>";
        } else {
            echo "Database " . DB_NAME . " exists.<br>";
        }

        // Now connect to the actual database
        $pdo->exec("USE " . DB_NAME);

        // Check if the 'users' table exists, create it if it doesn't
        $result = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($result->rowCount() == 0) {
            $sql = "CREATE TABLE users (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        email VARCHAR(100) NOT NULL UNIQUE,
                        password VARCHAR(255) NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";
            $pdo->exec($sql);
            echo "Table 'users' created successfully.<br>";
        } else {
            echo "Table 'users' exists.<br>";
        }

        // Check if the 'otp' table exists, create it if it doesn't
        $result = $pdo->query("SHOW TABLES LIKE 'otp'");
        if ($result->rowCount() == 0) {
            $sql = "CREATE TABLE otp (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        email VARCHAR(100) NOT NULL,
                        otp INT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";
            $pdo->exec($sql);
            echo "Table 'otp' created successfully.<br>";
        } else {
            echo "Table 'otp' exists.<br>";
        }

        // Return the PDO connection to use in further queries
        return $pdo;

    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
?>
