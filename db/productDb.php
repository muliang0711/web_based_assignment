<?php
 include_once __DIR__ . '/../db_connection.php';

// planing : I want these file only can control product crud 

class productDb{

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    public function commitTransaction() {
        $this->pdo->commit();
    }

    public function rollbackTransaction() {
        $this->pdo->rollBack();
    }

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
            ps.status,
            ps.quantity AS total_stock 
            FROM product p
            JOIN productsize ps ON p.productID = ps.productID
            JOIN series s ON p.seriesID = s.seriesID
            ORDER BY p.productID, ps.sizeID;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSeriesID(){
        $sql = "SELECT seriesID FROM series ";
        $stmt = $this->pdo->query($sql);
        $seriesIdList = $stmt->fetchAll();
        return  $seriesIdList; 
    }

    public function getProductID(){
        $sql = "SELECT productID FROM product ";
        $stmt = $this->pdo->query($sql);
        $productIDList = $stmt->fetchAll();
        return  $productIDList; 
    }

    public function filterProduct($filters) {
        
        // baseSql : 
        $sql = "SELECT 
                    p.productID, 
                    p.productName, 
                    p.price, 
                    p.seriesID, 
                    s.seriesName, 
                    ps.sizeID, 
                    p.introduction,
                    p.playerInfo,
                    ps.status,
                    ps.quantity AS stock,
                    SUM(ps.quantity) OVER (PARTITION BY p.productID) AS total_stock
                FROM product p
                LEFT JOIN productsize ps ON p.productID = ps.productID
                LEFT JOIN series s ON p.seriesID = s.seriesID

                WHERE 1=1"; 
    
        $params = [];
    
        // Product id Filter
        if (!empty($filters['productID'])) {
            $sql .= " AND p.productID =  ?";
            $params[] =   $filters['productID'] ;
        }
    
        // Series Filter
        if (!empty($filters['seriesID'])) {
            $sql .= " AND p.seriesID = ?";
            $params[] = $filters['seriesID'];
        }
    
        if (isset($filters['priceMin'])) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['priceMin'];
        }
        
