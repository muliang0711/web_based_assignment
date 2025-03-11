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
            // productId 
            // sizeID 
            $productName = $productInformation['prductName'];
            $seriesID = $productInformation['seriesId'];
            $seriesName = $productInformation['seriesName'];
            $price = $productInformation['price'];
            $quantity = $productInformation['stock'];    
        // 2. insert data into table series : 
            // 2.1 validate does the series already existing or not 

            // 2.1.1  write a sql to check with select limit 1 : 
            $checkSql = "SELECT seriesName FROM series WHERE seriesName = ? AND seriesID = ? LIMIT 1";
            $check_series_stmt = $this->pdo->prepare($checkSql);
            $check_series_stmt->execute($seriesName , $seriesID);
            // already exist add one , not yet craete one ; 
            if($check_series_stmt->fetch()){
                echo "Data exists. Proceeding with product insertion.";
                // pass to next program
                // this table is to make a real and one entity 
                if (insertProduct($productID, $productName, $price, $seriesID)) {
                    echo "Product successfully inserted.";
                    insertProductSize($productID, $sizeID, $quantity);
                } else {
                    throw new Exception("Error inserting product.");
                }
            }else{
                echo "data does not exist";
                // 2.2 generate the sql and insert 
                $seriesSql = "INSERT INTO series (seriesID , seriesName) VALUES (? , ?)";
                $insert_series_stmt = $this->pdo->prepare($seriesSql);
                $insert_series_stmt->execute([$seriesID,$seriesName]);
                echo "Sucess insert record into series" ; 
                // done and call out next program : 
                if (insertProduct($productID, $productName, $price, $seriesID)) {
                    echo "Product successfully inserted.";
                    // If insert is successful, call insertProductSize function
                    insertProductSize($productID, $sizeID, $quantity);
                } else {
                    throw new Exception("Error inserting product.");
                }
            }

        // 3. insert data into table product : 
        function insertProduct($productID , $productName , $price , $seriesID){
            // 3.1 sql to insert the product 
            try {
                // Prepare the SQL statement
                $sql = "INSERT INTO product (productID, productName, price, seriesID) VALUES (?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                return true ; 
            } catch (Exception $e) {
                // Log or display the error message
                error_log("Error inserting product: " . $e->getMessage());
        
                return false; // Return false on failure
            }
        }
        // this table is to add up the entity (calculate the stock)
        // 4. insert data into table product size:
        // 4.1 we just need to this fucntion 
        function insertProductSize($productID , $sizeID , $quantity){   

        }
        

        }
    }
}

// future update : using try catch to handle the error ; show user with understanding error not directly system error 
// future uipdate : lets program insert into series table first after that we make execute the funciton reduce cost 
?>