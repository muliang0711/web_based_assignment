<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");

$url = "https://malaysiapostcode.com/states/Melaka"; 
echo file_get_contents($url);
?>
