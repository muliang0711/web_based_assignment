<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php

require '../../_base.php';
$title='View Order Details';
require  "main.php";


$scriptArray = ['/js/admin_orders.js'];    

include '../../admin_login_guard.php';

//fetch order details from database;
if(isset($_GET["id"])){
    $orderID = $_GET["id"];
    $stm = $_db->prepare("SELECT o.*, sum(oi.subtotal)-o.discount as total FROM
                                orders o JOIN order_items oi ON (o.orderId = oi.orderId)
                                JOIN user u ON (u.userID = o.userId)
                                GROUP BY o.orderId HAVING o.orderId = ?;");
    $stm->execute([$orderID]);
    $order = $stm->fetchAll();
    if(count($order)<1){

        //if no order found maybe admin hand itchy change something in the url
        //need to pinch his buttocks
        redirect("/pages/admin/admin_home.php");
    }
    $order = $order[0];

    //getting images path
    $orderItems = $_db->prepare("SELECT oi.*, p.productName as name, pi.image_path as img FROM order_items oi JOIN product p
                                    ON (oi.productId = p.productID) 
                                    JOIN product_images pi ON (p.productID = pi.productID)
                                    WHERE orderId=? AND pi.image_type = 'product' ");
    $orderItems->execute([$orderID]);
    $orderItems = $orderItems->fetchAll();

    
}
else {
    // if order id not set
    redirect("/pages/admin/admin_home.php");
}

?>

<style>
    .th{
        text-align: right;
        width: 30%;
    }


    .productDIV{
        cursor: pointer;
        display: flex;
        position: relative;

    }

    .productDIV span:hover + img{
        display: block;
    }

    img{
        border: 3px solid black;
        width: 120px;
        height: auto;
        display: none;
        position: absolute;
        right: 0;
        transform: translateY(-50%);
        background: white;

    }
</style>

<div class="main-content">

<table class="tb">
        <div class="tb-title">
                <h5 style="margin: 0;"><i class="fas fa-table"></i> Order Details </h5>
        </div>

        <thead>
            <tr>
                <th class="th order">Order ID</th>
                <td class="td"><?= $order->orderId ?></td>
            </tr>
            
            <tr>
                <th class="th cust">Customer ID</th>
                <td class="td"><?= $order->userId ?></td>
            </tr>

            <tr>
                <th class="th cust">Customer Name</th>
                <td class="td"><?= $order->orderName ?></td>
            </tr>

            <tr>
                <th class="th cust">Customer Phone</th>
                <td class="td"><?= $order->orderPhone ?></td>
            </tr>

            <tr>
                <th class="th cust">Delivery Address</th>
                <td class="td"><?= $order->orderAddress ?></td>
            </tr>

            <tr>
                <th class="th produdt">Products <p><?= count($orderItems) ?> item(s)</p></th>
                <td class="td product">
                    <div>
                        <?php foreach($orderItems as $oi): ?>
                        <div class="productDIV" style="margin-bottom: 10px; padding: 5px; width: auto;">
                            <span><?= $oi->name?> (<?= $oi->gripSize ?>) Quantity: <?= $oi->quantity ?></span>
                            <img src="/File/<?= $oi->img ?>">
                        </div>
                        <?php endforeach ?>
                    </div>
                </td>
                
            </tr>

            <tr>
                <th class="th tracking">Tracking ID</th>
                <td class="td"><?= $order->tracking ?></td>
            </tr>
            
            <tr>
                <th class="th date">Order Placed On</span></th>
                <td class="td"><?= $order->orderDate ?></td>
            </tr>

            <tr>
                <th class="th fulfil">Status</th>
                <td class="td"><?= $order->status ?></td>
            </tr>

            <tr>
                <th class="th delivered">Delivered on</th>
                <td class="td"><?= $order->deliveredDate ?></td>
            </tr>

            <tr>
                <th class="th total">Total Paid</span></th>
                <td class="td"><?= "RM ".$order->total ?></td>
            </tr>

            <tr>
                <th class="th discount">Discount Amount</th>
                <td class="td"><?= "RM ".$order->discount ?></td>
            </tr>

            

            <tr>
                <th class="th cancel">Cancellation Reason</th>
                <td class="td"><?= $order->cancel_reason ?></td>
            </tr>
        </thead>
        
        


    </table>






</div>



<?php
require '../../admin_foot.php';
?>