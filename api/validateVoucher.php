<?php 
$vouchers = ["TEST123" => 0.3];
session_start();
header('Content-Type: application/json');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //check if the voucher code provided is valid

    
    $code = $_POST["vcr"];


    if($code === "ffff1234rmvcr"){
        $_SESSION["discount"] = 0.00;
        $arr = [
            "total" => round($_SESSION["subtotal"] - $_SESSION["discount"],2),
            "discount" => $_SESSION["discount"]
        ];
        echo json_encode($arr);
        exit();
    }

    if(array_key_exists($code, $vouchers)){
        $_SESSION["discount"] = $_SESSION["subtotal"] * $vouchers[$code];
        $arr = [
            "total" => round($_SESSION["subtotal"] - $_SESSION["discount"],2),
            "discount" => $_SESSION["discount"]
        ];
        echo json_encode($arr);
    }
    else {
        echo false;
    }
}

?>
