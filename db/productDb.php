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
        
        // baseSql : 
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
    
    public function addProductImage($porductID , $imagePath , $type){
        try{
            $sql = "INSERT INTO product_images(productID , image_path ,  image_type ) VALUES (? , ? , ?)";
            $result = $this->pdo->prepare($sql);
            $result->execute([$porductID , $imagePath , $type]); 
    
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
            $this->insertSeries($seriesID, $seriesName);

            // 3. Insert into product table
            $this->insertProduct($productID, $productName, $price, $seriesID,$quantity,$sizeID,$playerInfo,$introduction);
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
        $seriesID = $productInformation['seriesId'];
        $sizeID = $productInformation['sizeId'];
        $price = $productInformation['price'];
        $quantity = $productInformation['stock']; 
        $oldSizeID = $productInformation['oldSizeID'];
        $introduction = $productInformation['introduction'];
        $playerInfo = $productInformation['playerInfo'];

        try {

            // start transaction since there have multiple table insert;

            // $this->pdo->beginTransaction(); 

            // update series table first : 

            // $this->updateSeries($seriesName ,  $seriesID ,  $oldSeriesID );

            //update product table : 

            $this->updateProduct( $productName , $price , $productID , $introduction , $playerInfo);

            // update productsize :

            $this->updateProductSize($sizeID , $quantity ,  $productID );

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
    
            // Step 1: Check if the product-size combination exists
            $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM productsize WHERE productID = ? AND sizeID = ?");
            $checkStmt->execute([$productID, $sizeID]);
            $exists = $checkStmt->fetchColumn();
    
            if ($exists == 0) {
                return [
                    "success" => false,
                    "message" => "This product-size combination does not exist."
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
                // Delete from product table
                $deleteProductStmt = $this->pdo->prepare("DELETE FROM product WHERE productID = ?");
                $deleteProductStmt->execute([$productID]);
    
                // Optionally: also delete associated images
                $deleteImagesStmt = $this->pdo->prepare("DELETE FROM product_images WHERE productID = ?");
                $deleteImagesStmt->execute([$productID]);
    
                return [
                    "success" => true,
                    "message" => "Product '$productID' and all associated data deleted successfully (last size)."
                ];
            }
    
            return [
                "success" => true,
                "message" => "Size '$sizeID' for product '$productID' deleted successfully."
            ];
    
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Database error: " . $e->getMessage()
            ];
        }
    }
    
    public function totalsellTrack($filterData){
        // function : total how many order has been make  : 

        // furure upadte : hoe many profit we make 
        // future update : lets user can choise a timeline // done 
        // future update : lest user can choise to see data based on the status // done  
        // future update : filter out the sizeID // ing

        // Step 1 : fetch orderitem with status Deliverd first : --> clean data :
        // select oi.orderID , oi.productID ,  oi.quantity , oi.subtotal from orderitems where oi.orderid = o.orderid ;     
        
        try {
            // Fetch filter data (assuming frontend always sends values)
            $startDate = $filterData['startDate'];
            $endDate = $filterData['endDate'];
            $status = $filterData['status'] ?? null;
    
            // Base SQL Query
            $baseSql = "SELECT 
                            oi.orderId, 
                            SUM(oi.subtotal) AS total_revenue, 
                            SUM(oi.quantity) AS total_quantity
                        FROM order_items oi 
                        JOIN orders o ON oi.orderId = o.orderId 
                        WHERE o.orderDate BETWEEN ? AND ?";
    
            // Parameters for execution
            $params = [$startDate, $endDate];
    
            // Add status filter
            if ($status) {
                $baseSql .= " AND o.status = ?";
                $params[] = $status;
            }
    
            // Grouping by productId
            $baseSql .= " GROUP BY oi.productId ORDER BY total_quantity DESC";
    
            // Execute query
            $stmt = $this->pdo->prepare($baseSql);
            $stmt->execute($params);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Check if data exists
            if (!$data) {
                return ["success" => false, "message" => "No sales data found"];
            }
    
            return ["success" => true, "data" => $data];
    
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public function productSellTrack($filterData){
        // function : show how many that product have been sell

        // modify : 
        // show productid , sizeid , seriesid (product , productsize) 
        // show total_sales_quantity based (productid and gripId) quantity on the orderitem 
        // show total_revune based on SUM the same subtotal with same productID and gripsize 
        try {
            // Fetch filters
            $startDate = $filterData['startDate'];
            $endDate = $filterData['endDate'];
    
            // SQL Query
            $sql = "SELECT 
                        p.productID,
                        p.seriesID,
                        ps.sizeID,
                        SUM(oi.quantity) AS total_sales,
                        SUM(oi.subtotal) AS total_revenue
                    FROM product p
                    JOIN productsize ps ON p.productID = ps.productID
                    JOIN order_items oi ON ps.productID = oi.productId AND ps.sizeID = oi.gripSize
                    JOIN orders o ON oi.orderId = o.orderId
                    WHERE o.orderDate BETWEEN ? AND ?
                    GROUP BY p.productID, p.seriesID, ps.sizeID
                    ORDER BY total_sales DESC";
    
            // Execute query
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
            $result = $stmt->fetchAll();
    
            // Check if data exists
            if (!$result) {
                return ["success" => false, "message" => "No sales data found."];
            }
    
            return ["success" => true, "data" => $result];
    
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public function autoCalculateProductStock($orderProduct){
        // e  verytime create a order record will auto run this function : 
        try{

            // 1. fetch data from the array (orderProduct) : 
            $productID = $orderProduct['productID'] ; 
            $quantity = $orderProduct['quantity'] ; 
            $sizeID = $orderProduct['sizeID'];

            // 2. auto - the quantity in the productsize based on the productID and quantity : 
            $sql = "UPDATE productSize 
                    SET quantity = quantity - ? 
                    WHERE productID = ?  AND sizeID = ? ";
            
            // ready the params : 
            $params = [];
            $params = [$quantity , $productID , $sizeID] ; 

            // execuet :
            $result = $this->pdo->prepare($sql);
            $result->execute($params);

            // success : 
            return ["success" => true, "message" => "Stock updated successfully."];

        }catch(Exception $e){

            // false 
            return ["success" => false, "error" => $e->getMessage()];
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
    


    
//==================================== ALL Private function will be here : 

    // =============================== Support Update Function ===================================================================

    /*private function updateSeries($seriesName , $seriesID ,  $oldSeriesID ){
        try{
            // Check if the seriesID exists before updating
            $sqlCheck = "SELECT COUNT(*) FROM series WHERE seriesID = ?";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->execute([$oldSeriesID]);
            $exists = $stmtCheck->fetchColumn();
    
            if (!$exists) {
                throw new Exception("seriesID $oldSeriesID does not exist in series table.");
            }
    
            // Only update seriesName, do not change seriesID
            $sql = "UPDATE series SET seriesName = ? ,  seriesID = ?  WHERE seriesID = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$seriesName, $seriesID , $oldSeriesID]);
    
        }catch(Exception $e){
            throw new Exception("Error updating series: " . $e->getMessage());
      }    
    } // can not change foreign key due to mysql rule */ 

    private function updateProduct($productName , $price , $productID , $introduction , $playerInfo){
        try{
            $sql = "UPDATE product set productName = ? , price = ?  , introduction = ? , playerINfo = ?  
                    WHERE productID = ? " ;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productName , $price , $productID , $introduction , $playerInfo]);

        }catch(Exception $e){
            throw new Exception("Error insert into product : " . $e->getMessage());
        }
    }

    private function updateProductSize($sizeID, $quantity, $productID ) {
        try {
            $sql = "UPDATE productsize SET quantity = ? WHERE productID = ? AND sizeID = ? ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$quantity , $productID , $sizeID ,]);
    
        } catch (Exception $e) {
            throw new Exception("Error updating productSize: " . $e->getMessage());
        }
    } 

    //================================= Support Insert Function =================================================================

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

    private function insertProduct($productID, $productName, $price, $seriesID,$quantity,$sizeID ,$introduction , $playerInfo) {
        try {
            // product exis already : than skip this phase 
            $checkSql = "SELECT productID FROM product WHERE productID = ? LIMIT 1";
            $check_stmt = $this->pdo->prepare($checkSql);
            $check_stmt->execute([$productID]);

            if(!$check_stmt->fetch()){
                // if not existing than insert data into product first :
                $sql = "INSERT INTO product (productID, productName, price, seriesID , introduction , playerInfo) VALUES (?, ?, ?, ? , ? , ? )";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$productID, $productName, $price, $seriesID , $introduction , $playerInfo]);

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

    private function deleteImage($productID) {
        try{
            $stmt = $this->pdo->prepare("SELECT image_path FROM product_images WHERE productID = ?");
            $stmt->execute([$productID]);
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // 2. Delete image files from the uploads folder
            $uploadDir = realpath( __DIR__ . '/../File');
            foreach ($images as $image) {
                $filePath = $uploadDir . '/'. $image['image_path'];
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