<?php
// 1. Include DB connection
require_once __DIR__ . '/../../../db_connection.php';

// 2. Get productID and sizeID from URL
$productID = $_GET['productID'] ?? null;
$sizeID = $_GET['sizeID'] ?? null;

// Check if both are provided
if (!$productID || !$sizeID) {
    die("Missing productID or sizeID in the URL.");
}

// 3. Fetch current threshold from database
$sql = "SELECT low_stock_threshold FROM productstock WHERE productID = ? AND sizeID = ?";
$stmt = $_db->prepare($sql);
$stmt->execute([$productID, $sizeID]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

$currentThreshold = $product['low_stock_threshold'];

// 4. Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newThreshold = $_POST['low_stock_threshold'] ?? '';

    if (!is_numeric($newThreshold) || $newThreshold < 0) {
        $error = "Please enter a valid number.";
    } else {
        // Update DB
        $updateSQL = "UPDATE productstock SET low_stock_threshold = ? WHERE productID = ? AND sizeID = ?";
        $updateStmt = $_db->prepare($updateSQL);
        $success = $updateStmt->execute([$newThreshold, $productID, $sizeID]);

        if ($success) {
            $message = "Threshold updated successfully!";
            $currentThreshold = $newThreshold; // Reflect the new value
        } else {
            $error = "Failed to update threshold.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Low Stock Threshold</title>

</head>
<link rel="stylesheet" href="css/checkLowStockAlert.css">
<body>

<div class="form-box">
    <h2>Change Low Stock Threshold</h2>
    <p>Product ID: <strong><?= htmlspecialchars($productID) ?></strong></p>
    <p>Size ID: <strong><?= htmlspecialchars($sizeID) ?></strong></p>
    <p>Current Threshold: <strong><?= htmlspecialchars($currentThreshold) ?></strong></p>

    <?php if (!empty($message)) echo "<div class='msg'>$message</div>"; ?>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <label for="low_stock_threshold">New Threshold:</label>
        <input type="number" name="low_stock_threshold" id="low_stock_threshold" min="0" required value="<?= htmlspecialchars($currentThreshold) ?>">
        <button type="submit">Update</button>
    </form>

    <button onclick=" window.location ='/pages/admin/product/stock.php'"> back to menu</button>

</div>

</body>
</html>
