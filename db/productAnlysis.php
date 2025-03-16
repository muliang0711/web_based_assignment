<?php
include_once __DIR__ . "/../db_connection.php" ; 
// planing : I want this file can control functio related with anlysis product maybe include extract as json or csv 

class productAnlysis{

    private $pdo ;

    public function __construct($pdo){
        $this->pdo = $pdo ;
    }
    
    // bug need to be fixed : logic error 
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



}
?>