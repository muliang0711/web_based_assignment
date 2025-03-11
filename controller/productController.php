<?php
require_once __DIR__ . "/../service/productService.php";
require_once __DIR__ . "/../_base.php";
require_once __DIR__ . "/../db_connection.php";

$productService = new productService($_db);

if (is_post()) { 
    $action = $_POST['action'] ?? null;

    // 1. Search Products
    if ($action === "search") {
        $filters = [
            'productName' => $_POST['productName'] ?? null,
            'priceMin' => $_POST['minPrice'] ?? null,
            'priceMax' => $_POST['maxPrice'] ?? null,
            'seriesID' => $_POST['seriesID'] ?? null,
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

        // Convert to float 
        if (!empty($filters['priceMin'])) {
            $filters['priceMin'] = (float) $filters['priceMin'];
        }
        if (!empty($filters['priceMax'])) {
            $filters['priceMax'] = (float) $filters['priceMax'];
        }

        $result = $productService->filterProduct($filters);
        $_SESSION['search_results'] = $result;
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
        header("Location: ../pages/admin/admin_product.php");
        exit();
    }

    // 2. Add Product
    if ($action === "addProduct") {
        $productInformation = [
            'productId' => $_POST['productId'] ?? null , 
            'productName' => $_POST['productName'] ?? null,

            'seriesId' => $_POST['seriesId'] ?? null, 
            'seriesName' => $_POST['seriesName'] ?? null,

            'sizeId' => $_POST['sizeId'] ?? null , 
            'stock' => $_POST['stock'] ?? null,
            'price' => $_POST['price'] ?? null,
        ];


        // store the result
        $result1 = $productService->addProduct($productInformation);
        $_SESSION['add_results'] = $result1; 

        header("Location: ../pages/admin/admin_product.php"); 
        exit();
    }

    // 3. Update Product (To be implemented)
    if ($action === "updateProduct") {

    }

    // 4. Delete Product (To be implemented)
    if ($action === "deleteProduct") {

    }
}
?>
