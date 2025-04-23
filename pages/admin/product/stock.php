<?php
require_once __DIR__ . "/../../../_base.php";
include_once __DIR__ . "/../../../admin_login_guard.php";
//include __DIR__ . "/../main.php";
include __DIR__ . "/../../../controller/stockManager.php";
require_once "../../../controller/productController.php";

$productManager->loadLowStockProductsToSession();

$lowStockProducts = $_SESSION['low_stock_product'] ?? [];
if (!is_array($lowStockProducts)) $lowStockProducts = [];

$seriesIdList = $productController->getAllSeriesID();
$productIDList = $productController->getAllProductID();


$productsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$startFrom = ($page - 1) * $productsPerPage;


$totalProducts = count($lowStockProducts);
$displayProducts = array_slice($lowStockProducts, $startFrom, $productsPerPage);
$totalPages = ceil($totalProducts / $productsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Low Stock Products</title>
    <link rel="stylesheet" href="../../../css/admin_product.css">
</head>

<body>
    <div class="main-content">

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
        <div class="container-table">
            <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-table"></i> Product </h5>
            </div>

            <div style="padding: 1rem;">
                <table class="tb">
                    <thead>
                        <tr style="background-color: #f9f9f9;">
                            <th class="th">product ID</th>
                            <th class="th">series ID</th>
                            <th class="th">sizeID</th>
                            <th class="th">price</th>
                            <th class="th">stock</th>
                            <th class="th">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($displayProducts)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center;">No low stock products found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($displayProducts as $product): ?>
                                <tr>
                                    <td class="td"><?= htmlspecialchars($product->productID) ?></td>
                                    <td class="td"><?= htmlspecialchars($product->seriesID ?? '-') ?></td>
                                    <td class="td"><?= htmlspecialchars($product->sizeID ?? '-') ?></td>
                                    <td class="td">RM<?= number_format($product->price, 2) ?></td>
                                    <td class="td"><?= htmlspecialchars($product->stock ?? '0') ?></td>
                                    <td class="td">
                                        <a href="../product/productDetail.php?racket=<?= $product->productID ?>" class="action-btn-details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination" style="text-align: center; margin-top: 1rem;">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" style="margin: 0 4px; <?= $i == $page ? 'font-weight: bold;' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>

    </div>
</body>

</html>