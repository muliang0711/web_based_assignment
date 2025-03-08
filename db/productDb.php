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

    public function getProduct($filters){
        $sql = "SELECT * FROM WHERE 1=1 "; // base sql 
        $params = [] ; // be a empty set to append value if have 
        
        // condition validate : 
        // if $filters([value]) than append into baseSql , params

        // 1. productID :
        if($filters(['productId'])){
            $sql .= "AND productID = ?";
            $params[] = $filters['productId'];
        }
        // 2. productName 
        if($filters(['productName'])){
            $sql .= "AND productName = ?";
            $params[] = $filters['productName'];
        }
        // 3. seriesID
        if($filters(['seriesId'])){
            $sql .= "AND seriesID = ? ";
            $params[] = $filters['sericesId'];
        }
        // 4. price 
        if($filters(['$priceMin']) && $filters(['priceMax'])){
            $sql .= "AND price BETWEEN ? AND ?" ;
            $params[] = $filters(['priceMin']);
            $params[] = $filters(['priceMax']);
        }
        // ready to start : 
        $stmt =  $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
    // frontend guideline : 
    // the frontend should get the user input value and save as object in filters array
    //  
}

?>