<?php
require_once "../../../db/productStock.php";
require_once "../../../_base.php";      
include '../../../admin_login_guard.php';
$restockManager = new CheckStock($_db);

$restockRecordsList = $restockManager->getAllRestockRecords();
$productIDList = array_unique(array_column($restockRecordsList, 'productID'));
$adminList = array_unique(array_column($restockRecordsList, 'restocked_by'));

$recordsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$startFrom = ($page - 1) * $recordsPerPage;
$totalRecords = count($restockRecordsList);
$displayRecords = array_slice($restockRecordsList, $startFrom, $recordsPerPage);
$totalPages = ceil($totalRecords / $recordsPerPage);

$stylesheetArray = ['../../../css/admin_product.css'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restock History</title>
    <link rel="stylesheet" href="../../../css/main.css">
</head>

<body>
<div class="main-content">

    <div class="container-table">

    <div class="filter-section" style="padding: 1rem;">
    <form class="filter-form" method="POST" action="../../../controller/stockManager.php">
        <input type="hidden" name="action" value="filterRecord">

        <label for="productID">Product ID</label>
        <select name="productID" id="productID">
            <option value="">All</option>
            <?php foreach ($productIDList as $productID): ?>
                <option value="<?= htmlspecialchars($productID) ?>">
                    <?= htmlspecialchars($productID) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="sizeID">Size ID</label>
        <select name="sizeID" id="sizeID">
            <option value="">All</option>
            <option value="3UG5">3UG5</option>
            <option value="4UG5">4UG5</option>
        </select>

        <label for="restocked_by">Restocked By</label>
        <select name="restocked_by" id="restocked_by">
            <option value="">All</option>
            <?php foreach ($adminList as $adminName): ?>
                <option value="<?= htmlspecialchars($adminName) ?>">
                    <?= htmlspecialchars($adminName) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="startDate">Start Date</label>
        <input type="date" name="startDate" id="startDate">

        <label for="endDate">End Date</label>
        <input type="date" name="endDate" id="endDate">

        <button type="submit" style="margin-top: 10px;">Apply Filter</button>
    </form>
</div>


        <div class="tb-title">
            <h5 style="margin: 0;"><i class="fas fa-table"></i> Restock History</h5>
        </div>

        <div style="padding: 1rem;">
            <table class="tb">
                <thead>
                    <tr style="background-color: #f9f9f9;">
                        <th class="th">Restock ID</th>
                        <th class="th">Product ID</th>
                        <th class="th">Series ID</th>
                        <th class="th">Size ID</th>
                        <th class="th">Quantity</th>
                        <th class="th">Price (RM)</th>
                        <th class="th">Restocked By</th>
                        <th class="th">Restock Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($displayRecords as $record): ?>
                        <tr>
                            <td class="td"><?= htmlspecialchars($record['restockID']) ?></td>
                            <td class="td"><?= htmlspecialchars($record['productID']) ?></td>
                            <td class="td"><?= htmlspecialchars($record['seriesID']) ?></td>
                            <td class="td"><?= htmlspecialchars($record['sizeID']) ?></td>
                            <td class="td"><?= htmlspecialchars($record['restock_quantity']) ?></td>
                            <td class="td">RM<?= number_format($record['restock_price'], 2) ?></td>
                            <td class="td"><?= htmlspecialchars($record['restocked_by']) ?></td>
                            <td class="td"><?= htmlspecialchars($record['restock_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination" style="text-align: center; margin-top: 1rem;">
            <?php 
            $num_links = 5;
            $first_link = max(1, min($totalPages - $num_links + 1, $page - 2));
            $last_link  = max($num_links, min($totalPages, $page + 2));
            ?>

            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = $first_link; $i <= $last_link; $i++): ?>
                <a href="?page=<?= $i ?>" style="margin: 0 4px; <?= $i == $page ? 'font-weight: bold;' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>

            <div style="padding: 1rem; text-align: left;">
            <a href="/pages/admin/product/stock.php" class="action-btn-add" title="Back to Menu">
                <i class="fas fa-arrow-left"></i> Return to Menu
            </a>
        </div>

        </div>



    </div> 

</div> 
</body>
</html>
