<?php
require_once __DIR__ . '/../../../db_connection.php'; // 数据库连接

header('Content-Type: application/json');

// 1. 获取参数
$productID = $_GET['productID'] ?? null;
$sizeID = $_GET['sizeID'] ?? null;
$token = $_GET['token'] ?? null;

if (!$productID || !$sizeID || !$token) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters.'
    ]);
    exit;
}

// 2. 查询数据库验证 token
$sql = "SELECT p.productName, ps.sizeID, ps.quantity
        FROM productsize ps
        JOIN product p ON p.productID = ps.productID
        WHERE ps.productID = ? AND ps.sizeID = ? AND ps.qr_token = ?";
$stmt = $_db->prepare($sql);
$stmt->execute([$productID, $sizeID, $token]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// 3. 返回结果
if ($product) {
    echo json_encode([
        'success' => true,
        'productID' => $productID,
        'sizeID' => $sizeID,
        'token' => $token,
        'product_name' => $product['productName'],
        'size_label' => $product['sizeID'],
        'quantity' => $product['quantity']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid QR code or product not found.'
    ]);
}
