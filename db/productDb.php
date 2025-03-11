<?php
include_once __DIR__ . '/../db_connection.php';

class productDb{
    
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // 1. get all product  :
    public function getAllProducts(){
        // when using the pfo->query can not accpet variable ; it execute the sql directly ； 
        $stmt = $this->pdo->query("SELECT * FROM product");
        return $stmt->fetchAll();
    }
    // 2. get one product :
    // logic :
    // 1. we set a base sql sentences(it return everything) 
    // 2. when detetect specific filter value turn it we appned to the base sql 
        // 2.1  since the variable is not fixed we use array:params to save the value 

    public function filterProduct($filters) {
            $sql = "SELECT * FROM product WHERE 1=1"; 
            $params = [];
    
            if (!empty($filters['productName'])) {
                $sql .= " AND productName LIKE ?";
                $params[] = "%" . $filters['productName'] . "%";
            }
            if (!empty($filters['seriesID'])) {
                $sql .= " AND seriesID = ?";
                $params[] = $filters['seriesID'];
            }
            if (!empty($filters['priceMin'])) {
                $sql .= " AND price >= ?";
                $params[] = $filters['priceMin']; 
            }
            if (!empty($filters['priceMax'])) {
                $sql .= " AND price <= ?";
                $params[] = $filters['priceMax']; 
            }
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function addProduct($productInformation){

    }
}

?>