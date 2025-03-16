<?php

require_once "../../db_connection.php";
require_once "../../controller/productController.php";
require_once "../../_base.php";

// Include CSS (if needed, this additional CSS can also be inline as shown below)
$stylesheetArray = ['../../css/admin_product.css'];
link_stylesheet($stylesheetArray);

$productController = new ProductController($_db);
$allProducts = $productController->getAllProducts();

// Retrieve search results from session =====================
$searchProducts = $_SESSION['search_results'] ?? [];
unset($_SESSION['search_results']);

// Retrieve addProduct messages==============================
$Add_SuccessMsg = $_SESSION['Add_SuccessMsg'] ?? null;
unset($_SESSION['Add_SuccessMsg']);

$Add_ErrorMsg = $_SESSION['Add_ErrorMsg'] ?? [];
unset($_SESSION['Add_ErrorMsg']);

// Retrieve updateProduct messages============================
$Update_SuccessMsg = $_SESSION['Update_SuccessMsg'] ?? null ;
unset($_SESSION['Update_SuccessMsg']);

$Update_ErrorMsg = $_SESSION['Update_ErrorMsg'] ?? [];
unset($_SESSION['Update_ErrorMsg']);
//====================\
$Delete_SuccessMsg = $_SESSION['Delete_SuccessMsg'] ?? null ;
unset($_SESSION['Delete_SuccessMsg']);

