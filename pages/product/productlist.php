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
                   <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/aa/Logo-Yonex.svg/2560px-Logo-Yonex.svg.png" width="125px">
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


<!-- product Image -->
    <div class="list" id="productList">
      <div class="item" series="Arc">
        <a onclick = "onclick()" href = "../product/productDetail.php?racket=R0001">
        <img src="https://www.yonex.com/media/catalog/product/a/r/arc11-p.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819" alt="Yonex Arcsaber 11 Pro">
       <p>Yonex Arcsaber 11 Pro</p>
        </a>
      </div>

      <div class="item" series="Nnf">
        <a onclick = "onclick()" href = "../product/productDetail.php?racket=R0002">
        <img src="https://www.yonex.com/media/catalog/product/n/a/nanoflare_1000_z.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819" alt="Yonex Nanoflare 1000z">
        <p>Yonex Nanoflare 1000z</p>
        </a>
      </div>

      <div class="item" series="Ast">
        <a onclick = "onclick()" href = "../product/productDetail.php?racket=R0003">
        <img src="https://www.yonex.com/media/catalog/product/3/a/3ax88d-p_076-1_02.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819" alt="Yonex Astrox 88D Pro">
        <p>Yonex Astrox 88D Pro</p>
        </a>
      </div>
    </div>

</body> 