<?php
require_once "../../../db/productStock.php";
require_once "../../../_base.php";      
include '../../../admin_login_guard.php';


$restockRecordsList = $_SESSION['filterRecordResult'] ?? [];

$recordsPerPage = 10;
$totalRecords = count($restockRecordsList);

$totalPages = ($totalRecords > 0) ? ceil($totalRecords / $recordsPerPage) : 1;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));

$startFrom = ($page - 1) * $recordsPerPage;


$displayRecords = array_slice($restockRecordsList, $startFrom, $recordsPerPage);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Filtered Restock History</title>
    <link rel="stylesheet" href="../../../css/main.css">
</head>

<body>
    <div class="main-content">

        <div class="container-table">

            <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-filter"></i> Filtered Restock History</h5>
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
                        <?php if (empty($displayRecords)): ?>
                            <tr>
                                <td class="td" colspan="8" style="text-align:center;">No record found.</td>
                            </tr>
                        <?php endif; ?>
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

            <!-- Pagination Section -->
            <div class="pagination" style="text-align: center; margin-top: 1rem;">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
                <?php endif; ?>

                <?php
                $num_links = 5;
                $first_link = max(1, $page - floor($num_links / 2));
                $last_link = min($totalPages, $first_link + $num_links - 1);

                for ($i = $first_link; $i <= $last_link; $i++): ?>
                    <a href="?page=<?= $i ?>" style="margin: 0 4px; <?= $i == $page ? 'font-weight: bold;' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
                <?php endif; ?>
                <div style="padding: 1rem;">
                    <a href="/pages/admin/product/restock_history.php" class="action-btn-add" title="Return to Menu">
                        <i class="fas fa-arrow-left"></i> Return to Menu
                    </a>
                </div>
            </div>



        </div>

    </div>
</body>

</html>