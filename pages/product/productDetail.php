<?php
$stylesheetArray = ['product.css'];
$title = 'Product List';
require '../../_base.php';

// get the racket id from url
if (isset($_GET['racket'])) {
  $productID = $_GET['racket'];
}

// database
$_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

// SQL query
$statement = $_db->prepare("SELECT * FROM product WHERE productID = ?");
$statement->execute([$productID]);
$productObject = $statement->fetch();

// get product image
$stm = $_db->prepare("SELECT * FROM product_images WHERE productID = ? AND image_type = 'product'");
$stm->execute([$productID]);
$productImg = $stm->fetch();

// get player image
$stmm = $_db->prepare("SELECT * FROM product_images WHERE productID = ? AND image_type = 'player'");
$stmm->execute([$productID]);
$playerImg = $stmm->fetch();

if (!$productObject) {
  echo "Error: Undefined racket";
  // redirect('/');
}

$racketID = $productObject->productID;
$racketName = $productObject->productName; // Get the productName attribute of the product object
$price = $productObject->price; // Get the price attribute of the product object
$imgUrl = $productImg->image_path;
$intro = $productObject->introduction;
$playerInfo = $productObject->playerInfo;
$playerImg = $playerImg->image_path;

// get grip size from url
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
    $available = $_db->prepare("SELECT * FROM productstock WHERE productID = ? AND sizeID = ? AND stock > 0");
    $available->execute([$productID, $gripSize]);
    $productObj = $available->fetch();
    $productQuantity = $productObj->stock;

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
    prompt_user_login("Please log in to add to cart.");
    // temp('warn', 'Please login before add item to cart');
  }
}

include '../../_head.php';
?>


<body>
  <div class="detailPage-main-container">
    <!-- <div class="info"><?= temp("info"); ?></div>
<div class="error"><?= temp("error"); ?></div>
<div class="error"><?= temp("login"); ?></div> -->

    <!-- racket information -->
    <div class="image-container">
      <a class="prev" onclick="prevSlides(-1, 1)">&#10094;</a>
      <div class="product">
        <!-- racket image -->
        <div class="mySlides"><img src="../../../File/<?php echo $imgUrl; ?>" alt="Image"></div>
        <div class="mySlides"><img src="badmintonRacket.jpg" alt="Image2"></div>
        <div class="mySlides"><img src="badmintonRacket2.jpg" alt="Image3"></div>
      </div>
      <a class="next" onclick="nextSlides(1, 1)">&#10095;</a>
    </div>

    <!-- mutliple image slide-->
    <script>
      let slideIndex = 0;

      function showSlides(n) {
        const slides = document.getElementsByClassName("mySlides");
        if (n >= slides.length) slideIndex = 0;     // reset slide index
        if (n < 0) slideIndex = slides.length - 1;  // move to last index
        for (let i = 0; i < slides.length; i++) {   // display all the image to none
          slides[i].style.display = "none";
        }
        slides[slideIndex].style.display = "block"; // and then display one image
      }

      showSlides(slideIndex);

      function nextSlides(n) {
        showSlides(slideIndex += n);
      }

      function prevSlides(n) {
        showSlides(slideIndex -= n);
      }

    </script>

    <div class="detail">
      <div class="racketName"><?php echo $racketName ?></div>
      <div class="price"><?php echo "RM " ?>
        <?php echo $price ?><?php echo ".00" ?></div>
      <div class="information">
        <table>
          <tr>
            <th>Grip</th>
            <td>3UG5/4UG5</td>
          </tr>
          <br>
          <tr>
            <th>Joint</th>
            <td>T-joint</td>
          </tr>
          <br>
          <tr>
            <th>Texture</th>
            <td>Full-carbon</td>
          </tr>
          <br>
          <tr>
            <th>Item ID</th>
            <td><?php echo $productID ?></td>
          </tr>
        </table>
      </div>

      <!-- add to cart button -->
      <form method="get" class="addToCartForm">
        <div class="AddCart">

          <div class="radios">
            <div class="radioOne">
              <input type="radio" id="gripSize" name="gripSize" value='3UG5'>
              <label for="gripSize">
                <strong>
                  <span>3UG5</span>
                </strong>
              </label>
            </div>
            <div class="radioTwo">
              <input type="radio" id="gripSize" name="gripSize" value='4UG5'> <label for="gripSize"><strong>
                  <span>4UG5</span>
                </strong></label>
            </div>
          </div>

          <button type="submit" id="racket" name="racket" value="<?php echo $productObject->productID ?>">Add To Cart</button>
        </div>
      </form>

      <hr>

      <div class="introduction">
        <p>Racket Introduction ↓</p>
        <?php echo $intro ?>
      </div>


      <!-- player information -->
      <div class="playerPhoto">
        <img src="../../../File/<?php echo $playerImg; ?>" alt="PlayerImage">
        <div class="HeadingIntro">
          <?php echo "The player who is using this racket" ?>
        </div>
        <br>
        <?php echo $playerInfo; ?>
      </div>
    </div>



    <?php
    $size = $_db->prepare("SELECT * FROM productStock WHERE productID = ?");
    $size->execute([$productID]);
    $productObject = $size->fetchAll();
    ?>
  </div>
</body>
<?php
include '../../_foot.php';
