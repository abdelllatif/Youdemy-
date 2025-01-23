<?php
require_once 'class_database_connexion.php';

class categorie {
    protected $categorie;
    protected $pdo;

    public function __construct($categorie = null) {
        $data = new Data(); 
        $this->pdo = $data->getConnection();
        $this->categorie = $categorie;
    }

    public function set_categorie($categorie) {
        $this->categorie = $categorie; 

        $query = 'INSERT INTO categories(name) VALUES(:categorie)';
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindValue(':categorie', $this->categorie); 
        
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
