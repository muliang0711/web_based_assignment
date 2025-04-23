<?php
require_once __DIR__ . '/../../../db_connection.php';
require_once __DIR__ . '/../../..$productManager/stockManager.php';

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
    <style>
        body {
            font-family: Arial;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f2f2f2;
        }
        .form-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 350px;
        }
        .form-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        input[readonly] {
            background: #eee;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        .message {
            margin-top: 10px;
            text-align: center;
        }
    </style>
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
