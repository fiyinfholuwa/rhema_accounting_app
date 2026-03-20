<?php
class Auth {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function login($email, $password) {
        // Simple authentication (you can add database check later)
        if($email == 'admin@rhema.com' && $password == 'admin123') {
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = 'Admin User';
            $_SESSION['login_time'] = time();
            return true;
        }
        return false;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }
    
    public function logout() {
        session_destroy();
        return true;
    }
    
    public function checkAuth() {
        if (!$this->isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized', 'redirect' => true]);
            exit;
        }
    }
}
?>