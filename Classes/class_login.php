<?php

class Authentication {
    private $pdo;
    private $user_id;
    private $username;
    
    public function __construct() {
        $this->pdo = new Data();
        
    }
    
    public function login($username, $password) {
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $stmt = $this->pdo->getConnection()->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $this->user_id = $user['id'];
            $this->username = $user['username'];
            
            return true;
        }
        
        return false;
    }
    
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = array();
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        session_destroy();
        
        $this->user_id = null;
        $this->username = null;
        
        return true;
    }
    
    public function isAuthenticated() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['user_id']);
    }
    
    public function getCurrentUser() {
        if (!$this->isAuthenticated()) {
            return null;
        }
        
        return [
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username']
        ];
    }
}
