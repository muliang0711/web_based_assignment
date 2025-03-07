<?php
include_once '../../../db_connection.php';

class productDb{
    
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllProducts(){
        $stmt = $this->pdo->query("SELECT * FROM product");
        return $stmt->fetchAll();
    }
}
?>