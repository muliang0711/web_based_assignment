<?php

require_once "../../../db_connection.php";
require "../../admin/db/productDb.php";

// what this file do ? 
// as: decide the bussines logic about product  , validation and call out sql service 

class productService{
    // 1.2 we declare a variable to catch the class 
    private $productDb; 
    // 1. we need to create a productDb class with everytimes we call out this class for service 
    public function __construct($_pdo){
        // 1.2.1 create the class and catch it into productDb 
        $this->productDb = new productDb($_pdo);
    }
    // 2. show all the product to user 
    public function showAllProduct(){
        return $this->productDb->getAllProducts();
    }
}
?>
