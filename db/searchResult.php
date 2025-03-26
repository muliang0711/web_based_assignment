<?php 
 include_once __DIR__ . '/../_base.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        // 1. searchText ?  echo none  : echo result
        
        if(isset($_GET['searchText']) && !empty(is_get($searchText))){
             // 1.1 searchResult ? echo none : echo result
             if(isset($_GET['searchResult']) && !empty(is_get($searchResult))){
                $searchText = $_GET['searchText'] ;
                $searchResult = $_GET['searchResult'] ;

                // 2. html page : 


             }
        }else{

        }
    ?>
</body>
</html>