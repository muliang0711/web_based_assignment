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
    public function filterProduct($filters){
        return $this->productDb->filterProduct($filters);
    }
    //
    public function deleteProduct(){
        return null ;
    }
    //
    public function addProduct($productInformation) {
        // Initialize an empty error array
        $errors = [];
    
        // Validate product name
        if (empty($productInformation['productName'])) {
            $errors[] = "Product name cannot be null!";
        }
    
        // Validate series ID
        if (empty($productInformation['seriesId'])) {
            $errors[] = "Series ID cannot be null!";
        }
    
        // Validate price
        if (!isset($productInformation['price']) || $productInformation['price'] === '') {
            $errors[] = "Price must have a value!";
        } elseif (!is_numeric($productInformation['price'])) {
            $errors[] = "Price must be a number!";
        }
    
        // Validate stock
        if (!isset($productInformation['stock']) || $productInformation['stock'] === '') {
            $errors[] = "Stock must have a value!";
        } elseif (!is_numeric($productInformation['stock'])) {
            $errors[] = "Stock must be a number!";
        }
    
        // If there are validation errors, return them
        if (!empty($errors)) {
            return $errors;
        }
    
        // No errors, proceed with product addition
        $this->productDb->addProduct($productInformation);
    
        return "Successful adding a product: " .json_encode($productInformation);
    }
    
    // 
    public function updateProduct(){
        return null ; 
    }
    
}


?>
