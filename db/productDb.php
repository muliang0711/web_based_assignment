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
            //stmt = $this->pdo->query("SELECT * FROM product");
            //return $stmt->fetchAll();
        $sql = "SELECT p.productID, p.productName, p.price, p.seriesID, SUM(ps.quantity) AS total_stock
        FROM product p
        JOIN productsize ps ON p.productID = ps.productID
        WHERE ps.quantity > 0
        GROUP BY p.productID, p.productName, p.price, p.seriesID";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();

    }

    public function filterProduct($filters) {
    // 2. get one product :
    // logic :
    // 1. we set a base sql sentences(it return everything) 
    // 2. when detetect specific filter value turn it we appned to the base sql 
        // 2.1  since the variable is not fixed we use array:params to save the value 
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
        // since we already check data is correct in service side : 
        // now we just need to fecth data and turn into sql 
        // but since we have three table need to be fill in we need three sql 

        // since we need insert multiple data from one record we using beginTransaction()
        // with this it allow us track each insertion status if every insertion done than If all operations succeed, the transaction is committed (saved)
        // if one insertion is failed it rolled back 
        
        
        // 1. fetch data : 

        // 2. insert data into table series : 

        // 3. insert data into table product size:
        
        // 4. insert data intn table product : 



        
    }
}

// future update : using try catch to handle the error ; show user with understanding error not directly system error 

?>