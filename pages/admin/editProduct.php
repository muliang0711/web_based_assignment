<?php
require_once "../../db_connection.php";
require_once "../../controller/productController.php";

$productID = $_GET['productID'] ?? '';
$sizeID = $_GET['sizeID'] ?? '';

$productController = new ProductController($_db);
$product = $productController->getProductByIDAndSize($productID, $sizeID);

if (!$product) {
  echo "Product not found.";
  exit;
}

$stylesheetArray = ['../../css/editAnddetails.css'];
link_stylesheet($stylesheetArray);
?>


<div class="container">
  <form action="../../controller/productController.php" method="POST" enctype="multipart/form-data" class="form-container">
  <input type="hidden" name="action" value="updateProduct">
    <!-- LEFT -->
    <div class="left-side box">
      <h3 class="section-title">Edit Product Info</h3>

      <input type="hidden" name="productId" value="<?php echo $product['productID']; ?>" >

      <input type="hidden" name="sizeId" value="<?php echo $product['sizeID']; ?>">

      <div class="form-group">
        <label>Product Id</label>
        <input type="text" name="productName" value="<?php echo htmlspecialchars($product['productID']); ?>" readonly>
      </div>

      <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="productName" value="<?php echo htmlspecialchars($product['productName']); ?>" required>
      </div>


      <div class="form-group">
        <label>Series ID</label>
        <input type="text" name="seriesName" value="<?php echo htmlspecialchars($product['seriesName']); ?>" readonly>
      </div>

      <div class="form-group">
        <label>Series ID</label>
        <input type="text" name="seriesId" value="<?php echo htmlspecialchars($product['seriesID']); ?>" readonly>
      </div>

      <div class="form-group">
        <label>Size ID</label>
        <input type="text" name="sizeId" value="<?php echo htmlspecialchars($product['sizeID']); ?>" readonly>
      </div>

      <div class="form-group">
        <label>Price (RM)</label>
        <input type="number" step="25" name="price" value="<?php echo $product['price']; ?>" required>
      </div>

      <div class="form-group">
        <label>Stock</label>
        <input type="number" name="stock" value="<?php echo $product['total_stock']; ?>" required>
      </div>

      <div class="form-group">
        <label>Introduction</label>
        <textarea name="introduction" rows="3"><?php echo htmlspecialchars($product['introduction']); ?></textarea>
      </div>

      <div class="form-group">
        <label>Player Info</label>
        <textarea name="playerInfo" rows="3"><?php echo htmlspecialchars($product['playerInfo']); ?></textarea>
      </div>

      <button type="submit" class="submit-btn">Update Product</button>

    </div>

    <!-- RIGHT -->
    <div class="right-side box">
      <h3 class="section-title">Product Images</h3>

      <!-- Existing Product Images -->
      <div class="form-group">
        <label>Current Product Images</label>
        <div class="preview-gallery">
          <?php foreach ($product['product_images'] as $imgPath): ?>
            <img src="../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="product image">
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Upload New Product Images -->

      <div class="form-group">
        <label style="font-size: large; color:red;" >Because hacker attack ,  product you update on this page will override the existing product </label>
        <img src="/assets/img/hacker.png" alt=""width="200px">
      </div>

      <div class="form-group">
        <label>Upload New Product Images</label>
        <input type="file" name="productImage[]" accept="image/*" multiple required>
      </div>

      <!-- Existing Player Images -->
      <div class="form-group">
        <label>Current Player Images</label>
        <div class="preview-gallery">
          <?php foreach ($product['player_images'] as $imgPath): ?>
            <img src="../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="player image">
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Upload New Player Images -->
      <div class="form-group">
        <label>Upload New Player Images</label>
        <input type="file" name="playerImage[]" accept="image/*" multiple required>
      </div>

      <button type="button" class="back-btn" onclick="window.location.href='admin_product.php'">← Back</button>
    </div>

  </form>
</div>
