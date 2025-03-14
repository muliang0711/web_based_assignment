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
        $sql = "SELECT p.productID, p.productName, p.price, p.seriesID, ps.sizeID , s.seriesName , SUM(ps.quantity) AS total_stock
        FROM product p 
        JOIN productsize ps ON p.productID = ps.productID 
        JOIN series s ON p.seriesID = s.seriesID
        WHERE ps.quantity > 0
        GROUP BY p.productID, ps.sizeID";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function filterProduct($filters){
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
            return $stmt->fetchAll();
    }
    
    public function addProduct($productInformation){
        // since we already check data is correct in service side : 
        // now we just need to fecth data and turn into sql 
        // but since we have three table need to be fill in we need three sql 

        // since we need insert multiple data from one record we using beginTransaction()
        // with this it allow us track each insertion status if every insertion done than If all operations succeed, the transaction is committed (saved)
        // if one insertion is failed it rolled back 
        
        try{
            // 1 start Transaction : 
            $this->pdo->beginTransaction();
            // 1.1 fetch data : 
            $productID = $productInformation['productId'];
            $productName = $productInformation['productName'];
            $seriesID = $productInformation['seriesId'];
            $sizeID = $productInformation['sizeId'];
            $seriesName = $productInformation['seriesName'];
            $price = $productInformation['price'];
            $quantity = $productInformation['stock'];
            // 2. insert data into table series : 
            // 2.1 validate does the series already existing or not 

            // 2. Insert into series table
            $this->insertSeries($seriesID, $seriesName);

            // 3. Insert into product table
            $this->insertProduct($productID, $productName, $price, $seriesID,$quantity,$sizeID);
            // inside this phase already call insertProductSize function
  

            // 4. Commit transaction
            $this->pdo->commit();

            // return secess msg 
            return ["success" => true , "success" => "Add successful"];
        }catch(Exception $e){
            // Rollback transaction if any error occurs
            $this->pdo->rollBack();
            // Return an error message
            return ["success" => false, "error" => $e->getMessage()];
                
        }           
                                                                      
    }

    private function insertSeries($seriesID, $seriesName) {
        // Check if the series exists
        try{

            $checkSql = "SELECT seriesName FROM series WHERE seriesName = ? AND seriesID = ? LIMIT 1";
            $check_stmt = $this->pdo->prepare($checkSql);
            $check_stmt->execute([$seriesName, $seriesID]);

            // If not exists, insert it
            if (!$check_stmt->fetch()) {
                $sql = "INSERT INTO series (seriesID, seriesName) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$seriesID, $seriesName]);
            }

        }catch(Exception $e){

            error_log("Transaction failed: " . $e->getMessage());
            return false;
        }
    }

    private function insertProduct($productID, $productName, $price, $seriesID,$quantity,$sizeID) {
        try {
            // product exis already : than skip this phase 
            $checkSql = "SELECT productID FROM product WHERE productID = ? LIMIT 1";
            $check_stmt = $this->pdo->prepare($checkSql);
            $check_stmt->execute([$productID]);

            if(!$check_stmt->fetch()){
                $sql = "INSERT INTO product (productID, productName, price, seriesID) VALUES (?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$productID, $productName, $price, $seriesID]);

                $this->insertProductSize($productID, $sizeID, $quantity);
            }else{

                $this->insertProductSize($productID, $sizeID, $quantity);
            }
        } catch (Exception $e) {
            throw new Exception("Error inserting product: " . $e->getMessage());
        }
    }

    private function insertProductSize($productID, $sizeID, $quantity) {
        // at this phase the one product id can have two sizeID   
        try {
            // since we already check before so here we just need to insert 
            $sql = "INSERT INTO productsize (productID, sizeID, quantity) VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productID, $sizeID, $quantity]);

        } catch (Exception $e) {
            throw new Exception("Error inserting product size: " . $e->getMessage());
        }
    }

    public function updateProducts($productInformation){
        // fetch data 
        $productID = $productInformation['productId'];
        $productName = $productInformation['productName'];
        $seriesID = $productInformation['seriesId'];
        $seriesName = $productInformation['seriesName'];
        $sizeID = $productInformation['sizeId'];
        $price = $productInformation['price'];
        $quantity = $productInformation['stock']; 

        try {

            // start transaction since there have multiple table insert;

            $this->pdo->beginTransaction(); 

            // update series table first : 

            $this->updateSeries($seriesName ,  $seriesID);

            //update product table : 

            $this->updateProduct( $productName , $price , $seriesID , $productID  );

            // update productsize :

            $this->updateProductSize($sizeID , $quantity ,  $productID);

            // commit when done : 

            $this->pdo->commit();

            // return message when sucess : 
            return ["success" => true , "success" => "update successful"];

        }catch(Exception $e){

            $this->pdo->rollBack();

            // return when error 

            return ["success" => false, "error" => $e->getMessage()];
        }
    }


    private function updateSeries($seriesName , $seriesID ){

        try{
            $sql = "UPDATE series set seriesName = ? ,  seriesID = ? 
                    WHERE seriesID = ? " ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$seriesName ,  $seriesID , $seriesID ]);
        }catch(Exception $e){
            throw new Exception("Error insert into series: " . $e->getMessage());
        }

    }

    private function updateProduct($productName , $price , $seriesID , $productID ){
        try{
            $sql = "UPDATE product set productName = ? , price = ? , seriesID = ? 
                    WHERE productID = ? " ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName , $price , $seriesID , $productID]);

        }catch(Exception $e){
            throw new Exception("Error insert into product : " . $e->getMessage());
        }
    }

    private function updateProductSize($sizeID , $quantity ,  $productID ){

        try{
            $sql = "UPDATE productsize set sizeID = ? , quantity = ? 
                    WHERE productID = ? AND sizeID = ?" ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([ $sizeID , $quantity ,  $productID , $sizeID]);
        }catch(Exception $e){
            throw new Exception("Error insert into productSize : " . $e->getMessage());
        }
    }

}


// future update : using try catch to handle the error ; show user with understanding error not directly system error 
// future uipdate : lets program insert into series table first after that we make execute the funciton reduce cost 
?>