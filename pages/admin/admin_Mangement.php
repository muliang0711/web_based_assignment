<?php
require '../../_base.php';
require '/function/base_function.php';

$title='Admin Management';
$stylesheetArray = ['/css/admin_Management.css'];   // 注意：这边只放特定于此页面的 .css file(s)。所有 admin 页面都会用到的 .css files 应放在 /css/admin.css
// $scriptArray = [];       // 注意：这边只放特定于此页面的 .js file(s)。所有 admin 页面都会用到的 .js files 应放在 /js/admin.js

include '../../admin_head.php';
?>

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

<?php
if(isPost()){
    $id         =req('id');
    $name       =req('name');
    $password   =req('password');
    $verifyPassword=req('verify_password');


    if($id=''){}


}


?>




<div class="container">


</div>


<?php
require '../../admin_foot.php';
?>