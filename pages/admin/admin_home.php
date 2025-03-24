<?php
require '../../_base.php';
require_once  "../admin/main.php";
$title='Home Page';
$stylesheetArray = ['/css/admin_home.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
// $scriptArray = [];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js


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

    $stmB = $_db->prepare("SELECT ProductID,ProductName FROM Product");
    $stmB->execute();  
    $resultB = $stmB->fetchAll();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());  // Handle connection errors
}
?>

<div class="title">Today Sales</div>
<div class="container">
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
            <th>Total Product</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($resultA->TotalProducts) ?></td>
        </tr>
    </table>
    <table class="block">
        <tr>
            <th>Total Product</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($resultA->TotalProducts) ?></td>
        </tr>
    </table>
</div>

<table>
<?php foreach ($resultB as $s): ?>
    <tr>
        <td><?= $s->ProductID ?></td>
        <td><?= $s->ProductName ?></td>
    </tr>
    <?php endforeach ?>
</table>
 
<?php 
include '../../admin_foot.php';
?>

