<?php
require_once "../../../db_connection.php";
require_once "../../../controller/productController.php";
require_once "../../../_base.php";      
include "../main.php";
// Include CSS
$stylesheetArray = ['../../../css/admin_product.css'];
link_stylesheet($stylesheetArray);

$productController = new ProductController($_db);
$allProducts = $productController->getAllProducts();

$productController = new ProductController($_db);
$seriesIdList = $productController->getAllSeriesID();

$productController = new ProductController($_db);
$productNameList = $productController->getAllProductName();


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

  <div style="margin-bottom: 1rem; display: flex ; justify-content : space-between ;">

    <form style="display: flex;" action="/controller/productController.php">
        <div style="flex: 1;">

              <div class="box">
                  <form  action="/controller/productController.php">
                      <input type="text" class="input" name="searchText" required>
                      <button type="submit">submit</button>
                      <input type="hidden" name="action" value="search">
                  </form>

              </div>
        </div>
    </form>
          <!--filter bar or what right here -->
    <form action="" style="display: flex; ">
      <input type="hidden" name="action" value="filter">
          <select style="padding: 0.5rem;">
            <option>All Categories</option>
            <option>Active</option>
            <option>Pending</option>
            <option>Archived</option>
          </select>
      <label for="">Product Size ID</label>
          <select>
            <option>All Categories</option>
            <option>Active</option>
            <option>Pending</option>
            <option>Archived</option>
          </select>
            
          <input type="number" step="25" name="minPrice" value="10" required>
          <input type="number" step="25" name="maxPrice" value="25" required>
    </form>
 
  </div>

          <!-- Alert -->
         <!-- Messages -->
  <div style="background-color: #d4edda; color: #155724; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
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
              <th class="th">product ID  </th>
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
                    <a href="addProduct.php" class="action-btn-add" title="Add New Product">
                      <i class="fa-solid fa-plus"></i>
                    </a>

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

                </td>
            </tr>
            
      
            <?php endforeach; ?>

        </tbody>
      </table>
    </div>

  </div>


</div>
    
<?php
include "../../../admin_foot.php"
?>
<?php
// TODO : 
// 1. delete than just show a confirm message than delete 
// 2. add than show user add_product page 
// 3. 
?> 
    
 

<script>
  $(document).ready(function () {
    $('.delete-form').on('submit', function (e) {
      const productID = $(this).find('button').data('productid');
      const sizeID = $(this).find('button').data('sizeid');

      const confirmDelete = confirm(`Are you sure you want to delete this product?\nProduct ID: ${productID}\nSize ID: ${sizeID}`);

      if (!confirmDelete) {
        e.preventDefault(); // Cancel submission
      }
    });
  });
</script>

