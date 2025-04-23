<?php
$stylesheetArray = ['product.css', 'pager.css'];
$title = 'Product List';
require '../../_base.php';
include '../../_head.php';
global $search;
global $order;
global $min_price;
global $max_price;

$min_price = req('min');
$max_price = req('max');


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

$search = req('search');


$seriesStatement = $_db->prepare("SELECT * FROM series");
$seriesStatement->execute([]);
$seriesArray = $seriesStatement->fetchAll();
$currentPage = req('page', 1);
?>

<body>

  <!-- Side bar -->
  <div class="sidebar">
    <div class="sidebarFont">
      <h>Series</h>
      <hr>
      <?php foreach ($seriesArray as $s): ?>
        <a onclick="onclick()" href="../product/searchResult.php?search=<?php echo $s->seriesName ?>&dir=<?php echo $order ?>&page=<?php echo $currentPage ?>&min=<?php echo $min_price ?>&max=<?php echo $max_price ?>">
          <p><?php echo "$s->seriesName" ?></p>
        </a>
      <?php endforeach ?>
      <hr>
      <h>Price Sorting</h>
      <hr>
      <div class="sorting" ?>
        <a onclick="onclick()" href="../product/searchResult.php?dir=asc&page=<?php echo $currentPage ?>&search=<?php echo $search ?>&min=<?php echo $min_price ?>&max=<?php echo $max_price ?>">
          <p>Low to High</p>
        </a>
        <a onclick="onclick()" href="../product/searchResult.php?dir=desc&page=<?php echo $currentPage ?>&search=<?php echo $search ?>&min=<?php echo $min_price ?>&max=<?php echo $max_price ?>">
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
        <input type="hidden" id="search" name="search" value=<?php echo $search ?>>
        <button type="submit" class="applyButton">Apply</button>
      </form>
      <hr>
    </div>
  </div>


  <!-- Search bar -->
  <div class="main-container">
    <div class="top-sideFunction">
      <form method="get" action="../product/searchResult.php?search=?">
        <div class="searchContainer">
          <input type="text" id="search" name="search" maxlength="30" class="input" placeholder="<?php echo $search ?>">
          <div class="searchButton">
            <button><img src="illustration-magnifying-glass-icon.png"></button>
          </div>
        </div>
      </form>


      <!--   pagination   -->
      <?php
      require_once __DIR__ . '\SimplePager.php';
      $page = req('page', 1);
      // Reminder: the `limit` parameter of the SimplePager constructor must be a string, e.g. "10". Can't pass an int due to the use of ctype_digit(). This behavior seems to be deliberate (look up the constructor definition), which makes it weirder. 
      $p = new SimplePager("SELECT * FROM product JOIN product_images USING (productID) WHERE image_type = 'product' AND productName LIKE '%$search%' AND price BETWEEN $min_price AND $max_price ORDER BY price $order", [], "3", $page);
      /*$statement->execute(["%$search%"]);
   $productObjectArray = $statement->fetchAll();*/
      $arr = $p->result;
      echo "<br>";

      $p->html("dir=$order&search=$search&min=$min_price&max=$max_price");
      ?>

    </div>

    <!-- show price range -->
    <div class="priceRangeOutput">
      <?php
      echo "Price Range: RM";
      echo $min_price;
      echo " - RM";
      echo $max_price;
      ?>
    </div>

    <!-- Default setting of sorting function -->
    <?php global $order;
    if (req('dir')) {
      $order = req('dir');
    } else {
      $order = "asc";
    } ?>





    <?php
    /* $_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
        $statement = $_db->prepare("SELECT * FROM product JOIN product_images USING (productID) WHERE image_type = 'product' AND productName LIKE ? ORDER BY dir $order");
        $statement->execute(["%$search%"]);
        $productObjectArray = $statement->fetchAll();
        */ ?>

    <?php if ($arr): ?>
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
                  </div>
                </div>
              </div>
            </div>
            <!-- the end  -->
          </div>
        <?php endforeach ?>
      </div>
    <?php else: ?>
      <div class="noResult">
        <p>No result founded!</p>
        <hr>
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
                        <img width="150px" height="250px" id="productImage" src="../../../File/<?php echo  $productObject->image_path ?>" alt="Product Image" />
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
                      <!--<div class="btn"><button class="btn">Add to Cart</button></div>
                          <div class="btn"><button class="btn">Buy</button></div>-->
                      <div class="btn"><button class="btn" onclick="window.location.href='../product/productDetail.php?racket=<?php echo $productObject->productID ?>'">View Details</button></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- the end  -->
            </div>
          <?php endforeach ?>
        </div>
      </div>
    <?php endif ?>
  </div>
</body>
<?php
include '../../_foot.php';
