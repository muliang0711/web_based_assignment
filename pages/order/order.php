<?php 
    require "../../_base.php";
    $title = 'Order | Page';
    $time = time();
    $stylesheetArray  = ["order.css?"];
    include "../../_head.php";

    include '../../_login_guard.php';
    extract((array)$_user);
   
    $userId = $_user->userID;
    //defining some colors to be used to display the progress of delivery
    $colorStatusBar = "linear-gradient(90deg, rgba(29,204,29,1) 0%, rgba(255,177,0,1) 77%)";
    $colorStatusDefault = "rgba(221, 214, 214, 0.514)";
    $colorStatusDone = "rgb(25, 165, 25)";
    $colorStatusPending = "rgb(255,177,0)";

    $colorDelivered = "rgb(54, 187, 65)";
    $colorIntransit = "rgb(255, 198, 11)";
    $colorPending = "rgb(92, 91, 91)";

    $colorDeliveredBG = "rgba(54, 187, 65, 0.15)";
    $colorIntransitBG = "rgba(255, 198, 11, 0.15)";
    $colorPendingBG = "rgba(92, 91, 91, 0.15)";

    $colorArr = [
        //colors for pending
        [$colorStatusDone, $colorStatusBar, $colorStatusDefault, $colorStatusDefault, $colorStatusDefault, $colorPending, $colorPendingBG],
        //colors for in transit
        [$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusBar,$colorStatusDefault, $colorIntransit, $colorIntransitBG],
        //colors for delivered
        [$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusDone,$colorStatusDone, $colorDelivered, $colorDeliveredBG]
    ];
    $index = 0;

    //setting the filter
    //by default, show all status type and from newest order date to oldest
    $showOnlyStatus = $_GET["stat"] ?? "";
    $sort = $_GET["sort"] ?? "desc"; 
    $pricemin = $_GET["pricemin"] ?? "0"; 
    $pricemax = $_GET["pricemax"] ?? "10000"; 
    
    //fetching data
    try{
        $orders = $_db->query("Select o.*, sum(oi.subtotal) as total_price from
                                orders o JOIN order_items oi ON (o.orderId = oi.orderId) WHERE o.userId = $userId GROUP BY o.orderId HAVING total_price BETWEEN $pricemin AND $pricemax ORDER BY o.orderDate $sort;")->fetchAll();

    }
    catch (PDOException $e){
        die(":( Couldn't Find What You're Looking For");
    }
    if(count($orders) == 0){
        die("No orders yet");
    }
?>


<h1>My Order</h1>

<div id="filter-menu">
        <form method="GET">
            <label id="labelpricemin" for="pricemin">Price (min)  RM <?= $pricemin ?></label>
            <input type="range" name="pricemin" min="0" max="10000" value="<?= $pricemin ?>" class="slider" id="pricemin" step='100'><br><br>
            
            <label id="labelpricemax" for="pricemax">Price (max)  RM <?= $pricemax ?></label>
            <input type="range" name="pricemax" min="0" max="10000" value="<?= $pricemax ?>" class="slider" id="pricemax" step='100'><br><br>
            
            
            <label for="Status">Status</label><br>
            <select id='selectStatus' name="stat">
                <option value="">All</option>
                <option value="delivered" <?= $showOnlyStatus=="delivered" ? "selected" : "" ?> >Delivered</option>
                <option value="intransit" <?= $showOnlyStatus=="intransit" ? "selected" : "" ?> >In Transit</option>
                <option value="pending" <?= $showOnlyStatus=="pending" ? "selected" : "" ?> >Pending</option>
            </select><br><br>


            <label for="Date">Date</label><br>
            <select id='selectDate' name="sort">
                <option value="desc" <?= $sort=="desc" ? "selected" : "" ?> >Latest</option>
                <option value="asc" <?= $sort=="asc" ? "selected" : "" ?> >Oldest</option>
            </select><br><br>

            <div id="form-button-container">
                <button class = "resetbutton" type="reset">Reset</button>
                <button type="submit">Filter</button>
            </div>
            
        </form>
</div>

<div class="order-header">
        <span>Order ID</span>
        <span>Address</span>
        <span>Ordered Date</span>
        <span>Status</span>
        <span></span>
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
    <div class="order" data-order-id="<?=$o->orderId?>" style="cursor:pointer;">
        <span class="orderID">#<?=$o->orderId?></span>
        <span class="orderAddress"><?=$o->orderAddress?></span>
        <span class="orderDate"><?=substr($o->orderDate,8,2) . '/' . substr($o->orderDate,5,2) . '/' . substr($o->orderDate,0,4) ?></span>
        <span class="orderStatus" style="border: 2px solid <?= $colorArr[$index][5] ?>; border-radius: 15px; color: <?= $colorArr[$index][5] ?>; background: <?= $colorArr[$index][6] ?>"><?=$o->status?></span>
        <button class="dropdown" data-order-id="<?=$o->orderId?>">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
    </div>

    <?php endforeach; ?>
</div>

<?php 
$scriptArray = ["order.js"];
include '../../_foot.php'; 
?>