$Delete_ErrorMsg = $_SESSION['Delete_ErrorMsg'] ?? [];
unset($_SESSION['Delete_ErrorMsg']);
//============================================================

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Management Dashboard</title>
</head>
<body>
  <div class="container">
    <header>
      <h1>Product Management Dashboard</h1>
    </header>
    
    <div class="controls">
      <button id="search" class="btn btn-search">Search</button>
      <button id="add" class="btn btn-add">Add Product</button>
    </div>
    
    <!-- Search Form -->
    <div class="form-container filter-bar">
      <form action="../../controller/productController.php" method="post">
        <input type="hidden" name="action" value="filterProduct">
        
        <label for="productName">Product Name</label>
        <select name="productName" id="productName">
          <option value="">-- Select Product Name --</option>
          <?php foreach ($allProducts as $product) { ?>
            <option value="<?php echo htmlspecialchars($product->productName); ?>">
              <?php echo htmlspecialchars($product->productName); ?>
            </option>
          <?php } ?>
        </select>
        
        <label for="seriesID">Product Series ID</label>
        <select name="seriesID" id="seriesID">
          <option value="">-- Select Series ID --</option>
          <?php foreach ($allProducts as $product) { ?>
            <option value="<?php echo htmlspecialchars($product->seriesID); ?>">
              <?php echo htmlspecialchars($product->seriesID); ?>
            </option>
          <?php } ?>
        </select>

        <label for="productSize">Product Size</label>
        <select name="sizeID" id="sizeID">
          <option value="">-- Select Product Name --</option>
          <?php foreach ($allProducts as $product) { ?>
            <option value="<?php echo htmlspecialchars($product->sizeID); ?>">
              <?php echo htmlspecialchars($product->sizeID); ?>
            </option>
          <?php } ?>
        </select>
        
        <label for="minPrice">Min Price</label>
        <select name="minPrice" id="minPrice">
          <option value="">-- Min Price --</option>
          <?php for ($minPrice = 250 ; $minPrice <= 850; $minPrice += 50) { ?>
            <option value="<?php echo $minPrice; ?>"><?php echo "$" . number_format($minPrice, 2); ?></option>
          <?php } ?>
        </select>
        
        <label for="maxPrice">Max Price</label>
        <select name="maxPrice" id="maxPrice">
          <option value="">-- Max Price --</option>
          <?php for ($maxPrice = 250; $maxPrice <= 2000; $maxPrice += 250) { ?>
            <option value="<?php echo $maxPrice; ?>"><?php echo "$" . number_format($maxPrice, 2); ?></option>
          <?php } ?>
        </select>
        
        <div>
          <button type="submit" class="btn btn-search">Search</button>
          <button type="button" id="cancelSearch" class="btn btn-cancel">Cancel</button>
        </div>
      </form>
    </div>
    
    <!-- Add Product Form -->
    <div class="form-container add-form">
      <form action="../../controller/productController.php" method="post">
        <input type="hidden" name="action" value="addProduct">
        
        <label for="productId">Product ID</label>
        <input type="text" name="productId" id="productId" placeholder="Product ID">
        
        <label for="productNameAdd">Product Name</label>
        <input type="text" name="productName" id="productNameAdd" placeholder="Product Name">
        
        <label for="seriesId">Series ID</label>
        <input type="text" name="seriesId" id="seriesId" placeholder="Series ID">
        
        <label for="seriesName">Series Name</label>
        <input type="text" name="seriesName" id="seriesName" placeholder="Series Name">
        
        <label for="sizeId">Size ID</label>
        <input type="text" name="sizeId" id="sizeId" placeholder="Size ID">
        
        <label for="price">Price</label>
        <input type="text" name="price" id="price" placeholder="Price">
        
        <label for="stock">Stock</label>
        <input type="text" name="stock" id="stock" placeholder="Stock">
        
        <div>
          <button type="submit" class="btn btn-add">Submit</button>
          <button type="button" id="cancelAdd" class="btn btn-cancel">Cancel</button>
        </div>
      </form>
    </div>
    
    <!-- All Products List -->
    <section>
      <h2>All Products</h2>
      <ul class="product-list">
        <?php foreach ($allProducts as $index => $product) { ?>
          <li class="product-card">


            <h3><?php echo htmlspecialchars($product->productName); ?></h3>
            <p><strong>ID:</strong> <?php echo htmlspecialchars($product->productID); ?></p>
            <p><strong>Series ID:</strong> <?php echo htmlspecialchars($product->seriesID); ?></p>
            <p><strong>Series Name:</strong> <?php echo htmlspecialchars($product->seriesName); ?></p>
            <p><strong>Stock:</strong> <?php echo htmlspecialchars($product->total_stock); ?></p>
            <p><strong>Size ID:</strong> <?php echo htmlspecialchars($product->sizeID); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product->price, 2); ?></p>


        <!-- delete form -->
         <div>
         <form action="../../controller/productController.php" method="post" style="display: none;">

            <input type="hidden" name="action" value="deleteProduct" hidden>

            <input type="text" name="productId" value="<?php echo htmlspecialchars($product->productID); ?>" hidden >

            <input type="text" name="productName" value="<?php echo htmlspecialchars($product->productName); ?>"hidden>

            <input type="text" name="seriesId" value="<?php echo htmlspecialchars($product->seriesID); ?>" hidden>

            <label>Series Name</label>
            <input type="text" name="seriesName" value="<?php echo htmlspecialchars($product->seriesName); ?>" hidden>

            <label>Price</label>
            <input type="text" name="price" value="<?php echo number_format($product->price, 2); ?>" hidden>

            <label>Stock</label>
            <input type="text" name="stock" value="<?php echo htmlspecialchars($product->total_stock); ?>" hidden>

            <label>Size ID</label>
            <input type="text" name="sizeId" value="<?php echo htmlspecialchars($product->sizeID); ?>" hidden>

        </form>
         </div>
        

            <button class="btn btn-update updateProductBtn" data-index="<?php echo $index; ?>">Update</button>
            <button type="submit" class="btn btn-delete" data-index="<?php echo $index; ?>"
                data-productid="<?php echo htmlspecialchars($product->productID); ?>"
                data-productname="<?php echo htmlspecialchars($product->productName); ?>"
                data-seriesid="<?php echo htmlspecialchars($product->seriesID); ?>"
                data-seriesname="<?php echo htmlspecialchars($product->seriesName); ?>"
                data-price="<?php echo number_format($product->price, 2); ?>"
                data-stock="<?php echo htmlspecialchars($product->total_stock); ?>"
                data-sizeid="<?php echo htmlspecialchars($product->sizeID); ?>">
              Delete
            </button>
            <!-- Update Form (toggled via JS) -->
            <div class="update-form updateForm-<?php echo $index; ?>">
              <form action="../../controller/productController.php" method="post">
      
                <input type="hidden" name="action" value="updateProduct">
                
                <label>Product ID</label>
                <input type="text" name="productId" value="<?php echo htmlspecialchars($product->productID); ?>" readonly >
                
                <label>Product Name</label>
                <input type="text" name="productName" value="<?php echo htmlspecialchars($product->productName); ?>">
            
                <label>Series ID</label>
                <input type="text" name="seriesId" value="<?php echo htmlspecialchars($product->seriesID); ?>" hidden>

              
                
                <label>Series Name</label>
                <input type="text" name="seriesName" value="<?php echo htmlspecialchars($product->seriesName); ?>" hidden>

                <label>Price</label>
                <input type="text" name="price" value="<?php echo number_format($product->price, 2); ?>">
                
                <label>Stock</label>
                <input type="text" name="stock" value="<?php echo htmlspecialchars($product->total_stock); ?>">
                
                <label>Size ID</label>
                <input type="text" name="sizeId" value="<?php echo htmlspecialchars($product->sizeID); ?>">
                
                <input type="text" name="oldSizeID" value="<?php echo htmlspecialchars($product->sizeID); ?>" hidden>
                

                <div style="margin-top:10px;">
                  <button type="submit" class="btn btn-update">Save Changes</button>

                  <button type="button" class="btn btn-cancel cancelUpdateBtn" data-index="<?php echo $index; ?>">Cancel</button>
                </div>



              </form>
  
            </div>
          </li>
        <?php } ?>
      </ul>
    </section>
    
    <!-- Search Results -->
    <section class="result">
      <h2>Search Results</h2>
      <?php if (!empty($searchProducts)) { ?>
        <ul class="product-list">
          <?php foreach ($searchProducts as $product) { ?>
            <li class="product-card">
            <p><strong>ID:</strong> <?php echo htmlspecialchars($product->productID); ?></p>
            <p><strong>Series ID:</strong> <?php echo htmlspecialchars($product->seriesID); ?></p>
            <p><strong>Series Name:</strong> <?php echo htmlspecialchars($product->seriesName); ?></p>
            <p><strong>Stock:</strong> <?php echo htmlspecialchars($product->total_stock); ?></p>
            <p><strong>Size ID:</strong> <?php echo htmlspecialchars($product->sizeID); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product->price, 2); ?></p>
            </li>
          <?php } ?>
        </ul>
      <?php } else { ?>
        <p>No products found matching your criteria.</p>
      <?php } ?>
    </section>
    
    <!-- Messages -->
