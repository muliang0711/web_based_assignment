<?php
require_once __DIR__ . "/../../../_base.php";
include_once __DIR__ . "/../../../admin_login_guard.php";
include __DIR__ . "/../main.php";

$lowStockProducts = $_SESSION['low_stock_product'] ?? [];
if (!is_array($lowStockProducts)) $lowStockProducts = [];

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
                                    <td class="td"><?= htmlspecialchars($product->total_stock ?? '0') ?></td>
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