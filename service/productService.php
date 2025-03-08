<?php

require_once __DIR__ . "/../db/productDb.php";
require_once __DIR__ . "/../db_connection.php";


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
    // 
    public function showAllProduct(){
        return $this->productDb->getAllProducts();
    }
    //
    public function searchProduct($filters){
        return $this->productDb->getProduct($filters);
    }
    //
    public function deleteProduct(){
        return null ;
    }
    //
    public function createProduct(){
        return null;
    }
    // 
    public function updateProduct(){
        return null ; 
    }
    
}


?>
