<?php 
    require "../../_base.php";
    $title = 'Order | Page';
    $time = time();
    $stylesheetArray  = ["order.css?v={$time}"];
    include "../../_head.php";
?>


<h1>My orders</h1>
<div class="orders-container">
    <div class="order"></div>
    <div class="order"></div>
    <div class="order"></div>
</div>

<?php 
$scripts = ['order.js'];
include '../../_foot.php'; 
?>