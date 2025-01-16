<?php
class Data {
    private $pdo;
    private $DbName = 'youdemy';
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';

    public function __construct($DbName = null, $host = null, $user = null, $pass = null) {
        $this->DbName = $DbName ?? $this->DbName;
        $this->host = $host ?? $this->host;
        $this->user = $user ?? $this->user;
        $this->pass = $pass ?? $this->pass;
        $this->Connection();
    }

    public function Connection() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->DbName}";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>