<?php
// define router
require_once __DIR__ . '/../controller/product_controller.php';

$controller = new ProductController();

if ($_SERVER['REQUEST_URI'] == '/products' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller->listProducts();
}

if ($_SERVER['REQUEST_URI'] == '/product/add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->addProduct();
}

if ($_SERVER['REQUEST_URI'] == '/product/delete' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->deleteProduct();
}
?>
