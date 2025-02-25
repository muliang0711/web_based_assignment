<?php
require_once __DIR__ . '/../db_module/product_module.php';
require_once __DIR__ . '/../config/db_test.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel($GLOBALS['conn']);
    }

    // Display all products
    public function listProducts() {
        $products = $this->productModel->getAllProducts();
        require __DIR__ . '/../views/product_pages/product_list.php';
        echo "listProducts() called.\n";
    }

    // Add a new product
    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $image = $_POST['image'];
            $stock = $_POST['stock'];

            $this->productModel->addProduct($name, $desc, $price, $image, $stock);
            header("Location: ../products");
            exit();
        }
    }

    // Delete a product
    public function deleteProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $this->productModel->deleteProduct($id);
            header("Location: ../products");
            exit();
        }else{
            echo "invalid request" ;
            exit();
        }
    }
}

// Handle actions from forms
$controller = new ProductController();
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'add') {
        $controller->addProduct();
    } elseif ($_GET['action'] == 'delete') {
        $controller->deleteProduct();
    }
}
?>
