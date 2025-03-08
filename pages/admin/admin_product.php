<?php
// Include necessary files
include "../../db_connection.php";
include "../../service/productService.php";

$productService = new productService($_db);
$products = $productService->showAllProduct();

    foreach ($products as $product) {
        echo "<li>" . htmlspecialchars($product->productName) . " - $" . number_format($product->price, 2) . "</li>";
    }
    echo "</ul>";

?>
