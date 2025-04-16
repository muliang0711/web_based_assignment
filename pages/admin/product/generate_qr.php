<?php
require __DIR__ . '/../../../db_connection.php'; 
include_once __DIR__ . '/../../../vendor/autoload.php'; 

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

function generateQRCode($pdo, $productID, $sizeID) {
    // 1. Check if QR token already exists
    $checkSql = "SELECT qr_token FROM productstock WHERE productID = ? AND sizeID = ?";
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute([$productID, $sizeID]);
    $existing = $stmt->fetch();

    if ($existing && !empty($existing->qr_token)) {
        echo "QR Code already exists for product $productID, size $sizeID\n";
        return;
    }

    // 2. Generate secure token
    $token = bin2hex(random_bytes(16)); // 32-character token

    // 3. Save token into DB
    $updateSql = "UPDATE productstock SET qr_token = ? WHERE productID = ? AND sizeID = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$token, $productID, $sizeID]);
    
    // 4. Build verification URL
    $verifyUrl = "https://wbproject.local/pages/admin/product/verify-stock.php?productID=$productID&sizeID=$sizeID&token=$token";

    // 5. Generate QR code
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($verifyUrl)
        ->encoding(new Encoding('UTF-8'))
        ->size(300)
        ->margin(10)
        ->build();

    // 6. Save QR image
    $filePath = __DIR__ . "/../../../qrcode/product_{$productID}_size_{$sizeID}.png";
    $result->saveToFile($filePath);

    echo "QR Code generated and saved: $filePath\n";
}
$p = "R0001";
$s = "3UG5";
generateQRCode($_db, $p , $s); // Example: productID=5, sizeID=2
