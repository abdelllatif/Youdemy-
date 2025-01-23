<?php
require_once 'class_database_connexion.php';

class Tag {
    protected $id;
    protected $tag;
    protected $pdo;

    public function __construct($tag=null) {
        $data = new Data(); 
        $this->pdo = $data->getConnection();
        $this->tag = $tag;
    }

    public function set_tags($tag) {
        $this->tag = $tag;
        $query = 'INSERT INTO tags(name) VALUES(:tag)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':tag', $this->tag); 
            if ($stmt->execute()) {
            echo "Tags added successfully.";
        } else {
            echo "Error adding tags: " . implode(", ", $stmt->errorInfo());
        }
    }
    public function gettags() {
        $query = 'SELECT * FROM tags';
        $stmt = $this->pdo->prepare($query);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } else {
            echo "Error fetching categories: " . implode(", ", $stmt->errorInfo());
            return ; 
        }
    }
    public function deleteTag($tagId) {
        $pdo = new Data();
        $pdo->Connection();
        $query = "DELETE FROM tags WHERE id = :tagId";
        $stmt = $pdo->getConnection()->prepare($query);
        $stmt->bindParam(':tagId', $tagId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
