<?php
require_once 'class_database_connexion.php';

class User {
    public $Last_name;  
    public $First_name;
    public $email;
    public $password;
    public $role;
    public $avatar_path;
    public $bio;
    public $status;
    private $pdo;

    public function __construct($Last_name, $First_name, $email, $password, $role, $avatar_path = 'Uploads/default_avatar.jpg', $bio = '', $status = 'active') {
        $this->Last_name = $Last_name;
        $this->First_name = $First_name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->avatar_path = $avatar_path;
        $this->bio = $bio;
        $this->status = $status;

        $this->pdo = new Data(); 
        $this->pdo->Connection(); 
    }

    public function hashPassword() { 
        return password_hash($this->password, PASSWORD_DEFAULT);
    }
  
    public function SetUser() {
        $password_hash = $this->hashPassword(); 
        $query = "INSERT INTO users (Last_name, First_name, email, password, role, avatar_path, status) 
                  VALUES (:Last_name, :First_name, :email, :password, :role, :avatar_path, :status)";
        try {
            $stmt = $this->pdo->getConnection()->prepare($query);
    
            $stmt->bindParam(':Last_name', $this->Last_name);
            $stmt->bindParam(':First_name', $this->First_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':role', $this->role);
            $stmt->bindParam(':avatar_path', $this->avatar_path);
            $stmt->bindParam(':status', $this->status);
    
            if ($stmt->execute()) {
                echo "User registered successfully!";
                return true; 
            } else {
                echo "User registration failed.";
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
            return false; 
        }
    }

    public static function login($email, $password) {
        $pdo = new Data();
        $pdo->Connection();
        $connection = $pdo->getConnection();

        $query = "SELECT * FROM users WHERE email = :email";
        
        try {
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user['password'])) {
                    $_SESSION['client'] = [
                        'id' => $user['id'],
                        'role' => $user['role']
                    ];

                    echo "Login successful!";
                    if ($user['role'] == 'admin') {
                        header('location:../../ADMIN/Frontend/dhashebored.php');
                    } elseif ($user['role'] == 'teacher' && $user['is_approved'] == 'approved') {
                        header('location:../../professor/Frontend/teacher.php');
                    } elseif ($user['role'] == 'student') {
                        header('location:../../index.php');
                    } else {
                        echo "Invalid user role.";
                        return false;
                    }
                } else {
                    echo "Invalid email or password.";
                    return false;
                }
            } else {
                echo "Invalid email or password.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        header('location:../../../Login/frontend/singin.php');
    }
    public function getProfile($userId) {
        $query = "SELECT * FROM users WHERE id = :userId";
        try {
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                return $user;
            } else {
                return null; // Return null if user not found
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    
    public function get_All_users() {
        $query = "SELECT * FROM users";
        try {
            $stmt = $this->pdo->getConnection()->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?>