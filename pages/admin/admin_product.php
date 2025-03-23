<?php
require_once "../../db_connection.php";
require_once "../../controller/productController.php";
require_once "../../_base.php";      
require_once  "../admin/main.php";
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
    
<div class="main-content">
    <!-- Example Search/Filter Section -->

  <div style="margin-bottom: 1rem;">

    <form style="display: flex; gap: 1rem;">

        <div style="flex: 1;">
          <input type="text" placeholder="Search..." style="width: 50%; padding: 0.5rem;">
        </div>
          <!--filter bar or what right here -->
        <form action="">
              <select style="padding: 0.5rem;">
                <option>All Categories</option>
                <option>Active</option>
                <option>Pending</option>
                <option>Archived</option>
              </select>

              <select style="padding: 0.5rem;">
                <option>All Categories</option>
                <option>Active</option>
                <option>Pending</option>
                <option>Archived</option>
              </select>

              <select style="padding: 0.5rem;">
                <option>All Categories</option>
                <option>Active</option>
                <option>Pending</option>
                <option>Archived</option>
              </select>
              
              <select style="padding: 0.5rem;">
                <option>All Categories</option>
                <option>Active</option>
                <option>Pending</option>
                <option>Archived</option>
              </select>
        </form>
        
        <input type="date" style="padding: 0.5rem;">
        <button type="reset" style="padding: 0.5rem;">
          <i class="fas fa-undo"></i> Reset
        </button>
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


    <!-- Example Data Table  this is a sample when include to another page please replace this table to your page -->
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
                    <button class="action-btn-add">
                      <i class="fa-solid fa-plus"></i>
                    </button>
                    <button class="action-btn-details">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="action-btn-edit">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn-delete">
                      <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            
      
            <?php endforeach; ?>

        </tbody>
      </table>

    </div>
  </div>


</div>
    
<?php
// TODO : 
// 1. delete than just show a confirm message than delete 
// 2. add than show user add_product page 
// 3. 
?> 
    
