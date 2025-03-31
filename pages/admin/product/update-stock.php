<?php
require_once __DIR__ . '/../../db_connection.php';

header('Content-Type: application/json');

// 1. 读取 JSON 数据
$input = json_decode(file_get_contents('php://input'), true);

$productID = $input['productID'] ?? null;
$sizeID = $input['sizeID'] ?? null;
$token = $input['token'] ?? null;
$newQty = $input['new_quantity'] ?? null;

// 2. 验证参数
if (!$productID || !$sizeID || !$token || !$newQty || $newQty < 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input data.'
    ]);
    exit;
}

// 3. 检查 token 是否匹配
$sql = "SELECT * FROM productsize WHERE productID = ? AND sizeID = ? AND qr_token = ?";
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

// 4. 更新库存数量
$updateSql = "UPDATE productsize SET quantity = quantity + ? WHERE productID = ? AND sizeID = ?";
$updateStmt = $_db->prepare($updateSql);
$updateStmt->execute([$newQty, $productID, $sizeID]);

echo json_encode([
    'success' => true,
    'message' => 'Stock updated successfully!'
]);
