<?php
session_start();
// Include necessary files
require_once "../../db_connection.php";
require_once "../../controller/productController.php";
require_once "../../_base.php";
// secssion already start in the _base.php so we can deirect use 
// Include CSS
$stylesheetArray = ['../../css/admin_product.css'];
link_stylesheet($stylesheetArray);

$productController = new ProductController($_db);
$products = $productController->getAllProducts();

// Retrieve search results from session
$searchProducts = $_SESSION['search_results'] ?? [];
unset($_SESSION['search_results']); // Clear after retrieval
//--------
$Add_SucessMsg= $_SESSION['Add_SuccessMsg'] ?? [];
unset($_SESSION['Add_SuccessMsg']);

$Add_ErrorMsg = $_SESSION['Add_ErrorMsg'] ?? [];
unset($_SESSION['Add_ErrorMsg']);
//------------------------
?>
<!-- All product-->
<div>
    <h2>All Products</h2>
    <ul>
        <?php foreach ($products as $product) { ?>
            <li>
                ---<?php echo htmlspecialchars($product->productID)?>
                ---<?php echo htmlspecialchars($product->productName); ?> 
                ---$<?php echo number_format($product->price, 2); ?> 
                ---<?php echo htmlspecialchars($product->seriesID); ?>
                ---<?php echo htmlspecialchars($product->total_stock)?>
                ---<?php echo htmlspecialchars($product->sizeID)?>
            </li>
        <?php } ?>
    </ul>
</div>

<!--trigger-->
<button id="search">Search</button>
<button id="add">addProduct</button>

<!-- Search Form -->
<div class="filter-bar">
    <form action="../../controller/productController.php" method="post">
        <input type="hidden" name="action" value="filterProduct">
        
        <select name="productName">
            <option value="">-- Product Name --</option>
            <?php foreach ($products as $product) { ?>
                <option value="<?php echo htmlspecialchars($product->productName); ?>">
                    <?php echo htmlspecialchars($product->productName); ?>
                </option>
            <?php } ?>
        </select>

        <select name="seriesID">
            <option value="">-- Product Series ID --</option>
            <?php foreach ($products as $product) { ?>
                <option value="<?php echo htmlspecialchars($product->seriesID); ?>">
                    <?php echo htmlspecialchars($product->seriesID); ?>
                </option>
            <?php } ?>
        </select>

        <select name="minPrice">
            <option value="">-- Min Price --</option>
            <?php for ($minPrice = 250 ; $minPrice <= 850; $minPrice += 50) { ?>
                <option value="<?php echo $minPrice; ?>"><?php echo "$" . number_format($minPrice, 2); ?></option>
            <?php } ?>
        </select>

        <select name="maxPrice">
            <option value="">-- Max Price --</option>
            <?php for ($maxPrice = 250; $maxPrice <= 2000; $maxPrice += 250) { ?>
                <option value="<?php echo $maxPrice; ?>"><?php echo "$" . number_format($maxPrice, 2); ?></option>
            <?php } ?>
        </select>

        <button type="submit">Search</button>
    </form>
</div>
<!-- Add form-->
 <div class="add-form">
    <form action="../../controller/productController.php" method="post">
            
        <input type="hidden" name="action" id="action" value="addProduct">

            <input type="text" name="productName" placeholder="productname">
            <input type="text" name="productId" placeholder="productId">

            <input type="text" name="seriesName" placeholder="seriesName">
            <input type="text" name="seriesId" placeholder="seriesid">

            <input type="text" name="sizeId" placeholder="sizeId">

            <input type="text" name='price' placeholder="price">
            <input type="text" name='stock' placeholder="stock">

        <button type="submit">submit</button>
    </form>
   
 </div>
<!-- Search Results -->
<div class="result">
    <h2>Search Results</h2>
    <?php if (!empty($searchProducts) ) { ?>
        <ul>
            <?php foreach ($searchProducts as $product) { ?>
                <li>
                    <?php echo htmlspecialchars($product->productName); ?> 
                    - $<?php echo number_format($product->price, 2); ?> 
                    - <?php echo htmlspecialchars($product->seriesID); ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No products found matching your criteria.</p>
    <?php } ?>
</div>    
<!--ADD product result -->
<div class="messages">
    <?php if ($Add_SucessMsg): ?>
        <div class="success-message">
            <?php echo htmlspecialchars($Add_SucessMsg); ?>
        </div>
        <?php unset($_SESSION['Add_SuccessMsg']); ?>
    <?php endif; ?>

    <?php if ($Add_ErrorMsg): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($Add_ErrorMsg as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['Add_ErrorMsg']); ?>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#search").click(function () {
            $(".filter-bar").toggleClass("show");
        });
        $("#add").click(function(){
            $(".add-form").toggleClass("show")
        })
    });
</script>

</body>
</html>
