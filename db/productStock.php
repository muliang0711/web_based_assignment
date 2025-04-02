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

    // 1. send sms ; 
    private function sendLowStockSMS(){
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
                    img.image_path AS productImage
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

    // pending 
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