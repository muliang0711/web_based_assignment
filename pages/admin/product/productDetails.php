<?php
require_once "../../../db_connection.php";
require_once "../../../controller/productController.php";
require_once "../../../_base.php";

$stylesheetArray = ['../../../css/editAnddetails.css'];
link_stylesheet($stylesheetArray);

$productID = $_GET['productID'] ?? null;
$sizeID = $_GET['sizeID'] ?? null;

if (!$productID || !$sizeID) {
    echo "Product not found.";
    exit;
}

$productController = new ProductController($_db);
$product = $productController->getProductByIDAndSize($productID, $sizeID);

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<div class="container">
  <div class="form-container">
    <!-- Left Side: Product Info -->
    <div class="left-side box">
      <h3 class="section-title">Product Info</h3>

      <div class="form-group">
        <label>Product ID</label>
        <input type="text" value="<?php echo htmlspecialchars($product['productID']); ?>" disabled>
      </div>

      <div class="form-group">
        <label>Product Name</label>
        <input type="text" value="<?php echo htmlspecialchars($product['productName']); ?>" disabled>
      </div>

      <div class="form-group">
        <label>Series Name</label>
        <input type="text" value="<?php echo htmlspecialchars($product['seriesID']); ?>" disabled>
      </div>

      <div class="form-group">
        <label>Series Name</label>
        <input type="text" value="<?php echo htmlspecialchars($product['seriesName']); ?>" disabled>
      </div>

      <div class="form-group">
        <label>Size ID</label>
        <input type="text" value="<?php echo htmlspecialchars($product['sizeID']); ?>" disabled>
      </div>

      <div class="form-group">
        <label>Price (RM)</label>
        <input type="text" value="RM<?php echo number_format($product['price'], 2); ?>" disabled>
      </div>

      <div class="form-group">
        <label>Stock</label>
        <input type="text" value="<?php echo htmlspecialchars($product['total_stock']); ?>" disabled>
      </div>

      
      <div class="form-group">
        <label>Introduction</label>
        <textarea name="introduction" rows="3" readonly><?php echo htmlspecialchars($product['introduction']); ?></textarea>
      </div>

      <div class="form-group">
        <label>Player Info</label>
        <textarea name="playerInfo" rows="3" readonly><?php echo htmlspecialchars($product['playerInfo']); ?></textarea>
      </div>

      
    </div>

    <!-- Right Side: Images -->
    <div class="right-side box">

      <h3 class="section-title">Images</h3>

      <!-- Product Images -->
      <div class="form-group">
        <label>Product Pictures</label>
        <div class="preview-gallery">
          <?php foreach ($product['product_images'] as $imgPath): ?>
            <img src="../../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="Product Image" class="zoomable-img">
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Player Images -->
      <div class="form-group">
        <label>Player Pictures</label>
        <div class="preview-gallery">
          <?php foreach ($product['player_images'] as $imgPath): ?>
            <img src="../../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="Player Image" class="zoomable-img">
          <?php endforeach; ?>
        </div>
      </div>

      <div class="form-group">
        <button type="button" class="back-btn" onclick="window.location.href='admin_product.php'">← Back</button>
      </div>
      
    </div>
  </div>
</div>

<?php
include "../../../admin_foot.php"
?>
<!-- Modal Zoom Viewer -->
<div id="imageModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="zoomedImage">
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    // Zoom modal logic
    $(".zoomable-img").on("click", function () {
      $("#zoomedImage").attr("src", $(this).attr("src"));
      $("#imageModal").fadeIn();
    });

    $(".close").on("click", function () {
      $("#imageModal").fadeOut();
    });

    $("#imageModal").on("click", function (e) {
      if (e.target === this) {
        $(this).fadeOut();
      }
    });
  });
</script>
