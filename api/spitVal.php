<?php 
session_start();

header('Content-Type: application/json');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $val = [
        "total" => $_SESSION['subtotal'] - $_SESSION['discount'],
        "discount" => $_SESSION['discount']
    ];

    echo json_encode($val);
}  
?>