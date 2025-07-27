<?php 
require_once __DIR__ . '/../config/database.php';

class User {

    private $db;

    public function __construct() {

        // Get the database connection instance
        $this->db = Database::getInstance()->getConnection();
    }

    public function getById($id){     

        // Method to get user by ID
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function getByEmail($email) {

        // Method to get user by email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to create a new user
    public function createUser($email, $password) {

        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        $result = $stmt->execute([$email, $hashedPassword]);
        if ($result) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

}