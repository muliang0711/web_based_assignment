<?php
require_once __DIR__ . '/../config/db_test.php';

class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $desc, $price, $image, $stock) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, image, stock) VALUES (:name, :desc, :price, :image, :stock)");
        return $stmt->execute([
            ':name' => $name,
            ':desc' => $desc,
            ':price' => $price,
            ':image' => $image,
            ':stock' => $stock
        ]);
    }

    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

?>
