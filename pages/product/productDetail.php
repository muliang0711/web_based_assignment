<?php
$stylesheetArray = ['product.css'];
$title = 'Product List';
require '../../_base.php';
include '../../_head.php';
?>


<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Products Detail Page</title>
</head>



<?php
if (isset($_GET['racket'])) {
  $productID = $_GET['racket'];
}
$_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

$statement = $_db->prepare("SELECT * FROM product WHERE productID = ?");
$statement->execute([$productID]); // make sure your $productID variable is declared - I don’t see it in the screenshot
$productObject = $statement->fetch();
if (!$productObject) {
  echo "Error: Undefined racket";
  // redirect('/');
}


// If $productID is “R0001”, now your $productObject will be {productID: “R0001”, productName: “Yonex Arcsaber 11 Pro”, price: 849.00, seriesID: “ARC”}

$racketName = $productObject->productName; // Get the productName attribute of the product object
$price = $productObject->price; // Get the price attribute of the product object
$imgUrl = $productObject->productImg;
$intro = $productObject->introduction;
$playerInfo = $productObject->playerInfo;
$playerImg = $productObject->playerImage;

$gripSize = get("gripSize");
if ($gripSize) {
  $available = $_db->prepare("SELECT * FROM productSize WHERE productID = ? AND sizeID = ? AND quantity > 0");
  $available->execute([$productID, $gripSize]);
  $productObj = $available->fetch();
  if ($productObj) {
    // echo "Added to cart!";
    $available = $_db->prepare('INSERT INTO cartitem (userID, productID, sizeID, quantity +1) VALUES(?,?,?,?)');
    $available->execute([$userID, $productID, $gripSize, $quantity]);
    temp("info", "Added to cart Successfully!");
    redirect("../product/productDetail.php?racket=$productObj->productID");
  } else{
    temp("error", "Stock unvailable!");
    redirect("../product/productDetail.php?racket=$productObject->productID");
  }
}
?>

<div class="info"><?= temp("info"); ?></div>
<div class="error"><?= temp("error"); ?></div>

<div class="detail">
  <div class="product"><img src="<?php echo $imgUrl; ?>" alt="Image"></div>
  <div class="racketName"><?php echo $racketName ?></div>
  <div class="price"><?php echo "Price:RM " ?><?php echo $price ?><?php echo ".00" ?><br>
    <?php echo "Grip Size: 3UG5/4UG5" ?> <br> <?php echo "Made in Japan" ?> <br> <?php echo "Item code" ?> <?php echo $productID ?>
  </div>
</div>
<div class="introduction">
  <?php echo $intro ?>
</div>

<hr>

<div class="playerPhoto">
  <div class="HeadingIntro">
    <?php echo "The player who is using this racket" ?></div><br>
  <?php echo $playerInfo; ?>
  <img src="<?php echo $playerImg; ?>" alt="PlayerImage">
</div>

<div class="AddCart">
  <button onclick="openSelect()">Add To Cart</button>
</div>
<?php
$size = $_db->prepare("SELECT * FROM productSize WHERE productID = ?");
$size->execute([$productID]); // make sure your $productID variable is declared - I don’t see it in the screenshot
$productObject = $size->fetchAll();

?>
<div class="sizeSelect" id="selectSize">
  <div class="popup" id="popup">
    <h2>Select grip size</h2>
    <?php foreach ($productObject as $Obj): ?>
      <a onclick="onclick()" href="../product/productDetail.php?racket=<?php echo $Obj->productID ?>&gripSize=<?php echo $Obj->sizeID ?>">
        <button><?php echo $Obj->sizeID ?></button>
      </a>
    <?php endforeach?>
    <?php if($Obj->quantity > 0){
      
    }
    ?>

    <button onclick="closeSelect()">Close</button>
  </div>
</div>

<script>
  function openSelect() {
    document.getElementById("popup").style.display = "block";
    document.getElementById("selectSize").style.display = "block";
  }

  function closeSelect() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("selectSize").style.display = "none";
  }
</script>

<?php
include '../../_foot.php';
