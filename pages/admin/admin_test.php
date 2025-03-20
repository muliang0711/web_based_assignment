<?php

require_once "../../db_connection.php";
require_once "../../controller/productController.php";
require_once "../../_base.php";
require_once "../admin/main.php";
;$stylesheetArray = ['../../css/admin_sales.css'];
link_stylesheet($stylesheetArray);

$productController = new ProductController($_db);

// Fetch total sales data (if any form submission happened before)
$totalSalesData = $_SESSION['total_sales_results'] ?? [];
unset($_SESSION['total_sales_results']);

// Fetch product sales data (if any form submission happened before)
$productSalesData = $_SESSION['product_sales_results'] ?? [];
unset($_SESSION['product_sales_results']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Tracking Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Total Sales Tracker</h2>
        <form action="../../controller/productController.php" method="post">
            <input type="hidden" name="action" value="totalsellTrack">
            <div class="row">
                <div class="col-md-4">
                    <label>Start Date:</label>
                    <input type="date" name="startDate" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>End Date:</label>
                    <input type="date" name="endDate" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Status:</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Fetch Sales Data</button>
        </form>
        <div class="mt-4">
            <h3>Results:</h3>
            <?php if (!empty($totalSalesData)): ?>
                <table class='table table-striped'>
                    <tr><th>Order ID</th><th>Total Revenue</th><th>Total Quantity</th></tr>
                    <?php foreach ($totalSalesData as $row): ?>
                        <tr>     
                            <td><?= htmlspecialchars($row['orderId']) ?></td>
                            <td>$<?= number_format($row['total_revenue'], 2) ?></td>
                            <td><?= htmlspecialchars($row['total_quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No sales data found.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Product Sales Tracker</h2>
        <form action="../../controller/productController.php" method="post">
            <input type="hidden" name="action" value="productSellTrack">
            <div class="row">
                <div class="col-md-4">
                    <label>Start Date:</label>
                    <input type="date" name="startDate" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>End Date:</label>
                    <input type="date" name="endDate" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Size ID (Optional):</label>
                    <input type="text" name="sizeID" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-3">Fetch Product Sales Data</button>
        </form>
        <div class="mt-4">
            <h3>Results:</h3>
            <?php if (!empty($productSalesData)): ?>
                <table class='table table-striped'>
                    <tr><th>Product ID</th><th>Series ID</th><th>Size ID</th><th>Total Sales</th><th>Total Revenue</th></tr>
                    <?php foreach ($productSalesData as $row): ?>
                        <tr>
                        <td><?= $row->productID ?></td>
                    <td><?= $row->seriesID ?></td>
                    <td><?= $row->sizeID ?></td>
                    <td><?= $row->total_sales ?></td>
                    <td>$<?= number_format($row->total_revenue, 2) ?></td>

                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No product sales data found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
