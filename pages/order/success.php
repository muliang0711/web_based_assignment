<?php 
    require "../../_base.php";
    $title = 'Payment Success';
    $time = time();
    $stylesheetArray  = ["success.css?"];

    if(!isset($_SESSION['tempOrder'])){
        redirect("/");
    }

    //create order in db
    $orderID = $_db->query("SELECT MAX(orderId) from orders")->fetchColumn();
    $orderID++;

    $details = $_SESSION['tempOrder'];
    $items = $details->items;

    $stm = $_db->prepare("INSERT into orders(orderId, userId, orderDate, status, orderAddress, orderName, orderPhone, deliveryMethod, discount)
                             VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stm->execute([$orderID, $details->userId, $details->orderDate, "Pending", $details->orderAddress, $details->orderName, $details->orderPhone, "Standard", $details->discount]);

    foreach($items as $i){
        $stm = $_db->prepare("INSERT into order_items(orderId, productId, quantity, subtotal, gripSize)
                             VALUES(?, ?, ?, ?, ?)");
        $stm->execute([$orderID, $i->productID, $i->quantity, $i->subtotal, $i->sizeID]);
    }
    

    //remove items from cart
    include "../../_head.php";
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
        <button onclick="gohome()">Back to Homepage</button>
    </div>
</div>
<script>
    function gohome(){
        location = "/";
    }
</script>

<?php 
include '../../_foot.php';
unset($_SESSION["tempOrder"]);
?>