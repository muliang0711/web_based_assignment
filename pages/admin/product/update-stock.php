<?php
require_once __DIR__ . '/../../../db_connection.php';
require_once __DIR__ . '/../../../controller/stockManager.php';
require_once "../../../_base.php";      
include '../../../admin_login_guard.php';

$productID = $_GET['productID'] ?? null;
$sizeID = $_GET['sizeID'] ?? null;

if (!$productID || !$sizeID) die("Missing parameters.");

$productManager = new ProductManager($_db);

$product = $productManager->getProductInfo($productID, $sizeID);
if (!$product) die("Product not found.");
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

    <!-- 3. Display success or error messages -->
    <?php
    if (isset($_SESSION['successupdate'])) {
        echo "<div class='success-message'>" . htmlspecialchars($_SESSION['successupdate']) . "</div>";
        unset($_SESSION['successupdate']);
    }

    if (isset($_SESSION['failedupdate'])) {
        echo "<div class='error-message'>" . htmlspecialchars($_SESSION['failedupdate']) . "</div>";
        unset($_SESSION['failedupdate']);
    }
    ?>

    <form method="post" action="/controller/stockManager.php?action=updateStock">
        <!-- Hidden fields must be added -->
        <input type="hidden" name="productID" value="<?= htmlspecialchars($productID) ?>">
        <input type="hidden" name="sizeID" value="<?= htmlspecialchars($sizeID) ?>">
        
        <label>Product Name</label>
        <input type="text" value="<?= htmlspecialchars($product['productName']) ?>" readonly>

        <label>Size ID</label>
        <input type="text" value="<?= htmlspecialchars($sizeID) ?>" readonly>

        <label>Current Stock</label>
        <input type="text" value="<?= htmlspecialchars($product['stock']) ?>" readonly>
            
        <label>Restock Quantity</label>
        <input type="number" name="quantity" min="1" required>

        <label for="restock_price">Restock Price (per unit):</label>
        <input type="number" id="restock_price" name="restock_price" min="0" step="0.01" required>

        <button type="submit">Update Stock</button>
    </form>

    <!-- 4. Back to Menu Button -->
    <div class="back-button">
        <a href="stock.php">
            <button type="button" style="background-color: #888; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Back to Menu</button>
        </a>
    </div>
</div>

</body>
</html>