        if (isset($filters['priceMax'])) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['priceMax'];
        }
        
    
        // Product Size Filter
        if (!empty($filters['sizeID'])) {
            $sql .= " AND ps.sizeID = ?";
            $params[] = $filters['sizeID'];
        }


        
        $sql .= " ORDER BY p.productID, ps.sizeID";
        
        //echo "<pre>SQL: $sql</pre>";
        // echo "<pre>Params: " . print_r($params, true) . "</pre>";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $s = $stmt->fetchAll();

    
        //echo "<pre>";
        //print_r($s);
        //echo "</pre>";

        return $s ; 
    }
    
    public function addProductImage($productID , $imagePath , $type){
        try{
            $sql = "INSERT INTO product_images(productID , image_path ,  image_type ) VALUES (? , ? , ?)";
            $result = $this->pdo->prepare($sql);
            $result->execute([$productID , $imagePath , $type]); 
    
        }catch(Exception $e){

            throw new Exception("Eroor insert into product_image" . $e->getMessage());

        }
       

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
            // $this->pdo->beginTransaction();
            // 1.1 fetch data : 
            $productID = $productInformation['productId'];
            $productName = $productInformation['productName'];
            $seriesID = $productInformation['seriesId'];
            $sizeID = $productInformation['sizeId'];
            $seriesName = $productInformation['seriesName'];
            $price = $productInformation['price'];
            $quantity = $productInformation['stock'];
            $introduction = $productInformation['introduction'];
            $playerInfo = $productInformation['playerInfo'];
            
            // 2. insert data into table series : 
            // 2.1 validate does the series already existing or not 

            // 2. Insert into series table
           // Insert Series (if not exists)
            $checkSql = "SELECT seriesName FROM series WHERE seriesName = ? AND seriesID = ? LIMIT 1";
            $check_stmt = $this->pdo->prepare($checkSql);
            $check_stmt->execute([$seriesName, $seriesID]);
            if (!$check_stmt->fetch()) {
                $sql = "INSERT INTO series (seriesID, seriesName) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$seriesID, $seriesName]);
            }

            // Insert Product (if not exists)
            $checkSql = "SELECT productID FROM product WHERE productID = ? LIMIT 1";
            $check_stmt = $this->pdo->prepare($checkSql);
            $check_stmt->execute([$productID]);

            if (!$check_stmt->fetch()) {
                $sql = "INSERT INTO product (productID, productName, price, seriesID, introduction, playerInfo)
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$productID, $productName, $price, $seriesID, $introduction, $playerInfo]);
            }

            // Insert or Update Product Size
            $sql = "INSERT INTO productsize (productID, sizeID, quantity) 
                    VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productID, $sizeID, $quantity]);

            // inside this phase already call insertProductSize function

            // 4. Commit transaction
            // $this->pdo->commit();

            // return secess msg 
            return ["success" => true , "message" => "Add successful"];
        }catch(Exception $e){
            // Rollback transaction if any error occurs
            // $this->pdo->rollBack();
            // Return an error message
            return ["success" => false, "error" => $e->getMessage()];
                
        }           
                                                                      
    }

    public function updateProducts($productInformation){
        // fetch data 
        $productID = $productInformation['productId'];
        $productName = $productInformation['productName'];
        $sizeID = $productInformation['sizeId'];
        $price = $productInformation['price'];
        $quantity = $productInformation['stock']; 
        $introduction = $productInformation['introduction'];
        $playerInfo = $productInformation['playerInfo'];

        try {

            // start transaction since there have multiple table insert;

            // $this->pdo->beginTransaction(); 

            // update series table first : 

            // $this->updateSeries($seriesName ,  $seriesID ,  $oldSeriesID );

            //update product table : 

            // Update product table
            $sql = "UPDATE product SET productName = ?, price = ?, introduction = ?, playerInfo = ?  
            WHERE productID = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName , $price , $introduction , $playerInfo , $productID]);

            // Update productSize
            $sql = "UPDATE productsize SET quantity = ? WHERE productID = ? AND sizeID = ? ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$quantity , $productID , $sizeID]);


            // delete old IMAGE for all :

            $this->deleteImage($productID); 

            // commit when done : 

            // $this->pdo->commit();

            // return message when sucess : 
            
            // return ["success" => true , "message" => "update successful"];

        }catch(Exception $e){

            throw new Exception("error when delete image : " . $e->getMessage());

            // $this->pdo->rollBack();

            // return when error 

            // return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public function deleteProduct($productInformation) {
        try {
            $productID = $productInformation['productId'];
            $sizeID = $productInformation['sizeId'];
    
            // Step 0: Check if this product-size is part of any order (not yet delivered)
            $orderCheckStmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM order_items oi
                JOIN orders o ON oi.orderId = o.orderId
                WHERE oi.productId = ? AND oi.gripSize = ? AND o.status != 'Delivered'
            ");
            $orderCheckStmt->execute([$productID, $sizeID]);
            $activeOrders = $orderCheckStmt->fetchColumn();
    
            if ($activeOrders > 0) {
                return [
                    "success" => false,
                    "message" => "Cannot delete. This product (ID: $productID, Size: $sizeID) is used in an active order."
                ];
            }
    

    
            // Step 2: Delete this product-size entry
            $deleteSizeStmt = $this->pdo->prepare("DELETE FROM productsize WHERE productID = ? AND sizeID = ?");
            $deleteSizeStmt->execute([$productID, $sizeID]);
    
            // Step 3: Check if the product has any remaining sizes
            $remainingSizesStmt = $this->pdo->prepare("SELECT COUNT(*) FROM productsize WHERE productID = ?");
            $remainingSizesStmt->execute([$productID]);
            $remainingSizes = $remainingSizesStmt->fetchColumn();
    
            // Step 4: If no more sizes left, delete the product record
            if ($remainingSizes == 0) {

                
                $this->deleteImage($productID);
                
                // Delete from product table
                $deleteProductStmt = $this->pdo->prepare("DELETE FROM product WHERE productID = ?");
                $deleteProductStmt->execute([$productID]);
                return [
                    "success" => true,
                    "message" => "Product '$productID' and all associated data deleted successfully (last size)."
                ];
            }
    
            return [
                "success" => true,
                "message" => "Size '$sizeID' for product '$productID' deleted successfully."
            ];
    
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }
    
    public function getProductByIDAndSize($productID, $sizeID) {
        $sql = "SELECT 
                    p.productID,
                    p.productName,
                    p.price,
                    p.introduction,
                    p.playerInfo,
                    p.seriesID,
                    s.seriesName,
                    ps.sizeID,
                    ps.quantity AS total_stock,
                    GROUP_CONCAT(CASE WHEN pi.image_type = 'product' THEN pi.image_path END) AS product_images,
                    GROUP_CONCAT(CASE WHEN pi.image_type = 'player' THEN pi.image_path END) AS player_images
                FROM product p
                JOIN productsize ps ON p.productID = ps.productID
                JOIN series s ON p.seriesID = s.seriesID
                LEFT JOIN product_images pi ON p.productID = pi.productID
                WHERE p.productID = :productID AND ps.sizeID = :sizeID
                GROUP BY p.productID, ps.sizeID";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':productID' => $productID,
            ':sizeID' => $sizeID
        ]);
    
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($product) {
            // Convert image paths into arrays
            $product['product_images'] = array_filter(explode(',', $product['product_images']));
            $product['player_images'] = array_filter(explode(',', $product['player_images']));
        }
    
        return $product;
    }
    
    public function search($searchText){
        // 1. search from the product table :
        // 2. search from the size table :
        // 3. search from the series table : 

        $searchText ='%' . $searchText . '%';
        
        $sql = "SELECT 
                p.productID, 
                p.productName, 
                p.price, 
                p.seriesID, 
                s.seriesName, 
                ps.sizeID, 
                ps.status,
                ps.quantity AS total_stock 
                FROM product p
                JOIN series s ON p.seriesID = s.seriesID 
                JOIN productsize ps ON p.productID = ps.productID 
                WHERE p.productName LIKE ? OR s.seriesName LIKE  ? OR s.seriesID LIKE ? 
            "; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchText , $searchText , $searchText]);

        

        return $stmt->fetchAll();; 
    }

    public function updateProductStatus($productID, $sizeID, $status) {
        try {
            $sql = "UPDATE productsize SET status = ? WHERE productID = ? AND sizeID = ? ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$status, $productID, $sizeID]);

    
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    private function deleteImage($productID) {
        try{
            $stmt = $this->pdo->prepare("SELECT image_path FROM product_images WHERE productID = ?");
            $stmt->execute([$productID]);
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // 2. Delete image files from the uploads folder
            $uploadDir = __DIR__ . '/../File';


            foreach ($images as $image) {
                $filePath = $uploadDir . '/'. $image['image_path'];
                if (!file_exists($filePath)) {
                    error_log("NOT FOUND: $filePath");
                } else {
                    error_log("DELETING: $filePath");
                }
                
                if (file_exists($filePath)) {
                    unlink($filePath);  
                }
            }
        
            // 3. Delete image records from db
            $stmt = $this->pdo->prepare("DELETE FROM product_images WHERE productID = ?");
            $stmt->execute([$productID]);
        }
        catch(Exception $e){
            throw new Exception("error when delete image : " . $e->getMessage());
        }   
       
    }


    
//==================================================================================================================================
}


// future update : using try catch to handle the error ; show user with understanding error not directly system error 
// future uipdate : lets program insert into series table first after that we make execute the funciton reduce cost 
?>