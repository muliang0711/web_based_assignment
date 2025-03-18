<?php
require_once "../../db_connection.php";
require_once "../../controller/productController.php";
require_once "../../_base.php";
require_once "../../admin_head.php";
// Include CSS
$stylesheetArray = ['../../css/admin_product.css'];
link_stylesheet($stylesheetArray);

$productController = new ProductController($_db);
$allProducts = $productController->getAllProducts();

// Retrieve search results from session
$searchProducts = $_SESSION['search_results'] ?? [];
unset($_SESSION['search_results']);

// Retrieve messages
$Add_SuccessMsg = $_SESSION['Add_SuccessMsg'] ?? null;
unset($_SESSION['Add_SuccessMsg']);

$Add_ErrorMsg = $_SESSION['Add_ErrorMsg'] ?? [];
unset($_SESSION['Add_ErrorMsg']);

$Update_SuccessMsg = $_SESSION['Update_SuccessMsg'] ?? null;
unset($_SESSION['Update_SuccessMsg']);

$Update_ErrorMsg = $_SESSION['Update_ErrorMsg'] ?? [];
unset($_SESSION['Update_ErrorMsg']);

$Delete_SuccessMsg = $_SESSION['Delete_SuccessMsg'] ?? null;
unset($_SESSION['Delete_SuccessMsg']);

