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
        $query = "INSERT INTO users (Last_name, First_name, email, password, role, avatar_path, bio, status) 
                  VALUES (:Last_name, :First_name, :email, :password, :role, :avatar_path, :bio, :status)";
        try {
            $stmt = $this->pdo->getConnection()->prepare($query);
    
            $stmt->bindParam(':Last_name', $this->Last_name);
            $stmt->bindParam(':First_name', $this->First_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':role', $this->role);
            $stmt->bindParam(':avatar_path', $this->avatar_path);
            $stmt->bindParam(':bio', $this->bio);
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
                    session_start();
                    $_SESSION['client'] = [
                    'id'=>$user['id'],
                    'role'=>$user['role'],
                    'role'=>$user['role'],
                ];
                    echo "Login successful!";
                    if($user['role']=='admin'){
                    header('location:../../ADMIN/Frontend/dhashebored.php');
                    return ;
                    }
                    elseif($user['role']=='teacher'&& $user['is_approved']=1){
                    header('location:../../professor/Frontend/teacher.php');
                    return ;
                    }
                    elseif($user['role']=='student'){
                        header('location:../../index.php');
                        return ;
                        }
                        else {
                            echo "no student here.";
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
}
?>