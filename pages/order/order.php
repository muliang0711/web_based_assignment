<?php 
    require "../../_base.php";
    $title = 'Order | Page';
    $time = time();
    $stylesheetArray  = ["order.css?"];
    include "../../_head.php";

    //getting session info;
    $userId = $_SESSION['userID'] ?? '';
    
    //if userId not logged in then redirect to homepage
    if(!is_logged_in()){
        redirect("/");
    }
    //defining some colors to be used to display the progress of delivery
    $colorStatusBar = "linear-gradient(90deg, rgba(29,204,29,1) 0%, rgba(255,177,0,1) 77%)";
    $colorStatusDefault = "rgba(221, 214, 214, 0.514)";
    $colorStatusDone = "rgb(29, 204, 29)";
    $colorStatusPending = "rgb(255,177,0)";

    $colorArr = [
        //colors for pending
        [$colorStatusDone, $colorStatusBar, $colorStatusDefault, $colorStatusDefault, $colorStatusDefault],
        //colors for in transit
        [$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusBar,$colorStatusDefault],
        //colors for delivered
        [$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusDone]
    ];
    $index = 0;

    //setting the filter
    //by default, show all status type and from newest order date to oldest
    $showOnlyStatus = $_GET["stat"] ?? "";
    $sort = $_GET["sort"] ?? "desc"; 
    
    //fetching data
    try{
        $orders = $_db->query("Select o.*, sum(oi.subtotal) as total_price from
orders o JOIN order_items oi ON (o.orderId = oi.orderId) WHERE o.userId = $userId GROUP BY o.orderId ORDER BY o.orderDate $sort;")->fetchAll();
    $order_items = $_db->query("Select oi.*, p.productName FROM order_items oi JOIN product p ON (oi.productId = p.productID);")->fetchAll();
    }
    catch (PDOException $e){
        die(":( Couldn't Find What You're Looking For");
    }

?>


<h1>My Order</h1>
<div class="order-header">
        <span>Order ID</span>
        <span>Address</span>
        <span>Ordered Date</span>
        <span>Status</span>
</div>

<div class="orders-container">
    

    <?php foreach($orders as $o): ?>

        <?php
            if($o->status === "Pending"){
                //if status parameter is set and if the parameter is not pending then skip
                if(!empty($showOnlyStatus) and strtolower($showOnlyStatus) !== "pending")
                    continue;
                $index = 0;
            }
                
            else if ($o->status === "In Transit"){
                //if status parameter is set and if the parameter is not intransit then skip
                if(!empty($showOnlyStatus) and strtolower($showOnlyStatus)!== "intransit")
                    continue;
                $index = 1;
            }
            else {
                //if status parameter is set and if the parameter is not delivered then skip
                if(!empty($showOnlyStatus) and strtolower($showOnlyStatus)!== "delivered")
                    continue;
                $index = 2;
            }

        ?>
    <div class="order">
        <span class="orderID">#<?=$o->orderId?></span>
        <span class="orderAddress"><?=$o->orderAddress?></span>
        <span class="orderDate"><?=substr($o->orderDate,8,2) . '/' . substr($o->orderDate,5,2) . '/' . substr($o->orderDate,0,4) ?></span>
        <span class="orderStatus"><?=$o->status?></span>
        <button class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>

    <div class="orderDetailed">
            <div class="order-details-wrapper">
                <div class="orderProgress">

                    <div class="order-placed">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="<?= $colorArr[$index][0] ?>"><path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z"/></svg>
                        <div>Order Placed</div>
                        <div class="progress1" style="background: <?= $colorArr[$index][1] ?>;"></div>
                    </div>
                    <div class="order-intransit">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="<?= $colorArr[$index][2] ?>"><path d="M280-160q-50 0-85-35t-35-85H60l18-80h113q17-19 40-29.5t49-10.5q26 0 49 10.5t40 29.5h167l84-360H182l4-17q6-28 27.5-45.5T264-800h456l-37 160h117l120 160-40 200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H400q0 50-35 85t-85 35Zm357-280h193l4-21-74-99h-95l-28 120Zm-19-273 2-7-84 360 2-7 34-146 46-200ZM20-427l20-80h220l-20 80H20Zm80-146 20-80h260l-20 80H100Zm180 333q17 0 28.5-11.5T320-280q0-17-11.5-28.5T280-320q-17 0-28.5 11.5T240-280q0 17 11.5 28.5T280-240Zm400 0q17 0 28.5-11.5T720-280q0-17-11.5-28.5T680-320q-17 0-28.5 11.5T640-280q0 17 11.5 28.5T680-240Z"/></svg>
                        <div>In Transit</div>
                        <div class="progress2" style="background: <?= $colorArr[$index][3] ?>;"></div>
                    </div>
                    <div class="order-delivered">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="<?= $colorArr[$index][4] ?>"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                        <div>Delivered</div>
                    </div>
                </div>

                <div class="order-items-container">
                    <?php foreach($order_items as $oi):?>
                        <?php if($o->orderId === $oi->orderId):?>
                    <div class='items-container'>
                        <img alt="Item Image" src="https://www.yonex.com/media/catalog/product/b/4/b4000g_2023_2.png?quality=80&fit=bounds&height=819&width=600&canvas=600:819"></img>
                        <span class="item-name"><?= $oi->productName ?></span>
                        <span class="item-series"><?= $oi->gripSize ?></span>
                        <span class="item-quantity">x <?= $oi->quantity ?></span>
                        <span class="item-subtotal">RM <?= $oi->subtotal ?></span>
                    </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>

                <div class="order-total-container">
                    <?= $index===0? '<button class="cancel-order">Cancel Order</button>' : "" ?>
                    <div class="total-text">Total: RM <?= $o->total_price ?></div>
                </div> 

            </div>
    </div>

    <?php endforeach; ?>
</div>

<?php 
$scriptArray = ["order.js"];
include '../../_foot.php'; 
?>