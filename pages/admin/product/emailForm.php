<?include_once __DIR__ . "/../../../admin_login_guard.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Compose Email</title>

</head>
    <link rel="stylesheet" href="css/emailForm.css">
<body>


<form method="POST" action="/controller/stockManager.php">
    <input type="hidden" name="action" value="sendEmail">
    <h2>Sending Email</h2>
    
    <label for="to">To:</label>
    <input type="email" name="to" id="to" placeholder="recipient@example.com" required>

    <label for="subject">Subject:</label>
    <input type="text" name="subject" id="subject" placeholder="Enter subject" required>

    <label for="message">Message:</label>
    <textarea name="message" id="message" rows="10" placeholder="Write your message here..." required></textarea>

    <button type="submit">Send</button>

    <button style="color: white;  background-color:rgb(97, 114, 133); "
    onclick="window.location='/pages/admin/product/stock.php'"> Back to Menu </button>
</form>

</body>
</html>
