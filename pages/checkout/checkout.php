<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/_base.php";
    $title = 'Checkout';
    $time = time();
    $stylesheetArray  = ["checkout.css"];

    
    include $_SERVER["DOCUMENT_ROOT"] . "/_head.php";

    //$userID


    
?>
<h1>Checkout</h1>
<div class="giant-container">
    <div class="container">

    <div class="shipping-address">
        <h3>Shipping Information</h3>
        <div class="sliderContainer">
            <button class="left"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(126, 126, 126)"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg></button>
            <div class="viewbox">
                <div class="addressSlider">
                    <div class="card">1</div>
                    <div class="card">2</div> 
                    <div class="card">3</div> 
                    <div class="card">4</div> 
                    <div class="card">
                        <button><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(39, 39, 39)"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></button>
                        <span>Add Address</span>
                    </div> 
                </div>
            </div>
            <button class="right"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="rgb(126, 126, 126)"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg></button>
        </div>
        
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

    </div>

    <div class="container2">
    <div class="order-summary">
        <h3>Checkout Summary</h3><br>
    </div>

    <div class="buttons"></div>
    </div>
</div>

    


<?php
    $scriptArray = ["checkout.js"];
    include $_SERVER["DOCUMENT_ROOT"] . "/_foot.php";

?>