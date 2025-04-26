<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Compose Email</title>
    <style>
        form {
            max-width: 600px;
            margin: 50px auto;
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 0.8rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
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
