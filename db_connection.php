<?php
try {
    $_db = new PDO('mysql:dbname=web_based_assignment;host=localhost', 'root', '',[
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // Enable error reporting
    ]);
}catch (PDOException $e) {
    // Display meaningful error message
    die("Database Connection Failed: " . $e->getMessage());
}

?>