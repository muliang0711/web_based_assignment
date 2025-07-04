<?php
require '../../_base.php';
include __DIR__ . "/../../db_connection.php";
$title = 'Home Page';
$stylesheetArray = ['/css/admin_home.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
// $scriptArray = [];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js
include '../../admin_login_guard.php'; // Note: admin_login_guard contains redirect(), which MUST be before any HTML output
require_once  "../admin/main.php";
include __DIR__ . "/../../controller/stockManager.php";
$check = new CheckStock($_db);
$check->check_low_stock();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php
try {
    $_db = new PDO('mysql:dbname=web_based_assignment;host=localhost', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // Enable error reporting
    ]);

    // Query to count products
    $stmA = $_db->prepare("SELECT COUNT(*) AS TotalProducts FROM Product");
    $stmA->execute();
    $resultA = $stmA->fetch();

    $stmB = $_db->prepare("SELECT COUNT(*) AS TotalCustomer FROM user");
    $stmB->execute();
    $resultB = $stmB->fetch();


    $stmD = $_db->prepare("SELECT COUNT(*) AS TotalOrder FROM orders");
    $stmD->execute();
    $resultD = $stmD->fetch();

    $stmE = $_db->prepare("SELECT ROW_NUMBER() OVER (ORDER BY SUM(oi.quantity) DESC) AS rank,
    p.productName, oi.productId, 
    SUM(oi.quantity) AS total_quantity
        FROM order_items oi
        JOIN product p ON oi.productId = p.productID
        GROUP BY oi.productId, p.productName
        ORDER BY total_quantity DESC
        LIMIT 5;");
    $stmE->execute();
    // $resultE = $stmE->fetch();





    $stmC = $_db->prepare("SELECT 
    od.productId, 
    p.productName,
    SUM(od.subtotal) AS total_sales,
    SUM(od.quantity) AS total_sold, 
    (SUM(od.subtotal) / (SELECT SUM(subtotal) FROM order_items)) * 100 AS percentage
FROM order_items od
JOIN product p ON od.productId = p.productID
GROUP BY od.productId, p.productName
ORDER BY total_sales DESC
");
$stmC->execute();
$resultC = $stmC->fetchAll(PDO::FETCH_OBJ); // <<< 必须加上 FETCH_OBJ

$count = [];
$productName = [];
$percentage = [];

$counter = 0;
foreach ($resultC as $row) {
if ($counter >= 5) {
    break;
}
$productName[] = $row->productName;
$percentage[] = round($row->percentage, 2);
$count[] = $row->total_sold;
$counter++;
}

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());  // Handle connection errors
}
?>

<div class="main-content" style="  margin-left: var(--sidebar-width);
  margin-top: var(--topbar-height);
  padding: 1rem;">

    <div class="title">Sales</div>
    <div style="margin-left:10%;">
    <table class="block">
        
        <tr>
            <th>Total Product</th>
        </tr>
        <tr>
            <th><?= htmlspecialchars($resultA->TotalProducts) ?></th>
        </tr>
    </table>
    <table class="block">
        <tr>
            <th>Total Customer</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($resultB->TotalCustomer) ?></td>
        </tr>
    </table>
    <table class="block">
        <tr>
            <th>Total Order</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($resultD->TotalOrder) ?></td>
        </tr>
    </table>
</div>
<!-- 
    <table>
        ?php foreach ($resultB as $s): ?>
            <tr>
                <td>?= $s->ProductID ?></td>
                <td>?= $s->ProductName ?></td>
            </tr>
        ?php endforeach ?>
    </table> -->
    <br>
    <br>
    <br>

    <div class ="ranking">

             <table>
             <caption style="caption-side: top; font-weight: bold; font-size: 20px; padding: 10px; color:hsl(206, 100%, 30%)">
        Top 5 Best-Selling Products
    </caption>
             <tr >
                <th class="td">Ranking</th>
                <th class="td">Product ID</th>
                <th class="td">Product Name</th>
                <th class="td">Total Quantity</th>
        </tr>
        <?php foreach ($stmE as $e): ?>
             <tr class="th">

             <td class="td" ><?= $e->rank ?></td>
             <td class="td"><?= $e->productId ?></td>
             <td class="td"><?= $e->productName ?></td>
             <td class="td"><?= $e->total_quantity ?></td>
             </tr>  
             
             
             <?php endforeach ?>
             </table>
        </div>
        <br>
<br>
    <div class="Chart">
        <div class="pie">
        <canvas id="salesChart"></canvas>
        </div>
        <br><br>
        <div class="bar">
        <canvas id="salesCountChart"></canvas>
        </div>
        <script>
            //get percentage of  the variable $productName,percentage  ,then change it int o javascript array 
            const productName = <?php echo json_encode($productName); ?>;
const percentage = <?php echo json_encode($percentage); ?>;
const count = <?php echo json_encode($count); ?>;

new Chart("salesChart", {
    type: "pie",
    data: {
        labels: productName,
        datasets: [{
            backgroundColor: ["#8ecaf6", "#b8e1ff", "#b1d5ef", "#aac9df", "#aac9df", "#878c8f"],
            data: percentage
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
      
            title: {
                display: true,
                text: "Top 5 Product Sold Percentage"
            }
            
        
    }
});

            new Chart("salesCountChart", {
                type: "bar",
                data: {
                    labels: productName,
                    datasets: [{
                        backgroundColor: "#aac9df",
                        label: "Total Sold",
                        data: count
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: "Total Sold of Top 5 Product",
                        font: {size: 20
                        }
                    }
                }
            });
        </script>




    </div>



</div>
<?php
include '../../admin_foot.php';
?>