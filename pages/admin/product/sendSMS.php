
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Send SMS</title>
</head>
    <link rel="stylesheet" href="css/sendSMS.css">
<body>

    <?php if (!empty($_SESSION['SMSSuccess'])): ?>
    <div class="success-message"><?= $_SESSION['SMSSuccess']; unset($_SESSION['SMSSuccess']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['SMSError'])): ?>
    <div class="error-message"><?= $_SESSION['SMSError']; unset($_SESSION['SMSError']); ?></div>
    <?php endif; ?>

    <form class="sms-form" method="POST" action="/controller/stockManager.php">
        <h2>Send SMS</h2>
        <input type="hidden" name="action" value="sendSMS">
        <label for="phone">Phone Number</label>
        <input type="text" name="phone" id="phone" placeholder="e.g. +60123456789" required>

        <label for="message">Message</label>
        <textarea name="message" id="message" rows="4" placeholder="Type your message here..." required></textarea>

        <button type="submit">Send SMS</button>
        <button type="button" onclick="history.back()" style="margin-top: 1rem ; background-color:rgb(230, 230, 230);"> Back to menu</button>

    </form>

</body>

</html>