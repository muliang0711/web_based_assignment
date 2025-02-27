<?php
// This is a test to see if I can connect to the database successfully. 
// Works fine on 21/2/2025 :)
// Note to self (this applies to lh only since this is different for every device): use `myproject.local/<path-to-file>`.

$servername = "localhost"; // Your database server (for XAMPP, it's usually localhost)
$username = "root"; // Your MySQL username (default for XAMPP is root)
$password = ""; // Your MySQL password (default for XAMPP is empty)
$dbname = "test"; // Replace with the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";

?>