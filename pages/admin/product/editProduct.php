<?php
require_once "../../../db_connection.php";
require_once "../../../controller/productManager.php";

$productID    = $_GET['productID'] ?? '';
$sizeID       = $_GET['sizeID'] ?? '';

$productController  = new ProductController($_db);
$product            = $productController->getProductByIDAndSize($productID, $sizeID);

if (!$product) {
  echo "Product not found.";
  exit;
}

$stylesheetArray = ['../../../css/editAnddetails.css'];
link_stylesheet($stylesheetArray);
?>


<div class="container">
  <form action="/controller/productManager.php" method="POST" enctype="multipart/form-data" class="form-container">
  <input type="hidden" name="action" value="updateProduct">
    <!-- LEFT -->
    <div class="left-side box">
      <h3 class="section-title">Edit Product Info</h3>

      <div class="form-group">
        <label>Product Id</label>
        <input type="text" name="productId" value="<?php echo htmlspecialchars($product['productID']); ?>" readonly>
      </div>

      <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="productName" value="<?php echo htmlspecialchars($product['productName']); ?>" required>
      </div>

      <div class="form-group">
        <label>Series ID</label>
        <input type="text" name="seriesId" value="<?php echo htmlspecialchars($product['seriesID']); ?>" readonly>
      </div>
      
      <div class="form-group">
        <label>Series Name</label>
        <input type="text" name="seriesName" value="<?php echo htmlspecialchars($product['seriesName']); ?>" readonly>
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
        <input type="number" name="stock" value="<?php echo $product['total_stock']; ?>" readonly>
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

      
      <div class="form-group">
        <label style="font-size: large; color:red;" >Because hacker attack ,  image you update on this page will override the existing image </label>
        <img src="/assets/img/hacker.png" alt=""width="200px">
      </div>

      <!-- Existing Product Images -->
      <div class="form-group">
        <label>Current Product Images</label>
        <div class="preview-gallery ">
          <?php foreach ($product['product_images'] as $imgPath): ?>
            <img src="../../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="product image">
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Upload New Product Images -->


      <div class="form-group">
        <label>Upload New Product Images</label>
        <input type="file" name="productImage[]" accept="image/*" multiple >
      </div>

      <!-- Existing Player Images -->
      <div class="form-group">
        <label>Current Player Images</label>
        <div class="preview-gallery">
          <?php foreach ($product['player_images'] as $imgPath): ?>
            <img src="../../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="player image">
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Upload New Player Images -->
      <div class="form-group">
        <label>Upload New Player Images</label>
        <input type="file" name="playerImage[]" accept="image/*" multiple >
      </div>
        
      <button type="button" class="back-btn" onclick="window.location.href='admin_product.php'">← Back</button>
            
      <!-- Modal Container -->
      <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="zoomedImage">
      </div>
    
    </div>

  </form>
</div>

<?php
include "../../../admin_foot.php"
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function(){
    $(document).on("click", ".preview-gallery img", function () {
    const src = $(this).attr("src");
    $("#zoomedImage").attr("src", src);
    $("#imageModal").fadeIn();
    });

    // Close modal
    $(".close").click(function () {
      $("#imageModal").fadeOut();
    });

    // Optional: Click outside image to close
    $("#imageModal").click(function (e) {
      if (e.target === this) {
        $(this).fadeOut();
      }
    });
  });

</script>
