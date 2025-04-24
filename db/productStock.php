<?php 
include_once __DIR__ . "/../db_connection.php";
require __DIR__ . "/../vendor/autoload.php"; // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CheckStock {
    private $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo; //
    }

    private function sendLowStockEmail($toEmail, $productName, $stock, $threshold) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'puihy-wm24@student.tarc.edu.my';
            $mail->Password = 'mqps lalr ujvo fbqx';  // App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('puihy-wm24@student.tarc.edu.my', 'Inventory Alert');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = "Low Stock Alert: $productName";
            $mail->Body = "
                <p><strong>Product:</strong> $productName</p>
                <p><strong>Current Stock:</strong> $stock</p>
                <p><strong>Threshold:</strong> $threshold</p>
                <p>Please restock soon!</p>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function sendEmail($toEmail, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            // 1. SMTP setup
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'puihy-wm24@student.tarc.edu.my'; 
            $mail->Password   = 'mqps lalr ujvo fbqx';             
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // 2. Email setup
            $mail->setFrom('puihy-wm24@student.tarc.edu.my', 'Inventory System');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = nl2br(htmlspecialchars($message)); 

            // 3. Send
            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
            return false;
        }
    }

    // 1. send sms ; 
    private function sendSMS(){
        return ; 
    }
    
    public function check_low_stock() {
        $sql = "SELECT * FROM productstock WHERE stock <= low_stock_threshold AND alert_sent = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $low_stock_products = $stmt->fetchAll(); 

        if (count($low_stock_products) === 0) {
            return;
        }

        foreach ($low_stock_products as $product) {

            $productID = $product->productID;
            $sizeID = $product->sizeID;
            $productName = $product->product_name?? "Product #$productID"; // fallback
            $stock = $product->stock;
            $threshold = $product->low_stock_threshold;

            $ownerEmail = 'puihy-wm24@student.tarc.edu.my'; 

            $emailSent = $this->sendLowStockEmail($ownerEmail, $productName, $stock, $threshold);

            if ($emailSent) {

                $updateSql = "UPDATE productstock SET alert_sent = 1 WHERE productID = ? AND sizeID = ?";
                $updateStmt = $this->pdo->prepare($updateSql);
                $updateStmt->execute([$productID, $sizeID]);

                echo "Alert sent for $productName (Stock: $stock)\n";
            } else {
                echo "Failed to send email for $productName\n";
            }
        }
    }

    public function get_low_stock_product(){

        $sql = "SELECT 
                    p.productID,
                    p.productName,
                    p.price,
                    p.seriesID,
                    s.seriesName,
                    ps.sizeID,
                    ps.stock,
                    ps.low_stock_threshold,
                    img.image_path 
                FROM 
                    productstock ps
                JOIN 
                    product p ON ps.productID = p.productID
                LEFT JOIN 
                    series s ON p.seriesID = s.seriesID
                LEFT JOIN 
                    product_images img ON p.productID = img.productID AND img.image_type = 'product'
                WHERE 
                    ps.stock < ps.low_stock_threshold ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $low_stock_product = $stmt->fetchAll();

        return $low_stock_product ; 
    }


    public function change_low_stock_threshold($low_stock_threshold , $productID , $sizeID) {
        $sql = "UPDATE productstock 
                SET low_stock_threshold = ? 
                WHERE productID = ? 
                AND sizeID = ? " ;

        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute($low_stock_threshold , $productID , $sizeID);

        if ($success && $stmt->rowCount() > 0) {
            return true; // Update successful
        } else {
            return false; // Either no such product-size match, or no change needed
        }

    }

    // update product stock ; 
    public function update_product_stock($quantity ,$productID , $sizeID ){
        $sql = "UPDATE productstock
                SET 
                    stock = stock + ?,
                    alert_sent = 
                    CASE 
                        WHEN (stock + ?) > low_stock_threshold THEN 0 
                        ELSE alert_sent 
                    END
                WHERE 
                    productID = ? AND
                    sizeID = ? ";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([$quantity ,$quantity , $productID , $sizeID]);
        
        if ($success && $stmt->rowCount() > 0) {
            return true; // Update successful
        } else {
            return false; // Either no such product-size match, or no change needed
        }
        
    }
    
    // show restock record ;
    public function record_restock($productID, $sizeID, $quantity, $admin  ) {
        $sql = "INSERT INTO restock_history (productID, sizeID, restock_quantity, restocked_by)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$productID, $sizeID, $quantity, $admin ]);
    }
    
    public function getDetailedProductInfo($productID, $sizeID) {
        $sql = "SELECT 
                    p.productName, p.price, 
                    ps.stock, ps.alert_sent, ps.low_stock_threshold 
                FROM productstock ps
                JOIN product p ON p.productID = ps.productID
                WHERE ps.productID = ? AND ps.sizeID = ?
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productID, $sizeID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function filterProduct($filters)
    {
        try {
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
                        ps.stock AS total_stock
                    FROM product p
                    LEFT JOIN productstock ps ON p.productID = ps.productID
                    LEFT JOIN series s ON p.seriesID = s.seriesID
                    WHERE 1=1
            ";
            $params = [];
    
            if (!empty($filters['productID'])) {
                $sql .= " AND p.productID = ?";
                $params[] = $filters['productID'];
            }
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
            if (!empty($filters['sizeID'])) {
                $sql .= " AND ps.sizeID = ?";
                $params[] = $filters['sizeID'];
            }
    
            // Only include under-threshold stocks
            $sql .= " AND ps.stock < ps.low_stock_threshold";
    
            $sql .= " ORDER BY p.productID, ps.sizeID";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error filtering products: " . $e->getMessage());
        }
    }
    
    public function search($searchText)
    {
        try {
            $like = '%' . $searchText . '%';
            $sql = "SELECT 
                        p.productID, 
                        p.productName, 
                        p.price, 
                        p.seriesID, 
                        s.seriesName, 
                        ps.sizeID, 
                        ps.status,
                        ps.stock AS total_stock
                    FROM product p
                    JOIN series s ON p.seriesID = s.seriesID 
                    JOIN productstock ps ON p.productID = ps.productID 
                    WHERE (
                        p.productName LIKE ? 
                        OR p.productID LIKE ? 
                        OR s.seriesName LIKE ? 
                        OR s.seriesID LIKE ?
                        )
                    AND ps.stock < ps.low_stock_threshold
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$like, $like, $like , $like]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error searching products: " . $e->getMessage());
        }
    }
}
// here is just for test ; 
$check = new CheckStock($_db);
$check->check_low_stock();

// 1. where php
// 2. copy this file path 
// schtasks /Create /SC MINUTE /MO 30 /TN "CheckLowStock" /TR "\"--REPLACE WITH YOUR PHP FILE PATH--" \" --REPLACE WITH YOUR FILE PATH --"" /F

// check : schtasks /Query /TN "CheckLowStock"
// run : schtasks /Run /TN "CheckLowStock"
// delete : schtasks /Delete /TN "CheckLowStock" /F


?>