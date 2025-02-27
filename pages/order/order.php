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
        <span>Status</span>
    </div>
    <div class="order">
        <span class="orderID">#12345</span>
        <span class="orderAddress">PV18 RESIDENCES Kuala  Jalan Langkawi LUMPUR</span>
        <span class="orderDate">27/2/2025</span>
        <span class="orderStatus">Pending</span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>
    <div class="orderDetailed"></div>
    <div class="order">
        <span class="orderID">#55125</span>
        <span class="orderAddress">jalan ujong Pasir melaka 707070 malaysia</span>
        <span class="orderDate">12/8/2025</span>
        <span class="orderStatus">Delivered</span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>
    <div class="orderDetailed"></div>
    <div class="order">
        <span class="orderID">#66125</span>
        <span class="orderAddress">PV18 RESIDENCES Kuala  Jalan Langkawi LUMPUR</span>
        <span class="orderDate">27/2/2025</span>
        <span class="orderStatus">In Transit</span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>
    <div class="orderDetailed"></div>
</div>

<?php 
$scriptArray = ["order.js"];
include '../../_foot.php'; 
?>