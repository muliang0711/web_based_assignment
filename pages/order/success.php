<?php 
    require "../../_base.php";
    $title = 'Payment Success';
    $time = time();
    $stylesheetArray  = ["success.css?"];
    include "../../_head.php";

    // if(!isset($_SESSION['tempOrder'])){
    //     redirect("/");
    // }

    //create order in db
    $orderID = $_db->query("SELECT MAX(orderId) from orders")->fetchColumn();
    $orderID++;
    $details = $_SESSION['tempOrder'];

    $stm = $_db->prepare("INSERT into orders(orderId, userId, orderDate, status, orderAddress)")

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
            <span>date 123123</span>
        </div>

        <div>
            <span>Amount paid</span>
            <span>RM 1234.00</span>
        </div>

        <div>
            <span>Contant</span>
            <span>0126289399</span>
        </div>

    </div>

    <div class="buttoncontainer">
        <button>Back to Homepage</button>
    </div>
</div>
<!--  -->

<?php 
$scriptArray = ["success.js"];
include '../../_foot.php'; 
?>