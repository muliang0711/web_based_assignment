<!DOCTYPE html>
<html lang="en">
</html>

<?php
$stylesheetArray = ['product.css'];

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['series'])) {
        $selected_series = $_POST['series'];
        echo "You selected: " . htmlspecialchars($selected_series);
    } else {
        echo "No series selected.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['series' == 'Arc'])) {
        echo "<img src='" . htmlspecialchars($imageSrc) . "' width='300' alt='Product Image'>";
    }
}?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products List</title>
  </head>

<body>
      <!-- TopSide Menu -->
      <div class="menu">
        <nav>
          <div class="top-sideMenu">
            <ul>
                <!-- store logo -->
                 <div class="logo">
                   <img src="logo.jpg" width="125px">
                 </div>
                <!-- Menu button -->
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
      </div>
      <!-- Nanoflare 1000z image -->
    <div class="image-box">
        <img src="https://www.yonex.com/media/scandiweb/slider/n/a/nanoflare1000pc.png" alt="Nanoflare 700 RISING">
    </div>
    
    <hr>
<!-- label filter value -->
<!--
    <form>
      <label for="series">Choose a series:</label>
       <select id="series" name="series" onchange="filterProducts()">
          <option value="All">All products</option>
          <option value="Ast">Astrox</option>
          <option value="Nnf">Nanoflare</option>
          <option value="Arc">Arcsaber</option>
        </select>
    </form>

<script>
    function filterProducts() {
        var selectedSeries = document.getElementById("series").value;
        var products = document.querySelectorAll(".item");

        products.forEach(function(product) {
            if (selectedSeries === "All") {
                product.style.display = "block"; // Show all products
            } else {
                if (product.getAttribute("data-series") === selectedSeries) {
                    product.style.display = "block"; // Show matching products
                } else {
                    product.style.display = "none"; // Hide non-matching products
                }
            }
        });
    }
</script>
-->

<!-- product Image -->
    <?php 
      $_db = new PDO('mysql:dbname=web_based_assignment','root', '',[
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      ]);
      
    $statement = $_db->prepare("SELECT * FROM product");
    $statement->execute([]);
    $productObjectArray = $statement->fetchAll();
    ?>
    
    <div class="list" id="productList">
      <?php     
      foreach($productObjectArray as $productObject):?>
         <div class="item" series="Arc">
           <a onclick = "onclick()" href = "../product/productDetail.php?racket=<?php echo $productObject->productID ?>">
            <img src="<?php echo $productObject->productImg ?>">
           <p><?php echo $productObject->productName ?></p>
           </a>
         </div>
      <?php endforeach ?>
    </div>
</body> 