<?php 
    require "../../_base.php";
    $title = 'Payment Success';
    $time = time();
    $stylesheetArray  = ["success.css?"];

    if(!isset($_SESSION['tempOrder'])){
        redirect("/");
    }

    if(isset($_GET["billplz"]["paid"]) && $_GET["billplz"]["paid"]=="false"){
        redirect("/pages/order/paymentfailed.php");
        exit;
    }

    //create order in db
    $orderID = $_db->query("SELECT MAX(orderId) from orders")->fetchColumn();
    $orderID++;

    $details = $_SESSION['tempOrder'];
    unset($_SESSION['tempOrder']);
    $items = $details->items;

    $stm = $_db->prepare("INSERT into orders(orderId, userId, orderDate, status, orderAddress, orderName, orderPhone, deliveryMethod, discount)
                             VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stm->execute([$orderID, $details->userId, $details->orderDate, "Pending", $details->orderAddress, $details->orderName, $details->orderPhone, "Standard", $details->discount]);

    
    foreach($items as $i){
        $stm = $_db->prepare("INSERT into order_items(orderId, productId, quantity, subtotal, gripSize)
                             VALUES(?, ?, ?, ?, ?)");
        $stm->execute([$orderID, $i->productID, $i->quantity, $i->subtotal, $i->sizeID]);

        //subtracting the stock from database

        $stm = $_db->prepare("UPDATE productstock set stock=stock-1 WHERE productID = ? AND sizeID = ?");
        $stm->execute([$i->productID, $i->sizeID]);
    }
    

    //remove items from cart
    $_db->query("DELETE FROM cartitem WHERE userID = $details->userId");
    include "../../_head.php";

    //increase voucher usage
    if(isset($_SESSION["vcrcode"])){
        $code = $_SESSION["vcrcode"];
        $_db->prepare("UPDATE vouchers SET totalUsage = totalUsage+1 WHERE voucherCode = ?")->execute([$code]);
        unset($_SESSION["vcrcode"]);
    }
?>

<div class="container">
    <div class="circle">
    <svg xmlns="http://www.w3.org/2000/svg" height="70px" viewBox="0 -960 960 960" width="70px" fill="rgb(255,255,255)"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
    </div>
    <h1>Thank you for your payment!</h1>


    <div class="orderdetails">
        <div>
            <span>Order ID</span>
            <span>#<?= $orderID ?></span>
        </div>
        

        <div>
            <span>Created at</span>
            <span><?= $details->orderDate ?></span>
        </div>

        <div>
            <span>Amount paid</span>
            <span>RM <?= $details->total ?></span>
        </div>

        <div>
            <span>Contact</span>
            <span><?= $details->orderPhone ?></span>
        </div>

    </div>

    <div class="buttoncontainer">
        <button onclick="location='/pages/order/orderDetails.php?id=<?= $orderID ?>'">View Order</button>
    </div>
</div>


<?php 
include '../../_foot.php';
unset($_SESSION["tempOrder"]);
?>