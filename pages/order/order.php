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
    $showOnlyStatus = $_GET["status"] ?? "'Pending', 'In Transit', 'Delivered', 'Canceled'";
    $sort = $_GET["date"] ?? "desc"; 
    $price = $_GET["price"] ?? "desc"; 

    if(isset($_GET["date"])){
        $sort = ($_GET["date"]=="desc" || $_GET["date"]=="asc") ? $_GET["date"] : "desc";
    }

    if(isset($_GET["price"])){
        $sort = ($_GET["price"]=="desc" || $_GET["price"]=="asc") ? $_GET["price"] : "desc";
    }

    if(isset($_GET["status"])){
        $showOnlyStatus = '"' . implode('", "', $_GET["status"]) . '"';
        
    }
    //fetching data
    try{
        $sql = "Select o.*, sum(oi.subtotal) as total_price from
                                orders o JOIN order_items oi ON (o.orderId = oi.orderId) 
                                WHERE o.userId = $userId AND o.status in ($showOnlyStatus)
                                GROUP BY o.orderId ORDER BY o.orderDate $sort, total_price $price";
        $orders = $_db->prepare($sql);

       $orders->execute();
        $orders = $orders->fetchAll();

    }
    catch (PDOException $e){
        die(":( Couldn't Find What You're Looking For");
    }
    if(count($orders) == 0){
        die("No orders yet");
    }
?>




<ul class="filtermenu">
    <form method="GET">
            

            <label>Price</label><br>
                <div class="pricediv">
                <div><input class="radio" type="radio" value="desc" name="price" id="pricedesc" <?= $price=="desc"? "checked":"" ?>><label for="pricedesc">Highest</label></div>
                <div><input class="radio" type="radio" value="asc" name="price" id="priceasc" <?= $price=="asc"? "checked":"" ?>><label for="priceasc">Lowest</label></div>
                </div>
            
            <label>Status</label><br>

                <div class="statusdiv">
                    <div><input type="checkbox" name="status[]" id="all" <?= $showOnlyStatus=="'Pending', 'In Transit', 'Delivered', 'Canceled'"? "checked":"" ?>><label for="all" class="statuslabel all">All</label></div> 
                    <div><input type="checkbox" name="status[]"  value="Delivered" id="delivered" <?= strpos($showOnlyStatus,"Delivered") ? "checked" : "" ?> ><label for="delivered" class="statuslabel delivered">Delivered</label></div>
                    <div><input type="checkbox" name="status[]" value="In Transit" id="intransit"<?= strpos($showOnlyStatus,"In Transit") ? "checked" : "" ?> ><label for="intransit" class="statuslabel intransit">In Transit</label></div>
                    <div><input type="checkbox" name="status[]"  value="Pending" id="pending" <?= strpos($showOnlyStatus,"Pending") ? "checked" : "" ?> ><label for="pending" class="statuslabel pending">Pending</label></div>
                    <div><input type="checkbox" name="status[]"  value="Canceled" id="canceled" <?= strpos($showOnlyStatus,"Canceled") ? "checked" : "" ?> ><label for="canceled" class="statuslabel canceled">Canceled</label></div>
                </div>
                


            <label>Date</label><br>
                <div class="datediv">
                <div><input class="radio" type="radio" name="date" value="desc" id="latestDate" <?= $sort=="desc"? "checked":"" ?>><label for="latestDate">Latest</label></div> 
                <div><input class="radio" type="radio" name="date" value="asc" id="oldestDate" <?= $sort=="asc"? "checked":"" ?>><label for="oldestDate">Oldest</label></div> 
                </div>


            <div id="form-button-container">
                <button class = "resetbutton" type="reset">Clear</button>
                <button type="submit">Apply</button>
            </div>
            
    </form>
</ul>

<h1>My Order</h1>

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
            if($o->status === "Pending" || $o->status === "Canceled"){
                $index = 0;
            }
                
            else if ($o->status === "In Transit"){
                $index = 1;
            }
            else {
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