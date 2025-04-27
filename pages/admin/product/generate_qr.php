<?php
require __DIR__ . '/../../../db_connection.php'; 
include_once __DIR__ . '/../../../vendor/autoload.php'; 
require_once __DIR__ . '/../../../_base.php';
include_once __DIR__ . "/../../../admin_login_guard.php";
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

function generateQRCode($pdo, $productID, $sizeID) {
    try {
       
        $checkSql = "SELECT qr_token FROM productstock WHERE productID = ? AND sizeID = ?";
        $stmt = $pdo->prepare($checkSql);
        $stmt->execute([$productID, $sizeID]);
        $existing = $stmt->fetch();

        if ($existing && !empty($existing->qr_token)) {

            return false;
        }

        
        $token = bin2hex(random_bytes(16)); 

        $updateSql = "UPDATE productstock SET qr_token = ? WHERE productID = ? AND sizeID = ?";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$token, $productID, $sizeID]);

        $verifyUrl = getVerificationUrl($productID, $sizeID, $token);

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($verifyUrl)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10)
            ->build();

        $filePath = __DIR__ . "/../../../qrcode/product_{$productID}_size_{$sizeID}.png";
        $result->saveToFile($filePath);

        return true;
    } catch (Exception $e) {

        return false;
    }
}
function getVerificationUrl($productID, $sizeID, $token): string {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

    $host = $_SERVER['HTTP_HOST'];

    $path = "/pages/admin/product/verify-stock.php";

    $query = http_build_query([
        'productID' => $productID,
        'sizeID' => $sizeID,
        'token' => $token
    ]);

    return $protocol . $host . $path . "?" . $query;
}
