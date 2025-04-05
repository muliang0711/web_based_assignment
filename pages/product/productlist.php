<?php
require '../../_base.php';
$currentPage = req('page',1);
$stylesheetArray = ['product.css','pager.css'];
$title = 'Product List';
global $order;
// default price range 
global $min_price;
global $max_price;
if(!req('min')){
  $min_price = 0;
}
if(!req('max')){
  $max_price = 10000;
}

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


<!-- Side bar -->
<div class="sidebar">
  <div class="sidebarFont">
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
      <form method="get" name="priceRange" action="../product/productlist.php?dir=<?php if(!$order){ echo "asc";}else{echo $order;} ?>&page=<?php echo $currentPage ?>&min=<?php echo $min_price?>&max=<?php echo $max_price?>"> 
      <input type="number" class="priceRange" name="min" id="min" placeholder="RM MIN"> -
      <input type="number" class="priceRange" name="max" id="max" placeholder="RM MAX">
      <button type="submit" class="applyButton">Apply</button>
      </form> 
      <hr>
  </div>
</div>

<!-- get price range -->
<?php 
$min_price = isset($_GET['min']) ? $_GET['min'] : 0;
$max_price = isset($_GET['max']) ? $_GET['max'] : 10000;
// verify input
if($min_price){
  if($min_price < 0){
    $min_price = 0;
  }else{
    $min_price = req('min');
  }
}

if($max_price){
  if($min_price > $max_price){
    $max = 10000;
    $min = 0;
  }
}
?>

<!-- ascending for product list -->
<?php 
if(req('dir')){
$order = req('dir');
}else{
  $order = "asc";
}/*
$order = isset($_GET['dir']) && $_GET['dir'] == 'desc' ? 'DESC' : 'ASC'; */?>
<!-- ========================== -->
 
<div class="main-container">
  <form method="get" action="../product/searchResult.php?search=?">
    <div class="searchContainer">
      <input type="text" id="search" name="search" maxlength="30" class="input" placeholder="S E A R C H">
    <div class="searchButton">
      <button><img src="illustration-magnifying-glass-icon.png"></button>
    </div>
    </div>
  </form>


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
/*
  $statement = $_db->prepare("SELECT * FROM product JOIN product_images USING (productID) WHERE image_type = 'product' ORDER BY dir $order");
  $statement->execute([]);
  $productObjectArray = $statement->fetchAll();   */
  ?>

<!-- ============== -->
<!--   pagination   -->
   <?php
   require_once 'D:\user\Documents\web_based_assignment\pages\product\SimplePager.php';
   $page = req('page',1);
   $p = new SimplePager("SELECT * FROM product JOIN product_images USING (productID) WHERE image_type = 'product' AND price BETWEEN $min_price AND $max_price ORDER BY price $order",[],3,$page);
   $arr = $p->result;
   ?>
   <br>
   <?= $p->html() ?>
<!-- ============== -->




<!-- =============== -->
<!-- product listing -->
<!-- =============== -->
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
