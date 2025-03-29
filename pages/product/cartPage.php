<?php
$stylesheetArray = ['product.css'];
$title = 'Product List';
require '../../_base.php';
include '../../_head.php';

?>

<?php
/*
    global $_db;
    global $_user;
    $_user = $_db->query("SELECT * FROM user WHERE userID = {$_SESSION['userID']}")->fetch();
    $_user->execute([]); 
    $userID = $_user->userID;
if(!$userID){
    redirect("http://localhost:8000/pages/user/user-login.php");
}
*/
?>

<?php
include '../../_foot.php';