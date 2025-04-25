<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Send SMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 2rem;
        }

        .sms-form {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sms-form h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        .sms-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .sms-form input,
        .sms-form textarea {
            width: 100%;
            padding: 0.6rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .sms-form button {
            width: 100%;
            padding: 0.7rem;
            border: none;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }

        .sms-form button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <form class="sms-form" method="POST" action="/controller/stockManager.php">
        <h2>Send SMS</h2>

        <label for="phone">Phone Number</label>
        <input type="text" name="phone" id="phone" placeholder="e.g. +60123456789" required>

        <label for="message">Message</label>
        <textarea name="message" id="message" rows="4" placeholder="Type your message here..." required></textarea>

        <button type="submit">Send SMS</button>
        <button type="button" onclick="history.back()" style="margin-top: 1rem ; background-color:rgb(230, 230, 230);"> Back to menu</button>

    </form>

</body>

</html>