
<?php
// what this file do ?
// As : create a class module to handle all request and decide what service to call 
require_once "../service/productService.php";
require_once "../../../_base.php";

// 1. create a service class to use it function 
$productService = new productService($_pdo);


?>