
<?php


require_once "../../db_connection.php";
require_once "../../controller/productController.php";
require_once "../../_base.php";      

$stylesheetArray = ['../../css/productDetails.css'];
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

// TODO : show how many have been sold 
?>
<div class="container">
  <div class="details-card">
    <h2><?php echo htmlspecialchars($product['productName']); ?> (<?php echo htmlspecialchars($product['productID']); ?>)</h2>

    <div class="details-grid">
      <div class="info">
        <p><strong>Series:</strong> <?php echo htmlspecialchars($product['seriesName']); ?> (<?php echo $product['seriesID']; ?>)</p>
        <p><strong>Size:</strong> <?php echo htmlspecialchars($product['sizeID']); ?></p>
        <p><strong>Price:</strong> RM<?php echo number_format($product['price'], 2); ?></p>
        <p><strong>Stock:</strong> <?php echo htmlspecialchars($product['total_stock']); ?></p>
      </div>

      <div class="images">
        <h4>Product Images</h4>
        
        <?php foreach ($product['product_images'] as $imgPath): ?>
            <img src="../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="Product Image" width="200px">
        <?php endforeach; ?>

        <?php foreach ($product['player_images'] as $imgPath): ?>
            <img src="../../File/<?php echo htmlspecialchars($imgPath); ?>" alt="Product Image" width="200px">
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