<section class="messages">
  <?php if ($Add_SuccessMsg): ?>
    <div class="success-message">
      <?php echo htmlspecialchars($Add_SuccessMsg); ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($Add_ErrorMsg)): ?>
    <div class="error-messages">
      <ul>
        <?php foreach ($Add_ErrorMsg as $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($Update_SuccessMsg): ?>
    <div class="success-message">
      <?php echo htmlspecialchars($Update_SuccessMsg); ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($Update_ErrorMsg)): ?>
    <div class="error-messages">
      <ul>
        <?php foreach ($Update_ErrorMsg as $error): ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($Delete_SuccessMsg): ?>
    <div class="success-message">
      <?php echo htmlspecialchars($Delete_SuccessMsg); ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($Delete_ErrorMsg)): ?>
    <div class="error-messages">
      <ul>
        <?php foreach ($Delete_ErrorMsg as $error): ?>
          <li><?php var_dump($error); ?> </li> <!-- Debugging Output -->
        <?php endforeach; ?>
      </ul>
    </div>
<?php endif; ?>

</section>

  </div>
  
  <!-- jQuery and Custom Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Toggle search form visibility
      $("#search").click(function() {
        $(".filter-bar").toggleClass("show");
      });
      // Toggle add form visibility
      $("#add").click(function(){
        $(".add-form").toggleClass("show");
      });
      // Cancel buttons for forms
      $("#cancelSearch").click(function(){
        $(".filter-bar").removeClass("show");
      });
      $("#cancelAdd").click(function(){
        $(".add-form").removeClass("show");
      });
      // Toggle update form for each product
      $(".updateProductBtn").click(function() {
        var index = $(this).data("index");
        $(".update-form").slideUp();
        $(".updateForm-" + index).slideToggle();
      });
      // Cancel update form
      $(".cancelUpdateBtn").click(function() {
        var index = $(this).data("index");
        $(".updateForm-" + index).slideUp();
      });
      $(".btn-delete").click(function(e) {
        e.preventDefault(); // Prevent default behavior
        
        var productCard = $(this).closest(".product-card");
        var deleteForm = productCard.find("form"); // Find the hidden delete form
        
        var deleteForm = productCard.find("form").first();

if (deleteForm.length === 0) {
    console.log("Error: Delete form not found! Please check HTML structure.");
    return;
}
        var productName = $(this).data("productname");
        var productId   = $(this).data("productid");
        var seriesId    = $(this).data("seriesid");
        var seriesName  = $(this).data("seriesname");
        var price       = $(this).data("price");
        var stock       = $(this).data("stock");
        var sizeId      = $(this).data("sizeid");

        var confirmMessage = "Are you sure you want to delete the following product?\n\n";
        confirmMessage += "Product Name: " + productName + "\n";
        confirmMessage += "Product ID: " + productId + "\n";
        confirmMessage += "Series ID: " + seriesId + "\n";
        confirmMessage += "Series Name: " + seriesName + "\n";
        confirmMessage += "Price: $" + price + "\n";
        confirmMessage += "Stock: " + stock + "\n";
        confirmMessage += "Size ID: " + sizeId + "\n";

        if (confirm(confirmMessage)) {
            deleteForm.submit(); // Correctly submit the form
        }
    });
    });
    
  </script>
</body>
</html>
