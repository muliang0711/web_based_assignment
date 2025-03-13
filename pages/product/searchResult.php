<?php
                  $_db = new PDO('mysql:dbname=web_based_assignment','root', '',[
                  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                  ]);
                  $productName = '';
                  echo "<input type='search' id='search' name='search' value='$productName' placeholder='      Search..'>";
                  $statement = $_db->prepare("SELECT * FROM product WHERE productName LIKE ?");
                  $statement->execute(["%$productName%"]); 
                  $productObject = $statement->fetch("productID");
                  ?>