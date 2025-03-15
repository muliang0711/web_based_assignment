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
        $sql = "SELECT 
            p.productID, 
            p.productName, 
            p.price, 
            p.seriesID, 
            s.seriesName, 
            ps.sizeID, 
            ps.quantity AS total_stock 
            FROM product p
            JOIN productsize ps ON p.productID = ps.productID
            JOIN series s ON p.seriesID = s.seriesID
            ORDER BY p.productID, ps.sizeID;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function filterProduct($filters) {
        $sql = "SELECT 
                    p.productID, 
                    p.productName, 
                    p.price, 
                    p.seriesID, 
                    s.seriesName, 
                    ps.sizeID, 
                    ps.quantity AS stock,
                    SUM(ps.quantity) OVER (PARTITION BY p.productID) AS total_stock
                FROM product p
                JOIN productsize ps ON p.productID = ps.productID
                JOIN series s ON p.seriesID = s.seriesID
                WHERE 1=1"; 
    
        $params = [];
        $filterBySize = false;
        $filterByNameOnly = !empty($filters['productName']) && empty($filters['sizeID']);
    
        // Product Name Filter
        if (!empty($filters['productName'])) {
            $sql .= " AND p.productName LIKE ?";
            $params[] = "%" . $filters['productName'] . "%";
        }
    
        // Series Filter
        if (!empty($filters['seriesID'])) {
            $sql .= " AND p.seriesID = ?";
            $params[] = $filters['seriesID'];
        }
    
        // Price Filters
        if (!empty($filters['priceMin'])) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['priceMin']; 
        }
        if (!empty($filters['priceMax'])) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['priceMax']; 
        }
    
        // Product Size Filter
        if (!empty($filters['sizeID'])) {
            $sql .= " AND ps.sizeID = ?";
            $params[] = $filters['sizeID'];
            $filterBySize = true;
        }
    
        // Ensure the correct grouping when searching by name only (returns all sizes)
        if ($filterByNameOnly) {
            $sql .= " GROUP BY p.productID, ps.sizeID";
        }
    
        $sql .= " ORDER BY p.productID, ps.sizeID";
    
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
            return ["success" => true , "message" => "Add successful"];
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
                // if not existing than insert data into product first :
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
        $oldSizeID = $productInformation['oldSizeID'];

        try {

            // start transaction since there have multiple table insert;

            $this->pdo->beginTransaction(); 

            // update series table first : 

            $this->updateSeries($seriesName ,  $seriesID);

            //update product table : 

            $this->updateProduct( $productName , $price , $seriesID , $productID  );

            // update productsize :

            $this->updateProductSize($sizeID , $quantity ,  $productID , $oldSizeID );

            // commit when done : 

            $this->pdo->commit();

            // return message when sucess : 
            return ["success" => true , "message" => "update successful"];

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

    private function updateProduct($productName , $price , $seriesID , $productID  ){
        try{
            $sql = "UPDATE product set productName = ? , price = ? , seriesID = ? 
                    WHERE productID = ? " ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName , $price , $seriesID , $productID]);

        }catch(Exception $e){
            throw new Exception("Error insert into product : " . $e->getMessage());
        }
    }

    private function updateProductSize($sizeID, $quantity, $productID, $oldSizeID) {
        try {
            // Step 1: Delete the old entry first
            $deleteStmt = $this->pdo->prepare("DELETE FROM productsize WHERE productID = ? AND sizeID = ?");
            $deleteStmt->execute([$productID, $oldSizeID]);
    
            // Step 2: Check if the new (productID, sizeID) already exists
            $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM productsize WHERE productID = ? AND sizeID = ?");
            $checkStmt->execute([$productID, $sizeID]);
            $exists = $checkStmt->fetchColumn();
    
            if ($exists > 0) {
                throw new Exception("Error: The combination of productID and sizeID already exists.");
            }
    
            // Step 3: Insert new data
            $insertStmt = $this->pdo->prepare("INSERT INTO productsize (productID, sizeID, quantity) VALUES (?, ?, ?)");
            $insertStmt->execute([$productID, $sizeID, $quantity]);
    
        } catch (Exception $e) {
            throw new Exception("Error updating productSize: " . $e->getMessage());
        }
    }
    
    

    public function deleteProduct($productInformation) {
        try {
            // fetch data :
            $productID = $productInformation['productId'];
            $sizeID = $productInformation['sizeId'];
            // Step 1: Check if product and size exist
            $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM productsize WHERE productID = ? AND sizeID = ?");
            $checkStmt->execute([$productID, $sizeID]);
            $exists = $checkStmt->fetchColumn();
    
            if ($exists == 0) {
                return "Error: Product with this size does not exist.";
            }
    
            // Step 2: Delete the specific product-size combination
            $deleteSizeStmt = $this->pdo->prepare("DELETE FROM productsize WHERE productID = ? AND sizeID = ?");
            $deleteSizeStmt->execute([$productID, $sizeID]);
    
            // Step 3: Check if product has any remaining sizes
            $remainingStmt = $this->pdo->prepare("SELECT COUNT(*) FROM productsize WHERE productID = ?");
            $remainingStmt->execute([$productID]);
            $remainingSizes = $remainingStmt->fetchColumn();
    
            // Step 4: If no sizes remain, delete the product itself
            if ($remainingSizes == 0) {
                $deleteProductStmt = $this->pdo->prepare("DELETE FROM product WHERE productID = ?");
                $deleteProductStmt->execute([$productID]);
                return ["success" => true , "message" => "delete successful"];
            }
    
            return ["success" => true , "message" => "delete successful"];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
    
}


// future update : using try catch to handle the error ; show user with understanding error not directly system error 
// future uipdate : lets program insert into series table first after that we make execute the funciton reduce cost 
?>