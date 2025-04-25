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
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }

        .form-box h2 {
            margin-top: 0;
        }

        .form-box input[type="number"] {
            width: 100%;
            padding: 0.5rem;
            margin: 1rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-box button {
            padding: 0.5rem 1rem;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .msg {
            margin: 1rem 0;
            color: green;
        }

        .error {
            margin: 1rem 0;
            color: red;
        }
    </style>
</head>
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
