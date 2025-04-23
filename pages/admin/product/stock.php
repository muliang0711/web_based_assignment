<?php
require_once __DIR__ . "/../../../_base.php";
include_once __DIR__ . "/../../../admin_login_guard.php";
include __DIR__ . "/../main.php";
include __DIR__ . "/../../../controller/stockManager.php";
require_once "../../../controller/productController.php";
include __DIR__  . '/../../../admin_login_guard.php';
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
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

</head>
<style>#qr-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 999;
}

#cancel-scan {
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
}
#cancel-scan:hover {
    background-color: #cc0000;
}
</style>
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

            <!-- Restock Product -->
            <button class="action-btn-restock" style="margin-top: 10px; background-color: #28a745; color: white; padding: 10px; border: none; border-radius: 5px;">
                Restock Product <i class="fas fa-qrcode"></i>
            </button>

            <div id="qr-wrapper" style="display: none;">
                <div id="qr-reader" style="width: 300px;"></div>
                <button id="cancel-scan" style="margin-top: 10px;">Cancel</button>
            </div>


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
                                    <a href="productDetails.php?productID=<?php echo $product->productID; ?>&sizeID=<?php echo $product->sizeID; ?>" class="action-btn-details">
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

    <script>
const restockBtn = document.querySelector(".action-btn-restock");
const qrWrapper = document.getElementById("qr-wrapper");
const cancelBtn = document.getElementById("cancel-scan");
let html5QrCode = null;

restockBtn.addEventListener("click", function () {
    qrWrapper.style.display = "flex";
    html5QrCode = new Html5Qrcode("qr-reader");

    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 350 },
        (decodedText) => {
            html5QrCode.stop().then(() => {
                qrWrapper.style.display = "none";
                if (decodedText.includes("verify-stock.php?")) {
                    window.location.href = decodedText;
                } else {
                    alert("Invalid QR Code.");
                }
            });
        },
        (errorMessage) => { /* no match */ }
    ).catch(err => {
        console.error("Camera start error:", err);
    });
});

cancelBtn.addEventListener("click", function () {
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            qrWrapper.style.display = "none";
        }).catch(err => {
            console.error("Error stopping scanner:", err);
        });
    } else {
        qrWrapper.style.display = "none";
    }
});
</script>
</body>
</html>
