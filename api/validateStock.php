<?php
// 1. Set header to tell the client we will send back JSON
header('Content-Type: application/json');

// 2. Start session and extract user data
session_start();
global $_user;
  $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
  $userID = $_user->userID;

// 3. Connect to the database
$_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

// 4. Prepare and execute query to get user's cart items
$statement = $_db->prepare('SELECT * FROM cartitem JOIN product USING (productID) WHERE userID = ?');
$statement->execute([$userID]);
$cartItemArray = $statement->fetchAll();

// 5. Initialize variables to track stock status
$outOfStockItems = [];

// 6. Check each item if quantity exceeds stock
foreach ($cartItemArray as $cart) {
    $productID = $cart->productID;
    $sizeID = $cart->sizeID;
    $quantityNeeded = $cart->quantity;

    // Query stock for the specific product and size
    $stockStatement = $_db->prepare('SELECT stock FROM productstock WHERE productID = ? AND sizeID = ?');
    $stockStatement->execute([$productID, $sizeID]);
    $current = $stockStatement->fetch();

    // If product not found or stock insufficient
    if (!$current || $quantityNeeded > $current->stock) {
        $outOfStockItems[] = [
            'productID' => $productID,
            'sizeID' => $sizeID,
            'requestedQuantity' => $quantityNeeded,
            'availableStock' => $current ? $current->stock : 0,
        ];
    }
}

// 7. Build and output JSON response
if (empty($outOfStockItems)) {
    // 7.1 If all items are fine
    echo json_encode([
        'success' => true,
        'message' => 'All items are in stock.',
    ]);
} else {
    // 7.2 If some items are out of stock
    echo json_encode([
        'success' => false,
        'message' => 'Some items are out of stock.',
        'outOfStockItems' => $outOfStockItems,
    ]);
}
?>
