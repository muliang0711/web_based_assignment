

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


<form action="" method="post" enctype="multipart/form-data">

    <input type="text" name="productID">
    <input type="file" name="image[]" id="" multiple >
    <button type="submit"> submit</button>

</form>
</body>
</html>

<?php
require_once "../../db_connection.php";
require_once "../../_base.php";

$pdo = $_db; 

if(is_post()){
       

    
    // validation : 

    if(isset($_FILES['image'])){ // ensure there have file upload 

        // 1. if file is upload than assign to files 

        $files = $_FILES['image'];
        $productID = $_POST['productID'];
        // 2. defind a numb based on it for loop : 

        $filesCount = count($files['name']);

        // loop through the file : 

        for($i = 0 ; $i < $filesCount ; $i++){

        // 
        $fileTmpName = $files['tmp_name'][$i];
        $fileName = $files["name"][$i];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ["jpg", "jpeg", "png"];
        if (!in_array($fileExt, $allowedTypes)) {
            echo "File type not allowed: $fileName<br>";
            continue;
        }

        $newFileName = "product_{$productId}_" . time() . "_$i.$fileExt";
        $targetPath = $uploadDir . $newFileName;

        $pdo->prepare("INSERT INTO product_image (image_path) VALUES ? ");
        $pdo->execute($newFileName);
        }
    }

}
?> 