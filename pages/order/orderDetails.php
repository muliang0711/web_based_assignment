<?php 
    require "../../_base.php";
    $title = "Order Details";
    $stylesheetArray  = ["orderDetails.css?"];
    include "../../_head.php";

    $orderId = $_GET["id"] ?? "";

    //getting all the orders and order items from database
    try{
        $orderId=="" ? throw new Exception("Order ID is required.")  : null;
        
        $order = $_db->prepare("SELECT * FROM orders WHERE orderId=?");
        $order->execute([$orderId]);
        $order = $order -> fetchAll();

        $orderItems = $_db->prepare("SELECT * FROM order_items WHERE orderId=?");
        $orderItems->execute([$orderId]);
        $orderItems = $orderItems->fetchAll();
    }
    catch (PDOException | Exception $e){
        die(":( Couldn't Find What You're Looking For");
    }
?>


<span>Order#:12345</span>
<div class="container">
<div class="status-container">Show status and address here</div>
<div class="summary-container">Order Summary Here</div>
<div class="email-container">Notify email here</div>
<div class="buttons-container">Buttons here</div>
</div>





<?php 
    include "../../_foot.php";
?>