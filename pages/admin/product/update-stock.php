<?php
require_once __DIR__ . '/../../../db_connection.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$productID = $input['productID'] ?? null;
$sizeID = $input['sizeID'] ?? null;
$token = $input['token'] ?? null;
$newQty = $input['new_quantity'] ?? null;

if (!$productID || !$sizeID || !$token || !$newQty || $newQty < 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data.'
    ]);
    exit;
}

$sql = "SELECT * FROM productstock WHERE productID = ? AND sizeID = ? AND qr_token = ?";
$stmt = $_db->prepare($sql);
$stmt->execute([$productID, $sizeID, $token]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access. Token mismatch.'
    ]);
    exit;
}

$updateSql = "UPDATE productstock SET stock = ? WHERE productID = ? AND sizeID = ?";
$updateStmt = $_db->prepare($updateSql);
$updateStmt->execute([$newQty, $productID, $sizeID]);

echo json_encode([
    'success' => true,
    'message' => 'Stock updated successfully!'
]);
