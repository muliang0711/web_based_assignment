<?php
// 1. Start session to use session variables
session_start();

// 2. Include required files
include_once __DIR__ . '/../db_connection.php';
include_once __DIR__ . '/../db/productStock.php'; // Assuming this is where your CheckStock class is

// 3. Declare the ProductManager class
class ProductManager {
    private $pdo;
    private $checkStock;

    // 4. Constructor to initialize PDO and CheckStock
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->checkStock = new CheckStock($pdo);
    }

    // 5. Load low stock products into session
    public function loadLowStockProductsToSession() {
        $lowStockProducts = $this->checkStock->get_low_stock_product();
        $_SESSION['low_stock_product'] = $lowStockProducts;
    }
}

?>
