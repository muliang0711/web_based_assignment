
<?php
// what this file do ?
// As : create a class module to handle all request and decide what service to call 
require_once __DIR__ . "/../service/productService.php";
require_once __DIR__ . "/../_base.php";
require_once __DIR__ . "/../db_connection.php"; 
// 1. create a service class to use it function 
$productService = new productService($_db);


// 2. if method post && action = search -> execute searchProduct();
if (is_post()) {
    $action = $_POST['action'] ?? null;

    if ($action === "search") {
        // Capture filters from the search form
        $filters = [
            'productName' => $_POST['productName'] ?? null,
            'priceMin' => $_POST['priceMin'] ?? null,
            'priceMax' => $_POST['priceMax'] ?? null,
            'seriesID' => $_POST['seriesID'] ?? null,
        ];

        // Fetch products
        $result = $productService->searchProduct($filters);

        if (isset($result['errors'])) {
            $errors = $result['errors'];
            $products = [];
        } else {
            $products = $result;
        }
    }
    if ($action === "addProduct") {

    }
    if ($action === "updateProduct") {

    }
    if ($action === "deleteProduct") {

    }
}

?>