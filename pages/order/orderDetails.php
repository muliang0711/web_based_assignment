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


<span title="order ID" style="display:inline-block; margin-bottom: 20px; font-size: 30px; font-weight: bold;color: rgba(90, 90, 90, 0.58);">
    Order #12345
</span>

<div class="container">

    <div class="status-container">

        <div id="delivery-date">
            <span>Estimated Delivery Date</span><br>
            <span>Monday, May 30</span>
        </div>

        <div id="delivery-status">
            <span>Out For Delivery</span><br>
            <span>Your package is on the way</span>
        </div>

        <div id="address-container">
            <div id="address">
                <span>Shipping Address</span>
                <p>
                    Jane Doe<br>
                    1455 market street,<br>
                    San Francisco CA 19077<br>
                    United States
                </p>
            </div>
            <div id="method">
                <span>Delivery Method</span>
                <p>Standard (3-5 Business Days)</p>
            </div>
        </div>

        <div id="courier-type">
            <img id="courier-logo" src="https://img.sp.mms.shopee.com.my/my-11134141-7qukz-ljcfbwec82126d"><br>
            <span title="track order">Tracking ID: <a href="https://spx.com.my/track?123123123123123" target="_blank" style="color: rgb(10,132,255);">123123123123123</a> </span>
        </div>
    </div>

    <div class="summary-container">Order Summary Here</div>

    <div class="email-container">
        <span>Sign Up for Email Notifications</span>
        <p>Get delivery updates sent directly to <span style="font-weight: 500;">wayneganyw@gmail.com</span>. By signing up for SMS updates for this order, you accept our <a href="about:blank" target="_blank" style="color: rgb(10,132,255);">terms of use</a></p>
        <button>
            Get delivery updates
        </button>
    </div>

    <div class="buttons-container">Buttons here</div>

</div>





<?php 
    include "../../_foot.php";
?>