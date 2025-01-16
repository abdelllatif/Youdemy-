
<?php
class Learning {
    public $id;
    public $playlist_id;
    public $learning;
    protected $pdo;
    public function __construct($id, $playlist_id, $learning) {
        $this->pdo = ;
        $this->id = $id;
        $this->playlist_id = $playlist_id;
        $this->learning = $learning;
    }
    public function set_learnings($learning) {
        $this->learning = $learning;

        $query = 'INSERT INTO learning(name) VALUES(:learning)';
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindValue(':learning', $this->learning); 
        
        if ($stmt->execute()) {
            echo "learnings added successfully.";
        } else {
            echo "Error adding learnings: " . implode(", ", $stmt->errorInfo());
        }
    }
}
