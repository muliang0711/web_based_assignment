<?php 
include_once __DIR__ . "/../db_connection.php";

class check{
    private $pdo ;

    function __construct($pdo)
    {
        $this->$pdo = $pdo ;
    }

    public function check_low_stock(){
        $sql = "SELECT * FROM productsize 
        WHERE stock <= low_stock_threshold '
        AND alert_sent = 0";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $low_stock_product = $stmt->fetchAll();

        foreach($low_stock_product as $product){
            $productID = $product->productID ;
            $sizeID = $product->sizeID ; 
            $theresold = $product->low_stock_threshold;

            // gmail :
            // sms : 
        }
        
    }
}

$check = new check($_db);

?>