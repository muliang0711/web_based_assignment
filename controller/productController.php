<?php

require_once __DIR__ . "/../_base.php";
require_once __DIR__ . "/../db_connection.php";
require_once __DIR__ . "/../db/productDb.php";

class ProductController{

    private $productDb ; 

    public function __construct($_pdo){
        $this->productDb = new productDb($_pdo);
    }

    public function handleRequest(){
        if(!is_post()){
            return; 
        }
        $action = $_POST['action'] ?? null;
        switch ($action) {
            case 'addProduct':
                $this->addProduct(); // done 
                break;
            case 'updateProduct':
                $this->updateProduct(); // done 
                break;
            case 'deleteProduct':
                $this->deleteProduct(); // done 
                break;
            case 'filterProduct':
                $this->filterProducts(); //done 
                break;
            case 'totalsellTrack' :
                $this->handleTotalSellTrack();
                break;
            case 'productSellTrack':
                $this->handleProductSellTrack();
                break ; 
            default:
                $_SESSION['errors'] = 'Invalid action';
                $this->redirectToAdmin();
            }
    }

    public  function getAllProducts(){
        return  $this->productDb->getAllProducts();
    }

//====================== All Private Function : 

    private function filterProducts() {
        $filters = [
            'productName' => $_POST['productName'] ?? null,
            'priceMin' => isset($_POST['minPrice']) ? (float) $_POST['minPrice'] : null,
            'priceMax' => isset($_POST['maxPrice']) ? (float) $_POST['maxPrice'] : null,
            'seriesID' => $_POST['seriesID'] ?? null,
            'sizeID' => $_POST['sizeID'] ?? null, 
        ];
        /* when process the data send from frontend , data will loke likes this : associative array:
        [
            "productName" => "Gaming Laptop",
            "priceMin" => "50",
            "priceMax" => "500",
            "seriesID" => "S01"
        ]

        we use filters['variavblename'] to get sepcific value ：gaming laptop 

        when the value is a array ? "productName" => ["Gaming Laptop","xd"]        filters['productName'] :
            foreach($productName as name){
                echo($name) /
            }
        */
        
        $_SESSION['search_results'] = $this->productDb->filterProduct($filters);
        // what is the result look like ？ ： array of object 
        // result = [ 
        // (object) ["productName" => "Laptop", "price" => 1200] 
        // (obkect) ["productName" => "gamming laptop , price => 100]
        //  ]
        // how we fetch data ?
        // foreach($result as product ){
        //  product->productName ; 
        //  product->price ； 
        //}
        $this->redirectToAdmin();
    }

    private function addProduct() {
        $productInformation = [
            'productId' => $_POST['productId'] ?? null,
            'productName' => $_POST['productName'] ?? null,
            'seriesId' => $_POST['seriesId'] ?? null,
            'seriesName' => $_POST['seriesName'] ?? null,
            'sizeId' => $_POST['sizeId'] ?? null,  
            'stock' => $_POST['stock'] ?? null,
            'price' => $_POST['price'] ?? null,
        ];


        $errors = $this->validation($productInformation);

        // valdation : ensure the components of productId and sizeId existing in db
        // not longer need 

        // SAME product idalready existing than return error :
        $products = $this->getAllProducts();
        foreach($products as $product){
            if($productInformation['productId'] == $product->productID && $productInformation['seriesId'] == $product->productseriesID){
                $errors = ['ProductId existing already ']; 
            }
        
        }
        // If there are validation errors, return them
        if (!empty($errors)) {
            $_SESSION['Add_ErrorMsg'] = $errors;
            $this->redirectToAdmin();
        }

        // Try inserting the product
        $result = $this->productDb->addProduct($productInformation);

        if ($result['success']) {
            $_SESSION['Add_SuccessMsg'] = "Product '{$productInformation['productName']}' (ID: {$productInformation['productId']}) has been successfully added!";
        } else {
            $_SESSION['Add_ErrorMsg'] = ["Failed to add product. Reason: " . $result['error']];
        }

        $this->redirectToAdmin();
    }

