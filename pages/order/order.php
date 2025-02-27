<?php 
    require "../../_base.php";
    $title = 'Order | Page';
    $time = time();
    $stylesheetArray  = ["order.css?"];
    include "../../_head.php";

    $orders = [

    ];
?>


<h1>My orders</h1>
<div class="orders-container">
    <div class="order-header">
        <span>Order ID</span>
        <span>Address</span>
        <span>Ordered Date</span>
    </div>
    <div class="order">
        <span class="orderID">#12345</span>
        <span class="orderAddress">PV18 RESIDENCES Kuala  Jalan Langkawi LUMPUR</span>
        <span class="orderDate">27/2/2025</span>
    </div>
    <div class="order"></div>
    <div class="order"></div>
</div>

<?php 
$scripts = ['order.js'];
include '../../_foot.php'; 
?>