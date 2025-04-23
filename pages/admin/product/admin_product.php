<?php
require_once "../../../controller/productController.php";
require_once "../../../_base.php";
include __DIR__ . "/../main.php";
include __DIR__  . '/../../../admin_login_guard.php';
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
                <!-- View Details -->
                <a href="productDetails.php?productID=<?php echo $product->productID; ?>&sizeID=<?php echo $product->sizeID; ?>" class="action-btn-details">
                  <i class="fas fa-eye"></i>
                </a>

                <!-- Edit -->
                <a href="editProduct.php?productID=<?php echo $product->productID; ?> &sizeID=<?php echo $product->sizeID; ?>" class="action-btn-edit" title="Edit Product">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>

              

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

<script src="/js/product.js"></script>
<script>


$(document).ready(function () {
    console.log("product.js loaded!");
    const $minInput = $('#minPrice');
    const $maxInput = $('#maxPrice');
    const $form = $('.filter-form');
    const $errorMsg = $('#priceError');

    // Set default values if empty or out of range
    $minInput.on('blur', function () {

        let val = parseInt($(this).val());
        if (isNaN(val) || val < 10) {
            $(this).val(10);
        }

    });

    $maxInput.on('blur', function () {
        let val = parseInt($(this).val());
        if (isNaN(val) || val < 100) {
            $(this).val(100);
        } else if (val > 1000) {
            $(this).val(1000);
        }
    });

    // Validate before submit
    $form.on('submit', function (e) {
        const min = parseInt($minInput.val());
        const max = parseInt($maxInput.val());

        let error = "";

        if (isNaN(min) || isNaN(max)) {
            error = "Both prices must be numbers.";
        } else if (min < 10 || min > 1000) {
            error = "Minimum price must be between 10 and 1000.";
        } else if (max < 100 || max > 1000) {
            error = "Maximum price must be between 100 and 1000.";
        } else if (min > max) {
            error = "Minimum price cannot be greater than maximum price.";
        }

        if (error) {
            $errorMsg.text(error).show();
            e.preventDefault(); // stop submission
        } else {
            $errorMsg.hide(); // hide error if all good
        }
    });
    $('.delete-form').on('submit', function (e) {
        const productID = $(this).find('button').data('productid');
        const sizeID = $(this).find('button').data('sizeid');

        const confirmDelete = confirm(`Are you sure you want to delete this product?\nProduct ID: ${productID}\nSize ID: ${sizeID}`);

        if (!confirmDelete) {
            e.preventDefault(); // Cancel submission
        }
    });

    document.querySelectorAll('.status-toggle-btn').forEach(button => {
        button.addEventListener('click', async () => {
            
            // 1. fetch  element form html tag : 
            const productID = button.dataset.productid;
            const sizeID = button.dataset.sizeid;
            const currentStatus = button.dataset.status;
            const newStatus = currentStatus === 'onsales' ? 'notonsales' : 'onsales';


            // 2. use try catch to improve the process structure ; 
            try {
                // 3. sending the data to target file ;
                const response = await fetch('/controller/api/statusSwtich.php', {
                    // 3.1 mention the request method ；
                    method: 'POST',
                    // 3.2 mention how will the data convert into what type string or json or somelse in here is json 
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    // 3.3 modify the request body , what we want to send ; 
                    body: JSON.stringify({
                        productID: productID,
                        sizeID: sizeID,
                        status: newStatus
                    })
                });

                // 4. get http res body
                const result = await response.json();

                // repsonse.ok to ensure the request is send successfully 
                // response.success to ensure the backend is correctly processing the data 
                if (!response.ok || !result.success) {
                    throw new Error(result.error || 'Unknown error');
                }

                // update status 
                button.dataset.status = newStatus;

                if (newStatus === 'onsales') {
                    button.classList.remove('notonsales');
                    button.classList.add('onsales');
                    button.innerHTML = `<i class="fas fa-toggle-on"></i> On Sale`;
                } else {
                    button.classList.remove('onsales');
                    button.classList.add('notonsales');
                    button.innerHTML = `<i class="fas fa-toggle-off"></i> Not On Sale`;
                }
                // error handle 
            } catch (error) {
                console.error('Failed to update status:', error);
                alert('Failed to update status. Please try again.');
            }
        });
    });




});
</script>