<?php


// Include necessary files
require_once "../../db_connection.php";
require_once "../../service/productService.php";
require_once "../../_base.php";
// secssion already start in the _base.php so we can deirect use 
// Include CSS
$stylesheetArray = ['../../css/admin_product.css'];
link_stylesheet($stylesheetArray);

$productService = new productService($_db);
$products = $productService->showAllProduct();

// Retrieve search results from session
$searchProducts = $_SESSION['search_results'] ?? [];
unset($_SESSION['search_results']); // Clear after retrieval
//--------
$addProduct = $_SESSION['add_results'] ?? [];
unset($_SESSION['add_results']);
?>
<!-- All product-->
<div>
    <h2>All Products</h2>
    <ul>
        <?php foreach ($products as $product) { ?>
            <li>
                <?php echo htmlspecialchars($product->productName); ?> 
                - $<?php echo number_format($product->price, 2); ?> 
                - <?php echo htmlspecialchars($product->seriesID); ?>
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
        <input type="hidden" name="action" value="search">
        
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
            <input type="text" name="seriesId" placeholder="seriesid">
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
<div class="add">
 <?php print_r($addProduct);
    ?>
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
