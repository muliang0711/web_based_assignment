<?php 
header('Content-Type: application/json');
session_start();
extract((array)$_user);

$userID = $_user->userID;
$_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
  ]);
  
$statement = $_db->prepare('SELECT * FROM cartitem JOIN product USING (productID) WHERE userID = ?');
    $statement->execute([$userID]);
    $cartItemArray = $statement->fetchAll();

    $outOfStock = false;
    $outOfStockItems = [];

foreach ($cartItemArray as $cart) {
    $product = $cart->productID;
    $size = $cart->sizeID;
    $quantity =  $cart->quantity;
    $stockStatement = $_db->prepare('SELECT stock FROM productstock WHERE productID = ? AND sizeID = ?');
    $stockStatement->execute([$product, $size]);
    $current = $stockStatement->fetch();
    $currentStock = $current->stock;
    if ($cart->quantity > $currentStock) {
        return false;
    }
}
return true;
?>