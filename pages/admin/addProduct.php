
<?php
require_once "../../_base.php";      
$stylesheetArray = ['../../css/test.css'];
link_stylesheet($stylesheetArray);

?>
<div class="container">
  <form action="storeProduct.php" method="POST" enctype="multipart/form-data" class="form-container">

    <!-- Left Side: Product Details -->
    <div class="left-side box">
      <h3 class="section-title">Product Info</h3>

      <div class="form-group">
        <label for="productName">Product Id</label>
        <input type="text" id="productId" name="productId" required>
      </div>

      <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" id="productName" name="productName" required>
      </div>

      <div class="form-group">
        <label for="seriesID">Series ID</label>
        <input type="text" id="seriesID" name="seriesID" required>
      </div>

      
      <div class="form-group">
        <label for="seriesID">Series Name</label>
        <input type="text" id="seriesName" name="seriesName" required>
      </div>

      <div class="form-group">
        <label for="sizeID">Size ID</label>
        <input type="text" id="sizeID" name="sizeID" required>
      </div>

      <div class="form-group">
        <label for="price">Price (RM)</label>
        <input type="number" id="price" name="price" step="0.01" required>
      </div>

      <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" id="stock" name="stock" required>
      </div>

      <button type="submit" class="submit-btn">Add Product</button>
    </div>

    <!-- Right Side: Images -->
    <div class="right-side box">
      <h3 class="section-title">Images</h3>

      <div class="form-group">
        <label for="productImage">Product Picture</label>
        <input type="file" name="productImage" id="productImage" accept="image/*">
      </div>

      <div class="form-group">
        <label for="playerImage">Player Picture</label>
        <input type="file" name="playerImage" id="playerImage" accept="image/*">
      </div>

      <div class="form-group">
        <label>Preview</label>
        <div class="preview-gallery">
          <img src="../../File/player_R0001_0.jpg" alt="Preview" />
          <img src="../../File/player_R0001_0.jpg" alt="Preview" />
          <img src="../../File/player_R0001_0.jpg" alt="Preview" />
        </div>
      </div>
    </div>

  </form>
</div>
