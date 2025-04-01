<?php 
require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";

header('Content-Type: application/json');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //check if the voucher code provided is valid

    
    $code = $_POST["vcr"];
    $stm = $_db->prepare("SELECT * FROM vouchers WHERE voucherCode = ?");
    $stm->execute([$code]);
    $vouchers = $stm->fetchAll();
    
    

    if($code === "ffff1234rmvcr"){
        $_SESSION["discount"] = 0.00;
        unset($_SESSION["vcrcode"]);
        $arr = [
            "total" => round($_SESSION["subtotal"] - $_SESSION["discount"],2),
            "discount" => $_SESSION["discount"]
        ];
        echo json_encode($arr);
        exit();
    }

    if(count($vouchers)>0 && ($vouchers[0]->totalUsage < $vouchers[0]->allowedUsage) ){
        $_SESSION["discount"] = $_SESSION["subtotal"] * (($vouchers[0]->amount)/100);
        $_SESSION["vcrcode"] = $code;
        $arr = [
            "total" => round($_SESSION["subtotal"] - $_SESSION["discount"],2),
            "discount" => $_SESSION["discount"]
        ];
        echo json_encode($arr);
    }
    else {
        echo json_encode(false);
    }
}

?>