    private function updateProduct() {
        $productInformation = [
            'productId' => $_POST['productId'] ?? null,
            'productName' => $_POST['productName'] ?? null,
            'seriesId' => $_POST['seriesId'] ?? null,
            'seriesName' => $_POST['seriesName'] ?? null,
            'sizeId' => $_POST['sizeId'] ?? null,
            'stock' => $_POST['stock'] ?? null,
            'price' => $_POST['price'] ?? null,
            'oldSizeID' => $_POST['oldSizeID'] ?? null , 
            //'oldSeriesID' => $_POST['oldSeriesID'] ?? null , 
        ];
        $errors = [];

        $errors = $this->validation($productInformation);

        if(!empty($errors)){
            $_SESSION['Update_ErrorMsg'] = $errors;
            $this->redirectToAdmin();
        }
    
            
        $result = $this->productDb->updateProducts($productInformation);

        if($result['success']){
            $_SESSION['Update_SuccessMsg'] = "Product '{$productInformation['productName']}' (ID: {$productInformation['productId']}) has been successfully updated!";

        }else{
            $_SESSION['Update_ErrorMsg'] = ["Failed to update : " . $result['error']];
        }
        $this->redirectToAdmin();

    }

    private function deleteProduct() {

        $productInformation = [
            'productId' => $_POST['productId'] ?? null,
            'productName' => $_POST['productName'] ?? null,
            'seriesId' => $_POST['seriesId'] ?? null,
            'seriesName' => $_POST['seriesName'] ?? null,
            'sizeId' => $_POST['sizeId'] ?? null,
            'stock' => $_POST['stock'] ?? null,
            'price' => $_POST['price'] ?? null,
        ];

        $errors = [];
        $errors = $this->validation($productInformation);
        if(!empty($errors)){
            $_SESSION['Delete_ErrorMsg'] = $errors;
            $this->redirectToAdmin();
        }

        // else the data is clean so we call out the sql service :
        // save the sql result in variavble : 
        $result = $this->productDb->deleteProduct($productInformation);

        // validate if the error happend : for debug issue 

        if($result['success']){
            // save the sccess msg and return :
            $_SESSION['Delete_SuccessMsg'] = 'sucess delete';
        }else{
            // else return error msg : 
            $_SESSION['Delete_ErrorMsg'] = ['Failed delete ' . $result['message']];
        }
        $this->redirectToAdmin();
    }

    private function redirectToAdmin() {
        header('Location: ../pages/admin/admin_product.php');
        exit();
    }

    private function validation($productInformation){
        // Initialize an empty error array
        $errors = [];
        // validate product id 
        if (empty($productInformation['productId'])) {
            $errors[] = "ProductId cannot be null!";
            // need to add on validation number cannot more than 5
        }elseif (strlen($productInformation['productId']) > 5) {
           $errors[] = " Product ID cannot exceed 5 characters.";
       }
        // Validate product name     
        if (empty($productInformation['productName'])) {
            $errors[] = "Product name cannot be null!";
        }
    
        // Validate series ID
        if (empty($productInformation['seriesId'])) {
            $errors[] = "Series ID cannot be null!";
        // need to add on validation number cannot more than 3
        }elseif (strlen($productInformation['seriesId']) > 3) {
           $errors[] = " Series ID cannot exceed 3 characters.";
       }
        //need to add on one : seriesName 
        if (empty($productInformation['seriesName'])) {
        $errors[] = "SeriesName cannot be null!";
        // need to add on validation number cannot more than 15 
        }elseif (strlen($productInformation['seriesName']) > 15) {
           $errors[] = "Series Name cannot exceed 15 characters.";
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

        // Validate size ID
        if (empty($productInformation['sizeId'])) {
           $errors[] = " sizeID cannot be null!";
        // need to add on validation number cannot more than 3
        }elseif (strlen($productInformation['sizeId']) > 4) {
           $errors[] = " Size ID cannot exceed 4 characters.";
       }
       return $errors ;
    }

    private function handleTotalSellTrack() {
        $filterData = [
            'startDate' => $_POST['startDate'] ?? null,
            'endDate' => $_POST['endDate'] ?? null,
            'status' => $_POST['status'] ?? null,
        ];
        
        $response = $this->productDb->totalsellTrack($filterData);
        $_SESSION['total_sales_results'] = $response['success'] ? $response['data'] : [];
        
        header('Location : ../pages/admin/admin_test.php');
        exit();
    }

    private function handleProductSellTrack() {
        $filterData = [
            'startDate' => $_POST['startDate'] ?? null,
            'endDate' => $_POST['endDate'] ?? null,
            'sizeID' => $_POST['sizeID'] ?? null,
        ];
        
        $response = $this->productDb->productSellTrack($filterData);
        $_SESSION['product_sales_results'] = $response['success'] ? $response['data'] : [];
        
        header('Location : ../pages/admin/admin_test.php');
        exit();
    }
//====================================================================================
}
$productController = new ProductController($_db);
$productController->handleRequest();
?>
