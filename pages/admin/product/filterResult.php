<?php
require_once "../../../_base.php";
require_once "../../../controller/productManager.php";
include __DIR__ . "/../../../admin_login_guard.php";
$stylesheetArray = ['../../../css/main.css'];
link_stylesheet($stylesheetArray);

$filterResult = $_SESSION['filterResult'] ?? [];

// navigation program : 

// 1. set max item in perpage 
$productsPerPage = 10;

// get current page from url ; default to 1 if none 
$page           = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// calculate the item start from where 
$startFrom      = ($page - 1) * $productsPerPage;
// get total product number from result 
$totalProducts  = count($filterResult);
// function to decide the page item start from where 
// 50 ; 10 ; 10 --> than that page will start from product id 10 to 20 
$pagedProducts  = array_slice($filterResult, $startFrom, $productsPerPage);
// ensure product page is enough
$totalPages     = ceil($totalProducts / $productsPerPage);


// var_dump($filterResult);
// handle error 
if ($totalProducts === 0) {
    echo "<p>No search results found.</p>";
    exit();
}
if (empty($filterResult)) {
    echo "<p>No filter results found for: <strong>" . "</strong></p>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<body>

    <div class="main-content ">

        <div class="container-table">

            <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-table"></i> Product You Search </h5>
            </div>


            <div style="padding: 1rem;">
                <table class="tb ">

                    <thead>
                        <tr style="background-color: #f9f9f9;">
                            <th class="th">product ID </th>
                            <th class="th">product Name </th>
                            <th class="th">series ID</th>
                            <th class="th">series Name</th>
                            <th class="th">sizeID</th>
                            <th class="th">price</th>
                            <th class="th">stock</th>
                            <th class="th">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($pagedProducts as $index => $product): ?>

                            <!-- Product Info -->
                            <tr>
                                <td class="td searchtext"><?php echo htmlspecialchars($product->productID); ?></td>
                                <td class="td searchtext"><?php echo htmlspecialchars($product->productName); ?></td>
                                <td class="td searchtext"><?php echo htmlspecialchars($product->seriesID); ?></td>
                                <td class="td searchtext"><?php echo htmlspecialchars($product->seriesName); ?></td>
                                <td class="td searchtext"><?php echo htmlspecialchars($product->sizeID); ?></td>
                                <td class="td searchtext">RM<?php echo number_format($product->price, 2); ?></td>
                                <td class="td searchtext"><?php echo htmlspecialchars($product->total_stock); ?></td>
                                <td class="td">
                                    <!-- View Details -->
                                    <a href="productDetails.php?productID=<?php echo $product->productID; ?>&sizeID=<?php echo $product->sizeID; ?>" class="action-btn-details">
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    <!-- Edit -->
                                    <a href="editProduct.php?productID=<?php echo $product->productID; ?> &sizeID=<?php echo $product->sizeID; ?>" class="action-btn-edit" title="Edit Product">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!--<form method="POST" action="/controller/productManager.php" class="delete-form" style="display:inline;">
                                        <input type="hidden" name="action" value="deleteProduct">
                                        <input type="hidden" name="productId" value="<?// php echo $product->productID; ?>">
                                        <input type="hidden" name="sizeId" value="<?// php echo $product->sizeID; ?>">
                                        <button type="submit" class="action-btn-delete" data-productid="<?// php echo $product->productID; ?>" data-sizeid="<?// php echo $product->sizeID; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form> -->


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
                <a href="?page=<?php echo $i; ?>"
                    style="margin: 0 4px; <?php if ($i == $page) echo 'font-weight: bold;'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>

            <button type="button" class="back-btn" onclick="window.location.href='admin_product.php'">← Back</button>
        </div>
    </div>


</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/pages/admin/product/searchResult.js"></script>