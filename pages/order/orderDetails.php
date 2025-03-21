<?php 
    require "../../_base.php";
    $title = "Order Details";
    $stylesheetArray  = ["orderDetails.css?"];
    include "../../_head.php";

    $orderId = $_GET["id"] ?? "";

    //getting all the orders and order items from database
    try{
        $orderId=="" ? throw new Exception("Order ID is required.")  : null;

        
        $order = $_db->prepare("SELECT o.*, o.orderDate + INTERVAL 3 DAY as estimatedDate, u.email, sum(oi.subtotal)-o.discount as totalPrice FROM
                                orders o JOIN order_items oi ON (o.orderId = oi.orderId)
                                JOIN user u ON (u.userID = o.userId)
                                GROUP BY o.orderId HAVING o.orderId = ?;");
        $order->execute([$orderId]);
        $order = $order -> fetch(PDO::FETCH_OBJ);



        $orderItems = $_db->prepare("SELECT * FROM order_items WHERE orderId=?");
        $orderItems->execute([$orderId]);
        $orderItems = $orderItems->fetchAll();
    }
    catch (PDOException | Exception $e){
        die(":( Couldn't Find What You're Looking For");
    }

    $deliveredColor = "rgb(45, 153, 45)";
    $pendingColor = "rgba(255,177,0,1)";

    //delivery method can only be express or standard
    preg_match("/(\d{5}),\s*([A-Za-z\s]+)/", $order->orderAddress, $matches);
    $street = trim(str_replace($matches[0], "", $order->orderAddress));
    $postcode = $matches[1];
    $state = trim($matches[2]);
    $deliverySpeed = $order->deliveryMethod == "Standard" ? "3-5" : "1-3";
    $trackingId = $order->tracking != NULL? $order->tracking : "Coming Soon!";

    //if order is delivered
    if($order->deliveredDate!=NULL){
        $msg = "Delivered On";
        $msg2 = "Delivered";
        $msg3 = "Your package has been delivered";
        $Day = date("l", strtotime($order->deliveredDate));
        $Month = date("M", strtotime($order->deliveredDate));
        $Date = date("d", strtotime($order->deliveredDate));
        $color = $deliveredColor;
    }
    //if order is in transit
    else if ($order->status == "Pending"){
        $msg = "Estimated Delivery Date";
        $msg2 = "Out For Delivery";
        $msg3 = "Your package is on the way";
        $Day = date("l", strtotime($order->estimatedDate));
        $Month = date("M", strtotime($order->estimatedDate));
        $Date = date("d", strtotime($order->estimatedDate));
        $color = $deliveredColor;
    }
    //if order has been received
    else {
        $msg = "Estimated Delivery Date";
        $msg2 = "Processing Order";
        $msg3 = "Your order has been received";
        $Day = date("l", strtotime($order->estimatedDate));
        $Month = date("M", strtotime($order->estimatedDate));
        $Date = date("d", strtotime($order->estimatedDate));
        $color = $pendingColor;
    }
    
?>


<span title="order ID" style="display:inline-block; margin-bottom: 20px; font-size: 30px; font-weight: bold;color: rgba(90, 90, 90, 0.58);">
    Order #<?= $order->orderId ?>
</span>

<div class="giant-container">

<div class="container1">

    <div class="status-container">

        <div id="delivery-date">
            <span><?= $msg ?></span><br>
            <span><?= $Day . ", " . $Month . " " . $Date ?></span>
        </div>

        <div id="delivery-status">
            <span style="color:<?= $color ?>;"><?= $msg2 ?></span><br>
            <span><?= $msg3 ?></span>
        </div>

        <div id="address-container">
            <div id="address">
                <span>Shipping Address</span>
                <p>
                    <?= $street ?><br>
                    <?= $state . " " . $postcode . "," ?><br>
                    Malaysia
                </p>
            </div>
            <div id="method">
                <span>Delivery Method</span>
                <p>Standard (<?= $deliverySpeed ?> Business Days)</p>
            </div>
        </div>

        <div id="courier-type">
            <img id="courier-logo" src="https://img.sp.mms.shopee.com.my/my-11134141-7qukz-ljcfbwec82126d"><br>
            <span title="track order">
                Tracking ID: 
                <a <?= $trackingId != "Coming Soon!" ? "href='https://spx.com.my/track?$trackingId' style='color: rgb(10,132,255);'" : "" ?>  target="_blank">
                    <?= $trackingId ?>
                </a> 
            </span>
        </div>
    </div>



    <div class="email-container">
        <span>Sign Up for Email Notifications</span>
        <p>Get delivery updates sent directly to <span style="color: var(--seclessImportant);font-weight: 500;"><?= $order->email ?></span>. By signing up for SMS updates for this order, you accept our <a href="about:blank" target="_blank" style="color: rgb(10,132,255);">terms of use</a></p>
        <button class="email-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(39, 39, 39)"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/></svg>
            <span>Get delivery updates</span>
        </button>
    </div>



    </div>



    <div class="container2">

        <div class="summary-container">
            <span>Order Summary</span>

            <div class="order-items">
                <div class="item">
                    <img src="https://www.yonex.com/media/catalog/product/3/a/3ax88d-t_076-1_02.png">
                    <span class="product-name" >Yonex Astrox 3000 GD</span>
                    <span class="product-quantity">x1</span>
                    <span class="product-subtotal">RM 169.99</span>
                    <span class="product-variation">3UG5</span>
                </div>
            </div>

            <div class="subtotal">
                <span>Subtotal</span>
                <span>RM 49.99</span>
            </div>

            <hr>
            <div class="shipping-fee">
                <span>Shipping</span>
                <span>Free</span>
            </div>

            <div class="discount">
                <span>Discount</span>
                <span>RM 4.55</span>
            </div>

            <hr>
            <div class="total">
                <span>Total</span>
                <span>RM 55.54</span>
            </div>
        </div>



        <div class="buttons-container">
            <button>Cancel Order</button>
            <button>Contact Support</button>
        </div>

    </div>


</div>




<?php 
    include "../../_foot.php";
?>