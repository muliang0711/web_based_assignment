<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";
    $title = 'Checkout';
    $time = time();
    $stylesheetArray  = ["checkout.css"];

    
    include $_SERVER["DOCUMENT_ROOT"] . "/_head.php";


    
?>
<h1>Checkout</h1>
<div class="container">

    <div class="shipping-address">
        <h3>Address</h3><br>
        <div class="savedAddress"></div>
    </div>

    <div class="payment-methods">
        <h3>Payment Methods</h3>
        <div class="paymentcontainer">
            <div class="selected">Credit Card</div>
            <div>Paypal</div>
            <div>Skirll</div>
            <div class="border"></div>
        </div>

    </div>

    <div class="order-summary">
        <h3>Checkout Summary</h3><br>
    </div>

    <div class="buttons"></div>
</div>

<?php
    $scriptArray = ["checkout.js"];
    include $_SERVER["DOCUMENT_ROOT"] . "/_foot.php";

?>