$Delete_ErrorMsg = $_SESSION['Delete_ErrorMsg'] ?? [];
unset($_SESSION['Delete_ErrorMsg']);

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
      <h1>Product CRUD Generator</h1>
      <div class="admin-info">Admin Dashboard</div>
    </header>
    
    <!-- Top bar: search box, Add New, Export -->
    <div class="top-bar">
      <div class="search-container">
        <input type="text" placeholder="Search products...">
        <button class="btn btn-search" id="search">Search</button>
      </div>
      <div>
        <button class="btn btn-add" id="add">+ ADD NEW</button>
        <button class="btn btn-export">EXPORT</button>
      </div>
    </div>
    
    <!-- All Products Table -->
    <h2>All Products</h2>
    <table>
      <thead>
        <tr>
          <th>Actions</th>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Series ID</th>
          <th>Series Name</th>
          <th>Size ID</th>
          <th>Price</th>
          <th>Stock</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($allProducts as $index => $product): ?>
        <tr>
          <!-- Actions -->
          <td class="actions">
            <!-- Update button (opens modal) -->
            <button class="btn btn-update updateProductBtn"
              data-productid="<?php echo htmlspecialchars($product->productID); ?>"
              data-productname="<?php echo htmlspecialchars($product->productName); ?>"
              data-seriesid="<?php echo htmlspecialchars($product->seriesID); ?>"
              data-seriesname="<?php echo htmlspecialchars($product->seriesName); ?>"
              data-price="<?php echo number_format($product->price, 2); ?>"
              data-stock="<?php echo htmlspecialchars($product->total_stock); ?>"
              data-sizeid="<?php echo htmlspecialchars($product->sizeID); ?>"
            >
              Update
            </button>
            
            <!-- Delete button -->
            <button class="btn btn-delete"
              data-productid="<?php echo htmlspecialchars($product->productID); ?>"
              data-productname="<?php echo htmlspecialchars($product->productName); ?>"
              data-seriesid="<?php echo htmlspecialchars($product->seriesID); ?>"
              data-seriesname="<?php echo htmlspecialchars($product->seriesName); ?>"
              data-price="<?php echo number_format($product->price, 2); ?>"
              data-stock="<?php echo htmlspecialchars($product->total_stock); ?>"
              data-sizeid="<?php echo htmlspecialchars($product->sizeID); ?>"
            >
              Delete
            </button>
            
            <!-- Hidden delete form -->
            <form action="../../controller/productController.php" method="post"
                  style="display: none;"
                  class="deleteForm">
              <input type="hidden" name="action" value="deleteProduct">
              <input type="hidden" name="productId"   value="<?php echo htmlspecialchars($product->productID); ?>">
              <input type="hidden" name="productName" value="<?php echo htmlspecialchars($product->productName); ?>">
              <input type="hidden" name="seriesId"    value="<?php echo htmlspecialchars($product->seriesID); ?>">
              <input type="hidden" name="seriesName"  value="<?php echo htmlspecialchars($product->seriesName); ?>">
              <input type="hidden" name="price"       value="<?php echo number_format($product->price, 2); ?>">
              <input type="hidden" name="stock"       value="<?php echo htmlspecialchars($product->total_stock); ?>">
              <input type="hidden" name="sizeId"      value="<?php echo htmlspecialchars($product->sizeID); ?>">
            </form>
          </td>
          
          <!-- Product Info -->
          <td><?php echo htmlspecialchars($product->productID); ?></td>
          <td><?php echo htmlspecialchars($product->productName); ?></td>
          <td><?php echo htmlspecialchars($product->seriesID); ?></td>
          <td><?php echo htmlspecialchars($product->seriesName); ?></td>
          <td><?php echo htmlspecialchars($product->sizeID); ?></td>
          <td><?php echo number_format($product->price, 2); ?></td>
          <td><?php echo htmlspecialchars($product->total_stock); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    
    <!-- (Optional) Pagination (Static Example) -->
    <div class="pagination">
      <a href="#" class="page-link active">1</a>
      <a href="#" class="page-link">2</a>
      <a href="#" class="page-link">3</a>
      <a href="#" class="page-link">4</a>
      <a href="#" class="page-link">5</a>
    </div>
    
    <!-- Search Results -->
     <div class="result active ">
      <section class="result active">
        <h2>Search Results</h2>
        <?php if (!empty($searchProducts)) { ?>
          <div>
            <table>
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Series ID</th>
                  <th>Series Name</th>
                  <th>Size ID</th>
                  <th>Price</th>
                  <th>Stock</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($searchProducts as $product) { ?>
                  <tr>
                    <td><?php echo htmlspecialchars($product->productID); ?></td>
                    <td><?php echo htmlspecialchars($product->seriesID); ?></td>
                    <td><?php echo htmlspecialchars($product->seriesName); ?></td>
                    <td><?php echo htmlspecialchars($product->sizeID); ?></td>
                    <td>$<?php echo number_format($product->price, 2); ?></td>
                    <td><?php echo htmlspecialchars($product->total_stock); ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } else { ?>
          <p>No products found matching your criteria.</p>
        <?php } ?>
      </section>
     </div>

    
    <!-- Messages -->
     <div>
     <section class="messages result ">
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
              <li><?php var_dump($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      </section>
     </div>
    
  </div> <!-- end .container -->
  
  <!-- ===========================
       POPUP OVERLAYS 
  ============================ -->

  <!-- SEARCH OVERLAY -->
  <div class="popup-overlay search-overlay">
    <div class="popup-content">
      <h2>Search Products</h2>
      <form action="../../controller/productController.php" method="post">
        <input type="hidden" name="action" value="filterProduct">
        
        <label for="productName">Product Name</label>
        <input type="text" name="productName" id="productName" placeholder="Product Name">

        <label for="seriesID">Series ID</label>
        <input type="text" name="seriesID" id="seriesID" placeholder="Series ID">

        <label for="sizeID">Size ID</label>
        <input type="text" name="sizeID" id="sizeID" placeholder="Size ID">

        <label for="minPrice">Min Price</label>
        <input type="text" name="minPrice" id="minPrice" placeholder="e.g. 250">

        <label for="maxPrice">Max Price</label>
        <input type="text" name="maxPrice" id="maxPrice" placeholder="e.g. 2000">

        <div style="margin-top: 10px;">
          <button type="submit" class="btn btn-search">Search</button>
          <button type="button" class="btn btn-cancel" id="cancelSearch">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ADD OVERLAY -->
  <div class="popup-overlay add-overlay">
    <div class="popup-content">
      <h2>Add New Product</h2>
      <form action="../../controller/productController.php" method="post" enctype="multipart/form-data">
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
        
        <label for="image">Product Image</label>
        <input type="file" name="image[]" multiple required>
        
        <label for="introduction">Introduction</label>
        <input type="text" name="introduction" placeholder="introduction">

        <label for="playerInfo">player Info</label>
        <input type="text" name="playerInfo" placeholder="Playuer Info">
        
        <label for="playerImage">Player Image</label>
        <input type="file" name="playerImage[]" placeholder="player Image" multiple required>
             
        <div style="margin-top:10px;">
          <button type="submit" class="btn btn-add">Submit</button>
          <button type="button" class="btn btn-cancel" id="cancelAdd">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- UPDATE OVERLAY -->
  <div class="popup-overlay update-overlay">
    <div class="popup-content">
      <h2>Update Product</h2>
      <form action="../../controller/productController.php" method="post" id="updateForm">
        <input type="hidden" name="action" value="updateProduct">
        
        <label>Product ID</label>
        <input type="text" name="productId" readonly>
        
        <label>Product Name</label>
        <input type="text" name="productName">
        
        <label>Series ID</label>
        <input type="text" name="seriesId" hidden>

        <input type="text" name="seriesName" hidden>
        
        <input type="text" name="price">
        
        <label>Stock</label>
        <input type="text" name="stock">
        
        <label>Size ID</label>
        <input type="text" name="sizeId">
        
        <input type="hidden" name="oldSizeID">

        <div style="margin-top:10px;">
          <button type="submit" class="btn btn-update">Save Changes</button>
          <button type="button" class="btn btn-cancel cancelUpdateBtn">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- jQuery + custom JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../js/admin_product.js"></script>
</body>
</html>
