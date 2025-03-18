<?php
require_once __DIR__ . "/../db/productDb.php";
include_once __DIR__ . '/../db_connection.php';

class track{
    private $pdo ;

    private $productDb ; 

    public function __construct($_db){

        $this->pdo = $_db;

        $this->productDb = new productDb($_db);

        
    }

    public function trackUpdate($productInformation){
        $productID = $productInformation['productId'];
        session_start();
        $_SESSION['admin_id'] = '123';
        $admin_id = $_SESSION['admin_id']; 

        // get old product information : 
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE productID = ?");
        $stmt->execute([$productID]);
        $old_product = $stmt->fetch(PDO::FETCH_ASSOC);

        // update product information : 
        $newProduct =  $this->productDb->updateProducts($productInformation);

        // save change : 
        $stmt = $this->pdo->prepare("
        INSERT INTO product_audit_log (product_id, admin_id, action, old_value, new_value, ip_address, user_agent)
        VALUES (?, ?, 'UPDATE', ?, ?, ?, ?)
        ");
        $stmt->execute([
            $productID,
            $admin_id,
            json_encode($old_product),  // Store old values
            json_encode($newProduct), // Store new values
            $_SERVER['REMOTE_ADDR'], // IP Address
            $_SERVER['HTTP_USER_AGENT'] // Browser details
        ]);

        $to = "hockyangpui@gmail.com";
        $subject = "Product Updated: ID $productID";
        $message = "Product ID: $productID has been updated by Admin ID: $admin_id\n\n";
        $message .= "Old Value:\n" . json_encode($old_product, JSON_PRETTY_PRINT) . "\n\n";
        $message .= "New Value:\n" . json_encode($newProduct,  JSON_PRETTY_PRINT);
        $headers = "From: noreply@example.com";

        mail($to, $subject, $message, $headers);

        return ["success" => true , "message" => "update successful"];

    }

}
?>