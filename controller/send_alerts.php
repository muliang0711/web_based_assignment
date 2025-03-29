<?php
require __DIR__ . "/../vendor/autoload.php" ;  // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendLowStockEmail($toEmail, $productName, $stock, $threshold) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'puihy-wm24@student.tarc.edu.my';   // ✅ 改成你自己的 Gmail
        $mail->Password = 'mqps lalr ujvo fbqx';      // ✅ Gmail 的 16 位 App 密码
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('puihy-wm24@student.tarc.edu.my', 'Inventory Alert');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Low Stock Alert: $productName";
        $mail->Body = "
            <p><strong>Product:</strong> $productName</p>
            <p><strong>Current Stock:</strong> $stock</p>
            <p><strong>Threshold:</strong> $threshold</p>
            <p>Please restock soon!</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email error: " . $mail->ErrorInfo);
        return false;
    }
}

// ✅ 调用函数进行测试
if (sendLowStockEmail('puihy-wm24@student.tarc.edu.my', 'Apple iPhone 15', 2, 5)) {
    echo "✅ Test email sent successfully!";
} else {
    echo "❌ Failed to send test email.";
}
