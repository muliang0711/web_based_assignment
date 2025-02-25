<?php
// define router
require_once __DIR__ . '/../controller/product_controller.php';

$controller = new ProductController();

echo 'This line is for debugging purposes. $_SERVER[\'REQUEST_URI\']: ' . $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_URI'] == '/mvc_demo/products' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller->listProducts();
}

if ($_SERVER['REQUEST_URI'] == '/product/add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->addProduct();
}

if ($_SERVER['REQUEST_URI'] == '/product/delete' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->deleteProduct();
}
?>
