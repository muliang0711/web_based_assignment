<?php
require_once __DIR__ . "/../../../db_connection.php";
require_once "../../../controller/productController.php";
require_once "../../../_base.php";
include __DIR__ . "/../main.php";
// Include CSS
$stylesheetArray = ['../../../css/admin_product.css'];
link_stylesheet($stylesheetArray);

$productsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startFrom = ($page - 1) * $productsPerPage;

$allProductsList = $productController->getAllProducts();

$totalProducts = count($allProductsList);
$allProducts = array_slice($allProductsList, $startFrom, $productsPerPage);

// Calculate total pages
$totalPages = ceil($totalProducts / $productsPerPage);

$seriesIdList = $productController->getAllSeriesID();

$productIDList = $productController->getAllProductID();


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
<div class="main-content">
  <!-- Example Search/Filter Section -->

  <div class="filter-container">

    <!-- Search Bar -->
    <form class="search-box" method="GET" action="/controller/productController.php">
      <input type="hidden" name="action" value="search">
      <input type="text" name="searchText" placeholder="Search product..." required>
      <button type="submit">Search</button>
    </form>

    <!-- Filter Form -->
    <form class="filter-form" method="POST" action="/controller/productController.php">
      <input type="hidden" name="action" value="filter">

      <label for="productID">Product ID</label>
      <select name="productID" id="productID">
        <option value="">All</option>
        <?php foreach ($productIDList as $IdList): ?>
          <option value="<?= htmlspecialchars($IdList->productID) ?>">
            <?= htmlspecialchars($IdList->productID) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="seriesID">Series</label>
      <select name="seriesID" id="seriesID">
        <option value="">All</option>
        <?php foreach ($seriesIdList as $series): ?>
          <option value="<?= htmlspecialchars($series->seriesID) ?>">
            <?= htmlspecialchars($series->seriesID) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="sizeID">Size</label>
      <select name="sizeID" id="sizeID">
        <option value="">All</option>
        <option value="3UG5">3UG5</option>
        <option value="4GG5">4UG5</option>
      </select>

      <label for="minPrice">Min Price</label>
      <input type="number" name="minPrice" id="minPrice"
        min="10" max="1000" value="10" step="100">

      <label for="maxPrice">Max Price</label>
      <input type="number" name="maxPrice" id="maxPrice"
        min="100" max="1000" value="100" step="100">

      <small id="priceError" style="color: red; display: none;"></small>


      <button type="submit">Apply Filter</button>
    </form>

    <!-- Add Product -->
    <a href="addProduct.php" class="action-btn-add" title="Add New Product">
      <i class="fa-solid fa-plus"></i> Add Product
    </a>

  </div>


  <!-- Alert -->
  <!-- Messages -->
  <div style="background-color:rgb(255, 255, 255); color:rgb(255, 255, 255); padding: 0.75rem; margin-bottom: 1rem; border: 1px solidrgb(255, 255, 255);">
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


  <div class="container-table">

    <div class="tb-title">
      <h5 style="margin: 0;"><i class="fas fa-table"></i> Product </h5>
    </div>


    <div style="padding: 1rem;">
      <table class="tb">
        <thead>
          <tr style="background-color: #f9f9f9;">
            <th class="th">product ID </th>
            <th class="th">series ID</th>
            <th class="th">sizeID</th>
            <th class="th">price</th>
            <th class="th">stock</th>
            <th class="th">Actions</th>
          </tr>
        </thead>

        <tbody>

          <?php foreach ($allProducts as $index => $product): ?>

            <!-- Product Info -->
            <tr>
              <td class="td"><?php echo htmlspecialchars($product->productID); ?></td>
              <td class="td"><?php echo htmlspecialchars($product->seriesID); ?></td>
              <td class="td"><?php echo htmlspecialchars($product->sizeID); ?></td>
              <td class="td">RM<?php echo number_format($product->price, 2); ?></td>
              <td class="td"><?php echo htmlspecialchars($product->total_stock); ?></td>
              <td class="td">
                <!-- Add -->


                <!-- View Details -->
                <a href="productDetails.php?productID=<?php echo $product->productID; ?>&sizeID=<?php echo $product->sizeID; ?>" class="action-btn-details">
                  <i class="fas fa-eye"></i>
                </a>

                <!-- Edit -->
                <a href="editProduct.php?productID=<?php echo $product->productID; ?> &sizeID=<?php echo $product->sizeID; ?>" class="action-btn-edit" title="Edit Product">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <form method="POST" action="/controller/productController.php" class="delete-form" style="display:inline;">
                  <input type="hidden" name="action" value="deleteProduct">
                  <input type="hidden" name="productId" value="<?php echo $product->productID; ?>">
                  <input type="hidden" name="sizeId" value="<?php echo $product->sizeID; ?>">
                  <button type="submit" class="action-btn-delete" data-productid="<?php echo $product->productID; ?>" data-sizeid="<?php echo $product->sizeID; ?>">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>

                <button class="status-toggle-btn toggle-btn 
                      <?php echo $product->status === 'onsales' ? 'onsales' : 'notonsales'; ?>"

                  data-productid="<?php echo $product->productID; ?>"
                  data-sizeid="<?php echo $product->sizeID; ?>"
                  data-status="<?php echo $product->status; ?>">

                  <i class="fas <?php echo $product->status === 'onsales' ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
                  <?php echo $product->status === 'onsales' ? 'On Sale' : 'Not On Sale'; ?>
                </button>



              </td>
            </tr>


          <?php endforeach; ?>

        </tbody>
      </table>
    </div>

  </div>
  <div class="pagination" style="text-align: center; margin-top: 1rem;">
    <?php if ($page > 1): ?>
      <a href="?page=<?php echo $page - 1; ?>">&laquo; Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="?page=<?php echo $i; ?>" style="margin: 0 4px; <?php if ($i == $page) echo 'font-weight: bold;'; ?>">
        <?php echo $i; ?>
      </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
    <?php endif; ?>
  </div>`

</div>



<?php
include "../../../admin_foot.php"
?>

<script src="/pages/admin/product/product.js"></script>
<script src="/js/admin_product.js"></script>