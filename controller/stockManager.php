<?php
// 1. Start session to use session variables
session_start();

// 2. Include required files
include_once __DIR__ . '/../db_connection.php';
include_once __DIR__ . '/../db/productStock.php'; // Assuming this is where your CheckStock class is

class ProductManager {
    private $pdo;
    private $checkStock;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->checkStock = new CheckStock($pdo);
    }

    public function loadLowStockProductsToSession() {
        $lowStockProducts = $this->checkStock->get_low_stock_product();
        $_SESSION['low_stock_product'] = $lowStockProducts;
    }

    public function getProductInfo($productID, $sizeID) {
        return $this->checkStock->getProductByIDAndSize($productID, $sizeID);
    }

    public function updateStock($productID, $sizeID, $quantity, $adminName) {
        $success = $this->checkStock->update_product_stock($quantity, $productID, $sizeID);
        if ($success) {
            $this->checkStock->record_restock($productID, $sizeID, $quantity, $adminName);
            return ['success' => true, 'message' => 'Stock updated and restock recorded.'];
        } else {
            return ['success' => false, 'message' => 'Update failed or no stock change.'];
        }
    }
}

// 6. Example usage
$productManager = new ProductManager($_db);
?>
