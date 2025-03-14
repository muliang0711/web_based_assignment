<?php
require '../../_base.php';

$stylesheetArray = ['product.css'];
$title = 'Product List';
?>

<body>
<form method="get" action="../product/searchResult.php?search=?">
    <div class="searchContainer">
     <input type="text" id="search" name="search" maxlength="30" class="input" placeholder="S E A R C H">
    </div>
   <button><img src="illustration-magnifying-glass-icon.png"></button>
</form> 
    <?php
        $search = $_REQUEST['search'];
        if(!$search){
            echo "Invalid input!";
        }
        $_db = new PDO('mysql:dbname=web_based_assignment','root', '',[
                   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
            $statement = $_db->prepare("SELECT * FROM product WHERE productName LIKE ?");
            $statement->execute(["%$search%"]); 
            $productObjectArray = $statement->fetchAll();
    ?>
    <div class="userInput">
        <h>Input result " <?php echo $search ?> "</h>
    </div>
    <?php if($productObjectArray):?>
        <div class="list" id="productList">
    <?php     
      foreach($productObjectArray as $productObject):?>
         <div class="item">
          <a onclick = "onclick()" href = "../product/productDetail.php?racket=<?php echo $productObject->productID ?>">
          <img src="<?php echo $productObject->productImg ?>">
          <p><?php echo $productObject->productName ?></p>
          </a>
         </div>
      <?php endforeach ?>
      </div>
      <?php else: ?>
        <p>No result founded!</p>
    <?php endif ?>
</body> 