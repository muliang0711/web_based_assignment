<?php
require_once __DIR__ . '/../../../db_connection.php';


header('Content-Type: application/json');


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


$sql = "SELECT p.productName, ps.sizeID, ps.stock
        FROM productstock ps
        JOIN product p ON p.productID = ps.productID
        WHERE ps.productID = ? AND ps.sizeID = ? AND ps.qr_token = ?";
$stmt = $_db->prepare($sql);
$stmt->execute([$productID, $sizeID, $token]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);


if ($product) {
    $redirectUrl = "update.php?productID={$productID}&sizeID={$sizeID}";
    header("Location: $redirectUrl");
    exit;
} else {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid QR code or product not found.'
    ]);
}
