<?php
$stylesheetArray = ['product.css'];
$title = 'Product List';
require '../../_base.php';
include '../../_head.php';
$search = $_REQUEST['search'];
$seriesStatement = $_db->prepare("SELECT * FROM series");
$seriesStatement->execute([]);
$seriesArray = $seriesStatement->fetchAll();
?>

<body>

<div class="sidebar">
    <div class="sidebarFont">
        <ul>
            <h>Series</h>
            <hr>
            <?php foreach ($seriesArray as $s): ?>
                <a onclick="onclick()" href ="../product/searchResult.php?search=<?php echo $s->seriesName ?>" >
                <p><?php echo "$s->seriesName" ?></p>
                </a>
            <?php endforeach ?>
            <hr>
            <h>Price Sorting</h>
            <hr>
            <form method="get" action="../product/searchResult.php?price=LowToHigh">
            <p>Low  ->  High</p>
            </form>
            <form method="get" action="../product/searchResult.php?price=HighToLow">
            <p>High ->  Low</p>
            </form>
            <hr>
        </ul>
    </div>
</div>

    <form method="get" action="../product/searchResult.php?search=?">
        <div class="searchContainer">
            <input type="text" id="search" name="search" maxlength="30" class="input" placeholder="<?php echo $search ?>">
        </div>
        <div class="searchButton">
            <button><img src="illustration-magnifying-glass-icon.png"></button>
        </div>
    </form>
    <?php
    if (!$search) {
        echo "Invalid input!";
    }
    $_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]);
    $statement = $_db->prepare("SELECT * FROM product WHERE productName LIKE ?");
    $statement->execute(["%$search%"]);
    $productObjectArray = $statement->fetchAll();
    ?>
    <?php if ($productObjectArray): ?>
        <div class="list" id="productList">
            <?php
 foreach ($productObjectArray as $productObject): ?>
    <!-- start -->
    <div class="container">
    <!-- top side  -->
        <div class="product-card">
          <div class="top-side">
            <div class="true-card">
              <div class="picture-card">
                <div class="picture">
                  <img width="150px" height="250px" id="productImage" src="<?php echo $productObject->productImg ?>" alt="Product Image" />
                </div>
              </div>
            </div>
          </div>
    <!-- middle side  -->
          <div class="middle-side">
            <div class="true-card">
              <div class="information">
                <div class="product-name dsc"><h2><?php echo $productObject->productName ?></h2></div>
                <div class="product-series-name dsc"><span><p>RM <?php echo $productObject->price ?>.00</p></span></div>
                <div class="size-id dsc"><span>3UG5 / 4UG5</span></div>
              </div>
            </div>
          </div>
    <!-- bottom side  -->
          <div class="bottom-side">
            <div class="true-card">
              <div class="function">
                <div class="btn"><button class="btn">Add to Cart</button></div>
                <div class="btn"><button class="btn">Buy</button></div>
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
                $statement = $_db->prepare("SELECT * FROM product");
                $statement->execute([]);
                $productObjectArray = $statement->fetchAll();
                foreach ($productObjectArray as $productObject): ?>
                            <!-- start -->
        <div class="container">
        <!-- top side  -->
            <div class="product-card">
              <div class="top-side">
                <div class="true-card">
                  <div class="picture-card">
                    <div class="picture">
                      <img width="150px" height="250px" id="productImage" src="<?php echo $productObject->productImg ?>" alt="Product Image" />
                    </div>
                  </div>
                </div>
              </div>
        <!-- middle side  -->
              <div class="middle-side">
                <div class="true-card">
                  <div class="information">
                    <div class="product-name dsc"><h2><?php echo $productObject->productName ?></h2></div>
                    <div class="product-series-name dsc"><span>pending........</span></div>
                    <div class="size-id dsc"><span>3UG5 / 4UG5</span></div>
                  </div>
                </div>
              </div>
        <!-- bottom side  -->
              <div class="bottom-side">
                <div class="true-card">
                  <div class="function">
                    <div class="btn"><button class="btn">Add to Cart</button></div>
                    <div class="btn"><button class="btn">Buy</button></div>
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
</body>
<?php
include '../../_foot.php';
