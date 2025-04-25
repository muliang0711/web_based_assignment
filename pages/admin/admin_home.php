<?php
require '../../_base.php';

$title = 'Home Page';
$stylesheetArray = ['/css/admin_home.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
// $scriptArray = [];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js
require_once  "../admin/main.php";
include '../../admin_login_guard.php';

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

    //percentage of the product
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
    $resultC = $stmC->fetchAll();
    $count = [];
    $productName = []; //save the productname
    $percentage = []; //save the product sales percentage
    foreach ($resultC as $row) {
        $productName[] = $row->productName;  //save the product name into productName
        $percentage[] = round($row->percentage, 2);   //calculate the percentage into 2 小数 and save it into percentage array
        $count[] = $row->total_sold;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());  // Handle connection errors
}
?>

<div class="main-content" style="  margin-left: var(--sidebar-width);
  margin-top: var(--topbar-height);
  padding: 1rem;">
    <div class="title">Today Sales</div>
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
                        backgroundColor: ["#8ecaf6", "#b8e1ff", "#b1d5ef", "#aac9df", "#aac9df", "878c8f"],

                        data: percentage
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: "Each Product Sold Percentage",
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
                        text: "Total Sold of Each Product",
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