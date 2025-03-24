<?php
$stylesheetArray = ['product.css'];
$title = 'Product List';
require '../../_base.php';

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
$racketID = $productObject->productID;
$racketName = $productObject->productName; // Get the productName attribute of the product object
$price = $productObject->price; // Get the price attribute of the product object
$imgUrl = $productObject->productImg;
$intro = $productObject->introduction;
$playerInfo = $productObject->playerInfo;
$playerImg = $productObject->playerImage;

$gripSize = get("gripSize");
if (is_logged_in("user")) {
  global $_db;
  global $_user;
  $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
  $userID = $_user->userID;
} else {
  $userID = null;
}

if ($gripSize) {
  if ($userID) {
    $available = $_db->prepare("SELECT * FROM productSize WHERE productID = ? AND sizeID = ? AND quantity > 0");
    $available->execute([$productID, $gripSize]);
    $productObj = $available->fetch();
    $productQuantity = $productObj->quantity;

    $cartStatement = $_db->prepare("SELECT * FROM cartitem WHERE userID = ? AND productID = ? AND sizeID = ?");
    $cartStatement->execute([$userID, $productID, $gripSize]);
    $cartObject = $cartStatement->fetch();
    $cartQuantity = $cartObject->quantity;

    if (!$cartQuantity) {
      $cartQuantity = 0;
    }
    if ($productObj && $productQuantity > $cartQuantity) {
      // echo "Added to cart!";
      $cartQuantity += 1;
      if (!$cartObject) {
        $available = $_db->prepare('INSERT INTO cartitem (userID, productID, sizeID, quantity) VALUES(?,?,?,?)');
        $available->execute([$userID, $productID, $gripSize, $cartQuantity]);
      } else {
        $available = $_db->prepare('UPDATE cartitem SET quantity = ? WHERE userID = ? AND productID = ? AND sizeID = ?');
        $available->execute([$cartQuantity, $userID, $productID, $gripSize]);
      }
      temp("info", "Added to cart Successfully!");
      redirect("../product/productDetail.php?racket=$productObj->productID");
    } else {
      temp("error", "Stock unvailable! / Over limit!");
      redirect("../product/productDetail.php?racket=$productObject->productID");
    }
  } else {
    prompt_login("Please log in to add to cart.");
    // temp('warn', 'Please login before add item to cart');
  }
}

include '../../_head.php';
?>



<!-- <div class="info"><?= temp("info"); ?></div>
<div class="error"><?= temp("error"); ?></div>
<div class="error"><?= temp("login"); ?></div> -->

<div class="detail">
  <div class="product"><img src="<?php echo $imgUrl; ?>" alt="Image"></div>
  <div class="racketName"><?php echo $racketName ?></div>
  <div class="price"><?php echo "Price:RM " ?>
  <?php echo $price ?><?php echo ".00" ?></div>
  <div class="information">
  <br>
  <?php echo "Grip Size: 3UG5/4UG5" ?> 
  <br> 
  <?php echo "Made in Japan" ?> 
  <br> 
  <?php echo "Item code" ?> 
  <?php echo $productID ?>
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


<form method="get">
  <div class="AddCart">

    <button type="submit" id="racket" name="racket" value="<?php echo $productObject->productID ?>">Add To Cart</button>
    <div class="radioOne">
      <input type="radio" id="gripSize" name="gripSize" value='3UG5'> <label for="gripSize"><strong>
          <p>3UG5</p>
        </strong></label>
    </div>
    <div class="radioTwo">
      <input type="radio" id="gripSize" name="gripSize" value='4UG5'> <label for="gripSize"><strong>
          <p>4UG5</p>
        </strong></label>
    </div>
  </div>
</form>
<?php
$size = $_db->prepare("SELECT * FROM productSize WHERE productID = ?");
$size->execute([$productID]);
$productObject = $size->fetchAll();
?>
<!--
<?php if ($userID): ?>
<div class="sizeSelect" id="selectSize">
  <div class="popup" id="popup">
    <h2>Select grip size</h2>
    <?php foreach ($productObject as $Obj): ?>
      <a onclick="onclick()" href="../product/productDetail.php?racket=<?php echo $Obj->productID ?>&gripSize=<?php echo $Obj->sizeID ?>">
        <button><?php echo $Obj->sizeID ?></button>
      </a>
    <?php endforeach ?>
    <button onclick="closeSelect()">Close</button>
    <?php else: ?>
      <div class="attention">
      <p>Please login before add to cart!</p>
    </div>
      <?php endif ?>

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
    -->
<?php
include '../../_foot.php';
