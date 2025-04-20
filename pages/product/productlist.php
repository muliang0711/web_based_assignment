<?php
require '../../_base.php';
$currentPage = req('page',1);
$stylesheetArray = ['product.css','pager.css'];
$title = 'Product List';
global $order;

// default price range 
global $min_price;
global $max_price;

$min_price = req('min');
$max_price = req('max');

// default ascending
if(req('dir')){
  $order = req('dir');
  }else{
    $order = "asc";
  }

// Switch values if min > max
if ($min_price > $max_price) {
  $temp = $max_price;
  $max_price = $min_price;
  $min_price = $temp;
}

// Set to default if no value
if (!$min_price || $min_price < 0) {
  $min_price = 0;
}
if (!$max_price) {
  $max_price = 10000;
}

// Get product data from database
$_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);
$statement = $_db->prepare("SELECT * FROM product");
$statement->execute([]);
$productObjectArray = $statement->fetchAll();
$seriesStatement = $_db->prepare("SELECT * FROM series");
$seriesStatement->execute([]);
$seriesArray = $seriesStatement->fetchAll();

// Verify user
if (is_logged_in("user")) {
  global $_db;
  global $_user;
  $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
  $userID = $_user->userID;
} else {
  $userID = null;
}

include '../../_head.php';
?>

<body>
<!------------------------------------------------------------------------------------------------------------------------------------------------>
<!-- Side bar -->
<div class="sidebar">
  <div class="sidebarFont">
      <h>Series</h>
      <hr>
      <?php foreach ($seriesArray as $s): ?>
        <a onclick="onclick()" href="../product/searchResult.php?search=<?php echo $s->seriesName ?>&dir=<?php echo $order ?>&page=<?php echo $currentPage ?>&min=<?php echo $min_price?>&max=<?php echo $max_price?>">
          <p><?php echo "$s->seriesName" ?></p>
        </a>
      <?php endforeach ?>
      <hr>
      <h>Price Sorting</h>
      <hr>
      <div class="sorting" ?>
      <a onclick="onclick()" href="../product/productlist.php?dir=asc&page=<?php echo $currentPage ?>&max=<?php echo $max_price ?>&min=<?php echo $min_price ?>">
        <p>Low to High</p>
      </a>
      <a onclick="onclick()" href="../product/productlist.php?dir=desc&page=<?php echo $currentPage ?>&max=<?php echo $max_price ?>&min=<?php echo $min_price ?>">
        <p>High to Low</p>
      </a>
      </div>
      <hr>
      <h>Price Range</h>
      <hr>
      <form method="get" class="priceRangeForm" name="priceRange"> 
      <input type="number" class="priceRange" name="min" id="min" min="0" placeholder="RM MIN"> -
      <input type="number" class="priceRange" name="max" id="max" min="0" placeholder="RM MAX">
      <input type="hidden" id="dir" name="dir" value=<?php echo $order ?>>
      <input type="hidden" id="page" name="page" value=<?php echo $currentPage ?>>
      <button type="submit" class="applyButton">Apply</button>
      </form> 
      <script src="validatePriceRange.js"></script>
      <hr>
  </div>
</div>


<?php 
/*
$order = isset($_GET['dir']) && $_GET['dir'] == 'desc' ? 'DESC' : 'ASC'; */?>

 
<div class="main-container">
  <form method="get" action="../product/searchResult.php?search=?">
    <div class="searchContainer">
      <input type="text" id="search" name="search" maxlength="30" class="input" placeholder="S E A R C H">
    <div class="searchButton">
      <button><img src="illustration-magnifying-glass-icon.png"></button>
    </div>
    </div>
  </form>

  <!-- show price range -->
  <div class="priceRangeOutput">
  <?php
   echo "Price Range: RM"; echo $min_price; echo " - RM" ;echo $max_price;
  ?>

  </div>
  <!-- ad image -->
  <div class="image-box">
    <img src="aerosharp ad2.jpg" alt="Ad image">
  </div>

  <hr>

  <!-- product Image -->
  <?php
  $_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
  ]);
  ?>

<!--   pagination   -->
   <?php
   require_once __DIR__ . '\SimplePager.php';
   $page = req('page',1);
   // Reminder: the `limit` parameter of the SimplePager constructor must be a string, e.g. "10". Can't pass an int due to the use of ctype_digit(). This behavior seems to be deliberate (look up the constructor definition), which makes it weirder. 
   // I see.
   $p = new SimplePager(
    "SELECT * FROM product 
    JOIN product_images 
    USING (productID) 
    WHERE image_type = 'product' 
    AND price BETWEEN $min_price AND $max_price 
    ORDER BY price $order",
    [],
    "6", // Reminder: the `limit` parameter of the SimplePager constructor must be a string, e.g. "10". Can't pass an int due to the use of ctype_digit(). This behavior seems to be deliberate (look up the constructor definition), which makes it weirder. 
    $page
  );
   $arr = $p->result;
  //  var_dump($arr);
   echo "<br>"; 
   if (isset($search)) {
     $p->html("dir=$order&search=$search&min=$min_price&max=$max_price");
   } 
   else {
     $p->html("dir=$order&min=$min_price&max=$max_price");
   }
   ?>

<!-- product listing -->
  <div class="list" id="productList">
    <?php
      foreach ($arr as $productObject): ?>
        <!-- start -->
        <div class="container">
        <!-- top side  -->
        <div class="product-card">
          <div class="top-side">
            <div class="true-card">
              <div class="picture-card">
                <div class="picture">
                  <img width="150px" height="250px" id="productImage" src="../../../File/<?php echo  $productObject->image_path; ?>" alt="Product Image" />
                </div>
              </div>
            </div>
          </div>
          <!-- middle side  -->
          <div class="middle-side">
            <div class="true-card">
              <div class="information">
                <div class="product-name dsc">
                  <h2><?php echo $productObject->productName ?></h2>
                </div>
                <div class="product-series-name dsc"><span>
                    <p>RM <?php echo $productObject->price ?>.00</p>
                  </span></div>
                <div class="size-id dsc"><span>3UG5 / 4UG5</span></div>
              </div>
            </div>
          </div>
          <!-- bottom side  -->
          <div class="bottom-side">
            <div class="true-card">
              <div class="function">
           <!-- <div class="btn"><button class="btn">Add to Cart</button></div>
                <div class="btn"><button class="btn">Buy</button></div> -->
                <div class="btn"><button class="btn" onclick="window.location.href='../product/productDetail.php?racket=<?php echo $productObject->productID ?>'">View Details</button></div>
                <!--<?php //if (!$userID) {
                      //prompt_user_login("Please log in to add to cart.");
                    //}
                    ?> -->
              </div>
            </div>
          </div>
        </div>
        <!-- the end  -->
      </div>

    <?php endforeach ?>
  </div>
</div>
</body>
<?php
include '../../_foot.php';

