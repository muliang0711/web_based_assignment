<?php
require_once __DIR__ . '/controller/product_controller.php';

// Get the requested URL
$url = isset($_GET['url']) ? $_GET['url'] : '';

$controller = new ProductController();

if ($url == 'product/delete' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->deleteProduct();
} else {
    $controller->listProducts(); // Default: Show product list
}

?>
