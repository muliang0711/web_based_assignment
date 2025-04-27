<?php
require __DIR__ . '/../../../db_connection.php'; 
include_once __DIR__ . '/../../../vendor/autoload.php'; 
require_once __DIR__ . '/../../../_base.php';
include_once __DIR__ . "/../../../admin_login_guard.php";

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

// --- QR code generate function ---
function generateQRCode($pdo, $productID, $sizeID) {
    try {
        $checkSql = "SELECT qr_token FROM productstock WHERE productID = ? AND sizeID = ?";
        $stmt = $pdo->prepare($checkSql);
        $stmt->execute([$productID, $sizeID]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);  // ✅ 修正成 FETCH_ASSOC (array)

        if ($existing && !empty($existing['qr_token'])) {  // ✅ 现在用 array取值，正确
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
        error_log("QR Generation Error: " . $e->getMessage());
        return false;
    }
}

// --- Helper: Generate Verification URL ---
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

// --- Handle AJAX POST request ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "SELECT productID, sizeID FROM productstock WHERE qr_token IS NULL";
        $stmt = $_db->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ 这里也统一用 array

        foreach ($products as $product) {
            generateQRCode($_db, $product['productID'], $product['sizeID']);
        }

        echo "✅ All missing QR Codes have been generated successfully.";
    } catch (Exception $e) {
        echo "❌ Failed to generate QR Codes: " . $e->getMessage();
    }
    exit; // Only return text for AJAX
}
?>

<!-- HTML PAGE PART -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate All QR Codes</title>
    <script>
        async function generateAllQR() {
            if (!confirm("Are you sure you want to generate all missing QR codes?")) {
                return;
            }

            const button = document.getElementById('generateBtn');
            button.disabled = true;
            button.innerText = "Generating...";

            try {
                const response = await fetch('', { method: 'POST' });
                const result = await response.text();
                alert(result);
                window.location.reload(); // 自动刷新页面
            } catch (error) {
                alert('❌ Error generating QR codes!');
            } finally {
                button.disabled = false;
                button.innerText = "Generate All QR Codes";
            }
        }
    </script>
</head>
<body style="background-color: #f2f2f2; font-family: Arial, sans-serif; text-align: center; padding-top: 100px;">
    <h1>🔵 Generate All Product QR Codes</h1>
    <button id="generateBtn" onclick="generateAllQR()" style="padding: 15px 30px; font-size: 18px; cursor: pointer;">
        Generate All QR Codes
    </button>
</body>
</html>
