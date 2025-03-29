<?php
require '../../_base.php';

$stylesheetArray = ['product.css'];
$title = 'Product List';

// function link_stylesheet($stylesheetArray) {
//   if (!$stylesheetArray) {
//       return;
//   }
// }
//   $time = time();

//   if (is_array($stylesheetArray)) {
//       foreach ($stylesheetArray as $stylesheet) {
//           echo "<link rel='stylesheet' href='$stylesheet?v=$time' />";
//       }
//   } 

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
<div class="sidebar">
  <div class="sidebarFont">
    <ul>
      <h>Series</h>
      <hr>
      <?php foreach ($seriesArray as $s): ?>
        <a onclick="onclick()" href="../product/searchResult.php?search=<?php echo $s->seriesName ?>">
          <p><?php echo "$s->seriesName" ?></p>
        </a>
      <?php endforeach ?>
      <hr>
      <h>Price Sorting</h>
      <hr>
      <form method="get" action="../product/searchResult.php?price=LowToHigh">
        <p>Low -> High</p>
      </form>
      <form method="get" action="../product/searchResult.php?price=HighToLow">
        <p>High -> Low</p>
      </form>
      <hr>
    </ul>
  </div>
</div>


<div class="main-container">
  <form method="get" action="../product/searchResult.php?search=?">
    <div class="searchContainer">
      <input type="text" id="search" name="search" maxlength="30" class="input" placeholder="S E A R C H">
    </div>
    <div class="searchButton">
      <button><img src="illustration-magnifying-glass-icon.png"></button>
    </div>
  </form>


  <!-- TopSide Menu -->
  <!-- <div class="menu">
        <nav>
            <div class="top-sideMenu">
                <ul>
                    <div class="logo">
                    <img src="logo.jpg" width="125px">
                    </div>
                    <li><a onclick ="onClick()" href="../product/product.php"><strong>Home</strong></a></li>
                    <li><a onclick ="onClick()" href="../product/productlist.php"><strong>Products</strong></a></li>
                    <li><a href="#popup"><div id="cart"><img id="open-popup" src="illustration-shopping-online.png" alt="Cart" width="50" style="cursor: pointer;"></div></a></li>
                </ul>
            </div>
            <div id="popup" class="popup">
                <div class="popup-content">
                    <a href="#" class="close">&times;</a>
                    <h2>Shopping Cart</h2>
                    <p>Your cart is empty.</p>
                </div>
            </div>
        </nav>
    </div> -->

  <!-- Nanoflare 1000z image -->
  <div class="image-box">
    <img src="aerosharp ad2.jpg" alt="Nanoflare 700 RISING">
  </div>

  <hr>

  <!-- product Image -->
  <?php
  $_db = new PDO('mysql:dbname=web_based_assignment', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
  ]);

  $statement = $_db->prepare("SELECT * FROM product");
  $statement->execute([]);
  $productObjectArray = $statement->fetchAll();
  $statementImg = $_db->prepare("SELECT * FROM product_images WHERE image_type = 'product'");
  $statementImg->execute([]);
  $productObjectArrayImg = $statementImg->fetchAll();
  ?>

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
                  <img width="150px" height="250px" id="productImage" src="../../../File/<?php echo  $productObject->productImg; ?>" alt="Product Image" />
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
                <div class="btn"><button class="btn">Add to Cart</button></div>
                <div class="btn"><button class="btn">Buy</button></div>
                <div class="btn"><button class="btn" onclick="window.location.href='../product/productDetail.php?racket=<?php echo $productObject->productID ?>'">View Details</button></div>
                <!--<?php if (!$userID) {
                      prompt_login("Please log in to add to cart.");
                    }
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

<?php
include '../../_foot.php';

// <!-- label filter value -->
//     <form>
//       <label for="series">Choose a series:</label>
//        <select id="series" name="series" onchange="filterProducts()">
//           <option value="All">All products</option>
//           <option value="Ast">Astrox</option>
//           <option value="Nnf">Nanoflare</option>
//           <option value="Arc">Arcsaber</option>
//         </select>
//     </form>

// <script>
//     function filterProducts() {
//         var selectedSeries = document.getElementById("series").value;
//         var products = document.querySelectorAll(".item");

//         products.forEach(function(product) {
//             if (selectedSeries === "All") {
//                 product.style.display = "block"; // Show all products
//             } else {
//                 if (product.getAttribute("data-series") === selectedSeries) {
//                     product.style.display = "block"; // Show matching products
//                 } else {
//                     product.style.display = "none"; // Hide non-matching products
//                 }
//             }
//         });
//     }
// </script> 
