<!DOCTYPE html>
<html lang="en">
</html>
<link rel="stylesheet" href="./product/productlist.php">
<?php
$stylesheetArray = ['product-temp.css'];

function link_stylesheet($stylesheetArray) {
  if (!$stylesheetArray) {
      return;
  }
}
  $time = time(); 
  
  if (is_array($stylesheetArray)) {
      foreach ($stylesheetArray as $stylesheet) {
          echo "<link rel='stylesheet' href='$stylesheet?v=$time' />";
      }
  } 
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products Home Page</title>
  </head>

<div class="container">.
  <body>
    <div class="menu">
      <nav>
        <!-- TopSide Menu -->
        <div class="top-sideMenu">
        <ul>
          <!-- store logo -->
          <div class="logo">
            <img src="logo.jpg" width="125px">
            </div>
            <li><a onclick ="onClick()" href="../product/product.php"><strong>Home</strong></a></li>
          <li><a onclick ="onClick()" href="../product/productlist.php"><strong>Products</strong></a></li>
        </ul>
      </div>
      </nav>
    </div>
 

<?php 
if(isset($_GET['racket'])){
  $productID = $_GET['racket'];
}
$_db = new PDO('mysql:dbname=web_based_assignment','root', '',[
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

$statement = $_db->prepare("SELECT * FROM product WHERE productID = ?");
$statement->execute([$productID]); // make sure your $productID variable is declared - I don’t see it in the screenshot
$productObject = $statement->fetch();
  if(!$productObject){
    echo "Error: Undefined racket";
    redirect('/');
  }


// If $productID is “R0001”, now your $productObject will be {productID: “R0001”, productName: “Yonex Arcsaber 11 Pro”, price: 849.00, seriesID: “ARC”}

$racketName = $productObject->productName; // Get the productName attribute of the product object
$price = $productObject->price; // Get the price attribute of the product object
$imgUrl = $productObject->productImg;
$intro = $productObject->introduction;
$playerInfo = $productObject->playerInfo;
$playerImg = $productObject->playerImage;
?>

<div class="detail">
<div class="product"><img src="<?php echo $imgUrl; ?>" alt="Image"></div>
<div class="racketName"><?php echo $racketName ?></div>
<div class="price"><?php echo "Price:RM "?><?php echo $price?><?php echo ".00" ?><br>
<?php echo "Grip Size: 3UG5/4UG5" ?> <br> <?php echo "Made in Japan" ?> <br>  <?php echo "Item code" ?>  <?php echo $productID ?>
</div>
</div>
<div class="introduction">
<?php echo $intro ?>
  </div>
</div>
<div class="addtoCart"><button>Add to Cart<span class="shadow"></span></button></div>
<hr>

<div class="playerPhoto"> 
  <div class= "HeadingIntro"> 
<?php echo "The player who is using this racket" ?></div><br>
<?php echo $playerInfo; ?>
<img src="<?php echo $playerImg; ?>" alt="PlayerImage">
</div>
</body>
