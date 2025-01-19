<?php
require_once 'class_database_connexion.php';

class categorie {
    protected $categorie;
    protected $pdo;

    public function __construct($categorie = null) {
        $data = new Data(); // Ensure the class name is capitalized if it is defined that way
        $this->pdo = $data->getConnection();
        $this->categorie = $categorie;
    }

    public function set_categorie($categorie) {
        $this->categorie = $categorie; // Set the categorie property

        // Prepare the SQL query
        $query = 'INSERT INTO categories(name) VALUES(:categorie)';
        $stmt = $this->pdo->prepare($query);
        
        // Bind the parameter using bindValue instead of bind_param
        $stmt->bindValue(':categorie', $this->categorie); // Use bindValue for PDO
        
        // Execute the statement and handle the result
        if ($stmt->execute()) {
            echo "categories added successfully.";
        } else {
            echo "Error adding categories: " . implode(", ", $stmt->errorInfo());
        }
    }
    public function getCategories() {
        $query = 'SELECT * FROM categories';
        $stmt = $this->pdo->prepare($query);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } else {
            echo "Error fetching categories: " . implode(", ", $stmt->errorInfo());
            return ; 
        }
    }
  public  function deleteCategory($categoryId) {
        $pdo = new Data();
        $pdo->Connection();
        $query = "DELETE FROM categories WHERE id = :categoryId";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
