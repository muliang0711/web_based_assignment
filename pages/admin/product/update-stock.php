<?php
require_once __DIR__ . '/../../../db_connection.php';
require_once __DIR__ . '/../../../controller/stockManager.php';

$productID = $_GET['productID'] ?? null;
$sizeID = $_GET['sizeID'] ?? null;

if (!$productID || !$sizeID) die("Missing parameters.");
$productManager = new ProductManager($_db);

$product = $productManager->getProductInfo($productID, $sizeID);
if (!$product) die("Product not found.");

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $admin = 'admin123'; // Replace with session value

    if ($quantity > 0) {
        $result = $productManager->updateStock($productID, $sizeID, $quantity, $admin);
        $message = "<p style='color:" . ($result['success'] ? 'green' : 'red') . "'>{$result['message']}</p>";
    } else {
        $message = "<p style='color:red;'>Please enter a valid quantity.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product Stock</title>
    <link rel="stylesheet" href="css/updateStock.css">
</head>
<body>

<div class="form-box">
    <h2>Update Stock</h2>
    <?php echo $message; ?>
    <form method="post">
        <label>Product Name</label>
        <input type="text" value="<?= htmlspecialchars($product['productName']) ?>" readonly>

        <label>Size ID</label>
        <input type="text" value="<?= htmlspecialchars($sizeID) ?>" readonly>

        <label>Current Stock</label>
        <input type="text" value="<?= htmlspecialchars($product['stock']) ?>" readonly>
        
        <label>Restock Quantity</label>
        <input type="number" name="quantity" min="1" required>

        <button type="submit">Update Stock</button>

        <a href="stock.php" style="display: block; text-align: center; margin-top: 10px; text-decoration: none;">
        <button type="button" style="background-color: #888;">Back to Menu</button>
        </a>
    </form>
</div>

</body>
</html>  