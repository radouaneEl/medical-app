<?php

class Database {

    // Static property to store the single instance (Singleton pattern)
    private static $instance = null;

    // Property to hold the PDO connection
    private $pdo;

    // Private constructor to prevent direct object creation

    private function __construct() {

        // Load database configuration
        $config = require __DIR__ . '/../config/database.php';

        try {
            // Create PDO connection using configuration values
            $this->pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['username'],
                $config['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Stop execution and show error if connection fails
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Static method to get the single Database instance (Singleton)
    public static function getInstance() {
        
        // If the instance doesn't exist, create it
        if (self::$instance === null) {
            self::$instance = new self();
        }
        // Return the single instance
        return self::$instance;
    }

    // Public method to get the PDO connection
    public function getConnection()
    {
        return $this->pdo;
    }

}

?>