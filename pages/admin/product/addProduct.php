
<?php
require_once "../../../_base.php";      

include '../../../admin_login_guard.php';

$stylesheetArray = ['../../../css/editAnddetails.css'];
link_stylesheet($stylesheetArray);
?>
<div class="container">
  <form action="/controller/productManager.php" method="POST" enctype="multipart/form-data" class="form-container">
    
  <input type="hidden" name="action" value="addProduct">
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
        <label for="seriesId">Series ID</label>
        <input type="text" id="seriesId" name="seriesId" required>
      </div>

      
      <div class="form-group">
        <label for="seriesID">Series Name</label>
        <input type="text" id="seriesName" name="seriesName" required>
      </div>

      <div class="form-group">
        <label for="sizeID">Size ID</label>
        <input type="text" id="sizeId" name="sizeId" required>
      </div>

      <div class="form-group">
        <label for="price">Price (RM)</label>
        <input type="number" id="price" name="price" step="0.01" required>
      </div>

      <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" id="stock" name="stock" value="0" hidden>
      </div>
      
      <div class="form-group">
        <label>Introduction</label>
        <textarea name="introduction" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label>Player Info</label>
        <textarea name="playerInfo" rows="3"></textarea>
      </div>

      <button type="submit" class="submit-btn">Add Product</button>
    </div>

    <!-- Right Side: Images -->
    <div class="right-side box">
      <h3 class="section-title">Images</h3>

      <!-- Product Upload Drop Zone -->
      <div class="form-group">
        <label>Product Picture</label>
        <div id="drop-zone-product" class="drop-zone">
          <p>Drag & drop product images here or click to select</p>
          <input type="file" id="productImage" name="productImage[]" accept="image/jpeg,image/png,image/webp" multiple >
        </div>
        <div id="preview-product" class="preview-gallery"></div>
      </div>

      <!-- Player Upload Drop Zone -->
      <div class="form-group">
        <label>Player Picture</label>
        <div id="drop-zone-player" class="drop-zone">
          <p>Drag & drop player images here or click to select</p>
          <input type="file" id="playerImage" name="playerImage[]" accept="image/jpeg,image/png,image/webp" multiple >
        </div>
        <div id="preview-player" class="preview-gallery"></div>
      </div>

      <!-- Modal Container -->
      <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="zoomedImage">
      </div>

      <div class="form-group">
        <button type="button" class="back-btn" onclick="window.location.href='admin_product.php'">← Back</button>
      </div>

    </div>

  </form>
</div>

<?php
include "../../../admin_foot.php"
?>


<script>
  function setupDragDrop(dropZoneId, inputId, previewId, maxFiles = 5, maxSizeMB = 2, allowedTypes = ['image/jpeg', 'image/png', 'image/webp']) {
    const dropZone = $(dropZoneId);
    const fileInput = $(inputId);
    const preview = $(previewId);

    // Click opens file selector
    dropZone.on('click', function () {
      fileInput.trigger('click');
    });

    // Drag over style
    dropZone.on('dragover', function (e) {
      e.preventDefault();
      dropZone.addClass('dragover');
    });

    dropZone.on('dragleave', function () {
      dropZone.removeClass('dragover');
    });

    // Drop files
    dropZone.on('drop', function (e) {
      e.preventDefault();
      dropZone.removeClass('dragover');
      const files = e.originalEvent.dataTransfer.files;
      handleFiles(files);
    });

    // File input change
    fileInput.on('change', function () {
      handleFiles(this.files);
    });

    // File validation + preview
    function handleFiles(files) {
      if (files.length > maxFiles) {
        alert(`Max ${maxFiles} images allowed.`);
        fileInput.val('');
        return;
      }

      // preview.html(""); // clear previews
      Array.from(files).forEach(file => {
        if (!allowedTypes.includes(file.type)) {
          alert("Only JPG, PNG, WEBP formats allowed.");
          fileInput.val('');
          return;
        }

        if (file.size / (1024 * 1024) > maxSizeMB) {
          alert("File too large. Max: " + maxSizeMB + "MB.");
          fileInput.val('');
          return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
          const img = $("<img>", { src: e.target.result });
          preview.append(img);
        };
        reader.readAsDataURL(file);
      });
    }

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
  }

  $(document).ready(function () {
    setupDragDrop("#drop-zone-product", "#productImage", "#preview-product");
    setupDragDrop("#drop-zone-player", "#playerImage", "#preview-player");
  });

</script>


