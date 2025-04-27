<?php
require __DIR__ . '/../../../db_connection.php'; 
include_once __DIR__ . '/../../../vendor/autoload.php'; 
require_once __DIR__ . '/../../../_base.php';
include_once __DIR__ . "/../../../admin_login_guard.php";

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Function to generate QR Code and send email
function generateQRCode($pdo, $productID, $sizeID, $toEmail) {
    try {
        // 1.1 Check if QR already exists
        $checkSql = "SELECT qr_token FROM productstock WHERE productID = ? AND sizeID = ?";
        $stmt = $pdo->prepare($checkSql);
        $stmt->execute([$productID, $sizeID]);
        $existing = $stmt->fetch();

        if ($existing && !empty($existing->qr_token)) {
            return false;
        }

        // 1.2 Generate new token
        $token = bin2hex(random_bytes(16));

        // 1.3 Update the token into database
        $updateSql = "UPDATE productstock SET qr_token = ? WHERE productID = ? AND sizeID = ?";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$token, $productID, $sizeID]);

        // 1.4 Generate QR code image
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

        // 1.5 Send email with QR code
        $subject = "Product QR Code Generated Successfully";
        $message = "Dear User,<br><br>Your product QR code has been generated. Please find the QR code attached.<br><br>Regards,<br>Inventory System";

        sendEmailWithAttachment($toEmail, $subject, $message, $filePath);

        return true;
    } catch (Exception $e) {
        return false;
    }
}

// 2. Function to create verification URL
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

// 3. Function to send email with attachment
function sendEmailWithAttachment($toEmail, $subject, $message, $attachmentPath) {
    $mail = new PHPMailer(true);

    try {
        // 3.1 SMTP server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'puihy-wm24@student.tarc.edu.my'; // your Gmail
        $mail->Password   = 'mqps lalr ujvo fbqx';             // your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // 3.2 Sender and recipient settings
        $mail->setFrom('puihy-wm24@student.tarc.edu.my', 'Inventory System');
        $mail->addAddress($toEmail);

        // 3.3 Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // 3.4 Attach the QR Code
        $mail->addAttachment($attachmentPath);

        // 3.5 Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
